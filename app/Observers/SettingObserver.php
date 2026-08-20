<?php

namespace App\Observers;

use App\Models\Setting;

class SettingObserver
{
    public function saved(Setting $setting): void
    {
        Setting::flushCache($setting->key, $setting->group);
    }

    public function deleted(Setting $setting): void
    {
        Setting::flushCache($setting->key, $setting->group);
    }
}
