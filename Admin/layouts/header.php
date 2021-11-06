<?php
include('../config/connect.php');
if (!isset($_SESSION['username'])) {
    header('location: ' . URL . '/admin/login.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css?v=1.1">
    <title>Home</title>
</head>

<body>
    <!--menu-->
    <section class="menu text-center">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="./images/for-web/logo.jpeg" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>
            <ul>
                <li><a href=<?php echo URL . "admin/index.php"; ?>>Trang Chủ</a></li>
                <li><a href=<?php echo URL . "admin/manager-admin.php"; ?>>Nhân Viên</a></li>
                <li><a href=<?php echo URL . "admin/manager-customer.php"; ?>>Khách hàng</a></li>
                <li><a href=<?php echo URL . "admin/manager-categories.php"; ?>>Danh Mục</a></li>
                <li><a href=<?php echo URL . "admin/manager-products.php"; ?>>Sản Phẩm</a></li>
                <li><a href=<?php echo URL . "admin/manager-order.php?filter=1"; ?>>Đơn Hàng</a></li>
                <li><a href=<?php echo URL . "admin/logout.php"; ?>>Đăng Xuất</a></li>
            </ul>
        </div>
    </section>