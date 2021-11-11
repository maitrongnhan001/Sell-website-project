<?php
include('./layouts/header.php');
?>

<section class="register">
    <div class="container">
        <h1 class="text-center">Đăng ký</h1>
        <form action="" method="POST">
            <div class="input">
                <div class="input-login">
                    Họ và Tên
                    <input type="text" name="nameCustomer" class="input-responsive" required placeholder="Nhâp họ và tên *">
                    Tên đăng nhập
                    <input type="text" name="username" class="input-responsive" required placeholder="Nhâp tên tài khoản *">
                    <p id="nofi-1" class="red"></p>
                    Mật khẩu
                    <input type="password" name="password" class="input-responsive" required placeholder="Nhập mật khẩu *">
                    <p id="nofi-2"></p>
                    Nhập lại mật khẩu
                    <input type="password" name="r-password" class="input-responsive" required placeholder="Nhập lại mật khẩu *">
                    <p id="nofi-3" class="red"></p>
                    <br>
                </div>
                <div class="input-login">
                    Tên công ty
                    <input type="text" name="company"class="input-responsive" placeholder="Nhâp tên công ty">
                    Số điện thoại
                    <input type="text" name="phone" class="input-responsive" required placeholder="Nhâp số điện thoại *">
                    <p id="nofi-4" class="red"></p>
                    Số fax
                    <input type="text" name="fax" class="input-responsive" placeholder="Nhâp số fax">
                    Địa chỉ
                    <input type="text" name="address" class="input-responsive" required placeholder="Nhâp địa chỉ *">
                </div>
                <div class="clearfix"></div>
            </div>
            <?php
            if (isset($_SESSION['add_user'])) {
                echo "<div class='red text-center'>".$_SESSION['add_user']."</div>";
                unset($_SESSION['add_user']);
            }
            ?>
            <div class="text-center">
                <input type="submit" name="submit" id="register" value="Đăng ký" class="btn btn-login">
            </div>
        </form>
    </div>
</section>

<?php
if (isset($_POST['submit'])) {
    //get value
    $nameCustomer = $_POST['nameCustomer'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $company = $_POST['company'];
    $phone = $_POST['phone'];
    $fax = $_POST['fax'];
    $address = $_POST['address'];
    //store to database
    $conn = connectToDatabase();
    $sql = "INSERT INTO KhachHang (
        HoTenKH,
        UserName,
        Password,
        TenCongTy,
        SoDienThoai,
        SoFax
    ) VALUES (
        '$nameCustomer',
        '$username',
        '$password',
        '$company',
        '$phone',
        '$fax'
    )";
    $result = executeSQL($conn, $sql);
    if ($result) {
        //get mskh
        $sql = "SELECT MSKH FROM KhachHang WHERE UserName = '$username'";
        $codeCustomer = executeSQLResult($conn, $sql);
        $codeCustomer = $codeCustomer[0]['MSKH'];
        $sql = "INSERT INTO DiaChiKH (
            DiaChi,
            MSKH
        ) VALUES (
            '$address',
            $codeCustomer
        )";
        $result = executeSQL($conn, $sql);
        if ($result) {
            $_SESSION['add_user'] = "Tạo tài khoản thành công.";
            header('location: '.URL.'Customer/login.php');
        } else {
            $_SESSION['add_user'] = "Tạo tài khoản thành công.";
            header('location: '.URL.'Customer/register.php');
        }
    }
    closeConnect($conn);
}
include('./layouts/footer.php');
?>