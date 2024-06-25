<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Projects;
use App\Models\Role;
use App\Enums\UserRoleEnum;
use App\Enums\GenderEnum;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
    
        'name',
        'email_id',
        'phone_no',
        'password',
        'gender',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender'=>GenderEnum::class,
        'role'=>UserRoleEnum::class,
        
    ];
   

  
    public function clientProjects()
{
    return $this->belongsToMany(Projects::class, 'user_project', 'user_id', 'project_id');
                
}
public function client_employees()
{
    return $this->belongsToMany(User::class, 'clients_employees',  'employee_id','client_id')->withPivot('project_id');
}

// public function employeeProjects()
// {
//     return $this->belongsToMany(Projects::class, 'user_project', 'user_id', 'project_id');
                
// }

  
}
