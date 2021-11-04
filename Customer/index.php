<?php
include('./layouts/header.php');
include('./layouts/search.php');
if (isset($_SESSION['status'])) {
    echo "<h3 class='green text-center'>" . $_SESSION['status'] . "</h3>";
    unset($_SESSION['status']);
}
?>
<!-- Categories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Danh Mục</h2>
        <div class="container-category-center">
            <?php
            //get data categories
            $conn = connectToDatabase();
            $sql = "SELECT * FROM LoaiHangHoa LIMIT 3";
            $listCategories = executeSQLResult($conn, $sql);
            //render to display
            for ($i = 0; $i < count($listCategories); $i++) {
                $codeCategory = $listCategories[$i]['MaLoaiHang'];
                $nameCategory = $listCategories[$i]['TenLoaiHang'];
                $pathImageCategory = URL . 'images/categories/' . $listCategories[$i]['HinhAnh'];
            ?>
                <a href=<?php echo URL . '/Customer/category-products.php?codeCategory=' . $codeCategory; ?>>
                    <div class="box-3 float-container">

                        <img src=<?php echo $pathImageCategory; ?> width="330px" height="330px" alt="<?php echo $nameCategory; ?>" class="img-curve">
                        <h3 class="float-text white"><?php echo $nameCategory; ?></h3>
                    </div>
                </a>
            <?php
            }
            ?>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
<!-- Categories Section Ends Here -->


<!-- fOOD MEnu Section Starts Here -->
<section id="list-product-menu" class="product-menu">
    <div class="container">
        <h2 class="text-center">Sản Phẩm</h2>
        <?php
        //get data products
        $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, TenLoaiHang 
                FROM HangHoa, LoaiHangHoa 
                WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang LIMIT 6";
        $listProducts = executeSQLResult($conn, $sql);
        //render to display
        for ($i = 0; $i < count($listProducts); $i++) {
            $codeProduct = $listProducts[$i]['MSHH'];
            $nameProduct = $listProducts[$i]['TenHH'];
            $price = $listProducts[$i]['Gia'];
            $description = $listProducts[$i]['QuyCach'];

            //get image
            $sql = "SELECT * FROM HinhHangHoa WHERE MSHH = $codeProduct LIMIT 1";
            $result_image = executeSQLResult($conn, $sql);
            $image_name = $result_image[0]['TenHinh'];
            $pathImageProduct = URL . 'images/products/' . $image_name;

        ?>
            <div class="product-menu-box">
                <div class="product-menu-img">
                    <img src=<?php echo $pathImageProduct; ?> alt="<?php $nameProduct; ?>" class="img-responsive img-curve">
                </div>
                <div class="product-menu-desc">
                    <h4><?php echo $nameProduct; ?></h4>
                    <p class="product-price"><?php echo $price; ?></p>
                    <p class="product-detail"><?php echo $description; ?></p>
                    <br>

                    <a href=<?php echo URL . 'Customer/order.php?id=' . $codeProduct; ?> class="btn btn-primary">Mua ngay</a>
                </div>
            </div>
        <?php
        }
        ?>
        <div id="clearfix-load" class="clearfix"></div>
        <p id="load-product-index" class="text-center pink">Xem thêm sản phẩm</p>
    </div>
</section>
<?php
closeConnect($conn);
include('./layouts/footer.php');
?>