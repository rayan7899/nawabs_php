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

    // public function getCategoriesAttribute()
    // {
    //     return $this->items->pluck('category')->unique('id');
    // }

    public function getCategoriesWithItemsAttribute()
    {
        return $this->categories->map(function ($category) {
            $category->items = $this->items->where('category_id', $category->id);
            return $category;
        })->values();
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'list_id');
    }

    public function items($categoryId = null)
    {
        return $this->hasManyThrough(Item::class, Category::class, 'list_id', 'category_id');
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