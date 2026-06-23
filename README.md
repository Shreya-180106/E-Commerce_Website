# E-Commerce Website (PHP + MySQL)

A simple full-stack **E-Commerce Website** built using **PHP, MySQL, HTML, CSS, and JavaScript**.
This project allows users to browse products, register/login, add products to cart, place orders, and provides an admin panel for managing products and orders.

---

## Features

### User Side

* Home page with featured products
* Product listing page
* Product details page
* User registration and login
* Add to cart
* View cart
* Checkout and place order

### Admin Side

* Admin dashboard
* Add product
* Edit product
* Delete product
* View all orders

---

## Tech Stack

* **Frontend:** HTML, CSS, JavaScript
* **Backend:** PHP
* **Database:** MySQL
* **Server Environment:** XAMPP / Apache

---

## Project Folder Structure

```bash
E-Commerce_Project/
│
├── index.php
├── products.php
├── product-details.php
├── cart.php
├── checkout.php
├── login.php
├── register.php
├── logout.php
│
├── includes/
│   ├── db.php
│   ├── header.php
│   └── footer.php
│
├── admin/
│   ├── dashboard.php
│   ├── add-product.php
│   ├── edit-product.php
│   ├── delete-product.php
│   └── orders.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── images/
│       └── products/
│
└── database/
    └── ecommerce.sql
```

---

## Database Setup

1. Open **XAMPP Control Panel**
2. Start **Apache** and **MySQL**
3. Open **phpMyAdmin**
4. Create/import the database using:

   * `database/ecommerce.sql`

Database name used in this project:

```sql
ecommerce_db
```

---

## How to Run the Project

1. Install **XAMPP**
2. Move the project folder to:

   ```bash
   C:\xampp\htdocs\E-Commerce_Project
   ```
3. Start **Apache** and **MySQL** from XAMPP
4. Import the SQL file into phpMyAdmin
5. Open the project in browser:

   ```bash
   http://localhost/E-Commerce_Project/
   ```

---

## Admin Pages

* Dashboard: `http://localhost/E-Commerce_Project/admin/dashboard.php`
* Add Product: `http://localhost/E-Commerce_Project/admin/add-product.php`
* Orders: `http://localhost/E-Commerce_Project/admin/orders.php`

---

## Future Improvements

* Admin authentication
* Product image upload
* Search and filter products
* Cart quantity update
* Order success page
* Payment gateway integration
* Better UI/UX

---

## Author

**Shreya Dubey**
