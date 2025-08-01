<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Categorie;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Categorie::all();

        if ($categories->isEmpty()) {
            // Créer des catégories par défaut si elles n'existent pas
            $this->call(CategorieSeeder::class);
            $categories = Categorie::all();
        }

        $courses = [
            [
                'title' => 'Introduction au Développement Web',
                'description' => 'Apprenez les bases du développement web avec HTML, CSS et JavaScript.',
                'level' => 'beginner',
                'is_published' => true,
                'rating' => 4.5,
                'views_count' => 150,
                'category_id' => $categories->where('name', 'Développement Web')->first()->id ?? $categories->first()->id,
                'user_id' => 1, // Premier utilisateur
            ],
            [
                'title' => 'React.js Avancé',
                'description' => 'Maîtrisez React.js avec les hooks, le contexte et les performances.',
                'level' => 'intermediate',
                'is_published' => true,
                'rating' => 4.8,
                'views_count' => 89,
                'category_id' => $categories->where('name', 'Développement Web')->first()->id ?? $categories->first()->id,
                'user_id' => 1, // Premier utilisateur
            ],
            [
                'title' => 'Développement Mobile avec Flutter',
                'description' => 'Créez des applications mobiles cross-platform avec Flutter et Dart.',
                'level' => 'intermediate',
                'is_published' => true,
                'rating' => 4.2,
                'views_count' => 67,
                'category_id' => $categories->where('name', 'Développement Mobile')->first()->id ?? $categories->first()->id,
                'user_id' => 1, // Premier utilisateur
            ],
            [
                'title' => 'Design UI/UX pour Débutants',
                'description' => 'Découvrez les principes du design d\'interface utilisateur.',
                'level' => 'beginner',
                'is_published' => true,
                'rating' => 4.0,
                'views_count' => 234,
                'category_id' => $categories->where('name', 'Design UI/UX')->first()->id ?? $categories->first()->id,
                'user_id' => 1, // Premier utilisateur
            ],
            [
                'title' => 'Marketing Digital Avancé',
                'description' => 'Stratégies avancées de marketing digital et d\'acquisition.',
                'level' => 'advanced',
                'is_published' => false,
                'rating' => 0.0,
                'views_count' => 0,
                'category_id' => $categories->where('name', 'Marketing Digital')->first()->id ?? $categories->first()->id,
                'user_id' => 1, // Premier utilisateur
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
