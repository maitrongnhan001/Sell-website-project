<?php
include('./layouts/header.php');
include('./layouts/search.php');
?>

<!-- Categories Section Starts Here -->
<section id="list-categories" class="categories">
    <div class="container">
        <h2 class="text-center">Danh Mục</h2>
        <div class="container-category-center">
            <?php
            //get data categories
            $conn = connectToDatabase();
            $sql = "SELECT * FROM LoaiHangHoa LIMIT 6";
            $listCategories = executeSQLResult($conn, $sql);
            //render to display
            for ($i = 0; $i < count($listCategories); $i++) {
                $codeCategory = $listCategories[$i]['MaLoaiHang'];
                $nameCategory = $listCategories[$i]['TenLoaiHang'];
                $pathImageCategory = URL . 'images/categories/' . $listCategories[$i]['HinhAnh'];
            ?>
                <a href=<?php echo URL . '/Customer/category-products.php?codeCategory='.$codeCategory; ?>>
                    <div class="box-3 float-container">

                        <img src=<?php echo $pathImageCategory; ?> width="330px" height="330px" alt="<?php echo $nameCategory; ?>" class="img-curve">
                        <h3 class="float-text white"><?php echo $nameCategory; ?></h3>
                    </div>
                </a>
            <?php
            }
            ?>
            <div id="clearfix-load" class="clearfix"></div>
            <p class="text-center pink" id="load-categories">Xem thêm danh mục</p>
        </div>
    </div>
</section>
<!-- Categories Section Ends Here -->
<?php
closeConnect($conn);
include('./layouts/footer.php');
?>