<?php
include('./layouts/header.php');
include('./layouts/search.php');
?>

<!-- fOOD MEnu Section Starts Here -->
<section class="product-menu">
    <div class="container">
        <h2 class="text-center">Sản Phẩm</h2>
        <?php
        //get data products
        $conn = connectToDatabase();
        $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, TenLoaiHang, TenHinh 
                FROM HangHoa, LoaiHangHoa, HinhHangHoa 
                WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang
                        AND HangHoa.MSHH = HinhHangHoa.MSHH LIMIT 6";
        $listProducts = executeSQLResult($conn, $sql);
        //render to display
        for ($i = 0; $i < count($listProducts); $i++) {
            $codeProduct = $listProducts[$i]['MSHH'];
            $nameProduct = $listProducts[$i]['TenHH'];
            $price = $listProducts[$i]['Gia'];
            $description = $listProducts[$i]['QuyCach'];
            $pathImageProduct = URL . 'images/products/' . $listProducts[$i]['TenHinh'];
            //start in odd
            if ($i % 2 == 0) {
        ?>
                <div class="row">
                    <div class="product-menu-box">
                        <div class="product-menu-img">
                            <img src=<?php echo $pathImageProduct; ?> alt="<?php $nameProduct; ?>" class="img-responsive img-curve">
                        </div>
                        <div class="product-menu-desc">
                            <h4><?php echo $nameProduct; ?></h4>
                            <p class="product-price"><?php echo $price ?></p>
                            <p class="product-detail"><?php echo $description; ?></p>
                            <br>

                            <a href=<?php echo URL.'Customer/order.php?id='.$codeProduct; ?> class="btn btn-primary">Mua ngay</a>
                        </div>
                    </div>
                    <?php
                    if ($i == count($listProducts) - 1) {
                    ?>
                        <div class="clearfix"></div>

                </div>
            <?php
                    }
                }
                if ($i % 2 != 0) {
            ?>
            <div class="product-menu-box">
                <div class="product-menu-img">
                    <img src=<?php echo $pathImageProduct; ?> alt="<?php $nameProduct; ?>" class="img-responsive img-curve">
                </div>
                <div class="product-menu-desc">
                    <h4><?php echo $nameProduct; ?></h4>
                    <p class="product-price"><?php echo $price ?></p>
                    <p class="product-detail"><?php echo $description; ?></p>
                    <br>

                    <a href=<?php echo URL.'Customer/order.php?id='.$codeProduct; ?> class="btn btn-primary">Mua ngay</a>
                </div>
            </div>

            <div class="clearfix"></div>

    </div>

<?php
                }
            }
?>

<p class="text-center">
    <a href="#" class="pink">Xem thêm sản phẩm</a>
</p>

</section>

<?php 
closeConnect($conn);
include('./layouts/footer.php'); 
?>