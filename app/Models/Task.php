<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(key: 'task_id')]
#[Fillable(['title', 'description', 'assign_to', 'assign_by', 'start_at', 'end_at', 'status'])]
class Task extends Model
{

    public function assignedTo(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }

    public function assignedBy(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'assign_by', 'id');
    }
}
