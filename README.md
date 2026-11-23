# AssetFlow – Smart IT Asset Management System

AssetFlow is a project I developed to make IT asset management easier and more organized. It provides a simple way to keep track of company assets, manage employees, and maintain records of asset maintenance.

I built this project while learning and working with PHP, MySQL, and C programming.

## What can it do?

- View asset details and overall inventory through a dashboard.
- Add, update, and manage IT assets.
- Maintain employee records.
- Track which assets are assigned to employees.
- Record and manage maintenance activities.
- Export asset details into a CSV file.
- Generate a basic report using a C program.

## Technologies Used

- PHP – Backend development
- MySQL – Database management
- HTML & CSS – Page structure and styling
- JavaScript – Basic frontend interactions
- C – CSV-based reporting

## Getting Started

To run this project on your computer:

1. Install XAMPP.
2. Download or clone this repository.
3. Place the project folder inside the `htdocs` directory.
4. Start Apache and MySQL from the XAMPP Control Panel.
5. Open phpMyAdmin and import `database/schema.sql`.
6. Check the database settings in `config/db.php`.
7. Open this URL in your browser:

   `http://localhost/smart-it-asset-management/`

## C Reporting Program

The project also includes a small C program that reads exported asset data from a CSV file and generates a basic report.

Compile it using GCC:

```bash
gcc c-report/report.c -o c-report/report.exe
```

Run it with your exported CSV file:

```bash
c-report/report.exe assets-export.csv
```

## What I Learned

While building this project, I got practical experience with PHP and MySQL connectivity, database operations, CRUD functionality, CSV handling, and basic C programming.

## Future Improvements

- Add user login and authentication.
- Improve the dashboard with more analytics.
- Add role-based access for administrators and employees.

---
