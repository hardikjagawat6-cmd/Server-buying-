<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$c = @new mysqli('127.0.0.1', 'root', 'root');
if ($c->connect_error) {
    $c = @new mysqli('localhost', 'root', 'root');
    if ($c->connect_error) { die("Engine Error: Access blocked."); }
}

$c->query("CREATE DATABASE IF NOT EXISTS yt_notes_hosting");
$c->select_db("yt_notes_hosting");

// 1. Structural Layout Matrix Mapping Hardware Products
$t1 = "CREATE TABLE IF NOT EXISTS hosting_products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  subtitle VARCHAR(100),
  price DECIMAL(10,2) NOT NULL,
  ram VARCHAR(50) NOT NULL,
  cpu VARCHAR(50) NOT NULL,
  storage VARCHAR(50) NOT NULL,
  is_popular TINYINT(1) DEFAULT 0
)";
$c->query($t1);

// 2. Structural Layout Matrix Mapping Notification Trackers
$t2 = "CREATE TABLE IF NOT EXISTS payment_notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_name VARCHAR(100) NOT NULL,
  price_paid DECIMAL(10,2) NOT NULL,
  transaction_id VARCHAR(100) NOT NULL,
  status ENUM('Pending', 'Approved') DEFAULT 'Pending',
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$c->query($t2);

// Check if status column exists in old databases, insert if missing
$check = $c->query("SHOW COLUMNS FROM payment_notifications LIKE 'status'");
if ($check && $check->num_rows == 0) {
    $c->query("ALTER TABLE payment_notifications ADD COLUMN status ENUM('Pending', 'Approved') DEFAULT 'Pending'");
}

$c->query("TRUNCATE TABLE hosting_products");

$i = "INSERT INTO hosting_products (name, subtitle, price, ram, cpu, storage, is_popular) VALUES 
('Lobby Node', 'Starter Node', 4.99, '4 GB RAM', 'Ryzen 7 Shared CPU', '50 GB NVMe Storage', 0),
('Minecraft VPS', 'Internal V4', 60.00, '64 GB RAM', 'AMD Ryzen 7 Dedicated', '500 GB NVMe Storage', 1),
('Network Node', 'High Performance CPU', 1300.00, '128 GB RAM', 'Dual AMD Ryzen 7', '2 TB NVMe Storage', 0)";

if ($c->query($i)) {
    echo "🎉 SUCCESS: Database, server configurations, and transaction logs are successfully aligned!";
} else {
    echo "Error processing layout profiles: " . $c->error;
}
$c->close();
?>
