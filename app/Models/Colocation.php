<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Colocation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'cancelled_at',
        'invite_token',
    ];

    protected function casts(): array
    {
        return [
            'cancelled_at' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Colocation $colocation) {
            if (empty($colocation->invite_token)) {
                $colocation->invite_token = Str::random(32);
            }
        });
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'memberships')
            ->using(Membership::class)
            ->withPivot('role', 'joined_at', 'left_at')
            ->withTimestamps();
    }
}
