<?php
ob_start();
include('./layouts/header.php');

//check user is sale
if (isset($_SESSION['position'])) {
    if ($_SESSION['position'] != "Bán hàng") {
        $_SESSION['error'] = "Bạn không có quyền sử dụng tính năng này";
        header('location: '.URL.'/admin/manager-order.php?filter=1');
        die();
    }
} else {
    header('location: '.URL.'/admin/login.php');
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
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
} else {
    $filter = 1;
}
?>

<section class="main">
    <div class="container">
        <h1 class="text-center">Cập nhật đơn hàng</h1>
        <br>
        <?php
        if (isset($_SESSION['status_order'])) {
            echo "<div class='red text-center'>" . $_SESSION['status_order'] . "</div><br>";
            unset($_SESSION['status_order']);
        }
        ?>
        <form action="" method="POST" id="form-updade-order">
            <?php
            //get data
            $conn = connectToDatabase();
            //check code admin
            $sql = "SELECT MSNV FROM DatHANG WHERE SoDonDH=$noOrder";
            $codeAdmin = executeSQLResult($conn, $sql);
            $codeAdmin = $codeAdmin[0]['MSNV'];
            if ($codeAdmin == null) {
                $sql = "SELECT A.SoDonDH, B.HoTenKH, B.SoDienThoai, B.TenCongTy, B.SoFax, D.DiaChi, F.MSHH, F.TenHH, F.Gia, H.TenLoaiHang, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang
                        FROM ((DatHang AS A LEFT JOIN KhachHang AS B ON A.MSKH = B.MSKH) LEFT JOIN DiaChiKH AS D ON A.MaDC = D.MaDC ), ChiTietDatHang AS E, HangHoa AS F, LoaiHangHoa AS H
                        WHERE A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND F.MaLoaiHang = H.MaLoaiHang
                        AND A.SoDonDH = $noOrder";
                $order = executeSQLResult($conn, $sql);

                $adminUpdate = "Chưa cập nhật";
            } else {
                $sql = "SELECT A.SoDonDH, B.HoTenKH, B.SoDienThoai, B.TenCongTy, B.SoFax, D.DiaChi, F.MSHH, F.TenHH, F.Gia, H.TenLoaiHang, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, C.HoTenNV
                        FROM ((DatHang AS A LEFT JOIN KhachHang AS B ON A.MSKH = B.MSKH) LEFT JOIN DiaChiKH AS D ON A.MaDC = D.MaDC ), NhanVien AS C, ChiTietDatHang AS E, HangHoa AS F, LoaiHangHoa AS H
                        WHERE A.MSNV = C.MSNV
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND F.MaLoaiHang = H.MaLoaiHang
                        AND A.SoDonDH = $noOrder";
                $order = executeSQLResult($conn, $sql);

                $adminUpdate = $order[0]['HoTenNV'];
            }

            $nameCustomer = $order[0]['HoTenKH'];
            $phone = $order[0]['SoDienThoai'];
            $fax = $order[0]['SoFax'];
            $company = $order[0]['TenCongTy'];
            $address = $order[0]['DiaChi'];

            $codeProduct = $order[0]['MSHH'];
            $nameProduct = $order[0]['TenHH'];
            $price = $order[0]['Gia'];
            $category = $order[0]['TenLoaiHang'];

            $discount = $order[0]['GiamGia'];
            $dayOrder = $order[0]['NgayDH'];
            $dayShip = $order[0]['NgayGH'];
            $status = $order[0]['TrangThaiDH'];

            $quality = $order[0]['SoLuong'];
            $total = $order[0]['GiaDatHang'];

            //get image
            $sql = "SELECT * FROM HinhHangHoa WHERE MSHH = $codeProduct LIMIT 1";
            $result_image = executeSQLResult($conn, $sql);
            $image_name = $result_image[0]['TenHinh'];
            $pathImage = URL . 'images/products/' . $image_name;
            ?>
            <div class="statis-info">
                <h4>Thông tin khách hàng:</h4>
                <div class="group-info">
                    <p><b>Tên khách hàng:</b> <?php echo $nameCustomer; ?> </p>
                    <p><b>Số điện thoại:</b> <?php echo $phone; ?> </p>
                    <p><b>Số fax:</b> <?php echo $fax; ?> </p>
                    <p><b>Công ty:</b> <?php echo $company; ?> </p>
                    <p><b>Địa chỉ:</b> <?php echo $address; ?> </p>
                </div>
                <h4>Thông tin sản phẩm:</h4>
                <div class="group-info">
                    <p><b>Mã sảm phẩm:</b> <?php echo $codeProduct; ?> </p>
                    <p><b>Tên sản phẩm:</b> <?php echo $nameProduct; ?> </p>
                    <p><b>Hình ảnh:</b></p><?php echo "<img class='img-category' width='250px' height='250px' src=" . $pathImage . " alt='noImage'>" ?>
                    <p><b>Giá:</b> <?php echo $price ?> </p>
                    <p><b>Loại sản phẩm:</b> <?php echo $category; ?> </p>
                </div>
            </div>
            <h4>Thông tin đơn hàng:</h4>
            <div class="dynamic-info">
                <div class="group-info">
                    <p><b>Số đơn hàng:</b> <?php echo $noOrder ?> </p>
                </div>
                <div class="group-input">
                    <b>Giảm giá:</b>
                    <input type="number" name="discount" class="format-ip" value="<?php echo $discount; ?>" required>
                    <p class="red" id="nofi-1"></p>
                </div>
                <div class="group-input">
                    <p><b>Ngày đặt hàng:</b> <?php echo $dayOrder; ?> </p>
                    <input type="hidden" name="dayOrder" class="format-ip" value="<?php echo $dayOrder; ?>">
                    <br>
                    <b>Ngày giao hàng:</b><?php echo $dateShip; ?>
                    <input type="date" name="dayShip" class="format-ip" value="<?php echo $dateShip; ?>" required>
                    <p class="red" id="nofi-2"></p>
                </div>
                <div class="group-input">
                    <b>Trạng thái:</b>
                    <select class="format-ip" name="status">
                        <option value="Đặt hàng" <?php if ($status == 'Đặt hàng') {
                                                        echo "selected";
                                                    } ?>>Đặt hàng</option>
                        <option value="Đang giao" <?php if ($status == 'Đang giao') {
                                                        echo "selected";
                                                    } ?>>Đang giao</option>
                        <option value="Đã giao" <?php if ($status == 'Đã giao') {
                                                    echo "selected";
                                                } ?>>Đã giao</option>
                        <option value="Bị huỷ" <?php if ($status == 'Bị huỷ') {
                                                    echo "selected";
                                                } ?>>Huỷ đơn</option>
                    </select>
                </div>
                <div class="group-info">
                    <p><b>Nhân viên cập nhật:</b> <?php echo $adminUpdate; ?> </p>
                    <p><b>Số lượng:</b> <?php echo $quality; ?> </p>
                    <p><b>Tổng:</b> <?php echo $total; ?> </p>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="group-input">
                <input type="submit" id="update-order" value="Cập nhật đơn hàng" name="submit" class="btn-primary">
            </div>
            <?php
            if (isset($_POST['submit'])) {
                //get data
                $discount = $_POST['discount'];
                $dayShip = $_POST['dayShip'];
                $status = $_POST['status'];
                $total = $total - $discount;
                $username = $_SESSION['username'];

                //check day order
                if (strtotime($dateShip) < strtotime($dayOrder)) {
                    $_SESSION['status_order'] = "Cập nhật đơn hàng không thành công";
                    header('Location: ' . URL . 'admin/update-order.php?noOrder=' . $noOrder);
                }

                //check status is cancel
                if ($status == 'Bị huỷ') {
                    header('Location: '.URL.'admin/cancel-order.php?noOrder='.$noOrder);
                    die();
                }

                //update table ChiTietDatHang
                $sql = "UPDATE ChiTietDatHang SET
                        GiaDatHang=$total,
                        GiamGia=$discount
                        WHERE SoDonDH=$noOrder";
                $result = executeSQL($conn, $sql);
                //get code admin
                $sql = "SELECT MSNV FROM NhanVien WHERE UserName='$username'";
                $codeAdmin = executeSQLResult($conn, $sql);
                $codeAdmin = $codeAdmin[0]['MSNV'];
                //update table DatHang
                $sql = "UPDATE DatHang SET
                        MSNV=$codeAdmin,
                        NgayGH='$dayShip',
                        TrangThaiDH='$status'
                        WHERE SoDonDH=$noOrder";
                $result = $result && executeSQL($conn, $sql);
                unset($_POST['submit'], $_POST['dayShip'], $_POST['status']);
                if (!$result) {
                    $_SESSION['status_order'] = "Cập nhật đơn hàng không thành công";
                    header('Location: ' . URL . 'admin/update-order.php?noOrder=' . $noOrder);
                } else {
                    $_SESSION['status_order'] = "Cập nhật đơn hàng thành công";
                    header('Location: ' . URL . '/admin/manager-order.php?filter=' . $filter);
                }
            }
            ?>
        </form>
    </div>
</section>
<?php
closeConnect($conn);
include('./layouts/footer.php');
ob_end_flush();
?>