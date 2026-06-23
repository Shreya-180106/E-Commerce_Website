CREATE DATABASE IF NOT EXISTS ecommerce_db;
USE ecommerce_db;

-- USERS TABLE
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- PRODUCTS TABLE
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CART TABLE
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- ORDERS TABLE
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ORDER ITEMS TABLE
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- SAMPLE PRODUCTS
INSERT INTO products (name, description, price, image, category) VALUES
('Wireless Headphones', 'High quality wireless headphones with noise cancellation.', 2499.00, 'assets/images/products/headphone.jpg', 'Electronics'),
('Smart Watch', 'Stylish smartwatch with health tracking features.', 3999.00, 'assets/images/products/smartwatch.jpg', 'Electronics'),
('Running Shoes', 'Comfortable running shoes for daily workouts.', 1999.00, 'assets/images/products/shoes.jpg', 'Footwear'),
('Backpack', 'Durable backpack suitable for travel and office use.', 1499.00, 'assets/images/products/backpack.jpg', 'Accessories'),
('Laptop Bag', 'Premium laptop bag with multiple compartments.', 1299.00, 'assets/images/products/laptopbag.jpg', 'Accessories'),
('T-Shirt', 'Casual cotton t-shirt for everyday wear.', 699.00, 'assets/images/products/tshirt.jpg', 'Clothing');