# BLOSSOM — Complete Site Map

## Hierarchical Sitemap

```
BLOSSOM.blossom (Root: blossom.com)
|
+-- / (Homepage)
|   +-- Hero: Editor's Pick / Feature Story
|   +-- Featured Stories (3-column grid)
|   +-- Trending Now (horizontal scroll)
|   +-- Category Highlights (tabbed)
|   +-- Latest News Feed (2-column + sidebar)
|   +-- Featured Listings Preview (4 cards)
|   +-- Upcoming Events (3 cards)
|   +-- Newsletter Signup (inline)
|   +-- Community Highlights (3 threads)
|   +-- Partners/Sponsors Row
|   +-- Footer
|
+-- /blog
|   +-- /blog (Blog listing - latest articles)
|   +-- /blog?category=[slug] (Filtered by category)
|   +-- /blog/[article-slug] (Individual article)
|   |   +-- Article Header (hero image, title, meta)
|   |   +-- Article Body (editorial layout, max-width 680px)
|   |   +-- Paywall Gate (for premium content, after ~30%)
|   |   +-- Related Articles (3-4 cards)
|   |   +-- Author Bio Card
|   |   +-- Comments Section
|   |   +-- Share Buttons
|   |   +-- Newsletter CTA (end of article)
|   +-- /blog/archives (Article archive with filters)
|
+-- /category/[slug]
|   +-- Category landing page (similar to /blog filtered)
|   +-- Hero: category name + featured article
|   +-- Filter bar: subcategories, sort options
|   +-- Article grid: filtered results
|   +-- Sidebar: related categories, popular articles
|
+-- /events
|   +-- /events (Events listing - upcoming)
|   +-- /events?date=[month-year] (Calendar filtered)
|   +-- /events?location=[lga] (Location filtered)
|   +-- /events/[event-slug] (Individual event page)
|   |   +-- Event Header (banner, title, date/time)
|   |   +-- Event Details (location, description, lineup)
|   |   +-- RSVP / Ticket Button
|   |   +-- Event Map
|   |   +-- Related Events
|   |   +-- Organizer Profile
|   +-- /events/submit (Event submission - for listed entities)
|
+-- /listings
|   +-- /listings (Directory - all listings)
|   +-- /listings?type=business (Businesses only)
|   +-- /listings?type=personality (Personalities only)
|   +-- /listings?type=institution (Institutions only)
|   +-- /listings?lga=[slug] (Filtered by LGA)
|   +-- /listings?category=[slug] (Filtered by category)
|   +-- /listings/[listing-slug] (Individual listing page)
|   |   +-- Listing Hero (cover image, name, category badge)
|   |   +-- Listing Details (description, contact, map)
|   |   +-- Photo Gallery
|   |   +-- Reviews/Ratings
|   |   +-- Related Listings
|   |   +-- "Claim This Listing" CTA
|   +-- /listings/claim (Claim a listing - verification flow)
|   +-- /listings/submit (Submit new listing - paid placement)
|
+-- /community
|   +-- /community (Community hub - discussions feed)
|   +-- /community/discussions (All discussions)
|   +-- /community/discussions/[thread-slug] (Thread view)
|   +-- /community/topics (Browse by topic)
|   +-- /community/members (Member directory)
|   +-- /community/guidelines (Community rules)
|   +-- /community/[user-slug] (User profile)
|
+-- /magazine
|   +-- /magazine (Digital magazine reader)
|   +-- /magazine/issues (All past issues)
|   +-- /magazine/[issue-slug] (Single issue reader)
|   +-- /magazine/subscribe (Magazine subscription)
|
+-- /subscribe
|   +-- /subscribe (Subscription landing - pricing tiers)
|   +-- /subscribe/checkout (Payment flow)
|   +-- /subscribe/manage (Manage subscription - logged in)
|   +-- /subscribe/gift (Gift subscription)
|   +-- /subscribe/corporate (Corporate/institutional plans)
|
+-- /newsletter
|   +-- /newsletter (Newsletter landing - archive + signup)
|   +-- /newsletter/archive (Past newsletters)
|   +-- /newsletter/[issue-slug] (Single newsletter view)
|   +-- /newsletter/manage (Manage preferences - logged in)
|   +-- /newsletter/unsubscribe (Unsubscribe confirmation)
|
+-- /authors
|   +-- /authors (Authors listing)
|   +-- /authors/[author-slug] (Author profile page)
|   |   +-- Author Bio (headshot, bio, social links)
|   |   +-- Author's Articles (grid)
|   |   +-- Author Stats (articles, followers)
|   +-- /authors/contribute (Become a contributor)
|
+-- /search
|   +-- /search?q=[query] (Search results - articles, listings, events, people)
|
+-- /about
|   +-- /about (About BLOSSOM - mission, team, story)
|   +-- /about/team (Team page)
|   +-- /about/advisory-board (Advisory board)
|   +-- /about/mission (Mission & values)
|   +-- /about/plateau-heritage (Plateau State heritage section)
|
+-- /contact
|   +-- /contact (Contact form, address, social links)
|
+-- /advertise
|   +-- /advertise (Advertising landing - media kit)
|   +-- /advertise/rates (Rate card)
|   +-- /advertise/submit (Submit ad creative)
|   +-- /advertise/sponsored-content (Sponsored content packages)
|
+-- /auth
|   +-- /auth/login (Login page)
|   +-- /auth/register (Registration page)
|   +-- /auth/forgot-password (Password reset)
|   +-- /auth/verify-email (Email verification)
|   +-- /auth/social-callback (Social OAuth callback)
|
+-- /dashboard (Authenticated - role-based routing)
|   +-- /dashboard (Subscriber dashboard)
|   |   +-- Reading History
|   |   +-- Saved Articles
|   |   +-- Subscription Status
|   |   +-- Personalized Feed
|   +-- /dashboard/listing (Listed entity dashboard)
|   |   +-- Listing Analytics
|   |   +-- Listing Editor
|   |   +-- Review Management
|   |   +-- Subscription/Billing
|   |   +-- Promote Listing
|   +-- /dashboard/community (Community member dashboard)
|   |   +-- My Discussions
|   |   +-- My Comments
|   |   +-- Notifications
|   |   +-- Reputation/Points
|   +-- /dashboard/author (Author/contributor dashboard)
|   |   +-- My Articles (drafts, published, archived)
|   |   +-- Analytics
|   |   +-- Submissions
|   |   +-- Payment History
|   +-- /dashboard/admin (Admin panel)
|       +-- Dashboard Overview (KPIs, charts)
|       +-- Content Management
|       |   +-- Articles (CRUD)
|       |   +-- Events (CRUD)
|       |   +-- Categories/Tags
|       |   +-- Media Library
|       +-- Subscriber Management
|       |   +-- Subscriber List
|       |   +-- Subscription Plans
|       |   +-- Churn Analytics
|       +-- Listings Management
|       |   +-- All Listings (approve/edit/remove)
|       |   +-- Pending Claims
|       |   +-- Featured Placements
|       +-- Newsletter Management
|       |   +-- Campaign Builder
|       |   +-- Subscriber Lists
|       |   +-- Broadcast History
|       |   +-- Campaign Analytics
|       +-- Advertising
|       |   +-- Ad Placements
|       |   +-- Campaign Performance
|       |   +-- Revenue Tracking
|       +-- Community Moderation
|       |   +-- Reported Content
|       |   +-- Banned Users
|       |   +-- Discussion Rules
|       +-- Users & Roles
|       +-- Financial
|       |   +-- Revenue Dashboard
|       |   +-- Subscriptions Revenue
|       |   +-- Listings Revenue
|       |   +-- Advertising Revenue
|       |   +-- Invoices
|       +-- Settings
|           +-- General Settings
|           +-- Payment Gateways
|           +-- Email Templates
|           +-- SEO Settings
|           +-- Integrations
|
+-- /legal
|   +-- /legal/terms (Terms of Service)
|   +-- /legal/privacy (Privacy Policy)
|   +-- /legal/cookies (Cookie Policy)
|   +-- /legal/refund (Refund Policy)
|   +-- /legal/accessibility (Accessibility Statement)
|
+-- /sitemap (HTML sitemap)
+-- /robots.txt
+-- /feed (RSS feed)
```

## URL Structure Rules

| Rule | Pattern | Example |
|------|---------|---------|
| Slugs | lowercase, hyphens only | `/blog/heritage-festival-2026` |
| Filtering | query params | `/listings?type=business&lga=jos-north` |
| Pagination | `?page=N` | `/blog?page=3` |
| Search | `?q=encoded+query` | `/search?q=heritage+festival` |
| Trailing slash | No trailing slash | `/blog` not `/blog/` |
| Case sensitivity | Always lowercase | `/Blog` redirects to `/blog` |

## Navigation Hierarchy

| Level | Pages | Breadcrumb |
|-------|-------|------------|
| 0 | Homepage | Home |
| 1 | Blog, Events, Listings, Community, Magazine, Subscribe, Newsletter | Home > [Section] |
| 2 | Article, Event detail, Listing detail, Thread | Home > [Section] > [Item] |
| 3 | Author profile (from article) | Home > Blog > [Article] > [Author] |

## Role-Based Dashboard Routing

| User Role | Dashboard Route | Sidebar Items |
|-----------|----------------|---------------|
| Subscriber | `/dashboard` | Overview, Saved, History, Settings |
| Listed Entity | `/dashboard/listing` | Overview, Edit Listing, Reviews, Billing |
| Community Member | `/dashboard/community` | Discussions, Comments, Notifications, Reputation |
| Author | `/dashboard/author` | Articles, Submissions, Analytics, Payments |
| Admin | `/dashboard/admin` | All admin modules (full sidebar) |
| Advertiser | `/dashboard` | Campaigns, Placements, Analytics, Billing |
