# BLOSSOM — Plateau's Prestige Magazine

## Complete UI/UX Design System

**Version:** 1.0  
**Date:** August 18, 2026  
**Platform:** Web (Mobile-First Responsive)  
**Design Language:** Premium Editorial — Vogue, Monocle, Forbes × African Cultural Pride

---

## Document Structure

```
design-system/
  tokens/
    design-tokens.css          # All CSS custom properties (colors, type, spacing, shadows, etc.)
  
  pages/
    01-homepage.md             # Homepage layout, components, grid, mobile changes
    02-article.md              # Article/reading experience, paywall, comments
    03-events-listings-community-pricing.md  # Events, Listings, Community, Pricing pages
  
  components/
    01-cards.md                # Article cards (featured/standard/compact), Listing cards
    02-events-newsletter-navigation.md  # Event cards, Newsletter forms, Nav bar, Footer
    03-search-pills-share-heroes.md     # Search, Pills/Tags, Share buttons, Comment system, Hero variants
  
  INTERACTION_PATTERNS.md      # Content discovery, paywall, newsletter triggers, search flow
  SITE_MAP.md                  # Complete hierarchical sitemap with every page/section
  MASTER.md                    # This file — overview and quick reference
```

---

## Brand Identity Quick Reference

### Colors

| Role | Name | Hex | CSS Variable |
|------|------|-----|-------------|
| **Primary** | Onion Purple | `#5B2C6F` | `--color-onion` |
| **Secondary** | Sean Green | `#1E8449` | `--color-sean` |
| **Accent/CTA** | Orange | `#E67E22` | `--color-orange` |
| **Premium** | Heritage Gold | `#D4AF37` | `--color-gold` |
| **Clean** | White | `#FFFFFF` | `--color-white` |

### Typography

| Role | Font | Weight | Usage |
|------|------|--------|-------|
| **Display** | Playfair Display | 700-900 | Headlines, hero text |
| **Body** | Source Serif 4 | 400, 600 | Article body text, pull quotes |
| **UI** | Inter | 400-700 | Buttons, labels, navigation, meta |

### Spacing Base

4px unit system: 4, 8, 12, 16, 20, 24, 32, 40, 48, 64, 80, 96, 128px

---

## Key Design Decisions

1. **Mobile-first responsive**: All designs start at 320px, scale up
2. **Editorial reading experience**: 680px max article width for optimal readability
3. **Premium paywall**: Blur gate at 30% of article, scroll-locked
4. **Newsletter integration**: 8 trigger points across the user journey
5. **Touch-friendly**: All interactive elements 44x44px minimum
6. **Accessibility**: WCAG AA compliance, 4.5:1 contrast ratios, keyboard navigation
7. **Dark mode**: Full dark theme support via `[data-theme="dark"]`
8. **Reduced motion**: Respects `prefers-reduced-motion` preference
9. **Cultural authenticity**: Heritage gold for premium, editorial serif fonts for gravitas
10. **Performance-conscious**: Shadows, transitions, and animations optimized for 60fps

---

## Page Count Summary

| Section | Pages | Key Feature |
|---------|-------|-------------|
| Homepage | 1 | Hero + 8 content sections |
| Blog/Articles | 3+ | Reading experience + paywall |
| Events | 2+ | Calendar + RSVP |
| Listings | 3+ | Directory + submission flow |
| Community | 4+ | Discussions + profiles |
| Magazine | 2+ | Digital reader |
| Subscription | 4+ | Pricing + checkout |
| Newsletter | 3+ | Signup + archive |
| Authors | 2+ | Profiles |
| About/Contact | 2 | Mission + team |
| Advertise | 2+ | Media kit + rates |
| Auth | 4+ | Login, register, reset |
| Dashboard | 5+ | Role-based (subscriber, listing, community, author, admin) |
| Legal | 5 | Terms, privacy, etc. |
| **Total** | **~50 pages** | |

---

## Component Count Summary

| Category | Components | Variants |
|----------|-----------|----------|
| Article Cards | 3 | Featured, Standard, Compact |
| Listing Cards | 3 | Business, Personality, Institution |
| Event Cards | 2 | List view, Grid view |
| Newsletter Forms | 3 | Inline, Sticky banner, Modal |
| Pricing Cards | 3 | Free, Premium, Institution |
| Navigation | 3 | Desktop nav, Mobile hamburger, Bottom bar |
| Search | 2 | Desktop expanded, Mobile overlay |
| Pills/Tags | 3 | Category, Tag, Selected |
| Share Buttons | 1 | 5 platform buttons |
| Comment System | 1 | Input + threaded comments |
| Hero Sections | 3 | Full-bleed, Split, Statement |
| Testimonial | 1 | Quote card |
| Pull Quote | 1 | Inline article quote |
| Drop Cap | 1 | First letter styling |
| **Total** | **~34 unique components** | **~70+ variants** |

---

## Responsive Breakpoints

| Token | Width | Target |
|-------|-------|--------|
| `xs` | 0-479px | Small phones |
| `sm` | 480-639px | Large phones |
| `md` | 640-767px | Small tablets |
| `lg` | 768-1023px | Tablets |
| `xl` | 1024-1279px | Small desktops |
| `2xl` | 1280-1535px | Desktops |
| `3xl` | 1536px+ | Large desktops |

---

## Accessibility Compliance

- **Color contrast:** 4.5:1 minimum for all text (WCAG AA)
- **Touch targets:** 44x44px minimum for all interactive elements
- **Keyboard navigation:** Full tab order, focus visible states
- **Screen reader:** Semantic HTML, ARIA labels, skip links
- **Motion:** Respects prefers-reduced-motion
- **Text scaling:** Design works up to 200% browser zoom
- **Error handling:** Clear error messages, accessible form validation

---

**Design System Date:** August 18, 2026  
**Implementation Status:** Ready for developer handoff  
**QA Process:** Design review and validation protocols established
