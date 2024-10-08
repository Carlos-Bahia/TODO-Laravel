<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $dates = ['deadline', 'completed_at'];

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'is_completed',
        'created_by',
    ];

    public function getDeadlineAttribute()
    {
        return Carbon::parse($this->attributes['deadline']);
    }

    public function getCompletedAtAttribute()
    {
        return Carbon::parse($this->attributes['completed_at']);
    }
}
