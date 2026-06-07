<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['title', 'description', 'assign_to', 'assign_by', 'start_at', 'end_at', 'status'])]
class Task extends Model
{

    protected $primaryKey = 'task_id';

    protected function casts(): array
    {
        return [
            'status' => TaskStatus::class,
        ];
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_by', 'id');
    }
}
