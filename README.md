# E-Commerce Web Application

An e-commerce web application built using Laravel and Blade templates.
This project was developed to practice full-stack web development,
including authentication, authorization, middleware usage, database
management, and complex CRUD operations.

---

## Features

### User Features
- User registration and login
- Social login support
- Browse products
- Add products to cart
- Place orders
- View order history
- Edit user profile

### Admin Features
- Admin authentication and authorization
- Product management (create, update, delete)
- Order management
- Payment management
- Edit admin profile

---

## Tech Stack

- Frontend: HTML, CSS, JavaScript, jQuery, Bootstrap
- Backend: Laravel (Blade templating engine)
- Database: MySQL
- Authentication: Laravel Auth + Social Login
- Version Control: Git

## What I learnt
- Implementing authentication and authorization in Laravel
- Using middleware to protect routes and manage access control
- Structuring a full-stack Laravel application
- Working with relational databases using MySQL
- Handling complex CRUD operations
- Managing multiple user roles (admin and user)

## Future Improvements
- Use AJAX for certain actions to reduce full page reloads
- Improve the payment system to make it more realistic
- Enhance overall UI/UX
- Add order tracking and notification features

---

## Installation

1. Clone the repository
```bash
git clone https://github.com/ZweYaung/Laravel-e-commerce-project.git
```
2. Move into the project directory
```bash
cd Laravel-e-commerce-project
```
3. Install PHP dependencies
```bash
composer install
npm install
```
4. Create a .env file
```bash
cp .env.example .env
```
5.Generate the application key
```bash
php artisan key:generate
```

6. Configure the database in the .env file
```bash
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations
```bash
php artisan migrate
```

8. Start the development server
```bash
php artisan serve
```

9. Open your browser and visit <br>
http://127.0.0.1:8000
