# BLOSSOM — Settings Manager & API Service Manager
## Comprehensive Architecture Design Document

**Version:** 1.0  
**Date:** August 19, 2026  
**Status:** Ready for Implementation  
**Framework:** Laravel 11 + Filament v4

---

## Table of Contents

1. [Executive Summary](#1-executive-summary)
2. [Settings Manager (CMS/Configuration System)](#2-settings-manager)
3. [API Service Manager (External Integrations)](#3-api-service-manager)
4. [Database Schema Design](#4-database-schema-design)
5. [Model Layer Architecture](#5-model-layer-architecture)
6. [Filament Resource Designs](#6-filament-resource-designs)
7. [Service Layer Architecture](#7-service-layer-architecture)
8. [Caching Strategy](#8-caching-strategy)
9. [Security Considerations](#9-security-considerations)
10. [Implementation Plan](#10-implementation-plan)

---

## 1. Executive Summary

This document designs two critical infrastructure systems for the BLOSSOM magazine platform:

**Problem Statement:**
- Frontend is ~95% hardcoded static data (articles, events, listings, pricing, team members)
- No settings management system exists — all configuration lives in `config/*.php` files
- Payment gateways are implemented but not configurable via admin panel
- No centralized API service management for external integrations
- Every content change requires a code deploy

**Solution:**
1. **Settings Manager** — A database-driven key-value configuration system with Filament admin UI, grouped by domain (site, SEO, pages, payments, newsletter, featured content)
2. **API Service Manager** — A service provider pattern for all external integrations (payment gateways, email, SMS, storage, analytics, OAuth) with admin UI, credential encryption, and connection testing

**Expected Outcomes:**
- Admins can change any frontend content without code deployment
- All external service credentials are configurable via admin panel
- Settings are cached for performance (< 5ms retrieval)
- Credentials are encrypted at rest
- Services can be tested/configured per environment

---

## 2. Settings Manager

### 2.1 Architecture Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                    SETTINGS MANAGER                             │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────┐    ┌──────────────┐    ┌──────────────────┐  │
│  │  Filament    │───▶│  Setting     │───▶│  Settings        │  │
│  │  Admin UI    │    │  Model       │    │  Cache Store     │  │
│  └──────────────┘    └──────────────┘    └──────────────────┘  │
│         │                   │                     │             │
│         ▼                   ▼                     ▼             │
│  ┌──────────────┐    ┌──────────────┐    ┌──────────────────┐  │
│  │  Form        │    │  Settings    │    │  Blade           │  │
│  │  Builder     │    │  Table (DB)  │    │  Helpers         │  │
│  └──────────────┘    └──────────────┘    └──────────────────┘  │
│                                                                 │
│  Settings Groups:                                               │
│  • site          • seo          • page_content                  │
│  • payments      • newsletter   • featured_content              │
│  • team          • footer       • homepage                      │
└─────────────────────────────────────────────────────────────────┘
```

### 2.2 Settings Groups & Keys

#### A. SITE SETTINGS (`site.*`)
```php
'site.name'              => 'BLOSSOM Magazine',
'site.tagline'           => 'Plateau\'s Prestige Magazine',
'site.description'       => 'Celebrating the people, culture...',
'site.logo'              => 'images/logo.png',        // file path
'site.favicon'           => 'images/favicon.ico',     // file path
'site.contact_email'     => 'hello@blossom.ng',
'site.contact_phone'     => '+234 XXX XXX XXXX',
'site.contact_address'   => 'Jos, Plateau State, Nigeria',
'site.copyright_text'    => '© 2026 BLOSSOM Magazine',
'site.company_name'      => 'BLOSSOM Media Ltd',
'site.social_twitter'    => 'https://twitter.com/blossom',
'site.social_instagram'  => 'https://instagram.com/blossom',
'site.social_facebook'   => 'https://facebook.com/blossom',
'site.social_linkedin'   => 'https://linkedin.com/company/blossom',
'site.social_whatsapp'   => 'https://wa.me/234XXXXXXXXXX',
```

#### B. SEO SETTINGS (`seo.*`)
```php
'seo.default_title'          => 'BLOSSOM — Plateau\'s Prestige Magazine',
'seo.default_description'    => 'Celebrating the people, culture...',
'seo.default_keywords'       => 'plateau, jos, nigeria, magazine',
'seo.google_analytics_id'    => 'G-XXXXXXXXXX',
'seo.social_image'           => 'images/og-default.jpg',
'seo.twitter_handle'         => '@blossom_mag',
```

#### C. PAGE CONTENT SETTINGS (`page.*`)
```php
// About Page
'page.about.mission_text'        => 'Founded in 2024...',
'page.about.values'              => [['title' => 'Authenticity', ...]], // JSON
'page.about.founding_story'      => 'BLOSSOM was born...',
'page.about.team_members'        => [['name' => 'Dung Gyang', ...]], // JSON
'page.about.hero_image'          => 'images/about-hero.jpg',

// Contact Page
'page.contact.response_time_text' => 'We typically respond within 24 hours.',
'page.contact.partnership_email'  => 'partnerships@blossom.ng',
'page.contact.form_enabled'       => 'true',

// Pricing Page
'page.pricing.plans'              => [...], // JSON array of plan objects
'page.pricing.faq_items'          => [...], // JSON array of FAQ objects
'page.pricing.hero_text'          => 'Unlock Plateau\'s Full Story',
```

#### D. PAYMENT SETTINGS (`payment.*`)
```php
'payment.default_provider'    => 'paystack',
'payment.fallback_order'      => ['paystack', 'monnify', 'nomba'],
'payment.sandbox_mode'        => 'true',
'payment.plans.monthly.price' => '2500',
'payment.plans.monthly.name'  => 'Insider Monthly',
'payment.plans.yearly.price'  => '20000',
'payment.plans.yearly.name'   => 'Patron Annual',
'payment.listing_tiers'       => [...], // JSON
```

#### E. NEWSLETTER SETTINGS (`newsletter.*`)
```php
'newsletter.broadcast_enabled' => 'true',
'newsletter.batch_size'        => '50',
'newsletter.show_count'        => 'true',
'newsletter.count_text'        => 'Join 2,000+ readers',
'newsletter.unsubscribe_text'  => 'No spam. Unsubscribe anytime.',
```

#### F. FEATURED CONTENT (`featured.*`)
```php
'featured.hero_article_id'     => '1',
'featured.hero_title'          => 'The Remarkable Story...',
'featured.hero_subtitle'       => 'From the ancient rhythms...',
'featured.hero_image'          => 'images/hero-family.jpg',
'featured.hero_category'       => 'Culture & Heritage',
'featured.hero_author'         => 'Amina Bello',
'featured.hero_read_time'      => '8 min',
'featured.trending_articles'   => [...], // JSON array of article IDs
'featured.editor_picks'        => [...], // JSON array of article IDs
'featured.stats'               => [...], // JSON array of stat objects
'featured.cta_title'           => 'Stay Connected to Plateau',
'featured.cta_subtitle'        => 'Get the best stories...',
```

### 2.3 Database Schema

#### Migration: `create_settings_table.php`
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group', 50)->index();          // e.g., 'site', 'seo', 'payment'
            $table->string('key', 100);                     // e.g., 'site.name', 'payment.sandbox_mode'
            $table->longText('value')->nullable();           // JSON or plain text
            $table->string('type', 20)->default('text');    // text, boolean, json, image, number
            $table->string('label', 150)->nullable();       // Human-readable label
            $table->text('description')->nullable();         // Help text
            $table->integer('sort_order')->default(0);       // Display order within group
            $table->boolean('is_public')->default(false);    // Accessible from frontend without auth
            $table->timestamps();

            $table->unique(['group', 'key']);
            $table->index('is_public');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
```

### 2.4 Model Design

#### `Setting.php`
```php
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
     * Example: Setting::get('site.name', 'Default')
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
     * Example: Setting::group('site') → ['name' => 'BLOSSOM', ...]
     */
    public static function group(string $group): array
    {
        return Cache::remember("settings.group.{$group}", now()->addDay(), function () use ($group) {
            return static::where('group', $group)
                ->orderBy('sort_order')
                ->get()
                ->pluck('value', 'key')
                ->map(fn($val, $key) => static::castValueByKey($key, $val))
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
                ->mapWithKeys(fn($s) => [$s->key => $s->castValue()])
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

        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $serialized,
                'type' => is_array($value) ? 'json' : gettype($value) === 'boolean' ? 'boolean' : 'text',
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
            'json'    => json_decode($this->value, true),
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'number'  => is_numeric($this->value) ? (float) $this->value : $this->value,
            'image'   => $this->value ? Storage::url($this->value) : null,
            default   => $this->value,
        };
    }

    protected static function castValueByKey(string $key, mixed $value): mixed
    {
        if (str_ends_with($key, '_id') || str_ends_with($key, '.price')) {
            return is_numeric($value) ? (float) $value : $value;
        }
        if (in_array($key, ['payment.sandbox_mode', 'newsletter.broadcast_enabled', 'newsletter.show_count', 'page.contact.form_enabled'])) {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
        return $value;
    }
}
```

---

## 3. API Service Manager

### 3.1 Architecture Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                   API SERVICE MANAGER                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────┐    ┌──────────────┐    ┌──────────────────┐  │
│  │  Filament    │───▶│  Service     │───▶│  Service         │  │
│  │  Admin UI    │    │  Registry    │    │  Providers       │  │
│  └──────────────┘    └──────────────┘    └──────────────────┘  │
│         │                   │                     │             │
│         ▼                   ▼                     ▼             │
│  ┌──────────────┐    ┌──────────────┐    ┌──────────────────┐  │
│  │  Config      │    │  Services    │    │  Connection      │  │
│  │  Forms       │    │  Table (DB)  │    │  Tester          │  │
│  └──────────────┘    └──────────────┘    └──────────────────┘  │
│                                                                 │
│  Service Categories:                                            │
│  • payment      • email        • sms                            │
│  • storage      • analytics    • oauth                          │
│                                                                 │
│  Each Service Provider:                                         │
│  • Implements ServiceInterface                                  │
│  • Has config() → admin form schema                             │
│  • Has test() → connection test                                 │
│  • Credentials encrypted via Settings encryption                │
└─────────────────────────────────────────────────────────────────┘
```

### 3.2 Database Schema

#### Migration: `create_services_table.php`
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);                     // 'paystack', 'mailgun', 'termii'
            $table->string('category', 30);                  // 'payment', 'email', 'sms', 'storage', 'analytics', 'oauth'
            $table->string('display_name', 100);             // 'Paystack Payment Gateway'
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_primary')->default(false);   // Primary for its category
            $table->json('config')->nullable();              // Service-specific config (non-sensitive)
            $table->json('credentials')->nullable();         // Encrypted sensitive data
            $table->string('sandbox_mode', 10)->default('sandbox'); // 'sandbox' | 'production'
            $table->text('last_test_result')->nullable();    // JSON: {success, message, tested_at}
            $table->timestamp('last_tested_at')->nullable();
            $table->integer('priority')->default(0);         // Fallback order
            $table->timestamps();

            $table->unique(['name', 'category']);
            $table->index('category');
            $table->index('is_enabled');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
```

### 3.3 Model Design

#### `Service.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Service extends Model
{
    protected $fillable = [
        'name', 'category', 'display_name', 'is_enabled',
        'is_primary', 'config', 'credentials', 'sandbox_mode',
        'last_test_result', 'last_tested_at', 'priority',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_primary' => 'boolean',
        'config' => 'array',
        'last_test_result' => 'array',
        'last_tested_at' => 'datetime',
    ];

    // ─── Credential Encryption ───────────────────────────

    public function setCredentialsAttribute(array $value): void
    {
        $this->attributes['credentials'] = Crypt::encryptString(json_encode($value));
    }

    public function getCredentialsAttribute(): ?array
    {
        if (empty($this->attributes['credentials'])) {
            return null;
        }
        return json_decode(Crypt::decryptString($this->attributes['credentials']), true);
    }

    /**
     * Get a specific credential value.
     */
    public function getCredential(string $key, mixed $default = null): mixed
    {
        return $this->credentials[$key] ?? $default;
    }

    // ─── Scopes ──────────────────────────────────────────

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // ─── Helpers ─────────────────────────────────────────

    /**
     * Get primary service for a category.
     */
    public static function primary(string $category): ?static
    {
        return static::where('category', $category)
            ->where('is_primary', true)
            ->where('is_enabled', true)
            ->first();
    }

    /**
     * Get all enabled services for a category, ordered by priority.
     */
    public static function enabledFor(string $category): \Illuminate\Support\Collection
    {
        return static::where('category', $category)
            ->where('is_enabled', true)
            ->orderBy('priority')
            ->get();
    }

    /**
     * Record test result.
     */
    public function recordTest(bool $success, string $message): void
    {
        $this->update([
            'last_test_result' => [
                'success' => $success,
                'message' => $message,
                'tested_at' => now()->toISOString(),
            ],
            'last_tested_at' => now(),
        ]);
    }

    /**
     * Check if last test was successful.
     */
    public function lastTestPassed(): bool
    {
        return $this->last_test_result['success'] ?? false;
    }
}
```

### 3.4 Service Interface & Provider Pattern

#### `ServiceInterface.php`
```php
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
```

#### `BaseService.php`
```php
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

    abstract public function validate(): bool;
    abstract public function test(): array;
}
```

### 3.5 Service Implementations

#### Payment Services (refactored from existing)

##### `PaystackService.php`
```php
<?php

namespace App\Services\Payment\Gateways;

use App\Contracts\ServiceInterface;
use App\Models\Service;
use Illuminate\Support\Facades\Http;

class PaystackService extends BaseService implements ServiceInterface
{
    protected string $name = 'paystack';
    protected string $category = 'payment';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('secret_key')->label('Secret Key')->password()->required(),
            TextInput::make('public_key')->label('Public Key')->required(),
            TextInput::make('webhook_secret')->label('Webhook Secret')->password(),
            Toggle::make('test_mode')->label('Test Mode')->default(true),
        ];
    }

    public function validate(): bool
    {
        return $this->getCredential('secret_key') && $this->getCredential('public_key');
    }

    public function test(): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getCredential('secret_key'),
            ])->timeout(10)->get('https://api.paystack.co/transaction/initialize', [
                'email' => 'test@blossom.ng',
                'amount' => 10000, // 100 naira in kobo
            ]);

            if ($response->successful()) {
                return ['success' => true, 'message' => 'Paystack connection successful'];
            }

            return ['success' => false, 'message' => 'Paystack returned: ' . $response->body()];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()];
        }
    }

    public function getBaseUrl(): string
    {
        return $this->isSandbox()
            ? 'https://api.paystack.co'
            : 'https://api.paystack.co';
    }

    public function getSecretKey(): string
    {
        return $this->getCredential('secret_key', '');
    }

    public function getPublicKey(): string
    {
        return $this->getCredential('public_key', '');
    }
}
```

##### Similar implementations for:
- `MonnifyService.php`
- `NombaService.php`

#### Email Service

##### `MailgunService.php`
```php
<?php

namespace App\Services\Email;

use App\Services\BaseService;

class MailgunService extends BaseService
{
    protected string $name = 'mailgun';
    protected string $category = 'email';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('api_key')->label('API Key')->password()->required(),
            TextInput::make('domain')->label('Domain')->required(),
            TextInput::make('from_email')->label('From Email')->email()->required(),
            TextInput::make('from_name')->label('From Name')->required(),
            Select::make('region')->label('Region')->options([
                'us' => 'US',
                'eu' => 'EU',
            ])->default('us'),
        ];
    }

    public function validate(): bool
    {
        return $this->getCredential('api_key') && $this->getCredential('domain');
    }

    public function test(): array
    {
        try {
            $response = Http::withBasicAuth('api', $this->getCredential('api_key'))
                ->get("https://api.mailgun.net/v3/{$this->getCredential('domain')}/stats");

            if ($response->successful()) {
                return ['success' => true, 'message' => 'Mailgun connection successful'];
            }

            return ['success' => false, 'message' => 'Mailgun returned: ' . $response->body()];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()];
        }
    }

    public function sendEmail(string $to, string $subject, string $html): array
    {
        $response = Http::withBasicAuth('api', $this->getCredential('api_key'))
            ->post("https://api.mailgun.net/v3/{$this->getCredential('domain')}/messages", [
                'from' => "{$this->getConfig('from_name')} <{$this->getConfig('from_email')}>",
                'to' => $to,
                'subject' => $subject,
                'html' => $html,
            ]);

        return $response->json();
    }
}
```

#### SMS Service

##### `TermiiService.php`
```php
<?php

namespace App\Services\Sms;

use App\Services\BaseService;

class TermiiService extends BaseService
{
    protected string $name = 'termii';
    protected string $category = 'sms';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('api_key')->label('API Key')->password()->required(),
            TextInput::make('sender_id')->label('Sender ID')->required(),
            Select::make('channel')->label('Channel')->options([
                'dnd' => 'DND',
                'generic' => 'Generic',
            ])->default('dnd'),
            TextInput::make('gateway_url')->label('Gateway URL')
                ->default('https://termii.com/api'),
        ];
    }

    public function validate(): bool
    {
        return $this->getCredential('api_key') && $this->getConfig('sender_id');
    }

    public function test(): array
    {
        try {
            // Send test OTP to a hardcoded test number
            $response = Http::post($this->getConfig('gateway_url', 'https://termii.com/api') . '/sms/send', [
                'api_key' => $this->getCredential('api_key'),
                'to' => '+2348000000000',
                'from' => $this->getConfig('sender_id'),
                'sms' => 'BLOSSOM test message',
                'type' => 'plain',
                'channel' => $this->getConfig('channel', 'dnd'),
            ]);

            if ($response->successful()) {
                return ['success' => true, 'message' => 'Termii connection successful'];
            }

            return ['success' => false, 'message' => 'Termii returned: ' . $response->body()];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()];
        }
    }

    public function sendOtp(string $phone, string $otp): array
    {
        $response = Http::post($this->getConfig('gateway_url', 'https://termii.com/api') . '/sms/send', [
            'api_key' => $this->getCredential('api_key'),
            'to' => $phone,
            'from' => $this->getConfig('sender_id'),
            'sms' => "Your BLOSSOM verification code is: {$otp}",
            'type' => 'plain',
            'channel' => $this->getConfig('channel', 'dnd'),
        ]);

        return $response->json();
    }

    public function generateOtp(int $length = 6): string
    {
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= random_int(0, 9);
        }
        return $otp;
    }
}
```

#### Storage Service

##### `CloudinaryService.php`
```php
<?php

namespace App\Services\Storage;

use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class CloudinaryService extends BaseService
{
    protected string $name = 'cloudinary';
    protected string $category = 'storage';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('cloud_name')->label('Cloud Name')->required(),
            TextInput::make('api_key')->label('API Key')->required(),
            TextInput::make('api_secret')->label('API Secret')->password()->required(),
            TextInput::make('upload_preset')->label('Upload Preset'),
            TextInput::make('folder')->label('Folder')->default('blossom'),
            Toggle::make('auto_optimize')->label('Auto Optimize')->default(true),
        ];
    }

    public function validate(): bool
    {
        return $this->getCredential('cloud_name')
            && $this->getCredential('api_key')
            && $this->getCredential('api_secret');
    }

    public function test(): array
    {
        try {
            $response = Http::get("https://api.cloudinary.com/v1_1/{$this->getCredential('cloud_name')}/ping");

            if ($response->successful()) {
                return ['success' => true, 'message' => 'Cloudinary connection successful'];
            }

            return ['success' => false, 'message' => 'Cloudinary returned: ' . $response->body()];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()];
        }
    }

    public function upload(UploadedFile $file, ?string $folder = null): array
    {
        $folder = $folder ?? $this->getConfig('folder', 'blossom');

        $response = Http::attach('file', file_get_contents($file), $file->getClientOriginalName())
            ->post("https://api.cloudinary.com/v1_1/{$this->getCredential('cloud_name')}/image/upload", [
                'api_key' => $this->getCredential('api_key'),
                'folder' => $folder,
                'upload_preset' => $this->getConfig('upload_preset'),
                'resource_type' => 'auto',
            ]);

        return $response->json();
    }

    public function getOptimizedUrl(string $publicId, array $transforms = []): string
    {
        $defaultTransforms = [
            'quality' => 'auto',
            'fetch_format' => 'auto',
        ];

        $allTransforms = array_merge($defaultTransforms, $transforms);
        $transformString = implode(',', array_map(fn($k, $v) => "{$k}_{$v}", array_keys($allTransforms), array_values($allTransforms)));

        return "https://res.cloudinary.com/{$this->getCredential('cloud_name')}/image/upload/{$transformString}/{$publicId}";
    }
}
```

#### Analytics Service

##### `GoogleAnalyticsService.php`
```php
<?php

namespace App\Services\Analytics;

use App\Services\BaseService;
use Illuminate\Support\Facades\Http;

class GoogleAnalyticsService extends BaseService
{
    protected string $name = 'google_analytics';
    protected string $category = 'analytics';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('property_id')->label('GA4 Property ID')->required(),
            TextInput::make('measurement_id')->label('Measurement ID')->required(),
            TextInput::make('api_secret')->label('API Secret')->password(),
            Toggle::make('enhanced_ecommerce')->label('Enhanced Ecommerce')->default(false),
        ];
    }

    public function validate(): bool
    {
        return $this->getConfig('property_id') && $this->getConfig('measurement_id');
    }

    public function test(): array
    {
        try {
            // GA4 Measurement Protocol test
            $response = Http::post("https://www.google-analytics.com/mp/collect?firebase_debug_mode=true&api_secret={$this->getCredential('api_secret')}", [
                'client_id' => 'test_client_123',
                'events' => [[
                    'name' => 'connection_test',
                    'params' => ['source' => 'blossom_admin'],
                ]],
            ]);

            // GA4 returns 204 on success (no content)
            if ($response->successful() || $response->status() === 204) {
                return ['success' => true, 'message' => 'Google Analytics connection successful'];
            }

            return ['success' => false, 'message' => 'GA returned status: ' . $response->status()];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()];
        }
    }

    public function getMeasurementId(): string
    {
        return $this->getConfig('measurement_id', '');
    }

    public function getPropertyId(): string
    {
        return $this->getConfig('property_id', '');
    }
}
```

#### OAuth Services

##### `GoogleOAuthService.php`
```php
<?php

namespace App\Services\OAuth;

use App\Services\BaseService;

class GoogleOAuthService extends BaseService
{
    protected string $name = 'google';
    protected string $category = 'oauth';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('client_id')->label('Client ID')->required(),
            TextInput::make('client_secret')->label('Client Secret')->password()->required(),
            TextInput::make('redirect_uri')->label('Redirect URI')->url()->required(),
            Toggle::make('enabled')->label('Enable Google Login')->default(true),
        ];
    }

    public function validate(): bool
    {
        return $this->getCredential('client_id') && $this->getCredential('client_secret');
    }

    public function test(): array
    {
        try {
            // Verify the client ID is valid by checking Google's token info endpoint
            $response = Http::get("https://oauth2.googleapis.com/tokeninfo?id_token=test");

            // Even a 400 response means the endpoint is reachable
            if ($response->status() === 400 || $response->successful()) {
                return ['success' => true, 'message' => 'Google OAuth configuration valid'];
            }

            return ['success' => false, 'message' => 'Unexpected response'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()];
        }
    }

    public function getClientId(): string
    {
        return $this->getCredential('client_id', '');
    }

    public function getClientSecret(): string
    {
        return $this->getCredential('client_secret', '');
    }

    public function getRedirectUri(): string
    {
        return $this->getConfig('redirect_uri', route('auth.google.callback'));
    }
}
```

---

## 4. Service Registry & Provider

### `ServiceRegistry.php`
```php
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
        if (!$primary) {
            return null;
        }

        return $this->get($category, $primary->name);
    }

    /**
     * Get all enabled services for a category.
     */
    public function getEnabled(string $category): array
    {
        return Service::enabledFor($category)
            ->map(fn($service) => $this->get($category, $service->name))
            ->filter()
            ->toArray();
    }

    /**
     * Get config schema for a service.
     */
    public function getConfigSchema(string $category, string $name): ?array
    {
        $service = $this->get($category, $name);
        return $service?::getConfigSchema();
    }
}
```

### `ServiceProvider.php` (Laravel)
```php
<?php

namespace App\Providers;

use App\Services\Payment\Gateways\PaystackService;
use App\Services\Payment\Gateways\MonnifyService;
use App\Services\Payment\Gateways\NombaService;
use App\Services\Email\MailgunService;
use App\Services\Sms\TermiiService;
use App\Services\Storage\CloudinaryService;
use App\Services\Analytics\GoogleAnalyticsService;
use App\Services\OAuth\GoogleOAuthService;
use App\Services\OAuth\FacebookOAuthService;
use App\Services\OAuth\TwitterOAuthService;
use App\Services\ServiceRegistry;
use Illuminate\Support\ServiceProvider;

class BlossomServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ServiceRegistry::class, function () {
            $registry = new ServiceRegistry();

            // Payment gateways
            $registry->register('payment', 'paystack', PaystackService::class);
            $registry->register('payment', 'monnify', MonnifyService::class);
            $registry->register('payment', 'nomba', NombaService::class);

            // Email
            $registry->register('email', 'mailgun', MailgunService::class);

            // SMS
            $registry->register('sms', 'termii', TermiiService::class);

            // Storage
            $registry->register('storage', 'cloudinary', CloudinaryService::class);

            // Analytics
            $registry->register('analytics', 'google_analytics', GoogleAnalyticsService::class);

            // OAuth
            $registry->register('oauth', 'google', GoogleOAuthService::class);
            $registry->register('oauth', 'facebook', FacebookOAuthService::class);
            $registry->register('oauth', 'twitter', TwitterOAuthService::class);

            return $registry;
        });

        $this->app->alias(ServiceRegistry::class, 'services');
    }

    public function boot(): void
    {
        //
    }
}
```

---

## 5. Filament Resource Designs

### 5.1 Settings Resource

```
┌─────────────────────────────────────────────────────────────┐
│  FILAMENT SETTINGS PAGE                                     │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐        │
│  │  Site       │  │  SEO        │  │  Pages      │        │
│  └─────────────┘  └─────────────┘  └─────────────┘        │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐        │
│  │  Payments   │  │  Newsletter │  │  Featured   │        │
│  └─────────────┘  └─────────────┘  └─────────────┘        │
│                                                             │
│  Each tab renders a form with fields for that group.        │
│  Fields are dynamically generated from the settings table.  │
└─────────────────────────────────────────────────────────────┘
```

#### `SettingsResource.php`
```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingsResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;

class SettingsResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $navigationLabel = 'Settings';
    protected static ?int $navigationSort = 100;
    protected static ?string $slug = 'settings';

    // Disable default CRUD — we use custom pages
    public static function canCreate(): bool { return false; }
    public static function canDelete(Model $record): bool { return false; }
    public static function canDeleteAny(): bool { return false; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('settings')
                ->tabs([
                    self::siteTab(),
                    self::seoTab(),
                    self::pageContentTab(),
                    self::paymentTab(),
                    self::newsletterTab(),
                    self::featuredTab(),
                ])
                ->activeTab('site'),
        ]);
    }

    // ─── Tab Definitions ────────────────────────────────

    protected static function siteTab(): Forms\Components\Tabs\Tab
    {
        return Forms\Components\Tabs\Tab::make('Site Settings')
            ->icon('heroicon-o-globe-alt')
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('site.name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('site.tagline')
                            ->label('Tagline')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('site.description')
                            ->label('Site Description')
                            ->rows(3),
                    ]),

                Forms\Components\Section::make('Branding')
                    ->schema([
                        Forms\Components\FileUpload::make('site.logo')
                            ->label('Logo')
                            ->image()
                            ->directory('images/logo')
                            ->imageCropAspectRatio('2:1')
                            ->maxSize(2048),
                        Forms\Components\FileUpload::make('site.favicon')
                            ->label('Favicon')
                            ->image()
                            ->directory('images/favicon')
                            ->maxSize(512),
                    ]),

                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('site.contact_email')
                            ->label('Contact Email')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('site.contact_phone')
                            ->label('Contact Phone'),
                        Forms\Components\TextInput::make('site.contact_address')
                            ->label('Address'),
                    ]),

                Forms\Components\Section::make('Social Media')
                    ->schema([
                        Forms\Components\TextInput::make('site.social_twitter')
                            ->label('Twitter URL')
                            ->url(),
                        Forms\Components\TextInput::make('site.social_instagram')
                            ->label('Instagram URL')
                            ->url(),
                        Forms\Components\TextInput::make('site.social_facebook')
                            ->label('Facebook URL')
                            ->url(),
                        Forms\Components\TextInput::make('site.social_linkedin')
                            ->label('LinkedIn URL')
                            ->url(),
                        Forms\Components\TextInput::make('site.social_whatsapp')
                            ->label('WhatsApp URL')
                            ->url(),
                    ]),

                Forms\Components\Section::make('Legal')
                    ->schema([
                        Forms\Components\TextInput::make('site.copyright_text')
                            ->label('Copyright Text'),
                        Forms\Components\TextInput::make('site.company_name')
                            ->label('Company Name'),
                    ]),
            ]);
    }

    protected static function seoTab(): Forms\Components\Tabs\Tab
    {
        return Forms\Components\Tabs\Tab::make('SEO Settings')
            ->icon('heroicon-o-magnifying-glass')
            ->schema([
                Forms\Components\Section::make('Default SEO')
                    ->schema([
                        Forms\Components\TextInput::make('seo.default_title')
                            ->label('Default Meta Title')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('seo.default_description')
                            ->label('Default Meta Description')
                            ->rows(3),
                        Forms\Components\TextInput::make('seo.default_keywords')
                            ->label('Default Keywords')
                            ->helperText('Comma-separated'),
                    ]),

                Forms\Components\Section::make('Google Analytics')
                    ->schema([
                        Forms\Components\TextInput::make('seo.google_analytics_id')
                            ->label('Google Analytics ID')
                            ->placeholder('G-XXXXXXXXXX'),
                    ]),

                Forms\Components\Section::make('Social Sharing')
                    ->schema([
                        Forms\Components\FileUpload::make('seo.social_image')
                            ->label('Default Social Share Image')
                            ->image()
                            ->directory('images/seo')
                            ->imageAspectRatio('1200:630'),
                        Forms\Components\TextInput::make('seo.twitter_handle')
                            ->label('Twitter Handle')
                            ->placeholder('@blossom_mag'),
                    ]),
            ]);
    }

    protected static function pageContentTab(): Forms\Components\Tabs\Tab
    {
        return Forms\Components\Tabs\Tab::make('Page Content')
            ->icon('heroicon-o-document-text')
            ->schema([
                Forms\Components\Tabs::make('pages')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('About Page')
                            ->schema([
                                Forms\Components\RichEditor::make('page.about.mission_text')
                                    ->label('Mission Text'),
                                Forms\Components\RichEditor::make('page.about.founding_story')
                                    ->label('Founding Story'),
                                Forms\Components\Repeater::make('page.about.values')
                                    ->label('Core Values')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')->required(),
                                        Forms\Components\Textarea::make('description')->rows(2),
                                    ])
                                    ->columns(2),
                                Forms\Components\Repeater::make('page.about.team_members')
                                    ->label('Team Members')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')->required(),
                                        Forms\Components\TextInput::make('role'),
                                        Forms\Components\FileUpload::make('photo')
                                            ->image()
                                            ->directory('images/team'),
                                    ])
                                    ->columns(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('Contact Page')
                            ->schema([
                                Forms\Components\TextInput::make('page.contact.response_time_text')
                                    ->label('Response Time Text'),
                                Forms\Components\TextInput::make('page.contact.partnership_email')
                                    ->label('Partnership Email')
                                    ->email(),
                                Forms\Components\Toggle::make('page.contact.form_enabled')
                                    ->label('Contact Form Enabled'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Pricing Page')
                            ->schema([
                                Forms\Components\RichEditor::make('page.pricing.hero_text')
                                    ->label('Hero Text'),
                                Forms\Components\Repeater::make('page.pricing.plans')
                                    ->label('Subscription Plans')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')->required(),
                                        Forms\Components\TextInput::make('price')->numeric(),
                                        Forms\Components\Select::make('interval')
                                            ->options([
                                                'monthly' => 'Monthly',
                                                'yearly' => 'Yearly',
                                                'one-time' => 'One-time',
                                            ]),
                                        Forms\Components\Repeater::make('features')
                                            ->schema([
                                                Forms\Components\TextInput::make('feature')->required(),
                                            ])
                                            ->columns(1),
                                    ])
                                    ->columns(1),
                                Forms\Components\Repeater::make('page.pricing.faq_items')
                                    ->label('FAQ Items')
                                    ->schema([
                                        Forms\Components\TextInput::make('question')->required(),
                                        Forms\Components\Textarea::make('answer')->rows(3),
                                    ])
                                    ->columns(1),
                            ]),
                    ]),
            ]);
    }

    protected static function paymentTab(): Forms\Components\Tabs\Tab
    {
        return Forms\Components\Tabs\Tab::make('Payment Settings')
            ->icon('heroicon-o-credit-card')
            ->schema([
                Forms\Components\Section::make('Payment Configuration')
                    ->schema([
                        Forms\Components\Select::make('payment.default_provider')
                            ->label('Default Provider')
                            ->options([
                                'paystack' => 'Paystack',
                                'monnify' => 'Monnify',
                                'nomba' => 'Nomba',
                            ])
                            ->required(),
                        Forms\Components\Toggle::make('payment.sandbox_mode')
                            ->label('Sandbox Mode')
                            ->helperText('Enable test payments'),
                    ]),

                Forms\Components\Section::make('Subscription Plans')
                    ->schema([
                        Forms\Components\TextInput::make('payment.plans.monthly.price')
                            ->label('Monthly Plan Price (NGN)')
                            ->numeric(),
                        Forms\Components\TextInput::make('payment.plans.monthly.name')
                            ->label('Monthly Plan Name'),
                        Forms\Components\TextInput::make('payment.plans.yearly.price')
                            ->label('Yearly Plan Price (NGN)')
                            ->numeric(),
                        Forms\Components\TextInput::make('payment.plans.yearly.name')
                            ->label('Yearly Plan Name'),
                    ]),

                Forms\Components\Section::make('Listing Tiers')
                    ->schema([
                        Forms\Components\Repeater::make('payment.listing_tiers')
                            ->label('Listing Tiers')
                            ->schema([
                                Forms\Components\TextInput::make('name')->required(),
                                Forms\Components\TextInput::make('price')->numeric(),
                                Forms\Components\Repeater::make('features')
                                    ->schema([
                                        Forms\Components\TextInput::make('feature')->required(),
                                    ])
                                    ->columns(1),
                            ])
                            ->columns(1),
                    ]),
            ]);
    }

    protected static function newsletterTab(): Forms\Components\Tabs\Tab
    {
        return Forms\Components\Tabs\Tab::make('Newsletter Settings')
            ->icon('heroicon-o-envelope')
            ->schema([
                Forms\Components\Section::make('Newsletter Configuration')
                    ->schema([
                        Forms\Components\Toggle::make('newsletter.broadcast_enabled')
                            ->label('Broadcast Enabled'),
                        Forms\Components\TextInput::make('newsletter.batch_size')
                            ->label('Batch Size')
                            ->numeric()
                            ->default(50),
                        Forms\Components\Toggle::make('newsletter.show_count')
                            ->label('Show Subscriber Count'),
                        Forms\Components\TextInput::make('newsletter.count_text')
                            ->label('Count Display Text')
                            ->placeholder('Join 2,000+ readers'),
                    ]),
            ]);
    }

    protected static function featuredTab(): Forms\Components\Tabs\Tab
    {
        return Forms\Components\Tabs\Tab::make('Featured Content')
            ->icon('heroicon-o-star')
            ->schema([
                Forms\Components\Section::make('Hero Section')
                    ->schema([
                        Forms\Components\TextInput::make('featured.hero_title')
                            ->label('Hero Title'),
                        Forms\Components\TextInput::make('featured.hero_subtitle')
                            ->label('Hero Subtitle'),
                        Forms\Components\TextInput::make('featured.hero_category')
                            ->label('Hero Category'),
                        Forms\Components\TextInput::make('featured.hero_author')
                            ->label('Hero Author'),
                        Forms\Components\TextInput::make('featured.hero_read_time')
                            ->label('Read Time'),
                        Forms\Components\FileUpload::make('featured.hero_image')
                            ->label('Hero Image')
                            ->image()
                            ->directory('images/hero')
                            ->imageAspectRatio('16/9'),
                    ]),

                Forms\Components\Section::make('Stats')
                    ->schema([
                        Forms\Components\Repeater::make('featured.stats')
                            ->label('Homepage Stats')
                            ->schema([
                                Forms\Components\TextInput::make('value')
                                    ->label('Value')
                                    ->required(),
                                Forms\Components\TextInput::make('label')
                                    ->label('Label')
                                    ->required(),
                            ])
                            ->columns(2),
                    ]),

                Forms\Components\Section::make('CTA')
                    ->schema([
                        Forms\Components\TextInput::make('featured.cta_title')
                            ->label('CTA Title'),
                        Forms\Components\TextInput::make('featured.cta_subtitle')
                            ->label('CTA Subtitle'),
                    ]),
            ]);
    }

    // ─── Pages ──────────────────────────────────────────

    public static function getPages(): array
    {
        return [
            'index' => Pages\EditSettings::route('/'),
        ];
    }
}
```

### 5.2 Services Resource

#### `ServiceResource.php`
```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-server-stack';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $navigationLabel = 'API Services';
    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Service Information')
                ->schema([
                    Forms\Components\TextInput::make('display_name')
                        ->label('Service Name')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\Select::make('category')
                        ->label('Category')
                        ->options([
                            'payment' => 'Payment Gateway',
                            'email' => 'Email Service',
                            'sms' => 'SMS Service',
                            'storage' => 'Storage Service',
                            'analytics' => 'Analytics',
                            'oauth' => 'OAuth Provider',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('name')
                        ->label('Service Identifier')
                        ->required()
                        ->unique(ignoreRecord: true),
                ]),

            Forms\Components\Section::make('Configuration')
                ->schema([
                    Forms\Components\Toggle::make('is_enabled')
                        ->label('Enabled'),
                    Forms\Components\Toggle::make('is_primary')
                        ->label('Primary Service'),
                    Forms\Components\Select::make('sandbox_mode')
                        ->label('Environment')
                        ->options([
                            'sandbox' => 'Sandbox / Test',
                            'production' => 'Production',
                        ])
                        ->default('sandbox'),
                    Forms\Components\TextInput::make('priority')
                        ->label('Fallback Priority')
                        ->numeric()
                        ->default(0),
                ]),

            Forms\Components\Section::make('Credentials')
                ->schema([
                    Forms\Components\Placeholder::make('credentials_info')
                        ->content('Credentials are encrypted at rest. Enter each key/value pair for this service.')
                        ->columnSpanFull(),
                    // Dynamic credential fields based on service type
                    // These are rendered from the service's getConfigSchema()
                ])
                ->collapsed(),

            Forms\Components\Section::make('Connection Test')
                ->schema([
                    Forms\Components\Placeholder::make('test_result')
                        ->content(fn(?Service $record) => $record?->last_test_result
                            ? ($record->last_test_result['success'] ? '✅ ' : '❌ ') . $record->last_test_result['message']
                            : 'Not tested yet'
                        ),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('display_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn(string $state) => match($state) {
                        'payment' => 'success',
                        'email' => 'info',
                        'sms' => 'warning',
                        'storage' => 'gray',
                        'analytics' => 'primary',
                        'oauth' => 'danger',
                    }),
                Tables\Columns\IconColumn::make('is_enabled')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_primary')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sandbox_mode')
                    ->badge()
                    ->color(fn(string $state) => $state === 'sandbox' ? 'warning' : 'success'),
                Tables\Columns\TextColumn::make('last_tested_at')
                    ->label('Last Tested')
                    ->dateTime()
                    ->placeholder('Never'),
                Tables\Columns\TextColumn::make('last_test_result.success')
                    ->label('Test Result')
                    ->formatStateUsing(fn($state) => $state ? '✅ Passed' : '❌ Failed')
                    ->placeholder('—'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'payment' => 'Payment',
                        'email' => 'Email',
                        'sms' => 'SMS',
                        'storage' => 'Storage',
                        'analytics' => 'Analytics',
                        'oauth' => 'OAuth',
                    ]),
                Tables\Filters\TernaryFilter::make('is_enabled')
                    ->label('Enabled'),
            ])
            ->actions([
                Tables\Actions\Action::make('test')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Test Connection')
                    ->modalDescription('This will send a test request to the service.')
                    ->action(fn(Service $record) => static::testService($record)),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function testService(Service $record): array
    {
        $serviceClass = "App\\Services\\{$record->category}\\" . ucfirst($record->name) . "Service";

        if (!class_exists($serviceClass)) {
            return ['success' => false, 'message' => 'Service class not found'];
        }

        $service = new $serviceClass();
        $result = $service->test();
        $record->recordTest($result['success'], $result['message']);

        return $result;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
```

---

## 6. API Endpoint Design

### 6.1 Settings API (Public)

```
GET  /api/settings/public         → All public settings (for frontend)
GET  /api/settings/public/{group} → Public settings for a group
```

#### `SettingsController.php`
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = Setting::public();

        return response()->json([
            'success' => true,
            'data' => $settings,
        ]);
    }

    public function group(string $group): JsonResponse
    {
        $settings = Setting::group($group);

        return response()->json([
            'success' => true,
            'data' => $settings,
        ]);
    }
}
```

### 6.2 Services API (Admin)

```
GET    /api/admin/services              → List all services
GET    /api/admin/services/{id}         → Get service details
PUT    /api/admin/services/{id}         → Update service config
POST   /api/admin/services/{id}/test    → Test service connection
POST   /api/admin/services/{id}/enable  → Enable service
POST   /api/admin/services/{id}/disable → Disable service
```

#### `ServiceController.php`
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\ServiceRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(
        protected ServiceRegistry $registry
    ) {}

    public function index(): JsonResponse
    {
        $services = Service::all();

        return response()->json([
            'success' => true,
            'data' => $services,
        ]);
    }

    public function show(Service $service): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $service,
        ]);
    }

    public function update(Request $request, Service $service): JsonResponse
    {
        $validated = $request->validate([
            'config' => 'nullable|array',
            'credentials' => 'nullable|array',
            'sandbox_mode' => 'sometimes|in:sandbox,production',
        ]);

        if (isset($validated['credentials'])) {
            $service->credentials = $validated['credentials'];
            unset($validated['credentials']);
        }

        $service->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Service updated',
            'data' => $service,
        ]);
    }

    public function test(Service $service): JsonResponse
    {
        $serviceInstance = $this->registry->get($service->category, $service->name);

        if (!$serviceInstance) {
            return response()->json([
                'success' => false,
                'message' => 'Service implementation not found',
            ], 404);
        }

        $result = $serviceInstance->test();
        $service->recordTest($result['success'], $result['message']);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => [
                'tested_at' => $service->last_tested_at,
                'last_result' => $service->last_test_result,
            ],
        ]);
    }

    public function enable(Service $service): JsonResponse
    {
        $service->update(['is_enabled' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Service enabled',
        ]);
    }

    public function disable(Service $service): JsonResponse
    {
        $service->update(['is_enabled' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Service disabled',
        ]);
    }
}
```

### 6.3 Routes

```php
// routes/api.php

// Public settings
Route::get('/settings/public', [Api\SettingsController::class, 'index']);
Route::get('/settings/public/{group}', [Api\SettingsController::class, 'group']);

// Admin services (protected by auth + admin middleware)
Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/services', [Api\ServiceController::class, 'index']);
    Route::get('/services/{service}', [Api\ServiceController::class, 'show']);
    Route::put('/services/{service}', [Api\ServiceController::class, 'update']);
    Route::post('/services/{service}/test', [Api\ServiceController::class, 'test']);
    Route::post('/services/{service}/enable', [Api\ServiceController::class, 'enable']);
    Route::post('/services/{service}/disable', [Api\ServiceController::class, 'disable']);
});
```

---

## 7. Caching Strategy

### 7.1 Cache Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    CACHING LAYERS                            │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  Layer 1: Application Cache (File/Redis)                    │
│  ┌─────────────────────────────────────────────────────┐   │
│  │  settings.{key}          → Individual setting       │   │
│  │  settings.group.{group}  → All settings in group    │   │
│  │  settings.public         → All public settings      │   │
│  │  settings.all            → All settings             │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  Layer 2: Config Cache (composer.json scripts)              │
│  ┌─────────────────────────────────────────────────────┐   │
│  │  php artisan blossom:settings:cache                  │   │
│  │  → Generates config/blossom-settings.php             │   │
│  │  → Used by services reading config('blossom.*')     │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  Layer 3: Blade Template Cache                              │
│  ┌─────────────────────────────────────────────────────┐   │
│  │  @php $settings = Setting::public(); @endphp         │   │
│  │  → Cached per request via static::public()          │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  Invalidation:                                              │
│  • On settings save → flush affected cache keys             │
│  • On service update → flush service cache                  │
│  • artisan blossom:settings:clear → flush all               │
│  • TTL: 24 hours (with manual invalidation)                 │
└─────────────────────────────────────────────────────────────┘
```

### 7.2 Cache Commands

#### `SettingsCacheCommand.php`
```php
<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class SettingsCacheCommand extends Command
{
    protected $signature = 'blossom:settings:cache';
    protected $description = 'Cache settings to config file for performance';

    public function handle(): int
    {
        $settings = Setting::all();

        $grouped = $settings->groupBy('group')->map(function ($groupSettings) {
            return $groupSettings->mapWithKeys(fn($s) => [
                str_replace($s->group . '.', '', $s->key) => $s->castValue(),
            ])->toArray();
        });

        $configPath = config_path('blossom-settings.php');
        $content = "<?php\n\nreturn " . var_export($grouped->toArray(), true) . ";\n";

        file_put_contents($configPath, $content);

        $this->info("Settings cached to {$configPath}");
        return Command::SUCCESS;
    }
}
```

#### `SettingsClearCommand.php`
```php
<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class SettingsClearCommand extends Command
{
    protected $signature = 'blossom:settings:clear';
    protected $description = 'Clear all settings cache';

    public function handle(): int
    {
        Setting::flushCache();

        if (file_exists(config_path('blossom-settings.php'))) {
            unlink(config_path('blossom-settings.php'));
        }

        $this->info('Settings cache cleared');
        return Command::SUCCESS;
    }
}
```

### 7.3 Event-Driven Invalidation

```php
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
```

---

## 8. Security Considerations

### 8.1 Credential Encryption

```
┌─────────────────────────────────────────────────────────────┐
│                    SECURITY ARCHITECTURE                     │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  1. ENCRYPTION AT REST                                      │
│     • All service credentials encrypted via Laravel          │
│       Crypt::encryptString() (AES-256-CBC)                  │
│     • Encryption key in APP_KEY (.env)                      │
│     • Credentials column uses longText for encrypted data   │
│                                                             │
│  2. ACCESS CONTROL                                           │
│     • Settings page: admin role only                        │
│     • Services page: super_admin role only                  │
│     • API endpoints: admin middleware required              │
│     • Public settings: no auth required                     │
│                                                             │
│  3. AUDIT TRAIL                                              │
│     • All setting changes logged with user_id               │
│     • Service credential changes logged                     │
│     • Connection test results stored                        │
│                                                             │
│  4. VALIDATION                                               │
│     • URL validation for social links                       │
│     • Email validation for contact fields                   │
│     • File type/size validation for uploads                 │
│     • Input sanitization for all text fields                │
│                                                             │
│  5. RATE LIMITING                                            │
│     • Connection test: 10 requests/minute                   │
│     • Settings API: 60 requests/minute                      │
│     • Service API: 30 requests/minute                       │
└─────────────────────────────────────────────────────────────┘
```

### 8.2 Admin Role Middleware

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}
```

### 8.3 Settings Seed with Defaults

#### `SettingsSeeder.php`
```php
<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Site Settings
            ['group' => 'site', 'key' => 'site.name', 'value' => 'BLOSSOM Magazine', 'type' => 'text', 'label' => 'Site Name', 'is_public' => true],
            ['group' => 'site', 'key' => 'site.tagline', 'value' => "Plateau's Prestige Magazine", 'type' => 'text', 'label' => 'Tagline', 'is_public' => true],
            ['group' => 'site', 'key' => 'site.description', 'value' => 'Celebrating the people, culture, heritage, and achievements of Plateau State.', 'type' => 'text', 'label' => 'Description', 'is_public' => true],
            ['group' => 'site', 'key' => 'site.contact_email', 'value' => 'hello@blossom.ng', 'type' => 'text', 'label' => 'Contact Email', 'is_public' => true],
            ['group' => 'site', 'key' => 'site.contact_phone', 'value' => '+234 800 000 0000', 'type' => 'text', 'label' => 'Contact Phone', 'is_public' => true],
            ['group' => 'site', 'key' => 'site.contact_address', 'value' => 'Jos, Plateau State, Nigeria', 'type' => 'text', 'label' => 'Address', 'is_public' => true],
            ['group' => 'site', 'key' => 'site.copyright_text', 'value' => '© 2026 BLOSSOM Magazine', 'type' => 'text', 'label' => 'Copyright', 'is_public' => true],
            ['group' => 'site', 'key' => 'site.company_name', 'value' => 'BLOSSOM Media Ltd', 'type' => 'text', 'label' => 'Company Name', 'is_public' => true],
            ['group' => 'site', 'key' => 'site.social_twitter', 'value' => 'https://twitter.com/blossom', 'type' => 'text', 'label' => 'Twitter URL', 'is_public' => true],
            ['group' => 'site', 'key' => 'site.social_instagram', 'value' => 'https://instagram.com/blossom', 'type' => 'text', 'label' => 'Instagram URL', 'is_public' => true],
            ['group' => 'site', 'key' => 'site.social_facebook', 'value' => 'https://facebook.com/blossom', 'type' => 'text', 'label' => 'Facebook URL', 'is_public' => true],
            ['group' => 'site', 'key' => 'site.social_linkedin', 'value' => 'https://linkedin.com/company/blossom', 'type' => 'text', 'label' => 'LinkedIn URL', 'is_public' => true],

            // SEO Settings
            ['group' => 'seo', 'key' => 'seo.default_title', 'value' => "BLOSSOM — Plateau's Prestige Magazine", 'type' => 'text', 'label' => 'Default Title', 'is_public' => true],
            ['group' => 'seo', 'key' => 'seo.default_description', 'value' => 'Celebrating the people, culture, heritage, and achievements of Plateau State.', 'type' => 'text', 'label' => 'Default Description', 'is_public' => true],
            ['group' => 'seo', 'key' => 'seo.google_analytics_id', 'value' => '', 'type' => 'text', 'label' => 'GA ID', 'is_public' => true],

            // Newsletter Settings
            ['group' => 'newsletter', 'key' => 'newsletter.broadcast_enabled', 'value' => 'true', 'type' => 'boolean', 'label' => 'Broadcast Enabled', 'is_public' => true],
            ['group' => 'newsletter', 'key' => 'newsletter.batch_size', 'value' => '50', 'type' => 'number', 'label' => 'Batch Size', 'is_public' => false],
            ['group' => 'newsletter', 'key' => 'newsletter.show_count', 'value' => 'true', 'type' => 'boolean', 'label' => 'Show Count', 'is_public' => true],
            ['group' => 'newsletter', 'key' => 'newsletter.count_text', 'value' => 'Join 2,000+ readers', 'type' => 'text', 'label' => 'Count Text', 'is_public' => true],

            // Payment Settings
            ['group' => 'payment', 'key' => 'payment.default_provider', 'value' => 'paystack', 'type' => 'text', 'label' => 'Default Provider', 'is_public' => false],
            ['group' => 'payment', 'key' => 'payment.sandbox_mode', 'value' => 'true', 'type' => 'boolean', 'label' => 'Sandbox Mode', 'is_public' => false],
            ['group' => 'payment', 'key' => 'payment.plans.monthly.price', 'value' => '2500', 'type' => 'number', 'label' => 'Monthly Price', 'is_public' => true],
            ['group' => 'payment', 'key' => 'payment.plans.monthly.name', 'value' => 'Insider Monthly', 'type' => 'text', 'label' => 'Monthly Name', 'is_public' => true],
            ['group' => 'payment', 'key' => 'payment.plans.yearly.price', 'value' => '20000', 'type' => 'number', 'label' => 'Yearly Price', 'is_public' => true],
            ['group' => 'payment', 'key' => 'payment.plans.yearly.name', 'value' => 'Patron Annual', 'type' => 'text', 'label' => 'Yearly Name', 'is_public' => true],

            // Featured Content
            ['group' => 'featured', 'key' => 'featured.hero_title', 'value' => "The Remarkable Story of Plateau's Cultural Renaissance", 'type' => 'text', 'label' => 'Hero Title', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.hero_subtitle', 'value' => 'From the ancient rhythms of Nzem Berom to the modern art scene reshaping Jos.', 'type' => 'text', 'label' => 'Hero Subtitle', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.hero_category', 'value' => 'Culture & Heritage', 'type' => 'text', 'label' => 'Hero Category', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.cta_title', 'value' => 'Stay Connected to Plateau', 'type' => 'text', 'label' => 'CTA Title', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.cta_subtitle', 'value' => 'Get the best stories, news, and insights from BLOSSOM delivered to your inbox every week.', 'type' => 'text', 'label' => 'CTA Subtitle', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.stats', 'value' => json_encode([
                ['value' => '500+', 'label' => 'Articles Published'],
                ['value' => '50K', 'label' => 'Monthly Readers'],
                ['value' => '200+', 'label' => 'Featured Personalities'],
                ['value' => '12', 'label' => 'Content Categories'],
            ]), 'type' => 'json', 'label' => 'Stats', 'is_public' => true],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Settings seeded: ' . count($settings) . ' records');
    }
}
```

### Services Seeder

#### `ServicesSeeder.php`
```php
<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Payment Gateways
            [
                'name' => 'paystack',
                'category' => 'payment',
                'display_name' => 'Paystack',
                'is_enabled' => true,
                'is_primary' => true,
                'sandbox_mode' => 'sandbox',
                'priority' => 0,
            ],
            [
                'name' => 'monnify',
                'category' => 'payment',
                'display_name' => 'Monnify (Moniepoint)',
                'is_enabled' => false,
                'is_primary' => false,
                'sandbox_mode' => 'sandbox',
                'priority' => 1,
            ],
            [
                'name' => 'nomba',
                'category' => 'payment',
                'display_name' => 'Nomba (OPay)',
                'is_enabled' => false,
                'is_primary' => false,
                'sandbox_mode' => 'sandbox',
                'priority' => 2,
            ],

            // Email
            [
                'name' => 'mailgun',
                'category' => 'email',
                'display_name' => 'Mailgun',
                'is_enabled' => false,
                'is_primary' => true,
                'sandbox_mode' => 'sandbox',
                'priority' => 0,
            ],

            // SMS
            [
                'name' => 'termii',
                'category' => 'sms',
                'display_name' => 'Termii',
                'is_enabled' => false,
                'is_primary' => true,
                'sandbox_mode' => 'sandbox',
                'priority' => 0,
            ],

            // Storage
            [
                'name' => 'cloudinary',
                'category' => 'storage',
                'display_name' => 'Cloudinary',
                'is_enabled' => false,
                'is_primary' => true,
                'sandbox_mode' => 'sandbox',
                'priority' => 0,
            ],

            // Analytics
            [
                'name' => 'google_analytics',
                'category' => 'analytics',
                'display_name' => 'Google Analytics',
                'is_enabled' => false,
                'is_primary' => true,
                'sandbox_mode' => 'production',
                'priority' => 0,
            ],

            // OAuth
            [
                'name' => 'google',
                'category' => 'oauth',
                'display_name' => 'Google',
                'is_enabled' => false,
                'is_primary' => true,
                'sandbox_mode' => 'production',
                'priority' => 0,
            ],
            [
                'name' => 'facebook',
                'category' => 'oauth',
                'display_name' => 'Facebook',
                'is_enabled' => false,
                'is_primary' => false,
                'sandbox_mode' => 'production',
                'priority' => 1,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name'], 'category' => $service['category']],
                $service
            );
        }

        $this->command->info('Services seeded: ' . count($services) . ' records');
    }
}
```

---

## 9. Frontend Integration

### 9.1 Blade Helper

```php
// app/Helpers/SettingsHelper.php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get a setting value.
     * Usage: {{ setting('site.name') }}
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('setting_group')) {
    /**
     * Get all settings for a group.
     * Usage: @php $site = setting_group('site'); @endphp
     */
    function setting_group(string $group): array
    {
        return Setting::group($group);
    }
}

if (!function_exists('social_links')) {
    /**
     * Get all social links.
     */
    function social_links(): array
    {
        return Setting::group('site')
            ->filter(fn($value, $key) => str_starts_with($key, 'site.social_'))
            ->mapWithKeys(fn($value, $key) => [
                str_replace('site.social_', '', $key) => $value,
            ])
            ->toArray();
    }
}
```

### 9.2 Dynamic Home Page Example

```blade
{{-- resources/views/pages/home.blade.php (updated) --}}

@extends('layouts.app')

@section('title', setting('site.name') . ' — ' . setting('site.tagline'))
@section('metaDescription', setting('seo.default_description'))

@section('content')

{{-- HERO — Now Dynamic --}}
<section class="hero-section">
    <div class="hero-image-wrapper">
        <img src="{{ setting('featured.hero_image', asset('assets/hero-family.jpg')) }}"
             alt="{{ setting('site.name') }}"
             class="hero-image parallax-slow"
             loading="eager">
        <div class="hero-overlay"></div>
    </div>

    <div class="hero-content">
        <div class="max-w-3xl">
            <span class="hero-category-pill category-pill category-pill--green mb-6 inline-block">
                {{ setting('featured.hero_category', 'Culture & Heritage') }}
            </span>

            <h1 class="hero-title font-display text-white text-4xl md:text-5xl lg:text-6xl font-bold leading-[1.1] mb-6 tracking-tight">
                {{ setting('featured.hero_title', 'Welcome to BLOSSOM') }}
            </h1>

            <p class="hero-deck font-body text-white/80 text-lg md:text-xl leading-relaxed mb-8 max-w-2xl">
                {{ setting('featured.hero_subtitle', 'Plateau\'s Prestige Magazine') }}
            </p>

            <div class="hero-meta flex flex-wrap items-center gap-4 text-white/60 font-ui text-sm mb-8">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-onion/40 border border-white/20 flex items-center justify-center text-white text-xs font-semibold">
                        {{ strtoupper(substr(setting('featured.hero_author', 'B'), 0, 1)) }}
                    </div>
                    <span>{{ setting('featured.hero_author', 'BLOSSOM Team') }}</span>
                </div>
                <span class="hidden sm:inline text-white/30">·</span>
                <span>{{ setting('featured.hero_read_time', '5 min') }} read</span>
            </div>
        </div>
    </div>
</section>

{{-- STATS BAR — Now Dynamic --}}
<section class="py-16 border-t border-b border-silver bg-snow">
    <div class="container-blossom">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center stagger-children">
            @php
                $stats = json_decode(setting('featured.stats', '[]'), true) ?? [
                    ['value' => '500+', 'label' => 'Articles Published'],
                    ['value' => '50K', 'label' => 'Monthly Readers'],
                    ['value' => '200+', 'label' => 'Featured Personalities'],
                    ['value' => '12', 'label' => 'Content Categories'],
                ];
            @endphp

            @foreach($stats as $stat)
                <div>
                    <div class="font-display text-3xl md:text-4xl font-bold text-onion">{{ $stat['value'] }}</div>
                    <div class="font-ui text-sm text-muted mt-1">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- NEWSLETTER CTA — Now Dynamic --}}
<section class="py-20">
    <div class="container-blossom">
        <div class="newsletter-cta p-10 md:p-16 text-center relative z-10 reveal-scale">
            <h2 class="font-display text-3xl md:text-4xl font-bold text-white mb-4">
                {{ setting('featured.cta_title', 'Stay Connected to Plateau') }}
            </h2>
            <p class="font-body text-white/60 text-lg mb-8 max-w-lg mx-auto">
                {{ setting('featured.cta_subtitle', 'Get the best stories delivered to your inbox.') }}
            </p>

            <div class="max-w-md mx-auto">
                <livewire:newsletter-subscribe />
            </div>

            @if(setting('newsletter.show_count', true))
                <p class="font-ui text-xs text-white/30 mt-4">
                    {{ setting('newsletter.count_text', 'No spam. Unsubscribe anytime.') }}
                </p>
            @endif
        </div>
    </div>
</section>

@endsection
```

---

## 10. Implementation Priority Order

### Phase 1: Foundation (Week 1)
1. ✅ Create `settings` migration
2. ✅ Create `Setting` model with caching
3. ✅ Create `SettingsSeeder` with all defaults
4. ✅ Register `SettingsObserver` for cache invalidation
5. ✅ Create `setting()` and `setting_group()` helpers
6. ✅ Add Settings resource to Filament admin

### Phase 2: Services Infrastructure (Week 2)
1. ✅ Create `services` migration
2. ✅ Create `Service` model with encryption
3. ✅ Create `ServiceInterface` and `BaseService`
4. ✅ Create `ServiceRegistry`
5. ✅ Create `BlossomServiceProvider`
6. ✅ Create `ServicesSeeder`
7. ✅ Add Services resource to Filament admin

### Phase 3: Service Implementations (Week 3)
1. ✅ Refactor `PaystackGateway` → `PaystackService`
2. ✅ Create `MonnifyService`, `NombaService`
3. ✅ Create `MailgunService`
4. ✅ Create `TermiiService`
5. ✅ Create `CloudinaryService`
6. ✅ Create `GoogleAnalyticsService`
7. ✅ Create OAuth services (Google, Facebook, Twitter)

### Phase 4: Frontend Integration (Week 4)
1. ✅ Update all Blade templates to use `setting()` helper
2. ✅ Update `PaymentService` to read from database
3. ✅ Create API endpoints for public settings
4. ✅ Update SEO meta tags from settings
5. ✅ Update navigation/footer from settings

### Phase 5: Polish & Testing (Week 5)
1. ✅ Cache warm command
2. ✅ Connection test UI
3. ✅ Audit logging
4. ✅ Security audit
5. ✅ Performance testing
6. ✅ Documentation

---

## 11. Migration Summary

### New Files to Create

```
database/migrations/
├── 2024_01_01_000010_create_settings_table.php
└── 2024_01_01_000011_create_services_table.php

app/Models/
├── Setting.php
└── Service.php

app/Contracts/
└── ServiceInterface.php

app/Services/
├── BaseService.php
├── ServiceRegistry.php
├── Payment/
│   └── Gateways/
│       ├── PaystackService.php
│       ├── MonnifyService.php
│       └── NombaService.php
├── Email/
│   └── MailgunService.php
├── Sms/
│   └── TermiiService.php
├── Storage/
│   └── CloudinaryService.php
├── Analytics/
│   └── GoogleAnalyticsService.php
└── OAuth/
    ├── GoogleOAuthService.php
    ├── FacebookOAuthService.php
    └── TwitterOAuthService.php

app/Filament/Resources/
├── SettingsResource.php
├── SettingsResource/Pages/
│   └── EditSettings.php
├── ServiceResource.php
└── ServiceResource/Pages/
    ├── ListServices.php
    ├── CreateService.php
    └── EditService.php

app/Http/Controllers/Api/
├── SettingsController.php
└── ServiceController.php

app/Observers/
└── SettingObserver.php

app/Console/Commands/
├── SettingsCacheCommand.php
├── SettingsClearCommand.php
└── SettingsSeedCommand.php

app/Helpers/
└── SettingsHelper.php

database/seeders/
├── SettingsSeeder.php
└── ServicesSeeder.php

routes/
└── api.php (add routes)

config/
└── blossom-settings.php (generated by cache command)
```

---

## 12. Appendix: File Structure

```
app/
├── Contracts/
│   └── ServiceInterface.php
├── Helpers/
│   └── SettingsHelper.php
├── Models/
│   ├── Setting.php
│   └── Service.php
├── Observers/
│   └── SettingObserver.php
├── Services/
│   ├── BaseService.php
│   ├── ServiceRegistry.php
│   ├── Payment/
│   │   └── Gateways/
│   │       ├── PaystackService.php
│   │       ├── MonnifyService.php
│   │       └── NombaService.php
│   ├── Email/
│   │   └── MailgunService.php
│   ├── Sms/
│   │   └── TermiiService.php
│   ├── Storage/
│   │   └── CloudinaryService.php
│   ├── Analytics/
│   │   └── GoogleAnalyticsService.php
│   └── OAuth/
│       ├── GoogleOAuthService.php
│       ├── FacebookOAuthService.php
│       └── TwitterOAuthService.php
├── Filament/Resources/
│   ├── SettingsResource.php
│   ├── SettingsResource/Pages/
│   │   └── EditSettings.php
│   ├── ServiceResource.php
│   └── ServiceResource/Pages/
│       ├── ListServices.php
│       ├── CreateService.php
│       └── EditService.php
├── Http/Controllers/Api/
│   ├── SettingsController.php
│   └── ServiceController.php
├── Console/Commands/
│   ├── SettingsCacheCommand.php
│   └── SettingsClearCommand.php
└── Providers/
    └── BlossomServiceProvider.php

database/
├── migrations/
│   ├── 2024_01_01_000010_create_settings_table.php
│   └── 2024_01_01_000011_create_services_table.php
└── seeders/
    ├── SettingsSeeder.php
    └── ServicesSeeder.php

config/
└── blossom-settings.php (generated)

routes/
└── api.php (add routes)
```

---

*End of Design Document*
