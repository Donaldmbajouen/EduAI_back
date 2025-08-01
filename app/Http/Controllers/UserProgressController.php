<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProgressRequest;
use App\Models\UserProgress;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class UserProgressController extends Controller
{
    /**
     * Afficher la progression d'un utilisateur.
     */
    public function index()
    {
        $progress = UserProgress::with(['user', 'course', 'lesson'])->get();

        return response()->json([
            'success' => true,
            'data' => $progress
        ], 200);
    }

    /**
     * Créer ou mettre à jour la progression d'un utilisateur.
     */
    public function store(UserProgressRequest $request)
    {
        $data = $request->validated();

        // Chercher une progression existante ou en créer une nouvelle
        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'course_id' => $data['course_id'],
                'lesson_id' => $data['lesson_id'] ?? null,
            ],
            $data
        );

        return response()->json([
            'success' => true,
            'message' => 'Progression mise à jour avec succès.',
            'data' => $progress->load(['user', 'course', 'lesson'])
        ], 201);
    }

    /**
     * Afficher la progression spécifique d'un utilisateur.
     */
    public function show(UserProgress $userProgress)
    {
        return response()->json([
            'success' => true,
            'data' => $userProgress->load(['user', 'course', 'lesson'])
        ], 200);
    }

    /**
     * Mettre à jour la progression d'un utilisateur.
     */
    public function update(UserProgressRequest $request, UserProgress $userProgress)
    {
        $userProgress->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Progression mise à jour avec succès.',
            'data' => $userProgress->load(['user', 'course', 'lesson'])
        ], 200);
    }

    /**
     * Supprimer la progression d'un utilisateur.
     */
    public function destroy(UserProgress $userProgress)
    {
        $userProgress->delete();

        return response()->json([
            'success' => true,
            'message' => 'Progression supprimée avec succès.'
        ], 200);
    }

    /**
     * Obtenir la progression d'un utilisateur spécifique.
     */
    public function userProgress($userId)
    {
        $progress = UserProgress::with(['course', 'lesson'])
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $progress
        ], 200);
    }

    /**
     * Obtenir les cours en cours d'un utilisateur.
     */
    public function userInProgressCourses($userId)
    {
        $progress = UserProgress::with(['course', 'lesson'])
            ->where('user_id', $userId)
            ->inProgress()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $progress
        ], 200);
    }

    /**
     * Obtenir les cours terminés d'un utilisateur.
     */
    public function userCompletedCourses($userId)
    {
        $progress = UserProgress::with(['course', 'lesson'])
            ->where('user_id', $userId)
            ->completed()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $progress
        ], 200);
    }

    /**
     * Obtenir les favoris d'un utilisateur.
     */
    public function userFavorites($userId)
    {
        $progress = UserProgress::with(['course', 'lesson'])
            ->where('user_id', $userId)
            ->favorites()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $progress
        ], 200);
    }

    /**
     * Mettre à jour la progression d'une leçon.
     */
    public function updateLessonProgress(Request $request, $userId, $courseId, $lessonId)
    {
        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'time_spent' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'course_id' => $courseId,
                'lesson_id' => $lessonId,
            ],
            [
                'progress_percentage' => $request->progress_percentage,
                'time_spent' => $request->time_spent ?? 0,
                'notes' => $request->notes,
                'last_accessed_at' => now(),
            ]
        );

        // Mettre à jour le statut automatiquement
        $progress->updateProgress($request->progress_percentage, $request->time_spent);

        return response()->json([
            'success' => true,
            'message' => 'Progression de la leçon mise à jour.',
            'data' => $progress->load(['course', 'lesson'])
        ], 200);
    }

    /**
     * Marquer un cours comme favori.
     */
    public function toggleFavorite(Request $request, $userId, $courseId)
    {
        $request->validate([
            'is_favorite' => 'required|boolean',
        ]);

        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'course_id' => $courseId,
            ],
            [
                'is_favorite' => $request->is_favorite,
                'last_accessed_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => $request->is_favorite ? 'Cours ajouté aux favoris.' : 'Cours retiré des favoris.',
            'data' => $progress->load(['course'])
        ], 200);
    }
}
