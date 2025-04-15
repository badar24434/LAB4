<?php
require_once 'db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from form
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    // For debugging - you can remove this after fixing the issue
    error_log("Login attempt: Email = $email");

    // Check if user exists with the given credentials
    $stmt = $conn->prepare("SELECT id, name FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Proper if/else structure
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'message' => 'Login successful! Redirecting...',
            'name' => $user['name'],
            'redirect' => 'index.html?name=' . urlencode($user['name']) . '&email=' . urlencode($email)
        ]);
        exit; // Added exit to prevent additional output
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Login failed. Invalid email or password.'
        ]);
        exit; // Added exit
    }
    
    $stmt->close();
}

$conn->close();
?>
