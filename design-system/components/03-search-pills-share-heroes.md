# BLOSSOM — UI Component Catalog: Search, Pills, Share, Comment, Heroes

---

## SEARCH BAR: Desktop

```
+--------------------------------------------------------------+
|                                                              |
|  +--------------------------------------------------------+ |
|  |  [Search icon]  Search articles, listings, events...    | |
|  |                           Cmd+K                         | |
|  +--------------------------------------------------------+ |
|                                                              |
|  Max-width: 600px (idle) -> 800px (focused)                 |
|  Height: 48px                                                |
|  Border-radius: 24px (pill shape)                            |
|  Border: 1px solid silver                                    |
|  Background: white                                           |
|  Padding-left: 48px (for icon), padding-right: 80px         |
|  Font: Inter 400, text-base, ash placeholder                 |
|                                                              |
|  Focus state:                                                |
|  - Border: 2px solid onion                                   |
|  - Box-shadow: 0 0 0 4px rgba(91,44,111,0.1)               |
|  - Width expands to 800px (transition: 300ms)                |
|  - Shows search overlay below                                |
|                                                              |
|  Keyboard shortcut badge:                                    |
|  "Cmd+K" or "Ctrl+K" in Inter 500, text-xs, ash             |
|  Background: pearl, padding: 2px 8px, border-radius: 4px    |
|                                                              |
+--------------------------------------------------------------+
```

### Search Overlay (on focus/typing)

```
+--------------------------------------------------------------+
|  RECENT SEARCHES                                             |
|  "Heritage Festival"                           [x]          |
|  "Jos restaurants"                             [x]          |
|                                                              |
|  TRENDING                                                    |
|  [Fire icon] "Plateau Budget 2026"                          |
|  [Fire icon] "Best hotels in Jos"                           |
|                                                              |
|  SUGGESTED CATEGORIES                                        |
|  [Culture] [Business] [Events] [Listings]                   |
+--------------------------------------------------------------+

Position: absolute below search input
Width: matches search input width
Background: white
Border: 1px silver
Border-radius: 12px
Shadow: shadow-xl
Padding: 16px
Max-height: 400px, scroll-y: auto
z-index: 500 (z-popover)

Results groups (while typing):
  Articles: max 3 results
  Listings: max 3 results
  Events: max 3 results
  People: max 3 results
  Each group has "View all X results" link
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

## SEARCH BAR: Mobile

```
Full-width input at top of page
Height: 48px
Border-radius: 12px
Sticky below nav
Cancel button: "Cancel" text in onion color (right side)
On cancel: clears input, hides results, returns focus
```

---

## CATEGORY / TAG PILLS

### Category Pill (Large - for cards/headers)

```
CULTURE & HERITAGE

Font: Inter 600, 11px, uppercase, letter-spacing: 0.05em
Background: varies by category (onion, sean-green, etc.)
Text: white
Padding: 4px 12px
Border-radius: 4px
Height: 24px
```

### Tag Pill (Small - for filtering/tags)

```
Heritage

Font: Inter 500, 12px
Background: pearl (#F5F5F5)
Text: graphite (#616161)
Border: 1px solid silver
Padding: 2px 10px
Border-radius: 16px (pill shape)
Height: 28px
Hover: onion bg, white text, 150ms transition
```

### Tag Pill (Selected/Active)

```
Background: onion (#5B2C6F)
Text: white
Border-color: onion
```

### Category Color Map

| Category | Pill Color |
|----------|-----------|
| Culture & Heritage | onion (#5B2C6F) |
| Politics & Governance | #2C3E50 (dark blue-gray) |
| Business & Economy | sean-green (#1E8449) |
| Tourism & Travel | #16A085 (teal) |
| Education | #2980B9 (blue) |
| Arts & Entertainment | orange (#E67E22) |
| Sports | #C0392B (red) |
| Opinion | #8E44AD (purple-light) |
| Development | #27AE60 (green) |

---

## SOCIAL SHARE BUTTONS

```
Share row:
[Twitter] [Facebook] [LinkedIn] [WhatsApp] [Copy Link]

Each button:
  Icon: 20px, currentColor (from Lucide/Heroicons)
  Background: pearl (#F5F5F5)
  Border-radius: 8px
  Size: 40px x 40px (meets 44px touch target with padding)
  Hover: brand color bg + white icon
  Transition: all 150ms ease

Brand hover colors:
  Twitter:  #1DA1F2
  Facebook: #4267B2
  LinkedIn: #0077B5
  WhatsApp: #25D366
  Copy:     onion (#5B2C6F)

Copy button states:
  Default: [Link icon] "Copy" (text, 40px wide)
  Success: [Check icon] "Copied!" (Sean Green, 2s duration, then revert)
```

### Share Button Tooltip

```
Position: above button
Text: "Share on Twitter" (etc.)
Font: Inter 400, text-xs, white
Background: ink (#1A1A1A)
Padding: 4px 8px
Border-radius: 4px
Arrow: 6px, pointing down
Delay: 300ms on hover
```

---

## COMMENT SYSTEM

### Comment Input

```
+-----------------------------------------------+
|                                               |
|  [User Avatar 36px]                           |
|  +-----------------------------------------+ |
|  |  Join the discussion...                 | |  <- Placeholder
|  |                                         | |     Inter 400, text-base, ash
|  |                                         | |     Min-height: 80px
|  |                                         | |     Border: 1px silver
|  |                                         | |     Border-radius: 8px
|  +-----------------------------------------+ |     Padding: 12px
|                                               |     On focus: onion border
|  +-----------------------------------------+ |     focus ring: onion-15%
|  |  [Post Comment]                         | |  <- Only visible when text entered
|  +-----------------------------------------+ |     Orange bg, white text
|                                               |     Right-aligned
+-----------------------------------------------+

Rich text features:
  Bold, Italic, Link, Quote, List
  Toolbar: border-bottom 1px silver
  Icons: 20px, ash color, hover: onion
```

### Comment Card

```
+-----------------------------------------------+
|                                               |
|  [Avatar 36px]  Author Name  . 2 hours ago   |  <- Name: Inter 600, text-sm
|                  [Editor] badge                |     Time: Inter 400, text-xs, ash
|                                               |
|  Comment text content goes here in            |  <- Source Serif 4, text-base
|  Source Serif 4, 15px, charcoal color.        |     charcoal (#333333)
|  Max-width: 100% of container.               |
|                                               |
|  [Like 12]  [Reply]  [Report]                |  <- Inter 500, text-xs, ash
|                                               |     Like: heart icon (20px)
|  +-------------------------------------------+|     Fills with onion on click
|  |  [Avatar 28px] Reply Author . 1h ago     ||     Count +1, 200ms animation
|  |  Reply text...                            ||
|  |  [Like 3]  [Reply]  [Report]             ||  <- Nested: 32px indent
|  +-------------------------------------------+|     Avatar: 28px
|                                               |
+-----------------------------------------------+

Comment states:
  New: briefly highlighted onion-50 bg (2s fade)
  Edited: "(edited)" tag in ash
  Reported: 3px red left border
  Deleted: "This comment has been removed" in ash, italic
  Pinned: "Pinned" badge, onion bg

Role badges:
  Editor:      onion bg, white text, Inter 600, 10px
  Contributor: sean bg, white text
  Member:      silver bg, graphite text
```

### Comment Thread Nesting

```
Max depth: 3 levels (root > reply > reply)
Indent per level: 32px
Avatar sizes: 36px (root), 28px (reply), 24px (nested)
Divider: 1px solid silver between top-level comments
Thread indicator: 2px solid onion-100 vertical line
```

---

## HERO SECTION: Variant A (Full-Bleed Editorial)

```
+---------------------------------------------------------------+
|  [Full-width image, 16:9, min-height: 560px desktop]         |
|                                                               |
|  Gradient overlay: linear-gradient(transparent 30%,          |
|    rgba(0,0,0,0.8) 100%)                                     |
|                                                               |
|  +---------------------------------------------------------+ |
|  |  Content (positioned absolute, bottom-left)             | |
|  |  Padding: 80px (desktop), 24px (mobile)                 | |
|  |                                                         | |
|  |  +-----------+                                          | |
|  |  | CATEGORY  |  Sean Green bg, white text               | |
|  |  | PILL      |  Inter 600, 11px, uppercase              | |
|  |  +-----------+                                          | |
|  |                                                         | |
|  |  HEADLINE TEXT                                          | |
|  |  Playfair Display 700, white                            | |
|  |  text-7xl (72px) on 3xl+ screens                       | |
|  |  text-6xl (60px) on xl                                  | |
|  |  text-5xl (48px) on lg                                  | |
|  |  text-4xl (36px) on md                                  | |
|  |  text-3xl (30px) on mobile                              | |
|  |  line-height: 1.1                                       | |
|  |                                                         | |
|  |  Deck text (subtitle):                                  | |
|  |  Source Serif 4, text-xl (20px)                          | |
|  |  color: rgba(255,255,255,0.9)                           | |
|  |  max-width: 600px                                       | |
|  |                                                         | |
|  |  [Avatar 32px] Author Name . 8 min read                 | |
|  |  Inter 400, text-sm, rgba(255,255,255,0.8)             | |
|  |                                                         | |
|  |  [Read Article ->] (ghost button, white border)         | |
|  |                                                         | |
|  +---------------------------------------------------------+ |
|                                                               |
+---------------------------------------------------------------+

Mobile:
  Height: 400px (image top, text below, no overlay)
  Headline: text-3xl, left-aligned, ink color
  Deck: text-base, graphite color
  Background behind text: white
```

---

## HERO SECTION: Variant B (Split)

```
+---------------------------------------------------------------+
|                                                               |
|  +-------------------+  +----------------------------------+ |
|  |                   |  |                                  | |
|  |  TEXT CONTENT     |  |  [Image - 100% height]           | |
|  |  (50% width)      |  |  (50% width)                     | |
|  |  Background:      |  |  Object-fit: cover               | |
|  |  onion-50         |  |                                  | |
|  |                   |  |                                  | |
|  |  SUBTITLE         |  |                                  | |
|  |  (Inter 500,      |  |                                  | |
|  |   uppercase,      |  |                                  | |
|  |   orange)         |  |                                  | |
|  |                   |  |                                  | |
|  |  Section Title    |  |                                  | |
|  |  (Playfair 5xl)   |  |                                  | |
|  |                   |  |                                  | |
|  |  Description...   |  |                                  | |
|  |  (Source Serif)   |  |                                  | |
|  |                   |  |                                  | |
|  |  [CTA Button]     |  |                                  | |
|  |                   |  |                                  | |
|  +-------------------+  +----------------------------------+ |
|                                                               |
+---------------------------------------------------------------+

Height: 480px (desktop)
Mobile: Stacked (text top, image bottom)
```

---

## HERO SECTION: Variant C (Minimal Statement)

```
+---------------------------------------------------------------+
|                                                               |
|  Background: Onion Purple gradient                            |
|  linear-gradient(135deg, onion-900, onion)                    |
|  Height: 400px                                                |
|                                                               |
|  Centered content (flex, column, center):                     |
|                                                               |
|  SUBTITLE                                                     |
|  Inter 500, uppercase, letter-spacing: 0.05em                |
|  orange (#E67E22)                                             |
|  margin-bottom: 16px                                          |
|                                                               |
|  HEADLINE                                                     |
|  Playfair Display 700, white                                  |
|  text-5xl (48px)                                              |
|  margin-bottom: 16px                                          |
|                                                               |
|  DESCRIPTION                                                  |
|  Source Serif 4, text-lg, rgba(255,255,255,0.8)              |
|  max-width: 500px                                             |
|                                                               |
+---------------------------------------------------------------+

Mobile:
  Height: 320px
  Headline: text-3xl
  Padding: 24px
```

---

## PRICING CARD

```
+---------------------------------------------+
|                                             |
|  +---------------------------+              |
|  |     MOST POPULAR          |  <- badge   |
|  +---------------------------+    (only for |
|                                             |     featured card)
|  READER                                     |  <- Inter 700, text-sm
|  (Free)                                     |     uppercase, onion
|                                             |
|  0/mo                                       |  <- font-display, text-4xl
|                                             |     ink color
|  Perfect for casual readers                 |  <- Inter 400, text-sm
|                                             |     graphite
|  -----------------------------------------  |
|                                             |
|  [check] 5 articles per month              |  <- Inter 400, text-sm
|  [check] Event calendar access             |     check: Sean Green, 16px
|  [check] Basic listings browsing           |     cross: ash, 16px
|  [check] Community read access             |
|  [cross] Premium content                   |
|  [cross] Ad-free experience                |
|  [cross] Exclusive newsletter              |
|                                             |
|  -----------------------------------------  |
|                                             |
|  [Get Started - 100% width]               |  <- Ghost button, onion border
|                                             |
+---------------------------------------------+

Width: 33.33% in grid (desktop), 100% (mobile)
Padding: 32px internal
Border: 1px solid silver
Border-radius: 16px
Shadow: shadow-sm

Featured card:
  Border: 2px solid onion
  Shadow: shadow-onion
  Badge: "MOST POPULAR" (absolute, top: -12px)
  Slightly elevated: transform: scale(1.02)
```

---

## TESTIMONIAL CARD

```
+---------------------------------------------+
|                                             |
|  "                                          |  <- Large quote mark
|  "BLOSSOM has become my go-to source        |     Playfair, text-6xl
|   for everything Plateau State. The         |     onion-100 color
|   quality of journalism is unmatched."      |     Position: absolute top-left
|                                             |
|  ---- (onion decorative line, 40px)         |  <- 2px height, onion
|                                             |
|  [Avatar 48px]  Dr. Sarah Danjuma          |  <- Inter 600, text-sm, ink
|                  Commissioner,              |  <- Inter 400, text-xs, ash
|                  Plateau Ministry of        |
|                  Culture                    |
|                                             |
+---------------------------------------------+

Background: onion-50
Border-radius: 12px
Padding: 32px
Position: relative (for quote mark)
```

---

## PULL QUOTE (Inline Article)

```
+---------------------------------------------+
|  |                                          |  <- 3px left border, onion
|  |  "Heritage is not just about the         |
|  |   past — it is the foundation of         |
|  |   our future."                           |
|  |                                          |
|  |   — Governor, Plateau State              |  <- Inter 500, text-sm, onion
|  |                                          |
+---------------------------------------------+

Font: Playfair Display Italic, text-2xl (24px)
Color: onion (#5B2C6F)
Padding-left: 24px
Border-left: 3px solid onion
Margin: 40px 0
Max-width: 100% of article body
```

---

## DROP CAP (Article First Letter)

```
First letter of article:
Font: Playfair Display 900
Size: text-6xl (60px)
Color: onion (#5B2C6F)
Float: left
Line-height: 0.8
Margin-right: 12px
Margin-top: 8px
```
