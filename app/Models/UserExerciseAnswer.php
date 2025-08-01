<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExerciseAnswer extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_answers',
        'is_correct',
        'points_earned',
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
        'selected_answers' => 'array',
        'is_correct' => 'boolean',
        'points_earned' => 'integer',
    ];

    /**
     * Relation avec la tentative
     */
    public function attempt()
    {
        return $this->belongsTo(UserExerciseAttempt::class, 'attempt_id');
    }

    /**
     * Relation avec la question
     */
    public function question()
    {
        return $this->belongsTo(ExerciseQuestion::class, 'question_id');
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->attempt->user;
    }

    /**
     * Relation avec l'exercice
     */
    public function exercise()
    {
        return $this->attempt->exercise;
    }
}
