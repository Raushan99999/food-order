
CREATE DATABASE IF NOT EXISTS food_ordering_db;
USE food_ordering_db;

-- 1. Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Categories Table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

-- 3. Menu Items Table
CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80',
    is_available BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- 4. Orders Table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('Pending', 'Preparing', 'Out for Delivery', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    delivery_address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 5. Order Items Table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES menu_items(id) ON DELETE CASCADE
);

-- Seed Data: Insert Sample Admin and Menu Items
-- Default Admin: admin@food.com / Password: adminpassword
INSERT INTO users (full_name, email, password, phone, address, role) 
VALUES ('System Admin', 'admin@food.com', '$2y$10$8v/K7QkLd80P.14y3P/CxuR4J1w40E4A4P.Sg14y3P.Sg14y3P.Sg', '1234567890', 'HQ Address', 'admin');

INSERT INTO categories (name) VALUES ('Pizzas'), ('Burgers'), ('Beverages');

INSERT INTO menu_items (category_id, name, description, price, image) VALUES 
(1, 'Margherita Pizza', 'Classic delight with 100% real mozzarella cheese', 12.99, 'https://images.unsplash.com/photo-1604382354936-07c5d9983bd3?auto=format&fit=crop&w=600&q=80'),
(1, 'Pepperoni Pizza', 'Loaded with double pepperoni and extra cheese', 15.49, 'https://images.unsplash.com/photo-1628840042765-356cda07504e?auto=format&fit=crop&w=600&q=80'),
(2, 'Classic Cheeseburger', 'Juicy beef patty topped with cheddar, lettuce, and secret sauce', 8.99, 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=600&q=80'),
(3, 'Iced Cold Coffee', 'Rich espresso blended with chilled milk and chocolate syrup', 4.50, 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=600&q=80');
