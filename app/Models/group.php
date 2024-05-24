<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'admin_id');
    }

    public function participants()
    {
        return $this->belongsToMany('App\Models\User', 'group_participents', 'group_id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\GroupMessages', 'group_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
	
}
