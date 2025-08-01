<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\UserExerciseAttempt;
use App\Models\UserExerciseAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserExerciseAttemptController extends Controller
{
    /**
     * Commencer un exercice.
     */
    public function start(Request $request, Exercise $exercise)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Vérifier si l'utilisateur a déjà une tentative en cours
        $existingAttempt = UserExerciseAttempt::where('user_id', $request->user_id)
            ->where('exercise_id', $exercise->id)
            ->where('status', 'started')
            ->first();

        if ($existingAttempt) {
            return response()->json([
                'success' => true,
                'message' => 'Tentative déjà en cours.',
                'data' => $existingAttempt->load(['exercise', 'user'])
            ], 200);
        }

        // Créer une nouvelle tentative
        $attempt = UserExerciseAttempt::create([
            'user_id' => $request->user_id,
            'exercise_id' => $exercise->id,
            'status' => 'started',
            'started_at' => now(),
            'max_score' => $exercise->getMaxScoreAttribute(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Exercice commencé.',
            'data' => $attempt->load(['exercise', 'user'])
        ], 201);
    }

    /**
     * Soumettre les réponses et évaluer l'exercice.
     */
    public function submit(Request $request, UserExerciseAttempt $attempt)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:exercise_questions,id',
            'answers.*.selected_answers' => 'required|array',
            'time_spent' => 'nullable|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $totalScore = 0;
            $maxScore = $attempt->max_score;

            foreach ($request->answers as $answerData) {
                $question = $attempt->exercise->questions()->find($answerData['question_id']);

                if (!$question) {
                    continue;
                }

                // Vérifier si la réponse est correcte
                $isCorrect = $question->isAnswerCorrect($answerData['selected_answers']);
                $pointsEarned = $isCorrect ? $question->points : 0;
                $totalScore += $pointsEarned;

                // Enregistrer la réponse utilisateur
                UserExerciseAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'selected_answers' => $answerData['selected_answers'],
                    'is_correct' => $isCorrect,
                    'points_earned' => $pointsEarned,
                ]);
            }

            // Mettre à jour la tentative
            $attempt->update([
                'score' => $totalScore,
                'time_spent' => $request->time_spent,
            ]);

            // Marquer comme terminée et calculer les résultats
            $attempt->markAsCompleted();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Exercice terminé.',
                'data' => [
                    'attempt' => $attempt->load(['exercise', 'user']),
                    'results' => [
                        'score' => $totalScore,
                        'max_score' => $maxScore,
                        'percentage' => $attempt->percentage,
                        'is_passed' => $attempt->is_passed,
                        'passing_score' => $attempt->exercise->passing_score,
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la soumission.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir les résultats détaillés d'une tentative.
     */
    public function results(UserExerciseAttempt $attempt)
    {
        $attempt->load(['exercise.questions.answers', 'userAnswers.question.answers']);

        $detailedResults = [];
        foreach ($attempt->userAnswers as $userAnswer) {
            $question = $userAnswer->question;
            $correctAnswers = $question->getCorrectAnswers();

            $detailedResults[] = [
                'question' => $question->question_text,
                'user_answers' => $userAnswer->selected_answers,
                'correct_answers' => $correctAnswers->pluck('id')->toArray(),
                'is_correct' => $userAnswer->is_correct,
                'points_earned' => $userAnswer->points_earned,
                'max_points' => $question->points,
                'explanation' => $correctAnswers->first()->explanation ?? null,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'attempt' => $attempt,
                'detailed_results' => $detailedResults,
                'summary' => [
                    'score' => $attempt->score,
                    'max_score' => $attempt->max_score,
                    'percentage' => $attempt->percentage,
                    'is_passed' => $attempt->is_passed,
                    'passing_score' => $attempt->exercise->passing_score,
                    'time_spent' => $attempt->time_spent,
                ]
            ]
        ], 200);
    }

    /**
     * Obtenir l'historique des tentatives d'un utilisateur.
     */
    public function userHistory($userId)
    {
        $attempts = UserExerciseAttempt::with(['exercise', 'exercise.lesson'])
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->orderBy('completed_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $attempts
        ], 200);
    }

    /**
     * Obtenir les tentatives réussies d'un utilisateur.
     */
    public function userPassedAttempts($userId)
    {
        $attempts = UserExerciseAttempt::with(['exercise', 'exercise.lesson'])
            ->where('user_id', $userId)
            ->passed()
            ->orderBy('completed_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $attempts
        ], 200);
    }

    /**
     * Obtenir les tentatives échouées d'un utilisateur.
     */
    public function userFailedAttempts($userId)
    {
        $attempts = UserExerciseAttempt::with(['exercise', 'exercise.lesson'])
            ->where('user_id', $userId)
            ->failed()
            ->orderBy('completed_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $attempts
        ], 200);
    }

    /**
     * Obtenir les statistiques d'un exercice.
     */
    public function exerciseStats(Exercise $exercise)
    {
        $totalAttempts = $exercise->attempts()->count();
        $completedAttempts = $exercise->attempts()->completed()->count();
        $passedAttempts = $exercise->attempts()->passed()->count();
        $averageScore = $exercise->attempts()->completed()->avg('percentage') ?? 0;
        $averageTime = $exercise->attempts()->completed()->avg('time_spent') ?? 0;

        return response()->json([
            'success' => true,
            'data' => [
                'exercise' => $exercise->load('lesson'),
                'stats' => [
                    'total_attempts' => $totalAttempts,
                    'completed_attempts' => $completedAttempts,
                    'passed_attempts' => $passedAttempts,
                    'pass_rate' => $completedAttempts > 0 ? round(($passedAttempts / $completedAttempts) * 100, 2) : 0,
                    'average_score' => round($averageScore, 2),
                    'average_time' => round($averageTime, 2),
                ]
            ]
        ], 200);
    }
}
