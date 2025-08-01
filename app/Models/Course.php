<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'level',
        'is_published',
        'thumbnail',
        'rating',
        'views_count',
        'category_id',
        'user_id',
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
        'is_published' => 'boolean',
        'rating' => 'decimal:2',
        'views_count' => 'integer',
    ];

    /**
     * Relation avec la catégorie
     */
    public function category()
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les leçons
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->ordered();
    }

    /**
     * Relation avec les ressources
     */
    public function resources()
    {
        return $this->hasMany(CourseResource::class)->ordered();
    }

    /**
     * Relation avec la progression des utilisateurs
     */
    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Obtenir l'URL complète du thumbnail
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return asset('images/default-course.jpg');
    }
}
