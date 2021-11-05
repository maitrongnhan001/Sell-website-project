<?php
ob_start();

include('./layouts/header.php');

//get id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    unset($_GET['id']);
} else {
    $_SESSION['error'] = 'Không lấy được dữ liệu hàng hoá';
    header('Location: ' . URL . 'Customer/index.php');
}
?>

<section class="main">
    <div class="container">
        <h2 class="text-center">Chi tiết sản phẩm</h2>
        <br>
        <?php
        //get product
        $conn = connectToDatabase();
        $sql = "SELECT * FROM HangHoa, LoaiHangHoa WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang 
                                                            AND MSHH = $id";
        $result_product = executeSQLResult($conn, $sql);

        $name = $result_product[0]['TenHH'];
        $description = $result_product[0]['QuyCach'];
        $price = $result_product[0]['Gia'];
        $Quatity = $result_product[0]['SoLuongHang'];
        $category = $result_product[0]['TenLoaiHang'];
        ?>
        <div class="img-details" id="img-review">
            <?php
            //get image
            $sql = "SELECT * FROM HinhHangHoa WHERE MSHH = $id";
            $result_image = executeSQLResult($conn, $sql);
            ?>
            <div class="slider-content">
                <div id='slider-img-review'>
                    <?php
                    for ($i = 0; $i < count($result_image); $i++) {
                        $pathImage = URL . 'images/products/' . $result_image[$i]['TenHinh'];
                        if ($i == 0) {
                    ?>
                            <img class="my-slides" id="img-<?php echo $i + 1; ?>" src="<?php echo $pathImage; ?>">
                        <?php
                            continue;
                        }
                        ?>
                        <img class="my-slides hide" width=470px height=310px id="img-<?php echo $i + 1; ?>" src="<?php echo $pathImage; ?>">
                    <?php
                    }
                    ?>
                </div>
                <div class="slider-control" id="list-btn-slides">
                    <?php
                    for ($i = 0; $i < count($result_image); $i++) {
                        $pathImage = URL . 'images/products/' . $result_image[$i]['TenHinh'];
                        if ($i == 0) {
                    ?>
                            <span class="btn-slider-small forcus" id="btn-<?php echo $i + 1; ?>"></span>
                        <?php
                            continue;
                        }
                        ?>
                        <span class="btn-slider-small" id="btn-<?php echo $i + 1; ?>"></span>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="info-product-details">
            <h2 class="text-center"><?php echo $name; ?></h2>
            <p><b>Giá: </b><?php echo $price; ?></p>
            <p><b>Danh mục: </b><?php echo $category; ?></p>
            <p><b>Số lượng còn lại: </b><?php echo $Quatity; ?></p>
            <?php
            //get amount order
            $sql = "SELECT COUNT(SoDonDH) AS DaBan FROM ChiTietDatHang WHERE MSHH = $id";
            $result_amount_order = executeSQLResult($conn, $sql);
            $amount_order = $result_amount_order[0]['DaBan'];
            ?> 
            <p><b>Đã bán: </b><?php echo $amount_order; ?></p>
            <br>
            <br>
            <div class="text-center">
                <a class="btn btn-primary" href="<?php echo URL . 'customer/order.php?id=' . $id; ?>">Mua hàng</a>
            </div>
        </div>
        <div class="clearfix"></div>
        <br><br><br>
        <div class="info-product-description">
            <h2 class="text-center">Mô tả sản phẩm</h2>
            <p>
                <?php echo $description; ?>
            </p>
        </div>
    </div>
</section>

<?php
include('./layouts/footer.php');

ob_end_flush();
?>