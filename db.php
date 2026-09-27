<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_host = '://aivencloud.com'; 
$db_port = 11491;
$db_user = 'avnadmin';      
$db_pass = 'AVNS_8y5YSn28WUzozp0d8_D'; // Paste your same Aiven cloud password here!
$db_name = 'defaultdb';

$c = mysqli_init();
mysqli_ssl_set($c, NULL, NULL, NULL, NULL, NULL);
$success = @mysqli_real_connect($c, $db_host, $db_user, $db_pass, $db_name, $db_port, NULL, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);

if (!$success) { die("Engine Cloud Connection Error: " . mysqli_connect_error()); }

// 1. Structural Hardware Catalog Table Layout Mappings
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
mysqli_query($c, $t1);

// 2. Structural Notification Tracker Mappings
$t2 = "CREATE TABLE IF NOT EXISTS payment_notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_name VARCHAR(100) NOT NULL,
  price_paid DECIMAL(10,2) NOT NULL,
  transaction_id VARCHAR(100) NOT NULL,
  status ENUM('Pending', 'Approved') DEFAULT 'Pending',
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($c, $t2);

mysqli_query($c, "TRUNCATE TABLE hosting_products");

$i = "INSERT INTO hosting_products (name, subtitle, price, ram, cpu, storage, is_popular) VALUES 
('Lobby Node', 'Starter Node', 4.99, '4 GB RAM', 'Ryzen 7 Shared CPU', '50 GB NVMe Storage', 0),
('Minecraft VPS', 'Internal V4', 60.00, '64 GB RAM', 'AMD Ryzen 7 Dedicated', '500 GB NVMe Storage', 1),
('Network Node', 'High Performance CPU', 1300.00, '128 GB RAM', 'Dual AMD Ryzen 7', '2 TB NVMe Storage', 0)";

if (mysqli_query($c, $i)) {
    echo "🎉 SUCCESS: Your Online Cloud Database Tables are successfully populated and active!";
} else {
    echo "Error packing layout indexes: " . mysqli_error($c);
}
mysqli_close($c);
?>
