<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseResource extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'name',
        'type',
        'url',
        'file_path',
        'description',
        'order',
        'is_free',
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
        'is_free' => 'boolean',
    ];

    /**
     * Relation avec le cours
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Obtenir l'URL complète du fichier
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    /**
     * Scope pour les ressources gratuites
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    /**
     * Scope pour les ressources par ordre
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
