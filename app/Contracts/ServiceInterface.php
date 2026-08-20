<?php

namespace App\Contracts;

use App\Models\Service;

interface ServiceInterface
{
    /**
     * Get the service name identifier.
     */
    public function getName(): string;

    /**
     * Get the service category.
     */
    public function getCategory(): string;

    /**
     * Get admin form schema for configuring this service.
     * Returns Filament form fields.
     */
    public static function getConfigSchema(): array;

    /**
     * Validate that required credentials are present.
     */
    public function validate(): bool;

    /**
     * Test connection to the service.
     * Returns ['success' => bool, 'message' => string].
     */
    public function test(): array;

    /**
     * Get the service configuration from database.
     */
    public function getService(): ?Service;
}
