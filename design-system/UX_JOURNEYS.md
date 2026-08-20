# BLOSSOM — Complete User Experience Journeys & Interaction Flows

**Version:** 1.0
**Date:** August 18, 2026
**Author:** ArchitectUX
**Status:** Developer Handoff Ready

---

## Table of Contents

1. [New Reader Journey](#1-new-reader-journey)
2. [Subscription Journey](#2-subscription-journey)
3. [Newsletter Journey](#3-newsletter-journey)
4. [Featured Listing Journey](#4-featured-listing-journey)
5. [Community Journey](#5-community-journey)
6. [Advertiser Journey](#6-advertiser-journey)
7. [Admin/Editor Journey](#7-admineditor-journey)
8. [Information Architecture](#8-information-architecture)
9. [Search Experience](#9-search-experience)
10. [Notification System](#10-notification-system)
11. [Onboarding Flows](#11-onboarding-flows)

---

## 1. NEW READER JOURNEY — First Visit to Regular Reader

### Entry Points
- Social media link (Twitter/X, Facebook, Instagram, WhatsApp)
- Google search result
- Newsletter forward/shared link
- Direct URL (word of mouth)
- Referral from listed business/organization

---

### STEP 1: Landing on Homepage

**Screen: `/` (Homepage)**

```
WHAT THE USER SEES:
-------------------------------------------------------------------
NAVBAR: [BLOSSOM Logo]  Blog  Events  Listings  Community  Magazine
                 [Search]  [Newsletter]  [Subscribe]  [Avatar]
         Height: 72px | Position: sticky, top: 0 | z-index: 200

HERO: Full-bleed feature image (16:9, 560px desktop / 400px mobile)
      Gradient overlay: transparent 30% -> rgba(0,0,0,0.7) 100%

      [CULTURE & HERITAGE]     <- Category pill (Sean Green bg, white text)
      "The Remarkable Story of Plateau's..."
      Playfair Display 700, white, text-6xl (60px desktop, 30px mobile)

      "A compelling summary that draws readers into the heart
       of Plateau's cultural revival."
      Source Serif 4, white 90%, text-xl

      [Avatar] Author Name . 8 min read . [PREMIUM]
      [Read Article ->] (ghost button, white border)

EDITOR'S PICKS: "EDITOR'S PICKS" Playfair 600, text-3xl
      3-column grid (2 tablet, 1 mobile)
      Cards: Image 16:9 + Category pill + Title + Excerpt + Meta
      Hover: shadow-lg, translateY(-4px), 250ms ease

TRENDING: "TRENDING" Inter 700, uppercase + animated pulse dot
      Horizontal snap scroll cards (64px height each)
      Number (onion) + small image + title + meta

CATEGORY TABS: [Culture] [Politics] [Business] [Tourism] [Sports]
      Click -> AJAX content load (no page reload)
      Active: onion color, 2px bottom border

LATEST + SIDEBAR (8:4 column split, desktop)
      Main: 2-column article grid + [Load More]
      Sidebar: Newsletter CTA (onion-50 bg) | Featured Listing (gold border)
               | Upcoming Event (date block)

"PLATEAU'S FINEST": 4 featured listing cards (horizontal scroll mobile)

"WHAT'S HAPPENING": 3 event cards + [View All Events ->]

"THE CONVERSATION": 3 community thread cards

SUBSCRIPTION CTA: Full-width, dark onion gradient
      "Unlock Plateau's Story" + 3 pricing tier previews
      [Choose Your Plan ->] (orange button)

PARTNERS: Grayscale logos row (hover: full color)

FOOTER: 5-column grid, newsletter mini-signup, legal links
```

**First Impression Checklist:**
- Hero loads within 1.5s (LCP target)
- Logo visible immediately
- Category pill signals topic relevance
- Premium badge signals content quality
- Social proof visible in sidebar (subscriber count)

**User Psychology Triggers:**
- Hero headline answers: "Why should I care about Plateau State?"
- Category pill signals: "This covers topics I care about"
- Premium badge signals: "This is high-quality, exclusive content"

---

### STEP 2: Discovering Content

**6 Discovery Paths:**

| Path | Behavior | % of Users |
|------|----------|------------|
| A: Hero Story | Click hero or "Read Article" | 40% |
| B: Editor's Picks | Hover card (lift effect) -> click | 25% |
| C: Category Tabs | Click tab -> AJAX filtered content -> click article | 15% |
| D: Trending | Horizontal scroll -> click compact card | 10% |
| E: Sidebar | Newsletter CTA / Featured Listing / Event | 5% |
| F: Search | Click search icon or Cmd/Ctrl+K -> type query | 5% |

**Content Hierarchy on Homepage:**

| Position | Content Type | Purpose | Conversion Goal |
|----------|-------------|---------|-----------------|
| Hero | Feature article | First impression | Read article |
| Editor's Picks | Curated articles | Quality signal | Read article |
| Trending | Most-read articles | Social proof | Read article |
| Category tabs | Topic filtering | Personalization | Read article |
| Latest + Sidebar | Fresh content + CTAs | Engagement | Newsletter + Subscribe |
| Featured Listings | Business directory | Revenue | Listing purchases |
| Events | Calendar | Utility | RSVPs |
| Community | Discussions | Engagement | Account creation |
| Subscription CTA | Pricing | Revenue | Subscriber conversion |
| Partners | Social proof | Credibility | Trust building |

---

### STEP 3: First Article Read

**Screen: `/blog/[article-slug]`**

```
ARTICLE PAGE STRUCTURE:
-------------------------------------------------------------------
ARTHERO: Full-width (16:9 or 21:9), max-height 600px desktop / 320px mobile
         Gradient overlay + category pill + title (Playfair 5xl)

STICKY META BAR (appears on scroll down):
         [Avatar 28px] Author Name . Aug 15, 2026 . 8 min read
                                                      [Share] [Bookmark]
         Background: rgba(255,255,255,0.95), backdrop-filter: blur(8px)
         Position: sticky, top: 72px (desktop) / 56px (mobile)
         Height: 56px

ARTICLE BODY (max-width: 680px, centered):
         Drop cap: First letter (Playfair 900, 60px, onion, float left)
         Lead paragraph: Source Serif 4, text-lg, 1.6 line-height
         Body paragraphs: text-base, 1.625 line-height, max 65-75 chars/line

         PULL QUOTE:
         "Heritage is not just about the past..."
         Playfair Italic, text-2xl, onion color
         Border-left: 3px solid onion, padding-left: 24px

         [Full-width image with caption]
         Caption: Inter 400, text-xs, ash, centered

PAYWALL GATE (if premium, after ~30% of content):
         Remaining content: blur(12px), max-height: 400px
         Gradient overlay: white 0% -> transparent 60%

         GATE CARD (centered, max-width: 520px):
         "This story continues for premium subscribers"
         +------------------------------------------+
         | Monthly         | Annual (Save 33%)      |
         | N2,500/mo       | N20,000/yr            |
         | [Subscribe]     | [Subscribe *]          |
         +------------------------------------------+
         Already subscribed? [Log In]

         z-index: 800 (z-paywall)
         Scroll lock: body overflow hidden at gate position

ARTICLE FOOTER:
         TAGS: [Culture] [Heritage] [Plateau] [Tradition]
         SHARE: [Twitter] [Facebook] [LinkedIn] [WhatsApp] [Copy]

         AUTHOR BIO CARD (border: 1px silver, radius: 12px)
         [Avatar 64px] Author Name + Bio + Social links + [More Articles]

         RELATED ARTICLES: 3 cards in row

         COMMENTS SECTION: "DISCUSSION (24 comments)"
         [Comment input] [Post Comment] (orange)
         Comment Thread: Avatar + Name + Time + Text + [Like] [Reply]

         NEWSLETTER CTA (end of page, onion-50 bg)
```

**Reading Experience Phases:**

| Phase | Duration | What Happens |
|-------|----------|--------------|
| Initial load | 0-1.5s | Hero image loads, LCP achieved |
| First scroll | 0-5s | Meta bar appears, drop cap visible |
| Deep read | 5-30s | Full body, pull quotes, images |
| Paywall gate | ~30% | If premium: blur + gate card |
| Post-gate | After gate | Related articles, comments, newsletter CTA |

**Paywall Gate Behavior:**
- Trigger: Scroll to ~30% of article
- Animation: Content fades to blur (400ms ease)
- Scroll: Body overflow: hidden at gate
- Gate card: Positioned over blur, centered
- User can: Scroll back up, click Subscribe, click Log In, dismiss gate

**Error States:**

| Error | User Sees | Recovery |
|-------|-----------|----------|
| Article not found | 404 page with search | Search bar, homepage link |
| Image fails to load | Gray placeholder with icon | Automatic retry |
| Comment fails to post | "Failed to post. Try again." toast | Retry button |
| Share fails | "Could not share. Link copied." toast | Auto-copy fallback |
| Slow connection | Skeleton loading states | Progressive rendering |

**Metrics to Track:**

| Metric | Target | Event |
|--------|--------|-------|
| Article LCP | < 1.5s | Page load |
| Scroll depth | > 60% avg | Scroll event |
| Time on article | > 3 min avg | Session duration |
| Paywall impression | 100% on premium articles | Gate visibility |
| Paywall click-through | > 15% | Subscribe click |
| Comment post rate | > 5% of readers | Comment submit |
| Share rate | > 8% of readers | Share click |

---

### STEP 4: Newsletter Signup Trigger and Flow

**8 Trigger Points (ordered by conversion rate):**

| # | Trigger | Location | Type | Frequency Cap | Conversion |
|---|---------|----------|------|---------------|------------|
| 1 | Exit intent | Mouse leaves viewport | Modal popup | 1x per session | ~8% |
| 2 | Scroll 50% of article | Article end | Inline CTA | Every article | ~5% |
| 3 | Time-based (45s) | Any page | Sticky bottom banner | 1x per session | ~4% |
| 4 | 3+ articles read | Sidebar | Sticky sidebar CTA | 1x per session | ~3% |
| 5 | Dedicated page | /newsletter | Full landing page | Always | ~2% |
| 6 | Footer | Every page footer | Mini signup form | Always | ~1% |
| 7 | Post-comment | After first comment | Toast notification | 1x per session | ~1% |
| 8 | Registration | Account creation | Pre-checked checkbox | During signup | ~60% |

**Signup Form States:**

| State | Input | Button |
|-------|-------|--------|
| Default | White bg, silver border | Orange bg, "Subscribe" |
| Focus | Onion border, focus ring | Orange bg |
| Submitting | Disabled, opacity 0.7 | Spinner icon |
| Success | Green border | "Subscribed!" green bg |
| Error | Red border + error text | "Error" red bg |
| Already sub | Info border | "Manage" link |

**Confirmation Flow:**

```
Step 1: User enters email, clicks Subscribe
  -> Button shows spinner (onion color, 20px)
  -> Input disabled (opacity 0.7)

Step 2: Success
  -> Green toast: "Check your inbox! We sent a confirmation email."
  -> Email sent with double opt-in link
  -> User clicks link -> "You're subscribed!" confirmation page
  -> Animation: Confetti burst (300ms, brand colors)
  -> [Set Preferences] [Start Reading]

Step 2b: Already subscribed
  -> Info toast: "You're already subscribed! Check your latest newsletter."

Step 2c: Validation error
  -> Red error text: "Please enter a valid email address."
  -> Input border turns red
```

---

### STEP 5: Return Visit Experience

**Personalization on Return:**

| State | What Changes |
|-------|-------------|
| Visit count incremented | Stored in localStorage |
| Articles read | Stored in array for recommendations |
| Categories viewed | First tab pre-selected by interest |
| Newsletter banner | Suppressed if already subscribed |
| Welcome banner | "Welcome back! Here's what's new." (if 3+ visits) |
| Personalized feed | "Stories for You" section (if logged in) |
| Recently read | "Continue Reading" with progress bars (if logged in) |

---

### STEP 6: Conversion to Subscriber

**6 Conversion Triggers:**

| Trigger | Condition | Action |
|---------|-----------|--------|
| Paywall encounter | Hits premium article | Gate card -> checkout |
| Quota exceeded | 5 free articles/month | Overlay -> subscribe prompt |
| Content teaser | Newsletter premium preview | "Read full" link -> paywall |
| Homepage CTA | Scrolls to subscription section | Pricing preview -> /subscribe |
| Navigation CTA | Clicks "Subscribe" in nav | /subscribe pricing page |
| Social proof | 10+ free articles read | Toast -> /subscribe |

---

## 2. SUBSCRIPTION JOURNEY — Free to Paid Subscriber

### Entry Points
- Paywall gate card (most common)
- Homepage subscription CTA
- Navbar "Subscribe" button
- Newsletter email link
- Social media promotion
- Direct URL: `/subscribe`

---

### STEP 1: Paywall Encounter

**What user sees as they scroll through a premium article:**

```
Phase 1: READING (0-30%)
  - Full article content visible
  - Smooth scrolling, high-quality editorial experience

Phase 2: APPROACHING GATE (25-30%)
  - Content begins to fade (opacity transition)
  - Subtle visual cue that content is ending

Phase 3: GATE ACTIVATED (30%)
  - Content blurs: filter: blur(12px)
  - 400px of blurred content visible (creates curiosity)
  - Gradient overlay: white 0% -> transparent 60%
  - Body scroll locked at gate position
  - Gate card fades in (400ms ease)

Phase 4: GATE CARD
  - Lock icon + "This story continues for premium subscribers"
  - Two pricing options: Monthly (N2,500) / Annual (N20,000, Save 33%)
  - "Already subscribed? Log In" link
  - Click Subscribe -> checkout flow
  - Click Log In -> auth flow
```

---

### STEP 2: Pricing Page

**Screen: `/subscribe`**

```
PRICING HERO:
  Background: Onion Purple gradient
  "SUBSCRIPTION PLANS" (Inter 500, uppercase, orange)
  "Unlock Plateau's Complete Story" (Playfair 5xl, white)
  Toggle: [Monthly] [Annual - Save 33%]

PRICING CARDS (3 columns):

+----------------+  +----------------+  +----------------+
| READER (Free)  |  |* PREMIUM       |  | INSTITUTION    |
|                |  | (Featured)     |  | (Corporate)    |
| N0/mo          |  | N2,500/mo      |  | Custom Pricing |
|                |  | N20,000/yr     |  |                |
|                |  | (Save 33%)     |  |                |
| v 5 articles   |  | v Unlimited    |  | v All Premium  |
| v Events       |  | v Premium badge|  | v 50 seats     |
| v Basic listing|  | v Ad-free      |  | v Analytics    |
| v Community    |  | v Exclusive    |  | v API access   |
|   read access  |  |   content      |  | v Custom brand |
|                |  | v Community    |  | v Priority     |
|                |  |   badge        |  |   support      |
|                |  | v Early access |  |                |
|                |  | v Monthly      |  |                |
|                |  |   digest       |  |                |
| [Get Started]  |  | [Subscribe *]  |  | [Contact Sales]|
| (ghost btn)    |  | (orange btn)   |  | (onion btn)    |
+----------------+  +----------------+  +----------------+

Premium card: Border 2px onion, shadow-onion, "MOST POPULAR" badge,
              slightly elevated: scale(1.02)

FAQ ACCORDION:
  [>] What's included in the free tier?
  [>] Can I upgrade or downgrade anytime?
  [>] Is there a student discount?
  [>] How do I cancel my subscription?
  [>] What payment methods do you accept?

TESTIMONIALS: 3 quote cards
NEWSLETTER CTA: "Not ready to subscribe? Get our free newsletter."
```

**Pricing Comparison:**

| Feature | Reader (Free) | Premium (N2,500/mo) | Institution (Custom) |
|---------|---------------|---------------------|----------------------|
| Articles/month | 5 | Unlimited | Unlimited |
| Premium content | No | Yes | Yes |
| Ad-free | No | Yes | Yes |
| Digital magazine | No | Yes | Yes |
| Community badge | No | Yes | Yes |
| Early access | No | Yes | Yes |
| Monthly digest | No | Yes | Yes |
| Print magazine | No | No | Yes (add-on) |
| Seats | 1 | 1 | Up to 50 |
| Analytics | No | No | Yes |
| API access | No | No | Yes |
| Priority support | No | No | Yes |

---

### STEP 3: Plan Selection

**Interaction Flow:**

1. User views pricing cards (3 visible in grid)
2. User toggles Monthly/Annual -> prices update with fade (200ms)
3. User hovers card -> lift effect, shadow-lg, onion-100 border
4. User clicks "Subscribe" -> button spinner (200ms) -> navigate to checkout
5. If not logged in -> /auth/login?redirect=/subscribe/checkout

**Institution "Contact Sales" Flow:**
- Modal with contact form (Name, Org, Email, Phone, Message)
- Submit -> "We'll contact you within 24 hours"

---

### STEP 4: Payment Flow

**Screen: `/subscribe/checkout`**

```
CHECKOUT PAGE:
-------------------------------------------------------------------
ORDER SUMMARY (left column, 60%):
  Premium Subscription - Monthly Plan
  Subtotal:    N2,500
  Tax (7.5%):  N188
  ─────────────────
  Total:       N2,688

  Payment Method: [Card] [Bank Transfer] [USSD]

  Card Details:
  [Card number           ]
  [Expiry] [CVV]
  [Cardholder name       ]

  [Pay N2,688] (orange button, full width)
  Secure payment via Paystack

ACCOUNT CREATION (right column, 40%):
  [Full Name            ]
  [Email Address        ]
  [Password]  (toggle visibility)
  [Confirm Password     ]
  ☑ Subscribe to BLOSSOM Weekly newsletter
  ☐ I agree to [Terms] and [Privacy Policy]
  Already have an account? [Log In]
```

**Payment Methods:**

| Method | Details | Processing |
|--------|---------|------------|
| Card | Visa, Mastercard, Verve (Paystack/Flutterwave) | 2-5 seconds |
| Bank Transfer | Virtual account, 30-min window | Webhook auto-confirm |
| USSD | Bank selection + USSD code | Manual confirmation |

**Payment States:**

| State | User Sees | What Happens |
|-------|-----------|--------------|
| Initiating | "Processing..." overlay | Gateway loads |
| 3D Secure | Bank authentication page | User enters OTP |
| Processing | Spinner on pay button | Awaiting confirmation |
| Success | Green checkmark + "Payment successful!" | Redirect to dashboard |
| Failed | Red error: "Payment failed. Please try again." | Retry option |
| Abandoned | "Payment incomplete. Complete subscription?" | Resume flow |

---

### STEP 5: Account Creation

**Registration Methods:**

```
METHOD 1: Email Registration
  [Full Name            ]
  [Email Address        ]
  [Password]  (toggle visibility)
  [Confirm Password     ]
  ☑ Subscribe to BLOSSOM Weekly newsletter
  ☐ I agree to [Terms] and [Privacy Policy]
  [Create Account] (orange button, full width)
  ─── OR ───
  [Continue with Google] (white button)
  [Continue with Facebook] (blue button)
  Already have an account? [Log In]

METHOD 2: Social OAuth
  Click "Continue with Google" -> OAuth popup -> Account auto-created
  -> Profile pre-filled from Google data -> Redirect to dashboard
```

**Validation Rules:**

| Field | Rule | Error Message |
|-------|------|---------------|
| Full Name | Required, min 2 chars | "Name must be at least 2 characters" |
| Email | Required, valid format, unique | "An account with this email exists. [Log In]" |
| Password | Min 8 chars, 1 uppercase, 1 number | "Password must be at least 8 characters" |
| Confirm | Must match password | "Passwords do not match" |
| Terms | Required | "You must agree to the Terms of Service" |

---

### STEP 6: Post-Payment Onboarding

**Welcome Modal (appears after successful payment):**

```
+-----------------------------------------------------+
|                                     [Skip]           |
|                                                     |
|  Welcome to BLOSSOM Premium!                         |
|                                                     |
|  You now have unlimited access to:                  |
|  - All premium articles and investigations          |
|  - Ad-free reading experience                       |
|  - Exclusive subscriber-only content                |
|  - Early access to new features                     |
|  - Premium community badge                          |
|                                                     |
|  Let's personalize your experience:                 |
|                                                     |
|  WHAT TOPICS INTEREST YOU?                          |
|  [Culture] [Politics] [Business] [Tourism]          |
|  [Education] [Sports] [Arts] [Development]          |
|  (Select at least 3)                                |
|                                                     |
|  [Continue ->] (orange button)                       |
|  Step 1 of 3: Topics -> Preferences -> Invite       |
+-----------------------------------------------------+
```

**3-Step Onboarding:**

| Step | Content | Action |
|------|---------|--------|
| 1. Topic Selection | Select 3+ interests | Maps to personalized feed |
| 2. Notification Preferences | Email/push/SMS toggles + frequency | Save preferences |
| 3. Invite Friends | Share buttons + referral link | "Give a friend 1 month free" |

**Final State:**
- Welcome modal closes
- Dashboard loads with personalized feed
- Toast: "Welcome! Your premium subscription is active."
- Green "Premium Member" badge in navbar
- All paywalls removed
- Ad-free experience activated

---

### STEP 7: Subscription Management

**Screen: `/subscribe/manage`**

```
SUBSCRIPTION MANAGEMENT:
-------------------------------------------------------------------
CURRENT PLAN:
  Premium Monthly - N2,500/month
  Status: Active (green check)
  Next billing: September 15, 2026
  Payment method: Visa ****4242
  [Upgrade to Annual] [Change Payment Method]

UPGRADE OPTIONS:
  Switch to Annual: N20,000/year - Save N10,000 (33% off)
  [Upgrade Now]

BILLING HISTORY:
  Aug 15, 2026 | N2,688 | Paid | [Download Receipt]

CANCEL SUBSCRIPTION:
  [Cancel Subscription] (text link, red on hover)
```

**Upgrade Flow:**
1. Click "Upgrade to Annual" -> modal confirmation
2. "Monthly plan replaced, unused time prorated"
3. [Confirm Upgrade] -> payment processed -> success toast

**Downgrade Flow:**
1. Click "Downgrade" -> modal confirmation
2. "Annual plan ends on [date], switched to monthly after"
3. [Confirm Downgrade] -> success toast

**Cancel Flow (4 steps):**
1. Reason selection (Too expensive / Not enough content / Found alternative / Other)
2. Confirmation modal ("Are you sure? Access continues until [date]")
3. Exit survey (optional: "What could we do better?")
4. Confirmation: "Cancelled. Access continues until [date]."

---

## 3. NEWSLETTER JOURNEY — Signup to Engagement

### STEP 1: Signup Locations (8 points)

| # | Location | Visual | Cap | Conversion |
|---|----------|--------|-----|------------|
| 1 | Exit intent modal | Full modal, editorial image | 1x/session | ~8% |
| 2 | Article end CTA | Inline, onion-50 bg | Every article | ~5% |
| 3 | Sticky bottom banner | Fixed bottom, 64px, onion-900 | 1x/session | ~4% |
| 4 | Sidebar CTA | Card, onion-50 bg | Always | ~3% |
| 5 | /newsletter page | Full landing page | Always | ~2% |
| 6 | Footer | Mini form in footer | Always | ~1% |
| 7 | Post-comment toast | Toast notification | 1x/session | ~1% |
| 8 | Registration checkbox | Pre-checked opt-in | During signup | ~60% |

### STEP 2: Email Confirmation Flow

```
Step 1: User enters email -> spinner replaces button text
Step 2: Green toast: "Check your inbox! We sent a confirmation email."
Step 3: Confirmation email sent (double opt-in)
        Subject: "Confirm your subscription to BLOSSOM Weekly"
        Content: Welcome text + [Confirm My Subscription] button
Step 4: User clicks link -> /newsletter/confirm/[token]
        "You're subscribed!" + confetti animation
        [Set Preferences] [Start Reading]
```

### STEP 3: Preference Center

**Screen: `/newsletter/manage`**

```
NEWSLETTER PREFERENCES:
-------------------------------------------------------------------
Hi [Name], manage your BLOSSOM newsletter preferences.

EMAIL FREQUENCY:
  o Weekly (every Wednesday)
  * Bi-weekly (every other Wednesday)
  o Monthly (first Wednesday)

TOPICS (select at least 1):
  [x] Culture & Heritage    [x] Business & Economy
  [ ] Politics & Governance [x] Tourism & Travel
  [ ] Education             [ ] Arts & Entertainment
  [ ] Sports                [ ] Development

CONTENT TYPES:
  [x] Editor's picks    [x] Featured articles
  [x] Events calendar   [ ] Listing highlights
  [ ] Community talks    [x] Breaking news alerts

NOTIFICATION CHANNELS:
  [x] Email newsletter
  [ ] Push notifications (browser)
  [ ] SMS alerts (breaking news only)

[Save Preferences] (orange button)
[Unsubscribe from all] (text link, red)
```

### STEP 4: First Newsletter Received

```
NEWSLETTER EMAIL STRUCTURE:
-------------------------------------------------------------------
BLOSSOM Logo (centered)
BLOSSOM WEEKLY - Issue #24 - August 15, 2026

EDITOR'S PICK:
  [Hero Image 600x300]
  "The Heritage Festival Preview"
  [Read Article ->] (orange button)

MORE STORIES (3 items):
  [img 120x80] Story title + [Read ->]
  [img 120x80] Story title + [Read ->]
  [img 120x80] Story title + [Read ->]

UPCOMING EVENTS:
  Sep 15-17  Plateau Heritage Festival
  Sep 22     Jos Tech Summit
  Sep 28     Cultural Night Market

FROM THE COMMUNITY:
  "What's the best restaurant in Jos?" - 47 replies

FEATURED LISTING:
  [Image] Mama Dikko's Restaurant - 4.8 stars

SUBSCRIBE TO PREMIUM:
  "Unlock unlimited articles, ad-free reading, and exclusive content."
  [Subscribe Now ->] (orange button)

FOOTER: Social links + Unsubscribe + Manage Preferences
```

### STEP 5: Re-engagement for Inactive Subscribers

| Days Inactive | Email Subject | Content |
|---------------|---------------|---------|
| 7 days | "We miss you! Here's what you've missed" | 3 top stories + CTA |
| 14 days | "Plateau is buzzing! Don't miss out." | Top 5 + events |
| 30 days | "Is everything okay? We'd love to have you back." | Monthly recap + preference update |
| 60 days | (Suppressed - no more emails) | Can re-subscribe via website |

### STEP 6: Unsubscribe Flow

```
Step 1: User clicks "Unsubscribe" in email
Step 2: /newsletter/unsubscribe?token=[unique]
        Confirmation page with retention options:
        - "Update my preferences instead"
        - "Switch to monthly digest"
        - [Confirm Unsubscribe] (red button)
        - Optional reason (radio buttons)
Step 3: Success: "You've been unsubscribed."
        "You can always re-subscribe at blossom.com"
        [Return to BLOSSOM]
```

**Suppression Rules:**
- Hard bounce: Immediate suppression
- Soft bounce (3x consecutive): Suppress
- Unsubscribe: Immediate suppression
- 60 days inactive: Suppress
- Spam report: Immediate suppression + admin alert

---

## 4. FEATURED LISTING JOURNEY — Discovery to Live

### STEP 1: How Users Discover Listings

| Path | Source | Behavior |
|------|--------|----------|
| A | Homepage "PLATEAU'S FINEST" | 4 featured cards (gold border) |
| B | Navigation "Listings" | Directory landing page |
| C | Search results | Business/personality name search |
| D | Article mentions | "View Listing" link in articles |
| E | Community discussions | Auto-linked mentions |
| F | Direct URL | /listings/[slug] |
| G | Category browse | Filtered directory view |

### STEP 2: Search and Filter Experience

**Screen: `/listings`**

```
DIRECTORY HERO:
  "Plateau's Directory" (Playfair 5xl)
  "Businesses, Personalities, Institutions"
  STAT ROW: [248 Businesses] [156 Personalities] [89 Institutions]

SEARCH & FILTER PANEL (sticky, top: 72px):
  [Search listings...] [Filter] [Sort: Featured v]
  [All Types v] [All LGAs v] [All Categories v]
  ACTIVE FILTERS: [Business x] [Jos North x] [Restaurants x] [Clear]

TABS: [All] [Businesses] [Personalities] [Institutions]

GRID (3 cols desktop, 2 tablet, 1 mobile):
  Results: Showing 1-12 of 248
  Cards: Cover Image 320x200 + Category pill + Name + Location
         + Rating (gold stars) + Description (2 lines, ellipsis)
  Premium: Gold top border (3px) + "FEATURED" badge
  Claimed: Verified badge (green check)
  Unclaimed: "Claim this listing" overlay on hover

[Load More Listings] (ghost button)

CTA BANNER: "List Your Business" (onion gradient)
  "Get discovered by Plateau's readers"
  [Submit Listing ->] (orange button)
```

**Filter Behavior:**
- Type: Dropdown (Business, Personality, Institution)
- LGA: Dropdown (17 LGAs + "All")
- Category: Dropdown (Restaurants, Hotels, Schools, etc.)
- Sort: Featured (default), Newest, Rating, Name
- Filters update via AJAX (no page reload)
- URL updates: /listings?type=business&lga=jos-north

### STEP 3: "Claim Your Listing" Flow

```
Step 1: User finds unclaimed listing (hover shows "Claim" overlay)
Step 2: Click "Claim This Listing" -> Verification modal:
        "Are you the owner/representative of [Business Name]?"
        Verification methods:
        - Email verification (6-digit code)
        - Phone verification (6-digit SMS)
        - Document upload (business certificate/ID)
Step 3: Submits claim -> "Your claim is being reviewed"
Step 4: Admin reviews (approve/reject notification)
Step 5: On approval: Verified badge added, listing dashboard access
Step 6: On rejection: Reason provided, option to resubmit
```

### STEP 4: "Submit New Listing" Flow (5 Steps)

```
SCREEN: /listings/submit

STEP 1: CHOOSE TYPE
  [Business]  [Personality]  [Institution]
  3 cards with icon + title + description

STEP 2: BASIC INFORMATION
  Name*           [                        ]
  Category*       [Select category      v]
  LGA*            [Select LGA           v]
  Address         [                        ]

STEP 3: DETAILS
  Description*    [500 char textarea      ]
  Phone           [+234 ...              ]
  Website         [https://...            ]
  Cover Image     [Drag & drop or click   ]
                  JPG/PNG/WebP, Max 5MB

STEP 4: CHOOSE PLAN
  +----------------+  +------------------+
  | BASIC (Free)   |  | FEATURED (Premium)|
  | N0/year        |  | N15,000/year     |
  | v Basic listing|  | v All Basic      |
  | v Contact info |  | v Gold border    |
  | v Description  |  | v Priority place |
  |                |  | v Photo gallery  |
  |                |  | v Analytics      |
  |                |  | v Verified badge |
  |                |  | v Event posting  |
  | [Select Basic] |  | [Select Featured]|
  +----------------+  +------------------+

STEP 5: REVIEW & SUBMIT
  Preview of listing as it will appear
  [Edit] [Submit Listing]
  On submit: "Your listing is under review. We'll notify you within 48 hours."
```

### STEP 5: Listing Management Dashboard

**Screen: `/dashboard/listing`**

```
LISTING DASHBOARD:
-------------------------------------------------------------------
OVERVIEW:
  Views this month: 1,247
  Click-throughs: 89
  Profile completion: 85%
  [Edit Listing] [Promote Listing]

LISTING EDITOR:
  Same fields as submission form
  Live preview on right side
  [Save Changes]

REVIEW MANAGEMENT:
  Average rating: 4.8 (24 reviews)
  Recent reviews with responses
  [Respond] [Report]

BILLING:
  Current plan: Featured (N15,000/year)
  Next renewal: Sep 15, 2026
  [Upgrade] [Downgrade] [Cancel]

ANALYTICS:
  Views chart (30 days)
  Top traffic sources
  Search terms leading to listing
  Demographic breakdown
```

### STEP 6: Analytics for Listed Entities

```
ANALYTICS DASHBOARD:
-------------------------------------------------------------------
METRICS:
  Total views: 1,247 (this month)
  Unique visitors: 892
  Click-throughs: 89 (7.1% CTR)
  Direction requests: 23
  Phone calls: 12
  Website clicks: 34

TRAFFIC SOURCES:
  Search: 45%
  Direct: 25%
  Social: 20%
  Newsletter: 10%

TOP SEARCH TERMS:
  "restaurant Jos North" - 234 views
  "Mama Dikko" - 189 views
  "traditional food Jos" - 156 views

PERIOD COMPARISON:
  This month vs last month: +12% views
  This month vs same month last year: +34% views
```

---

## 5. COMMUNITY JOURNEY — Browse to Lead

### STEP 1: Discovery of Community Section

| Path | Source | Behavior |
|------|--------|----------|
| A | Nav menu "Community" | Community hub page |
| B | Homepage "THE CONVERSATION" | 3 thread cards |
| C | Article comments | "Join the discussion" |
| D | Search results | Community threads in results |
| E | Newsletter | "From the Community" section |

### STEP 2: Account Creation for Participation

```
WHEN USER TRIES TO POST (not logged in):
  Modal: "Join the Plateau Conversation"
  "Create an account to participate in discussions."
  [Create Account] [Log In] (buttons)
  [Continue as Guest] (text link - read-only access)

ACCOUNT CREATION:
  Same as subscription journey Step 5
  Pre-selected role: "Community Member"
  Newsletter opt-in: Pre-checked
```

### STEP 3: First Post/Comment

```
NEW DISCUSSION:
  Click "New Discussion" button (orange)
  Modal/inline form:
    Topic dropdown: [Culture] [Politics] [Business] [General]
    Title input (required, max 120 chars)
    Rich text editor (body, required, min 50 chars)
    Tags: up to 5 pills (type + Enter to add)
    [Post Discussion] (orange button)
  On post:
    Thread appears at top (optimistic update)
    "Discussion posted successfully" toast
    If tags match user interests -> notification sent

FIRST COMMENT:
  Click comment input on article
  Rich text editor appears
  [Post Comment] (orange, right-aligned)
  Comment appears with fade-in (250ms)
  Author gets notification
  Toast: "Enjoying the discussion? Get weekly Plateau insights."
  [Subscribe to Newsletter] (in toast)
```

### STEP 4: Thread Participation

```
REPLY FLOW:
  Click "Reply" on any comment
  Inline reply editor appears below comment
  Auto-focused, [Cancel] and [Post Reply] buttons
  Type reply -> [Post Reply]
  Reply nested under parent (250ms fade-in)
  Parent author gets notification

ENGAGEMENT MICRO-INTERACTIONS:
  Like: Heart fills with onion color, count +1, small bounce (200ms)
  Reply: Inline editor slides down (250ms)
  Share: Dropdown appears below button (150ms)
  Bookmark: Bookmark fills, "Saved!" toast (200ms)
  Report: Reason dropdown appears (150ms)
```

### STEP 5: Building Reputation/Profile

**Screen: `/community/[user-slug]`**

```
USER PROFILE:
-------------------------------------------------------------------
[Avatar 96px]  User Name
               Member since Aug 2026
               [Community Member badge]
               156 reputation points

STATS:
  Discussions started: 12
  Comments posted: 89
  Likes received: 234
  Best answer: 8

BADGES:
  [First Post] [Popular Commenter] [Helpful Member]
  [Culture Expert] [Community Leader]

ACTIVITY:
  Recent discussions and comments
  [View All ->]
```

**Reputation System:**

| Action | Points |
|--------|--------|
| Post discussion | +10 |
| Post comment | +5 |
| Receive like | +2 |
| Best answer (selected by author) | +25 |
| First post of the day | +5 |
| 7-day streak | +50 |
| Report spam (confirmed) | +15 |

**Badge Thresholds:**

| Badge | Requirement |
|-------|-------------|
| First Post | 1 discussion |
| Popular Commenter | 50 comments |
| Helpful Member | 10 best answers |
| Culture Expert | 25 culture posts |
| Community Leader | 500 reputation points |

### STEP 6: Moderation Experience

```
REPORTED CONTENT:
  Click "Report" on comment/thread
  Reason dropdown: Spam, Harassment, Misinformation, Other
  Optional: description text area
  [Submit Report]
  Toast: "Report submitted. Our moderators will review."
  Content flagged for admin review

BANNED USER EXPERIENCE:
  Attempt to post: "Your account has been suspended."
  "Contact support@blossommagazine.ng for details."
  Read-only access maintained
```

---

## 6. ADVERTISER JOURNEY — Interest to Results

### STEP 1: Ad Placement Discovery

| Path | Source | Behavior |
|------|--------|----------|
| A | Nav "Advertise" | Advertising landing page |
| B | "List Your Business" CTA | Cross-sell to advertising |
| C | Contact page | Advertising inquiry form |
| D | Direct URL | /advertise |
| E | Sales outreach | Email/phone contact |

### STEP 2: Media Kit Access

**Screen: `/advertise`**

```
ADVERTISING LANDING PAGE:
-------------------------------------------------------------------
HERO: "Reach Plateau's Decision Makers"
      "BLOSSOM reaches 50,000+ Plateau State leaders, businesses,
       and cultural enthusiasts."

AUDIENCE STATS:
  Monthly readers: 50,000+
  Newsletter subscribers: 2,340+
  Social followers: 15,000+
  Average time on site: 4:32

AD PLACEMENTS:
  +------------------+  +------------------+
  | BANNER ADS       |  | SPONSORED CONTENT|
  | Leaderboard      |  | Native articles  |
  | Sidebar          |  | Brand features   |
  | In-article       |  | Event promotion  |
  | N50K-150K/month  |  | N200K-400K/piece |
  +------------------+  +------------------+

  +------------------+  +------------------+
  | LISTING BOOST    |  | NEWSLETTER SPONSOR|
  | Featured placement|  | Dedicated email  |
  | Premium badge    |  | Banner + text    |
  | Analytics        |  | N100K-300K/campaign|
  | N15K/year        |  |                  |
  +------------------+  +------------------+

[Download Media Kit] (onion button)
[Contact Sales] (orange button)
```

### STEP 3: Contact/Booking Flow

```
CONTACT FORM (modal or /advertise/contact):
  Name*: [                    ]
  Organization*: [                    ]
  Email*: [                    ]
  Phone: [+234 ...           ]
  Interest: [Banner Ads v]
  Budget range: [N50K-100K v]
  Message: [                    ]
  [Submit Inquiry] (orange button)
  Toast: "Thank you! Our sales team will contact you within 24 hours."
```

### STEP 4: Campaign Setup

```
CAMPAIGN BRIEF (collaborative with sales team):
  Campaign name: [                    ]
  Placement type: [Banner / Sponsored Content / Listing Boost]
  Duration: [Start date] - [End date]
  Target audience: [All / Business / Culture / Tourism]
  Creative assets: [Upload] (images, copy)
  Budget: [                    ]
  KPIs: [Impressions / Clicks / Conversions]

APPROVAL WORKFLOW:
  1. Advertiser submits creative
  2. Admin reviews (brand guidelines check)
  3. Revisions if needed
  4. Approval notification
  5. Campaign goes live
```

### STEP 5: Performance Reporting

```
CAMPAIGN DASHBOARD (advertiser view):
  Impressions: 45,230
  Clicks: 1,234 (2.7% CTR)
  Conversions: 89
  Cost per click: N0.12
  Budget remaining: N45,000

  Performance chart (daily views/clicks)
  Top performing placements
  Audience demographics
  [Download Report] [Renew Campaign]
```

---

## 7. ADMIN/EDITOR JOURNEY — Content to Analytics

### STEP 1: Article Creation and Publishing

**Screen: `/dashboard/admin`**

```
CONTENT MANAGEMENT:
-------------------------------------------------------------------
ARTICLES LIST:
  All | Drafts | Published | Archived | Scheduled
  Search: [                    ]
  Filter: [Category v] [Author v] [Date v]

  Table: Title | Author | Category | Status | Date | Actions
  Actions: [Edit] [Preview] [Delete]

CREATE NEW ARTICLE:
  Title: [                                        ]
  Slug: [auto-generated, editable                ]
  Category: [Culture & Heritage v]
  Tags: [type + Enter to add, max 10]
  Author: [Select author v]
  
  Featured Image: [Drag & drop or click]
  Alt text: [                                        ]
  
  Body: [Rich text editor with toolbar]
        Bold, Italic, Link, Quote, Image, Embed
        Word count: 0
  
  EXCERPT: [                                        ]
  (2-3 sentences, max 200 chars)
  
  SEO:
  Meta title: [auto-filled from title, editable    ]
  Meta description: [auto-filled from excerpt       ]
  Open Graph image: [auto-filled from featured      ]
  
  PUBLISHING OPTIONS:
  Status: [Draft v] / [Published v] / [Scheduled v]
  Schedule date: [Date picker]
  Premium content: [ ] (paywall toggle)
  
  [Save as Draft] (ghost button)
  [Preview] (ghost-sean button)
  [Publish] (orange button)
```

**Article Workflow:**

| Status | Description | Next Action |
|--------|-------------|-------------|
| Draft | Work in progress | Edit, Preview, or Publish |
| In Review | Submitted by contributor | Editor reviews |
| Scheduled | Set for future publish | Auto-publish on date |
| Published | Live on site | Edit, unpublish, or archive |
| Archived | Hidden from site | Restore or delete |

### STEP 2: Newsletter Campaign Creation

```
NEWSLETTER MANAGEMENT:
-------------------------------------------------------------------
CAMPAIGNS LIST:
  All | Drafts | Sent | Scheduled
  Table: Subject | Recipients | Open Rate | Click Rate | Date | Actions

CREATE CAMPAIGN:
  Subject line: [                                        ]
  Preview text: [                                        ]
  
  CONTENT BUILDER:
  +------------------------------------------+
  | [Header]  BLOSSOM Weekly                  |
  | [Hero]    [Select article or custom]     |
  | [Text]    [Edit text block]             |
  | [Divider] ---                            |
  | [Article] [Select article]              |
  | [Article] [Select article]              |
  | [Events]  [Auto-populate upcoming]      |
  | [CTA]     [Subscribe to Premium]        |
  | [Footer]  [Social links + legal]        |
  +------------------------------------------+
  
  RECIPIENTS:
  All subscribers: 2,340
  By preference: [Culture] [Business] etc.
  By engagement: Active / Inactive / New
  
  SCHEDULE:
  [Send Now] [Schedule for: Date Time]
  
  PREVIEW:
  [Desktop preview] [Mobile preview]
  [Send test email]
  
  [Send Campaign] (orange button)
  Confirmation modal: "Send to 2,340 subscribers?"
```

### STEP 3: Subscription and Payment Monitoring

```
SUBSCRIBER MANAGEMENT:
-------------------------------------------------------------------
OVERVIEW:
  Total subscribers: 2,340
  Premium subscribers: 1,247
  Free subscribers: 1,093
  MRR: N3,117,500
  Churn rate: 3.2%

SUBSCRIBER LIST:
  Search: [                    ]
  Filter: [Plan v] [Status v] [Joined v]
  Table: Name | Email | Plan | Status | Joined | Actions
  Actions: [View] [Edit] [Cancel] [Email]

SUBSCRIPTION ANALYTICS:
  New subscriptions (30 days): +89
  Cancellations (30 days): -23
  Net growth: +66
  LTV: N18,000
  CAC: N2,500
```

### STEP 4: Listing Management

```
LISTINGS MANAGEMENT:
-------------------------------------------------------------------
ALL LISTINGS: 493
  Pending review: 12
  Active: 456
  Featured: 89
  Unclaimed: 25

TABLE: Name | Type | LGA | Status | Featured | Actions
Actions: [Edit] [Approve] [Feature] [Remove]

PENDING CLAIMS: 8
  Table: Claimant | Listing | Method | Date | Actions
  Actions: [Approve] [Reject] [Request Info]

FEATURED PLACEMENTS:
  Current featured listings: 89
  [Add Featured] [Remove Featured]
  Rotation schedule: Monthly
```

### STEP 5: Community Moderation

```
COMMUNITY MODERATION:
-------------------------------------------------------------------
REPORTED CONTENT: 5 pending
  Table: Reporter | Content | Reason | Date | Actions
  Actions: [Approve] [Remove] [Warn User] [Ban User]

BANNED USERS: 3
  Table: User | Reason | Date | Expires | Actions
  Actions: [Unban] [Extend]

DISCUSSION RULES:
  [Edit rules] (rich text editor)
  Preview of community guidelines page
  [Save Changes]
```

### STEP 6: Analytics Dashboard

```
ADMIN ANALYTICS DASHBOARD:
-------------------------------------------------------------------
KPI CARDS:
  +------------+  +------------+  +------------+  +------------+
  | Page Views |  | Subscribers|  | Revenue    |  | Engagement |
  | 124,567    |  | 2,340      |  | N3.1M MRR  |  | 4:32 avg   |
  | +12% MoM   |  | +89 new    |  | +8% MoM   |  | +15% MoM   |
  +------------+  +------------+  +------------+  +------------+

CHARTS:
  Traffic over time (line chart)
  Revenue breakdown (pie chart: subscriptions, ads, listings)
  Subscriber growth (bar chart)
  Top articles (table: views, time on page, shares)
  Top listings (table: views, clicks, calls)
  Newsletter performance (open rate, click rate trend)
  Community growth (discussions, comments, active users)
```

---

## 8. INFORMATION ARCHITECTURE

### Content Organization

```
BLOSSOM SITE ARCHITECTURE:
-------------------------------------------------------------------

LEVEL 0: HOME (/)
  |
  +-- LEVEL 1: CONTENT SECTIONS
  |   +-- /blog (Articles listing)
  |   |   +-- /blog/[article-slug] (Individual article)
  |   |   +-- /blog/archives (Article archive)
  |   +-- /events (Events listing)
  |   |   +-- /events/[event-slug] (Individual event)
  |   |   +-- /events/submit (Event submission)
  |   +-- /listings (Directory)
  |   |   +-- /listings/[listing-slug] (Individual listing)
  |   |   +-- /listings/submit (New listing)
  |   |   +-- /listings/claim (Claim listing)
  |   +-- /community (Discussions hub)
  |   |   +-- /community/discussions/[thread-slug]
  |   |   +-- /community/topics
  |   |   +-- /community/members
  |   +-- /magazine (Digital reader)
  |       +-- /magazine/issues
  |       +-- /magazine/[issue-slug]
  |
  +-- LEVEL 1: CONVERSION SECTIONS
  |   +-- /subscribe (Pricing)
  |   |   +-- /subscribe/checkout
  |   |   +-- /subscribe/manage
  |   |   +-- /subscribe/gift
  |   |   +-- /subscribe/corporate
  |   +-- /newsletter (Landing + archive)
  |   |   +-- /newsletter/archive
  |   |   +-- /newsletter/manage
  |   +-- /advertise (Media kit + rates)
  |       +-- /advertise/rates
  |       +-- /advertise/submit
  |
  +-- LEVEL 1: AUTHORITY SECTIONS
  |   +-- /authors (Contributor profiles)
  |   |   +-- /authors/[author-slug]
  |   |   +-- /authors/contribute
  |   +-- /about (Mission + team)
  |   |   +-- /about/team
  |   |   +-- /about/advisory-board
  |   |   +-- /about/mission
  |   +-- /contact
  |   +-- /search
  |
  +-- LEVEL 1: ACCOUNT SECTIONS
  |   +-- /auth/login
  |   +-- /auth/register
  |   +-- /auth/forgot-password
  |   +-- /auth/verify-email
  |   +-- /dashboard (role-based routing)
  |       +-- /dashboard (Subscriber)
  |       +-- /dashboard/listing (Listed entity)
  |       +-- /dashboard/community (Community member)
  |       +-- /dashboard/author (Author)
  |       +-- /dashboard/admin (Admin panel)
  |
  +-- LEVEL 1: LEGAL SECTIONS
      +-- /legal/terms
      +-- /legal/privacy
      +-- /legal/cookies
      +-- /legal/refund
      +-- /legal/accessibility
```

### Content Taxonomy

**Categories (Primary):**

| Category | Color | Description |
|----------|-------|-------------|
| Culture & Heritage | Onion Purple (#5B2C6F) | Traditions, festivals, history |
| Politics & Governance | Dark blue-gray (#2C3E50) | Government, policy, elections |
| Business & Economy | Sean Green (#1E8449) | Commerce, startups, markets |
| Tourism & Travel | Teal (#16A085) | Destinations, hospitality |
| Education | Blue (#2980B9) | Schools, universities, learning |
| Arts & Entertainment | Orange (#E67E22) | Music, film, visual arts |
| Sports | Red (#C0392B) | Athletics, local teams |
| Development | Green (#27AE60) | Infrastructure, NGOs, progress |

**Tags (Secondary):**
- Freeform tags, up to 10 per article
- Examples: heritage, jos, tourism, youth, technology, agriculture

**Content Types:**
- Article (long-form journalism)
- Event (calendar item)
- Listing (directory entry)
- Discussion (community thread)
- Newsletter (email edition)
- Magazine (digital issue)

---

## 9. SEARCH EXPERIENCE

### Search Trigger

```
TRIGGER OPTIONS:
  1. Click search icon in navbar (desktop/mobile)
  2. Press Cmd/Ctrl+K (keyboard shortcut)
  3. Click search bar in mobile nav
  4. Navigate to /search?q=[query]
```

### Search Overlay (Desktop)

```
SEARCH OVERLAY:
-------------------------------------------------------------------
+--------------------------------------------------------------+
|                                                              |
|  [Search icon]  Search articles, listings, events...    Cmd+K |
|                                                              |
|  Max-width: 600px (idle) -> 800px (focused)                 |
|  Height: 48px                                                |
|  Border-radius: 24px (pill shape)                            |
|  Focus: 2px onion border + focus ring                        |
|                                                              |
|  RECENT SEARCHES                                             |
|  "Heritage Festival"                        [x]              |
|  "Jos restaurants"                          [x]              |
|                                                              |
|  TRENDING                                                    |
|  [Fire] "Plateau Budget 2026"                               |
|  [Fire] "Best hotels in Jos"                                |
|                                                              |
|  SUGGESTED CATEGORIES                                        |
|  [Culture] [Business] [Events] [Listings]                   |
|                                                              |
+--------------------------------------------------------------+
```

### Search Results (while typing)

```
RESULTS GROUPS (appear after 3+ characters, debounced 300ms):
-------------------------------------------------------------------
ARTICLES (max 3):
  [Image 60x40] Article Title
                Category . 8 min read
  
LISTINGS (max 3):
  [Image 60x40] Business Name
                Category . Location . Rating

EVENTS (max 3):
  [Image 60x40] Event Title
                Date . Location

PEOPLE (max 3):
  [Avatar 40px] Author Name
                Role . Article count

Each group has "View all [N] results" link
```

### Search Results Page

**Screen: `/search?q=[query]`**

```
SEARCH RESULTS PAGE:
-------------------------------------------------------------------
SEARCH BAR (at top, pre-filled with query)
FILTERS: [All] [Articles] [Listings] [Events] [People]

RESULTS: "Heritage Festival" - 24 results

ARTICLES (12):
  [Card] [Card] [Card]
  [Card] [Card] [Card]
  ... (3-col grid)

LISTINGS (6):
  [Card] [Card] [Card]
  [Card] [Card] [Card]

EVENTS (4):
  [Card] [Card]
  [Card] [Card]

PEOPLE (2):
  [Profile card] [Profile card]
```

### Keyboard Navigation

| Key | Action |
|-----|--------|
| ArrowDown | Move to next result |
| ArrowUp | Move to previous result |
| Enter | Select highlighted result |
| Escape | Close search overlay |
| Tab | Move between result groups |

---

## 10. NOTIFICATION SYSTEM

### In-App Notifications

**Notification Bell (navbar):**
- Icon: Bell with unread count badge (orange)
- Click: Dropdown panel with recent notifications
- [Mark all as read] link at top

**Notification Types:**

| Type | Trigger | Content |
|------|---------|---------|
| Comment reply | Someone replies to your comment | "X replied to your comment on [Article]" |
| Like | Someone likes your comment | "X liked your comment on [Article]" |
| Mention | Someone @mentions you | "X mentioned you in [Thread]" |
| New article | New article in followed category | "New in [Category]: [Article Title]" |
| Newsletter | Newsletter published | "BLOSSOM Weekly #24 is here" |
| Subscription | Payment confirmation/renewal | "Your subscription has been renewed" |
| Listing | Listing approved/updated | "Your listing has been approved" |
| Community | Thread you follow has new reply | "New reply in [Thread Title]" |

**Notification Dropdown:**
```
+------------------------------------------+
| NOTIFICATIONS                     [Clear] |
+------------------------------------------+
| [Avatar] X replied to your comment       |
|          "Great article!" · 2h ago       |
|                                          |
| [Avatar] X liked your comment            |
|          on "Heritage Festival" · 4h ago |
|                                          |
| New article in Culture:                  |
| "The Remarkable Story..." · 6h ago       |
|                                          |
| [View all notifications]                 |
+------------------------------------------+
```

### Email Notifications

| Type | Frequency | Content |
|------|-----------|---------|
| Newsletter | Weekly/Bi-weekly/Monthly | Digest of top stories |
| Comment reply | Real-time | "X replied to your comment" |
| Subscription renewal | Monthly/Annual | "Your subscription has been renewed" |
| Subscription expiry | 7 days before | "Your subscription expires soon" |
| Listing approved | Real-time | "Your listing is now live" |
| Community digest | Weekly | "Top discussions this week" |

### Push Notifications (Browser)

| Type | Trigger | Permission |
|------|---------|------------|
| Breaking news | Major story published | Opt-in during onboarding |
| Newsletter | Newsletter published | Opt-in during onboarding |
| Comment reply | Someone replies | Opt-in during onboarding |

**Push Notification Permission Flow:**
```
1. Trigger: After 3rd article read OR during onboarding
2. Browser native permission dialog
3. If allowed: "You'll receive notifications for breaking news and replies"
4. If denied: No further prompts (can enable in settings)
```

---

## 11. ONBOARDING FLOWS

### Reader Onboarding (Free User)

```
WELCOME SCREEN (first visit):
-------------------------------------------------------------------
+-----------------------------------------------------+
|                                                     |
|  Welcome to BLOSSOM                                  |
|  Plateau's Prestige Magazine                        |
|                                                     |
|  Discover the stories, culture, and people          |
|  that make Plateau State extraordinary.              |
|                                                     |
|  [Start Reading] (orange button)                     |
|  [Create Account] (ghost button)                     |
|                                                     |
+-----------------------------------------------------+

POST-REGISTRATION ONBOARDING:
-------------------------------------------------------------------
Step 1: "What topics interest you?"
  [Culture] [Politics] [Business] [Tourism]
  [Education] [Sports] [Arts] [Development]
  (Select 3+)
  [Continue ->]

Step 2: "How often do you want to hear from us?"
  o Daily digest
  * Weekly newsletter
  o Monthly roundup
  [Continue ->]

Step 3: "Follow BLOSSOM on social media"
  [Twitter] [Instagram] [Facebook] [LinkedIn]
  [Skip for now]

Step 4: "You're all set!"
  "Start exploring Plateau's stories."
  [Go to Homepage] (orange button)
```

### Subscriber Onboarding (Paid User)

See Subscription Journey Step 6: Post-Payment Onboarding

### Listed Entity Onboarding

```
POST-LISTING CREATION:
-------------------------------------------------------------------
Step 1: "Your listing is under review"
  "We'll notify you within 48 hours."
  [Go to Dashboard]

Step 2: (After approval)
  "Your listing is live!"
  [Edit Listing] [View Listing] [Promote Listing]

Step 3: Dashboard tour
  3-step tooltip walkthrough:
  1. "Edit your listing details here"
  2. "View analytics to track performance"
  3. "Respond to reviews from customers"
  [Finish Tour]
```

### Community Member Onboarding

```
POST-REGISTRATION:
-------------------------------------------------------------------
Step 1: "Join the Plateau Conversation"
  "Connect with fellow Plateau enthusiasts."
  [Browse Discussions] [Create First Discussion]

Step 2: Community guidelines
  "Before you post, please review our guidelines."
  [Read Guidelines] [I Understand]

Step 3: First interaction prompt
  "Start by introducing yourself!"
  "Tell us: What's your favorite thing about Plateau State?"
  [Post Introduction]
```

### Author/Contributor Onboarding

```
POST-APPROVAL:
-------------------------------------------------------------------
Step 1: "Welcome to the BLOSSOM Editorial Team"
  "You've been approved as a contributor."
  [Start Writing]

Step 2: Editorial guidelines
  "Please review our editorial standards."
  [Read Guidelines] [Download Style Guide]

Step 3: Dashboard tour
  1. "Create new articles here"
  2. "Track your article performance"
  3. "Manage your submissions"
  [Finish Tour]

Step 4: First article prompt
  "Ready to write your first article?"
  "What topic are you passionate about?"
  [Start Writing] [Browse Topics]
```

### Admin Onboarding

```
FIRST LOGIN:
-------------------------------------------------------------------
Step 1: "Welcome to BLOSSOM Admin"
  "Here's your command center."
  [Take Tour] [Skip]

Step 2: Quick setup checklist
  [ ] Configure payment gateways
  [ ] Set up email templates
  [ ] Create first newsletter
  [ ] Review pending listings
  [ ] Set up analytics
  [Complete Setup] [Do Later]

Step 3: Dashboard overview
  Live tour of admin panel with tooltips
  [Finish Tour]
```

---

**Document Status:** Complete
**Last Updated:** August 18, 2026
**Developer Handoff:** Ready
**Next Steps:** Implement journey flows, test with users, iterate
