<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lesson_id',
        'title',
        'description',
        'type',
        'difficulty_level',
        'points',
        'time_limit',
        'is_active',
        'order',
        'passing_score',
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
        'time_limit' => 'integer',
        'is_active' => 'boolean',
        'order' => 'integer',
        'passing_score' => 'integer',
    ];

    /**
     * Relation avec la leçon
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Relation avec les questions
     */
    public function questions()
    {
        return $this->hasMany(ExerciseQuestion::class)->ordered();
    }

    /**
     * Relation avec les tentatives utilisateur
     */
    public function attempts()
    {
        return $this->hasMany(UserExerciseAttempt::class);
    }

    /**
     * Scope pour les exercices actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les exercices ordonnés
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope pour les exercices par niveau de difficulté
     */
    public function scopeByDifficulty($query, $level)
    {
        return $query->where('difficulty_level', $level);
    }

    /**
     * Calculer le score maximum possible
     */
    public function getMaxScoreAttribute()
    {
        return $this->questions->sum('points');
    }

    /**
     * Vérifier si un utilisateur a passé cet exercice
     */
    public function hasUserPassed($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->where('is_passed', true)
            ->exists();
    }

    /**
     * Obtenir la meilleure tentative d'un utilisateur
     */
    public function getUserBestAttempt($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->orderBy('percentage', 'desc')
            ->first();
    }
}
