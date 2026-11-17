# Harness Lab

A small project used to learn harness engineering.

## Stack

- Angular frontend
- PHP backend
- SQL Server database
- Docker

## Start the environment

docker compose -f docker-compose.yml build --no-cache && docker compose -f docker-compose.yml up --build

## Initialize the database

make db-init

## Verify the project

make check

## Endpoints

Health check:

http://localhost:8080

Tasks:

http://localhost:8080/tasks

## Harness Rules

A task is not complete until:

make check

passes successfully.
