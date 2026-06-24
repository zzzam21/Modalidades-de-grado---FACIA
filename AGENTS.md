# AGENTS.md — modalidades

CodeIgniter 4 MVC app (PHP 8.1+) for managing academic degree modalities. Spanish codebase.

## Quick start

```powershell
composer install
# set CI_ENVIRONMENT, DB creds, and GEMINI_API_KEY in .env
php spark serve
```

- **Dev server**: `http://localhost:8080/`
- **XAMPP Apache**: `http://localhost/modalidades/public/`
- **DB**: MySQL `modalidadesfacia`, user `root`, port `3306` (XAMPP), creds in `.env`
- `.env` is gitignored — never commit secrets. Template is `env` (copy to `.env`).

## Key commands

| Action | Command |
|---|---|
| Run all tests | `vendor/bin/phpunit` or `composer test` |
| Run single test | `vendor/bin/phpunit --filter testName` |
| CI4 CLI | `php spark` |

No linter, typechecker, or codegen configured.

## Architecture

- **Controllers** (`app/Controllers/`) — inconsistent casing (`modalitieController`, `studentController`, `importPdfController`, `TeachersController`) — match existing style per file. Routes reference PascalCase even when filename is camelCase.
- **Models** (`app/Models/`) — extend `CodeIgniter\Model`; 8 models for tables: `modalities`, `teachers`, `students`, `programs`, `users_program`, `type_modalities`, `modalitie_student`, `modalitie_teacher`, plus `UserModel` for `users`.
- **Views** (`app/Views/`) — `dashboard/`, `dashboard/Modules/`, `auth/`, `layout/`, `errors/`
- **`app/Libraries/openAIService.php`** — calls **Google Gemini** (`gemini-2.5-flash`), **not** OpenAI despite the name. Expects `GEMINI_API_KEY` in `.env`.
- **`app/Filters/AuthFilter.php`** — session-based auth guard (`logged_in` session key). Capital `A` required for PSR-4 (Linux case-sensitive).
- **Routes** (`app/Config/Routes.php`) — all internal routes use `['filter' => 'auth']`; only `/auth/login` (GET+POST) is public. **Duplicate route**: `/configuration/updatePassword` defined twice on lines 81 and 85.

## PDF import flow

1. POST `/modalities/add` → `importPdfController::importPdf` — parses PDF with `smalot/pdfparser`, sends text to Gemini with a detailed extraction prompt
2. Returns JSON with structured data (students, advisors, modality details)
3. POST `/modalities/process` → `ModalitieController::processModalitie` — validates and persists via DB transaction (rolls back on failure)

## Testing

- Test DB auto-switches to SQLite3 `:memory:` when `ENVIRONMENT === 'testing'` (`Config\Database` constructor)
- Only CI4 boilerplate tests exist (`HealthTest.php`, `ExampleDatabaseTest.php`, `ExampleSessionTest.php`) — no app-specific tests
- PHPUnit 10 config in `phpunit.xml.dist`; copy to `phpunit.xml` to customize

## Database

- Schema is managed directly (no migration files, no `db/init.sql`). Tables are created manually or via phpMyAdmin.
- **Default admin**: `admin@admin.com` / `admin123`
- The `programs` table (program+sede combos with `program_ID` codes like 31/170/171) is the critical lookup for PDF extraction — `sede_codigo` must match exactly or extraction returns null.

## Notable conventions

- All text content is Spanish (UI, comments, variables, AI prompt)
- Controllers instantiate models inline with `new \App\Models\...` (no DI)
- `builds` script toggles CI4 between stable release and dev-develop
