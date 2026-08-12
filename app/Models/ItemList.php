<?php

namespace App\Models;

use App\Enums\ListUserStatusEnum;
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

    public function getCategoriesAttribute()
    {
        return $this->items->pluck('category')->unique('id');
    }

    public function getCategoriesWithItemsAttribute()
    {
        return $this->categories->map(function ($category) {
            $category->items = $this->items->where('category_id', $category->id);
            return $category;
        })->values();
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'list_items', 'list_id', 'item_id')
            ->using(ListItem::class)
            ->withPivot('status', 'need_at', 'needed_by', 'created_by')
            ->withTimestamps();
    }

    public function users($status = [ListUserStatusEnum::PENDING->value, ListUserStatusEnum::ACCEPTED->value, ListUserStatusEnum::REJECTED->value, ListUserStatusEnum::CANCELLED->value]): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'list_users', 'list_id', 'user_id')
            ->using(ListUser::class)
            ->withPivot('role', 'status')
            ->withTimestamps()
            ->wherePivotIn('status', $status);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}