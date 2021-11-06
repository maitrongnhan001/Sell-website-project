<?php
ob_start();
include('../Config/connect.php');
if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
    unset($_SESSION['position']);
    header('location: '.URL.'admin/login.php');
} else {
    header('location: '.URL.'admin/login.php');
}
ob_end_flush();
?>