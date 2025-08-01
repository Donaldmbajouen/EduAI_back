<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Afficher la liste des leçons.
     */
    public function index()
    {
        $lessons = Lesson::with('course')->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => $lessons
        ], 200);
    }

    /**
     * Créer une nouvelle leçon.
     */
    public function store(LessonRequest $request)
    {
        $lesson = Lesson::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Leçon créée avec succès.',
            'data' => $lesson->load('course')
        ], 201);
    }

    /**
     * Afficher une leçon spécifique.
     */
    public function show(Lesson $lesson)
    {
        return response()->json([
            'success' => true,
            'data' => $lesson->load('course')
        ], 200);
    }

    /**
     * Mettre à jour une leçon.
     */
    public function update(LessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Leçon mise à jour avec succès.',
            'data' => $lesson->load('course')
        ], 200);
    }

        /**
     * Supprimer une leçon.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return response()->json([
            'success' => true,
            'message' => 'Leçon supprimée avec succès.'
        ], 200);
    }

    /**
     * Afficher les leçons d'un cours spécifique.
     */
    public function lessonsByCourse(Course $course)
    {
        $lessons = $course->lessons()->with('course')->get();

        return response()->json([
            'success' => true,
            'data' => $lessons
        ], 200);
    }

    /**
     * Afficher les leçons publiées d'un cours.
     */
    public function publishedLessonsByCourse(Course $course)
    {
        $lessons = $course->lessons()->published()->with('course')->get();

        return response()->json([
            'success' => true,
            'data' => $lessons
        ], 200);
    }
}
