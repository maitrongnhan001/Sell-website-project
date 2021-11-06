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
        <h1 class="text-center">Thêm sản phẩm</h1>
        <br>
        <form action="" method="POST" enctype="multipart/form-data" class="add-product">
            <?php
            //show nofication add admin error
            if (isset($_SESSION['status_product'])) {
                echo ("<br><div class='red'>" . $_SESSION['status_product'] . "</div>");
                unset($_SESSION['status_product']);
            }
            //get list category
            $conn = connectToDatabase();
            $sql = "SELECT MaLoaiHang, TenLoaiHang FROM LoaiHangHoa";
            $listCategories = executeSQLResult($conn, $sql);
            ?>
            <div class="col-info-product">
                <div class="group-input">
                    <p><b>Tên sản phẩm</b></p>
                    <input type="text" name="Name-Product" required placeholder="Tên sản phẩm *" class="format-ip">
                    <p id="nofi-1"></p>
                </div>
                <div class="group-input">
                    <p><b>Quy cách</b></p>
                    <textarea name="Description" id="" cols="30" rows="10" require placeholder="Quy cách *"></textarea>
                </div>
                <div class="group-input">
                    <p><b>Giá</b></p>
                    <input type="number" name="Price" id="price" required placeholder="Giá *" class="format-ip">
                    <p id="nofi-2" class="red"></p>
                </div>
                <div class="group-input">
                    <p><b>Số lượng</b></p>
                    <input type="number" name="Quality" id="quality" required placeholder="Số lượng *" class="format-ip">
                    <p id="nofi-3" class="red"></p>
                </div>
            </div>
            <div class="col-info-product">
                <div class="group-input">
                    <p><b>Danh mục</b></p>
                    <select name="Category" class="format-ip">
                        <?php
                        //display list category to screen
                        for ($i = 0; $i < count($listCategories); $i++) {
                            $codeCategory = $listCategories[$i]['MaLoaiHang'];
                            $nameCategory = $listCategories[$i]['TenLoaiHang'];
                            echo "<option value='$codeCategory'>$nameCategory</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="group-input" id="group-input-img">
                    <p><b>Hình ảnh</b></p>
                    <div id="img-review">
                        <p id="text-review-img">Chưa chọn ảnh nào</p>
                    </div>
                    <br>
                    <label for="image-upload" class="input-file btn-secondary">
                        <input type="file" name="Image-Product[]" id="image-upload" multiple="multiple" required placeholder="Thêm hình ảnh">
                        Chọn ảnh
                    </label>
                    <p id="nofi-5" class="red"></p>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="group-input">
                <input type="submit" id="register" value="Thêm sản phẩm" name="submit" class="btn-primary">
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
    $list_image = $_FILES['Image-Product'];

    //insert data to table HangHoa
    $sql = "INSERT INTO HangHoa (
        TenHH,
        QuyCach,
        Gia,
        SoLuongHang,
        MaLoaiHang
    ) VALUES (
        '$nameProduct',
        '$description',
        $price,
        $quality,
        $category
    )";
    $result = executeSQL($conn, $sql);

    //check store success?
    if (!$result) {
        unset($_POST['submit'], $_POST['Name-Product'], $_POST['Description'], $_POST['Price'], $_POST['Quality'], $_POST['Category'], $_FILES['Image-Product']['name']);
        $_SESSION['status_product'] = 'Thêm sản phẩm thất bại';
        header('Location: ' . URL . 'Admin/add-product.php');
        die();
    }

    //get MSHH for store image to database
    $MSHH = executeSQLResult($conn, "SELECT MSHH FROM HangHoa ORDER BY MSHH DESC LIMIT 1");
    $MSHH = $MSHH[0]['MSHH'];

    //store image
    $total_image = count($list_image['name']);

    for ($i = 0; $i < $total_image; $i++) {
        //get image name
        $imageName = $list_image['name'][$i];

        //random name product
        $extension = end(explode('.', $imageName));
        $imageName = 'product_' . rand(0000, 9999) . '.' . $extension;

        //store image
        $sourceFile = $list_image['tmp_name'][$i];
        $pathImage = "../images/products/$imageName";
        $upload = move_uploaded_file($sourceFile, $pathImage);

        //check store success?
        if (!$upload) {
            unset($_POST['submit'], $_POST['Name-Product'], $_POST['Description'], $_POST['Price'], $_POST['Quality'], $_POST['Category'], $_FILES['Image-Product']['name']);
            $_SESSION['status_product'] = 'Thêm sản phẩm thất bại';
            header('Location: ' . URL . 'Admin/add-product.php');
            die();
        }

        //insert data to table HinhHangHoa
        $sql = "INSERT INTO HinhHangHoa (
                                TenHinh,
                                MSHH
                            ) VALUES (
                                '$imageName',
                                '$MSHH'
                            )";
        $result = $result && executeSQL($conn, $sql);
    }
    //unset
    unset($_POST['submit'], $_POST['Name-Product'], $_POST['Description'], $_POST['Price'], $_POST['Quality'], $_POST['Category'], $_FILES['Image-Product']);

    //check insert data
    if ($result) {
        $_SESSION['status_product'] = 'Thêm sản phẩm thành công';
        header('Location: ' . URL . 'Admin/manager-products.php');
    } else {
        $_SESSION['status_product'] = 'Thêm sản phẩm thất bại';
        header('Location: ' . URL . 'Admin/add-product.php');
    }
}

closeConnect($conn);
include('./layouts/footer.php');
ob_end_flush();
?>