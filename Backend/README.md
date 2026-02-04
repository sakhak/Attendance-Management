# Attendance Management

This repository contains a Laravel backend and a React + TypeScript frontend for the Attendance Management project.

## Repository Structure

- `Backend/` — Laravel 12 API and server-rendered assets.
- `Frontend/` — Vite + React client application.

## Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+ (recommended) and npm
- A database supported by Laravel (e.g., MySQL, Postgres, SQLite)

## Backend Setup (Laravel)

```bash
cd Backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```
### Run the backend locally

```bash
cd Backend
php artisan serve
```

If you want to run the full Laravel + Vite dev stack (including queue and logs), use:

```bash
cd Backend
composer run dev
```

## Frontend Setup (React + Vite)

```bash
cd Frontend
npm install
```

### Run the frontend locally

```bash
cd Frontend
npm run dev
```

### Build the frontend

```bash
cd Frontend
npm run build
```

## Testing

Backend tests:

```bash
cd Backend
php artisan test
```

Frontend linting:

```bash
cd Frontend
npm run lint
```

## Notes

- Configure environment variables in `Backend/.env` as needed for your database and services.
- If the frontend consumes the backend API, update the frontend API base URL to match your backend host and port.
