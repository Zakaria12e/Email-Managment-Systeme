<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'exped_nom',
        'exped_org',
        'email_exped',
        'exped_phone',
        'date_exped',
        'sujet',
        'contenu',
        'to',
        'cc',
        'cci',
        'dead_line',
        'user_id',
        'nbr_env',
        'status',
    ];

    protected $dates = [
        'date_exped',
        'dead_line',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function attachments()
    {
        return $this->hasMany(Attachments::class);
    }
}
