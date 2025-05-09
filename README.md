# Dorm Management System (DMS)

A web‑based application to streamline student housing operations: from room bookings and maintenance requests to payments, a peer‑to‑peer marketplace and campus news.

---

## Team Members

| Student Name             | Student ID  |
|--------------------------|-------------|
| Oryngaly Dauir           | 22B030576   |
| Suleimenova Zhasmin      | 22B030444   |
| Taimas Ayazhan           | 22B030447   |
| Taubaev Azamat           | 22B030450   |
| Tokanova Ayazhan         | 21B030931   |


---

## Description

The **Dorm Management System** helps dormitory administrators, managers and students to:

- **Authenticate** users and enforce role‑based access (student / manager / employee / admin)
- **Allocate rooms** and process housing applications
- **Submit & track maintenance requests** (electric, plumbing, etc.)
- **Handle payments** and view upcoming dues
- **Browse & post in a marketplace** for buying/selling between residents
- **Publish campus news** with images and announcements
- **Register for physical education classes** and manage make‑up sessions



---
## Table of Contents

- [Project Overview](#project-overview)  
- [Key Features](#key-features)  
- [Requirements](#requirements)  
- [Installation](#installation)  
- [Environment Setup](#environment-setup)  
- [Running the Project](#running-the-project)  
  - [With Docker / Sail](#with-docker--sail)  
  - [Without Docker](#without-docker)  
- [Database](#database)  
  - [Migrations & Seeders](#migrations--seeders)  
  - [Viewing Data](#viewing-data)  
- [Project Structure](#project-structure)  
- [Artisan Commands](#artisan-commands)  
- [Testing](#testing)  
- [Tips & Tricks](#tips--tricks)  
- [Support & Contact](#support--contact)

---

## Project Overview

The **Dorm Management System (DMS)** is a Laravel web application designed to manage dormitory buildings, rooms, students, staff, and a campus‑wide marketplace. It uses [Laravel Sail](https://laravel.com/docs/sail) and Docker for seamless local development and deployment.

---

## Requirements

- Docker & Docker Desktop (WSL2 integration on Windows)  
- Git  
- PHP ≥ 8.0  
- Composer  

---

## Installation

1. **Clone the repository**  
   ```bash
   git clone https://github.com/your-org/dorm-management-system.git
   cd dorm-management-system
   ```

2. **Install PHP dependencies**  
   ```bash
   composer install
   ```

3. *(Optional)* **Install frontend dependencies**  
   ```bash
   npm install
   ```

4. **Copy environment file & generate key**  
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

---

## Environment Setup

Edit your `.env` file to configure your environment:

```dotenv
APP_NAME="DMS"
APP_ENV=local
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
FORWARD_DB_PORT=5432

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

CACHE_DRIVER=database
SESSION_DRIVER=database
```

> **Tip**: On Windows, use WSL2 with Docker Desktop and enable integration for your Ubuntu distro.

---

## Running the Project

### With Docker / Sail

1. Ensure **Docker Desktop** is running.  
2. From the project root, start all services:
   ```bash
   ./vendor/bin/sail up -d
   ```
3. Run migrations and seed data:
   ```bash
   ./vendor/bin/sail artisan migrate:fresh --seed
   ```
4. Open your browser at `http://localhost`.

### Without Docker

1. Configure your local PHP server (Valet, Homestead, XAMPP, etc.).  
2. Ensure **PostgreSQL** and **Redis** are running locally.  
3. Run:
   ```bash
   php artisan migrate --force
   php artisan db:seed
   php artisan serve
   ```
4. Browse to `http://127.0.0.1:8000`.

---

## Database

### Migrations & Seeders

- **Run migrations**:
  ```bash
  ./vendor/bin/sail artisan migrate
  ```
- **Reset & seed**:
  ```bash
  ./vendor/bin/sail artisan migrate:fresh --seed
  ```

### Viewing Data

Use **psql** or a GUI client (DataGrip, DBeaver):

```bash
./vendor/bin/sail exec pgsql psql -U sail -d laravel
```

Then, for example:

```sql
SELECT * FROM students;
```

---

## Project Structure

```
├── app/
│   ├── Http/
│   ├── Models/
│   ├── Services/         
│   └── ...
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── docker-compose.yml    
├── .env
├── README.md
└── vendor/
```

---

## Artisan Commands

- `php artisan migrate` — run migrations  
- `php artisan db:seed` — run seeders  
- `php artisan route:list` — list routes  
- `php artisan tinker` — interactive shell  
- `php artisan config:clear` — clear config cache  

---

## Testing

If tests are available:

```bash
./vendor/bin/sail artisan test
```

---

## Tips & Tricks

- **Alias Sail**  
  ```bash
  alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
  ```
  Then use `sail up -d` instead of the full path.

- **Enable Xdebug**  
  Set `SAIL_XDEBUG_MODE=debug` in your `.env`.

- **View logs**  
  ```bash
  sail logs laravel.test
  sail logs pgsql
  ```

---

# API Documentation

## Authentication
- **POST /** - Login to the system
- **POST /logout** - Logout from the system (requires authentication)

## Admin Panel
*Requires authentication and admin role*

### User Management
- **GET /admin/dashboard/users/create** - Display user creation form
- **POST /admin/dashboard/users** - Create new user
- **GET /admin/dashboard/users** - List all users
- **DELETE /admin/dashboard/users/{id}** - Delete user
- **GET /admin/users/{id}/json** - Get user information in JSON format

## Student Panel
*Requires authentication and student role*

### Profile and Personal Account
- **GET /student/dashboard** - Student dashboard
- **GET /student/personal** - Personal account
- **POST /student/personal/profile/update** - Update profile
- **PATCH /student/personal/profile/update** - Update profile details

### Marketplace
- **GET /student/ads** - View advertisements
- **POST /student/ads** - Create advertisement
- **PUT /student/ads/{ad}** - Update advertisement
- **DELETE /student/ads/{ad}** - Delete advertisement

### Room Booking
- **GET /student/personal/floors/{building_id}** - Get list of floors in building
- **GET /student/personal/rooms/{building_id}/{floor}** - Get list of rooms
- **POST /student/personal/booking/store** - Create booking
- **POST /student/personal/booking/change-room** - Change room

### Payments
- **POST /payment/initiate** - Initialize payment
- **GET /payment/callback** - Payment system callback
- **GET /payment/status/{id}** - Check payment status

### Maintenance Requests
- **GET /personal/create-request** - Display request creation form
- **POST /personal** - Create request
- **GET /personal/requests** - List requests
- **GET /personal/requests/{id}** - View request details
- **PUT /personal/requests/{repairRequest}** - Update request
- **DELETE /personal/requests/{repairRequest}** - Delete request

## Employee Panel
*Requires authentication and employee role*

### Request Management
- **GET /employee/dashboard/requests** - List requests
- **GET /employee/dashboard/requests/{id}** - View request details
- **PUT /employee/dashboard/requests/{id}** - Update request status

## Common Endpoints
- **POST /language-switch** - Switch language
- **GET /notifications** - Get notifications
- **POST /notifications/{id}/read** - Mark notification as read



## Dependencies & Versions

- PHP: `8.1.x`  
- Laravel: `10.x`  
- PostgreSQL: `17.x`  
- Redis: `7.x`  
- Composer: `2.x`  

---

## Configuration & Environment Variables

| Key                | Type      | Default                     | Description                                    |
|--------------------|-----------|-----------------------------|------------------------------------------------|
| `DB_CONNECTION`    | string    | `pgsql`                     | Database driver                                |
| `DB_HOST`          | string    | `pgsql`                     | DB host (service name in Docker)               |
| `DB_PORT`          | integer   | `5432`                      | DB port                                        |
| `DB_DATABASE`      | string    | `laravel`                   | Database name                                  |
| `DB_USERNAME`      | string    | `sail`                      | DB user                                        |
| `DB_PASSWORD`      | string    | `password`                  | DB password                                    |
| `REDIS_HOST`       | string    | `redis`                     | Redis host                                     |
| `CACHE_DRIVER`     | string    | `database`                  | Cache driver                                   |
| `QUEUE_CONNECTION` | string    | `database`                  | Queue driver                                   |
| `MAIL_MAILER`      | string    | `log`                       | Mail transport (use `smtp` in production)      |


---

## Architecture Overview

1. **Web Layer**: Nginx → PHP-FPM (Laravel Sail)  
2. **Database**: PostgreSQL container  
3. **Cache & Queue**: Redis container  
4. **Job Workers**: `php artisan queue:work`  
5. **Mail**: MailHog in dev, SMTP in prod  

---

## Contribution Guide

1. Fork the repo  
2. Create a feature branch (`git checkout -b feature/XYZ`)  
3. Commit changes with clear messages  
4. Push and open a Pull Request  
5. Someone will review and merge  

Please adhere to PSR‑12 and write unit tests for new features.

---

## Troubleshooting & FAQ

- **“Host pgsql not found”** — run `sail up -d` after editing `.env`.  
- **Permission denied on sockets** — add your user to the `docker` group or prefix with `sudo`.  
- **Migrations failing** — ensure containers are healthy: `sail ps`, then re-run `sail artisan migrate:fresh`.  
- **Mail not sending in dev** — check `MAIL_MAILER=log` or use MailHog.  

---

## Changelog

### v1.0.0 (2025‑04‑23)
- Initial release: user auth, room booking, marketplace, notifications  

### v1.1.0 (2025‑05‑10)
- Added Redis queues for email & notifications  
- Improved test coverage  

---

## Security Considerations

- Never commit `.env` to version control  
- Use strong, unique passwords for DB and services  
- Keep dependencies up to date (`composer audit`)  
- Rate‑limit sensitive endpoints (login, bookings)  

---
