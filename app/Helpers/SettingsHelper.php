<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Get a setting value.
     *
     * @example {{ setting('site.name') }}
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('setting_group')) {
    /**
     * Get all settings for a group.
     *
     * @example @php $site = setting_group('site'); @endphp
     */
    function setting_group(string $group): array
    {
        return Setting::group($group);
    }
}

if (! function_exists('social_links')) {
    /**
     * Get all social links.
     */
    function social_links(): array
    {
        return collect(Setting::group('site'))
            ->filter(fn ($value, $key) => str_starts_with($key, 'site.social_'))
            ->mapWithKeys(fn ($value, $key) => [
                str_replace('site.social_', '', $key) => $value,
            ])
            ->toArray();
    }
}
