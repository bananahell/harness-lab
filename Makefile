# Recipes start with ">" instead of a tab, so copy/paste can't break them.
.RECIPEPREFIX = >

# Run commands in the api container as your own user (avoids root-owned files).
RUN = docker compose run --rm --no-deps --user $(shell id -u):$(shell id -g) -e COMPOSER_HOME=/tmp/composer api

.PHONY: install check test stan cs cs-fix

install:
> $(RUN) composer install

check:
> $(RUN) composer check

test:
> $(RUN) composer test

stan:
> $(RUN) composer stan

cs:
> $(RUN) composer cs

cs-fix:
> $(RUN) composer cs:fix
