<?php
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $cnic = mysqli_real_escape_string($conn, $_POST['cnic']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.location.href='/olx-pafiast/admin/HTML/signup.html';</script>";
        exit();
    }

    // Count the total number of admin users
    $countQuery = "SELECT COUNT(*) as total_admins FROM admins";
    $countResult = mysqli_query($conn, $countQuery);
    $countRow = mysqli_fetch_assoc($countResult);
    $totalAdmins = $countRow['total_admins'];

    // Limit admin registration to 3 users
    if ($totalAdmins >= 3) {
        echo "<script>alert('Admin registration limit reached. No more than 3 admins are allowed.'); window.location.href='/olx-pafiast/admin/HTML/signup.html';</script>";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if CNIC or Email already exists
    $checkQuery = "SELECT * FROM admins WHERE cnic = '$cnic' OR email = '$email'";
    $result = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('CNIC or Email already exists'); window.location.href='/olx-pafiast/admin/HTML/signup.html';</script>";
        exit();
    }

    // Insert new admin user into the database
    $sql = "INSERT INTO admins (name, email, phone, cnic, password) VALUES ('$name', '$email', '$phone', '$cnic', '$hashedPassword')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registration successful! Please Login'); window.location.href='/olx-pafiast/admin/HTML/login.html';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>