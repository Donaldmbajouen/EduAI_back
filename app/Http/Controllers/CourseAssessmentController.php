<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\CourseLevelAssessmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CourseAssessmentController extends Controller
{
    protected $assessmentService;

    public function __construct(CourseLevelAssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

    /**
     * Commencer un test d'évaluation pour un cours
     */
    public function startAssessment(Request $request, Course $course)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            // Générer le test d'évaluation
            $assessment = $this->assessmentService->generateAssessment($course->id, $request->user_id);

            // Stocker temporairement en cache (pas en BD)
            $cacheKey = "assessment_{$assessment['assessment_id']}";
            Cache::put($cacheKey, $assessment, now()->addMinutes(30));

            return response()->json([
                'success' => true,
                'message' => 'Test d\'évaluation généré avec succès.',
                'data' => [
                    'assessment_id' => $assessment['assessment_id'],
                    'course_title' => $assessment['course_title'],
                    'category' => $assessment['category'],
                    'total_questions' => $assessment['total_questions'],
                    'expires_at' => $assessment['expires_at'],
                    'questions' => $assessment['questions'],
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération du test.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soumettre les réponses et obtenir l'évaluation
     */
    public function submitAssessment(Request $request, Course $course)
    {
        $request->validate([
            'assessment_id' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        try {
            // Récupérer le test depuis le cache
            $cacheKey = "assessment_{$request->assessment_id}";
            $assessment = Cache::get($cacheKey);

            if (!$assessment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Test d\'évaluation expiré ou non trouvé.'
                ], 404);
            }

            // Vérifier que l'utilisateur correspond
            if ($assessment['user_id'] != $request->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Accès non autorisé à ce test.'
                ], 403);
            }

            // Évaluer le niveau
            $evaluation = $this->assessmentService->evaluateLevel($request->assessment_id, $request->answers);

            // Stocker le résultat temporairement
            $resultCacheKey = "assessment_result_{$request->assessment_id}";
            Cache::put($resultCacheKey, $evaluation, now()->addHours(24));

            // Supprimer le test du cache
            Cache::forget($cacheKey);

            return response()->json([
                'success' => true,
                'message' => 'Évaluation terminée avec succès.',
                'data' => $evaluation
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'évaluation.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir les recommandations personnalisées
     */
    public function getRecommendations(Request $request, Course $course)
    {
        $request->validate([
            'assessment_id' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            // Récupérer le résultat depuis le cache
            $resultCacheKey = "assessment_result_{$request->assessment_id}";
            $evaluation = Cache::get($resultCacheKey);

            if (!$evaluation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Résultat d\'évaluation non trouvé ou expiré.'
                ], 404);
            }

            // Vérifier que l'utilisateur correspond
            if ($evaluation['assessment_id'] != $request->assessment_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Accès non autorisé à ce résultat.'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'course' => [
                        'id' => $course->id,
                        'title' => $course->title,
                        'description' => $course->description,
                    ],
                    'evaluation' => $evaluation,
                    'personalized_path' => $this->generatePersonalizedPath($course, $evaluation),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des recommandations.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir le statut d'un test d'évaluation
     */
    public function getAssessmentStatus(Request $request, Course $course)
    {
        $request->validate([
            'assessment_id' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            // Vérifier si le test existe
            $cacheKey = "assessment_{$request->assessment_id}";
            $assessment = Cache::get($cacheKey);

            if ($assessment) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'status' => 'in_progress',
                        'expires_at' => $assessment['expires_at'],
                        'total_questions' => $assessment['total_questions'],
                    ]
                ], 200);
            }

            // Vérifier si le résultat existe
            $resultCacheKey = "assessment_result_{$request->assessment_id}";
            $result = Cache::get($resultCacheKey);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'status' => 'completed',
                        'level' => $result['level'],
                        'score_percentage' => $result['score_percentage'],
                        'evaluated_at' => $result['evaluated_at'],
                    ]
                ], 200);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'status' => 'not_started',
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la vérification du statut.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Générer un parcours personnalisé basé sur l'évaluation
     * TODO: Améliorer avec l'IA pour des recommandations plus précises
     */
    private function generatePersonalizedPath($course, $evaluation)
    {
        $level = $evaluation['level'];
        $lessons = $course->lessons()->ordered()->get();

        $personalizedPath = [
            'course_id' => $course->id,
            'user_level' => $level,
            'recommended_lessons' => [],
            'skip_lessons' => [],
            'focus_areas' => [],
            'estimated_completion_time' => '',
        ];

        switch ($level) {
            case 'beginner':
                $personalizedPath['recommended_lessons'] = $lessons->take(5)->pluck('id')->toArray();
                $personalizedPath['skip_lessons'] = $lessons->slice(7)->pluck('id')->toArray();
                $personalizedPath['focus_areas'] = ['Concepts de base', 'Pratique régulière'];
                $personalizedPath['estimated_completion_time'] = '4-6 heures';
                break;

            case 'intermediate':
                $personalizedPath['recommended_lessons'] = $lessons->slice(2, 5)->pluck('id')->toArray();
                $personalizedPath['skip_lessons'] = $lessons->take(2)->pluck('id')->toArray();
                $personalizedPath['focus_areas'] = ['Concepts avancés', 'Bonnes pratiques'];
                $personalizedPath['estimated_completion_time'] = '3-4 heures';
                break;

            case 'advanced':
                $personalizedPath['recommended_lessons'] = $lessons->slice(4)->pluck('id')->toArray();
                $personalizedPath['skip_lessons'] = $lessons->take(4)->pluck('id')->toArray();
                $personalizedPath['focus_areas'] = ['Optimisations', 'Architecture avancée'];
                $personalizedPath['estimated_completion_time'] = '2-3 heures';
                break;
        }

        return $personalizedPath;
    }
}
