<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ListUser extends Pivot
{
    protected $fillable = [
        'status',
        'role'
    ];

    public function list(): BelongsTo
    {
        return $this->belongsTo(ItemList::class, 'list_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
