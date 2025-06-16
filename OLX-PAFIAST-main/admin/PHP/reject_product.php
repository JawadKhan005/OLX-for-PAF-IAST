<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /olx-pafiast/admin/HTML/login.html');
    exit();
}

include 'connection.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Update product status to 'rejected'
    $query = "UPDATE products SET status = 'rejected' WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $product_id);
    if ($stmt->execute()) {
        header('Location: admin_dashboard.php'); // Redirect back to admin dashboard
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
