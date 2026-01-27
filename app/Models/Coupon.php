<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'expires_at',
        'status',
        'description',
    ];

    protected $casts = [
        'value' => 'float',
        'min_purchase' => 'float',
        'expires_at' => 'datetime',
        'status' => 'boolean',
    ];

    /**
     * Users who have used this coupon.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_coupon')
            ->withPivot('used_at')
            ->withTimestamps();
    }

    /**
     * Check if the coupon is valid.
     */
    public function isValid(): bool
    {
        if (!$this->status) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Check if the coupon is valid for a specific cart total.
     */
    public function isValidForTotal(float $total): bool
    {
        return $total >= $this->min_purchase;
    }

    /**
     * Check if a user has already used this coupon.
     */
    public function isUsedByUser(int $userId): bool
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    /**
     * Calculate discount amount for a given total.
     */
    public function calculateDiscount(float $total): float
    {
        if ($this->type === 'percent') {
            return ($total * $this->value) / 100;
        }

        return min($this->value, $total);
    }
}
