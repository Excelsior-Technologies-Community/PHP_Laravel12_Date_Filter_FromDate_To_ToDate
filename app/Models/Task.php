<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'task_date',
        'status'
    ];

    protected $casts = [
        'task_date' => 'date',
    ];
}