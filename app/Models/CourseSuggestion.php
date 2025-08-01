<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSuggestion extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'level',
        'category_id',
        'justification',
        'status',
        'votes_count',
        'admin_notes',
        'approved_at',
        'implemented_at',
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
        'votes_count' => 'integer',
        'approved_at' => 'datetime',
        'implemented_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur qui a fait la suggestion
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec la catégorie
     */
    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }

    /**
     * Relation avec les votes
     */
    public function votes()
    {
        return $this->hasMany(SuggestionVote::class);
    }

    /**
     * Scope pour les suggestions en attente
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope pour les suggestions approuvées
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope pour les suggestions populaires (plus de votes)
     */
    public function scopePopular($query)
    {
        return $query->orderBy('votes_count', 'desc');
    }

    /**
     * Vérifier si un utilisateur a voté pour cette suggestion
     */
    public function hasUserVoted($userId)
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }

    /**
     * Obtenir le vote d'un utilisateur pour cette suggestion
     */
    public function getUserVote($userId)
    {
        return $this->votes()->where('user_id', $userId)->first();
    }

    /**
     * Incrémenter le compteur de votes
     */
    public function incrementVotes()
    {
        $this->increment('votes_count');
    }

    /**
     * Décrémenter le compteur de votes
     */
    public function decrementVotes()
    {
        $this->decrement('votes_count');
    }
}
