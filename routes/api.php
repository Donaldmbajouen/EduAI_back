<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserProgressController;
use App\Http\Controllers\CourseSuggestionController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\UserExerciseAttemptController;
use App\Http\Controllers\CourseAssessmentController;
use App\Http\Controllers\AdminStatisticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes pour les utilisateurs
Route::apiResource('users', UserController::class);

// Routes pour les catégories
Route::apiResource('categories', CategorieController::class);

// Routes pour les cours
Route::apiResource('courses', CourseController::class);

// Routes supplémentaires pour les cours
Route::get('users/{userId}/courses', [CourseController::class, 'coursesByUser']);
Route::get('users/{userId}/courses/published', [CourseController::class, 'publishedCoursesByUser']);

// Routes pour les leçons
Route::apiResource('lessons', LessonController::class);

// Routes supplémentaires pour les leçons
Route::get('courses/{course}/lessons', [LessonController::class, 'lessonsByCourse']);
Route::get('courses/{course}/lessons/published', [LessonController::class, 'publishedLessonsByCourse']);

// Routes pour la progression des utilisateurs
Route::apiResource('user-progress', UserProgressController::class);

// Routes spécialisées pour la progression
Route::get('users/{userId}/progress', [UserProgressController::class, 'userProgress']);
Route::get('users/{userId}/progress/in-progress', [UserProgressController::class, 'userInProgressCourses']);
Route::get('users/{userId}/progress/completed', [UserProgressController::class, 'userCompletedCourses']);
Route::get('users/{userId}/progress/favorites', [UserProgressController::class, 'userFavorites']);
Route::post('users/{userId}/courses/{courseId}/lessons/{lessonId}/progress', [UserProgressController::class, 'updateLessonProgress']);
Route::post('users/{userId}/courses/{courseId}/favorite', [UserProgressController::class, 'toggleFavorite']);

// Routes pour les suggestions de cours
Route::apiResource('course-suggestions', CourseSuggestionController::class);

// Routes spécialisées pour les suggestions
Route::post('course-suggestions/{courseSuggestion}/vote', [CourseSuggestionController::class, 'vote']);
Route::get('course-suggestions/popular', [CourseSuggestionController::class, 'popular']);
Route::get('users/{userId}/suggestions', [CourseSuggestionController::class, 'userSuggestions']);
Route::get('course-suggestions/status/{status}', [CourseSuggestionController::class, 'byStatus']);

// Routes pour les exercices
Route::apiResource('exercises', ExerciseController::class);

// Routes spécialisées pour les exercices
Route::get('lessons/{lesson}/exercises', [ExerciseController::class, 'exercisesByLesson']);
Route::get('exercises/difficulty/{difficulty}', [ExerciseController::class, 'byDifficulty']);
Route::get('exercises/type/{type}', [ExerciseController::class, 'byType']);

// Routes pour les tentatives d'exercices
Route::post('exercises/{exercise}/start', [UserExerciseAttemptController::class, 'start']);
Route::post('exercise-attempts/{attempt}/submit', [UserExerciseAttemptController::class, 'submit']);
Route::get('exercise-attempts/{attempt}/results', [UserExerciseAttemptController::class, 'results']);
Route::get('users/{userId}/exercise-history', [UserExerciseAttemptController::class, 'userHistory']);
Route::get('users/{userId}/exercise-passed', [UserExerciseAttemptController::class, 'userPassedAttempts']);
Route::get('users/{userId}/exercise-failed', [UserExerciseAttemptController::class, 'userFailedAttempts']);
Route::get('exercises/{exercise}/stats', [UserExerciseAttemptController::class, 'exerciseStats']);

// Routes pour les tests d'évaluation de niveau
Route::post('courses/{course}/assessment/start', [CourseAssessmentController::class, 'startAssessment']);
Route::post('courses/{course}/assessment/submit', [CourseAssessmentController::class, 'submitAssessment']);
Route::get('courses/{course}/assessment/recommendations', [CourseAssessmentController::class, 'getRecommendations']);
Route::get('courses/{course}/assessment/status', [CourseAssessmentController::class, 'getAssessmentStatus']);

// Route pour les statistiques admin générales
Route::get('admin/statistics', [AdminStatisticsController::class, 'getGeneralStats']);

