# Recipes start with ">" instead of a tab, so copy/paste can't break them.
.RECIPEPREFIX = >

include .env
export


# Run PHP tooling in the api container as your own user (avoids root-owned files).
RUN = docker compose run --rm --no-deps --user $(shell id -u):$(shell id -g) -e COMPOSER_HOME=/tmp/composer api

.PHONY: install check api-check web-check test stan cs cs-fix web-format web-lint web-test web-build

install:
> $(RUN) composer install
> cd web && npm install

# Everything an agent must run before saying "done".
check: api-check web-check

api-check:
> $(RUN) composer check

web-check: web-format web-lint web-test web-build

test:
> $(RUN) composer test

stan:
> $(RUN) composer stan

cs:
> $(RUN) composer cs

cs-fix:
> $(RUN) composer cs:fix

web-format:
> cd web && npx prettier --check "src/**/*.{ts,html,css}"

web-lint:
> cd web && npx ng lint

web-test:
> cd web && npx ng test --watch=false

web-build:
> cd web && npx ng build

db-init:
> docker compose exec -T db /opt/mssql-tools18/bin/sqlcmd \
>   -S localhost \
>   -U sa \
>   -P "$$DB_PASSWORD" \
>   -C \
>   -i /dev/stdin < database/001_create_tasks.sql
