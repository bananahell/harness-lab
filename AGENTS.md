# Harness Lab Agent Instructions

## Mission

This repository exists to learn harness engineering.

The goal is not to add features quickly.
The goal is to build software safely and predictably.

## Rules

- Keep changes small and focused.
- Add new files only when needed (for example a new class and its test); otherwise modify existing files.
- Do not introduce new dependencies without justification.
- Do not edit generated files: `api/composer.lock`, `web/package-lock.json`, `web/dist/`, `vendor/`, `node_modules/`, and any `*.cache` file. Change dependencies through Composer or npm instead.
- Do not change Docker configuration unless explicitly asked.
- Do not disable tests, linting, or static analysis, and do not loosen their configuration (`api/phpstan.neon`, `api/.php-cs-fixer.dist.php`, `api/phpunit.xml.dist`, `web/eslint.config.js`).
- Never silently ignore bad data or errors; fail loudly with a clear message.

## Commands

Docker must be running. All commands run from the repository root.

- `make check`: run every check. It also starts the database and resets it to the seed data.
- `make db-init`: start the database and apply `database/*.sql` in filename order.
- `make cs-fix`: auto-fix PHP code style.
- `make web-check`: run only the Angular checks.
- `make hooks`: activate the git pre-commit hook (once per clone).

## Definition of Done

A task is only complete when `make check` passes successfully.

Never claim success without running the harness.

## Project Structure

- `/api`: PHP backend (`src/`, `tests/`, `public/index.php`)
- `/web`: Angular frontend
- `/database`: SQL scripts, applied in filename order

The integration test depends on the seed data in `database/002_seed.sql`.
If you change the seed or schema, update the tests in the same change.

## Development Approach

1. Understand the existing code.
2. Make the smallest possible change.
3. Run the harness.
4. Fix all failures.
5. Only then consider the task complete.

## Learning Loop

If the same mistake has to be corrected twice, add a rule here or a check
to `make check` so it cannot happen a third time.
