<?php
ob_start();
include('./layouts/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    unset($_GET['id']);
} else {
    $_SESSION['error'] = 'Không lấy được dữ liệu hình ảnh';
    header('Location: ' . URL . 'admin/manager-products.php');
}
?>

<section class="main">
    <div class="container">
        <h1 class="text-center">Thêm hình</h1>
        <br>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="group-input" id="group-input-img">
                <p><b>Hình ảnh</b></p>
                <div id="img-review">
                    <?php
                    $conn = connectToDatabase();
                    $sql = "SELECT * FROM HinhHangHoa WHERE MaHinh = $id";
                    $result_image = executeSQLResult($conn, $sql);
                    $id_product = $result_image[0]['MSHH'];
                    $result_image = $result_image[0]['TenHinh'];
                    $pathImage = URL . 'images/products/' . $result_image;
                    ?>
                    <img id='img-show' class='format-img-review img-category' width=300px height=300px src=<?php echo $pathImage; ?>>
                </div>
                <br>
                <label for="image-upload" class="input-file btn-secondary">
                    <input type="file" name="Image-Product" id="image-upload" required placeholder="Thêm hình ảnh">
                    Chọn ảnh
                </label>
                <p id="nofi-5" class="red"></p>
            </div>
            <div class="group-input">
                <input type="submit" id="register" value="Thêm hình" name="submit" class="btn-primary">
            </div>
        </form>
    </div>
</section>

<?php
//check submit
if (isset($_POST['submit'])) {
    $image = $_FILES['Image-Product'];
    $imageName = $image['name'];

    //store image
    if ($imageName != "") {
        //random name product
        $extension = end(explode('.', $imageName));
        $imageName = 'product_' . rand(0000, 9999) . '.' . $extension;
        //delete image
        $delete = unlink('../images/products/' . $result_image);
        if (!$delete) {
            unset($_POST['submit'], $_POST['Image-Product']);
            $_SESSION['status-image'] = 'Cập nhật hình ảnh thất bại';
            header('Location: ' . URL . 'Admin/manager-image.php?id=' . $id_product);
            closeConnect($conn);
            die();
        }
        //store image
        $sourceFile = $_FILES['Image-Product']['tmp_name'];
        $pathImage = "../images/products/$imageName";
        $upload = move_uploaded_file($sourceFile, $pathImage);
        //check store success?
        if (!$upload) {
            unset($_POST['submit'], $_POST['Image-Product']);
            $_SESSION['status_product'] = 'Cập nhật sản phẩm thất bại';
            header('Location: ' . URL . 'Admin/manager-image.php?id=' . $id_product);
            closeConnect($conn);
            die();
        }
    } else {
        $imageName = "";
        unset($_POST['submit'], $_POST['Image-Product']);
        $_SESSION['status_product'] = 'Cập nhật sản phẩm thất bại';
        header('Location: ' . URL . 'Admin/manager-image.php?id=' . $id_product);
        closeConnect($conn);
        die();
    }

    //insert data to table HinhHangHoa
    if ($imageName != "") {
        $sql = "UPDATE HinhHangHoa SET
                    TenHinh = '$imageName',
                    MSHH = '$id_product'
                WHERE MaHinh = $id";
        $result = executeSQL($conn, $sql);

        //check insert
        if ($result) {
            $_SESSION['status-image'] = 'Cập nhật hình ảnh thành công';
            header('Location: ' . URL . 'Admin/manager-image.php?id=' . $id_product);
        }
    }
}

closeConnect($conn);
include('./layouts/footer.php');
ob_end_flush();
?>