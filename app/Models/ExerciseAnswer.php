<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseAnswer extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'answer_text',
        'is_correct',
        'explanation',
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
        'is_correct' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Relation avec la question
     */
    public function question()
    {
        return $this->belongsTo(ExerciseQuestion::class, 'question_id');
    }

    /**
     * Scope pour les réponses ordonnées
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope pour les réponses correctes
     */
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    /**
     * Scope pour les réponses incorrectes
     */
    public function scopeIncorrect($query)
    {
        return $query->where('is_correct', false);
    }
}
