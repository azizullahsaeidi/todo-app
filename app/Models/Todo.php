<?php

namespace App\Models;

use App\Models\Relations\BelongsToTodoType;
use App\Models\Relations\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory, BelongsToUser, BelongsToTodoType;

    protected $guarded = [];
}
