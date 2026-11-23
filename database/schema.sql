CREATE DATABASE IF NOT EXISTS smart_asset_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE smart_asset_db;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS maintenance_records;
DROP TABLE IF EXISTS assets;
DROP TABLE IF EXISTS employees;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE employees (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(160) NULL,
 department VARCHAR(100) NULL,
 active TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY uq_employee_email (email)
) ENGINE=InnoDB;

CREATE TABLE assets (
 id INT AUTO_INCREMENT PRIMARY KEY,
 asset_tag VARCHAR(50) NOT NULL UNIQUE,
 name VARCHAR(150) NOT NULL,
 category ENUM('Laptop','Desktop','Monitor','Printer','Networking','Other') NOT NULL DEFAULT 'Other',
 serial_number VARCHAR(120) NULL,
 purchase_date DATE NULL,
 purchase_cost DECIMAL(12,2) NOT NULL DEFAULT 0,
 warranty_expiry DATE NULL,
 status ENUM('Available','Assigned','Under Maintenance','Retired') NOT NULL DEFAULT 'Available',
 assigned_to INT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_asset_employee FOREIGN KEY (assigned_to) REFERENCES employees(id) ON DELETE SET NULL,
 INDEX idx_asset_status(status),
 INDEX idx_asset_warranty(warranty_expiry)
) ENGINE=InnoDB;

CREATE TABLE maintenance_records (
 id INT AUTO_INCREMENT PRIMARY KEY,
 asset_id INT NOT NULL,
 description VARCHAR(500) NOT NULL,
 vendor VARCHAR(150) NULL,
 cost DECIMAL(12,2) NOT NULL DEFAULT 0,
 status ENUM('Open','Resolved') NOT NULL DEFAULT 'Open',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 resolved_at DATETIME NULL,
 CONSTRAINT fk_maintenance_asset FOREIGN KEY (asset_id) REFERENCES assets(id) ON DELETE CASCADE,
 INDEX idx_maintenance_status(status)
) ENGINE=InnoDB;

INSERT INTO employees(name,email,department) VALUES
('Aarav Shah','aarav@example.com','Engineering'),
('Diya Patel','diya@example.com','Finance'),
('Rohan Mehta','rohan@example.com','Human Resources');

INSERT INTO assets(asset_tag,name,category,serial_number,purchase_date,purchase_cost,warranty_expiry,status,assigned_to) VALUES
('LAP-001','Dell Latitude 5420','Laptop','DL5420-001','2024-01-10',65000,'2027-01-10','Assigned',1),
('LAP-002','HP ProBook 440','Laptop','HP440-002','2023-06-15',58000,'2026-12-15','Assigned',2),
('MON-001','Dell 24-inch Monitor','Monitor','DM24-001','2024-03-20',12000,'2027-03-20','Available',NULL),
('PRN-001','HP LaserJet Pro','Printer','HPLJ-001','2022-09-01',18000,'2026-12-01','Under Maintenance',NULL),
('NET-001','TP-Link Network Switch','Networking','TPL-001','2024-02-12',7500,'2027-02-12','Available',NULL);

INSERT INTO maintenance_records(asset_id,description,vendor,cost,status) VALUES
(4,'Paper feed roller inspection','City Office Systems',1200,'Open');
