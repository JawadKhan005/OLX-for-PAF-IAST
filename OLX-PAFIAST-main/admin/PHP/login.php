<?php
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Get form data
    $cnic = mysqli_real_escape_string($conn, $_POST['cnic']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the CNIC exists in the database
    $sql = "SELECT * FROM admins WHERE cnic = '$cnic'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Fetch user data
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Start session and store user data
            session_start();
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_email'] = $user['email'];
            
            // Redirect to the admin dashboard or home page
            header("Location: /olx-pafiast/admin/PHP/admin_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid password'); window.location.href='/olx-pafiast/admin/HTML/login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found with the provided CNIC'); window.location.href='/olx-pafiast/admin/HTML/signup.html';</script>";
    }
}
?>

    <script>
        window.onload = function() {
            document.getElementById("cnic").value = "";
            document.getElementById("password").value = "";
        };
    </script>