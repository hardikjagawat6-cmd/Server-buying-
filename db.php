<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once 'config.php';

// Build product schema securely
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS hosting_products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  subtitle VARCHAR(100),
  price DECIMAL(10,2) NOT NULL,
  ram VARCHAR(50) NOT NULL,
  cpu VARCHAR(50) NOT NULL,
  storage VARCHAR(50) NOT NULL,
  is_popular TINYINT(1) DEFAULT 0
)");

mysqli_query($conn, "TRUNCATE TABLE hosting_products");

// Seed the 9 brand new tiered game hosting configurations
$i = "INSERT INTO hosting_products (name, subtitle, price, ram, cpu, storage, is_popular) VALUES 
('DIRT PLAN', 'Starter Tier', 60.00, '2 GB DDR4', '100% (1 Core)', '20 GB NVMe', 0),
('WOOD PLAN', 'Budget Instance', 120.00, '4 GB DDR4', '200% (2 Cores)', '40 GB NVMe', 0),
('STONE PLAN', 'Standard SMP Instance', 180.00, '6 GB DDR4', '250% (2.5 Cores)', '60 GB NVMe', 0),
('COAL PLAN', 'Performance Node', 240.00, '8 GB DDR4', '300% (3 Cores)', '80 GB NVMe', 0),
('IRON PLAN', 'Advanced Community Core', 300.00, '10 GB DDR4', '350% (3.5 Cores)', '100 GB NVMe', 1),
('GOLD PLAN', 'Premium Modded Framework', 420.00, '14 GB DDR4', '400% (4 Cores)', '140 GB NVMe', 0),
('REDSTONE PLAN', 'High-Tier Automated Network', 480.00, '16 GB DDR4', '450% (4.5 Cores)', '160 GB NVMe', 0),
('DIAMOND PLAN', 'Ultimate Performance Box', 720.00, '24 GB DDR4', '500% (5 Cores)', '200 GB NVMe', 0),
('NETHERITE PLAN', 'Enterprise Network Fleet', 960.00, '32 GB DDR4', '250% NVMe Space', 0)";

if (mysqli_query($conn, $i)) {
    echo "🎉 SUCCESS: Intel Xeon plans loaded successfully onto cloud nodes!";
} else {
    echo "Error uploading hardware layers: " . mysqli_error($conn);
}
mysqli_close($conn);
?>
