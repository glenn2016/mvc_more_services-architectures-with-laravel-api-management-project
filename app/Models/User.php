<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Jwt
     */
        public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Tâches assignées à cet utilisateur (en tant que membre)

     */

    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
    /**
     * Tâches créées par cet utilisateur (en tant que chef)
     */

    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     *  Projets où il est chef
     */

    public function projets()
    {
        return $this->hasMany(Project::class, 'chef_id');
    }

    /**
     * Projets qu’il a créés (utile si `created_by` ≠ `chef_id`)
     *
     */

    public function createdProjects()
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    /**
     * Membres qu’il a créés (si chef crée un utilisateur)
     *
     */

    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    /**
     * Chef qui a créé cet utilisateur
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Rôles (Many-to-Many)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}