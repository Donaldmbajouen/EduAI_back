<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseSuggestion;
use App\Models\User;
use App\Models\Categorie;

class CourseSuggestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Categorie::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            // Créer des données par défaut si elles n'existent pas
            $this->call([UserSeeder::class, CategorieSeeder::class]);
            $users = User::all();
            $categories = Categorie::all();
        }

        $suggestions = [
            [
                'user_id' => $users->first()->id,
                'title' => 'Développement avec Vue.js 3',
                'description' => 'Apprenez Vue.js 3 avec la Composition API, les nouveaux concepts et les meilleures pratiques.',
                'level' => 'intermediate',
                'category_id' => $categories->where('name', 'Développement Web')->first()->id ?? $categories->first()->id,
                'justification' => 'Vue.js 3 est très populaire et il manque un cours complet sur cette version.',
                'status' => 'pending',
                'votes_count' => 15,
            ],
            [
                'user_id' => $users->first()->id,
                'title' => 'Machine Learning pour Débutants',
                'description' => 'Introduction au machine learning avec Python, scikit-learn et TensorFlow.',
                'level' => 'beginner',
                'category_id' => $categories->where('name', 'Intelligence Artificielle')->first()->id ?? $categories->first()->id,
                'justification' => 'L\'IA est un domaine en pleine expansion, il faut des cours accessibles.',
                'status' => 'approved',
                'votes_count' => 28,
                'approved_at' => now()->subDays(5),
            ],
            [
                'user_id' => $users->first()->id,
                'title' => 'DevOps avec Docker et Kubernetes',
                'description' => 'Maîtrisez Docker, Kubernetes et les pratiques DevOps modernes.',
                'level' => 'advanced',
                'category_id' => $categories->where('name', 'DevOps')->first()->id ?? $categories->first()->id,
                'justification' => 'Les compétences DevOps sont très recherchées sur le marché.',
                'status' => 'pending',
                'votes_count' => 42,
            ],
            [
                'user_id' => $users->first()->id,
                'title' => 'Design System avec Figma',
                'description' => 'Créer et maintenir un design system professionnel avec Figma.',
                'level' => 'intermediate',
                'category_id' => $categories->where('name', 'Design UI/UX')->first()->id ?? $categories->first()->id,
                'justification' => 'Les design systems sont essentiels pour les grandes entreprises.',
                'status' => 'implemented',
                'votes_count' => 35,
                'approved_at' => now()->subDays(10),
                'implemented_at' => now()->subDays(2),
            ],
            [
                'user_id' => $users->first()->id,
                'title' => 'Cybersécurité pour Développeurs',
                'description' => 'Apprenez à sécuriser vos applications web et mobiles.',
                'level' => 'intermediate',
                'category_id' => $categories->where('name', 'Cybersécurité')->first()->id ?? $categories->first()->id,
                'justification' => 'La sécurité est cruciale, tous les développeurs doivent la maîtriser.',
                'status' => 'rejected',
                'votes_count' => 8,
                'admin_notes' => 'Cours déjà en préparation par un autre instructeur.',
            ],
        ];

        foreach ($suggestions as $suggestion) {
            CourseSuggestion::create($suggestion);
        }
    }
}
