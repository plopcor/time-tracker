<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTime extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'start_at', 'end_at'];  // Fillable fields
    public $timestamps = false;
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
