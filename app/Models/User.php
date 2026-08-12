<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ListTypeEnum;
use App\Enums\ListUserStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
/**
 * @method static \App\Models\ItemList[] lists()
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function lists($status = [ListUserStatusEnum::ACCEPTED->value]): BelongsToMany
    {
        return $this->belongsToMany(ItemList::class, 'list_users', 'user_id', 'list_id')
            ->using(ListUser::class)
            ->wherePivotIn('status', $status)
            ->withTimestamps();
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(ListUser::class, 'user_id')
            ->where('status', ListUserStatusEnum::PENDING->value);
    }

    public function defaultList()
    {
        return $this->lists()->where('type', ListTypeEnum::DEFAULT->value)->first();
    }
}
