# LAB4 Project Setup Guide

## Requirements
- XAMPP (which includes Apache, PHP, MySQL, and phpMyAdmin)
- Node.js and npm (for development with webpack)

## Installation Steps

### 1. Setup XAMPP
1. Download and install XAMPP from https://www.apachefriends.org/
2. Start Apache and MySQL services from the XAMPP control panel
   - Click the "Start" buttons next to Apache and MySQL

### 2. Database Setup
1. Place the LAB4 project folder in the htdocs directory of your XAMPP installation
   - Typically located at: `C:\xampp\htdocs\` (Windows) or `/Applications/XAMPP/htdocs/` (Mac)
2. Open your browser and navigate to http://localhost/LAB4/db_setup.php
   - This will automatically create the necessary database and tables

### 3. Install Node Dependencies (for development only)
1. Open a terminal/command prompt in the project directory
2. Run: `npm install` to install all dependencies

### 4. Access the Application
- Direct access: http://localhost/LAB4/
- For development with webpack: Run `npm start` in the project directory

### Important Notes
- MySQL is already included in XAMPP, no separate installation required
- The default database credentials are:
  - Username: root
  - Password: (blank/empty)
- If you've changed your MySQL credentials, update them in db_connection.php
