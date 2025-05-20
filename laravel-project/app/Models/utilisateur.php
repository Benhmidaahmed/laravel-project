<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use App\Enums\Role;

class utilisateur extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'utilisateur';

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'enabled' => 'boolean',

    ];


    // JWT Implementation
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->roles,
            'email' => $this->email,
        ];
    }

  public function isPsychologist(): bool
{
    return $this->roles === Role::PSYCHOLOGIST->value;
}

public function isStudent(): bool
{
    return $this->roles === Role::STUDENT->value;
}

}
