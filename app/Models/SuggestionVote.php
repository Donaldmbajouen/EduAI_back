<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuggestionVote extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'course_suggestion_id',
        'vote_type',
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
        //
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec la suggestion de cours
     */
    public function courseSuggestion()
    {
        return $this->belongsTo(CourseSuggestion::class);
    }

    /**
     * Scope pour les votes positifs
     */
    public function scopeUpVotes($query)
    {
        return $query->where('vote_type', 'up');
    }

    /**
     * Scope pour les votes négatifs
     */
    public function scopeDownVotes($query)
    {
        return $query->where('vote_type', 'down');
    }
}
