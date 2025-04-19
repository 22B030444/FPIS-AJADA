# Dorm Management System (DMS)

A web‑based application to streamline student housing operations: from room bookings and maintenance requests to payments, a peer‑to‑peer marketplace and campus news.

---

## Team Members

| Student Name             | Student ID  |
|--------------------------|-------------|
| Oryngaly Dauir           | 22B030441   |
| Suleimenova Zhasmin      | 22B030444   |
| Taimas Ayazhan           | 22B030447   |
| Taubaev Azamat           | 22B030450   |
| Tokanova Ayazhan         | 22B030452   |


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

Designed with Laravel (Blade), Tailwind CSS & Bootstrap, it’s responsive and easily deployable.

---

## Table of Contents

1. [Tech Stack](#tech-stack)
2. [Installation & Setup](#installation--setup)
3. [Running the Application](#running-the-application)
4. [Database & Seeding](#database--seeding)
5. [Available Features](#available-features)
6. [API & Routes](#api--routes)
7. [Testing](#testing)
8. [Contributing](#contributing)
9. [License](#license)

---

## Tech Stack

- **Backend**: PHP 8+, [Laravel 10](https://laravel.com/)
- **Templating**: Blade, Tailwind CSS, Bootstrap 5
- **Database**: MySQL (or SQLite for local dev)
- **Storage**: Laravel Filesystem (local / public)
- **Authentication**: Laravel Sanctum / built‑in Auth
- **Notifications**: Mail (SMTP), in‑app toasts
- **Containerization (future)**: Docker, AWS ECS

---

## Installation & Setup

1. **Clone the repository**  
   ```bash
   git clone https://github.com/your‑org/dorm-management-system.git
   cd dorm-management-system
   ```

2. **Install PHP dependencies**  
   ```bash
   composer install
   ```

3. **Configure environment**  
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```  
   Edit `.env` to set your database credentials, e.g.:  
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=dms
   DB_USERNAME=root
   DB_PASSWORD=secret
   ```

   > **SQLite option**:  
   > ```bash
   > touch database/database.sqlite
   > ```
   > then in `.env`:  
   > `DB_CONNECTION=sqlite`  
   > `DB_DATABASE=/full/path/to/database/database.sqlite`

4. **Link storage**  
   ```bash
   php artisan storage:link
   ```

5. **Run migrations & seeders**  
   ```bash
   php artisan migrate --seed
   ```

---

## Running the Application

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` in your browser.

---

## Database & Seeding

We include seeders for:

- **Users**: Admin, Manager, Employee, Student
- **News**: Three sample announcements with images
- **(Optional)**: Buildings, Rooms, Demo bookings

To run:

```bash
php artisan db:seed
```  

---

## Available Features

### 1. Authentication & Roles  
- Students, Managers, Employees, Admins  
- Laravel Auth + role middleware

### 2. Room Management  
- Students apply for rooms (building → floor → room)  
- Managers approve or reject bookings

### 3. Maintenance Requests  
- Students file repair requests (electric, plumbing, other)  
- Employees view, update status (in_review → accepted → completed)

### 4. Payments Dashboard  
- View upcoming dues and payment status

### 5. Marketplace  
- Post & browse second‑hand listings within dormitory

### 6. News & Notifications  
- Admins publish campus news with optional image  
- In‑app modals for reading full articles

### 7. Physical Education Booking  
- Students sign up for sports classes  
- Track make‑up sessions if missed

---

## API & Routes

| Method   | URI                                         | Action                                      |
|----------|---------------------------------------------|---------------------------------------------|
| **Auth** | `/login`, `/register`, `/logout`            | User authentication                         |
| **News** | `GET /news`, `POST /admin/news`, `PUT /admin/news/{id}`, `DELETE /admin/news/{id}` | CRUD for announcements |
| **Booking** | `GET /bookings`, `POST /booking`, `PUT /booking/{id}`, `DELETE /booking/{id}` | Room applications |
| **Request** | `GET /requests`, `POST /request`, `PUT /request/{id}`, `DELETE /request/{id}` | Maintenance tickets |
| **Marketplace** | `GET /market`, `POST /market/listing` | Buy/sell listings |
| **Sports** | `GET /sports`, `POST /sports/book`, `DELETE /sports/book/{id}` | PE class scheduling |
| **Users** | `GET /admin/users`, `POST /admin/users`, `PUT /admin/users/{id}`, `DELETE /admin/users/{id}` | Admin user management |

> Use `php artisan route:list` for a full list.

---

## Testing

Run PHPUnit tests:

```bash
php artisan test
```

This will execute unit & feature tests (e.g., `RepairRequestTest`).

---

## Contributing

1. Fork the repo  
2. Create a feature branch (`git checkout -b feature/awesome`)  
3. Commit your changes (`git commit -m 'Add awesome feature'`)  
4. Push (`git push origin feature/awesome`)  
5. Open a Pull Request

---

## License

This project is licensed under the [MIT License](LICENSE).

