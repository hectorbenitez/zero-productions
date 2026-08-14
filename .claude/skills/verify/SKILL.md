---
name: verify
description: How to run and drive the Zero Productions marketing site end-to-end to verify changes at the real surface (local server + curl). Use after building a feature when the PHPUnit suite isn't enough proof, or to reproduce a reported bug against the real app.
---

# Verifying Zero Productions

Not a Herd site — serve it yourself from the repo root:

```bash
php artisan serve                # http://127.0.0.1:8000
# or: composer run dev           # serve + queue listener + vite watcher
```

## Prepare state

```bash
php artisan migrate --no-interaction     # SQLite locally (database/database.sqlite)
php artisan db:seed --no-interaction     # admin + settings are updateOrCreate (safe to re-run);
                                         # EventsSeeder plain-creates — seed once, or re-runs duplicate the sample events
npm run build                            # views use @vite
```

Seeded admin: `admin@example.com` / `password` (pre-verified — admin routes require
`auth` + `verified`). Registration routes exist (Breeze default) — any verified user
reaches `/admin`; that's a known quirk, not a bug to fix.

## External services degrade by design

- **Turnstile**: the contact form only verifies when `services.turnstile.secret_key` is
  set — locally it just submits.
- **Mail**: `MAIL_MAILER=log` locally — contact notifications land in
  `storage/logs/laravel.log` (Resend only in prod).
- The contact form is throttled `3,1` — a 4th POST inside a minute 429s; that's the
  throttle working, not a regression.

## Drive with curl

Public pages are plain GETs: `/`, `/eventos`, `/eventos/{slug}`, `/contacto`, and images
at `/media/{id}`. Forms need the CSRF token and a cookie jar:

```bash
JAR=$(mktemp); BASE=http://127.0.0.1:8000
HTML=$(curl -s -c $JAR $BASE/login)
TOKEN=$(echo "$HTML" | grep -o 'name="_token" value="[^"]*"' | head -1 | sed 's/.*value="//;s/"//')
curl -s -b $JAR -c $JAR -X POST $BASE/login \
  --data-urlencode "_token=$TOKEN" \
  --data-urlencode "email=admin@example.com" \
  --data-urlencode "password=password" \
  -o /dev/null -w "%{http_code} -> %{redirect_url}\n"
```

## Flows worth driving

- Home: hero rotates event covers, always shows 6 events (upcoming + recent past)
- `/eventos` list (upcoming/past split) → event detail: cover, ticket links in their
  saved order, gallery
- Contact: submit → flash + mail in the log; hammer it to see the 429
- Admin: event CRUD → upload cover/flyer/gallery (lands in the DB, serves via
  `/media/{id}`) → reorder links/gallery → site settings → contact-messages inbox
- Guest hitting `/admin` → redirect to login

## Gotchas

- Shell cwd resets between Bash calls — use absolute paths or `cd` within one command.
- Image queries must not select `data` accidentally — the model excludes it by default;
  respect `Image::$defaultColumns` when writing custom queries.
- Prod is PostgreSQL, local is SQLite — behavior that differs between them (ILIKE, casts,
  bytea history) belongs behind the patterns already in the migrations/tests.
