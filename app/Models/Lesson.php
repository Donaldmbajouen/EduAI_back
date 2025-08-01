<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video_url',
        'order',
        'difficulty_level',
        'objectives',
        'prerequisites',
        'status',
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
        'order' => 'integer',
    ];

    /**
     * Relation avec le cours
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope pour les leçons publiées
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope pour les leçons par ordre
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Relation avec la progression des utilisateurs
     */
    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Relation avec les exercices
     */
    public function exercises()
    {
        return $this->hasMany(Exercise::class)->ordered();
    }
}
