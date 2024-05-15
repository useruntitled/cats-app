<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
