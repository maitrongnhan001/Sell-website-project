<?php
include('./layouts/header.php');
include('../Debug/Debug.php');
if (isset($_SESSION['username'])) {
    $userName = $_SESSION['username'];
} else {
    $userName = $_SESSION['status'] = 'Vui lòng đăng nhập để sử dụng tính năng này.';
    header('location: ' . URL . 'Customer/login.php');
    die();
}
if (isset($_GET['id'])) {
    $codeProduct = $_GET['id'];
    //get data product
    $conn = connectToDatabase();
    $sql = "SELECT TenHH, Gia, SoLuongHang, TenHinh 
            FROM HangHoa, LoaiHangHoa, HinhHangHoa 
            WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang
            AND HangHoa.MSHH = HinhHangHoa.MSHH
            AND HangHoa.MSHH = $codeProduct";
    $product = executeSQLResult($conn, $sql);
    $nameProduct = $product[0]['TenHH'];
    $price = $product[0]['Gia'];
    $quality = $product[0]['SoLuongHang'];
    $pathImage = URL . 'images/products/' . $product[0]['TenHinh'];
}
?>

<section class="product-order">
    <div class="container">

        <h2 class="text-center text-white">Điền thông tin vào form này để mua hàng.</h2>
        <?php
        //check erorr
        if (isset($_SESSION['error'])) {
            echo "<div class='red text-center'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="" class="order" method="POST">
            <fieldset>
                <legend>Sản phẩm đã chọn</legend>

                <div class="product-menu-img">
                    <img src=<?php echo $pathImage; ?> alt="No Iamge" class="img-responsive img-curve">
                </div>

                <div class="product-menu-desc">
                    <div class="row">
                        <div class="clearfix">
                            <h3>
                                <?php echo $nameProduct; ?>
                            </h3>
                            <p class="product-price">
                                VNĐ: <?php echo $price ?>
                            </p>
                            <input type="hidden" id="pr" name="price" value="<?php echo $price; ?>">
                        </div>
                        <div class="clearfix total-container">
                            <h3>Tổng</h3>
                            <p class="product-price" id="rt">
                                VNĐ: <?php echo $price ?>
                            </p>
                        </div>
                    </div>

                    <div class="order-label">Số lượng</div>
                    <input type="number" id="ipn" name="qty" class="input-responsive" value="1" required>
                    <p class="red" id="nofi-1"></p>

                </div>

            </fieldset>
            <?php
            //get data user
            $sql = "SELECT KhachHang.MSKH, HoTenKH, SoDienThoai, MaDC, DiaChi 
                    FROM KhachHang, DiaChiKH 
                    WHERE KhachHang.MSKH = DiaChiKH.MSKH
                    AND KhachHang.UserName = '$userName'";

            $UserInfo = executeSQLResult($conn, $sql);
            $codeCustomer = $UserInfo[0]['MSKH'];
            $codeAddress = $UserInfo[0]['MaDC'];
            $nameCustomer = $UserInfo[0]['HoTenKH'];
            $phone = $UserInfo[0]['SoDienThoai'];
            $address = $UserInfo[0]['DiaChi'];
            ?>
            <fieldset>
                <legend>Thông tin liên lạc</legend>
                <div class="order-label">Tên người nhận</div>
                <input type="text" name="name-receive" value="<?php echo $nameCustomer; ?>" placeholder="Nhập tên người nhận *" class="input-responsive" required>

                <div class="order-label">Số điện thoại</div>
                <input type="tel" name="phone" value="<?php echo $phone; ?>" pattern="0[0-9]{9}" placeholder="Nhập số điện thoại người nhận *" class="input-responsive" required>

                <div class="order-label">Địa chỉ</div>
                <textarea name="address" rows="10" placeholder="Nhập địa chỉ nhận *" class="input-responsive" required><?php echo $address; ?></textarea>

                <input type="submit" name="submit" id="submit-order" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

    </div>
</section>

<?php
if (isset($_POST['submit'])) {
    //get data
    $qty = $_POST['qty'];
    //check qty
    if ($quality < $qty) {
        $_SESSION['error'] = "Đặt hàng không thành công";
        header('location: ' . URL . 'Customer/order.php?id=' . $codeProduct);
        unset($_POST['submit'], $_POST['price'], $_POST['qty'], $_POST['name-receive'], $_POST['phone'], $_POST['address']);
        die();
    }
    $total = $price * $qty;
    $nameReceive = $_POST['name-receive'];
    $phoneReceive = $_POST['phone'];
    $addressReceive = $_POST['address'];
    //check information of customer
    if (!($nameReceive == $nameCustomer && $phoneReceive == $phone)) {
        //update table KhachHang
        $sql = "UPDATE KhachHang
                SET HoTenKH = '$nameReceive', SoDienThoai = '$phoneReceive'
                WHERE MSKH = $codeCustomer";
        $result = executeSQL($conn, $sql);
        if (!$result) {
            $_SESSION['error'] = "Đặt hàng không thành công";
            header('location: ' . URL . 'Customer/order.php?id=' . $codeProduct);
            unset($_POST['submit'], $_POST['price'], $_POST['qty'], $_POST['name-receive'], $_POST['phone'], $_POST['address']);
            die();
        }
    }
    if (!($addressReceive == $address)) {
        //update table DiaChiKH
        $sql = "UPDATE DiaChiKH
                SET DiaChi = '$addressReceive'
                WHERE MaDC = $codeAddress";
        $result = executeSQL($conn, $sql);
        if (!$result) {
            $_SESSION['error'] = "Đặt hàng không thành công";
            header('location: ' . URL . 'Customer/order.php?id=' . $codeProduct);
            unset($_POST['submit'], $_POST['price'], $_POST['qty'], $_POST['name-receive'], $_POST['phone'], $_POST['address']);
            die();
        }
    }
    //store table DatHang
    date_default_timezone_set("VietNam/HoChiMinh");
    $date = getdate();
    $day = $date['mday'];
    $month = $date['mon'];
    $year = $date['year'];
    $DayOrder = "$year-$month-$day";
    $statusOrder = "Đặt hàng";
    $sql = "INSERT INTO DatHang (
        MSKH,
        NgayDH,
        TrangThaiDH
    ) VALUES (
        $codeCustomer,
        '$DayOrder',
        '$statusOrder'
    )";
    //get SoDonDH
    $result = executeSQL($conn, $sql);
    $codeOrder = $conn->insert_id;
    if (!$result) {
        $_SESSION['error'] = "Đặt hàng không thành công";
        header('location: ' . URL . 'Customer/order.php?id=' . $codeProduct);
        unset($_POST['submit'], $_POST['price'], $_POST['qty'], $_POST['name-receive'], $_POST['phone'], $_POST['address']);
        die();
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
        $codeProduct,
        $qty,
        $total,
        0
    )";
    $result = executeSQL($conn, $sql);
    if (!$result) {
        $_SESSION['error'] = "Đặt hàng không thành công";
        header('location: ' . URL . 'Customer/order.php?id=' . $codeProduct);
        unset($_POST['submit'], $_POST['price'], $_POST['qty'], $_POST['name-receive'], $_POST['phone'], $_POST['address']);
        die();
    }
    //update quality products
    $quality = $quality - $qty;
    $sql = "UPDATE HangHoa SET 
            SoLuongHang = $quality
            WHERE MSHH = $codeProduct";
    $result = executeSQL($conn, $sql);
    if (!$result) {
        $_SESSION['error'] = "Đặt hàng không thành công";
        header('location: ' . URL . 'Customer/order.php?id=' . $codeProduct);
        unset($_POST['submit'], $_POST['price'], $_POST['qty'], $_POST['name-receive'], $_POST['phone'], $_POST['address']);
        die();
    }
    //check success
    $_SESSION['status'] = "Đặt hàng thành công";
    header('location: ' . URL . 'Customer/');
    //unset data
    unset($_POST['submit'], $_POST['price'], $_POST['qty'], $_POST['name-receive'], $_POST['phone'], $_POST['address']);
}
closeConnect($conn);
include('./layouts/footer.php');
?>