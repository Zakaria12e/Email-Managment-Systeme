<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'email_id', 'nom_piece', 'type_piece', 'chemin'];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
