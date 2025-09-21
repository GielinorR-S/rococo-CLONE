-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS rococo_db;
USE rococo_db;

-- Bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venue VARCHAR(50) DEFAULT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    guests INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    special_requests TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- If the table already exists without venue column, run this manually:
-- ALTER TABLE bookings ADD COLUMN venue VARCHAR(50) NULL AFTER id;

-- Contact entries table
CREATE TABLE IF NOT EXISTS contact_entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Subscribers table
CREATE TABLE IF NOT EXISTS subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================================
-- Shop / Products schema (basic for multi-location ordering)
-- Locations handled logically via location_slug column to keep
-- schema simple without separate location table (can be added later)
-- ==========================================================

-- Product categories (per location)
CREATE TABLE IF NOT EXISTS product_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location_slug VARCHAR(40) NOT NULL, -- e.g. 'stkilda','hawthorn','pointcook'
    name VARCHAR(120) NOT NULL,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY idx_location (location_slug)
);

-- Products
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(160) NOT NULL,
    description TEXT,
    price DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    image_url VARCHAR(255),
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES product_categories(id) ON DELETE CASCADE,
    KEY idx_active (is_active)
);

-- Optional product images table (future use / gallery) - placeholder
CREATE TABLE IF NOT EXISTS product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Seed sample categories & products only if tables are empty (pseudo-guard comments for manual runs)
-- Run these INSERTs only once manually if needed. Comment out after initial load.
INSERT INTO product_categories (location_slug, name, display_order)
SELECT * FROM (
    SELECT 'stkilda','Antipasti',1 UNION ALL
    SELECT 'stkilda','Pizza',2 UNION ALL
    SELECT 'stkilda','Pasta',3 UNION ALL
    SELECT 'hawthorn','Pizza',1 UNION ALL
    SELECT 'hawthorn','Mains',2 UNION ALL
    SELECT 'pointcook','Pizza',1 UNION ALL
    SELECT 'pointcook','Dessert',2
) AS tmp
WHERE NOT EXISTS(SELECT 1 FROM product_categories LIMIT 1);

INSERT INTO products (category_id, name, description, price, image_url)
SELECT c.id, p.name, p.description, p.price, p.image_url
FROM product_categories c
JOIN (
    SELECT 'Antipasti' cat,'Garlic Focaccia' name,'Wood fired garlic, rosemary & sea salt.' description, 8.50 price, 'https://images.unsplash.com/photo-1604908176997-125d4d978f74?auto=format&fit=crop&w=800&q=60' image_url UNION ALL
    SELECT 'Pizza','Margherita','San Marzano tomato, fior di latte, basil.', 18.00,'https://images.unsplash.com/photo-1601924582971-b7eabf6d5f5d?auto=format&fit=crop&w=800&q=60' UNION ALL
    SELECT 'Pizza','Diavola','Hot salami, mozzarella, chilli oil.', 22.00,'https://images.unsplash.com/photo-1594007654729-407eedc4be65?auto=format&fit=crop&w=800&q=60' UNION ALL
    SELECT 'Pasta','Spaghetti Carbonara','Guanciale, pecorino, egg yolk emulsion.', 24.00,'https://images.unsplash.com/photo-1617196034796-73dfa7f4c9d0?auto=format&fit=crop&w=800&q=60' UNION ALL
    SELECT 'Mains','Veal Parmigiana','Crumbed veal, Napoli, mozzarella, fries.', 29.00,'https://images.unsplash.com/photo-1600891964092-4316c288032e?auto=format&fit=crop&w=800&q=60' UNION ALL
    SELECT 'Dessert','Tiramisu','Espresso soaked savoiardi, mascarpone.', 12.00,'https://images.unsplash.com/photo-1606755962773-d324e0a13086?auto=format&fit=crop&w=800&q=60'
) p ON p.cat = c.name
WHERE NOT EXISTS(SELECT 1 FROM products LIMIT 1);
