<?php
// Connect to MySQL (default username is usually root with empty password on XAMPP)
$conn = new mysqli("localhost", "root", "");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS students";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db("students");

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
} else {
    echo "Database and table created successfully";
}

$conn->close();
?>
