<?php
include('./layouts/header.php');
?>
<!-- login -->
<section class="login">
    <div class="container">
        <h1 class="text-center">Đăng nhập</h1>
        <form action="" method="POST">
            <?php
            if (isset($_SESSION['status'])) {
                echo "<div class='red text-center'>".$_SESSION['status']."</div>";
                unset($_SESSION['status']);
            }
            ?>
            <div class="input-login">
                Tên đăng nhập
                <input type="text" name="username" class="input-responsive" require placeholder="Nhâp tên tài khoản *">
                Mật khẩu
                <input type="password" name="password" class="input-responsive" require placeholder="Nhập mật khẩu *">
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
            if ($_SESSION['error']) {
                echo "<div class='red text-center'>".$_SESSION['error']."</div>";
                unset($_SESSION['error']);
            }
            ?>
            <div class="text-center">
                <input type="submit" name="submit" value="Đăng nhập" class="btn btn-login">
            </div>
        </form>
    </div>
</section>

<!-- end login -->
<?php
$conn = connectToDatabase();
if (isset($_POST['submit'])) {
    //get data
    $userName = $conn->real_escape_string($_POST['username']);
    $password = md5($conn->real_escape_string($_POST['password']));
    //login
    $sql = "SELECT UserName FROM KhachHang WHERE UserName = '%s' AND Password = '%s'";
    $sql = sprintf($sql, $userName, $password);
    $userName = executeSQLResult($conn, $sql);
    if (count($userName) == 1) {
        $userName = $userName[0]['UserName'];
        $_SESSION['username'] = $userName;
        header('location: '.URL.'Customer');
    } else {
        $_SESSION['error'] = "Tài khoản hoặc mật khẩu không đúng.";
        header('location: '.URL.'/Customer/login.php');
    }
    //clear data and connnect
    unset($_POST['submit'], $_POST['username'], $_POST['password']);
    closeConnect($conn);
    //redirect
}
include('./layouts/footer.php');
?>