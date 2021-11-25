<?php
ob_start();
include('./layouts/header.php');

//check user is stocker
if (isset($_SESSION['position'])) {
    if ($_SESSION['position'] != "Bán hàng") {
        $_SESSION['error'] = "Bạn không có quyền sử dụng tính năng này";
        header('location: ' . URL . '/admin/manager-order.php?filter=1');
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
                <input type="text" name="name-product" disabled placeholder="Tên sản phẩm" class="format-ip">
            </div>
            <div class="group-input">
                <p><b>Số lượng</b></p>
                <input type="number" name="quatity" id="quality" value="1" required placeholder="Số lượng *" class="format-ip">
                <p id="nofi-3" class="error"></p>
            </div>
            <div class="group-input">
                <p><b>Giá</b></p>
                <input type="number" name="price" id="price" disabled  placeholder="Tổng giá" class="format-ip">
                <p id="nofi-2" class="red"></p>
            </div>
            <div class="group-input">
                <input type="submit" id="register" value="Thêm đơn hàng" name="submit" class="btn-primary">
            </div>
        </form>
    </div>
</section>
<?php
//function check result
function checkResult($result)
{
    if (!$result) {
        $_SESSION['error'] = "Mua hàng thất bại";
        header('Location: ' . URL . 'admin/add-order.php');
        unset($_POST['submit'],  $_POST['code-product'], $_POST['quatity']);
        die();
    }
}

if (isset($_POST['submit'])) {
    if (isset($_POST['submit'])) {
        //get data
        $code_product = $_POST['code-product'];
        $quatity = $_POST['quatity'];

        //get code admin
        $conn = connectToDatabase();
        $username = $_SESSION['username'];
        $sql = "SELECT MSNV FROM NhanVien WHERE UserName = '$username'";
        $result_admin = executeSQLResult($conn, $sql);
        $code_admin = $result_admin[0]['MSNV'];

        //get date 
        date_default_timezone_set("VietNam/HoChiMinh");
        $date = getdate();
        $day = $date['mday'];
        $month = $date['mon'];
        $year = $date['year'];
        $DayOrder = "$year-$month-$day";

        $statusOrder = "Đã giao";

        //add data to DatHang
        $sql = "INSERT INTO DatHang (
            MSNV,
            NgayDH,
            NgayGH,
            TrangThaiDH
        ) VALUES (
            $code_admin,
            '$DayOrder',
            '$DayOrder',
            '$statusOrder'
        )";

        $result = executeSQL($conn, $sql);
        checkResult($result);

        //get No.order
        $codeOrder = $conn->insert_id;

        //get total cost
        $sql = "SELECT Gia, SoLuongHang FROM HangHoa WHERE MSHH = $code_product";
        $result_product = executeSQLResult($conn, $sql);
        $total_quatity = $result_product[0]['SoLuongHang'];
        $price = $result_product[0]['Gia'];
        $total = $price * $quatity;

        //check quatity
        if ($quatity > $total_quatity) {
            checkResult(false);
        }

        //store table ChiTietDatHang
        $sql = "INSERT INTO ChiTietDatHang (
            SoDonDH,
            MSHH,
            SoLuong,
            GiaDatHang,
            GiamGia
        ) VALUES (
            $codeOrder,
            $code_product,
            $quatity,
            $total,
            0
        )";

        $result = executeSQL($conn, $sql);
        checkResult($result);

        //update data HangHoa
        $total_quatity = $total_quatity - $quatity;
        $sql = "UPDATE HangHoa SET 
                    SoLuongHang = $total_quatity
                    WHERE MSHH = $code_product";
        $result = executeSQL($conn, $sql);
        checkResult($result);

        if ($result) {
            $_SESSION['status_order'] = "Mua hàng thành công";
            header('Location: ' . URL . 'admin/manager-order.php');
        }
        //clear data
        unset($_POST['submit'],  $_POST['code-product'], $_POST['quatity']);
    }
}
?>
<?php
closeConnect($conn);
include('./layouts/footer.php');
ob_end_flush();
?>