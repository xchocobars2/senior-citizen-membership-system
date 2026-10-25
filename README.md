# Senior Citizen Membership Management System

A web-based membership management system built with **Laravel** and **Breeze (Blade)** for managing senior citizen membership records efficiently.

## Features

- **Role-Based Access Control**
  - Admin
  - User (Senior Citizen)

- **Admin Dashboard**
  - Membership statistics (Total, Active, Inactive, Pending)
  - Recent members list
  - Weather information with city search (OpenWeatherMap API)

- **Membership Management (CRUD)**
  - Create, Read, Update, Delete membership records
  - Search functionality

- **User Management**
  - Create and manage user accounts
  - Assign roles (Admin / User)
  - Protect admin pages from unauthorized access

- **Reports**
  - Filter members by status (Active, Inactive, Pending)

- **User Dashboard**
  - View personal membership information
  - Update limited profile details

- **Security**
  - Role-based middleware protection
  - Secure password hashing

## Tech Stack

- Laravel 11
- Laravel Breeze (Blade)
- Tailwind CSS
- SQLite / MySQL
- OpenWeatherMap API
- Vite

## Default Login Credentials

| Role  | Email               | Password  |
|-------|---------------------|-----------|
| Admin | admin@example.com   | ********* |
| User  | senior@example.com  | ********* |

## Installation

### Requirements
- PHP 8.2+
- Composer
- Node.js & npm
- Laragon / XAMPP / similar local server

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/senior-citizen-membership-system.git
   cd senior-citizen-membership-system