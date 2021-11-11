<?php include('./layouts/header.php') ?>

<section class="main">
    <div class="container">
        <h1>Thống kê cửa hàng</h1>
        <?php
        //get data
        $conn = connectToDatabase();
        $sql = "SELECT count(MSNV) AS AmountAdmin FROM NhanVien";
        $result = executeSQLResult($conn, $sql);
        $AmountAdmin = $result[0]['AmountAdmin'];

        $sql = "SELECT count(MSHH) AS AmountProducts FROM HangHoa";
        $result = executeSQLResult($conn, $sql);
        $AmountProducts = $result[0]['AmountProducts'];

        $sql = "SELECT count(MaLoaiHang) AS AmountCategories FROM LoaiHangHoa";
        $result = executeSQLResult($conn, $sql);
        $AmountCategories = $result[0]['AmountCategories'];

        $sql = "SELECT sum(GiaDatHang) AS TotalSales FROM ChiTietDatHang";
        $result = executeSQLResult($conn, $sql);
        $TotalSales = $result[0]['TotalSales'];
        ?>
        <div class="row">
            <div class="item-details text-center">
                <h1><?php echo $AmountAdmin; ?></h1>
                Nhân viên
            </div>
            <div class="item-details text-center">
                <h1><?php echo $AmountCategories; ?></h1>
                Danh mục
            </div>
            <div class="item-details text-center">
                <h1><?php echo $AmountProducts; ?></h1>
                Sản phẩm
            </div>
            <div class="item-details text-center">
                <h1><?php echo $TotalSales; ?></h1>
                Tổng doanh thu
            </div>
        </div>
        <h1>Thống kê đơn hàng</h1>
        <?php
        //get data
        $sql = "SELECT count(SoDonDH) AS AmountOrder FROM DatHang";
        $result = executeSQLResult($conn, $sql);
        $AmountOrder = $result[0]['AmountOrder'];

        $sql = "SELECT count(SoDonDH) AS AmountNewOrder FROM DatHang WHERE TrangThaiDH='Đặt hàng'";
        $result = executeSQLResult($conn, $sql);
        $AmountNewOrder = $result[0]['AmountNewOrder'];

        $sql = "SELECT count(SoDonDH) AS AmountOrderShiping FROM DatHang WHERE TrangThaiDH='Đang giao'";
        $result = executeSQLResult($conn, $sql);
        $AmountOrderShiping = $result[0]['AmountOrderShiping'];

        $sql = "SELECT count(SoDonDH) AS AmountOrderSuccess FROM DatHang WHERE TrangThaiDH='Đã giao'";
        $result = executeSQLResult($conn, $sql);
        $AmountOrderSuccess = $result[0]['AmountOrderSuccess'];

        $sql = "SELECT count(SoDonDH) AS AmountOrderCancel FROM DatHang WHERE TrangThaiDH='Bị huỷ'";
        $result = executeSQLResult($conn, $sql);
        $AmountOrderCancel = $result[0]['AmountOrderCancel'];
        ?>
        <div class="row">
            <div class="item-details text-center">
                <h1><?php echo $AmountOrder; ?></h1>
                Đơn Hàng
            </div>
            <div class="item-details text-center">
                <h1><?php echo $AmountNewOrder; ?></h1>
                Đã đặt
            </div>
            <div class="item-details text-center">
                <h1><?php echo $AmountOrderShiping; ?></h1>
                Đang giao
            </div>
            <div class="item-details text-center">
                <h1><?php echo $AmountOrderSuccess; ?></h1>
                Đã giao
            </div>
            <div class="item-details text-center">
                <h1><?php echo $AmountOrderCancel; ?></h1>
                Bị huỷ
            </div>
        </div>
    </div>
</section>
<?php include('./layouts/footer.php') ?>