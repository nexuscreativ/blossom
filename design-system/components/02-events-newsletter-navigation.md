# BLOSSOM — UI Component Catalog: Event Cards, Newsletter, Navigation

---

## EVENT CARD: List View

```
+--------+---------------------------------------------+
|        |                                             |
| DATE   |  [Event Image - 80x80px, rounded-md]       |
| BLOCK  |                                             |
|        |  Event Title                                |  <- Playfair 600, text-lg
| SEP    |  Location . Time                            |  <- Inter 400, text-sm, ash
| 15     |  [Category pill]  [124 RSVPs]               |
|        |                                             |
+--------+---------------------------------------------+

Date Block:
  Width: 80px, height: 100%
  Background: onion (#5B2C6F)
  Text color: white
  Display: flex, column, center
  Month: Inter 500, 12px, uppercase, letter-spacing 0.05em
  Day: Playfair 700, 28px
  Border-radius: 12px 0 0 12px

Card:
  Layout: flex, row
  Border: 1px solid silver
  Border-radius: 12px
  Shadow: shadow-sm
  Hover: shadow-md, border onion-100
  Padding: 16px
  Gap: 16px
```

---

## EVENT CARD: Grid View

```
+---------------------------------------------+
|                                             |
|  [Event Banner - 16:9 ratio]                |
|                          +--------+         |
|                          | SEP 15 |         |  <- Date badge overlay
|                          +--------+         |     Orange bg, white text
|                                             |     Position: absolute, top-right
+---------------------------------------------+     Padding: 8px 12px
|                                             |     Border-radius: 0 0 0 8px
|  Event Title                                |  <- Playfair 600, text-lg
|  Location . Category                        |  <- Inter 400, text-sm, ash
|  124 RSVPs                                  |  <- Inter 500, text-xs, onion
|                                             |
|  [RSVP - Free] (orange button, 100% width)  |  <- or "Sold Out" (disabled gray)
|                                             |
+---------------------------------------------+

Border-radius: 12px
Border: 1px solid silver
Shadow: shadow-sm
Hover: shadow-lg, translateY(-4px)
```

### Event Card States

| State | Changes |
|-------|---------|
| Default | shadow-sm, silver border |
| Hover | shadow-md/lift |
| Featured | Gold top border (3px), "FEATURED" badge |
| Past | Opacity 0.6, desaturated image, "Past" badge |
| Cancelled | Red badge, strikethrough title, disabled button |
| Sold Out | Gray badge, disabled RSVP button |

---

## NEWSLETTER SIGNUP: Inline (Homepage/Article Sidebar)

```
+---------------------------------------------+
|                                             |
|  [Mail icon]                                |  <- 24px, onion color
|  STAY CONNECTED                             |  <- Playfair 600, text-xl, ink
|                                             |
|  Weekly Plateau insights in your inbox.     |  <- Inter 400, text-sm, graphite
|  Join 2,340 subscribers.                    |
|                                             |
|  +----------------------------+ +----------+|
|  | your@email.com             | |Subscribe ||  <- Input: h-48px, 16px text
|  +----------------------------+ +----------+|     Button: orange bg, white
|                                             |     min-width: 120px
|  No spam. Unsubscribe anytime.              |  <- Inter 400, text-xs, ash
|                                             |
+---------------------------------------------+

Background: onion-50 (#F4ECF7)
Border-radius: 12px
Padding: 32px
Border: none
```

### Form States

| State | Input | Button |
|-------|-------|--------|
| Default | White bg, silver border | Orange bg, "Subscribe" |
| Focus | Onion border, focus ring | Orange bg |
| Submitting | Disabled, opacity 0.7 | Spinner icon |
| Success | Green border | "Subscribed!" green bg |
| Error | Red border | "Error" red bg |
| Already sub | Info border | "Manage" link |

---

## NEWSLETTER SIGNUP: Sticky Banner (Bottom)

```
+---------------------------------------------------------------+
|  [Mail] Get Plateau's best stories weekly. [Email] [Subscribe] [x]  |
+---------------------------------------------------------------+

Fixed at bottom: 0
Full width, height: 64px
Background: onion-900 (#2C0E37)
Text: white
z-index: 200
Input: white bg, h-40px, max-width: 300px
Button: orange bg, h-40px
Dismiss: [x] button, 44x44px touch target
Animation: slide up from bottom on scroll past 50%
Padding: 0 24px
Safe area: env(safe-area-inset-bottom)
```

---

## NEWSLETTER SIGNUP: Modal (Exit Intent)

```
+---------------------------------------------+
|                                     [x]     |
|                                             |
|  +---------------------------------------+  |
|  |  [Editorial image - 100% width]       |  |  <- Max-height: 200px
|  |  Border-radius: 12px 12px 0 0         |  |     Object-fit: cover
|  +---------------------------------------+  |
|                                             |
|  JOIN 2,340 PLATEAU ENTHUSIASTS            |  <- Inter 600, uppercase
|                                             |     letter-spacing: 0.05em
|  Weekly stories of culture, heritage,       |  <- Source Serif 4, text-base
|  and development from Plateau State.        |     graphite
|                                             |
|  [First Name - full width]                  |  <- Stacked form
|  [Email Address - full width]               |     Each: h-48px
|                                             |
|  [Subscribe Now - full width, orange]       |  <- h-48px
|                                             |
|  No spam. Unsubscribe anytime.              |  <- text-xs, ash
|  By subscribing, you agree to our           |
|  [Terms] and [Privacy Policy].              |
|                                             |
+---------------------------------------------+

Modal: max-width 440px, centered
Background: white
Border-radius: 16px
Shadow: shadow-2xl
Backdrop: rgba(0,0,0,0.5)
Animation: scale(0.95->1) + fade, 300ms ease
z-index: 400 (z-modal)
Trigger: after 60s on page, or exit intent
Frequency: once per session (localStorage)
```

---

## NAVIGATION BAR: Desktop

```
+---------------------------------------------------------------+
|                                                                 |
|  [BLOSSOM LOGO]   Blog   Events   Listings   Community   Magazine |
|  (160px wide)                                                      |
|                     Active: onion color, 2px bottom border        |
|                     Inactive: charcoal color                      |
|                     Font: Inter 500, 15px                         |
|                     Padding: 8px 16px (each item)                 |
|                                                                   |
|                              [Search] [Newsletter] [Subscribe] [Avatar] |
|                              40x40px  ghost btn   orange btn   36px |
|                                                                   |
+---------------------------------------------------------------+

Height: 72px
Background: white (default) / transparent (over hero)
Border-bottom: 1px solid silver (when solid)
Position: sticky, top: 0
z-index: 200
Transition: background 300ms, box-shadow 300ms

Scrolled state:
  Background: rgba(255,255,255,0.95)
  Backdrop-filter: blur(12px)
  Box-shadow: shadow-sm
  Border-bottom: 1px silver

Transparent (hero) state:
  Background: transparent
  Text: white
  No border
  Logo: white version
```

### Logo Spec

```
"BLOSSOM" text: Playfair Display 700, 24px
Tagline: "Plateau's Prestige" Inter 400, 10px, ash
Lockup width: ~160px
SVG format, responsive
Desktop: full logo lockup
Tablet: full lockup
Mobile icon: "B" monogram only (32x32px)
```

---

## NAVIGATION BAR: Mobile

```
+-----------------------------------+
|  [B] Logo        [Search] [Hamburger]  |
+-----------------------------------+

Height: 56px
Logo: "B" monogram (Playfair 700, 24px)
Search: 44x44px touch target
Hamburger: 44x44px touch target (3 horizontal lines)
  Active: transforms to X (rotate 45deg, 250ms)
```

---

## MOBILE HAMBURGER MENU

```
+-----------------------------------+
|  [BLOSSOM Logo]             [x]  |
|                                   |
|  --------------------------------|
|                                   |
|  [Search bar - full width]        |
|                                   |
|  --- BROWSE ---                   |
|                                   |
|  [icon] Blog                      |
|  [icon] Events                    |
|  [icon] Listings                  |
|  [icon] Community                 |
|  [icon] Magazine                  |
|                                   |
|  --- ACCOUNT ---                  |
|                                   |
|  [icon] Profile                   |  <- if logged in
|  [icon] My Dashboard              |
|  [icon] Saved Articles            |
|                                   |
|  --- MORE ---                     |
|                                   |
|  [icon] Newsletter                |
|  [icon] Advertise                 |
|  [icon] About                     |
|  [icon] Contact                   |
|                                   |
|  --------------------------------|
|                                   |
|  [Subscribe to Premium]           |  <- Full width, orange
|                                   |
|  --------------------------------|
|                                   |
|  [Twitter] [FB] [IG] [LinkedIn]  |
|                                   |
|  (c) 2026 BLOSSOM                 |
|                                   |
+-----------------------------------+

Animation: slide in from right, 300ms ease
Backdrop: rgba(0,0,0,0.5)
Width: 100% (max 400px)
Background: white
z-index: 900
Touch targets: all items min-height 48px
```

---

## BOTTOM NAVIGATION BAR (Mobile Only)

```
+-----------------------------------+
|                                   |
|         (page content)            |
|                                   |
+-----------------------------------+
|  Home    Search   News    Profile |
|   ^       ^       ^       ^      |
|   |       |       |       |      |
|   |       |       |       |      |
|  icons: 20px each                 |
|  labels: 10px, Inter 400         |
|  Active: onion color + label     |
|  Inactive: ash color             |
+-----------------------------------+

Height: 56px + env(safe-area-inset-bottom)
Background: white
Border-top: 1px silver
Shadow: shadow-md
z-index: 200

Shows on: Homepage, Listings, Events, Blog listing, Community
Hides on: Dashboard, Auth, Pricing, Article reading
```

---

## FOOTER: Desktop

```
+---------------------------------------------------------------+
|  BACKGROUND: ink (#1A1A1A)                                     |
|  TEXT: white / ash                                             |
|  PADDING: 80px top, 40px bottom                                |
|                                                                 |
|  +----------+----------+----------+----------+----------+     |
|  | BLOSSOM  | EXPLORE  | COMMUNITY| COMPANY  | CONNECT  |     |
|  |          |          |          |          |          |     |
|  | About    | Blog     | Discuss. | About    | Twitter  |     |
|  | Mission  | Events   | Guidel.  | Careers  | Facebook |     |
|  | Heritage | Listings | Top Mem. | Advertise| Instagram|     |
|  | Team     | Magazine |          | Press Kit| LinkedIn |     |
|  | Advisory | Categories|         |          | YouTube  |     |
|  |          | Newsletter|         |          | WhatsApp |     |
|  +----------+----------+----------+----------+----------+     |
|                                                                 |
|  -----------------------------------------------------------  |
|                                                                 |
|  NEWSLETTER MINI SIGNUP:                                        |
|  "Stay connected with Plateau" (Inter 500, text-sm, white)     |
|  [Email input 300px] [Subscribe button]                         |
|                                                                 |
|  -----------------------------------------------------------  |
|                                                                 |
|  [BLOSSOM Logo white]    Terms . Privacy . Cookies . Refund    |
|                           Accessibility . Sitemap               |
|                                                                 |
|  (c) 2026 Emerald Colours Nigeria Limited. All rights reserved. |
|                                                                 |
+---------------------------------------------------------------+

Footer column titles: Inter 600, text-sm, white, uppercase
Footer links: Inter 400, text-sm, ash (#9E9E9E)
Footer links hover: white, underline
Grid: 5 columns on xl+, 2 on lg, 1 on mobile
Max-width: 1280px, centered
```
