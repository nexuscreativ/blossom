<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'group', 'key', 'value', 'type', 'label',
        'description', 'sort_order', 'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'sort_order' => 'integer',
    ];

    // ─── Scopes ──────────────────────────────────────────

    public function scopeGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // ─── Static Helpers (main API) ───────────────────────

    /**
     * Get a setting value by dot notation key.
     *
     * @example Setting::get('site.name', 'Default')
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("settings.{$key}", now()->addDay(), function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting ? $setting->castValue() : $default;
        });
    }

    /**
     * Get all settings for a group.
     *
     * @example Setting::group('site') → ['name' => 'BLOSSOM', ...]
     */
    public static function group(string $group): array
    {
        return Cache::remember("settings.group.{$group}", now()->addDay(), function () use ($group) {
            return static::where('group', $group)
                ->orderBy('sort_order')
                ->get()
                ->pluck('value', 'key')
                ->map(fn ($val, $key) => static::castValueByKey($key, $val))
                ->toArray();
        });
    }

    /**
     * Get all public settings (for frontend Blade templates).
     */
    public static function public(): array
    {
        return Cache::remember('settings.public', now()->addDay(), function () {
            return static::where('is_public', true)
                ->get()
                ->mapWithKeys(fn ($s) => [$s->key => $s->castValue()])
                ->toArray();
        });
    }

    /**
     * Set a setting value (creates or updates).
     */
    public static function set(string $key, mixed $value, ?string $group = null): static
    {
        $group = $group ?? substr($key, 0, strpos($key, '.'));
        $serialized = is_array($value) ? json_encode($value) : (string) $value;
        $type = is_array($value)
            ? 'json'
            : ((is_bool($value) || in_array($value, ['true', 'false'])) ? 'boolean' : 'text');

        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $serialized,
                'type' => $type,
            ]
        );

        static::flushCache($key, $group);

        return $setting;
    }

    /**
     * Set multiple settings at once.
     */
    public static function setMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            static::set($key, $value);
        }
    }

    /**
     * Flush cache for a key or group.
     */
    public static function flushCache(?string $key = null, ?string $group = null): void
    {
        if ($key) {
            Cache::forget("settings.{$key}");
        }
        if ($group) {
            Cache::forget("settings.group.{$group}");
        }
        Cache::forget('settings.public');
        Cache::forget('settings.all');
    }

    // ─── Instance Helpers ────────────────────────────────

    /**
     * Cast value based on type column.
     */
    public function castValue(): mixed
    {
        return match ($this->type) {
            'json' => json_decode($this->value, true),
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'number' => is_numeric($this->value) ? (float) $this->value : $this->value,
            'image' => $this->value ? Storage::url($this->value) : null,
            default => $this->value,
        };
    }

    protected static function castValueByKey(string $key, mixed $value): mixed
    {
        if (str_ends_with($key, '_id') || str_contains($key, '.price')) {
            return is_numeric($value) ? (float) $value : $value;
        }

        if (in_array($key, [
            'payment.sandbox_mode',
            'newsletter.broadcast_enabled',
            'newsletter.show_count',
            'page.contact.form_enabled',
        ])) {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        return $value;
    }
}
