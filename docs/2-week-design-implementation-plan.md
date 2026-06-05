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

- [ ] `:root` token block in `site.css`
- [ ] Fonts loading; body and heading styles applied
- [ ] Inline style inventory documented (in this file or a scratch note)

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

- [ ] Scroll-triggered navbar transition
- [ ] Active nav link reflects current section
- [ ] Smooth anchor navigation with correct offset

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

- [ ] Hero readable on all breakpoints
- [ ] Clear primary vs secondary CTA
- [ ] Entrance animation on page load (respects reduced motion)

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

- [ ] About section uses design tokens only
- [ ] Stats animate once when visible
- [ ] Logo slider pauses on hover

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

- [ ] No inline styles on service cards
- [ ] Hover states feel premium and consistent
- [ ] AOS applied to all three service cards

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

- [ ] Features match global section header pattern
- [ ] Card styling aligned with services/features token system

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

- [ ] No Lorem ipsum in portfolio
- [ ] Zigzag layout animates on scroll
- [ ] Image hover overlay (or documented as skipped with reason)

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

- [ ] Team cards have hover polish and consistent avatar frame
- [ ] Gold plan visually dominant
- [ ] Pricing uses tokens; no ad-hoc darkblue inline styles

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

- [ ] Valid semantic HTML in contact block
- [ ] Footer feels complete, not an afterthought
- [ ] Only AOS + CSS animations remain
- [ ] `site.js` documents AOS config at top

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

- [ ] Responsive checklist signed off (see below)
- [ ] Accessibility quick audit complete
- [ ] Implementation notes appended to bottom of this doc

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

- [ ] Hero text doesn't overflow on small phones
- [ ] Navbar toggler works; menu items reachable
- [ ] Service/feature/pricing cards stack without horizontal scroll
- [ ] Logo marquee doesn't break layout on mobile
- [ ] Portfolio zigzag collapses to single column cleanly
- [ ] Contact form full width on mobile

### Animation

- [ ] Reduced motion disables scroll animations and hero stagger
- [ ] No jank on scroll (test on mid-tier mobile if possible)
- [ ] Logo marquee pauses on hover/focus

### Functional

- [ ] All nav anchor links land at correct section (offset for sticky nav)
- [ ] Contact form submission + success/error alerts still work
- [ ] Admin login link still reachable from contact section

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
| | 1 | | |
| | 2 | | |
| | 3 | | |
| | 4 | | |
| | 5 | | |
| | 6 | | |
| | 7 | | |
| | 8 | | |
| | 9 | | |
| | 10 | | |

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

*Last updated: June 4, 2026 — generated for YARAMAY website redesign implementation.*
