-- Create the main table for your hosting products
CREATE TABLE IF NOT EXISTS `hosting_products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `subtitle` VARCHAR(100) DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `ram` VARCHAR(50) NOT NULL,
  `cpu` VARCHAR(50) NOT NULL,
  `storage` VARCHAR(50) NOT NULL,
  `is_popular` TINYINT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Clear any old placeholder data
TRUNCATE TABLE `hosting_products`;

-- Insert your exact packages matching your invoice details
INSERT INTO `hosting_products` (`name`, `subtitle`, `price`, `ram`, `cpu`, `storage`, `is_popular`) VALUES
('Lobby Node', 'Starter Node', 4.99, '4 GB RAM', 'Ryzen 7 Shared CPU', '50 GB NVMe Storage', 0),
('Minecraft VPS', 'Internal V4', 899.00, '64 GB RAM', 'AMD Ryzen 7 Dedicated', '500 GB NVMe Storage', 1),
('Network Node', 'High Performance CPU', 1300.00, '128 GB RAM', 'Dual AMD Ryzen 7', '2 TB NVMe Storage', 0);
