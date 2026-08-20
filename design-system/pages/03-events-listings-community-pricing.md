# BLOSSOM — Page Architecture: Events, Listings, Community, Pricing

---

## EVENTS PAGE (`/events`)

### Layout

```
+---------------------------------------------------------------+
|                     NAVIGATION BAR                              |
+---------------------------------------------------------------+
|                                                                 |
|  EVENTS HERO (Sean Green gradient subtle)                       |
|  "Discover Plateau" headline (Playfair 5xl)                     |
|  "Events, celebrations, and gatherings" (Source Serif text-lg)  |
|                                                                 |
|  +-----------------------------------------------------------+ |
|  | SEARCH & FILTER BAR                                        | |
|  | [Search events...] [Date] [Location] [Category]           | |
|  |                                                             | |
|  | Active filters: [Culture x] [Jos x] [Clear all]           | |
|  +-----------------------------------------------------------+ |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  FEATURED EVENT (full-width hero card)                          |
|  +-----------------------------------------------------------+ |
|  | [Large banner 16:9]                                        | |
|  |                                                             | |
|  |  EVENT BADGE: "FEATURED" (gold)                             | |
|  |  EVENT TITLE: "Plateau Heritage Festival 2026"             | |
|  |  Date: September 15-17, 2026                               | |
|  |  Location: Jos Museum, Jos                                 | |
|  |  [RSVP - Free] / [Buy Tickets - 5,000]                    | |
|  +-----------------------------------------------------------+ |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  VIEW TOGGLE: [List] [Calendar]                                |
|                                                                 |
|  LIST VIEW (default):                                          |
|  MONTH HEADER: "September 2026"                                |
|  +-----------------------------------------------------------+ |
|  | Event Card (horizontal):                                   | |
|  | +--------+------------------------------------------------+| |
|  | | DATE   | [Image 80x80]  Event Title                    || |
|  | | BLOCK  | Location . Time                               || |
|  | | SEP 15 | [Category] [124 RSVPs]                       || |
|  | +--------+------------------------------------------------+| |
|  +-----------------------------------------------------------+ |
|                                                                 |
|  CALENDAR VIEW:                                                |
|  +-----+-----+-----+-----+-----+-----+-----+                |
|  | Mon | Tue | Wed | Thu | Fri | Sat | Sun |                |
|  +-----+-----+-----+-----+-----+-----+-----+                |
|  |     |  1  |  2  |  3  |  4  |  5  |  6  |                |
|  |     |     |  o  |     |  o  |     |     | o = event dot   |
|  +-----+-----+-----+-----+-----+-----+-----+                |
|                                                                 |
|  "SUBMIT AN EVENT" (Sean Green ghost button)                   |
|                                                                 |
+---------------------------------------------------------------+
|                     FOOTER                                      |
+---------------------------------------------------------------+
```

### Event Card States

| State | Visual |
|-------|--------|
| Default | White bg, shadow-sm, silver border |
| Hover | shadow-md, translateY(-2px), onion-100 border |
| Featured | Gold top border (3px), shadow-md always |
| Past Event | Opacity 0.6, desaturated image, "Past" badge |
| Cancelled | Red badge, strikethrough title |
| Sold Out | Gray badge, disabled RSVP button |

---

## LISTINGS DIRECTORY (`/listings`)

### Layout

```
+---------------------------------------------------------------+
|                     NAVIGATION BAR                              |
+---------------------------------------------------------------+
|                                                                 |
|  DIRECTORY HERO                                                |
|  "Plateau's Directory" (Playfair 5xl)                          |
|  "Businesses, Personalities, Institutions"                     |
|                                                                 |
|  STAT ROW:                                                     |
|  [248 Businesses] [156 Personalities] [89 Institutions]        |
|  Each: number (text-3xl, onion) + label (text-sm, graphite)    |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  SEARCH & FILTER PANEL                                         |
|  +-----------------------------------------------------------+ |
|  | Search listings...  [Filter]  [Sort: Featured v]           | |
|  |                                                             | |
|  | FILTER ROW:                                                 | |
|  | [All Types v] [All LGAs v] [All Categories v]              | |
|  |                                                             | |
|  | ACTIVE FILTERS:                                             | |
|  | [Business x] [Jos North x] [Restaurants x] [Clear]         | |
|  +-----------------------------------------------------------+ |
|  Position: sticky, top: 72px                                    |
|                                                                 |
|  TABS: [All] [Businesses] [Personalities] [Institutions]       |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  RESULTS: Showing 1-12 of 248                                   |
|                                                                 |
|  GRID (3 cols desktop, 2 tablet, 1 mobile):                    |
|  +-----------+  +-----------+  +-----------+                   |
|  | COVER IMG |  | COVER IMG |  | COVER IMG |                   |
|  | 320x200   |  | 320x200   |  | 320x200   |                   |
|  +-----------+  +-----------+  +-----------+                   |
|  | * GOLD    |  |           |  | * GOLD    |                   |
|  | CATEGORY  |  | CATEGORY  |  | CATEGORY  |                   |
|  | Name      |  | Name      |  | Name      |                   |
|  | Location  |  | Location  |  | Location  |                   |
|  | Rating    |  | Rating    |  | Rating    |                   |
|  | Desc      |  | Desc      |  | Desc      |                   |
|  +-----------+  +-----------+  +-----------+                   |
|                                                                 |
|  [Load More Listings] (ghost button)                            |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  CTA: "List Your Business" (full-width banner)                  |
|  Background: onion gradient                                     |
|  "Get discovered by Plateau's readers"                          |
|  [Submit Listing ->] (orange button)                            |
|                                                                 |
+---------------------------------------------------------------+
|                     FOOTER                                      |
+---------------------------------------------------------------+
```

### Listing Card Specs

```
Width: 100% (in grid)
Padding: 20px internal
Border-radius: 12px
Border: 1px solid silver
Shadow: shadow-sm
Hover: shadow-lg, translateY(-4px), onion-100 border

Premium: Gold top border (3px solid --color-gold)
Claimed: Verified badge (green check) next to name
Unclaimed: "Claim this listing" ghost overlay on hover
Image: 100% width, 200px height, object-fit cover
Category pill: Sean Green bg, white text, Inter 500, 11px uppercase
Title: Playfair 600, text-lg
Location: Inter 400, text-sm, ash
Rating: Gold stars (12px), review count in graphite
Description: Inter 400, text-sm, graphite, 2 lines max, ellipsis
```

---

## COMMUNITY PAGE (`/community`)

### Layout

```
+---------------------------------------------------------------+
|                     NAVIGATION BAR                              |
+---------------------------------------------------------------+
|                                                                 |
|  COMMUNITY HEADER                                               |
|  "The Plateau Conversation" (Playfair 5xl)                      |
|  "Join discussions on culture, development, and heritage"       |
|                                                                 |
|  STATS: [1,247 Members] [342 Discussions] [5,891 Comments]    |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  +-----------------------------------+  +-------------------+  |
|  | MAIN FEED                          |  | SIDEBAR           |  |
|  |                                   |  |                   |  |
|  | [New Discussion] (orange button)  |  | ACTIVE TOPICS     |  |
|  |                                   |  | [Culture]         |  |
|  | SORT: [Latest] [Popular] [Unans.] |  | [Politics]        |  |
|  |                                   |  | [Business]        |  |
|  | +-------------------------------+ |  | [Education]       |  |
|  | | THREAD CARD                   | |  |                   |  |
|  | |                               | |  | LEADERBOARD       |  |
|  | | [Avatar] Author . 2h ago      | |  | 1. Name (45 pts)  |  |
|  | | Thread Title (bold, text-lg)  | |  | 2. Name (38 pts)  |  |
|  | | First 2 lines of content...  | |  | 3. Name (32 pts)  |  |
|  | |                               | |  |                   |  |
|  | | [Culture] [12 replies]        | |  | TOP POSTS         |  |
|  | | [Like 24] [Reply] [Share]     | |  | (trending thread) |  |
|  | +-------------------------------+ |  |                   |  |
|  |                                   |  | NEWSLETTER CTA    |  |
|  | [Load More]                        |  | (inline signup)   |  |
|  +-----------------------------------+  +-------------------+  |
|                                                                 |
+---------------------------------------------------------------+
|                     FOOTER                                      |
+---------------------------------------------------------------+
```

### Thread View (`/community/discussions/[slug]`)

```
+---------------------------------------------------------------+
|  [Back arrow] Category badge                                   |
|  Thread Title (Playfair 4xl)                                   |
|  Author: [Avatar] Name . Role badge . Posted 3h ago            |
+---------------------------------------------------------------+
|                                                                 |
|  Original Post:                                                 |
|  [Author Avatar 48px] Author Name                              |
|  Posted: 3h ago                                                 |
|  Full text content...                                           |
|  [Like 24] [Reply] [Share] [Report]                            |
|                                                                 |
|  Replies (sorted: Latest / Most Liked):                        |
|  +-----------------------------------------------------------+ |
|  | [Avatar 36px] Name . 2h ago                               | |
|  | Reply text...                                              | |
|  | [Like 8] [Reply] [Report]                                 | |
|  |                                                            | |
|  |   [Avatar 28px] Name . 1h ago (nested, 32px indent)      | |
|  |   Nested reply text...                                     | |
|  |   [Like 3] [Reply] [Report]                               | |
|  +-----------------------------------------------------------+ |
|                                                                 |
|  Reply Input:                                                   |
|  [User Avatar] "Write a reply..."                              |
|  [Rich text area] [Post Reply]                                  |
|                                                                 |
+---------------------------------------------------------------+
```

---

## SUBSCRIPTION / PRICING PAGE (`/subscribe`)

### Layout

```
+---------------------------------------------------------------+
|                     NAVIGATION BAR                              |
+---------------------------------------------------------------+
|                                                                 |
|  PRICING HERO                                                   |
|  Background: Onion Purple gradient                              |
|  "SUBSCRIPTION PLANS" (Inter 500, uppercase, orange)           |
|  "Unlock Plateau's Complete Story" (Playfair 5xl, white)       |
|  "Choose the plan that fits your journey." (Source Serif)       |
|  Height: 400px                                                  |
|                                                                 |
|  TOGGLE: [Monthly] [Annual - Save 33%]                         |
|  Toggle switch: 200px wide, 48px height                         |
|  Active bg: onion, knob: white 40x40px                         |
|  "Save 33%" badge: Sean Green bg                               |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  PRICING CARDS (3 columns)                                      |
|                                                                 |
|  +---------------+  +---------------+  +---------------+       |
|  | READER        |  | * PREMIUM     |  | INSTITUTION   |       |
|  | (Free)        |  | (Featured)    |  | (Corporate)   |       |
|  |               |  |               |  |               |       |
|  | 0/mo          |  | 2,500/mo      |  | Custom        |       |
|  |               |  | 20,000/yr     |  | Pricing       |       |
|  |               |  | (Save 33%)    |  |               |       |
|  |               |  |               |  |               |       |
|  | v Features:  |  | v All Free   |  | v All Premium |       |
|  | v 5 articles |  |   features   |  |   features    |       |
|  | v Events     |  | v Unlimited  |  | v 50 seats    |       |
|  | v Basic      |  | v Premium    |  | v Analytics   |       |
|  |   listings   |  |   badge      |  | v API access  |       |
|  | v Community  |  | v Ad-free    |  | v Custom      |       |
|  |              |  | v Exclusive  |  |   branding    |       |
|  |              |  |   content    |  | v Priority    |       |
|  |              |  | v Community  |  |   support     |       |
|  |              |  |   badge      |  |               |       |
|  |              |  | v Early      |  |               |       |
|  |              |  |   access     |  |               |       |
|  |              |  | v Monthly    |  |               |       |
|  |              |  |   digest     |  |               |       |
|  |              |  |               |  |               |       |
|  | [Get Started]|  |[Subscribe *] |  |[Contact Sales]|       |
|  | (ghost btn)  |  | (orange btn) |  | (onion btn)   |       |
|  +---------------+  +---------------+  +---------------+       |
|                                                                 |
|  Premium card: onion border (2px), shadow-onion,               |
|                 "MOST POPULAR" badge at top                     |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  FAQ ACCORDION                                                 |
|  [>] What's included in the free tier?                         |
|  [>] Can I upgrade or downgrade anytime?                        |
|  [>] Is there a student discount?                              |
|  [>] How do I cancel my subscription?                           |
|  [>] Can I get a refund?                                        |
|                                                                 |
|  Accordion: border-bottom 1px silver                            |
|  Open: onion arrow, expanded content                            |
|  Animation: max-height transition, 300ms                        |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  TESTIMONIALS                                                   |
|  "What Our Readers Say" (Playfair 5xl)                         |
|  3 testimonial cards (quote, author, avatar)                   |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  NEWSLETTER CTA                                                 |
|  "Not ready to subscribe? Get our free newsletter."            |
|  [Email input] [Subscribe]                                      |
|                                                                 |
+---------------------------------------------------------------+
|                     FOOTER                                      |
+---------------------------------------------------------------+
```

### Pricing Card States

| State | Visual |
|-------|--------|
| Default | White bg, shadow-sm, silver border |
| Hover | shadow-lg, onion-100 border |
| Popular (Premium) | Onion border 2px, shadow-onion, "MOST POPULAR" badge |
| Selected | Border onion-500, light onion background |
| Annual toggle active | Shows annual price, "Save 33%" badge |
| Mobile | Full width, stacked vertically |

---

## COMPONENT CATALOG SUMMARY

See individual component files:
- `components/01-article-cards.md`
- `components/02-listing-cards.md`
- `components/03-event-cards.md`
- `components/04-newsletter-forms.md`
- `components/05-navigation.md`
- `components/06-search.md`
- `components/07-pills-tags.md`
- `components/08-share-comment.md`
- `components/09-hero-sections.md`
