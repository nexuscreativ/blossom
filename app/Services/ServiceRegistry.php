<?php

namespace App\Services;

use App\Contracts\ServiceInterface;
use App\Models\Service;
use Illuminate\Support\Facades\App;

class ServiceRegistry
{
    protected array $services = [];

    /**
     * Register a service implementation.
     */
    public function register(string $category, string $name, string $implementation): void
    {
        $this->services[$category][$name] = $implementation;
    }

    /**
     * Get a service instance by category and name.
     */
    public function get(string $category, string $name): ?ServiceInterface
    {
        if (!isset($this->services[$category][$name])) {
            return null;
        }

        return App::make($this->services[$category][$name]);
    }

    /**
     * Get the primary service for a category.
     */
    public function getPrimary(string $category): ?ServiceInterface
    {
        $primary = Service::primary($category);

        if (! $primary) {
            return null;
        }

        return $this->get($category, $primary->name);
    }

    /**
     * Get all enabled services for a category.
     *
     * @return ServiceInterface[]
     */
    public function getEnabled(string $category): array
    {
        return Service::enabledFor($category)
            ->map(fn ($service) => $this->get($category, $service->name))
            ->filter()
            ->toArray();
    }

    /**
     * Get config schema for a service.
     */
    public function getConfigSchema(string $category, string $name): ?array
    {
        $service = $this->get($category, $name);

        if (! $service) {
            return null;
        }

        return $service::getConfigSchema();
    }

    /**
     * Get all registered services.
     */
    public function all(): array
    {
        return $this->services;
    }

    /**
     * Get all registered categories.
     */
    public function categories(): array
    {
        return array_keys($this->services);
    }
}
