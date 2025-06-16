<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: /olx-pafiast/admin/HTML/login.html");
    exit();
}
?>
