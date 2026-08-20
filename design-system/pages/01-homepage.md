# BLOSSOM — Page Architecture: Homepage

## Layout Structure

```
+---------------------------------------------------------------+
|                     GLOBAL NAVIGATION BAR                       |
|  [BLOSSOM Logo]  Blog  Events  Listings  Community  Magazine   |
|                         [Search]  [Newsletter]  [Subscribe] [^]|
|  Height: 72px | Position: sticky, top: 0 | z-index: 200       |
+---------------------------------------------------------------+
|                                                                 |
|                       HERO SECTION                              |
|  +-----------------------------------------------------------+ |
|  | Full-width feature image (16:9, min-height: 560px)        | |
|  |                                                           | |
|  |  +-----------+                                            | |
|  |  | CATEGORY  |  "CULTURE & HERITAGE" pill                | |
|  |  | PILL      |  Sean Green bg, white text                 | |
|  |  +-----------+                                            | |
|  |                                                           | |
|  |  HEADLINE TEXT                                            | |
|  |  Playfair Display 700, white, text-6xl                    | |
|  |  "The Remarkable Story of Plateau's..."                   | |
|  |                                                           | |
|  |  Deck text in Source Serif 4 (text-xl, white 90%)         | |
|  |  "A compelling summary that draws readers..."             | |
|  |                                                           | |
|  |  [Avatar] Author Name  .  8 min read  .  [PREMIUM]       | |
|  |  [Read Article ->] (ghost button, white border)           | |
|  |                                                           | |
|  +-----------------------------------------------------------+ |
|  Gradient overlay: transparent 30% to rgba(0,0,0,0.7) 100%    |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  SECTION: Editor's Picks (3-column grid)                       |
|  ---------------------------------------------------------------|
|  "EDITOR'S PICKS"  Playfair Display 600, text-3xl              |
|  Gold underline decoration (40px, 2px, --color-gold)           |
|                                                                 |
|  +-----------+  +-----------+  +-----------+                   |
|  | IMAGE     |  | IMAGE     |  | IMAGE     |                   |
|  | 16:9      |  | 16:9      |  | 16:9      |                   |
|  +-----------+  +-----------+  +-----------+                   |
|  | Category  |  | Category  |  | Category  |                   |
|  | Title     |  | Title     |  | Title     |                   |
|  | Excerpt   |  | Excerpt   |  | Excerpt   |                   |
|  | Meta      |  | Meta      |  | Meta      |                   |
|  +-----------+  +-----------+  +-----------+                   |
|                                                                 |
|  Grid: 3 cols desktop, 2 tablet, 1 mobile                      |
|  Gap: 32px (desktop), 20px (mobile)                            |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  SECTION: Trending Now (horizontal scroll)                      |
|  ---------------------------------------------------------------|
|  "TRENDING"  Inter 700, uppercase, letter-spacing 0.05em       |
|  Animated pulse dot (onion color, 8px, 1s pulse)               |
|                                                                 |
|  [Card 01] [Card 02] [Card 03] [Card 04] [Card 05] ->        |
|  Compact cards: number + small image + title + meta             |
|  Height: 64px per card                                          |
|  Scroll: horizontal, snap-x, hide scrollbar                     |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  SECTION: Category Showcase (tabbed)                            |
|  ---------------------------------------------------------------|
|  [Culture] [Politics] [Business] [Tourism] [Sports]            |
|  Tab font: Inter 500, 14px                                      |
|  Active: onion color, 2px bottom border                         |
|  Inactive: graphite color                                       |
|                                                                 |
|  Content per tab:                                               |
|  +-----------------------------------------------------+       |
|  | Featured article (large, 60% width)                  |       |
|  | + 2 sidebar articles (stacked, 40% width)           |       |
|  +-----------------------------------------------------+       |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  SECTION: Latest + Sidebar                                      |
|  ---------------------------------------------------------------|
|  +-----------------------------------+  +-------------------+  |
|  | MAIN CONTENT (8 cols / 66.67%)    |  | SIDEBAR (4 /33%)  |  |
|  |                                   |  |                   |  |
|  | 2-column article list:            |  | Newsletter CTA    |  |
|  | [img] Title  [img] Title         |  | (onion-50 bg)     |  |
|  | [img] Title  [img] Title         |  |                   |  |
|  | [img] Title  [img] Title         |  | Featured Listing  |  |
|  | [img] Title  [img] Title         |  | (gold border)     |  |
|  |                                   |  |                   |  |
|  | [Load More] (ghost button)        |  | Upcoming Event    |  |
|  |                                   |  | (event card)      |  |
|  +-----------------------------------+  +-------------------+  |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  SECTION: Featured Listings Carousel                            |
|  ---------------------------------------------------------------|
|  "PLATEAU'S FINEST"  Playfair Display 600, text-3xl            |
|                                                                 |
|  4 listing cards (business, personality, institution, business) |
|  Horizontal scroll on mobile, grid on desktop                   |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  SECTION: Events Preview                                        |
|  ---------------------------------------------------------------|
|  "WHAT'S HAPPENING"  Playfair Display 600, text-3xl            |
|                                                                 |
|  3 event cards in row                                           |
|  [View All Events ->] (Sean Green ghost button)                |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  SECTION: Community Pulse                                       |
|  ---------------------------------------------------------------|
|  "THE CONVERSATION"  Playfair Display 600, text-3xl            |
|                                                                 |
|  3 discussion thread cards                                      |
|  Each: title, author avatar, reply count, timestamp            |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  SECTION: Subscription CTA (full-width)                         |
|  ---------------------------------------------------------------|
|  Background: onion-900 gradient                                 |
|  "Unlock Plateau's Story" (Playfair 700, white, text-5xl)     |
|  3 pricing tier preview cards (compact)                         |
|  [Choose Your Plan ->] (orange button)                          |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|  SECTION: Partners / Sponsors Row                               |
|  ---------------------------------------------------------------|
|  Background: pearl (#F5F5F5)                                    |
|  Partner logos in single row (grayscale, hover: full color)    |
|  Horizontal scroll on mobile                                    |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|                       FOOTER                                    |
|  ---------------------------------------------------------------|
|  Background: ink (#1A1A1A)                                      |
|  5-column grid (About, Explore, Community, Company, Connect)   |
|  Newsletter mini-signup                                         |
|  Legal links row                                                |
|  Copyright: 2026 Emerald Colours Nigeria Ltd.                   |
|                                                                 |
+---------------------------------------------------------------+
```

## Component Inventory

| Component | Count | Key Specs |
|-----------|-------|-----------|
| Navigation Bar | 1 | h-72px, sticky, transparent-to-solid |
| Hero Section | 1 | Full-bleed, 560px min-height, gradient overlay |
| Featured Article Card (large) | 3 | 3-col grid, image 16:9, Playfair title |
| Compact Article Card | 6+ | Horizontal, 64px height, number + title |
| Category Tab System | 1 | 5 tabs, horizontal scroll on mobile |
| Sidebar Newsletter CTA | 1 | onion-50 bg, inline form, orange CTA |
| Sidebar Featured Listing | 1 | Gold top border, premium badge |
| Listing Card (featured) | 4 | Image + category + name + rating |
| Event Card | 3 | Date badge + title + location + RSVP |
| Community Thread Card | 3 | Title + author + reply count |
| Subscription CTA Section | 1 | Full-width dark bg, pricing preview |
| Partner Logo Carousel | 1 | Grayscale logos, hover color |
| Footer | 1 | 5-col, newsletter mini, legal links |

## Desktop Grid Specifications

```
Content container: max-width 1280px, centered
Main content area: 8 columns (66.67%)
Sidebar: 4 columns (33.33%)
Grid gap: 32px
Outer padding: 64px each side (xl), 80px (2xl)
Section vertical padding: 96px (desktop), 48px (mobile)
```

## Mobile Layout Changes

| Element | Desktop | Mobile |
|---------|---------|--------|
| Hero | Full-bleed overlay, 560px | Stacked (image + text below), 400px |
| Hero headline | text-6xl (60px) | text-3xl (30px) |
| Featured articles | 3-col grid | Single column, full width |
| Trending | Horizontal scroll | Horizontal swipe carousel |
| Category tabs | Horizontal scroll | Horizontal scroll, smaller |
| Latest articles | 2-col grid | Single column |
| Sidebar | Right column | Below main content |
| Listings carousel | 4 cards visible | 1 card, snap scroll |
| Events | 3 cards row | 1 card, swipeable |
| Footer | 5-col grid | Accordion columns |
| Bottom nav bar | Hidden | Visible (Home, Search, News, Profile) |
