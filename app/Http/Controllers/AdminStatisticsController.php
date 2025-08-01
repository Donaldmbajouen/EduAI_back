<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Exercise;
use App\Models\CourseSuggestion;
use App\Models\UserProgress;
use App\Models\UserExerciseAttempt;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminStatisticsController extends Controller
{
    /**
     * Statistiques générales importantes pour l'évaluation de l'application
     */
    public function getGeneralStats()
    {
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();
        $lastWeek = $now->copy()->subWeek();

        return response()->json([
            'success' => true,
            'data' => [
                // Vue d'ensemble de la plateforme
                'platform_overview' => [
                    'total_users' => User::count(),
                    'active_users' => User::where('active', true)->count(),
                    'total_courses' => Course::count(),
                    'published_courses' => Course::where('is_published', true)->count(),
                    'total_lessons' => Lesson::count(),
                    'total_exercises' => Exercise::count(),
                    'total_categories' => Categorie::count(),
                ],

                // Croissance et activité récente
                'growth_metrics' => [
                    'new_users_this_month' => User::where('created_at', '>=', $lastMonth)->count(),
                    'new_users_this_week' => User::where('created_at', '>=', $lastWeek)->count(),
                    'new_courses_this_month' => Course::where('created_at', '>=', $lastMonth)->count(),
                    'new_lessons_this_month' => Lesson::where('created_at', '>=', $lastMonth)->count(),
                ],

                // Engagement des utilisateurs
                'user_engagement' => [
                    'users_with_progress' => UserProgress::distinct('user_id')->count(),
                    'total_progress_records' => UserProgress::count(),
                    'completed_courses' => UserProgress::where('status', 'completed')->count(),
                    'total_exercise_attempts' => UserExerciseAttempt::count(),
                    'completed_exercises' => UserExerciseAttempt::where('status', 'completed')->count(),
                    'average_course_completion_rate' => $this->calculateCompletionRate(),
                ],

                // Performance des cours
                'course_performance' => [
                    'total_course_views' => Course::sum('views_count'),
                    'average_course_rating' => Course::avg('rating'),
                    'most_viewed_courses' => $this->getMostViewedCourses(),
                    'highest_rated_courses' => $this->getHighestRatedCourses(),
                ],

                // Performance des exercices
                'exercise_performance' => [
                    'average_success_rate' => $this->calculateAverageSuccessRate(),
                    'total_exercise_attempts' => UserExerciseAttempt::count(),
                    'successful_attempts' => UserExerciseAttempt::where('is_passed', true)->count(),
                    'most_attempted_exercises' => $this->getMostAttemptedExercises(),
                ],

                // Suggestions et feedback
                'suggestions_metrics' => [
                    'total_suggestions' => CourseSuggestion::count(),
                    'pending_suggestions' => CourseSuggestion::where('status', 'pending')->count(),
                    'approved_suggestions' => CourseSuggestion::where('status', 'approved')->count(),
                    'implemented_suggestions' => CourseSuggestion::where('status', 'implemented')->count(),
                ],

                // Utilisateurs les plus actifs
                'top_active_users' => $this->getMostActiveUsers(),

                // Cours les plus populaires
                'top_courses' => $this->getTopCourses(),

                // Tendances récentes
                'recent_trends' => [
                    'user_registration_trend' => $this->getUserRegistrationTrend(),
                    'course_creation_trend' => $this->getCourseCreationTrend(),
                    'exercise_attempt_trend' => $this->getExerciseAttemptTrend(),
                ]
            ]
        ]);
    }

    // Méthodes utilitaires privées

    private function calculateCompletionRate()
    {
        $totalEnrollments = UserProgress::count();
        $completedEnrollments = UserProgress::where('status', 'completed')->count();

        return $totalEnrollments > 0 ? round(($completedEnrollments / $totalEnrollments) * 100, 2) : 0;
    }

    private function calculateAverageSuccessRate()
    {
        $totalAttempts = UserExerciseAttempt::where('status', 'completed')->count();
        $successfulAttempts = UserExerciseAttempt::where('status', 'completed')
            ->where('is_passed', true)
            ->count();

        return $totalAttempts > 0 ? round(($successfulAttempts / $totalAttempts) * 100, 2) : 0;
    }

    private function getMostActiveUsers()
    {
        return User::withCount(['progress', 'exerciseAttempts'])
            ->orderBy('progress_count', 'desc')
            ->orderBy('exercise_attempts_count', 'desc')
            ->limit(5)
            ->get(['id', 'name', 'email', 'progress_count', 'exercise_attempts_count']);
    }

    private function getMostViewedCourses()
    {
        return Course::orderBy('views_count', 'desc')
            ->limit(5)
            ->get(['id', 'title', 'views_count', 'rating']);
    }

    private function getHighestRatedCourses()
    {
        return Course::where('rating', '>', 0)
            ->orderBy('rating', 'desc')
            ->limit(5)
            ->get(['id', 'title', 'rating', 'views_count']);
    }

    private function getMostAttemptedExercises()
    {
        return Exercise::withCount('attempts')
            ->orderBy('attempts_count', 'desc')
            ->limit(5)
            ->get(['id', 'title', 'attempts_count']);
    }

    private function getTopCourses()
    {
        return Course::withCount(['userProgress as enrollments', 'userProgress as completions' => function($query) {
            $query->where('status', 'completed');
        }])
        ->orderBy('enrollments', 'desc')
        ->limit(5)
        ->get(['id', 'title', 'enrollments', 'completions', 'rating', 'views_count']);
    }

    private function getUserRegistrationTrend()
    {
        return User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getCourseCreationTrend()
    {
        return Course::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getExerciseAttemptTrend()
    {
        return UserExerciseAttempt::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
