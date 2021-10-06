<?php
include('../Config/connect.php');
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: '.URL.'/admin/login.php');
    die();
}
if (isset($_GET['noOrder'])) {
    $noOrder = $_GET['noOrder'];
    unset($_GET['noOrder']);
} else {
    $_SESSION['error'] = 'Không lấy được thông tin đơn hàng.';
    header('location: ' . URL . 'admin/manager-order.php?filter=1');
    die();
}
$conn = connectToDatabase();
//get code admin
$sql = "SELECT MSNV FROM NhanVien WHERE UserName='$username'";
$codeAdmin = executeSQLResult($conn, $sql);
$codeAdmin = $codeAdmin[0]['MSNV'];
//update table ChiTietDonHang
$sql = "UPDATE ChiTietDatHang SET
            GiaDatHang=0,
            GiamGia=0
            WHERE SoDonDH=$noOrder";
$result = executeSQL($conn, $sql);
//update table DatHang
$sql = "UPDATE DatHang SET
            MSNV=$codeAdmin,
            TrangThaiDH='Bị huỷ'
            WHERE SoDonDH=$noOrder";
$result = executeSQL($conn, $sql);
unset($_POST['submit'], $_POST['dayShip'], $_POST['status']);
if (!$result) {
    $_SESSION['error'] = "Cập nhật đơn hàng không thành công";
    header('Location: ' . URL . 'admin/manager-order.php?noOrder=1');
} else {
    $_SESSION['status_order'] = "Cập nhật đơn hàng thành công";
    header('Location: ' . URL . '/admin/manager-order.php?filter=1');
}
closeConnect($conn);
?>
