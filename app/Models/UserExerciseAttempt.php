<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExerciseAttempt extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'exercise_id',
        'score',
        'max_score',
        'percentage',
        'time_spent',
        'status',
        'is_passed',
        'started_at',
        'completed_at',
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
        'score' => 'integer',
        'max_score' => 'integer',
        'percentage' => 'decimal:2',
        'time_spent' => 'integer',
        'is_passed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'exercice
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * Relation avec les réponses utilisateur
     */
    public function userAnswers()
    {
        return $this->hasMany(UserExerciseAnswer::class, 'attempt_id');
    }

    /**
     * Scope pour les tentatives terminées
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope pour les tentatives réussies
     */
    public function scopePassed($query)
    {
        return $query->where('is_passed', true);
    }

    /**
     * Scope pour les tentatives échouées
     */
    public function scopeFailed($query)
    {
        return $query->where('is_passed', false)->where('status', 'completed');
    }

    /**
     * Calculer le pourcentage de réussite
     */
    public function calculatePercentage()
    {
        if ($this->max_score > 0) {
            $this->percentage = round(($this->score / $this->max_score) * 100, 2);
        }
        return $this->percentage;
    }

    /**
     * Vérifier si la tentative est réussie
     */
    public function checkIfPassed()
    {
        $this->is_passed = $this->percentage >= $this->exercise->passing_score;
        return $this->is_passed;
    }

    /**
     * Marquer comme terminée
     */
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->completed_at = now();
        $this->calculatePercentage();
        $this->checkIfPassed();
        $this->save();
    }
}
