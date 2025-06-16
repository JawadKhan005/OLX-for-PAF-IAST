<?php
header('Content-Type: application/json');
include 'connection.php';

$query = "SELECT product_id, name, price, image_path FROM products WHERE status = 'accepted'";
$result = $conn->query($query);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);
?>
