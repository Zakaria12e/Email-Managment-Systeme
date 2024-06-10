<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destinataire extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_dest',
        'prenom_dest',
        'telephone_dest',
        'first_email',
        'second_email',
        'department_id',
        'structure_id',
    ];



    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'destinataire_roles', 'destinataire_id', 'role_id');
    }
}
