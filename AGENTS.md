# Harness Lab Agent Instructions

## Mission

This repository exists to learn harness engineering.

The goal is not to add features quickly.
The goal is to build software safely and predictably.

## Rules

- Keep changes small and focused.
- Prefer modifying existing files over creating new files.
- Do not introduce new dependencies without justification.
- Do not edit generated files.
- Do not change Docker configuration unless explicitly asked.
- Do not disable tests, linting, or static analysis.

## Definition of Done

A task is only complete when:

make check

passes successfully.

Never claim success without running the harness.

## Project Structure

/api
PHP backend

/web
Angular frontend

## Development Approach

1. Understand the existing code.
2. Make the smallest possible change.
3. Run the harness.
4. Fix all failures.
5. Only then consider the task complete.

