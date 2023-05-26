<?php

namespace App\Models\Relations;

use App\Models\TodoType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTodoType
{
    /**
     * Get todoType
     */
    public function todoType(): BelongsTo
    {
        return $this->belongsTo(TodoType::class);
    }
}
