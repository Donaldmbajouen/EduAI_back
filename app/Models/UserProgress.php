<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'lesson_id',
        'status',
        'progress_percentage',
        'time_spent',
        'last_accessed_at',
        'completed_at',
        'notes',
        'is_favorite',
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
        'progress_percentage' => 'integer',
        'time_spent' => 'integer',
        'last_accessed_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_favorite' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le cours
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relation avec la leçon
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Scope pour les cours en cours
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope pour les cours terminés
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope pour les favoris
     */
    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }

    /**
     * Mettre à jour la progression
     */
    public function updateProgress($percentage, $timeSpent = null)
    {
        $this->progress_percentage = $percentage;
        $this->last_accessed_at = now();

        if ($timeSpent) {
            $this->time_spent += $timeSpent;
        }

        if ($percentage >= 100) {
            $this->status = 'completed';
            $this->completed_at = now();
        } elseif ($percentage > 0) {
            $this->status = 'in_progress';
        }

        $this->save();
    }
}
