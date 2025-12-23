# PHP_Laravel12_Date_Filter_FromDate_To_ToDate

A comprehensive **Laravel 12** application demonstrating **date range filtering** functionality with a clean, responsive user interface. This project serves as a practical, real‑world example of implementing date‑based filtering combined with CRUD operations in Laravel.

---

## Project Overview

This project focuses on filtering database records using date ranges and optional status conditions. It is suitable for learning, interviews, and academic projects where date‑based reports or task management systems are required.

---

## Features

### Core Features

* Date range filtering (from date / to date)
* Multiple filter combinations:

  * From date only
  * To date only
  * From and to date
  * Date range with status filter
* Status filtering (Pending, In Progress, Completed)
* Full CRUD operations (Create, Read, Update, Delete)
* Pagination using Laravel paginator
* Server‑side form validation
* Database seeding with sample data

### UI / UX Features

* Clean and modern Bootstrap 5 interface
* Responsive layout for mobile and desktop
* Visual status indicators using color coding
* Date validation and input constraints
* Success and error notifications
* Confirmation dialog before delete operations

---

## Quick Start

### Prerequisites

* PHP 8.1 or higher
* Composer
* MySQL 5.7 or higher
* Git

---

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/laravel-date-filter.git
cd laravel-date-filter
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

```bash
cp .env.example .env
```

Edit the `.env` file and update database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_date_filter
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations and Seed Database

```bash
php artisan migrate --seed
```

### 6. Start Development Server

```bash
php artisan serve
```

Access the application at:

```
http://127.0.0.1:8000
```

---

## Project Structure

```
laravel-date-filter/
├── app/
│   ├── Http/Controllers/TaskController.php
│   ├── Models/Task.php
│   └── Providers/
├── database/
│   ├── migrations/
│   │   └── create_tasks_table.php
│   └── seeders/
│       └── TaskSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       └── tasks/
│           ├── index.blade.php
│           ├── create.blade.php
│           └── edit.blade.php
├── routes/
│   └── web.php
├── public/
├── .env.example
├── composer.json
└── README.md
```

---

## Technical Implementation

### Date Filtering Logic

The date filtering logic is implemented in `TaskController.php` using conditional query building:

```php
public function index(Request $request)
{
    $query = Task::query();

    if ($request->filled('from_date') && $request->filled('to_date')) {
        $fromDate = Carbon::parse($request->from_date)->startOfDay();
        $toDate = Carbon::parse($request->to_date)->endOfDay();
        $query->whereBetween('task_date', [$fromDate, $toDate]);
    } elseif ($request->filled('from_date')) {
        $fromDate = Carbon::parse($request->from_date)->startOfDay();
        $query->where('task_date', '>=', $fromDate);
    } elseif ($request->filled('to_date')) {
        $toDate = Carbon::parse($request->to_date)->endOfDay();
        $query->where('task_date', '<=', $toDate);
    }
}
```

---

## Database Schema

### Tasks Table

```
id
title
description
task_date
status (pending, in_progress, completed)
created_at
updated_at
```

---

## Routes Configuration

Available routes in `routes/web.php`:

```
GET    /               Redirect to tasks index
GET    /tasks          List tasks with filters
GET    /tasks/create   Show create form
POST   /tasks          Store new task
GET    /tasks/{id}/edit Show edit form
PUT    /tasks/{id}     Update task
DELETE /tasks/{id}     Delete task
```

---

## Usage Examples

### Basic Filtering

* Filter by date range: select both from and to dates
* Filter from specific date only
* Filter until a specific date

### Combined Filtering

* Date range with status filter
* Single date with status filter
* Clear filters to view all records

### Sample Query Strings

```
/tasks?from_date=2024-01-01&to_date=2024-01-31
/tasks?from_date=2024-01-15
/tasks?to_date=2024-01-20
/tasks?status=completed&from_date=2024-01-01
```

---

## Database Seeding

The project includes seeded sample data:

* Past tasks (completed)
* Current date tasks (in progress)
* Future tasks (pending)
* Mixed status combinations

To reseed the database:

```bash
php artisan migrate:fresh --seed
```

---

## Testing the Application

### Date Filter Testing

* From date without to date
* To date without from date
* Both from and to dates
* Invalid date combinations

### CRUD Testing

* Create tasks with future dates
* Update existing task dates
* Delete tasks
* View task listings

### Edge Cases

* Empty result sets
* Single day filtering
* Cross‑month filtering
* Year boundary filtering

---

### Screenshot
## dashboard
<img width="1619" height="966" alt="image" src="https://github.com/user-attachments/assets/ec9b8a14-c4e3-4dd0-a85d-2f602af6b23d" />

## Add Task
<img width="1579" height="656" alt="image" src="https://github.com/user-attachments/assets/159d8ef3-3daa-444f-9cf3-636ef6fc423c" />
## 


