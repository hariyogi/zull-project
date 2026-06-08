<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['task_activity_id', 'file_name', 'file_path', 'file_type'])]
class TaskEvidence extends Model
{
    protected $primaryKey = 'task_evidence_id';
    protected $table = 'task_evidences';
}
