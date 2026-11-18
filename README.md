# Harness Lab

A small project used to learn harness engineering.

## Stack

- Angular frontend
- PHP backend
- SQL Server database
- Docker

## Setup (once per clone)

    cp .env.example .env    # then set your own DB_PASSWORD
    make hooks

## Start the environment

    docker compose up -d --build

## Initialize the database

    make db-init

## Verify the project

    make check

## Endpoints

- Health check: http://localhost:8080
- Tasks: http://localhost:8080/tasks

## Harness rules

See `AGENTS.md`. Definition of done: `make check` passes.
