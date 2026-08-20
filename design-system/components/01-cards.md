# BLOSSOM — UI Component Catalog: Article & Listing Cards

---

## ARTICLE CARD: Featured (Large)

```
+---------------------------------------------+
|                                             |
|  [IMAGE - 16:9 ratio, 400x225px min]       |
|  Border-radius: 12px top only              |
|  Object-fit: cover                          |
|                                             |
+---------------------------------------------+  <- 1px silver border (bottom)
|                                             |
|  CATEGORY PILL                              |  <- Inter 600, 11px, uppercase
|  "CULTURE & HERITAGE"                       |     Sean Green bg, white text
|  Padding: 4px 12px, border-radius: 4px     |
|                                             |
|  Article Title Goes Here                    |  <- Playfair Display 600
|  (2 lines max, text-2xl / 24px)            |     line-height: 1.3
|  Color: ink (#1A1A1A)                       |     text-overflow: ellipsis
|                                             |
|  Brief excerpt text that gives the reader   |  <- Source Serif 4, text-sm
|  a taste of what the article contains...    |     graphite (#616161)
|  (2 lines max with ellipsis)                |     line-height: 1.5
|                                             |
|  -----------------------------------------  |
|  [Avatar 24px] Author Name . Aug 15, 2026  |  <- Inter, text-xs, ash (#9E9E9E)
|  . 8 min read                               |
|                                             |
+---------------------------------------------+

Dimensions: min-width 340px, auto height
Padding: 0 (image edge-to-edge), 24px (content area)
Border: 1px solid silver (#E0E0E0)
Border-radius: 12px
Shadow: shadow-sm at rest
Hover: shadow-lg, translateY(-4px), border onion-100
Transition: all 250ms ease
Premium indicator: Gold star icon (12px) next to title
```

### States

| State | Changes |
|-------|---------|
| Default | shadow-sm, silver border |
| Hover | shadow-lg, translateY(-4px), onion-100 border |
| Focus-visible | 2px onion outline, 2px offset |
| Premium | Gold star (12px) next to title |
| Loading | Skeleton: gray shimmer animation |

---

## ARTICLE CARD: Standard (Horizontal)

```
+---------------------------------------------+
|                                             |
|  +-----------+  Article Title              |  <- Playfair 600, text-xl
|  |           |  (2 lines max)               |
|  |  IMAGE    |                              |
|  |  120x90   |  Brief excerpt (2 lines)    |  <- Source Serif 4, text-sm
|  |  rounded  |                              |     graphite
|  |  md       |  [Author] . [Date] . [Time]  |  <- Inter, text-xs, ash
|  +-----------+                              |
|                                             |
+---------------------------------------------+

Horizontal layout: image left, text right
Gap: 16px between image and text
Padding: 16px
Border-bottom: 1px silver
Hover: background pearl (#F5F5F5), 200ms
Image: 120x90px, border-radius: 8px, object-fit: cover
```

---

## ARTICLE CARD: Compact (Trending)

```
+---------------------------------------------+
|                                             |
|  01  [img 40px]  Title text here            |  <- Number: onion, 700, text-lg
|      Author . 3h ago                        |     Image: 40x40px, rounded-md
|                                             |     Title: Inter 500, text-sm
+---------------------------------------------+     Author: Inter 400, text-xs, ash

Height: 64px (fixed)
Border-bottom: 1px silver
Hover: background onion-50 (#F4ECF7), 150ms
Number: Playfair 700, text-lg, onion color
```

---

## LISTING CARD: Business

```
+---------------------------------------------+
|                                             |
|  [COVER IMAGE - 100% width, 200px height]  |
|  Border-radius: 12px 12px 0 0              |
|  Object-fit: cover                          |
|                                             |
|  +--------+                                |
|  |FEATURED|  (only for premium)            |  <- Gold bg, white text
|  +--------+  Absolute positioned top-right |     Inter 600, 10px, uppercase
|                                             |
+---------------------------------------------+  <- 1px silver border
|                                             |
|  +-----------+                              |
|  | RESTAURANT |                            |  <- Sean Green pill
|  +-----------+  Inter 500, 11px, uppercase  |     white text
|                                             |
|  Mama Dikko's Restaurant                    |  <- Playfair 600, text-lg
|  (2 lines max)                              |     ink color
|                                             |
|  Jos North, Plateau State                   |  <- Inter 400, text-sm, ash
|                                             |
|  [Star 12px] 4.8  (12 reviews)             |  <- Gold star, graphite text
|                                             |
|  A beloved family restaurant known for      |  <- Inter 400, text-sm, graphite
|  its traditional Plateau cuisine and...     |     2 lines max, ellipsis
|                                             |
+---------------------------------------------+

Width: 100% (within grid)
Padding: 20px
Border-radius: 12px
Border: 1px solid silver
Shadow: shadow-sm at rest
Hover: shadow-lg, translateY(-4px), onion-100 border
Premium: Gold top border (3px solid --color-gold)
Claimed: Verified checkmark (16px, Sean Green) next to name
Unclaimed: "Claim this listing" ghost overlay on hover
```

### Listing Card States

| State | Changes |
|-------|---------|
| Default | shadow-sm, silver border |
| Hover | shadow-lg, translateY(-4px) |
| Hover (unclaimed) | "Claim this listing" overlay appears |
| Premium/Featured | Gold top border (3px), "FEATURED" badge |
| Claimed | Verified badge (green check) |
| Unclaimed | Claim overlay on hover |

---

## LISTING CARD: Personality

```
Same as Business card but:
- No cover image; uses avatar instead (120x120px, centered, rounded-full)
- Category shows role/profession instead of business type
- Description focuses on achievements
- Badge: "PERSONALITY" (Onion bg, white text)
```

---

## LISTING CARD: Institution

```
Same as Business card but:
- Badge: "INSTITUTION" (Sean Green bg, white text)
- May include "Est. Year" in meta
- Description focuses on mission/history
```
