<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'phone',
        'avatar',
        'active',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Obtenir l'URL complète de l'avatar
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('images/default-avatar.png');
    }

    /**
     * Relation avec les cours
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Relation avec la progression
     */
    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Relation avec les suggestions de cours
     */
    public function courseSuggestions()
    {
        return $this->hasMany(CourseSuggestion::class);
    }

    /**
     * Relation avec les votes sur les suggestions
     */
    public function suggestionVotes()
    {
        return $this->hasMany(SuggestionVote::class);
    }

    /**
     * Relation avec les tentatives d'exercices
     */
    public function exerciseAttempts()
    {
        return $this->hasMany(UserExerciseAttempt::class);
    }
}
