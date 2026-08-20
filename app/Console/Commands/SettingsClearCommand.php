<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class SettingsClearCommand extends Command
{
    protected $signature = 'blossom:settings:clear';

    protected $description = 'Clear all settings cache and remove cached config file';

    public function handle(): int
    {
        Setting::flushCache();

        $configPath = config_path('blossom-settings.php');

        if (file_exists($configPath)) {
            unlink($configPath);
            $this->info('Removed cached config file');
        }

        $this->info('Settings cache cleared successfully');

        return Command::SUCCESS;
    }
}
