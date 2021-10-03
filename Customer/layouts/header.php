<?php
include('../Config/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Storeee</title>
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="./images/for-web/logo.jpeg" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <nav class="menu text-right">
                <ul>
                    <li class="active"><a href=<?php echo URL . 'Customer/'; ?>>Trang Chủ</a></li>
                    <li><a href=<?php echo URL . 'Customer/categories.php'; ?>>Danh Mục</a></li>
                    <li><a href=<?php echo URL . 'Customer/products.php'; ?>>Sản Phẩm</a></li>
                    <li>
                        <?php
                        if (isset($_SESSION['username'])) {
                        ?>

                            <a href=<?php echo URL . 'Customer/logout.php'; ?>>Tài khoản</a>
                        <?php
                        } else {
                        ?>
                            <a href=<?php echo URL . 'Customer/login.php'; ?>>Đăng Nhập</a>
                        <?php
                        }
                        ?>
                    </li>
                </ul>
            </nav>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->