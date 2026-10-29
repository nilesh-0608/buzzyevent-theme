# Buzzy Event

A fast, dependency-free classic WordPress theme for long-form technical writing.

Dark-first editorial design with a single reading column, built for a blog that
publishes code. No page builder, no jQuery, no build step — upload it and it runs.

## What it does

- **Dark by default**, with a light palette for visitors whose OS asks for one.
  All colour pairs meet WCAG AA.
- **One reading column.** The article header, body, footer and comments share a
  single measure, so there is exactly one left edge. Images, code blocks and
  tables break out to a wider centred band, capped so they can never cause
  sideways scrolling.
- **First-class code blocks** — distinct surface, monospace, horizontal scroll,
  and styling for core block output generally (quotes, tables, galleries,
  captions, buttons, separators).
- **Lean head.** Emoji scripts, generator, RSD and wlwmanifest output are all
  removed. One stylesheet, one small vanilla-JS file for the mobile nav.
- Custom logo, custom menu, featured images, translation-ready, skip link,
  visible focus rings, and `prefers-reduced-motion` support.

## Install

Download the repository as a ZIP, then in WordPress go to
**Appearance → Themes → Add New → Upload Theme**, pick the ZIP, install and
activate.

The folder inside the ZIP must be named `buzzyevent`.

## Setup

- The homepage headline and standfirst are generated from **Settings → General**
  (site title and tagline) — they are not hardcoded. Edit them there.
- Assign a menu to the **Primary** location under **Appearance → Menus**. Without
  one, the theme falls back to listing pages.

## Typography

Headings use Manrope, body copy uses DM Sans, both served from Google Fonts and
enqueued properly with a `preconnect` hint. A system font stack is declared as a
fallback, so the theme still renders correctly if Google Fonts is unreachable.

## Requirements

WordPress 6.0+, PHP 7.4+.

## Licence

GPLv2 or later — <https://www.gnu.org/licenses/gpl-2.0.html>
