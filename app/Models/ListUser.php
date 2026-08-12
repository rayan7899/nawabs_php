<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ListUser extends Pivot
{
    protected $table = 'list_users';
    protected $fillable = [
        'status',
        'status_changed_at',
        'role',
        'role_changed_at'
    ];

    protected $casts = [
        'status' => \App\Enums\ListUserStatusEnum::class,
        'role' => \App\Enums\ListUserRoleEnum::class,
    ];

    protected static function booted()
    {
        static::creating(function ($item) {
            $item->color = generateRandomHexColor();
        });

        /**
         * Generates a random 6-character hexadecimal color string.
         * @return string
         */
        function generateRandomHexColor(): string
        {
            // Generate 3 random bytes (one for Red, Green, and Blue)
            $bytes = random_bytes(3);

            // Convert the binary data to a clean hex string and prepend the hash
            return '#' . bin2hex($bytes);
        }
    }

    public function list(): BelongsTo
    {
        return $this->belongsTo(ItemList::class, 'list_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
