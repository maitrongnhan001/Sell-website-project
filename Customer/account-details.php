<?php
ob_start();
include('./layouts/header.php');
if (isset($_SESSION['username_customer'])) {
    $username = $_SESSION['username_customer'];
} else {
    header('Location: ' . URL . 'Customer/login.php');
    die();
}
?>

<?php include('./layouts/child-menu.php'); ?>

<section class="register">
    <div class="container">
        <h1 class="text-center">Thông tin tài khoản</h1>
        <?php
        if (isset($_SESSION['add_user'])) {
            echo "<div class='green text-center'>" . $_SESSION['add_user'] . "</div>";
            unset($_SESSION['add_user']);
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='red text-center'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="" method="POST">
            <?php
            //get data
            $conn = connectToDatabase();
            $sql = "SELECT * FROM KhachHang, DiaChiKH 
                    WHERE KhachHang.MSKH = DiaChiKH.MSKH
                    AND UserName = '$username'";
            $infoUser = executeSQLResult($conn, $sql);
            $codeCustomer = $infoUser[0]['MSKH'];
            $nameCustomer = $infoUser[0]['HoTenKH'];
            $company = $infoUser[0]['TenCongTy'];
            $fax = $infoUser[0]['SoFax'];
            $phone = $infoUser[0]['SoDienThoai'];
            $address = $infoUser[0]['DiaChi'];
            ?>
            <p class="text-center"><b>Tên đăng nhập:</b> <?php echo $username; ?></p>
            <br>
            <div class="input">
                <div class="input-login">
                    <p><b>Họ và Tên</b></p>
                    <input type="text" name="nameCustomer" class="input-responsive" value="<?php echo $nameCustomer; ?>" required placeholder="Nhâp họ và tên *">
                    <p><b>Số fax</b></p>
                    <input type="text" name="fax" class="input-responsive" value="<?php echo $fax; ?>" placeholder="Nhập số fax">
                    <br>
                </div>
                <div class="input-login">
                    <p><b>Tên công ty</b></p>
                    <input type="text" name="company" class="input-responsive" value="<?php echo $company; ?>" placeholder="Nhâp tên công ty">
                    <p><b>Số điện thoại</b></p>
                    <input type="text" name="phone" class="input-responsive" value="<?php echo $phone; ?>" required placeholder="Nhâp số điện thoại *">
                    <p id="nofi-4" class="red"></p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="text-center">
                <input type="submit" name="info" id="register" value="Cập nhật" class="btn btn-login">
            </div>
        </form>
        <?php
        //update information for customer
        if (isset($_POST['info'])) {
            //get value
            $nameCustomer = $_POST['nameCustomer'];
            $company = $_POST['company'];
            $phone = $_POST['phone'];
            $fax = $_POST['fax'];
            $address = $_POST['address'];
            //store to database
            $conn = connectToDatabase();
            $sql = "UPDATE KhachHang SET
            HoTenKH='$nameCustomer',
            TenCongTy='$company',
            SoDienThoai='$phone',
            SoFax='$fax'
            WHERE MSKH=$codeCustomer";
            $result = executeSQL($conn, $sql);
            if (!$result) {
                $_SESSION['error'] = "Cập nhật không thành công.";
                header('Location: ' . URL . 'Customer/account-details.php');
            } else {
                $_SESSION['add_user'] = "Cập nhật thành công.";
                header('Location: ' . URL . 'Customer/account-details.php');
            }
        }
        ?>
    </div>
</section>

<hr>

<section class="login">
    <div class="container">
        <h1 class="text-center">Mật khẩu</h1>
        <form action="" method="POST">
            <div class="input-login">
                <p><b>Mật khẩu cũ</b></p>
                <input type="password" name="current-password" class="input-responsive" required placeholder="Nhập mật khẩu *">
                <p class="red">
                <?php
                if (isset($_SESSION['error-password'])) {
                    echo $_SESSION['error-password'];
                    unset($_SESSION['error-password']);
                }
                ?></p>
                <p><b>Mật khẩu mới</b></p>
                <input type="password" name="password" class="input-responsive" required placeholder="Nhập mật khẩu *">
                <p id="nofi-2"></p>
                <p><b>Nhập lại mật khẩu mới</b></p>
                <input type="password" name="r-password" class="input-responsive" required placeholder="Nhập lại mật khẩu *">
                <p id="nofi-3" class="red"></p>
            </div>
            <div class="clearfix"></div>
            <div class="text-center">
                <input type="submit" name="update-password" id="register" value="Cập nhật" class="btn btn-login">
            </div>
        </form>
        <?php
        //update password for customer
        if (isset($_POST['update-password'])) {
            //check current password
            $current_password = md5($conn->real_escape_string($_POST['current-password']));
            $sql = "SELECT * FROM KhachHang WHERE UserName='$username' AND Password='$current_password'";
            $result = executeSQLResult($conn, $sql);
            if (count($result) != 1) {
                $_SESSION['error-password'] = "Cập nhật không thành công.";
                header('Location: ' . URL . 'Customer/account-details.php');
                unset($_POST['current-password'], $_POST['password']);
                closeConnect($conn);
                die();
            }
            //get value
            $password = md5($conn->real_escape_string($_POST['password']));
            //store to database
            $sql = "UPDATE KhachHang SET
                    Password='$password'
                    WHERE MSKH=$codeCustomer";
            $result = executeSQL($conn, $sql);
            unset($_POST['current-password'], $_POST['password']);
            if ($result) {
                $_SESSION['add_user'] = "Cập nhật thành công.";
                header('Location: ' . URL . 'Customer/account-details.php');
            } else {
                $_SESSION['error'] = "Cập nhật không thành công.";
                header('Location: ' . URL . 'Customer/account-details.php');
            }
        }
        ?>
    </div>
</section>


<?php
closeConnect($conn);
include('./layouts/footer.php');
ob_end_flush();
?>