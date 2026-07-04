# Employee Management System — Laravel Technical Test

A mini Employee Management System built with Laravel, demonstrating CRUD operations, role-based access control, file upload handling, and clean architecture.

## Tech Stack

- **Backend:** Laravel 13
- **Auth:** Laravel Breeze (Blade)
- **Frontend:** Bootstrap 5
- **Database:** MySQL

## Features

- Role-based access control (Admin / Employee) using custom middleware
- Employee CRUD — create, edit, and view own profile
- Multi-tab profile form (Basic Information / Education & Documents)
- Dynamic add/remove for multiple education entries (one-to-many relationship)
- File upload handling — profile photo and education certificates
- Admin dashboard — view all employees and individual employee profiles

## Database Structure

| Table | Purpose |
|---|---|
| `roles` | Stores "admin" and "employee" roles |
| `users` | Login/auth data (name, email, password, role_id) |
| `employee_profiles` | Employee-specific details (address, DOB, phone, photo, etc.) |
| `educations` | Multiple education/certificate entries per employee |

**Relationships**
- `Role hasMany Users` / `User belongsTo Role`
- `User hasOne EmployeeProfile` / `EmployeeProfile belongsTo User`
- `User hasMany Educations` / `Education belongsTo User`

## Setup Instructions

1. **Clone and install dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Update `.env` with your database credentials:
   ```
   DB_DATABASE=employee-management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Run migrations and seed roles**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Create storage symlink** (required for uploaded files to be accessible)
   ```bash
   php artisan storage:link
   ```

5. **Build frontend assets**
   ```bash
   npm run dev
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```
   Visit: `http://127.0.0.1:8000`

## Test Credentials

**Admin Account**
```
Email: admin@gmail.com
Password: password123
```

**Employee Account**
Register a new account via `/register` — new signups are automatically assigned the "Employee" role.

## Access Control

| Role | Access |
|---|---|
| **Admin** | View dashboard, view all employees, view any employee's full profile |
| **Employee** | Create/edit/view own profile only |

Role checks are enforced via a custom `role` middleware (`app/Http/Middleware/CheckRole.php`), applied to route groups in `routes/web.php`.

## Key Routes

| Route | Method | Access | Purpose |
|---|---|---|---|
| `/employees/create` | GET/POST | Employee | Create profile |
| `/employees/edit` | GET/PATCH | Employee | Edit own profile |
| `/employees/profile` | GET | Employee | View own profile |
| `/admin/employees` | GET | Admin | List all employees |
| `/admin/employees/{id}` | GET | Admin | View a specific employee's profile |