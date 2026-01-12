# Laravel 12 Application (Dockerized)

This is a **Laravel 12** application designed to run fully containerized using **Docker Compose**. The setup includes multiple services (such as the Laravel app, database, cache, etc.) and provides a straightforward workflow to get the project up and running locally.

---

## 🧰 Requirements

Make sure you have the following installed on your machine:

-   Docker
-   Docker Compose

No local PHP, Composer, or database installation is required.

---

## 🚀 Getting Started

### 1. Start the containers

Build and start all services in detached mode:

```bash
docker compose up -d
```

---

### 2. (Optional) Create cache directory

In some environments, Laravel may require the `bootstrap/cache` directory to exist and be writable:

```bash
docker exec -it laravel_app mkdir -p /var/www/html/bootstrap/cache
```

---

### 3. Install PHP dependencies

Run Composer inside the Laravel container:

```bash
docker exec -it laravel_app composer install
```

---

## 🔐 Optional Development Packages

The following commands are **optional** and only needed if you want to enable specific features.

### Laravel Breeze (API authentication)

```bash
# docker exec -it laravel_app composer require laravel/breeze --dev
# docker exec -it laravel_app php artisan breeze:install api
```

### Redis client (Predis)

```bash
# docker exec -it laravel_app composer require predis/predis
```

> Uncomment and run these commands only if your project requires authentication scaffolding or Redis support.

---

## 🗄️ Database Setup

### Run migrations

```bash
docker exec -it laravel_app php artisan migrate
```

### Seed the database

```bash
docker exec -it laravel_app php artisan db:seed
```

---

## 🧪 Running Tests

### Run all tests

```bash
docker exec -it laravel_app php artisan test
```

### Run a specific test

```bash
docker exec -it laravel_app php artisan test --filter=CreateOrderActionTest
```

---

## 🛠️ Common Commands

Stop containers:

```bash
docker compose down
```

View running containers:

```bash
docker compose ps
```

View logs:

```bash
docker compose logs -f
```

---

## 📌 Notes

-   The main Laravel container is assumed to be named **`laravel_app`**.
-   All Artisan and Composer commands should be executed inside this container.
-   Environment variables should be configured via `.env` as usual for Laravel projects.

---

## 📄 License

This project is provided as-is for development and internal use.
