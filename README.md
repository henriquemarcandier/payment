# Multi-Currency Payment API

Laravel 12 application for managing multi-currency payment requests.

## Requirements

- PHP 8.2+
- MySQL / MariaDB
- Composer

## Setup

```bash
# Clone and enter the project
cd payment

# Install dependencies
composer install

# Configure environment
cp .env.example .env
# Edit .env with your database credentials

# Create database
mysql -u root -e "CREATE DATABASE payment CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations and seeders
php artisan migrate
php artisan db:seed

# Alternatively, you can import payment.sql (phpMyAdmin or mysql CLI)
# but running php artisan migrate is the recommended way.

# Start the server
php artisan serve
```

## API Endpoints

### Authentication

| Method | Endpoint         | Description        |
|--------|------------------|--------------------|
| POST   | `/api/register`  | Register a new user |
| POST   | `/api/login`     | Login               |
| POST   | `/api/logout`    | Logout (auth)       |
| GET    | `/api/user`      | Get current user    |

### Payment Requests

| Method | Endpoint                              | Description               |
|--------|---------------------------------------|---------------------------|
| GET    | `/api/payment-requests`               | List requests (auth)      |
| POST   | `/api/payment-requests`               | Create request (auth)     |
| GET    | `/api/payment-requests/{id}`          | Get request details       |
| PUT    | `/api/payment-requests/{id}`          | Approve/reject (finance)  |

### Examples

```bash
# Register
curl -X POST http://localhost/payment/public/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John","email":"john@test.com","password":"password123"}'

# Login
curl -X POST http://localhost/payment/public/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@test.com","password":"password123"}'

# Create payment request (use token from login)
curl -X POST http://localhost/payment/public/api/payment-requests \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"amount":100,"currency":"USD","description":"Office supplies"}'

# List payment requests
curl http://localhost/payment/public/api/payment-requests \
  -H "Authorization: Bearer TOKEN"

# Approve/reject (finance role only)
curl -X PUT http://localhost/payment/public/api/payment-requests/1 \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"status":"approved"}'
```

## Scheduled Tasks

Expire pending requests older than 48 hours:
```bash
php artisan payments:expire
```

Add to crontab:
```
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

## Seeded Users

| Name               | Email                  | Role    | Currency |
|--------------------|------------------------|---------|----------|
| Ana Silva          | ana@empresa.com        | employee| EUR      |
| John Smith         | john@empresa.com       | employee| GBP      |
| Maria Garcia       | maria@empresa.com      | employee| EUR      |
| Takashi Yamamoto   | takashi@empresa.com    | employee| JPY      |
| Sarah Johnson      | sarah@empresa.com      | employee| USD      |
| Carlos Mendes      | carlos@empresa.com     | employee| BRL      |
| Finance Team       | finance@empresa.com    | finance | EUR      |

All users password: `password`

## Web Access

Open in your browser:

- **Login page:** `http://localhost/payment/public/` or `http://localhost/payment/public/login`
- **Dashboard (after login):** `http://localhost/payment/public/dashboard`

On the dashboard you'll find the **Currency Converter** — select a source and target currency to see the live exchange rate.

## Tests

```bash
php artisan test
```