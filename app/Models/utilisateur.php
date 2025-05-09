<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class utilisateur extends Authenticatable
{
    use HasFactory;
    protected $table = 'utilisateur'; // Sans 's'

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'num_tel',
        'url_image',
        'roles',
        'enabled',
        'provider',
        'student_card_number',
        'university',
        'study_level',
        'adeli_number',
        'specialization',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];
}
