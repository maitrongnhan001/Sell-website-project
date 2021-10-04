<?php 
include('./layouts/header.php');
if (isset($_GET['noOrder'])) {
    $noOrder = $_GET['noOrder'];
    unset($_GET['noOrder']);
} else {
    $_SESSION['error'] = 'Không lấy được thông tin đơn hàng.';
    header('location: '.URL.'admin/manager-order.php?filter=1');
}
?>

<section class="main">
    <div class="container">
        <h1 class="text-center">Cập nhật đơn hàng</h1>
        <br>
    </div>
<?php
closeConnect($conn);
include('./layouts/footer.php') ?>