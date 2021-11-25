<?php
ob_start();
include('./layouts/header.php');
include('../Debug/Debug.php');
if (isset($_SESSION['username_customer'])) {
    $userName = $_SESSION['username_customer'];
} else {
    $userName = $_SESSION['status'] = 'Vui lòng đăng nhập để sử dụng tính năng này.';
    header('location: ' . URL . 'Customer/login.php');
    die();
}
if (isset($_GET['id'])) {
    $codeProduct = $_GET['id'];
    //get data product
    $conn = connectToDatabase();
    $sql = "SELECT TenHH, Gia, SoLuongHang 
            FROM HangHoa, LoaiHangHoa 
            WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang
            AND HangHoa.MSHH = $codeProduct";
    $product = executeSQLResult($conn, $sql);
    $nameProduct = $product[0]['TenHH'];
    $price = $product[0]['Gia'];

    //format price
    $str_price = strval($price);
    $index = strlen($str_price) - 3;
    while ($index > 0) {
        $str_price = substr($str_price, 0, $index).",".substr($str_price,$index);
         $index = $index - 3;
    }

    $quality = $product[0]['SoLuongHang'];

    //get image
    $sql = "SELECT * FROM HinhHangHoa WHERE MSHH = $codeProduct LIMIT 1";
    $result_image = executeSQLResult($conn, $sql);
    $image_name = $result_image[0]['TenHinh'];
    $pathImage = URL . 'images/products/' . $image_name;
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
                                VNĐ: <?php echo $str_price ?>
                            </p>
                            <input type="hidden" id="pr" name="price" value="<?php echo $price; ?>">
                        </div>
                        <div class="clearfix total-container">
                            <h3>Tổng</h3>
                            <p class="product-price" id="rt">
                                VNĐ: <?php echo $str_price ?>
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
            $sql = "SELECT KhachHang.MSKH, HoTenKH, SoDienThoai 
                    FROM KhachHang 
                    WHERE KhachHang.UserName = '$userName'";

            $UserInfo = executeSQLResult($conn, $sql);
            $codeCustomer = $UserInfo[0]['MSKH'];
            $nameCustomer = $UserInfo[0]['HoTenKH'];
            $phone = $UserInfo[0]['SoDienThoai'];
            ?>
            <fieldset>
                <legend>Thông tin liên lạc</legend>
                <div class="order-label">Tên người nhận:</div>
                <input type="text" id="ipn" class="input-responsive" disabled value="<?php echo $nameCustomer; ?>" required>

                <div class="order-label">Số điện thoại:</div>
                <input type="text" id="ipn" class="input-responsive" disabled value="<?php echo $phone; ?>" required>

                <div class="group-address" id="group-current-address">
                    <div class="order-label">Chọn địa chỉ</div>
                    <?php
                    //get address
                    $sql = "SELECT * FROM DiaChiKH
                                WHERE MSKH=$codeCustomer";
                    $list_address = executeSQLResult($conn, $sql);
                    for ($i = 0; $i < count($list_address); $i++) {
                        $address = $list_address[$i]['DiaChi'];
                        $codeAddress = $list_address[$i]['MaDC'];
                    ?>
                        <p>
                            <input type="radio" name="address" value="<?php echo $codeAddress; ?>" required><span><?php echo $address; ?></span>
                        <div class="clearfix"></div>
                        </p>
                    <?php
                    }
                    ?>
                    <button class="btn btn-address-order" id="btn-new-address">Địa chỉ mới</button>
                </div>
                <div class="group-address hide" id="group-new-address">
                    <div class="order-label">Địa chỉ mới</div>
                    <input type="text" id="ipn-new-address" name="new-address" class="input-responsive">
                    <button class="btn btn-address-order" id="btn-current-address">Địa chỉ cũ</button>
                </div>

                <input type="submit" name="submit" id="submit-order" value="Mua hàng" class="btn btn-primary">
            </fieldset>

        </form>

    </div>
</section>

<?php
function CheckExecuteSQL($result, $codeProduct)
{
    //check sql execute success ???
    //if error then redirect order.php with code of product, after die process
    if (!$result) {
        $_SESSION['error'] = "Đặt hàng không thành công";
        header('location: ' . URL . 'Customer/order.php?id=' . $codeProduct);
        unset($_POST['submit'], $_POST['price'], $_POST['qty'], $_POST['name-receive'], $_POST['phone'], $_POST['address']);
        die();
    }
}

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

    //handle address
    if ($_POST['new-address'] != "") {
        //handle new address
        $new_address = $_POST['new-address'];
        $sql = "INSERT INTO DiaChiKH (
            DiaChi,
            MSKH
        ) VALUES (
            '$new_address',
            $codeCustomer
        )";
        $result = executeSQL($conn, $sql);
        CheckExecuteSQL($result, $codeProduct);

        //get code address
        $sql = "SELECT MAX(MaDC) AS MaDC FROM `DiaChiKH` WHERE MSKH=3";
        $code_address = executeSQLResult($conn, $sql);
        $code_address = $code_address[0]['MaDC'];
    } else {
        $code_address = $_POST['address'];
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
        TrangThaiDH,
        MaDC
    ) VALUES (
        $codeCustomer,
        '$DayOrder',
        '$statusOrder',
        $code_address
    )";

    //get SoDonDH
    $result = executeSQL($conn, $sql);
    $codeOrder = $conn->insert_id;
    CheckExecuteSQL($result, $codeProduct);

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
    CheckExecuteSQL($result, $codeProduct);

    //update quality products
    $quality = $quality - $qty;
    $sql = "UPDATE HangHoa SET 
            SoLuongHang = $quality
            WHERE MSHH = $codeProduct";
    $result = executeSQL($conn, $sql);
    CheckExecuteSQL($result, $codeProduct);

    //check success
    $_SESSION['status'] = "Đặt hàng thành công";
    header('location: ' . URL . 'Customer/');
    //unset data
    unset($_POST['submit'], $_POST['price'], $_POST['qty'], $_POST['name-receive'], $_POST['phone'], $_POST['address']);
}

closeConnect($conn);
include('./layouts/footer.php');
ob_end_flush();
?>