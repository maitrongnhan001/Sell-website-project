<?php
include('./layouts/header.php');
?>
<!-- login -->
<section class="login">
    <div class="container">
        <h1 class="text-center">Đăng nhập</h1>
        <form action="" method="POST">
            <div class="input-login">
                Tên đăng nhập
                <input type="text" name="username" id="username" class="input-responsive" require placeholder="Nhâp tên tài khoản *">
                Mật khẩu
                <input type="password" name="password" id="password" class="input-responsive" require placeholder="Nhập mật khẩu *">
                <p id="nofi-1"></p>
                <br>
                <a href="" class="pink">Quên mật khẩu</a>
                <a href= <?php echo URL.'Customer/register.php'; ?> class="pink">Tạo tài khoản</a>
            </div>
            <?php
            if ($_SESSION['add_user']) {
                echo "<div class='green text-center'>".$_SESSION['add_user']."</div>";
                unset($_SESSION['add_user']);
            }
            ?>
            <div class="text-center">
                <input type="submit" name="login" value="Đăng nhập" class="btn btn-login">
            </div>
        </form>
    </div>
</section>
<!-- end login -->
<?php
include('./layouts/footer.php');
?>