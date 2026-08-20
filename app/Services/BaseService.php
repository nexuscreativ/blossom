<?php

namespace App\Services;

use App\Contracts\ServiceInterface;
use App\Models\Service;

abstract class BaseService implements ServiceInterface
{
    protected ?Service $service = null;
    protected string $name;
    protected string $category;

    public function __construct()
    {
        $this->service = Service::where('name', $this->name)
            ->where('category', $this->category)
            ->first();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function isEnabled(): bool
    {
        return $this->service?->is_enabled ?? false;
    }

    public function getCredential(string $key, mixed $default = null): mixed
    {
        return $this->service->getCredential($key, $default);
    }

    public function getConfig(string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->service?->config ?? [];
        }

        return $this->service?->config[$key] ?? $default;
    }

    public function isSandbox(): bool
    {
        return $this->service?->sandbox_mode === 'sandbox';
    }
}
