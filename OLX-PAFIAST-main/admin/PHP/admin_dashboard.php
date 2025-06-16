<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /olx-pafiast/admin/HTML/login.html');
    exit();
}

require_once 'connection.php';

// Get the logged-in admin's ID and name
$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

// Fetch all products (for admin to see all users' products)
$query = "SELECT * FROM products";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/olx-pafiast/admin/CSS/admin_dashboard.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-md-block sidebar">
                <div class="text-center my-3">
                    <h3>Admin Panel</h3>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Dashboard</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <!-- Pending Products Section -->
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5>All Products</h5>
                    </div>
                    <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Seller</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($product = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $product['product_id']; ?></td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['user_id']); ?></td>
                                    <td><span class="badge <?php echo ($product['status'] == 'pending') ? 'bg-warning' : ($product['status'] == 'accepted' ? 'bg-success' : 'bg-danger'); ?>">
                                    <?php echo ucfirst($product['status']); ?></span></td>
                                    <td class="table-actions">
                                    <?php if ($product['status'] == 'pending') { ?>
                                        <a href="accept_product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-success btn-sm">Accept</a>
                                        <a href="reject_product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                                    <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
