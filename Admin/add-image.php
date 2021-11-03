<?php
ob_start();
include('./layouts/header.php');
?>
<?php
if (isset($_GET['id'])) {
    $MSHH = $_GET['id'];
    unset($_GET['id']);
} else {
    $_SESSION['error'] = 'Không lấy được dữ liệu hình ảnh';
    header('Location: '.URL.'admin/manager-products.php');
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
                    <p id="text-review-img">Chưa chọn ảnh nào</p>
                </div>
                <br>
                <label for="image-upload" class="input-file btn-secondary">
                    <input type="file" name="Image-Product[]" id="image-upload" multiple="multiple" required placeholder="Thêm hình ảnh">
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
    $list_image = $_FILES['Image-Product'];

    //store image
    $total_image = count($list_image['name']);
    $result = true;

    //open connection to database
    $conn = connectToDatabase();
    
    //count amount image
    $sql = "SELECT COUNT(MaHinh) AS SoLuong FROM HinhHangHoa WHERE MSHH = $MSHH";
    echo $sql;
    $amount_image = executeSQLResult($conn, $sql);
    $amount_image = $amount_image[0]['SoLuong'];

    //check amount
    if ($amount_image + $total_image >= 6 ) {
        $_SESSION['error'] = 'Số lượng hình ảnh không được lớn hơn 6';
        header('Location: '.URL.'admin/manager-image.php?id='.$MSHH);
    }

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

    if ($result) {
        $_SESSION['status-image'] = 'Thêm hình ảnh thành công';
        header('Location: '.URL.'admin/manager-image.php?id='.$MSHH);
    } else {
        $_SESSION['error'] = 'Thêm hình ảnh không thành công';
        header('Location: '.URL.'admin/manager-image.php?id='.$MSHH);
    }

    //clear data and close connecting database
    unset($_POST['submit'], $_FILES['Image-Product']);
    closeConnect($conn);
}

include('./layouts/footer.php');
ob_end_flush();
?>