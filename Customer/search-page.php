<?php
include('./layouts/header.php');
include('./layouts/search.php');
if (isset($_GET['search'])) {
    $valueSearch = $_GET['search'];
    //search from database
    $conn = connectToDatabase();
    $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, TenLoaiHang 
                FROM HangHoa, LoaiHangHoa 
                WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang";
    $listProducts = executeSQLResult($conn, $sql);
    /*
    listProductSearch is all result search
    listProductsName is reuslt search by name product
    */
    $listProductsSearch = array();
    $listProductsName = array();

    //search by name
    $array_search = str_split($valueSearch);
    for ($i = count($array_search); $i > 0; $i--) {
        $str_child = substr($valueSearch, 0, $i);
        for ($j = 0; $j < count($listProducts); $j++) {
            if (strpos($listProducts[$j]['TenHH'], $str_child)) {
                array_push($listProductsName, $j);
            }
        }
    }
    $listProductsSearch = array_unique($listProductsName);
    unset($_GET['search']);
}
?>


<section class="product-menu">
    <div class="container">
        <h2 class="text-center">Products Menu</h2>
        <?php
        //render to display
        foreach($listProductsSearch as $index) {
            $codeProduct = $listProducts[$index]['MSHH'];
            $nameProduct = $listProducts[$index]['TenHH'];
            $price = $listProducts[$index]['Gia'];
            $description = $listProducts[$index]['QuyCach'];

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

    </div>
    <div class="clearfix"></div>
    </div>

    <p class="text-center">
        <a href="#" class="pink">See All Foods</a>
    </p>

</section>

<?php
closeConnect($conn);
include('./layouts/footer.php');
?>