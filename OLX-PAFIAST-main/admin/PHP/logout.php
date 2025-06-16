<?php
session_start();
session_unset();
session_destroy();
header("Location: /olx-pafiast/admin/HTML/login.html");
exit();
?>
