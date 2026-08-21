# BLOSSOM — Global Stories, Nigerian Soul

> Nigerian vibes, global reach, Plateau roots.

BLOSSOM is a production-ready digital magazine platform built with **Laravel 11**, **Filament 3 (v4)**, **Livewire 3**, and **Tailwind CSS 4**. It ships with a **zero-configuration web installer**, a full editorial content system, subscription billing, a newsletter engine, a community feed, and an **AI support chatbot with human-in-the-loop (HITL) escalation** across the web, WhatsApp, Telegram, and voice.

The platform is **domain-agnostic**: install it once and run any niche magazine — the installer auto-detects your URL, builds your database, seeds content, and creates the admin account.

![Laravel](https://img.shields.io/badge/Laravel-11.x-%23FF2D20?style=flat-square&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-v4-%23FBBF24?style=flat-square)
![Livewire](https://img.shields.io/badge/Livewire-3.x-%234e56a6?style=flat-square)
![Tailwind](https://img.shields.io/badge/Tailwind%20CSS-4-%2306B6D4?style=flat-square&logo=tailwindcss&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-%23777BB4?style=flat-square&logo=php&logoColor=white)

---

## ✨ Key Features

### 🗞️ Editorial Platform
- **Articles** — rich editorial content with categories, tags, featured & premium gating
- **Events** — upcoming events directory with date, venue, and showcase cards
- **Listings** — business/community directory with featured tiers and reviews
- **Comments, Likes & Bookmarks** — reader engagement throughout the site
- **SEO defaults** — configurable titles, descriptions, and Google Analytics ID
- **Premium paywall** — premium articles redirect to the subscription/pricing page

### 💳 Subscriptions & Payments
- **Plans & Checkout** — Livewire-powered subscription checkout
- **Three Nigerian providers** behind one clean service layer: **Paystack**, **Monnify**, **Nomba**
- **Webhook & callback handling** — payment verification and provider-agnostic flows
- **Transactions ledger** — full payment history in the admin panel

### 📧 Newsletter Engine
- **Signup widget** with live subscriber count
- **Broadcast management** — batching, scheduling, and delivery via queued jobs
- **Livewire `NewsletterSubscribe`** component, **`SendNewsletterJob`** queue worker, unsubscribe tokens

### 🏘️ Community
- **Community feed** — members share posts, comment, and like
- **Newsletter subscribe**, **contact form**, and full legal pages (terms, privacy, cookies, accessibility)

### 🤖 AI Support Chatbot + HITL
- **Web chat widget** on every public page with typing indicators and escalation notes
- **AI engine** via **OpenRouter** (any model — default `openai/gpt-4o-mini`) grounded in your **live site data** (articles, events, listings, site settings)
- **Rule-based fallback** — the bot answers common questions (pricing, contact, location, hours, articles, events…) even with **no API key configured**
- **Channels** — web widget + **WhatsApp / Telegram / Voice** through **respond.io**
- **Human-in-the-loop inbox** — escalated chats land in the Filament admin **Chat Inbox**: read transcripts, reply as agent, resolve or reopen
- **Webhook endpoint** `/webhooks/respondio` with HMAC signature verification

### ⚙️ Domain-Agnostic Auto-Installer
- Visit any domain → installer **auto-detects `APP_URL`** from the request
- **SQLite by default (zero config)** with optional MySQL / Postgres
- Runs **environment checks** (blocking + advisory), tests the DB connection, and writes `.env` **only after migrations succeed**
- Generates `APP_KEY`, seeds settings & demo content, creates the **admin account**
- Locks itself out (`storage/app/installed`) once complete — safe to re-run the flow on any host

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11.55+, PHP 8.2+ |
| Admin Panel | Filament v4 (Filament 3.4 / `filament/filament` `*`) |
| Frontend | Blade + Livewire 3, Tailwind CSS 4 (standalone CLI build) |
| Database | SQLite (default), MySQL, Postgres |
| Payments | Paystack, Monnify, Nomba (service-layer abstraction) |
| AI Chat | OpenRouter LLM API + rule engine fallback |
| Support Channels | respond.io (WhatsApp / Telegram / Voice) |
| Queue | Database driver (`QUEUE_CONNECTION=database`) |

---

## 🚀 Quick Start (Recommended)

The fastest path is the **web installer** — no terminal database setup needed.

```bash
git clone https://github.com/nexuscreativ/blossom.git
cd blossom

# Install PHP + JS dependencies
composer install
npm install
npm run build            # compiles Tailwind → public/assets/css/blossom.css

# Serve it (or point any web server at public/)
php artisan serve --port=8099
```

1. Open **http://localhost:8099** in your browser.
2. The **installer** runs automatically: it checks your server, tests the DB, writes `.env`, runs migrations + seeders, and creates your admin account.
3. Log in at **/admin** and start publishing.

> **No `.env`? No problem.** If `.env` is missing, `public/index.php` generates the `APP_KEY` and the installer handles the rest. The installer defaults to a **SQLite** database file at `database/database.sqlite` — literally zero configuration.

### Manual setup (if you prefer the CLI)

```bash
cp .env.example .env
php artisan key:generate

# SQLite (default)
touch database/database.sqlite

# or MySQL/Postgres — update DB_* in .env accordingly

php artisan migrate --seed
php artisan storage:link
php artisan serve --port=8099
```

Default seeded admin (change immediately in production):

```
Email:    admin@blossom.ng
Password: blossom2024
```

---

## 🧭 Public Pages

```
/                     Home
/about                About BLOSSOM
/articles             Article listing & reading (premium paywall)
/events               Upcoming events
/listings             Business & community directory
/pricing              Subscription plans + checkout
/newsletter           Newsletter landing
/community            Community feed (auth required)
/contact              Contact form + info
/login  /register     Member auth
/dashboard            Member dashboard (auth required)
/terms /privacy /cookies /accessibility /press-kit /careers /advertise
```

---

## 🛡️ Admin Panel (`/admin`)

Filament-driven, with the full editorial + operations surface:

- **Content** — Articles, Posts, Events, Listings, Comments, Categories, Tags
- **Management** — Subscriptions, Transactions, Bookmark manager, **Chat Inbox**
- **Settings** — Manage Settings page (site info, SEO, newsletter, payments, socials) + Service configuration (API keys for payments, mail, SMS, storage, analytics, respond.io)
- **Administration** — Users

### Chat Inbox (HITL)
Escalated conversations appear with an open-count badge. Open a conversation to see the full **transcript**, then **Reply** as an agent, **Resolve**, or **Reopen**. Agents can also be assigned per conversation.

---

## 🤖 AI Chatbot Setup

1. **(Optional but recommended)** Add an OpenRouter key to `.env`:
   ```env
   OPENROUTER_API_KEY=sk-or-...
   OPENROUTER_MODEL=openai/gpt-4o-mini
   ```
   Without a key the bot still answers from its **rule engine** using live site data.

2. **Web widget** is enabled automatically on every public page.

3. **WhatsApp / Telegram / Voice** — in **Admin → Services**, open **respond.io** and add:
   - respond.io API key
   - Webhook secret
   - Then in respond.io → Settings → Webhooks, point to:
     ```
     POST https://your-domain.com/webhooks/respondio
     ```
   Replies flow through the same admin **Chat Inbox**.

---

## 💳 Payments Setup

Configure provider keys in `.env` (see `.env.example`) or in **Admin → Services**:

```env
# Paystack
PAYSTACK_SECRET_KEY=sk_...
PAYSTACK_PUBLIC_KEY=pk_...
PAYSTACK_WEBHOOK_SECRET=whsec_...

# Monnify
MONNIFY_API_KEY=...
MONNIFY_SECRET_KEY=...
MONNIFY_CONTRACT_CODE=...
MONNIFY_SUBACCOUNT_CODE=...

# Nomba
NOMBA_API_KEY=...
NOMBA_SECRET_KEY=...
NOMBA_MERCHANT_ID=...
```

Webhooks to register with your provider:
```
/webhooks/paystack
/webhooks/monnify
/webhooks/nomba
```

---

## 🧰 Common Commands

```bash
# Frontend assets
npm run dev                # watch & rebuild Tailwind
npm run build              # production build (minified)

# Database
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed

# Production optimizations
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Queue worker (required for the newsletter job)
php artisan queue:work
```

---

## 📁 Project Structure

```
app/
├── Console/Commands/        # e.g. SendNewsletterCommand, create-admin
├── Filament/                # Admin panel
│   ├── Resources/           # Article, Event, Listing, ChatConversation, Service, … (14 resources)
│   └── Pages/ManageSettings.php
├── Http/Controllers/        # Page, Auth, Payment, Chat, ChatWebhook, Install controllers
├── Livewire/                # NewsletterSubscribe, SubscriptionCheckout, CommunityFeed
├── Jobs/                    # SendNewsletterJob (queued)
├── Models/                  # Article, Event, Listing, ChatConversation, Service, Setting, …
├── Providers/               # BlossomServiceProvider (service registry), Filament/AdminPanelProvider
├── Services/
│   ├── BaseService.php      # Common service contract (validate / test / config)
│   ├── Payment/             # Paystack, Monnify, Nomba adapters
│   └── Chat/                # ChatEngine (OpenRouter + rules), ChatManager (orchestrator), RespondIoService
└── Support/Installer/       # EnvManager — writes .env atomically, generates APP_KEY
resources/views/
├── pages/                   # Blade templates for every public page
└── layouts/components/      # chat-widget, nav, footer, …
routes/web.php               # Public routes, installer, chat + webhooks
database/
├── migrations/              # 13 migrations → 30 tables
└── seeders/                 # Settings, Services, demo content
```

---

## 📦 Deployment

Full cPanel/shared-hosting walkthrough → **[DEPLOYMENT_C_PANEL.md](DEPLOYMENT_C_PANEL.md)**

Production checklist:
1. `npm run build` and commit `public/assets/css/blossom.css`
2. `composer install --optimize-autoloader --no-dev`
3. `php artisan migrate --force`
4. `php artisan config:cache && php artisan route:cache && php artisan view:cache`
5. Start a **queue worker** (`php artisan queue:work`) — required for newsletter broadcasts
6. Make `storage/` and `bootstrap/cache/` writable; symlink `public/storage`
7. Set `APP_DEBUG=false` and fill real `MAIL_*` + payment credentials

---

## 🧭 Additional Documentation

| Document | Purpose |
|----------|---------|
| [`design-system/`](design-system/) | Full UI/UX design system — tokens, pages, components, sitemap, interaction patterns |
| [`DEPLOYMENT_C_PANEL.md`](DEPLOYMENT_C_PANEL.md) | cPanel shared-hosting deployment guide |
| [`SETTINGS_AND_API_SERVICE_DESIGN.md`](SETTINGS_AND_API_SERVICE_DESIGN.md) | Settings & service-layer architecture |
| [`PAYMENT_ARCHITECTURE.md`](PAYMENT_ARCHITECTURE.md) | Payment provider architecture |
| [`BRAND-IDENTITY-GUIDELINES.md`](BRAND-IDENTITY-GUIDELINES.md) | Brand voice & identity |
| [`BLOSSOM_Business_Analysis.md`](BLOSSOM_Business_Analysis.md) | Market & business analysis report |

---

## 🔐 Security Notes

- `.env`, `vendor/`, and `node_modules/` are gitignored — never commit secrets
- `webhooks/*` and the installer are the only CSRF-exempt routes
- Service API keys are **encrypted at rest** (`Crypt::encryptString`) in the database
- respond.io webhooks verify an HMAC-SHA256 signature when a secret is configured
- The installer writes `.env` only after a successful database setup, avoiding half-installed states

---

## 📄 License

Proprietary. © BLOSSOM Media Ltd. All rights reserved.