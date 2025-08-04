<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../includes/admin_auth.php");
    exit();
    
}
echo "hello";
?>
