# car_driving_school  

A lightweight **Online Car Driving School Management System** built with PHP. The application enables administrators to manage schools, packages, enrolments, and subscriptions, while providing a simple front‑end for students to enroll and track their status.

---  

## Overview  

The system offers a complete workflow for a driving school:

* Admins can add/edit schools and driving packages.  
* Students can register for courses, view enrolment status, and cancel subscriptions.  
* A contact‑support page allows users to reach the school directly.  

All data is stored in a MySQL database (`drivingschool_db.sql`). The project is organized into an `admin/` panel and a public front‑end.

---  

## Features  

| Area | Capability |
|------|------------|
| **Admin Dashboard** | Secure login, navigation bar, and logout. |
| **School Management** | Add, edit, view, and delete driving schools. |
| **Package Management** | Create, edit, view, and delete driving packages. |
| **Enrolments** | View pending enrolments, manage enrolment status, and generate reports. |
| **Subscriptions** | View, update, and cancel student subscriptions. |
| **Student Portal** | Enroll in a package, view enrolment status, and cancel subscriptions. |
| **Support** | Contact form for students to reach the school. |
| **Responsive UI** | Simple CSS styling (`css/style.css`). |

---  

## Tech Stack  

| Layer | Technology |
|-------|------------|
| **Backend** | PHP 7.x+ |
| **Database** | MySQL (schema in `Database/drivingschool_db.sql`) |
| **Frontend** | HTML5, CSS3 |
| **Server** | Apache / Nginx (any LAMP/LEMP stack) |
| **Version Control** | Git (GitHub) |

---  

## Installation  

1. **Clone the repository**  

   ```bash
   git clone https://github.com/yourusername/car_driving_school.git
   cd car_driving_school
   ```

2. **Create the database**  

   ```sql
   -- In MySQL client or phpMyAdmin
   SOURCE Database/drivingschool_db.sql;
   ```

3. **Configure the application**  

   - Copy `config.php.example` to `config.php` (if the example file exists) or edit `config.php` directly.  
   - Set your database credentials:  

     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'drivingschool_db');
     define('DB_USER', 'YOUR_DB_USERNAME');
     define('DB_PASS', 'YOUR_DB_PASSWORD');
     ```

   - (Optional) Update any API keys or external service URLs, replacing real values with `YOUR_OWN_API_KEY`.

4. **Set up the web server**  

   - Place the project in your web root (e.g., `/var/www/html/car_driving_school`).  
   - Ensure the `admin/uploads/` directory is writable for image uploads.  

5. **Install dependencies** *(none required beyond PHP core)*  

6. **Start the server**  

   - For a quick local test, you can use PHP’s built‑in server:  

     ```bash
     php -S localhost:8000
     ```

   - Navigate to `http://localhost:8000/index.php` in your browser.

---  

## Usage  

### Admin  

1. Open `admin/admin_login.php` and log in with the credentials you created in the database.  
2. Use the navigation bar (`