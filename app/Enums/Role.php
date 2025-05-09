<?php
namespace App\Enums;

enum Role: string
{
    case USER = 'USER';
    case PSYCHOLOGIST = 'PSYCHOLOGIST';
    case ADMIN = 'ADMIN';
}
