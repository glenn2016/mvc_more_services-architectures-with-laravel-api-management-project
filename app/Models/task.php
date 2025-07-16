<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    //
     protected $fillable = [
        'name',
        'project_id',
        'assigned_to',
        'created_by'
    ];

    /**
     *Projet auquel appartient cette tâche
     *
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Membre assigné à cette tâche
     *
     *
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /***
     *  Utilisateur qui a créé la tâche
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
