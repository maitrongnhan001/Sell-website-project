<?php
include('../Config/connect.php');
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: '.URL.'/Customer/login.php');
    die();
}
if (isset($_GET['noOrder'])) {
    $noOrder = $_GET['noOrder'];
    unset($_GET['noOrder']);
} else {
    $_SESSION['error'] = 'Không lấy được thông tin đơn hàng.';
    header('location: ' . URL . 'Customer/manager-order.php?filter=1');
    die();
}
$conn = connectToDatabase();
//update table DatHang
$sql = "UPDATE DatHang SET
            TrangThaiDH='Bị huỷ'
            WHERE SoDonDH=$noOrder";
$result = executeSQL($conn, $sql);
if (!$result) {
    $_SESSION['error'] = "Cập nhật đơn hàng không thành công";
    header('Location: ' . URL . 'Customer/manager-order.php?noOrder=1');
} else {
    $_SESSION['status_order'] = "Cập nhật đơn hàng thành công";
    header('Location: ' . URL . 'Customer/manager-order.php?filter=1');
}
closeConnect($conn);
?>
