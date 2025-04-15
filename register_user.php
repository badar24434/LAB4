<?php
// Enable error reporting for debugging
error_reporting(E_ALL); 
ini_set('display_errors', 1);

require_once 'db_connection.php';

header('Content-Type: application/json');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Log the incoming request for debugging
    error_log("Registration attempt received: " . json_encode($_POST));
    
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    // Simple password validation
    if (strlen($password) < 12) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 12 characters long']);
        exit;
    }

    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
        exit;
    }

    try {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            exit;
        }

        // For a real application, you would hash the password here
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // But for this simple lab, we'll store the password as is

        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            error_log("Registration successful for: $email");
            echo json_encode(['success' => true, 'message' => 'Registration successful']);
        } else {
            error_log("Registration failed for: $email. Error: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $stmt->error]);
        }

        $stmt->close();
    } catch (Exception $e) {
        error_log("Exception during registration: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}

$conn->close();
?>
