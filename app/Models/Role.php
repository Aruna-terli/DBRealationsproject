<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    const CLIENT_ROLE_ID = 1;
    const EMPLOYEE_ROLE_ID = 2;
}
