<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

require_once 'connection.php'; 

$user_id = $_SESSION['user_id']; // Get logged-in user's ID
$user_name = $_SESSION['user_name']; // Logged-in user's name

// Fetch ONLY the logged-in user's products
$query = "SELECT * FROM products WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | OLX PAF-IAST</title>
    <link rel="stylesheet" href="/olx-pafiast/src/CSS/user_dashboard.css">
</head>
<body>
<header>
    <h1>Welcome, <?php echo htmlspecialchars($user_name); ?></h1>
    <a href="profile.php" class="profile-link">Profile</a>
    <a href="logout.php" class="logout-link">Logout</a>
</header>

<main>
    <section class="product-upload">
        <h2>Upload Product</h2>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Product Description" required></textarea>
            <input type="text" name="price" placeholder="Price" required>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>
    </section>

    <section class="product-list">
        <h2>Your Products</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td><?php echo htmlspecialchars($product['price']); ?></td>
                        <td>
                        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="Product Image" width="100">
                    </td>
                    <td><?php echo ucfirst($product['status']); ?></td> <!-- Display the status -->
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</main>

<script src="/olx-pafiast/src/JavaScript/dashboard.js"></script>
</body>
</html>
