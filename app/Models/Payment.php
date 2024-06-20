<?php

namespace App\Models;
use App\Models\Projects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $guarded = ['id'];

    public function paid_clients()
    {
        return $this->HasMany(Projects::class, 'id', 'project_id');
    }
    // public function sold_project()
    // {
    //     return $this->belongsTo(Payment::class,'project_id','id');
    // }
    
}
