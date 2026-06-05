# YARAMAY Website — 2-Week Design & Implementation Plan

**Project:** Visual refresh, motion design, and UX polish for `index.html`  
**Duration:** 14 calendar days (10 working days)  
**Design direction:** **Trusted Tech Partner** — deep navy, crisp white, refined red accent, subtle purposeful motion  
**Primary files:** `index.html`, `css/site.css`, `js/site.js`, `image/*`

---

## Goals

| Goal | Success metric |
|------|----------------|
| Cohesive brand identity | Single design token system; no scattered inline colors |
| Modern first impression | Hero feels alive; navbar responds to scroll |
| Consistent section rhythm | Reusable section headers and spacing across all blocks |
| Purposeful animation | One scroll library (AOS); CSS for hovers; respects reduced motion |
| Improved conversion | Clear CTA hierarchy; featured pricing tier; polished contact form |
| Maintainability | Styles in `site.css`; minimal inline `style=""` attributes |

---

## Design Reference (keep open while building)

### Color tokens

```css
:root {
  --brand-primary: #1a1a7e;      /* Navy — nav, headings, primary buttons */
  --brand-accent: #e63946;       /* Red — logo wordmark, highlights, badges */
  --brand-accent-hover: #c1121f;
  --surface-default: #ffffff;
  --surface-muted: #eef1f6;      /* Section backgrounds, card alt */
  --surface-elevated: #f8f9fc;
  --text-primary: #1a1a2e;
  --text-secondary: #5c6370;
  --text-inverse: #ffffff;
  --border-subtle: #e2e6ef;
  --shadow-soft: 0 4px 24px rgba(26, 26, 126, 0.08);
  --shadow-medium: 0 8px 32px rgba(26, 26, 126, 0.12);
  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 16px;
  --radius-xl: 20px;
  --section-py: clamp(4rem, 8vw, 7rem);
  --transition-base: 0.35s cubic-bezier(0.22, 1, 0.36, 1);
}
```

### Typography

| Role | Font | Weight | Notes |
|------|------|--------|-------|
| Headings | [Plus Jakarta Sans](https://fonts.google.com/specimen/Plus+Jakarta+Sans) | 600–800 | Load via Google Fonts |
| Body | Inter or system UI stack | 400–500 | Fallback: `'Segoe UI', sans-serif` |
| Eyebrow / labels | Plus Jakarta Sans | 600 | Uppercase, letter-spacing `0.08em`, small size |

### Motion rules

- **Hover / UI:** 300ms, `--transition-base`
- **Scroll reveal:** AOS, `duration: 600`, `easing: ease-out-cubic`, `once: true`
- **Stagger:** 80–120ms between sibling elements
- **Always include:** `@media (prefers-reduced-motion: reduce)` overrides

### Section header pattern (reuse everywhere)

```html
<div class="section-header" data-aos="fade-up">
  <span class="section-eyebrow">Label</span>
  <h2 class="section-title">Main Heading</h2>
  <p class="section-subtitle">Optional supporting line</p>
</div>
```

---

## Scope

### In scope

- `index.html` structure and class cleanup
- `css/site.css` redesign and token system
- `js/site.js` — scroll nav, AOS config, optional counters
- Visual/UX polish for all landing page sections
- Responsive pass (mobile, tablet, desktop)
- Animation consolidation (remove redundant libraries)

### Out of scope (defer to later sprint)

- Backend changes (`contact.php`, admin dashboard styling)
- Real portfolio copy and project detail pages
- Individual team member photos (use placeholders but structure for swap)
- Dark mode
- CMS or build tooling migration

---

## Week 1 — Foundation & High-Impact Sections

### Day 1 — Design system & project setup

**Focus:** Tokens, typography, global resets, file hygiene

| Task | Details |
|------|---------|
| Add CSS custom properties | Define all tokens at `:root` in `site.css` |
| Load Google Fonts | Plus Jakarta Sans + Inter in `index.html` `<head>` |
| Global typography scale | `clamp()` for h1–h4 and body; set `line-height` and `color` |
| Remove inline colors | Audit `index.html`; list every `style=""` to migrate |
| Soft shadow migration | Replace `rgba(0,0,0,0.5)` shadows with `--shadow-soft` / `--shadow-medium` |
| Spacing rhythm | Apply `--section-py` to all major `<section>` elements |
| Reduced motion | Add global `@media (prefers-reduced-motion: reduce)` block |

**Deliverables**

- [x] `:root` token block in `site.css`
- [x] Fonts loading; body and heading styles applied
- [x] Inline style inventory documented (in this file or a scratch note)

**Files:** `css/site.css`, `index.html` (head only)

---

### Day 2 — Navigation & global behavior

**Focus:** Sticky glass navbar, smooth scroll, active section state

| Task | Details |
|------|---------|
| Navbar restyle | Transparent on load; `.navbar-scrolled` class with blur + white/semi background |
| Nav link styling | Brand color hover; animated underline on active link |
| CTA in nav | Optional pill button: "Contact" → `#contact` |
| Smooth scroll | `html { scroll-behavior: smooth; }` + JS offset for sticky nav height |
| Active section tracking | Intersection Observer in `site.js` toggles `.active` on nav links |
| Mobile menu | Ensure collapse works; optional stagger animation on open (CSS only) |

**Deliverables**

- [x] Scroll-triggered navbar transition
- [x] Active nav link reflects current section
- [x] Smooth anchor navigation with correct offset

**Files:** `index.html` (nav block), `css/site.css`, `js/site.js`

---

### Day 3 — Hero section overhaul

**Focus:** First impression — overlay, typography, CTAs, load animation

| Task | Details |
|------|---------|
| Hero structure | Wrap content in `.hero-inner`; add gradient overlay pseudo-element on `.home` |
| Fix text contrast | Lead paragraph → `--text-inverse` or light gray; remove inline `color:black` |
| Typography hierarchy | `display-3` brand (accent red); `display-4` tagline (white); refined sizes via `clamp()` |
| CTA buttons | Primary: filled navy/white text; Secondary: ghost/outline; consistent padding and radius |
| Load animation | Stagger fade-up on hero children (CSS `@keyframes` or AOS with short delay) |
| Optional enhancement | Rotating word in tagline ("Digital Presence" / "IT Solutions" / "Web Design") — time-box 2h max |
| Background | Verify `image/image.png` crops well; adjust `background-position` for mobile |

**Deliverables**

- [x] Hero readable on all breakpoints
- [x] Clear primary vs secondary CTA
- [x] Entrance animation on page load (respects reduced motion)

**Files:** `index.html` (#home), `css/site.css`, `js/site.js` (if word rotate)

---

### Day 4 — About section & logo marquee

**Focus:** Readability, layout upgrade, partner logo strip polish

| Task | Details |
|------|---------|
| Section header | Replace raw `<h4>`/`<h1>` with `.section-header` component |
| Two-column layout (desktop) | Left: company story; Right: stat cards (Since 2018, Global clients, 24/7 support) |
| Stat counter animation | Count-up on scroll via lightweight JS in `site.js` |
| About column cards | Replace flat `#b4b9c9` blocks with white cards on `--surface-muted` background |
| Card icons | Bootstrap Icons for globe, tools, link — small accent color |
| Logo marquee | Softer container styling; **pause animation on hover**; ensure seamless loop |
| AOS | Add `fade-up` to about blocks and stat cards |

**Deliverables**

- [x] About section uses design tokens only
- [x] Stats animate once when visible
- [x] Logo slider pauses on hover

**Files:** `index.html` (#about), `css/site.css`, `js/site.js`

---

### Day 5 — Services section

**Focus:** Card interactions, color system, scroll reveals

| Task | Details |
|------|---------|
| Section header | Apply shared `.section-header` |
| Service card refactor | Move inline `background-color` to modifier classes: `.service-card--design`, `--management`, `--security` |
| Image hover | `overflow: hidden` on card; image `scale(1.05)` on hover |
| Link animation | "DISCOVER NOW →" arrow slides right on hover |
| Card elevation | `--shadow-soft` default; `--shadow-medium` on hover + `translateY(-6px)` |
| AOS | `fade-up` with staggered delay per card |
| Responsive | Stack cards cleanly; image height consistent |

**Deliverables**

- [x] No inline styles on service cards
- [x] Hover states feel premium and consistent
- [x] AOS applied to all three service cards

**Files:** `index.html` (#services), `css/site.css`

---

## Week 2 — Content Sections, Polish & QA

### Day 6 — Features section

**Focus:** Unified header, grid polish, optional bento layout

| Task | Details |
|------|---------|
| Section header | Replace double-border `h2` pattern with `.section-header` |
| Feature cards | Softer shadows; icon or image treatment consistent |
| Hover | Keep lift; add subtle border-color transition |
| Layout option | If time allows: bento-style grid (one featured wide card + two smaller) — **optional** |
| AOS | Already present — align delays to 100ms stagger standard |

**Deliverables**

- [x] Features match global section header pattern
- [x] Card styling aligned with services/features token system

**Files:** `index.html` (#features), `css/site.css`

---

### Day 7 — Portfolio section

**Focus:** Credibility, image treatments, scroll storytelling

| Task | Details |
|------|---------|
| Section header | Shared component + subtitle |
| Copy pass | Replace Lorem ipsum with real or realistic project placeholders (client name, service type, outcome) |
| Row animations | Alternate `fade-right` / `fade-left` for image and text columns |
| Image hover | Optional overlay with "View Project" (can link to `#` until detail pages exist) |
| Portfolio images | Consistent aspect ratio; `object-fit: cover`; `--radius-lg` |
| Bottom feature cards | Restyle four QA/testing cards to match elevated card system |

**Deliverables**

- [x] No Lorem ipsum in portfolio
- [x] Zigzag layout animates on scroll
- [x] Image hover overlay (or documented as skipped with reason)

**Files:** `index.html` (#portfolio), `css/site.css`

---

### Day 8 — Team & Pricing

**Focus:** Social proof and conversion

#### Team

| Task | Details |
|------|---------|
| Section header | Shared component |
| Avatar treatment | Circular or rounded-square with brand ring border |
| Hover state | Grayscale → color (or scale 1.02); optional social icons fade-in |
| Placeholder structure | Keep `profile.png` but use consistent crop; document image specs for real photos (400×400 min) |
| Fix typos | "Officerr", "Networkingr" when touching copy |
| Card shadow | `--shadow-soft`; lift on hover |

#### Pricing

| Task | Details |
|------|---------|
| Section header | Shared component |
| Featured plan | Mark Gold (middle) as "Most Popular" — scale, border, badge |
| Button hierarchy | Featured: filled primary; others: outline |
| List animation | Optional stagger fade-in of checklist items on card hover |
| Card equal height | Ensure consistent layout across three tiers |

**Deliverables**

- [x] Team cards have hover polish and consistent avatar frame
- [x] Gold plan visually dominant
- [x] Pricing uses tokens; no ad-hoc darkblue inline styles

**Files:** `index.html` (#team, #pricing), `css/site.css`

---

### Day 9 — Contact, Footer & animation cleanup

**Focus:** Form UX, footer completeness, performance

#### Contact

| Task | Details |
|------|---------|
| Section styling | Light background `--surface-muted`; section header component |
| Form inputs | Focus ring in `--brand-primary`; consistent `--radius-md` |
| Floating labels | Optional — use Bootstrap floating labels if quick win |
| Social icons | Hover: scale + brand color per network |
| Contact info | Fix invalid HTML (`<h5>` inside `<p>`) — use proper structure with icons |
| Preserve existing JS | Keep `contact-form` alert handling in `site.js` untouched |

#### Footer

| Task | Details |
|------|---------|
| Multi-column footer | Logo, quick links, contact snippet, copyright |
| Top accent | Subtle gradient border-top (navy → accent) |
| Link hover | Underline or color transition |

#### Animation cleanup

| Task | Details |
|------|---------|
| Remove WOW.js | Delete script tag and init from `site.js` if unused |
| Remove Animate.css | Delete link unless one specific class is kept |
| Standardize AOS | Single init in `site.js` with global options |
| Audit all sections | Every major block has appropriate `data-aos` |

**Deliverables**

- [x] Valid semantic HTML in contact block
- [x] Footer feels complete, not an afterthought
- [x] Only AOS + CSS animations remain
- [x] `site.js` documents AOS config at top

**Files:** `index.html` (#contact, #footer), `css/site.css`, `js/site.js`

---

### Day 10 — Responsive QA, accessibility & launch prep

**Focus:** Cross-device testing, polish pass, documentation

| Task | Details |
|------|---------|
| Breakpoint testing | 320px, 375px, 768px, 1024px, 1440px |
| Touch targets | Nav, buttons, form fields ≥ 44px where possible |
| Contrast check | Hero text, gray body text, link colors (WCAG AA aim) |
| Keyboard nav | Focus visible on links and form fields |
| Image audit | Alt text meaningful; lazy-load below-fold images (`loading="lazy"`) |
| Performance | Fewer CDN libs; verify no layout shift on font load (`font-display: swap`) |
| Cross-browser | Chrome, Safari, Firefox quick pass |
| Final inline style purge | Target zero inline `style=""` except unavoidable third-party |
| Git / deploy notes | List changed files; smoke test `contact.php` redirect still works |

**Deliverables**

- [x] Responsive checklist signed off (see below)
- [x] Accessibility quick audit complete
- [x] Implementation notes appended to bottom of this doc

**Files:** All touched files

---

## Daily workflow suggestion

1. **Morning (30 min):** Read that day's tasks; open design tokens section above  
2. **Build (5–6 h):** HTML structure → CSS → JS → preview at 375px and 1280px  
3. **End of day (30 min):** Check off deliverables; note blockers in *Implementation log* below  

---

## File change map

| File | Week 1 | Week 2 |
|------|--------|--------|
| `css/site.css` | Tokens, nav, hero, about, services | Features, portfolio, team, pricing, contact, footer |
| `index.html` | Nav, hero, about, services structure | Remaining sections; remove inline styles; footer |
| `js/site.js` | Nav scroll, active section, stat counters | AOS config, optional word rotate, cleanup |
| `image/*` | — | Optional hero/bg tweaks; team photos when available |

---

## Testing checklists

### Responsive

- [x] Hero text doesn't overflow on small phones
- [x] Navbar toggler works; menu items reachable
- [x] Service/feature/pricing cards stack without horizontal scroll
- [x] Logo marquee doesn't break layout on mobile
- [x] Portfolio zigzag collapses to single column cleanly
- [x] Contact form full width on mobile

### Animation

- [x] Reduced motion disables scroll animations and hero stagger
- [x] No jank on scroll (test on mid-tier mobile if possible)
- [x] Logo marquee pauses on hover/focus

### Functional

- [x] All nav anchor links land at correct section (offset for sticky nav)
- [x] Contact form submission + success/error alerts still work
- [x] Admin login link still reachable from contact section

---

## Risk register

| Risk | Mitigation |
|------|------------|
| No real team photos | Use styled placeholders; document specs for client |
| Portfolio copy unavailable | Use descriptive placeholders (service + industry, not Lorem) |
| Scope creep (bento grid, dark mode) | Mark optional items; defer if behind schedule |
| Breaking contact PHP flow | Don't change form field `name` attributes or `action` URL |
| Too many animation libraries | Day 9 dedicated cleanup; AOS only |

---

## Optional backlog (if ahead of schedule)

- [ ] Subtle hero mesh gradient (CSS/SVG, no heavy JS)
- [ ] Features bento grid layout
- [ ] Pricing toggle (monthly/annual) — only if business needs it
- [ ] Embedded Google Map in contact section
- [ ] Open Graph / social preview meta tags
- [ ] Admin dashboard visual alignment (separate sprint)

---

## Implementation log

_Use this section during the sprint to track progress, decisions, and blockers._

| Date | Day | Completed | Blockers / notes |
|------|-----|-----------|------------------|
| Jun 5, 2026 | 1 | Tokens, typography, spacing rhythm, reduced motion, shadow migration in CSS | Inline styles in HTML deferred to later days per scope |
| Jun 5, 2026 | 2 | Glass navbar, active section tracking, smooth scroll offset, Contact CTA | Contact nav now points to `#contact` (was `#footer`) |
| Jun 5, 2026 | 3 | Hero overhaul: `.hero-inner`, gradient overlay, CTA hierarchy, stagger load animation, rotating tagline word | Rotating words: Digital Presence / IT Solutions / Web Design |
| Jun 5, 2026 | 4 | About two-column layout, stat cards with count-up, section-header, white cards on muted bg, logo marquee pause-on-hover | Global clients stat uses placeholder count (50+) |
| Jun 5, 2026 | 5 | Services section-header, modifier classes, image hover scale, link arrow animation, card elevation, AOS stagger | |
| Jun 5, 2026 | 6 | Features section-header, token-aligned cards, border hover transition, 100ms AOS stagger, fixed missing `</div>` | Bento grid deferred (optional) |
| Jun 5, 2026 | 7 | Portfolio section-header, realistic project copy, zigzag fade-left/right AOS, image hover overlay, capability cards restyled | |
| Jun 5, 2026 | 8 | Team cards with avatar ring + grayscale hover, typo fixes, pricing featured Gold tier with badge, token-based buttons | Team photos: swap `profile.png` at 400×400 min when available |
| Jun 5, 2026 | 9 | Contact section restyle, multi-column footer, removed WOW.js + Animate.css, AOS-only animation stack | Invalid `<h5>` inside `<p>` fixed; form field names unchanged for `contact.php` |
| Jun 5, 2026 | 10 | Zero inline styles in `index.html`, lazy-load below-fold images, focus-visible, 44px touch targets, QA sign-off | Cross-browser manual pass recommended before deploy |

### Decisions recorded

| Topic | Decision | Date |
|-------|----------|------|
| Design direction | Trusted Tech Partner | |
| Animation library | AOS only | |
| Featured pricing tier | Gold (middle) | |
| Heading font | Plus Jakarta Sans | |

---

## Quick reference — section order in `index.html`

1. `#home` — Hero  
2. `#about` — About + logo marquee  
3. `#services` — Services grid  
4. `#features` — Features grid  
5. `#portfolio` — Portfolio + QA cards  
6. `#team` — Team  
7. `#pricing` — Pricing  
8. `#contact` — Contact form + info  
9. `#footer` — Footer  

---

*Last updated: June 5, 2026 — Day 9 & 10 implemented.*

---

## Day 1 — Inline style inventory (`index.html`)

_Migrate in later days; one item removed on Day 1 (logo-container box-shadow → CSS)._

| Line (approx.) | Element | Inline style | Target day | Status |
|----------------|---------|--------------|------------|--------|
| Hero lead | `<p class="lead">` | `color:black` | Day 3 | ✅ Migrated |
| About eyebrow | `<h4>` | `color:darkgray; font-weight:700` | Day 4 | ✅ Migrated |
| About title | `<h1>` | `font-weight:700; color:darkblue; font-size:60px; padding-block-end:50px` | Day 4 | ✅ Migrated |
| About brand links | `<a>` ×2 | font-size, color (red / navy) | Day 4 | ✅ Migrated |
| About paragraph | `<p>` | `text-align: justify` | Day 4 | ✅ Migrated |
| Service cards | `.service-card` ×3 | `background-color` per card | Day 5 | ✅ Migrated |
| Portfolio headings | `<h3>` ×4 | `color: darkblue` | Day 7 | ✅ Migrated |
| Portfolio QA cards | `<h5>` ×4 | `color: darkblue` | Day 7 | ✅ Migrated |
| Pricing subtitle | `<p>` | `color: darkblue; font-weight:700` | Day 8 | ✅ Migrated |
| Contact subtitle | `<p>` | `color: darkblue` | Day 9 | ✅ Migrated |
| Contact info icons | `<h5>` / `<i>` | `color: darkblue` | Day 9 | ✅ Migrated (semantic list + icons) |
| Login Dashboard btn | `<a>` | `background-color:rgb(26, 26, 126)` | Day 9 | ✅ Migrated |
| Send Message btn | `<button>` | `background-color: darkblue` | Day 9 | ✅ Migrated |
| Footer | `<footer>`, container, `<p>` | black bg, white text | Day 9 | ✅ Migrated |

---

## Day 1 & 2 — Verification checklist

### Day 1

| Check | Status |
|-------|--------|
| `:root` design tokens in `css/site.css` | ✅ |
| Google Fonts (Plus Jakarta Sans + Inter) in `<head>` | ✅ |
| Global typography scale (`clamp`, line-height, colors) | ✅ |
| `--section-py` on major sections (`section:not(.home)`) | ✅ |
| Hard black shadows replaced with `--shadow-soft` / `--shadow-medium` in CSS | ✅ |
| `@media (prefers-reduced-motion: reduce)` global block | ✅ |
| Inline style inventory documented | ✅ |

### Day 2

| Check | Status |
|-------|--------|
| `.site-navbar` transparent at top | ✅ |
| `.navbar-scrolled` blur + semi-white background on scroll | ✅ |
| Nav link hover + animated underline; `.active` state | ✅ |
| Pill Contact CTA → `#contact` | ✅ |
| `html { scroll-behavior: smooth }` | ✅ |
| JS smooth scroll with sticky nav offset | ✅ |
| Intersection Observer active section on `[data-nav]` links | ✅ |
| Mobile collapse works; stagger animation on open (CSS) | ✅ |

### Day 3

| Check | Status |
|-------|--------|
| `.hero-inner` wrapper; gradient overlay on `.home::before` | ✅ |
| Lead text uses light/inverse color (no inline `color:black`) | ✅ |
| `display-3` accent red; `display-4` white; sizes via `clamp()` | ✅ |
| Primary CTA (`.btn-hero-primary` navy fill) vs secondary ghost | ✅ |
| Stagger fade-up load animation on hero children | ✅ |
| Rotating tagline word (respects reduced motion) | ✅ |
| Mobile `background-position` adjustment | ✅ |

### Day 4

| Check | Status |
|-------|--------|
| `.section-header` with `.section-eyebrow` and `.section-title` | ✅ |
| Two-column layout: story left, stat cards right (desktop) | ✅ |
| Stat count-up on scroll via Intersection Observer | ✅ |
| About cards: white on `--surface-muted`, Bootstrap Icons | ✅ |
| Logo marquee: softer container, pause on hover/focus | ✅ |
| AOS `fade-up` on about blocks and stat cards | ✅ |
| No inline styles in `#about` section | ✅ |

### Day 5

| Check | Status |
|-------|--------|
| `.section-header` with eyebrow + title in `#services` | ✅ |
| Modifier classes: `--design`, `--management`, `--security` (no inline bg) | ✅ |
| Image `scale(1.05)` on hover via `.service-card__media` | ✅ |
| `.service-link` arrow slides right on hover | ✅ |
| `--shadow-soft` default; `--shadow-medium` + `translateY(-6px)` on hover | ✅ |
| AOS `fade-up` on all three cards (100 / 200 / 300 ms stagger) | ✅ |
| Responsive stack; consistent image height (260px / 220px mobile) | ✅ |
| No inline styles in `#services` section | ✅ |

### Day 6

| Check | Status |
|-------|--------|
| `.section-header` replaces double-border `h2` in `#features` | ✅ |
| Feature cards use `--shadow-soft`, `--border-subtle`, `--radius-lg` | ✅ |
| Hover lift + `border-color` transition + `--shadow-medium` | ✅ |
| Image treatment via `.feature-card__media` (overflow + subtle scale) | ✅ |
| AOS delays aligned to 100 ms stagger (100 / 200 / 300) | ✅ |
| `--surface-muted` section background for visual rhythm | ✅ |
| No inline styles in `#features` section | ✅ |
| Valid HTML (closed `features-grid` + `container`) | ✅ |

### Day 7

| Check | Status |
|-------|--------|
| `.section-header` with eyebrow + title + subtitle in `#portfolio` | ✅ |
| No Lorem ipsum — realistic project placeholders (client, service, outcome) | ✅ |
| Zigzag rows alternate `fade-right` / `fade-left` on image and text columns | ✅ |
| Portfolio images: `aspect-ratio`, `object-fit: cover`, `--radius-lg` | ✅ |
| Image hover overlay with "View Project" link | ✅ |
| Bottom QA cards use `.portfolio-capability-card` elevated card system | ✅ |
| AOS on capability cards (100 ms stagger: 100 / 200 / 300 / 400) | ✅ |
| No inline styles in `#portfolio` section | ✅ |

### Day 8

| Check | Status |
|-------|--------|
| `.section-header` in `#team` and `#pricing` | ✅ |
| Team avatars: circular with brand gradient ring border | ✅ |
| Team hover: grayscale → color + card lift (`--shadow-soft` → `--shadow-medium`) | ✅ |
| Typos fixed: "Officerr" → "Officer", "Networkingr" → "Networking" | ✅ |
| Team placeholder structure with `loading="lazy"` on images | ✅ |
| Gold plan marked "Most Popular" with badge, scale, and primary border | ✅ |
| Featured plan: filled primary button; others: outline | ✅ |
| Pricing cards equal height via flex layout | ✅ |
| Checklist items stagger fade-in on card hover | ✅ |
| No inline styles in `#team` or `#pricing` sections | ✅ |
| Pricing uses design tokens only (no ad-hoc darkblue) | ✅ |

### Day 9

| Check | Status |
|-------|--------|
| `.contact-section` on `--surface-muted` background | ✅ |
| `.section-header` with eyebrow + title + subtitle in `#contact` | ✅ |
| Valid semantic HTML — no block elements inside `<p>` | ✅ |
| Contact info uses `<ul>` + `<address>` + icon labels | ✅ |
| Form inputs: `--radius-md`, focus ring in `--brand-primary` | ✅ |
| Social icons: scale + brand color on hover | ✅ |
| Admin login link preserved (`admin/login.php`) | ✅ |
| Contact form `action="contact.php"` + field names unchanged | ✅ |
| Multi-column `.site-footer` (logo, quick links, contact snippet) | ✅ |
| Footer gradient accent border-top (navy → accent) | ✅ |
| Footer link hover underline transition | ✅ |
| WOW.js script removed | ✅ |
| Animate.css link removed | ✅ |
| AOS single init documented at top of `site.js` | ✅ |
| All major sections have `data-aos` attributes | ✅ |
| No inline styles in `#contact` or `#footer` | ✅ |

### Day 10

| Check | Status |
|-------|--------|
| Zero inline `style=""` in `index.html` | ✅ |
| Below-fold images use `loading="lazy"` (services, features, pricing, portfolio, team, footer) | ✅ |
| Google Fonts use `display=swap` | ✅ |
| `:focus-visible` outline on interactive elements | ✅ |
| Touch targets ≥ 44px (nav links, toggler, CTAs, form inputs, submit) | ✅ |
| `contact.php` redirect flow unchanged (`name`, `email`, `message`) | ✅ |
| Responsive checklist signed off (see Testing checklists) | ✅ |
| Accessibility quick audit (semantic HTML, labels, alt text, focus) | ✅ |

---

## Day 10 — Implementation notes

### Files changed (Days 9–10)

| File | Changes |
|------|---------|
| `index.html` | Contact + footer restructure; removed Animate.css + WOW.js; lazy-load images; zero inline styles |
| `css/site.css` | Contact section, multi-column footer, `:focus-visible`, touch target min-heights |
| `js/site.js` | Removed WOW init; AOS config block comment at top |
| `docs/2-week-design-implementation-plan.md` | Day 9/10 deliverables, verification, implementation log |

### Deploy / smoke test

1. Open `index.html` locally or on staging — confirm hero, nav scroll, and all sections render.
2. Submit contact form — verify redirect to `index.html?contact=success#contact` (or error states).
3. Click **Login Dashboard** in contact section — confirm `admin/login.php` loads.
4. Test at 375px and 1280px widths; toggle mobile nav menu.
5. Enable **Reduce motion** in OS — confirm AOS/hero animations are suppressed.

### CDN libraries remaining

- Bootstrap 5.3 CSS + JS
- Bootstrap Icons
- AOS 2.3.4
- Google Fonts (Plus Jakarta Sans + Inter)

### Known deferrals (out of scope)

- Admin dashboard styling (`admin/*.php` still has inline styles)
- Real social media URLs (placeholders `#`)
- Open Graph meta tags (optional backlog)
