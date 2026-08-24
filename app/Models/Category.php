<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    protected $fillable = [
        'name',
        'color',
        'type',
        'list_id',
        'created_by',
    ];

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->created_by = Auth::id();
        });
    }

    protected function color(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? null,
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
