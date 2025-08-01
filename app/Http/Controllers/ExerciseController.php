<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseRequest;
use App\Models\Exercise;
use App\Models\ExerciseQuestion;
use App\Models\ExerciseAnswer;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    /**
     * Afficher tous les exercices.
     */
    public function index()
    {
        $exercises = Exercise::with(['lesson', 'questions.answers'])
            ->active()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $exercises
        ], 200);
    }

    /**
     * Créer un nouvel exercice avec questions et réponses.
     */
    public function store(ExerciseRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $questions = $data['questions'];
            unset($data['questions']);

            // Créer l'exercice
            $exercise = Exercise::create($data);

            // Créer les questions et réponses
            foreach ($questions as $questionData) {
                $answers = $questionData['answers'];
                unset($questionData['answers']);

                $question = $exercise->questions()->create($questionData);

                foreach ($answers as $answerData) {
                    $question->answers()->create($answerData);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Exercice créé avec succès.',
                'data' => $exercise->load(['lesson', 'questions.answers'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'exercice.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher un exercice spécifique.
     */
    public function show(Exercise $exercise)
    {
        return response()->json([
            'success' => true,
            'data' => $exercise->load(['lesson', 'questions.answers'])
        ], 200);
    }

    /**
     * Mettre à jour un exercice.
     */
    public function update(ExerciseRequest $request, Exercise $exercise)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $questions = $data['questions'] ?? [];
            unset($data['questions']);

            // Mettre à jour l'exercice
            $exercise->update($data);

            // Supprimer les anciennes questions et réponses
            $exercise->questions()->delete();

            // Créer les nouvelles questions et réponses
            foreach ($questions as $questionData) {
                $answers = $questionData['answers'];
                unset($questionData['answers']);

                $question = $exercise->questions()->create($questionData);

                foreach ($answers as $answerData) {
                    $question->answers()->create($answerData);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Exercice mis à jour avec succès.',
                'data' => $exercise->load(['lesson', 'questions.answers'])
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de l\'exercice.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un exercice.
     */
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return response()->json([
            'success' => true,
            'message' => 'Exercice supprimé avec succès.'
        ], 200);
    }

    /**
     * Obtenir les exercices d'une leçon.
     */
    public function exercisesByLesson(Lesson $lesson)
    {
        $exercises = $lesson->exercises()
            ->with(['questions.answers'])
            ->active()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $exercises
        ], 200);
    }

    /**
     * Obtenir les exercices par niveau de difficulté.
     */
    public function byDifficulty($difficulty)
    {
        $exercises = Exercise::with(['lesson', 'questions.answers'])
            ->byDifficulty($difficulty)
            ->active()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $exercises
        ], 200);
    }

    /**
     * Obtenir les exercices par type.
     */
    public function byType($type)
    {
        $exercises = Exercise::with(['lesson', 'questions.answers'])
            ->where('type', $type)
            ->active()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $exercises
        ], 200);
    }
}
