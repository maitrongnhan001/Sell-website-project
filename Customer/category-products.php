<?php
include('./layouts/header.php');
if (isset($_GET['codeCategory'])) {
    $id = $_GET['codeCategory'];
    //get category name
    $conn = connectToDatabase();
    $sql = "SELECT TenLoaiHang FROM LoaiHangHoa WHERE MaLoaiHang = $id";
    $nameCategory = executeSQLResult($conn, $sql);
    $nameCategory = $nameCategory[0]['TenLoaiHang'];
    $_SESSION['search'] = 'Kết quả cho "' . $nameCategory . '"';
} else {
    header('location: ' . URL . 'Customer/');
}
include('./layouts/search.php');
?>

<section id="list-product-menu" class="product-menu">
    <div class="container">
        <h2 class="text-center">Sản Phẩm</h2>
        <?php
        //get data products
        $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, TenLoaiHang 
                FROM HangHoa, LoaiHangHoa 
                WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang
                        AND HangHoa.MaLoaiHang = $id LIMIT 6";
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
        <div class="clearfix"></div>
        <p class="text-center">
            <a href="#" class="pink">Xem thêm sản phẩm</a>
        </p>
    </div>

</section>

<?php
closeConnect($conn);
unset($_GET['codeCategory']);
include('./layouts/footer.php');
?>