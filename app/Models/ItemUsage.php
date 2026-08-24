<?php

namespace App\Models;

use App\ItemUsageActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ItemUsage extends Model
{
    protected $fillable = ['action'];

    protected $casts = [
        'action' => ItemUsageActions::class,
    ];

    protected static function booted()
    {
        static::creating(function ($listItem) {
            if (!$listItem->created_by) {
                $listItem->created_by = Auth::id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
