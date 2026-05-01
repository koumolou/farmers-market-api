# Farmers Market API

> REST API backend for an agricultural marketplace platform in Côte d'Ivoire. Built with Laravel 12 and PHP 8.2.

## Live API

https://web-production-09f71f.up.railway.app/api

## Tech Stack

- Laravel 12 + PHP 8.2
- MySQL (Railway)
- Laravel Sanctum — token-based authentication
- Service layer architecture: Controller → Service → Repository → Model
- Role-based access control: admin / supervisor / operator

---

## Local Setup

### Requirements

- PHP 8.2+
- Composer
- MySQL

### Steps

```bash
git clone https://github.com/koumolou/farmers-market-api.git
cd farmers-market-api
composer install
cp .env.example .env
php artisan key:generate
```

Configure your `.env` database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=farmers_market
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then run:

```bash
php artisan migrate:fresh --seed
php artisan serve
```

API is now available at `http://localhost:8000/api`

---

## Docker Setup

```bash
docker-compose up --build
```

API available at `http://localhost:8000/api`

## Demo Credentials

| Role       | Email                   | Password |
| ---------- | ----------------------- | -------- |
| Admin      | admin@farmarket.ci      | password |
| Supervisor | supervisor@farmarket.ci | password |
| Operator   | operator@farmarket.ci   | password |

---

## Role Permissions

| Action                       | Admin | Supervisor | Operator |
| ---------------------------- | ----- | ---------- | -------- |
| Create supervisors           | ✅    | ❌         | ❌       |
| Create operators             | ✅    | ✅         | ❌       |
| Manage categories & products | ✅    | ✅         | ❌       |
| Create & lookup farmers      | ❌    | ❌         | ✅       |
| Place orders                 | ❌    | ❌         | ✅       |
| Record repayments            | ❌    | ❌         | ✅       |

---

## API Endpoints

### Authentication

POST /api/login
POST /api/logout
GET /api/me

### User Management

GET /api/supervisors
POST /api/supervisors (admin only)
PUT /api/supervisors/{id} (admin only)
DELETE /api/supervisors/{id} (admin only)
GET /api/operators
POST /api/operators (admin + supervisor)
PUT /api/operators/{id} (admin + supervisor)
DELETE /api/operators/{id} (admin + supervisor)

### Categories & Products

GET /api/categories
POST /api/categories (admin + supervisor)
PUT /api/categories/{id} (admin + supervisor)
DELETE /api/categories/{id} (admin + supervisor)
GET /api/products
GET /api/products?category_id={id}
POST /api/products (admin + supervisor)
PUT /api/products/{id} (admin + supervisor)
DELETE /api/products/{id} (admin + supervisor)

### Farmers

GET /api/farmers
GET /api/farmers/{id}
GET /api/farmers/search?query={identifier_or_phone}
POST /api/farmers (operator only)
PUT /api/farmers/{id} (operator only)

### Transactions

POST /api/transactions/checkout (operator only)

### Repayments

POST /api/repayments (operator only)
GET /api/farmers/{id}/repayments (operator only)

---

## Key Business Rules

| Rule            | Description                                                                                       |
| --------------- | ------------------------------------------------------------------------------------------------- |
| Credit interest | `grand_total = subtotal × (1 + interest_rate)`. Rate configurable in settings table (default 30%) |
| Credit limit    | Transaction blocked if new debt would exceed farmer's credit limit                                |
| FIFO repayment  | Oldest debt settled first. Partial repayment supported                                            |
| Commodity rate  | Configurable kg → FCFA conversion (default 1kg = 1,000 FCFA)                                      |
| Debt currency   | All debts recorded in FCFA regardless of repayment method                                         |

---

## Architecture

app/
├── Http/
│ ├── Controllers/Api/ # Thin controllers — return ApiResponse only
│ ├── Requests/ # Form Request validation per endpoint
│ └── Responses/ # ApiResponse helper (success/error)
├── Services/ # Business logic layer
├── Repositories/ # Database access layer
│ └── Interfaces/ # Repository contracts
└── Models/ # Eloquent models with relationships

---

## API Documentation

Import `doc/farmers_market_postman.json` into Postman.

The collection includes:

- All endpoints with example requests and responses
- Auto-save tokens after login via test scripts
- Role-specific tokens (admin_token, supervisor_token, operator_token)
- Error response examples for each endpoint

---

## Database Schema

| Table             | Description                                               |
| ----------------- | --------------------------------------------------------- |
| users             | Admin, supervisor, operator accounts with role hierarchy  |
| categories        | Nested product categories (parent_id self-reference)      |
| products          | Agricultural products with FCFA price                     |
| farmers           | Farmer profiles with credit limits                        |
| transactions      | Cash and credit orders                                    |
| transaction_items | Line items per transaction                                |
| debts             | Credit transaction debts in FCFA                          |
| repayments        | Commodity repayment records                               |
| repayment_debt    | Pivot — tracks which debts each repayment settled         |
| settings          | Configurable rates (interest_rate, commodity_rate_per_kg) |
