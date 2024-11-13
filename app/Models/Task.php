<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name'];  // Fillable fields
    public $timestamps = false;

    public function taskTimes()
    {
        return $this->hasMany(TaskTime::class);
    }
}
