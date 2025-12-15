<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskItem extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['task_id', 'description'];

    /**
     * Get the task that owns the task item.
     */

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
