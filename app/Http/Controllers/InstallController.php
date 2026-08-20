<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use App\Support\Installer\EnvManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PDO;

class InstallController extends Controller
{
    /**
     * Show the installer welcome / requirements page.
     */
    public function index()
    {
        if ($this->isInstalled()) {
            return redirect()->route('home');
        }

        $requirements = $this->checkRequirements();
        $writable = $this->checkWritable();

        return view('install.welcome', [
            'requirements' => $requirements,
            'writable' => $writable,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    /**
     * Handle database configuration and run the installation.
     */
    public function install(Request $request)
    {
        if ($this->isInstalled()) {
            return redirect()->route('home');
        }

        $validated = Validator::make($request->all(), [
            'app_name' => ['required', 'string', 'max:100'],
            'app_url' => ['required', 'url'],
            'db_connection' => ['required', 'in:sqlite,mysql,pgsql'],
            'db_host' => ['nullable', 'string'],
            'db_port' => ['nullable', 'numeric'],
            'db_database' => ['required', 'string'],
            'db_username' => ['nullable', 'string'],
            'db_password' => ['nullable', 'string'],
            'admin_name' => ['required', 'string', 'max:100'],
            'admin_email' => ['required', 'email'],
            'admin_password' => ['required', 'string', 'min:8'],
            'mail_host' => ['nullable', 'string'],
            'mail_port' => ['nullable', 'numeric'],
            'mail_username' => ['nullable', 'string'],
            'mail_password' => ['nullable', 'string'],
            'mail_from_address' => ['nullable', 'email'],
        ])->validate();

        // Ensure the sqlite file exists before configuring the connection.
        if ($validated['db_connection'] === 'sqlite') {
            $dbPath = base_path($validated['db_database']);
            if (! file_exists($dbPath)) {
                touch($dbPath);
            }
        }

        // Test the database connection before writing anything permanent.
        if (! $this->testConnection($validated)) {
            return back()->withErrors([
                'db_connection' => 'Could not connect to the database. Please check the details.',
            ])->withInput();
        }

        // Build the new environment values (used for both the live
        // connection and the .env file that we write after success).
        $env = array_filter([
            'APP_NAME' => '"' . $validated['app_name'] . '"',
            'APP_ENV' => 'production',
            'APP_DEBUG' => 'false',
            'APP_URL' => rtrim($validated['app_url'], '/'),
            'APP_KEY' => env('APP_KEY') ?: EnvManager::generateKey(),
            'APP_INSTALLED' => 'true',
            'DB_CONNECTION' => $validated['db_connection'],
            'DB_HOST' => $validated['db_connection'] === 'sqlite' ? null : ($validated['db_host'] ?: '127.0.0.1'),
            'DB_PORT' => $validated['db_connection'] === 'sqlite' ? null : ($validated['db_port'] ?: '3306'),
            'DB_DATABASE' => $validated['db_database'],
            'DB_USERNAME' => $validated['db_connection'] === 'sqlite' ? null : ($validated['db_username'] ?? ''),
            'DB_PASSWORD' => $validated['db_connection'] === 'sqlite' ? null : ($validated['db_password'] ?? ''),
            'MAIL_HOST' => $validated['mail_host'] ?? '',
            'MAIL_PORT' => $validated['mail_port'] ?? '',
            'MAIL_USERNAME' => $validated['mail_username'] ?? '',
            'MAIL_PASSWORD' => $validated['mail_password'] ?? '',
            'MAIL_FROM_ADDRESS' => '"' . ($validated['mail_from_address'] ?? 'no-reply@' . parse_url($validated['app_url'], PHP_URL_HOST)) . '"',
        ]);

        // Push the values into the process environment and reload config
        // so migrations run against the new database in-process.
        $this->applyEnv($env);
        $this->reloadConfigFromEnv($validated);

        try {
            // Run migrations + full seed.
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);

            // Create / update the admin account.
            $admin = User::updateOrCreate(
                ['email' => $validated['admin_email']],
                [
                    'first_name' => $validated['admin_name'],
                    'last_name' => '',
                    'role' => 'admin',
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'password' => Hash::make($validated['admin_password']),
                ]
            );

            // Apply domain-agnostic site settings.
            Setting::set('site.name', $validated['app_name']);
            Setting::set('site.company_name', $validated['app_name']);
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors([
                'db_connection' => 'Installation failed: ' . $e->getMessage(),
            ])->withInput();
        }

        // Only persist .env and the lock file once everything succeeded.
        EnvManager::set($env);

        // Write the lock file so the app boots normally from now on.
        $this->writeLockFile([
            'installed_at' => now()->toIso8601String(),
            'url' => rtrim($validated['app_url'], '/'),
            'db_connection' => $validated['db_connection'],
            'admin_email' => $validated['admin_email'],
        ]);

        Setting::flushCache(null, null);

        return redirect()->route('install.complete');
    }

    /**
     * Show the installation complete page.
     */
    public function complete()
    {
        if (! $this->isInstalled()) {
            return redirect()->route('install.index');
        }

        return view('install.complete');
    }

    /**
     * Determine whether the application has been installed.
     */
    public function isInstalled(): bool
    {
        if (filter_var(env('APP_INSTALLED', false), FILTER_VALIDATE_BOOLEAN)) {
            return true;
        }

        return file_exists(storage_path('app/installed'));
    }

    protected function writeLockFile(array $meta): void
    {
        file_put_contents(
            storage_path('app/installed'),
            json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    protected function testConnection(array $config): bool
    {
        if ($config['db_connection'] === 'sqlite') {
            return file_exists(base_path($config['db_database']));
        }

        $dsn = $config['db_connection'] . ':host=' . ($config['db_host'] ?? '127.0.0.1')
            . ';port=' . ($config['db_port'] ?? '3306')
            . ';dbname=' . $config['db_database'];

        try {
            new PDO($dsn, $config['db_username'] ?? '', $config['db_password'] ?? '', [
                PDO::ATTR_TIMEOUT => 5,
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    protected function applyEnv(array $env): void
    {
        foreach ($env as $key => $value) {
            $value = trim($value, '"');
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }

    protected function reloadConfigFromEnv(array $config): void
    {
        // Re-run Laravel's configuration bootstrap so config/database.php
        // is rebuilt from the new environment values.
        if (file_exists(base_path('bootstrap/cache/config.php'))) {
            unlink(base_path('bootstrap/cache/config.php'));
        }
        app()->bootstrapWith([\Illuminate\Foundation\Bootstrap\LoadConfiguration::class]);

        // Point the live connection at the newly configured database.
        $connection = $config['db_connection'];
        config(['database.default' => $connection]);
        DB::purge($connection);
    }

    protected function checkRequirements(): array
    {
        $checks = [
            'PHP >= 8.2' => ['ok' => version_compare(PHP_VERSION, '8.2.0', '>='), 'blocking' => true],
            'OpenSSL Extension' => ['ok' => extension_loaded('openssl'), 'blocking' => true],
            'PDO Extension' => ['ok' => extension_loaded('pdo'), 'blocking' => true],
            'MBString' => ['ok' => extension_loaded('mbstring'), 'blocking' => true],
            'CURL' => ['ok' => extension_loaded('curl'), 'blocking' => true],
            'Fileinfo' => ['ok' => extension_loaded('fileinfo'), 'blocking' => true],
            'JSON' => ['ok' => extension_loaded('json'), 'blocking' => true],
            'PDO SQLite (SQLite option)' => ['ok' => extension_loaded('pdo_sqlite'), 'blocking' => false],
            'PDO MySQL (MySQL option)' => ['ok' => extension_loaded('pdo_mysql'), 'blocking' => false],
            'PDO PostgreSQL (Postgres option)' => ['ok' => extension_loaded('pdo_pgsql'), 'blocking' => false],
        ];

        return $checks;
    }

    protected function checkWritable(): array
    {
        $paths = [
            '.env' => base_path('.env'),
            'storage' => storage_path(),
            'bootstrap/cache' => base_path('bootstrap/cache'),
            'database' => database_path(),
        ];

        $result = [];
        foreach ($paths as $label => $path) {
            if (is_dir($path)) {
                $result[$label] = is_writable($path);
            } else {
                $result[$label] = is_writable(dirname($path));
            }
        }

        return $result;
    }
}