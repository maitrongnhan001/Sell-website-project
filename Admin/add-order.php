<?php
ob_start();
include('./layouts/header.php');

//check user is stocker
if (isset($_SESSION['position'])) {
    if ($_SESSION['position'] == "Bán hàng") {
        $_SESSION['error'] = "Bạn không có quyền sử dụng tính năng này";
        header('location: ' . URL . '/admin/manager-products.php');
        die();
    }
} else {
    header('location: ' . URL . '/admin/login.php');
    die();
}
?>

<section class="main">
    <div class="container">
        <h1 class="text-center">Thêm đơn hàng</h1>
        <br>
        <form action="" method="POST" enctype="multipart/form-data">
            <?php
            //show nofication add admin error
            if (isset($_SESSION['status_product'])) {
                echo ("<br><div class='red'>" . $_SESSION['status_product'] . "</div>");
                unset($_SESSION['status_product']);
            }
            //get list category
            $conn = connectToDatabase();
            $sql = "SELECT MaLoaiHang, TenLoaiHang FROM LoaiHangHoa";
            $listCategories = executeSQLResult($conn, $sql);
            ?>
            <div class="group-input">
                <p><b>Mã sản phẩm</b></p>
                <input type="number" name="code-product" required placeholder="Mã sản phẩm *" class="format-ip">
                <p id="nofi-1"></p>
            </div>
            <div class="group-input">
                <p><b>Tên sản phẩm</b></p>
                <input type="text" name="name-product" required placeholder="Tên sản phẩm *" class="format-ip">
            </div>
            <div class="group-input">
                <p><b>Số lượng</b></p>
                <input type="number" name="quatity" id="quality" required placeholder="Số lượng *" class="format-ip">
                <p id="nofi-3" class="error"></p>
            </div>
            <div class="group-input">
                <p><b>Giá</b></p>
                <input type="number" name="Price" id="price" required placeholder="Giá *" class="format-ip">
                <p id="nofi-2" class="red"></p>
            </div>
            <div class="group-input">
                <input type="submit" id="register" value="Thêm đơn hàng" name="submit" class="btn-primary">
            </div>
        </form>
    </div>
</section>
<?php
if (isset($_POST['submit'])) {
    //function check result
    //get data
    //add data to DatHang
    //add data to ChiTietDatHang
    //update data HangHoa
}
?>
<?php
closeConnect($conn);
include('./layouts/footer.php');
ob_end_flush();
?>