<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskItem extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['task_id', 'description', 'is_done'];

    /**
     * Get the task that owns the task item.
     */

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
