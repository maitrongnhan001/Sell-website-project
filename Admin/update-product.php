<?php
ob_start();
include('./layouts/header.php');

//check user is stocker
if (isset($_SESSION['position'])) {
    if ($_SESSION['position'] == "Bán hàng") {
        $_SESSION['error'] = "Bạn không có quyền sử dụng tính năng này";
        header('location: ' . URL . '/admin/manager-products.php');
        die();
    }
} else {
    header('location: ' . URL . '/admin/login.php');
    die();
}
?>

<section class="main">
    <div class="container">
        <h1 class="text-center">Cập nhật sản phẩm</h1>
        <br>
        <form action="" method="POST" enctype="multipart/form-data" class="add-product">
            <?php
            //show nofication add admin error
            if (isset($_SESSION['status_product'])) {
                echo ("<br><div class='red'>" . $_SESSION['status_product'] . "</div>");
                unset($_SESSION['status_product']);
            }
            //get id
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            } else {
                $_SESSION['error'] = 'Không có dữ liệu';
                header('Location: ' . URL . 'Admin/manager-products.php');
            }
            //get data for product
            $conn = connectToDatabase();
            $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, SoLuongHang, HangHoa.MaloaiHang, MaHinh, TenHinh 
                    FROM HangHoa, HinhHangHoa, LoaiHangHoa 
                    WHERE HangHoa.MSHH = HinhHangHoa.MSHH AND LoaiHangHoa.MaLoaiHang = HangHoa.MaLoaiHang AND HangHoa.MSHH = $id;";
            $products = executeSQLResult($conn, $sql);
            $nameProduct = $products[0]['TenHH'];
            $description = $products[0]['QuyCach'];
            $price = $products[0]['Gia'];
            $quality = $products[0]['SoLuongHang'];
            $category = $products[0]['MaloaiHang'];
            $codeImage = $products[0]['MaHinh'];
            ?>
            <div class="col-info-product">
                <div class="group-input">
                    <p><b>Tên sản phẩm</b></p>
                    <input type="text" name="Name-Product" value="<?php echo $nameProduct; ?>" required placeholder="Tên sản phẩm *" class="format-ip">
                    <p id="nofi-1"></p>
                </div>
                <div class="group-input">
                    <p><b>Quy cách</b></p>
                    <textarea name="Description" id="" cols="30" rows="10" require placeholder="Quy cách *"><?php echo $description; ?></textarea>
                </div>
                <div class="group-input">
                    <p><b>Giá</b></p>
                    <input type="number" name="Price" id="price" value="<?php echo $price; ?>" required placeholder="Giá *" class="format-ip">
                    <p id="nofi-2" class="red"></p>
                </div>
                <div class="group-input">
                    <p><b>Số lượng</b></p>
                    <input type="number" name="Quality" id="quality" value="<?php echo $quality; ?>" required placeholder="Số lượng *" class="format-ip">
                    <p id="nofi-3" class="red"></p>
                </div>
            </div>
            <div class="col-info-product">
                <div class="group-input">
                    <p><b>Danh mục</b></p>
                    <select name="Category" class="format-ip">
                        <?php
                        //get list category
                        $sql = "SELECT MaLoaiHang, TenLoaiHang FROM LoaiHangHoa";
                        $listCategories = executeSQLResult($conn, $sql);
                        //display list category to screen
                        for ($i = 0; $i < count($listCategories); $i++) {
                            $codeCategory = $listCategories[$i]['MaLoaiHang'];
                            $nameCategory = $listCategories[$i]['TenLoaiHang'];
                            //check category is select
                            if ($codeCategory == $category) {
                                echo "<option value='$codeCategory' selected>$nameCategory</option>";
                            } else {
                                echo "<option value='$codeCategory'>$nameCategory</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="group-input" id="group-input-img">
                    <p><b>Hình ảnh</b></p>
                    <br>
                    <div id="img-review">
                        <div class="slider-content">
                            <div id='slider-img-review'>
                                <?php
                                for ($i = 0; $i < count($products); $i++) {
                                    $pathImage = URL . 'images/products/' . $products[$i]['TenHinh'];
                                    if ($i == 0) {
                                ?>
                                        <img class="my-slides" width=470px height=310px id="img-<?php echo $i + 1; ?>" src="<?php echo $pathImage; ?>">
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
                                for ($i = 0; $i < count($products); $i++) {
                                    $pathImage = URL . 'images/products/' . $products[$i]['TenHinh'];
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
                    <br>
                    <a href="<?php echo URL.'admin/update-image.php' ?>" class="btn-secondary" id="btn-update-image">Cập nhật hình</a>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="group-input">
                <input type="submit" id="register" value="Cập nhật sản phẩm" name="submit" class="btn-primary">
            </div>
        </form>
    </div>
</section>
<?php
if (isset($_POST['submit'])) {
    //add catagory to database
    //get data
    $nameProduct = $_POST['Name-Product'];
    $description = $_POST['Description'];
    $price = $_POST['Price'];
    $quality = $_POST['Quality'];
    $category = $_POST['Category'];
    
    //insert data to table HangHoa
    $sql = "UPDATE HangHoa SET
                TenHH = '$nameProduct',
                QuyCach = '$description',
                Gia = $price,
                SoLuongHang = $quality,
                MaLoaiHang = $codeCategory
            WHERE MSHH = $id";
    $result = executeSQL($conn, $sql);
    //unset
    unset($_POST['submit'], $_POST['Name-Product'], $_POST['Description'], $_POST['Price'], $_POST['Quality'], $_POST['Category'], $_FILES['Image-Product']['name']);
    //check insert data
    if ($result) {
        $_SESSION['status_product'] = 'Cập nhật sản phẩm thành công';
        header('Location: ' . URL . 'Admin/manager-products.php');
    } else {
        $_SESSION['status_product'] = 'Cập nhật phẩm thất bại';
        header('Location: ' . URL . 'Admin/update-product.php?id=' . $id);
    }
}
?>
<?php
closeConnect($conn);
include('./layouts/footer.php');
ob_end_flush();
?>