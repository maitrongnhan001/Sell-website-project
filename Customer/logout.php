<?php
include('../Config/connect.php');
if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
    header('location: '.URL.'Customer/');
} else {
    header('location: '.URL.'Customer/');
}
?>