<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserProgress;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;

class UserProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $courses = Course::all();
        $lessons = Lesson::all();

        if ($users->isEmpty() || $courses->isEmpty()) {
            // Créer des données par défaut si elles n'existent pas
            $this->call([UserSeeder::class, CourseSeeder::class, LessonSeeder::class]);
            $users = User::all();
            $courses = Course::all();
            $lessons = Lesson::all();
        }

        $progressData = [
            // Progression pour le premier utilisateur
            [
                'user_id' => $users->first()->id,
                'course_id' => $courses->first()->id,
                'lesson_id' => $lessons->first()->id,
                'status' => 'in_progress',
                'progress_percentage' => 75,
                'time_spent' => 45,
                'notes' => 'HTML très intéressant, je progresse bien !',
                'is_favorite' => true,
                'last_accessed_at' => now()->subHours(2),
            ],
            [
                'user_id' => $users->first()->id,
                'course_id' => $courses->first()->id,
                'lesson_id' => $lessons->skip(1)->first()->id,
                'status' => 'not_started',
                'progress_percentage' => 0,
                'time_spent' => 0,
                'notes' => null,
                'is_favorite' => false,
                'last_accessed_at' => null,
            ],
            [
                'user_id' => $users->first()->id,
                'course_id' => $courses->skip(1)->first()->id,
                'lesson_id' => null,
                'status' => 'completed',
                'progress_percentage' => 100,
                'time_spent' => 120,
                'notes' => 'Cours React terminé avec succès !',
                'is_favorite' => true,
                'last_accessed_at' => now()->subDays(1),
                'completed_at' => now()->subDays(1),
            ],
            [
                'user_id' => $users->first()->id,
                'course_id' => $courses->skip(2)->first()->id,
                'lesson_id' => null,
                'status' => 'paused',
                'progress_percentage' => 30,
                'time_spent' => 25,
                'notes' => 'Pause temporaire, je reprendrai plus tard',
                'is_favorite' => false,
                'last_accessed_at' => now()->subDays(3),
            ],
        ];

        foreach ($progressData as $progress) {
            UserProgress::create($progress);
        }
    }
}
