# BLOSSOM — Interaction Patterns & Responsive Strategy

---

## 1. CONTENT DISCOVERY FLOW

### Homepage to Article

```
Path 1: Hero Click
  User lands on homepage
  -> Hero captures attention (full-bleed image, bold headline)
  -> Click hero or "Read Article" button
  -> Article page loads (full reading experience)

Path 2: Card Browse
  User scrolls to "Editor's Picks"
  -> Cards show hover lift + shadow (250ms)
  -> Click card -> Article page

Path 3: Category Discovery
  User clicks category tab on homepage
  -> Tab content loads via AJAX (no page reload)
  -> OR user clicks category pill in nav dropdown
  -> Category landing page loads
  -> Filtered articles in grid
  -> Click article -> Article page

Path 4: Trending Scroll
  User scrolls horizontally through trending section
  -> Snap scroll on mobile (scroll-snap-type: x mandatory)
  -> Click compact card -> Article page

Path 5: Search
  User clicks search icon or presses Cmd/Ctrl+K
  -> Search overlay opens (300ms fade)
  -> Type query (debounced 300ms after 3 chars)
  -> Results appear grouped: Articles | Listings | Events | People
  -> Keyboard: up/down to navigate, Enter to select
  -> Click result -> Article/Listing/Event page

Path 6: Newsletter
  User receives newsletter email
  -> Clicks article link
  -> Lands on article page (with UTM tracking)
```

### Category Navigation

```
1. Click category in nav dropdown OR category pill on article/card
2. Category landing page loads:
   - Hero: category name + featured article for that category
   - Filter bar: subcategories, sort options (Latest, Popular, Oldest)
   - Article grid: filtered results
   - Sidebar: related categories, popular articles in this category
3. Pagination: "Load More" button (not infinite scroll for category pages)
4. Breadcrumb updates: Home > Blog > [Category Name]
```

---

## 2. PAYWALL TRIGGER POINTS & PRESENTATION

### Trigger Points

| Location | Trigger Condition | Gate Type |
|----------|-------------------|-----------|
| Article body | After 30% of content (~3-4 paragraphs) | Inline blur + CTA card |
| Article listing | Premium badge on card click | Modal overlay |
| Magazine reader | First 2 pages free | Full gate after page 2 |
| Search results | Premium articles in results | Click -> modal |
| Author profile | Premium article count shown | Click -> modal |
| Email newsletter | Premium content preview | "Read full article" link -> paywall |
| Community | Premium discussions | Read-only for free users |

### Paywall Presentation: Inline Blur

```
Trigger: User scrolls to 30% of article content
Animation: Content fades to blur as user approaches gate (400ms ease)

+-----------------------------------------------------------+
|  (Visible content - first 30% of article)                 |
|  First paragraphs fully readable...                        |
|                                                           |
|  ---------------------------------------------------------|
|                                                           |
|  [Begin blur gradient - white to transparent]              |
|  Remaining content: filter: blur(12px)                     |
|  max-height: 400px of blurred content visible              |
|                                                           |
|  +-----------------------------------------------------+ |
|  |  GATE CARD (positioned over blur, centered)          | |
|  |                                                     | |
|  |  [Lock icon]                                        | |
|  |  "This story continues for premium subscribers"     | |
|  |                                                     | |
|  |  +------------------+  +----------------------+    | |
|  |  | Monthly          |  | Annual (Save 33%)     |    | |
|  |  | N2,500/mo        |  | N20,000/yr            |    | |
|  |  |                  |  |                       |    | |
|  |  | [Subscribe]      |  | [Subscribe *]         |    | |
|  |  +------------------+  +----------------------+    | |
|  |                                                     | |
|  |  Already subscribed? [Log In]                        | |
|  +-----------------------------------------------------+ |
|                                                           |
+-----------------------------------------------------------+

Scroll behavior: Body overflow hidden at gate position
Gate card: max-width 520px, white bg, border 1px silver
z-index: 800 (z-paywall)
```

### Paywall Modal (from listing/search)

```
Triggered by: Clicking premium content from non-article page

+-----------------------------------------------------------+
|                                                    [X]    |
|                                                           |
|  +-----------------------------------------------------+ |
|  |  [Article preview image - 100% width, max 200px]    | |
|  +-----------------------------------------------------+ |
|                                                           |
|  [Lock icon] PREMIUM ARTICLE                              |
|  Inter 600, uppercase, onion color                        |
|                                                           |
|  "Article Title Goes Here"                                |
|  Playfair 600, text-xl                                    |
|                                                           |
|  By Author Name . 8 min read                              |
|  Inter 400, text-sm, ash                                  |
|                                                           |
|  First 2 sentences visible in gray italic (preview)       |
|                                                           |
|  +-----------------------------------------------------+ |
|  |  Unlock this article and hundreds more.              | |
|  |                                                     | |
|  |  [Subscribe to Premium - full width, orange]        | |
|  |                                                     | |
|  |  Already a subscriber? [Log In]                     | |
|  +-----------------------------------------------------+ |
|                                                           |
+-----------------------------------------------------------+

Modal: max-width 480px
Shadow: shadow-2xl
Backdrop: rgba(0,0,0,0.5)
Animation: scale(0.95->1) + fade, 300ms
z-index: 400
```

---

## 3. NEWSLETTER SUBSCRIPTION TRIGGERS

| Trigger | Location | Type | Frequency Cap |
|---------|----------|------|---------------|
| Time-based | After 45s on any page | Sticky bottom banner | 1x per session |
| Scroll-based | After 50% scroll on article | Inline CTA at article end | Every article |
| Exit intent | Mouse leaves viewport (desktop) | Modal popup | 1x per session |
| Content-based | After reading 3+ articles | Sidebar sticky CTA | 1x per session |
| Dedicated page | /newsletter page | Full signup form | Always visible |
| Footer | Every page footer | Mini signup form | Always visible |
| Post-comment | After posting first comment | Toast notification | 1x per session |
| Registration | During account creation | Pre-checked opt-in | During signup |

### Newsletter Confirmation Flow

```
Step 1: User enters email, clicks Subscribe
  -> Button shows spinner (onion color, 20px)
  -> Input disabled (opacity 0.7)

Step 2a: Success
  -> Green toast: "Check your inbox! We sent a confirmation email."
  -> Email sent with double opt-in link
  -> User clicks link -> "You're subscribed!" confirmation page

Step 2b: Already subscribed
  -> Info toast: "You're already subscribed! Check your latest newsletter."

Step 2c: Validation error
  -> Red error text below input: "Please enter a valid email address."
  -> Input border turns red
```

---

## 4. LISTING SUBMISSION FLOW

### New Listing Submission (5 Steps)

```
Step 1: Choose Type
  [Business] [Personality] [Institution]
  3 cards, clickable, icon + title + description

Step 2: Basic Information
  Form fields: Name*, Category*, LGA*, Address
  Each: full-width input, label above, validation on blur

Step 3: Details
  Form fields: Description* (textarea, 500 char max), Phone, Website, Cover Image
  Image upload: drag-and-drop zone or click, preview on upload
  Validation: required fields, format checks

Step 4: Choose Plan
  2 pricing cards: Basic (Free) vs Featured (N15,000/yr)
  Selection highlights chosen card

Step 5: Review & Submit
  Preview of listing as it will appear
  [Edit] [Submit Listing]
  On submit: "Your listing is under review. We'll notify you within 48 hours."
```

### Claim Existing Listing Flow

```
1. User finds unclaimed listing
2. Clicks "Claim This Listing" button
3. Verification modal appears:
   - "Are you the owner/representative of [Business Name]?"
   - Verification method: Email / Phone / Document upload
4. Submits claim -> "Your claim is being reviewed"
5. Admin reviews (approve/reject notification)
6. On approval: "Your listing is now claimed! [Go to Dashboard]"
```

---

## 5. COMMUNITY ENGAGEMENT FLOW

### New Discussion

```
1. Click "New Discussion" button (community page)
2. Modal/inline form appears:
   - Topic dropdown: [Culture] [Politics] [Business] [General]
   - Title input (required, max 120 chars)
   - Rich text editor (body, required, min 50 chars)
   - Tags: up to 5 pills (type + Enter to add)
   - [Post Discussion] button
3. On post:
   - Thread appears at top of feed (optimistic update)
   - "Discussion posted successfully" toast
   - If tags match user interests -> notification sent
```

### Reply Flow

```
1. Click "Reply" on any comment
2. Inline reply editor appears below comment
   - Focused automatically
   - [Cancel] and [Post Reply] buttons
3. Type reply -> [Post Reply]
4. Reply appears nested under parent (250ms fade-in)
5. Parent author gets notification
```

### Engagement Micro-interactions

| Action | Behavior | Duration |
|--------|----------|----------|
| Like | Heart fills with onion color, count +1, small bounce | 200ms spring |
| Reply | Inline editor slides down | 250ms ease |
| Share | Share dropdown appears below button | 150ms ease |
| Bookmark | Bookmark fills, "Saved!" toast | 200ms spring |
| Report | Reason dropdown appears | 150ms ease |

---

## 6. SOCIAL SHARING MECHANICS

### Share Button Behavior

```
Desktop:
  Click -> Share dropdown appears (positioned below button)
  Dropdown: Twitter, Facebook, LinkedIn, WhatsApp, Copy Link
  Each opens new window/tab with pre-filled share content
  Dropdown closes on outside click

Mobile:
  Click -> Native share sheet (Web Share API) if available
  Fallback -> Bottom sheet with share options

Share content structure:
  Title: Article/Event title
  Text: First 150 chars of description + " via @BlossomMagazine"
  URL: Canonical URL with UTM parameters
  Image: Open Graph image (1200x630)
```

### UTM Parameters

```
?utm_source=blossom.com&utm_medium=social&utm_campaign=[platform]_[type]

Examples:
  ?utm_source=blossom.com&utm_medium=social&utm_campaign=twitter_article
  ?utm_source=blossom.com&utm_medium=social&utm_campaign=facebook_event
  ?utm_source=blossom.com&utm_medium=email&utm_campaign=newsletter_jan15
```

---

## 7. SEARCH INTERACTION FLOW

```
1. Trigger: Click search icon OR press Cmd/Ctrl+K
2. Search overlay opens (300ms fade-in)
3. Focus on input immediately (auto-focus)
4. Show recent searches + trending (if input empty)
5. User types:
   a. After 3 characters -> debounced search (300ms delay)
   b. Results appear grouped:
      - Articles (max 3)
      - Listings (max 3)
      - Events (max 3)
      - People (max 3)
   c. Each group has "View all X results" link
6. Keyboard navigation:
   - ArrowDown: next result
   - ArrowUp: previous result
   - Enter: navigate to result
   - Escape: close overlay
7. Click/Enter on result -> navigate to result page
8. Close: Esc key, click outside, or X button
```

---

# 8. MOBILE-FIRST RESPONSIVE STRATEGY

## Breakpoint Definitions

| Token | Min-Width | Max-Width | Target | Grid Cols |
|-------|-----------|-----------|--------|-----------|
| `xs` | 0px | 479px | Small phones | 4 |
| `sm` | 480px | 639px | Large phones | 4 |
| `md` | 640px | 767px | Small tablets | 8 |
| `lg` | 768px | 1023px | Tablets | 8 |
| `xl` | 1024px | 1279px | Small desktops | 12 |
| `2xl` | 1280px | 1535px | Desktops | 12 |
| `3xl` | 1536px | - | Large desktops | 12 |

## Container Widths

| Breakpoint | Max Width | Horizontal Padding |
|------------|-----------|-------------------|
| xs | 100% | 16px |
| sm | 100% | 20px |
| md | 640px | 24px |
| lg | 768px | 32px |
| xl | 1024px | 48px |
| 2xl | 1280px | 64px |
| 3xl | 1440px | 80px |

## Touch Targets

All interactive elements: **minimum 44x44px** touch target

| Element | Visual Size | Touch Target |
|---------|------------|--------------|
| Buttons | 44px height | 44x44px min |
| Nav links | text only | 44px tap area |
| Icon buttons | 20-24px icon | 44x44px wrapper |
| Checkboxes | 20px visual | 48x48px |
| List items | varies | 48px min-height |

## Swipe Gestures

| Element | Gesture | Action |
|---------|---------|--------|
| Hero carousel | Horizontal swipe | Next/prev slide |
| Trending section | Horizontal swipe | Scroll more articles |
| Event cards | Horizontal swipe | Browse events |
| Image gallery | Horizontal swipe | Next/prev image |
| Category tabs | Horizontal swipe | Scroll hidden tabs |

## Component Responsive Behavior

### Article Cards

| Breakpoint | Layout | Columns | Image |
|------------|--------|---------|-------|
| xs-sm | Vertical stack | 1 | 100% w, 200px h |
| md-lg | 2-col grid | 2 | 100% w, 180px h |
| xl+ | 3-col grid | 3 | 100% w, 200px h |

### Listing Cards

| Breakpoint | Layout | Columns |
|------------|--------|---------|
| xs-sm | Vertical stack | 1 |
| md-lg | 2-col grid | 2 |
| xl+ | 3-col grid | 3 |

### Navigation

| Breakpoint | Primary Nav | Search | Subscribe |
|------------|-------------|--------|-----------|
| xs-md | Hamburger + bottom bar | Icon -> overlay | In menu |
| lg | Full horizontal | Inline bar | Ghost button |
| xl+ | Full horizontal | Expanded | Orange button |

### Hero Section

| Breakpoint | Layout | Height | Headline |
|------------|--------|--------|----------|
| xs-sm | Stacked (img + text) | 400px | text-3xl |
| md-lg | Overlay (text on img) | 480px | text-4xl |
| xl+ | Overlay (text on img) | 560px | text-6xl/7xl |

### Sidebar

| Breakpoint | Behavior |
|------------|----------|
| xs-lg | Below main content, full width |
| xl+ | Right sidebar, 4/12 columns |

### Footer

| Breakpoint | Layout |
|------------|--------|
| xs-md | Single column, accordion sections |
| lg | 2-column grid |
| xl+ | 5-column grid |

## Mobile-Specific Patterns

### Pull-to-Refresh
- Applied on: Listings, Events, Community feed
- Visual: BLOSSOM spinner (onion color, 32px)
- Action: Reloads current data

### Infinite Scroll / Load More
- Applied on: Blog listing, Listings directory, Community feed
- Trigger: Scroll to bottom (80% threshold)
- Visual: Loading spinner (onion, 32px)
- Action: Loads next page (12 items)
- End state: "You've reached the end" message

### Bottom Navigation
- Visible on: Homepage, Listings, Events, Blog, Community
- Hidden on: Dashboard, Auth, Pricing, Article reading
- Height: 56px + safe-area-inset-bottom
- Active indicator: onion color icon + label + optional top dot
