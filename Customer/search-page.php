<?php
include('./layouts/header.php');
include('./layouts/search.php');
if (isset($_GET['search'])) {
    $valueSearch = $_GET['search'];
    //search from database
    $conn = connectToDatabase();
    $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, TenLoaiHang, TenHinh 
                FROM HangHoa, LoaiHangHoa, HinhHangHoa 
                WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang
                AND HangHoa.MSHH = HinhHangHoa.MSHH";
    $listProducts = executeSQLResult($conn, $sql);
    /*
    listProductSearch is all result search
    listProductsId is result search by id
    listProductsName is reuslt search by name product
    listProductsCategory is result search by name category
    */
    $listProductsSearch = array();
    $listProductsId = array();
    $listProductsName = array();
    $listProductsCategory = array();
    for ($i = 0; $i < count($listProducts); $i++) {
        //search id
        $id = (int) filter_var($valueSearch, FILTER_SANITIZE_NUMBER_INT);
        if ($id == $listProducts[$i]['MSHH']) {
            array_push($listProductsId, $i);
        }
        //search name product
        if (strcasecmp($valueSearch, $listProducts[$i]['TenHH']) == 0) {
            array_push($listProductsName, $i);
        }
        //search name category
        if (strcasecmp($valueSearch, $listProducts[$i]['TenLoaiHang']) == 0) {
            array_push($listProductsCategory, $i);
        }
    }
    $listProductsSearch = array_merge($listProductsId, $listProductsName, $listProductsCategory);
}
?>

<!-- fOOD MEnu Section Starts Here -->
<section class="product-menu">
    <div class="container">
        <h2 class="text-center">Products Menu</h2>
        <?php
        //render to display
        for ($i = 0; $i < count($listProductsSearch); $i++) {
            $index = $listProductsSearch[$i];
            $codeProduct = $listProducts[$index]['MSHH'];
            $nameProduct = $listProducts[$index]['TenHH'];
            $price = $listProducts[$index]['Gia'];
            $description = $listProducts[$index]['QuyCach'];
            $pathImageProduct = URL . 'images/products/' . $listProducts[$index]['TenHinh'];
            //start in odd
            if ($codeProduct != $listProducts[$i - 1]['MSHH']) {

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