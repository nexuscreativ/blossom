<?php

namespace App\Support\Installer;

class EnvManager
{
    /**
     * Read the current .env file into an associative array.
     */
    public static function read(): array
    {
        $path = base_path('.env');
        if (! file_exists($path)) {
            return [];
        }

        $values = [];
        foreach (file($path, FILE_IGNORE_NEW_LINES) as $line) {
            $line = ltrim($line);
            if ($line === '' || str_starts_with($line, '#') || ! str_contains($line, '=')) {
                continue;
            }
            [$key, $value] = explode('=', $line, 2);
            $values[trim($key)] = trim(trim($value), '"');
        }

        return $values;
    }

    /**
     * Set values in .env, preserving all unrelated lines and comments.
     */
    public static function set(array $values): void
    {
        $path = base_path('.env');
        $source = file_exists($path)
            ? file_get_contents($path)
            : (file_exists(base_path('.env.example')) ? file_get_contents(base_path('.env.example')) : '');

        $lines = explode("\n", $source);
        $found = [];

        foreach ($lines as &$line) {
            $trimmed = ltrim($line);
            if ($trimmed === '' || str_starts_with($trimmed, '#') || ! str_contains($trimmed, '=')) {
                continue;
            }
            $key = trim(explode('=', $trimmed, 2)[0]);
            if (array_key_exists($key, $values)) {
                $line = $key . '=' . static::quote((string) $values[$key]);
                $found[$key] = true;
            }
        }

        $out = implode("\n", $lines);
        foreach ($values as $key => $value) {
            if (! isset($found[$key])) {
                $out .= ($out === '' ? '' : "\n") . $key . '=' . static::quote((string) $value);
            }
        }

        file_put_contents($path, rtrim($out) . "\n");
    }

    /**
     * Generate a fresh application encryption key.
     */
    public static function generateKey(): string
    {
        return 'base64:' . base64_encode(random_bytes(32));
    }

    /**
     * Quote a value for a .env file when it contains special characters.
     */
    protected static function quote(string $value): string
    {
        if ($value === '') {
            return '';
        }

        return preg_match('/[\s"#\\$]/', $value) ? '"' . addcslashes($value, '"\\') . '"' : $value;
    }
}