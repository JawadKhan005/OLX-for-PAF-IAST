<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Logged-in user's ID
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle file upload
    $image = $_FILES['image'];
    $image_path = 'uploads/' . basename($image['name']);
    move_uploaded_file($image['tmp_name'], $image_path);

    // Insert into products table
    $query = "INSERT INTO products (user_id, name, description, price, image_path) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Database Error: " . $conn->error);
    }

    $stmt->bind_param('issss', $user_id, $name, $description, $price, $image_path);
    if ($stmt->execute()) {
        header('Location: user_dashboard.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
