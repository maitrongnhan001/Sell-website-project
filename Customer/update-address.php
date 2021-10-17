<?php
ob_start();
include('./layouts/header.php');
//check login
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: ' . URL . 'Customer/login.php');
    die();
}

//get code address
if (isset($_GET['code_address'])) {
    $code_address = $_GET['code_address'];
} else {
    $_SESSION['error'] = "Không lấy được dữ liệu";
    header('location: '.URL.'Customer/manager-address.php');
    die();
}
?>

<!-- login -->
<section class="login">
    <div class="container">
        <h1 class="text-center">Cập nhật địa chỉ</h1>
        <form action="" method="POST">
            <?php
            if (isset($_SESSION['status_address'])) {
                echo "<div class='red text-center'>".$_SESSION['ststatus_addressatus']."</div>";
                unset($_SESSION['status_address']);
            }

            //get address customer
            $conn = connectToDatabase();
            $sql = "SELECT * FROM DiaChiKH WHERE MaDC=$code_address";
            $address = executeSQLResult($conn, $sql);
            $address = $address[0]['DiaChi'];
            ?>
            <div class="input-login">
                <b>Địa chỉ</b>
                <input type="text" name="new-address" class="input-responsive" value="<?php echo $address; ?>" required placeholder="Nhâp địa chỉ *">
            </div>
            <div class="text-center">
                <input type="submit" name="submit" value="Cập nhật" class="btn btn-login">
            </div>
        </form>
    </div>
</section>

<!-- end login -->
<?php
//update address
if ($_POST['submit']) {
    //get data
    $new_address = $_POST['new-address'];
    
    //update
    $sql = "UPDATE DiaChiKH SET DiaChi='$new_address' WHERE MaDC=$code_address";
    $result = executeSQL($conn, $sql);

    //check execute
    if ($result) {
        unset($_POST['new-address']);
        $_SESSION["success"] = "Cập nhật địa chỉ thành công";
        header('location: '.URL.'Customer/manager-address.php');
    } else {
        unset($_POST['new-address']);
        $_SESSION["error"] = "Cập nhật địa chỉ không thành công";
        header('location: '.URL.'Customer/update-address.php');
    }
}
include('./layouts/footer.php');
ob_end_flush();
?>