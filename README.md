# IT Ticketing System Documentation

## 1. Project Overview

IT Ticketing System is a web-based application designed to help manage and track internal IT support requests. This system allows users to submit issues or requests, while IT Staff and Supervisors can monitor, manage, and update ticket progress efficiently.

The application provides a centralized platform for handling IT support workflows, improving communication between users and the IT team, and making ticket management more organized.

---

## 2. Technologies Used

The project was developed using the following technologies:

### Backend

* **Laravel 12**
  PHP framework used for building the application logic, routing, authentication, and backend functionality.

* **PHP 8.2**
  Programming language used to run the Laravel application.

### Frontend

* **Blade Template Engine**
  Laravel templating system for creating dynamic web pages.

* **Tailwind CSS**
  Utility-first CSS framework used for interface styling.

* **Vite**
  Frontend build tool used for compiling CSS and JavaScript assets.

### Database

* **SQLite**
  Lightweight database used for storing application data.

### Tools

* **Composer**
  Dependency manager for PHP packages.

* **Git & GitHub**
  Version control system used for project management.

---

## 3. Features Implemented

### User Features

* User authentication (Login)
* Create new support tickets
* View submitted tickets
* Track ticket status

### IT Staff Features

* View all incoming tickets
* Update ticket status
* Manage ticket progress

### Supervisor Features

* Monitor ticket activities
* Review ticket management process
* Assign tickets to responsible persons
* Monitor ticket progress


### Ticket Management

The system provides complete ticket management functionality:

* Add tickets
* Edit tickets
* Update ticket status
* Delete tickets
* View ticket list

### Ticket Information Fields

Each ticket displays:

* Ticket Title
* Issue Category
* Priority
* Status
* Assigned Person
* Created Date

### Status Management

Available ticket status options:

* Open
* In Progress
* Resolved
* Closed

### Dashboard Features

The dashboard provides ticket statistics:

* Total Tickets
* Open Tickets
* In Progress Tickets
* Closed Tickets
* High Priority Tickets

### Additional Interface Features

* Responsive layout
* Clean information hierarchy
* Easy-to-read dashboard interface

### Bonus Features Implemented

* Search and filter tickets
* Status color indicators
* Sorting tickets by status, priority, and created date

---

## 4. Setup Instructions

### Requirements

Before running the project, make sure the environment has:

* PHP >= 8.2
* Composer
* SQLite
* Node.js & npm (only for building frontend assets)

---

### Installation Steps

1. Clone the repository:

git clone https://github.com/DinaCahyoWibowo/Ticketing

2. Enter the project directory:

cd ticketing

3. Install PHP dependencies:

composer install

4. Create environment configuration:

cp .env.example .env


5. Generate application key:

php artisan key:generate

6. Configure database in `.env`:

DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite

7. Create SQLite database file:

touch database/database.sqlite

8. Run database migration:

php artisan migrate

9. Install frontend dependencies:

npm install

10. Build frontend assets:

npm run build

11. Start the application:

php artisan serve

The application can be accessed through:

```
http://127.0.0.1:8000
```

---

## Demo Account

| Email                                   | Role       |
| --------------------------------------- | ---------- |
| [user@gmail.com](mailto:user@gmail.com) | User       |
| [budi@gmail.com](mailto:budi@gmail.com) | IT Staff   |
| [andi@gmail.com](mailto:andi@gmail.com) | IT Staff   |
| [spv@gmail.com](mailto:spv@gmail.com)   | Supervisor |

Password:

```
password
```
