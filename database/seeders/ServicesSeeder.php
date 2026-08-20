<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // ─── Payment Gateways ─────────────────────────
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

            // ─── Email ────────────────────────────────────
            [
                'name' => 'mailgun',
                'category' => 'email',
                'display_name' => 'Mailgun',
                'is_enabled' => false,
                'is_primary' => true,
                'sandbox_mode' => 'sandbox',
                'priority' => 0,
            ],

            // ─── SMS ──────────────────────────────────────
            [
                'name' => 'termii',
                'category' => 'sms',
                'display_name' => 'Termii',
                'is_enabled' => false,
                'is_primary' => true,
                'sandbox_mode' => 'sandbox',
                'priority' => 0,
            ],

            // ─── Storage ──────────────────────────────────
            [
                'name' => 'cloudinary',
                'category' => 'storage',
                'display_name' => 'Cloudinary',
                'is_enabled' => false,
                'is_primary' => true,
                'sandbox_mode' => 'sandbox',
                'priority' => 0,
            ],

            // ─── Analytics ────────────────────────────────
            [
                'name' => 'google_analytics',
                'category' => 'analytics',
                'display_name' => 'Google Analytics',
                'is_enabled' => false,
                'is_primary' => true,
                'sandbox_mode' => 'production',
                'priority' => 0,
            ],

            // ─── OAuth ────────────────────────────────────
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
            [
                'name' => 'twitter',
                'category' => 'oauth',
                'display_name' => 'Twitter / X',
                'is_enabled' => false,
                'is_primary' => false,
                'sandbox_mode' => 'production',
                'priority' => 2,
            ],

            // ─── Chat / Support Channels ────────────────
            [
                'name' => 'respondio',
                'category' => 'chat',
                'display_name' => 'respond.io (WhatsApp / Telegram / Voice)',
                'is_enabled' => false,
                'is_primary' => true,
                'sandbox_mode' => 'sandbox',
                'priority' => 0,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name'], 'category' => $service['category']],
                $service
            );
        }

        $this->command->info('Services seeded: '.count($services).' records');
    }
}
