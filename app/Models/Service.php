<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Service extends Model
{
    protected $fillable = [
        'name', 'category', 'display_name', 'is_enabled',
        'is_primary', 'config', 'credentials', 'sandbox_mode',
        'last_test_result', 'last_tested_at', 'priority',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_primary' => 'boolean',
        'config' => 'array',
        'last_test_result' => 'array',
        'last_tested_at' => 'datetime',
    ];

    // ─── Credential Encryption ───────────────────────────

    /**
     * Encrypt credentials before saving.
     */
    public function setCredentialsAttribute(array|null $value): void
    {
        $this->attributes['credentials'] = Crypt::encryptString(json_encode($value ?? []));
    }

    /**
     * Decrypt credentials when reading.
     */
    public function getCredentialsAttribute(): ?array
    {
        if (empty($this->attributes['credentials'])) {
            return null;
        }

        try {
            return json_decode(Crypt::decryptString($this->attributes['credentials']), true);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get a specific credential value.
     */
    public function getCredential(string $key, mixed $default = null): mixed
    {
        return $this->credentials[$key] ?? $default;
    }

    // ─── Scopes ──────────────────────────────────────────

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // ─── Helpers ─────────────────────────────────────────

    /**
     * Get primary service for a category.
     */
    public static function primary(string $category): ?static
    {
        return static::where('category', $category)
            ->where('is_primary', true)
            ->where('is_enabled', true)
            ->first();
    }

    /**
     * Get all enabled services for a category, ordered by priority.
     */
    public static function enabledFor(string $category): \Illuminate\Support\Collection
    {
        return static::where('category', $category)
            ->where('is_enabled', true)
            ->orderBy('priority')
            ->get();
    }

    /**
     * Record test result.
     */
    public function recordTest(bool $success, string $message): void
    {
        $this->update([
            'last_test_result' => [
                'success' => $success,
                'message' => $message,
                'tested_at' => now()->toISOString(),
            ],
            'last_tested_at' => now(),
        ]);
    }

    /**
     * Check if last test was successful.
     */
    public function lastTestPassed(): bool
    {
        return $this->last_test_result['success'] ?? false;
    }

    /**
     * Get display badge color based on category.
     */
    public function getCategoryColor(): string
    {
        return match ($this->category) {
            'payment' => 'success',
            'email' => 'info',
            'sms' => 'warning',
            'storage' => 'gray',
            'analytics' => 'primary',
            'oauth' => 'danger',
            'chat' => 'success',
            default => 'gray',
        };
    }
}
