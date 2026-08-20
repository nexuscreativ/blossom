<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class SettingsCacheCommand extends Command
{
    protected $signature = 'blossom:settings:cache';

    protected $description = 'Cache all settings to a config file for fast access';

    public function handle(): int
    {
        $settings = Setting::all();

        $grouped = $settings->groupBy('group')->map(function ($groupSettings) {
            return $groupSettings
                ->mapWithKeys(fn ($s) => [
                    str_replace($s->group.'.', '', $s->key) => $s->castValue(),
                ])
                ->toArray();
        });

        $configPath = config_path('blossom-settings.php');
        $content = "<?php\n\nreturn ".var_export($grouped->toArray(), true).";\n";

        file_put_contents($configPath, $content);

        $this->info("Settings cached to {$configPath}");
        $this->info("Total settings: {$settings->count()}");

        return Command::SUCCESS;
    }
}
