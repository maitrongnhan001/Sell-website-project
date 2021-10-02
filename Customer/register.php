<?php
include('./layouts/header.php');
?>
<!-- login -->
<section class="register">
    <div class="container">
        <h1 class="text-center">Đăng ký</h1>
        <form action="" method="POST">
            <div class="input">
                <div class="input-login">
                    Họ và Tên
                    <input type="text" name="nameCustomer" class="input-responsive" require placeholder="Nhâp họ và tên *">
                    Tên đăng nhập
                    <input type="text" name="username" id="username" class="input-responsive" require placeholder="Nhâp tên tài khoản *">
                    <p id="nofi-1" class="red"></p>
                    Mật khẩu
                    <input type="password" name="password" id="password" class="input-responsive" require placeholder="Nhập mật khẩu *">
                    <p id="nofi-2"></p>
                    Nhập lại mật khẩu
                    <input type="password" name="r-password" id="r-password" class="input-responsive" require placeholder="Nhập lại mật khẩu *">
                    <p id="nofi-3" class="red"></p>
                    <br>
                </div>
                <div class="input-login">
                    Tên công ty
                    <input type="text" name="company" id="company" class="input-responsive" placeholder="Nhâp tên công ty">
                    Số điện thoại
                    <input type="text" name="phone" id="phone" class="input-responsive" require placeholder="Nhâp số điện thoại *">
                    <p id="nofi-4" class="red"></p>
                    Số fax
                    <input type="text" name="fax" id="fax" class="input-responsive" placeholder="Nhâp số fax">
                    Địa chỉ
                    <input type="text" name="address" id="address" class="input-responsive" require placeholder="Nhâp địa chỉ *">
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="text-center">
                <input type="submit" name="register" id="register" value="Đăng ký" class="btn btn-login">
            </div>
        </form>
    </div>
</section>
<!-- end login -->
<?php
if (isset($_POST['register'])) {
    
}
include('./layouts/footer.php');
?>