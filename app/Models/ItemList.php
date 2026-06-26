<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ItemList extends Model
{
    use HasFactory;

    protected $table = 'lists';

    protected $fillable = [
        'name',
        'type',
        'status',
        'created_by',
    ];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'list_items', 'list_id', 'item_id')
            ->using(ListItem::class)
            ->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'list_users', 'list_id', 'user_id')
            ->using(ListUser::class)
            ->withPivot('role')
            ->withTimestamps();
    }
}