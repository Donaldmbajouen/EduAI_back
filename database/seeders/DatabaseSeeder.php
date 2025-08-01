<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            CategorieSeeder::class,
            CourseSeeder::class,
            LessonSeeder::class,
            UserProgressSeeder::class,
            CourseSuggestionSeeder::class,
            ExerciseSeeder::class,
        ]);
    }
}
