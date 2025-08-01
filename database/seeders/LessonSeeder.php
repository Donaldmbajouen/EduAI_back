<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Course;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        if ($courses->isEmpty()) {
            // Créer des cours par défaut si ils n'existent pas
            $this->call(CourseSeeder::class);
            $courses = Course::all();
        }

        $lessons = [
            // Leçons pour le cours "Introduction au Développement Web"
            [
                'course_id' => $courses->where('title', 'Introduction au Développement Web')->first()->id ?? $courses->first()->id,
                'title' => 'Introduction au HTML',
                'content' => '<h2>Qu\'est-ce que le HTML ?</h2><p>Le HTML (HyperText Markup Language) est le langage de balisage standard utilisé pour créer des pages web. Il définit la structure et le contenu d\'une page web.</p><h3>Les éléments de base :</h3><ul><li>&lt;html&gt; - L\'élément racine</li><li>&lt;head&gt; - Les métadonnées</li><li>&lt;body&gt; - Le contenu visible</li></ul>',
                'video_url' => 'https://www.youtube.com/watch?v=example1',
                'order' => 1,
                'difficulty_level' => 'easy',
                'objectives' => 'Comprendre les bases du HTML, créer une première page web simple, maîtriser les éléments de base.',
                'prerequisites' => 'Aucun prérequis nécessaire.',
                'status' => 'published',
            ],
            [
                'course_id' => $courses->where('title', 'Introduction au Développement Web')->first()->id ?? $courses->first()->id,
                'title' => 'Les bases du CSS',
                'content' => '<h2>Introduction au CSS</h2><p>Le CSS (Cascading Style Sheets) est utilisé pour styliser et mettre en forme les pages HTML.</p><h3>Concepts clés :</h3><ul><li>Sélecteurs CSS</li><li>Propriétés et valeurs</li><li>Le modèle de boîte</li><li>Flexbox et Grid</li></ul>',
                'video_url' => 'https://www.youtube.com/watch?v=example2',
                'order' => 2,
                'difficulty_level' => 'easy',
                'objectives' => 'Maîtriser les sélecteurs CSS, comprendre le modèle de boîte, créer des mises en page simples.',
                'prerequisites' => 'Connaissance de base en HTML.',
                'status' => 'published',
            ],
            [
                'course_id' => $courses->where('title', 'Introduction au Développement Web')->first()->id ?? $courses->first()->id,
                'title' => 'JavaScript pour débutants',
                'content' => '<h2>Introduction à JavaScript</h2><p>JavaScript est un langage de programmation qui permet d\'ajouter de l\'interactivité aux pages web.</p><h3>Fonctionnalités de base :</h3><ul><li>Variables et types de données</li><li>Fonctions</li><li>Conditions et boucles</li><li>Manipulation du DOM</li></ul>',
                'video_url' => 'https://www.youtube.com/watch?v=example3',
                'order' => 3,
                'difficulty_level' => 'medium',
                'objectives' => 'Comprendre les variables et types, créer des fonctions simples, manipuler le DOM.',
                'prerequisites' => 'Connaissance de base en HTML et CSS.',
                'status' => 'published',
            ],

            // Leçons pour le cours "React.js Avancé"
            [
                'course_id' => $courses->where('title', 'React.js Avancé')->first()->id ?? $courses->first()->id,
                'title' => 'Les Hooks React',
                'content' => '<h2>Les Hooks React</h2><p>Les Hooks sont des fonctions qui permettent d\'utiliser l\'état et d\'autres fonctionnalités React dans les composants fonctionnels.</p><h3>Hooks principaux :</h3><ul><li>useState - Gestion de l\'état</li><li>useEffect - Effets de bord</li><li>useContext - Contexte global</li><li>useReducer - État complexe</li></ul>',
                'video_url' => 'https://www.youtube.com/watch?v=example4',
                'order' => 1,
                'difficulty_level' => 'medium',
                'objectives' => 'Maîtriser useState et useEffect, comprendre le cycle de vie des composants, créer des hooks personnalisés.',
                'prerequisites' => 'Connaissance de base en React et JavaScript.',
                'status' => 'published',
            ],
            [
                'course_id' => $courses->where('title', 'React.js Avancé')->first()->id ?? $courses->first()->id,
                'title' => 'Performance et optimisation',
                'content' => '<h2>Optimisation des performances React</h2><p>Apprenez à optimiser vos applications React pour de meilleures performances.</p><h3>Techniques d\'optimisation :</h3><ul><li>React.memo pour la mémorisation</li><li>useMemo et useCallback</li><li>Code splitting</li><li>Lazy loading</li></ul>',
                'video_url' => 'https://www.youtube.com/watch?v=example5',
                'order' => 2,
                'difficulty_level' => 'hard',
                'objectives' => 'Optimiser les performances, réduire les re-renders, implémenter le code splitting.',
                'prerequisites' => 'Maîtrise des Hooks React et des concepts de base.',
                'status' => 'published',
            ],

            // Leçons pour le cours "Développement Mobile avec Flutter"
            [
                'course_id' => $courses->where('title', 'Développement Mobile avec Flutter')->first()->id ?? $courses->first()->id,
                'title' => 'Introduction à Flutter et Dart',
                'content' => '<h2>Flutter et Dart</h2><p>Flutter est un framework de développement mobile créé par Google. Dart est le langage de programmation utilisé.</p><h3>Concepts fondamentaux :</h3><ul><li>Widgets et arbre de widgets</li><li>Stateless et Stateful widgets</li><li>Gestion de l\'état</li><li>Navigation</li></ul>',
                'video_url' => 'https://www.youtube.com/watch?v=example6',
                'order' => 1,
                'difficulty_level' => 'medium',
                'objectives' => 'Comprendre l\'architecture Flutter, créer des widgets simples, maîtriser la navigation.',
                'prerequisites' => 'Connaissance de base en programmation orientée objet.',
                'status' => 'published',
            ],
        ];

        foreach ($lessons as $lesson) {
            Lesson::create($lesson);
        }
    }
}
