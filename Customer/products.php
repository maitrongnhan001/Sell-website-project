<?php
include('./layouts/header.php');
include('./layouts/search.php');
?>

<section id="list-product-menu" class="product-menu">
    <div class="container">
        <h2 class="text-center">Sản Phẩm</h2>
        <?php
        //get data products
        $conn = connectToDatabase();
        $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, TenLoaiHang 
                FROM HangHoa, LoaiHangHoa 
                WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang LIMIT 12";
        $listProducts = executeSQLResult($conn, $sql);
        //render to display
        for ($i = 0; $i < count($listProducts); $i++) {
            $codeProduct = $listProducts[$i]['MSHH'];
            $nameProduct = $listProducts[$i]['TenHH'];
            $price = $listProducts[$i]['Gia'];

            //format price
            $price = strval($price);
            $index = strlen($price) - 3;
            while ($index > 0) {
                $price = substr($price, 0, $index).",".substr($price,$index);
                 $index = $index - 3;
            }

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

                    <a href=<?php echo URL . 'Customer/product-details.php?id=' . $codeProduct; ?> class="btn btn-primary">Mua ngay</a>
                </div>
            </div>
        <?php
        }
        ?>
        <div id="clearfix-load" class="clearfix"></div>
        <p id="load-product" class="text-center pink">Xem thêm sản phẩm</p>
    </div>

</section>

<?php
closeConnect($conn);
include('./layouts/footer.php');
?>