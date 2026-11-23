# Smart IT Asset Management System

A beginner-friendly PHP + MySQL project for tracking IT assets, employees, and maintenance. Includes a small C program that summarizes an exported asset CSV.

## Requirements
- Windows with XAMPP (Apache, PHP, MySQL/MariaDB, phpMyAdmin)
- MySQL port used by this project: `3307` (edit `config/db.php` if yours differs)
- Optional: GCC compiler for the C report

## Setup
1. Extract this folder into your XAMPP `htdocs` directory, e.g. `C:\xampp\htdocs\smart-it-asset-management`.
2. Start Apache and XAMPP MySQL.
3. Open phpMyAdmin at `http://localhost/phpmyadmin/`.
4. Create/select database `smart_asset_db`.
5. Import `database/schema.sql`. **Warning:** this script drops and recreates the project's three tables. Import only into a fresh `smart_asset_db` database.
6. Check `config/db.php`: host `127.0.0.1`, port `3307`, database `smart_asset_db`, user `root`, password blank (typical local XAMPP defaults).
7. Open `http://localhost/smart-it-asset-management/`.

## Features
- Dashboard counts, warranty-expiry summary, recent assets and maintenance.
- Asset create, edit, delete, assignment and CSV export.
- Employee directory, add and deactivate.
- Maintenance logging and resolution.
- C companion program to read exported CSV and calculate status/value totals.

## C report
1. In the app, download the CSV export from `export_assets.php` (open `http://localhost/smart-it-asset-management/export_assets.php`).
2. Save it as `assets-export.csv` in the `c-report` folder.
3. Compile: `gcc report.c -o report`
4. Run: `report.exe assets-export.csv`

The teaching parser expects simple CSV values and does not handle quoted fields containing commas.

## Suggested test
- Open Dashboard and check sample data.
- Add an employee.
- Add an asset and assign it.
- Create a maintenance record; the asset changes to Under Maintenance.
- Resolve the record; the asset changes to Available.
- Export CSV and run the C report.

## GitHub
1. Create a new empty GitHub repository.
2. Open a terminal in this folder.
3. Run:
   ```
   git init
   git add .
   git commit -m "Build Smart IT Asset Management System"
   git branch -M main
   git remote add origin https://github.com/YOUR-USERNAME/YOUR-REPOSITORY.git
   git push -u origin main
   ```

## Security and scope
Uses PDO prepared statements, output escaping and CSRF tokens on POST forms. This is a local learning/demo project, not production-ready: it has no authentication or role-based access control, and needs a fuller audit trail, backups, validation and deployment hardening before real organizational use.
