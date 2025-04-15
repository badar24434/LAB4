<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // 
$dbname = "students";

// Create connection with error handling
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Set character set for proper encoding
    $conn->set_charset("utf8mb4");
    
    // For debugging
    error_log("Database connection established successfully");
    
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Connection error occurred. Please try again later.");
}
?>
