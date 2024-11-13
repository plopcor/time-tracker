

# Usage

### Set up
1. Copy `.env.example` as `.env`
2. Modify `DOCKER_USER` (and `DOCKER_USER_UID` if on Linux)

## Docker

### Build image
```bash
docker compose up -d --build
```

### Commands
All the commands that are normally required are already in `entrypoint.sh`

This way they get executed on each docker start

```bash
# Install dependencies
docker exec prueba-app /bin/bash composer install

# Generate key (only first launch)
docker exec prueba-app php artisan key:generate

# Create database (create SQLite file if necessary and migrate)
docker exec prueba-app php artisan migrate
```

### Access

**Go to http://localhost:8000**

# Project
It's been built on top of Laravel 11 (PHP 8.2) implementing the hexagonal architecture

Laravel provides the backend and frontend for it

Containerized with Docker through `docker compose` to create two services, PHP and Nginx to serve it. 

# Backend
- All the hexagonal architecture classes are on `\src` folder
- It has controllers, entities, services, repositories and commands.

**Domain**
- Created entities to work and pass data (`Task` and `TaskTime`)
- Created commands to encapsulate data and make it immutable and easy to work with

**Ports**
- Created interfaces for the repositories
- WIP-Command line script to make actions on tasks

**Adapters**
- Created HTTP controller for API requests
- Created custom `Request` classes for the API HTTP controller so data can be validated
- Created repositories on top of Laravel's Eloquent ORM
- Map all the data from Eloquent to the domain Entities


# Frontend
- Made with Vue 2 + Axios through CDNs, no need to compile.
- Fully responsive for mobile and desktop
- Split in multiple components, each one having one responsibility
- Using events to communicate between components
- Created `TaskService.js` to have all the axios calls
- Single page that will show the time tracking input and list of tasks worked at today
- Detail of each work period in a task, starting date, end date and duration
- Show total time worked today

**UI**

We have two parts:
- Task input: Specify task name, start/stop working on it and show elapsed time
- Task list:
  - Shows today's tasks with each time registered (start date, end date and duration)
  - Shows today's total worked time
  - Updates when you start/stop working on a task

# Command line (WIP)
**You can find the scripts in `\app\Console\`**

`TaskAction.php` Start or stop working on a task

Parameters:
- `action` [string] Action to perform. Valid values: `start`, `stop`
- `name` [string] Task name to start or stop

`TaskList.php` List of all created tasks and the times registered
