<?php
ob_start();
include('./layouts/header.php');
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: ' . URL . 'Customer/login.php');
    die();
}
?>
<!-- login -->
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
            <div class="input">
                <div class="input-login">
                    <p><b>Tên đăng nhập:</b></p>
                    <p id='username'><?php echo $username; ?></p>
                    <br>
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
                    <p><b>Địa chỉ</b></p>
                    <input type="text" name="address" class="input-responsive" value="<?php echo $address; ?>" required placeholder="Nhâp địa chỉ *">
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
            if ($result) {
                $sql = "UPDATE DiaChiKH (
                DiaChi='$address',
                WHERE MSKH=$codeCustomer";
                $result = executeSQL($conn, $sql);
                if ($result) {
                    $_SESSION['error'] = "Cập nhật không thành công.";
                    header('Location: ' . URL . 'Customer/update-user.php');
                } else {
                    $_SESSION['add_user'] = "Cập nhật thành công.";
                    header('Location: ' . URL . 'Customer/update-user.php');
                }
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
                <p><b>Mật khẩu</b></p>
                <input type="password" name="password" class="input-responsive" required placeholder="Nhập mật khẩu *">
                <p id="nofi-2"></p>
                <p><b>Nhập lại mật khẩu</b></p>
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
            //get value
            $password=md5($_POST['password']);
            //store to database
            $sql = "UPDATE KhachHang SET
                    Password='$password'
                    WHERE MSKH=$codeCustomer";
            $result = executeSQL($conn, $sql);
            if ($result) {
                $_SESSION['add_user'] = "Cập nhật thành công.";
                header('Location: ' . URL . 'Customer/update-user.php');
            } else {
                $_SESSION['error'] = "Cập nhật không thành công.";
                header('Location: ' . URL . 'Customer/update-user.php');
            }
        }
        ?>
    </div>
</section>

<!-- end login -->
<?php
closeConnect($conn);
include('./layouts/footer.php');
ob_end_flush();
?>