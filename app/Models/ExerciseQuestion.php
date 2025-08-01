<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseQuestion extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exercise_id',
        'question_text',
        'question_type',
        'points',
        'order',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'points' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Relation avec l'exercice
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * Relation avec les réponses
     */
    public function answers()
    {
        return $this->hasMany(ExerciseAnswer::class, 'question_id')->ordered();
    }

    /**
     * Relation avec les réponses utilisateur
     */
    public function userAnswers()
    {
        return $this->hasMany(UserExerciseAnswer::class, 'question_id');
    }

    /**
     * Scope pour les questions ordonnées
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Obtenir les réponses correctes
     */
    public function getCorrectAnswers()
    {
        return $this->answers()->where('is_correct', true)->get();
    }

    /**
     * Vérifier si une réponse est correcte
     */
    public function isAnswerCorrect($selectedAnswers)
    {
        $correctAnswers = $this->getCorrectAnswers()->pluck('id')->toArray();
        $selectedIds = is_array($selectedAnswers) ? $selectedAnswers : [$selectedAnswers];

        return empty(array_diff($correctAnswers, $selectedIds)) &&
               empty(array_diff($selectedIds, $correctAnswers));
    }
}
