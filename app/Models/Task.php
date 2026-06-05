<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table(key: 'task_id')]
#[Fillable(['title', 'description', 'assign_to', 'assign_by', 'start_at', 'status'])]
class Task extends Model
{

}
