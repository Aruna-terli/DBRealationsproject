<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Role;

class projects extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $fillable = [
        // 'user_id',
        // 'project_name',
        // 'Amount',
        // 'project_type',
        // 'description'
        
    ];
    public function clients()
    {
        return $this->belongsToMany(User::class, 'user_project', 'project_id', 'user_id')->withPivot('role_id');
                   
    }
    
    public function employees()
    {
        return $this->belongsToMany(User::class, 'user_project', 'project_id', 'user_id')->withPivot('role_id');
                    
    }
}
