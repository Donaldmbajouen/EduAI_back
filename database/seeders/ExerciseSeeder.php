<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exercise;
use App\Models\ExerciseQuestion;
use App\Models\ExerciseAnswer;
use App\Models\Lesson;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessons = Lesson::all();

        if ($lessons->isEmpty()) {
            // Créer des données par défaut si elles n'existent pas
            $this->call([LessonSeeder::class]);
            $lessons = Lesson::all();
        }

        $exercises = [
            [
                'lesson_id' => $lessons->first()->id,
                'title' => 'Quiz sur les bases de Laravel',
                'description' => 'Testez vos connaissances sur les fondamentaux de Laravel.',
                'type' => 'quiz_single',
                'difficulty_level' => 'easy',
                'points' => 0,
                'time_limit' => 15,
                'is_active' => true,
                'order' => 1,
                'passing_score' => 70,
                'questions' => [
                    [
                        'question_text' => 'Qu\'est-ce que Laravel ?',
                        'question_type' => 'text',
                        'points' => 2,
                        'order' => 1,
                        'answers' => [
                            [
                                'answer_text' => 'Un framework PHP',
                                'is_correct' => true,
                                'explanation' => 'Laravel est un framework PHP moderne et élégant.',
                                'order' => 1,
                            ],
                            [
                                'answer_text' => 'Un langage de programmation',
                                'is_correct' => false,
                                'explanation' => 'Laravel est un framework, pas un langage.',
                                'order' => 2,
                            ],
                            [
                                'answer_text' => 'Une base de données',
                                'is_correct' => false,
                                'explanation' => 'Laravel est un framework, pas une base de données.',
                                'order' => 3,
                            ],
                        ],
                    ],
                    [
                        'question_text' => 'Quelle commande permet de créer un nouveau projet Laravel ?',
                        'question_type' => 'text',
                        'points' => 3,
                        'order' => 2,
                        'answers' => [
                            [
                                'answer_text' => 'composer create-project laravel/laravel nom-du-projet',
                                'is_correct' => true,
                                'explanation' => 'Cette commande Composer crée un nouveau projet Laravel.',
                                'order' => 1,
                            ],
                            [
                                'answer_text' => 'laravel new nom-du-projet',
                                'is_correct' => false,
                                'explanation' => 'Cette commande n\'existe pas.',
                                'order' => 2,
                            ],
                            [
                                'answer_text' => 'php artisan new nom-du-projet',
                                'is_correct' => false,
                                'explanation' => 'php artisan est utilisé après la création du projet.',
                                'order' => 3,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'lesson_id' => $lessons->first()->id,
                'title' => 'Quiz avancé sur les migrations',
                'description' => 'Testez vos connaissances sur les migrations Laravel.',
                'type' => 'quiz_multiple',
                'difficulty_level' => 'medium',
                'points' => 0,
                'time_limit' => 20,
                'is_active' => true,
                'order' => 2,
                'passing_score' => 75,
                'questions' => [
                    [
                        'question_text' => 'Quelles sont les méthodes utilisées dans les migrations ?',
                        'question_type' => 'text',
                        'points' => 4,
                        'order' => 1,
                        'answers' => [
                            [
                                'answer_text' => 'up()',
                                'is_correct' => true,
                                'explanation' => 'La méthode up() est exécutée lors de la migration.',
                                'order' => 1,
                            ],
                            [
                                'answer_text' => 'down()',
                                'is_correct' => true,
                                'explanation' => 'La méthode down() est exécutée lors du rollback.',
                                'order' => 2,
                            ],
                            [
                                'answer_text' => 'create()',
                                'is_correct' => false,
                                'explanation' => 'create() n\'est pas une méthode de migration.',
                                'order' => 3,
                            ],
                            [
                                'answer_text' => 'migrate()',
                                'is_correct' => false,
                                'explanation' => 'migrate() est une commande artisan, pas une méthode de migration.',
                                'order' => 4,
                            ],
                        ],
                    ],
                    [
                        'question_text' => 'Quelles colonnes peuvent être créées avec les migrations ?',
                        'question_type' => 'text',
                        'points' => 3,
                        'order' => 2,
                        'answers' => [
                            [
                                'answer_text' => 'string',
                                'is_correct' => true,
                                'explanation' => 'string() crée une colonne VARCHAR.',
                                'order' => 1,
                            ],
                            [
                                'answer_text' => 'integer',
                                'is_correct' => true,
                                'explanation' => 'integer() crée une colonne INT.',
                                'order' => 2,
                            ],
                            [
                                'answer_text' => 'boolean',
                                'is_correct' => true,
                                'explanation' => 'boolean() crée une colonne TINYINT.',
                                'order' => 3,
                            ],
                            [
                                'answer_text' => 'array',
                                'is_correct' => false,
                                'explanation' => 'Il n\'y a pas de type array() natif dans les migrations.',
                                'order' => 4,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($exercises as $exerciseData) {
            $questions = $exerciseData['questions'];
            unset($exerciseData['questions']);

            $exercise = Exercise::create($exerciseData);

            foreach ($questions as $questionData) {
                $answers = $questionData['answers'];
                unset($questionData['answers']);

                $question = $exercise->questions()->create($questionData);

                foreach ($answers as $answerData) {
                    $question->answers()->create($answerData);
                }
            }
        }
    }
}
