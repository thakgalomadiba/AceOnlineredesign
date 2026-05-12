Ace Online — Full-Stack E-Commerce Platform
A production-grade e-commerce platform built with PHP, MySQL, HTML, CSS and vanilla JavaScript. Features a complete shopping experience for customers and a full management dashboard for administrators.

🚀 Live Demo

Coming soon — deployment in progress


✨ Features
Customer Side

Browse products by category and subcategory
Featured products on homepage
Full shopping cart (add, update, remove items)
Secure checkout and order placement
Order history and tracking
Account registration and login

Admin Dashboard

Product management — add, edit, delete products with images
Category and subcategory management
Order management — view and update order statuses
Inventory tracking with stock control
Customer account management
Separate admin and customer views

Security

Password hashing with password_hash() and password_verify()
Prepared statements throughout — no SQL injection vulnerabilities
XSS prevention using htmlspecialchars() on all output
Session regeneration on login — prevents session fixation attacks
Role-based access control — admins and customers see different views


🛠️ Tech Stack
LayerTechnologyFrontendHTML, CSS, Vanilla JavaScriptBackendPHPDatabaseMySQLServerApache (XAMPP)

🗄️ Database Schema
Key tables:

customers — user accounts with role-based access
products — product listings with slugs, brands, and featured flags
product_images — multiple images per product
categories / subcategories — hierarchical product organisation
cart / cart_items — persistent shopping cart
orders / order_items — order tracking with unique order numbers
addresses — customer delivery addresses


⚙️ Setup & Installation
Requirements

PHP 7.4+
MySQL 5.7+
Apache (XAMPP recommended)

Steps

Clone the repository

bashgit clone https://github.com/thakgalomadiba/AceOnlineredesign.git
cd AceOnlineredesign

Import the database


Open phpMyAdmin or MySQL Workbench
Create a new database called ace_online
Import database/ace_online.sql


Configure the database connection


Open config/db.php
Update with your database credentials:

php$host = 'localhost';
$dbname = 'ace_online';
$username = 'your_username';
$password = 'your_password';

Run the project


Place the project folder in your htdocs directory
Start Apache and MySQL in XAMPP
Visit http://localhost/AceOnlineredesign

Default Admin Account
Email:    admin@aceonline.com
Password: admin123

Change these immediately after setup


📁 Project Structure
AceOnlineredesign/
├── admin/                  # Admin dashboard pages
│   ├── products.php
│   ├── orders.php
│   ├── categories.php
│   └── customers.php
├── api/                    # Backend logic
├── config/
│   └── db.php              # Database connection
├── public/
│   └── partials/           # Reusable UI components (header, footer, nav)
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── database/
│   └── ace_online.sql      # Full database schema
├── index.php               # Homepage
├── login.php
├── register.php
├── cart.php
├── checkout.php
└── orders.php

🔒 Security Highlights
This project implements several security best practices:

SQL Injection Prevention — All database queries use prepared statements with bound parameters
XSS Prevention — All user-generated content is sanitised with htmlspecialchars() before output
Secure Password Storage — Passwords are hashed using PHP's password_hash() with bcrypt
Session Security — session_regenerate_id(true) called on every login
Role-Based Access — Admin pages check session role before rendering


📸 Screenshots

Coming soon


🗺️ Roadmap

 Deploy to live hosting
 Stripe payment integration
 Email order confirmations
 Product search and filtering
 Mobile responsive improvements


👨‍💻 Author
Thakgalo Makitla Madiba

GitHub: @thakgalomadiba
LinkedIn: Thakgalo Madiba
Email: Thakgalomadiba08@gmail.com
