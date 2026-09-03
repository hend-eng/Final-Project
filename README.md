# SHOP.CO – E-Commerce Website

## 📌 Project Overview

SHOP.CO is a full-stack e-commerce website developed as a final project.
The website provides a complete online shopping experience, including product browsing, filtering, authentication, cart management, checkout, orders, and an admin dashboard.

The project was built using **HTML, CSS, JavaScript, PHP, MySQL, and Bootstrap**.

---

## 🚀 Features

### 👤 Customer Side

* User registration and login
* User authentication and logout
* Browse products
* Product filtering and pagination
* Product details page
* Browse products by categories and brands
* Shopping cart
* Checkout
* Order management
* User profile
* About page
* Contact page
* Team page
* Responsive design

### 🛠️ Admin Dashboard

* Admin authentication
* Dashboard overview
* Product management

  * Add products
  * Edit products
  * Delete products
  * View products
* Category management
* Brand management
* Client management
* Order management

---

## 💻 Technologies Used

* **HTML5** – Website structure
* **CSS3** – Styling and layout
* **Bootstrap** – Responsive layout and UI components
* **Flexbox** – Alignment and responsive positioning
* **JavaScript** – Client-side interactions
* **PHP** – Backend logic and server-side functionality
* **MySQL** – Database management
* **Git & GitHub** – Version control

---

## 📂 Project Structure

```text
Final-Project/
│
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   └── dashboard.css
│   ├── images/
│   └── js/
│       └── home.js
│
├── auth/
│   ├── login.php
│   ├── logout.php
│   └── signup.php
│
├── config/
│   ├── db.php
│   └── products.php
│
├── dasboard/
│   ├── brands/
│   ├── categories/
│   ├── clients/
│   ├── orders/
│   ├── products/
│   ├── dash-shared/
│   └── index.php
│
├── database/
│   └── ecommerce.sql
│
├── pages/
│   ├── about.php
│   ├── brands.php
│   ├── cart.php
│   ├── checkout.php
│   ├── contact.php
│   ├── orders.php
│   ├── product-details.php
│   ├── products.php
│   ├── profile.php
│   └── Team.php
│
├── shared/
│   ├── auth.php
│   ├── footer.php
│   └── header.php
│
└── index.php
```

---

## 🗄️ Database

The project uses **MySQL** as its database.

The database file is located at:

```text
database/ecommerce.sql
```

It contains the required database structure and data for the e-commerce system.

---

## ⚙️ How to Run the Project

### 1. Install a Local Server

Use a local development environment such as:

* XAMPP
* WAMP
* Laragon

### 2. Clone the Repository

```bash
git clone <repository-url>
```

### 3. Move the Project

Place the project inside your server's web directory.

For XAMPP:

```text
htdocs/Final-Project
```

### 4. Create the Database

Open **phpMyAdmin** and create/import the database using:

```text
database/ecommerce.sql
```

### 5. Configure the Database

Update the database connection inside:

```text
config/db.php
```

with your local MySQL credentials.

### 6. Run the Website

Start **Apache** and **MySQL** from XAMPP, then open:

```text
http://localhost/Final-Project/
```

---

## 🔐 Authentication

The project includes authentication functionality using PHP sessions.

Users can:

* Create an account
* Log in
* Log out
* Access protected pages
* View their profile
* View their orders

The admin dashboard also has authentication and authorization controls.

---

## 🛒 E-Commerce Flow

```text
Home
  ↓
Products
  ↓
Product Details
  ↓
Add to Cart
  ↓
Cart
  ↓
Checkout
  ↓
Order
  ↓
Orders / Profile
```

---

## 👨‍💼 Admin Flow

```text
Admin Login
     ↓
Dashboard
     ↓
 ┌──────────┬──────────┬──────────┬──────────┐
 Products   Categories   Brands    Clients
     ↓          ↓          ↓          ↓
   CRUD        CRUD       CRUD       View
     
     ↓
   Orders
```

---

## 🎨 UI & Layout

The frontend uses **Bootstrap** for responsive grid/layout components and reusable UI elements.

**CSS Flexbox** is also used for arranging and aligning elements such as:

* Navigation items
* Header sections
* Product cards
* Buttons
* Content sections
* Footer elements

Custom CSS is used to control the website's branding, spacing, typography, colors, and overall appearance.

---

## 📱 Responsive Design

The website is designed to work across different screen sizes using:

* Bootstrap responsive utilities
* CSS media queries
* Flexbox
* Responsive containers and layouts

---

## 📚 Academic Project

This project was developed as a **Full-Stack E-Commerce Final Project** to demonstrate practical knowledge of:

* Frontend development
* Backend development
* Database integration
* Authentication
* CRUD operations
* PHP sessions
* Responsive web design
* Git version control

---

## 👥 Team

The project was developed as a team-based academic project.

See the **Team page** inside the website for team members and responsibilities.
