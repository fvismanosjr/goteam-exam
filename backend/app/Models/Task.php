<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['user_id'];

    /**
     * Get the task items for the task
     */
    public function taskItems(): HasMany
    {
        return $this->hasMany(TaskItem::class);
    }
}
