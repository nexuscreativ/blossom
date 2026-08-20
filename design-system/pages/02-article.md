# BLOSSOM — Page Architecture: Article Page

## Layout Structure

```
+---------------------------------------------------------------+
|                     NAVIGATION BAR (72px)                       |
+---------------------------------------------------------------+
|                                                                 |
|                       ARTICLE HERO                              |
|  +-----------------------------------------------------------+ |
|  | Full-width feature image (16:9 or 21:9 ratio)             | |
|  | Max-height: 600px (desktop), 320px (mobile)               | |
|  |                                                           | |
|  | Gradient: transparent -> rgba(0,0,0,0.7)                  | |
|  |                                                           | |
|  |  CATEGORY PILL (top-left, absolute)                       | |
|  |  ARTICLE TITLE (Playfair 5xl, white, bottom-left)        | |
|  +-----------------------------------------------------------+ |
|                                                                 |
|  ARTICLE META BAR (sticky, appears on scroll down)             |
|  +-----------------------------------------------------------+ |
|  | [Avatar 28px] Author Name . Aug 15, 2026 . 8 min read    | |
|  |                                              [Share] [Bm] | |
|  +-----------------------------------------------------------+ |
|  Position: sticky, top: 72px (below nav)                       |
|  Background: rgba(255,255,255,0.95), backdrop-filter: blur(8px)|
|  Height: 56px                                                   |
|  z-index: 200                                                   |
|  Transition: translateY(-100%) hidden, translateY(0) shown     |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|           ARTICLE BODY (max-width: 680px, centered)            |
|                                                                 |
|  +-----------------------------------------------------------+ |
|  |                                                           | |
|  |  Lead paragraph (Source Serif 4, text-lg, 1.6 line-height)| |
|  |  First letter drop cap: Playfair 900, text-6xl, onion     | |
|  |  float: left, line-height: 0.8, margin-right: 12px       | |
|  |                                                           | |
|  |  Body paragraphs (text-base, 1.625 line-height)           | |
|  |  Max 65-75 characters per line for readability            | |
|  |                                                           | |
|  |  +-----------------------------------------------------+ | |
|  |  | PULL QUOTE                                          | | |
|  |  | Playfair Display Italic, text-2xl, onion color       | | |
|  |  | Border-left: 3px solid onion, padding-left: 24px    | | |
|  |  | Attribution: Inter 500, text-sm, onion               | | |
|  |  +-----------------------------------------------------+ | |
|  |                                                           | |
|  |  [Full-width image with caption]                          | |
|  |  Caption: Inter 400, text-xs, ash, centered               | |
|  |  margin-top: 8px                                         | |
|  |                                                           | |
|  |  More body text...                                       | |
|  |                                                           | |
|  |  [Inline image with caption]                              | |
|  |  margin: 32px 0                                          | |
|  |                                                           | |
|  |  More body text...                                       | |
|  |                                                           | |
|  +-----------------------------------------------------------+ |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|           PAYWALL GATE (if premium content)                     |
|                                                                 |
|  +-----------------------------------------------------------+ |
|  |                                                           | |
|  |  [Remaining content - blurred]                            | |
|  |  filter: blur(12px), max-height: 400px                   | |
|  |                                                           | |
|  |  [Gradient overlay: white 0% -> transparent 60%]         | |
|  |  (dark mode: #0D0D0D instead of white)                   | |
|  |                                                           | |
|  |  +-----------------------------------------------------+ | |
|  |  |  GATE CARD (positioned over blur)                    | | |
|  |  |  Background: white, border: 1px silver               | | |
|  |  |  Border-radius: 12px, padding: 32px                  | | |
|  |  |                                                      | | |
|  |  |  "This story continues for premium subscribers"      | | |
|  |  |                                                      | | |
|  |  |  +------------------+  +----------------------+     | | |
|  |  |  | Monthly          |  | Annual (Save 33%)     |     | | |
|  |  |  | 2,500/mo         |  | 20,000/yr             |     | | |
|  |  |  | [Subscribe]      |  | [Subscribe *]         |     | | |
|  |  |  +------------------+  +----------------------+     | | |
|  |  |                                                      | | |
|  |  |  Already subscribed? [Log In]                         | | |
|  |  +-----------------------------------------------------+ | |
|  |                                                           | |
|  +-----------------------------------------------------------+ |
|  z-index: 800 (z-paywall)                                      |
|  Scroll lock: overflow hidden on body at gate position          |
|                                                                 |
+---------------------------------------------------------------+
|                                                                 |
|                       ARTICLE FOOTER                            |
|                                                                 |
|  TAGS: [Culture] [Heritage] [Plateau] [Tradition]             |
|  Tag pills: pearl bg, graphite text, pill shape                |
|                                                                 |
|  SHARE: [Twitter] [Facebook] [LinkedIn] [WhatsApp] [Copy]     |
|  40x40px buttons, brand colors on hover                         |
|                                                                 |
|  +-----------------------------------------------------------+ |
|  | AUTHOR BIO CARD                                           | |
|  |                                                           | |
|  | [Avatar 64px, rounded]  Author Name                       | |
|  |                         Playfair 600, text-xl              | |
|  |                                                           | |
|  |                         Short biography text in            | |
|  |                         Source Serif 4, text-sm, graphite  | |
|  |                                                           | |
|  |                         [Twitter] [LinkedIn]               | |
|  |                         [More Articles ->]                 | |
|  +-----------------------------------------------------------+ |
|  Border: 1px silver, border-radius: 12px, padding: 24px       |
|                                                                 |
|  +-----------------------------------------------------------+ |
|  | RELATED ARTICLES                                          | |
|  | "You might also enjoy"                                    | |
|  |                                                           | |
|  | 3 article cards in row (same as homepage featured)        | |
|  +-----------------------------------------------------------+ |
|                                                                 |
|  +-----------------------------------------------------------+ |
|  | COMMENTS SECTION                                          | |
|  |                                                           | |
|  | "DISCUSSION (24 comments)"                                | |
|  |                                                           | |
|  | [Comment input box]                                       | |
|  | [Avatar] "Join the discussion..."                         | |
|  | min-height: 80px, border: 1px silver                      | |
|  | [Post Comment] (orange, right-aligned)                    | |
|  |                                                           | |
|  | Comment Thread:                                           | |
|  | +-----------------------------------------------------+ | |
|  | | [Avatar 36px]  Author Name . 2h ago                 | | |
|  | |                .Editor (onion badge)                 | | |
|  | |                                                      | | |
|  | | Comment text in Source Serif 4, 15px, charcoal       | | |
|  | |                                                      | | |
|  | | [Like 12] [Reply] [Report]                           | | |
|  | |                                                      | | |
|  | |   +-----------------------------------------------+ | | |
|  | |   | [Avatar 28px] Reply Author . 1h ago            | | | |
|  | |   | Reply text...                                  | | | |
|  | |   | [Like 3] [Reply] [Report]                      | | | |
|  | |   +-----------------------------------------------+ | | |
|  | +-----------------------------------------------------+ | |
|  |                                                           | |
|  | [Load More Comments]                                      | |
|  +-----------------------------------------------------------+ |
|                                                                 |
|  ---------------------------------------------------------------|
|  NEWSLETTER CTA (end of page)                                  |
|  "Never miss a story" inline subscribe                         |
|  onion-50 background, 32px padding                             |
|                                                                 |
+---------------------------------------------------------------+
|                     FOOTER                                      |
+---------------------------------------------------------------+
```

## Component States

### Paywall Gate
- **Trigger:** After ~30% of article body content
- **Visual:** blur(12px) on remaining content, max-height: 400px
- **Overlay:** linear-gradient(white 0%, transparent 60%) at 300px height
- **Gate card:** centered, max-width: 520px, white background
- **Animation:** Content fades to blur on scroll to gate position (400ms ease)
- **Scroll behavior:** Body scroll locked at gate position

### Article Meta Bar (Sticky)
- **Position:** sticky, top: 72px (desktop), top: 56px (mobile)
- **Visibility:** Hidden on scroll up, shown on scroll down
- **Animation:** translateY(-100%) to translateY(0), 250ms ease
- **Background:** rgba(255,255,255,0.95) with backdrop-filter: blur(8px)
- **Height:** 56px
- **Content:** Avatar (28px), author name, date, read time, action icons

### Comment Thread
- **Max nesting depth:** 3 levels (root > reply > reply)
- **Indent:** 32px per nesting level
- **Avatar sizes:** 36px (root), 28px (replies)
- **Divider:** 1px solid silver between top-level comments
- **New comment highlight:** onion-50 background, 2s fade
- **Role badges:** Editor (onion bg), Contributor (sean bg), Member (silver bg)

## Desktop Grid

```
Article body column: max-width 680px, centered
Container width: 800px (body + side margins)
Related articles: 3 columns within 680px container
Comments: 680px width, same as body
Author card: 680px width, full
```

## Mobile Layout Changes

| Element | Desktop | Mobile |
|---------|---------|--------|
| Hero image | Full-width, 600px height | Full-width, 320px height |
| Hero title | text-5xl (48px) | text-3xl (30px) |
| Meta bar | Sticky, top: 72px | Sticky, top: 56px, simplified |
| Body text | 680px centered | Full-width, 20px padding |
| Pull quotes | Border-left + text | Full-width, border-left only |
| Paywall gate | Same visual | Same visual, tighter CTA |
| Author card | Horizontal layout | Vertical layout (stacked) |
| Related articles | 3 columns | Single column |
| Comments | 680px width | Full width, 2-level max nesting |
| Share buttons | Row layout | Wrapped row |
| Tags | Horizontal row | Wrapped row |
