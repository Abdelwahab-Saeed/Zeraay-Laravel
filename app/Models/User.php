<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use DevKandil\NotiFire\Traits\HasFcm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasFcm;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'city',
        'state',
        'engineer_code',
        'address',
        'role',
        'image',
        'fcm_token',
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
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the user's cart items.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the user's wishlist items.
     */
    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class);
    }

    /**
     * Get the user's orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Coupons used by the user.
     */
    public function usedCoupons()
    {
        return $this->belongsToMany(Coupon::class, 'user_coupon')
            ->withPivot('used_at')
            ->withTimestamps();
    }

    /**
     * Get the user's chat.
     */
    public function chat()
    {
        return $this->hasOne(Chat::class);
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'user_notifications');
    }

    /**
     * Get the full URL for the user's profile image.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Accessor for appends.
     */
    protected $appends = ['image_url'];
}
