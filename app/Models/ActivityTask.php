<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table(key: 'activity_task_id')]
#[Fillable(['activity_task_id', 'task_id', 'title', 'description'])]
class ActivityTask extends Model
{



}
