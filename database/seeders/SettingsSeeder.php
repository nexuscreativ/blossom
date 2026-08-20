<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ─── Site Settings ────────────────────────────
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

            // ─── SEO Settings ─────────────────────────────
            ['group' => 'seo', 'key' => 'seo.default_title', 'value' => "BLOSSOM — Plateau's Prestige Magazine", 'type' => 'text', 'label' => 'Default Title', 'is_public' => true],
            ['group' => 'seo', 'key' => 'seo.default_description', 'value' => 'Celebrating the people, culture, heritage, and achievements of Plateau State.', 'type' => 'text', 'label' => 'Default Description', 'is_public' => true],
            ['group' => 'seo', 'key' => 'seo.google_analytics_id', 'value' => '', 'type' => 'text', 'label' => 'GA ID', 'is_public' => true],
            ['group' => 'seo', 'key' => 'seo.twitter_handle', 'value' => '@blossom_mag', 'type' => 'text', 'label' => 'Twitter Handle', 'is_public' => true],

            // ─── Newsletter Settings ───────────────────────
            ['group' => 'newsletter', 'key' => 'newsletter.broadcast_enabled', 'value' => 'true', 'type' => 'boolean', 'label' => 'Broadcast Enabled', 'is_public' => true],
            ['group' => 'newsletter', 'key' => 'newsletter.batch_size', 'value' => '50', 'type' => 'number', 'label' => 'Batch Size', 'is_public' => false],
            ['group' => 'newsletter', 'key' => 'newsletter.show_count', 'value' => 'true', 'type' => 'boolean', 'label' => 'Show Count', 'is_public' => true],
            ['group' => 'newsletter', 'key' => 'newsletter.count_text', 'value' => 'Join 2,000+ readers', 'type' => 'text', 'label' => 'Count Text', 'is_public' => true],

            // ─── Payment Settings ──────────────────────────
            ['group' => 'payment', 'key' => 'payment.default_provider', 'value' => 'paystack', 'type' => 'text', 'label' => 'Default Provider', 'is_public' => false],
            ['group' => 'payment', 'key' => 'payment.sandbox_mode', 'value' => 'true', 'type' => 'boolean', 'label' => 'Sandbox Mode', 'is_public' => false],
            ['group' => 'payment', 'key' => 'payment.fallback_order', 'value' => json_encode(['paystack', 'monnify', 'nomba']), 'type' => 'json', 'label' => 'Fallback Order', 'is_public' => false],
            ['group' => 'payment', 'key' => 'payment.plans.monthly.price', 'value' => '2500', 'type' => 'number', 'label' => 'Monthly Price', 'is_public' => true],
            ['group' => 'payment', 'key' => 'payment.plans.monthly.name', 'value' => 'Insider Monthly', 'type' => 'text', 'label' => 'Monthly Name', 'is_public' => true],
            ['group' => 'payment', 'key' => 'payment.plans.yearly.price', 'value' => '20000', 'type' => 'number', 'label' => 'Yearly Price', 'is_public' => true],
            ['group' => 'payment', 'key' => 'payment.plans.yearly.name', 'value' => 'Patron Annual', 'type' => 'text', 'label' => 'Yearly Name', 'is_public' => true],
            ['group' => 'payment', 'key' => 'payment.listing_tiers', 'value' => json_encode([
                ['name' => 'Standard', 'price' => 0, 'features' => ['Basic listing', '1 listing per month']],
                ['name' => 'Featured', 'price' => 15000, 'currency' => 'NGN', 'interval' => 'monthly', 'features' => ['Featured placement', '5 listings', 'Priority support']],
                ['name' => 'Premium', 'price' => 35000, 'currency' => 'NGN', 'interval' => 'monthly', 'features' => ['Top placement', 'Unlimited listings', 'Premium badge', 'Dedicated support']],
            ]), 'type' => 'json', 'label' => 'Listing Tiers', 'is_public' => true],

            // ─── Featured Content ──────────────────────────
            ['group' => 'featured', 'key' => 'featured.hero_title', 'value' => "The Remarkable Story of Plateau's Cultural Renaissance", 'type' => 'text', 'label' => 'Hero Title', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.hero_subtitle', 'value' => 'From the ancient rhythms of Nzem Berom to the modern art scene reshaping Jos, discover how Plateau State is writing its next chapter.', 'type' => 'text', 'label' => 'Hero Subtitle', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.hero_category', 'value' => 'Culture & Heritage', 'type' => 'text', 'label' => 'Hero Category', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.hero_author', 'value' => 'Amina Bello', 'type' => 'text', 'label' => 'Hero Author', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.hero_read_time', 'value' => '8 min', 'type' => 'text', 'label' => 'Hero Read Time', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.cta_title', 'value' => 'Stay Connected to Plateau', 'type' => 'text', 'label' => 'CTA Title', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.cta_subtitle', 'value' => 'Get the best stories, news, and insights from BLOSSOM delivered to your inbox every week.', 'type' => 'text', 'label' => 'CTA Subtitle', 'is_public' => true],
            ['group' => 'featured', 'key' => 'featured.stats', 'value' => json_encode([
                ['value' => '500+', 'label' => 'Articles Published'],
                ['value' => '50K', 'label' => 'Monthly Readers'],
                ['value' => '200+', 'label' => 'Featured Personalities'],
                ['value' => '12', 'label' => 'Content Categories'],
            ]), 'type' => 'json', 'label' => 'Stats', 'is_public' => true],

            // ─── About Page ────────────────────────────────
            ['group' => 'page', 'key' => 'page.about.mission_text', 'value' => "Founded in 2024, BLOSSOM Magazine was born from a simple belief: Plateau State has stories worth telling — stories of resilience, innovation, culture, and beauty that deserve a premium platform.", 'type' => 'text', 'label' => 'Mission Text', 'is_public' => true],
            ['group' => 'page', 'key' => 'page.about.founding_story', 'value' => 'We are a team of journalists, designers, and storytellers united by our love for the Jos Plateau and our commitment to showcasing its best to the world.', 'type' => 'text', 'label' => 'Founding Story', 'is_public' => true],
            ['group' => 'page', 'key' => 'page.about.values', 'value' => json_encode([
                ['title' => 'Authenticity', 'description' => 'Every story we tell is rooted in truth.'],
                ['title' => 'Excellence', 'description' => 'Premium storytelling meets premium design.'],
                ['title' => 'Community', 'description' => 'We exist to connect Plateau people everywhere.'],
            ]), 'type' => 'json', 'label' => 'Values', 'is_public' => true],
            ['group' => 'page', 'key' => 'page.about.team_members', 'value' => json_encode([
                ['name' => 'Dung Gyang', 'role' => 'Editor-in-Chief'],
                ['name' => 'Amina Bello', 'role' => 'Features Editor'],
                ['name' => 'Ibrahim Musa', 'role' => 'Culture Editor'],
                ['name' => 'Grace Pam', 'role' => 'Digital Director'],
            ]), 'type' => 'json', 'label' => 'Team Members', 'is_public' => true],

            // ─── Contact Page ──────────────────────────────
            ['group' => 'page', 'key' => 'page.contact.response_time_text', 'value' => 'We typically respond within 24 hours.', 'type' => 'text', 'label' => 'Response Time Text', 'is_public' => true],
            ['group' => 'page', 'key' => 'page.contact.partnership_email', 'value' => 'partnerships@blossom.ng', 'type' => 'text', 'label' => 'Partnership Email', 'is_public' => true],
            ['group' => 'page', 'key' => 'page.contact.form_enabled', 'value' => 'true', 'type' => 'boolean', 'label' => 'Contact Form Enabled', 'is_public' => true],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Settings seeded: '.count($settings).' records');
    }
}
