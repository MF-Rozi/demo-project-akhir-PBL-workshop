# Copilot instructions for this repository

## Build, test, and lint commands

- **Initial setup (PHP deps, env, key, migrate, JS deps, production assets):**
  - `composer setup`
- **Run local dev stack (Laravel server + queue listener + Vite dev server):**
  - `composer dev`
- **Build frontend assets:**
  - `npm run build`
- **Run full test suite:**
  - `composer test`
  - or `php artisan test`
- **Run a single test file:**
  - `php artisan test tests/Feature/Auth/AuthenticationTest.php`
- **Run a single test by name/filter:**
  - `php artisan test --filter="users can authenticate using the login screen"`
- **Lint/format PHP:**
  - Check only: `./vendor/bin/pint --test`
  - Auto-fix: `./vendor/bin/pint`

Tests are configured to use in-memory SQLite in `phpunit.xml`; local test execution requires the `pdo_sqlite` PHP extension.

## High-level architecture

This is a Laravel 13 monolith with two main surfaces:

1. **Public site** (`/`, `/zone/{zone}`, `/attraction/{attraction}`)  
   Implemented by `HomeController` and `ReviewController`. Visitors can browse zones/attractions and submit reviews without login.
2. **Admin panel** (`/admin/*`)  
   Protected by `auth` middleware, implemented with resource controllers (`Admin\ZoneController`, `Admin\AttractionController`) plus custom review moderation actions (`Admin\ReviewController`).

Domain model flow:

- `Zone` has many `Attraction`
- `Attraction` belongs to `Zone` and has many `Review`
- `Review` belongs to `Attraction` and is moderated via `is_approved`
- Public pages only render approved reviews (`approvedReviews` relation / `approved` scope)
- Migrations enforce cascades (`zone -> attractions`, `attraction -> reviews`)

Rendering/UI flow:

- Blade templates are split by role with dedicated layouts:
  - `resources/views/layouts/public.blade.php`
  - `resources/views/layouts/admin.blade.php`
- Assets are bundled with Vite from:
  - `resources/css/app.scss` (Bootstrap + custom styles)
  - `resources/js/app.js` (Bootstrap JS)

Seed data flow:

- `DatabaseSeeder` calls `AdminUserSeeder`, `ZoneSeeder`, `AttractionSeeder` in that order.

## Key repository conventions

- Prefer **route model binding** for domain routes/controllers (typed params like `Zone $zone`, `Attraction $attraction`, `Review $review`).
- Keep review moderation logic centered on `Review::approved()` / `Review::pending()` scopes and `Attraction::approvedReviews()`.
- For admin CRUD image uploads, use the **public disk** and keep file lifecycle consistent:
  - Store to `zones/` or `attractions/`
  - Delete old image when replacing/deleting records
- Use existing route naming patterns:
  - Public: `home`, `zone.show`, `attraction.show`, `review.store`
  - Admin: `admin.dashboard`, `admin.zones.*`, `admin.attractions.*`, `admin.reviews.*`
- Follow current validation style: inline `$request->validate([...])` in controllers rather than introducing new Form Request classes unless a broader refactor is requested.
- Admin views expect flash message keys `success` and `error` from controller redirects.
