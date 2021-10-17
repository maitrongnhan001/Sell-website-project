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

//get code customer
$conn = connectToDatabase();
$sql = "SELECT MSKH FROM KhachHang WHERE UserName = '$username'";
$result = executeSQLResult($conn, $sql);
if (count($result) > 0) {
    $code_customer = $result[0]['MSKH'];
} else {
    $_SESSION["error"] = "Lấy thông tin không thành công";
    header('location: ' . URL . 'Customer/manager-address.php');
    die();
}
?>

<!-- login -->
<section class="login">
    <div class="container">
        <h1 class="text-center">Cập nhật địa chỉ</h1>
        <form action="" method="POST">
            <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='red text-center'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            }
            ?>
            <div class="input-login">
                <b>Địa chỉ</b>
                <input type="text" name="new-address" class="input-responsive" required placeholder="Nhâp địa chỉ *">
            </div>
            <div class="text-center">
                <input type="submit" name="submit" value="Thêm địa chỉ" class="btn btn-login">
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
    $sql = "INSERT INTO DiaChiKH 
            (DiaChi, MSKH) VALUES 
            ('$new_address', $code_customer)";
    $result = executeSQL($conn, $sql);

    //check execute
    if ($result) {
        unset($_POST['new-address']);
        $_SESSION["success"] = "Cập nhật địa chỉ thành công";
        header('location: ' . URL . 'Customer/manager-address.php');
    } else {
        unset($_POST['new-address']);
        $_SESSION["error"] = "Cập nhật địa chỉ không thành công";
        header('location: ' . URL . 'Customer/add-address.php');
    }
}
include('./layouts/footer.php');
ob_end_flush();
?>