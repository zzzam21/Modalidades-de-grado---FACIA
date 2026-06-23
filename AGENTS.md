# AGENTS.md — modalidades

CodeIgniter 4 MVC app (PHP 8.1+) for managing academic degree modalities. Spanish codebase.

## Quick start

```powershell
composer install
# set CI_ENVIRONMENT, DB creds, and GEMINI_API_KEY in .env
php spark serve
```

- **Dev server** (spark): `http://localhost:8080/`
- **XAMPP Apache**: `http://localhost/modalidades/public/`
- **DB**: MySQL `modalidadesfacia`, default user `root`, port `3306` (XAMPP) or `3307` (Docker), creds in `.env`
- `.env` is gitignored — never commit secrets

## Key commands

| Action | Command |
|---|---|
| Run all tests | `vendor/bin/phpunit` or `composer test` |
| Run single test | `vendor/bin/phpunit --filter testName` |
| CI4 CLI | `php spark` |
| Dev server | `php spark serve` |

No linter, typechecker, or codegen configured.

## Architecture

- **`app/Controllers/`** — MVC controllers with inconsistent casing (e.g., `modalitieController`, `TeachersController`) — match existing style per file
- **`app/Models/`** — extend `CodeIgniter\Model`; tables: `modalities`, `teachers`, `students`, `programs`, `users_program`, `type_modalities`, `modalitie_student`, `modalitie_teacher`
- **`app/Views/`** — dashboard views under `dashboard/`, `dashboard/Modules/`, `auth/`
- **`app/Libraries/openAIService.php`** — calls **Google Gemini** (`gemma-4-26b-it`), **not** OpenAI. Expects `GEMINI_API_KEY` in `.env`.
- **`app/Filters/AuthFilter.php`** — session-based auth guard (`logged_in` session key)
- **`app/Config/Routes.php`** — all internal routes use `['filter' => 'auth']`; only `/auth/login` is public

## PDF import flow

1. POST `/modalities/add` → `importPdfController::importPdf` — parses PDF with `smalot/pdfparser`, sends text to Gemini with a detailed extraction prompt
2. Returns JSON with structured data (students, advisors, modality details)
3. POST `/modalities/process` → `modalitieController::processModalitie` — validates and persists via DB transaction (rolls back on failure)

## Database

- No migration files — authoritative schema is `db/init.sql` (8 tables with foreign keys, seeded programs and admin user)
- **Default admin**: `admin@admin.com` / `admin123`
- The `programs` table (8 rows: program+sede combos with `program_ID` codes like 31/170/171) is the critical lookup for PDF extraction — `sede_codigo` must match exactly or extraction returns null

## Testing quirks

- Test DB auto-switches to SQLite3 `:memory:` when `ENVIRONMENT === 'testing'` (`Config\Database` constructor checks this)
- Only CI4 boilerplate tests exist (`HealthTest.php`, `ExampleDatabaseTest.php`, `ExampleSessionTest.php`) — no app-specific tests yet
- PHPUnit 10 config in `phpunit.xml.dist`; copy to `phpunit.xml` to customize

## Docker

```powershell
# Requires env vars: GEMINI_API_KEY, DB_PASSWORD, DB_ROOT_PASSWORD
docker compose up -d
```

| Service | URL |
|---|---|
| App | `http://localhost/` |
| phpMyAdmin | `http://localhost:8081` |
| MySQL (host) | `localhost:3307` |

- `db:8.4` with healthcheck; app waits for healthy DB
- `db/init.sql` auto-seeds schema + data on first start
- PHP 8.3 Apache with aggressive OPcache, mod_rewrite+headers+expires

## Linux case-sensitivity

`app/Filters/AuthFilter.php` must keep capital `A` (PSR-4). Windows tolerates lowercase, Linux Docker container does not.

## Notable conventions

- All text content is Spanish (UI, comments, variables, AI prompt)
- Controllers instantiate models inline with `new \App\Models\...` (no DI)
- `.env` is gitignored — never commit secrets
