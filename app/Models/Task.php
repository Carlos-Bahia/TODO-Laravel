<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected array $dates = ['deadline', 'completed_at'];

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'is_completed',
        'created_by',
        'completed_at'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_task')->limit(2);
    }

    public function getDeadlineAttribute(): Carbon
    {
        return Carbon::parse($this->attributes['deadline']);
    }

    public function getCompletedAtAttribute(): Carbon
    {
        return Carbon::parse($this->attributes['completed_at']);
    }
}
