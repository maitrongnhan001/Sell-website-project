<?php include('./layouts/header.php') ?>

<section class="main">
    <div class="container">
        <h1 class="text-center">Cập nhật sản phẩm</h1>
        <br>
        <form action="" method="POST" enctype="multipart/form-data">
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
            $pathImage = URL . 'images/products/' . $products[0]['TenHinh'];
            ?>

            <div class="group-input">
                <p>Tên sản phẩm</p>
                <input type="text" name="Name-Product" value="<?php echo $nameProduct; ?>" required placeholder="Tên sản phẩm *" class="format-ip">
                <p id="nofi-1"></p>
            </div>
            <div class="group-input">
                <p>Quy cách</p>
                <textarea name="Description" id="" cols="30" rows="10" require placeholder="Quy cách *"><?php echo $description; ?></textarea>
            </div>
            <div class="group-input">
                <p>Giá</p>
                <input type="number" name="Price" id="price" value="<?php echo $price; ?>" required placeholder="Giá *" class="format-ip">
                <p id="nofi-2" class="red"></p>
            </div>
            <div class="group-input">
                <p>Số lượng</p>
                <input type="number" name="Quality" id="quality" value="<?php echo $quality; ?>" required placeholder="Số lượng *" class="format-ip">
                <p id="nofi-3" class="red"></p>
            </div>
            <div class="group-input">
                <p>Danh mục</p>
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
            <div class="group-input">
                <p>Hình ảnh</p>
                <br>
                <div id="img-review">
                    <img id='img-show' class='format-img-review img-category' width=300px height=300px src=<?php echo $pathImage; ?>>
                </div>
                <br>
                <label for="image-upload" class="input-file btn-secondary">
                    <input type="file" name="Image-Product" id="image-upload" required placeholder="Thêm hình ảnh">
                    Chọn ảnh
                </label>
                <p id="nofi-5"></p>
            </div>
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
    $imageName = $_FILES['Image-Product']['name'];
    //store image
    if ($imageName != "") {
        //random name product
        $extension = end(explode('.', $imageName));
        $imageName = 'product_' . rand(0000, 9999) . '.' . $extension;
        //delete image
        $delete = unlink('../images/products/'.$products[0]['TenHinh']);
        if (!$delete) {
            unset($_POST['submit'], $_POST['Name-Product'], $_POST['Description'], $_POST['Price'], $_POST['Quality'], $_POST['Category'], $_FILES['Image-Product']['name']);
            $_SESSION['status_product'] = 'Cập nhật sản phẩm thất bại';
            header('Location: ' . URL . 'Admin/update-product.php?id=' . $id);
            die();
        }
        //store image
        $sourceFile = $_FILES['Image-Product']['tmp_name'];
        $pathImage = "../images/products/$imageName";
        $upload = move_uploaded_file($sourceFile, $pathImage);
        //check store success?
        if (!$upload) {
            unset($_POST['submit'], $_POST['Name-Product'], $_POST['Description'], $_POST['Price'], $_POST['Quality'], $_POST['Category'], $_FILES['Image-Product']['name']);
            $_SESSION['status_product'] = 'Cập nhật sản phẩm thất bại';
            header('Location: ' . URL . 'Admin/update-product.php?id=' . $id);
            die();
        }
    } else {
        $imageName = "";
    }
    //insert data to table HangHoa
    $sql = "UPDATE HangHoa SET
                TenHH = '$nameProduct',
                QuyCach = '$description',
                Gia = $price,
                SoLuongHang = $quality,
                MaLoaiHang = $codeCategory
            WHERE MSHH = $id";
    $result = executeSQL($conn, $sql);
    //insert data to table HinhHangHoa
    if ($imageName != "") {
        $sql = "UPDATE HinhHangHoa SET
                    TenHinh = '$imageName',
                    MSHH = '$category'
                WHERE MaHinh = $codeImage";
        $result = $result && executeSQL($conn, $sql);
    }
    //unset
    unset($_POST['submit'], $_POST['Name-Product'], $_POST['Description'], $_POST['Price'], $_POST['Quality'], $_POST['Category'], $_FILES['Image-Product']['name']);
    //check insert data
    if ($result) {
        $_SESSION['status_product'] = 'Cập nhật sản phẩm thành công';
        header('Location: ' . URL . 'Admin/manager-products.php');
    } else {
        $_SESSION['status_product'] = 'Cập nhật phẩm thất bại';
        header('Location: ' . URL . 'Admin/update-product.php?id='.$id);
    }
}
?>
<?php
closeConnect($conn);
include('./layouts/footer.php') ?>