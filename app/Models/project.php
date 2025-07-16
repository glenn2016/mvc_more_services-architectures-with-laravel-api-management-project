<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    //
     protected $fillable = [
        'name',
        'description',
        'chef_id',
        'created_by'
    ];

    /**
     * Le chef de projet
     */

    public function chef()
    {
        return $this->belongsTo(User::class, 'chef_id');
    }

    /**
     * Créateur du projet (utile si différent du chef)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Toutes les tâches du projet
     */

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
