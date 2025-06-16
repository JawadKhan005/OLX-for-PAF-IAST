<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch and sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $stdFaculty = $_POST['stdFaculty'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Password Confirmation Check
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.location.href='signup.html';</script>";
        exit();
    }

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists
    $checkEmailQuery = "SELECT id FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkEmailQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "<script>alert('Email already exists'); window.location.href='signup.html';</script>";
        exit();
    }
    $checkStmt->close();

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, gender, role, stdFaculty, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $phone, $gender, $role, $stdFaculty, $hashedPassword);

    // Execute the query and check success
    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please Login'); window.location.href='signup.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>