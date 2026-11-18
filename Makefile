# Recipes start with ">" instead of a tab, so copy/paste can't break them.
.RECIPEPREFIX = >

-include .env
export

SQLCMD = /opt/mssql-tools18/bin/sqlcmd

# Run PHP tooling in the api container as your own user (avoids root-owned files).
RUN = docker compose run --rm --no-deps --user $(shell id -u):$(shell id -g) -e COMPOSER_HOME=/tmp/composer api

.PHONY: install hooks check api-check web-check test stan cs cs-fix web-format web-lint web-test web-build db-up db-init

install:
> $(RUN) composer install
> cd web && npm install

# Activate the git hooks stored in .githooks (run once per clone).
hooks:
> git config core.hooksPath .githooks
> chmod +x .githooks/pre-commit

# Everything an agent must run before saying "done".
check: api-check web-check

api-check: db-init
> $(RUN) composer check

web-check: web-format web-lint web-test web-build

test: db-init
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

# Start the database container and wait until it accepts connections.
db-up:
> docker compose up -d db
> for i in $$(seq 1 30); do \
>   docker compose exec -T db $(SQLCMD) -S localhost -U sa -P "$$DB_PASSWORD" -C -Q "SELECT 1" > /dev/null 2>&1 && exit 0; \
>   echo "waiting for db ($$i/30)..."; sleep 2; \
> done; echo "db did not become ready"; exit 1

# Apply database/*.sql in filename order (002_seed.sql RESETS the tasks table).
db-init: db-up
> for f in database/*.sql; do \
>   echo "Applying $$f"; \
>   docker compose exec -T db $(SQLCMD) -b -S localhost -U sa -P "$$DB_PASSWORD" -C -i /dev/stdin < $$f || exit 1; \
> done
