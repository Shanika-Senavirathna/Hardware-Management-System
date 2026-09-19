# 🛠️ Hardware Management System

A web-based Hardware Management System developed using HTML, CSS, PHP, and MySQL in VS Code to streamline inventory tracking, sales billing, and supplier records.

---

## ✨ Key Features
- 🔐 **User Authentication:** Secure login system for Admin and Staff (`login.php`).
- 📊 **Dashboard:** Real-time summary of sales and hardware stock (`dashboard.php`).
- 📦 **Products Management:** Easily add, update, and manage hardware inventory (`products.php`).
- 🧾 **Billing System:** Fast point-of-sale checkout and bill printing (`billing.php`, `print_bill.php`).
- 📜 **Sales History:** Detailed records of daily sales transactions (`sales_history.php`).
- 👥 **User Management:** Manage user roles and system access (`users.php`).

---

## 🛠️ Tech Stack
- **IDE / Editor:** Visual Studio Code (VS Code)
- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Environment:** XAMPP / WAMP Server

---

## 🚀 How to Setup and Run

1. **Clone or Download:**
   - Download/extract this repository into your local server's root folder (e.g., `C:/xampp/htdocs/Hardware-Management-System`).

2. **Database Setup:**
   - Open **phpMyAdmin** in your browser (`http://localhost/phpmyadmin`).
   - Create a new database named `smartbuild_db`.
   - Click on **Import** and upload the `smartbuild_db (1).sql` file included in this repository.

3. **Configure Connection:**
   - Check the database connection settings inside the `config/` folder to ensure the database name and credentials match your local setup.

4. **Run Application:**
   - Open your web browser and navigate to:  
     `http://localhost/Hardware-Management-System/login.php`
