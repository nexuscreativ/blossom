<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'avatar',
        'phone',
        'role',
        'password',
        'google_id',
        'is_active',
        'bio',
        'location',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, 'owner_id');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->latest();
    }

    public function activeSubscription(): ?Subscription
    {
        return $this->subscriptions()
            ->where('status', \App\Enums\Payment\SubscriptionStatus::ACTIVE)
            ->where('ends_at', '>', now())
            ->latest()
            ->first();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function newsletterSubscriber(): HasOne
    {
        return $this->hasOne(NewsletterSubscriber::class);
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'user');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return in_array($this->role, ['admin', 'editor']);
    }

    public function isAuthor(): bool
    {
        return in_array($this->role, ['admin', 'editor', 'author']);
    }

    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription() !== null;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
