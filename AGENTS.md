# Claude Project Instructions

Zero Productions — Spanish-language marketing site for the concert producer (the same
producer that is tenant #1 of the ZeroPass ticketing SaaS, a separate repo). Laravel 12,
Blade + Tailwind **v3** + Alpine 3, Vite. A public site (home, eventos, contacto) plus a
small admin panel (event CRUD, images, ticket links, site settings, contact messages).
The UI is **Spanish**; code, comments, and commit messages are English. Ticket sales
happen in ZeroPass — this site only links out to them via each event's `EventLink`s.
`AGENTS.md` is an identical mirror of this file — when you edit one, copy it over the
other.

## Skills — activate them, don't wait until stuck

- **`verify`** (`.claude/skills/`) — drive the real app locally when the test suite isn't
  enough proof, or to reproduce a reported bug.
- **`laravel-best-practices`** (mirrored in `.agents/skills/`) — generic backend rule set;
  project conventions here override it.

## Deployment — Heroku, auto-deploy, no CI gate

- App `zero-productions` (zero-productions.com). **Every push to `main` auto-deploys via
  the Heroku GitHub integration and there is NO CI gate** — run the full test suite and
  Pint before every push; a broken push is live in minutes.
- The `Procfile` has a `release` phase (`php artisan migrate --force`) — pending
  migrations run automatically on every deploy.
- PostgreSQL in production, SQLite locally — write migrations that work on both (one
  existing migration is pgsql-only and guarded; follow that pattern if unavoidable).
- **Images live in the database** (`images.data`, base64 text) because the Heroku
  filesystem is ephemeral — this is deliberate, don't "fix" it. They serve through
  `/media/{image}`. The `Image` model hides `data` and excludes it from default selects
  (`$defaultColumns` + `booted()`) — keep that discipline in any query touching images.

## Domain notes

- Models: `Event` (slug URLs `/eventos/{slug}`, cover + flyer images, gallery),
  `EventLink` (external ticket links, orderable), `Image` (kind: cover/flyer/gallery),
  `SiteSetting` (key-value site config), `ContactMessage`, `User`.
- **Admin is any authenticated + verified user** — Breeze auth, no role column, and the
  Breeze registration routes exist. That's a known quirk of a single-admin site; don't
  add a role system unless asked. Local seeded admin: `admin@example.com` / `password`
  (already verified).
- Contact form: throttled 3/min per IP, Cloudflare Turnstile verified **only when
  `services.turnstile.secret_key` is set** (skips locally), notification mail via Resend
  in prod (`MAIL_MAILER=log` locally).
- SEO matters here: per-page titles/descriptions/OpenGraph — keep them when touching
  public views.

## Front-End

1. **Tailwind v3** — config lives in `tailwind.config.js` (NOT v4's CSS-first `@theme`):
   `primary` blue palette, `font-display` (Bebas Neue/Impact), `font-sans` (Instrument
   Sans). Don't apply Tailwind v4 idioms (`@import "tailwindcss"`, `@theme`) here.
2. Alpine 3 for interactivity (loaded in `resources/js/app.js`); keep page behavior in
   existing patterns — check sibling views before inventing new ones.
3. Assets build with Vite (`npm run build`); Heroku builds its own on deploy.

## Back-End

1. Validate all input explicitly; keep controllers small; business logic out of Blade.
2. Eloquent relationships with eager loading (no N+1); named routes everywhere.
3. No schema changes unless requested; schema changes always via migrations.
4. Never run `migrate:fresh`, `db:wipe`, destructive seeders, or anything against the
   prod DB without explicit approval.
5. Don't edit `.env`, credentials, or Heroku config vars unless explicitly requested.

## Language rule — English in code, no exceptions

All identifiers, comments, commit messages, and developer-facing log/exception text are
**English**. When touching a line with a Spanish comment, translate it. The **only**
Spanish is user-facing text: UI copy in Blade views, validation/flash messages, and
mail bodies shown to users.

## Commands

```bash
php artisan test          # full suite (~2s, SQLite) — keep it green, run before every push
vendor/bin/pint           # pre-approved, run freely before committing
npm run build             # production assets; npm run dev for a watcher
php artisan serve         # local server (not a Herd site); composer run dev for the full stack
```

## Testing

PHPUnit (not Pest); tests run on SQLite. Feature tests for HTTP flows. Add/update tests
when fixing bugs or adding behavior — there is no CI, the local suite is the only gate.

## Working style

1. Match the existing code style; smallest safe change; no unsolicited refactors or
   drive-by modernization. Don't touch unrelated files.
2. Commit messages follow the history: `Area: imperative description` — capitalized,
   concise (e.g. `Event page: align cover image crop to top`, `Fix test suite: guard
   pgsql-only migration`). Commits go directly to `main`, and `main` auto-deploys — every
   commit must leave the site deployable.
3. Before broad or risky changes, explain the plan first. If a requirement is ambiguous,
   ask before building.
4. Don't create or modify README/docs unless asked.
5. At the end of a task, summarize: files changed, what changed, tests/checks run.
