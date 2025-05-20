<?php

namespace App\Enums;

enum Role: string
{
    case STUDENT = 'STUDENT';
    case PSYCHOLOGIST = 'PSYCHOLOGIST';
    case ADMIN = 'ADMIN';
}
