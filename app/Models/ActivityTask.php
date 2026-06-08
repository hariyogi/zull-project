<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['activity_task_id', 'task_id', 'title', 'description'])]
class ActivityTask extends Model
{

    protected $primaryKey = 'activity_task_id';
    public function taskEvidences(): HasMany
    {
        return $this->hasMany(TaskEvidence::class, 'task_activity_id', 'activity_task_id');
    }
}
