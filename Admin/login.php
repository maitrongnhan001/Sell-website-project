<?php
ob_start();
include('../config/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Home</title>
</head>

<body>
    <br>
    <h1 class="text-center">Quản lý đặt hàng</h1>
    <br>
    <hr>
    <section class="login">
        <div class="container">
            <h1 class="text-center">Đăng nhập</h1>
            <form action="" method="POST">
                <div class="input-login">
                    <div class="group-input">
                        <p><b>Tên đăng nhập:</b></p>
                        <input type="text" name="username" class="format-ip" require placeholder="Nhâp tên tài khoản *">
                    </div>
                    <div class="group-input">
                        <p><b>Mật khẩu:</b></p>
                        <input type="password" name="password" class="format-ip" require placeholder="Nhập mật khẩu *">
                    </div>
                    <p id="nofi-1"></p>
                </div>
                <?php
                if (isset($_SESSION['error'])) {
                    echo "<div class='red text-center'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']);
                }
                ?>
                <div class="group-input">
                    <input type="submit" name="submit" value="Đăng nhập" class="btn-primary">
                </div>
            </form>
        </div>
    </section>

    <?php
    $conn = connectToDatabase();
    if (isset($_POST['submit'])) {
        //get data
        $userName = $conn->real_escape_string($_POST['username']);
        $password = md5($conn->real_escape_string($_POST['password']));
        //login
        $sql = "SELECT UserName, ChucVu FROM NhanVien WHERE UserName = '%s' AND Password = '%s'";
        $sql = sprintf($sql, $userName, $password);
        $admin = executeSQLResult($conn, $sql);
        if (count($admin) == 1) {
            $userName = $admin[0]['UserName'];
            $position = $admin[0]['ChucVu'];
            $_SESSION['username'] = $userName;
            $_SESSION['position'] = $position;
            header('location: ' . URL . 'admin/');
        } else {
            $_SESSION['error'] = "Tài khoản hoặc mật khẩu không đúng.";
            header('location: ' . URL . '/admin/login.php');
        }
        //clear data and connnect
        unset($_POST['submit'], $_POST['username'], $_POST['password']);
        closeConnect($conn);
        //redirect
    }
    include('./layouts/footer.php');
    ob_end_flush();
    ?>