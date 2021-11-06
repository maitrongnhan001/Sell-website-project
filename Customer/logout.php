<?php
ob_start();
include('../Config/connect.php');
if (isset($_SESSION['username_customer'])) {
    unset($_SESSION['username_customer']);
    header('location: '.URL.'Customer/');
} else {
    header('location: '.URL.'Customer/');
}
ob_end_flush();
?>