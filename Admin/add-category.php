<?php include('./layouts/header.php') ?>

<section class="main">
    <div class="container">
        <h1 class="text-center">Thêm danh mục</h1>
        <br>
        <form action="" method="POST" enctype="multipart/form-data">
            <?php
            //show nofication add admin error
            if (isset($_SESSION['status_category'])) {
                echo ("<br><div class='red'>" . $_SESSION['status_category'] . "</div>");
                unset($_SESSION['status_category']);
            }
            ?>
            <div class="group-input">
                <p><b>Tên danh mục</b></p>
                <input type="text" name="Name-Category" required placeholder="Tên danh mục" class="format-ip">
                <p id="nofi-1"></p>
            </div>
            <div class="group-input">
                <p><b>Hình ảnh</b></p>
                <br>
                <div id="img-review">
                    <p id="text-review-img">Chưa chọn ảnh nào</p>
                </div>
                <br>
                <label for="image-upload" class="input-file btn-secondary">
                    <input type="file" name="Image-Category" id="image-upload" required placeholder="Thêm hình ảnh">
                    Chọn ảnh
                </label>
                <p id="nofi-5"></p>
            </div>
            <div class="group-input">
                <input type="submit" id="register" value="Thêm danh mục" name="submit" class="btn-primary">
            </div>
        </form>
    </div>
</section>
<?php
if (isset($_POST['submit'])) {
    //get value of method post
    $nameCategory = $_POST['Name-Category'];
    //check and store file
    if ($_FILES['Image-Category']['name'] != "") {
        $imageName = $_FILES['Image-Category']['name'];
        //get extension of out image (.jpg, .png, ...)
        $extension = end(explode('.', $imageName));
        //render the name image
        $imageName = "category_".rand(0000, 9999).'.'.$extension;
        $sourceFile = $_FILES['Image-Category']['tmp_name'];
        $pathImage = "../images/categories/$imageName";
        $upload = move_uploaded_file($sourceFile, $pathImage);
        //check image
        if (!$upload) {
            unset($_POST['submit'],$_POST['Name-Category'], $_POST['Image-Category']);
            $_SESSION['status_category'] = 'Thêm danh mục sản phẩm thất bại';
            header('Location: '.URL.'Admin/add-category.php');
            die();
        }
    } else {
        $imageName = "";
    }
    
    //insert category to database
    $conn = connectToDatabase();
    $sql = "INSERT INTO LoaiHangHoa (
        TenLoaiHang,
        HinhAnh
    ) VALUES (
        '$nameCategory',
        '$imageName'
    )";

    $result = executeSQL($conn, $sql);

    if ($result) {
        $_SESSION['status_category'] = 'Thêm danh mục sản phẩm thành công';
        header('Location: '.URL.'Admin/manager-categories.php');
    } else {
        $_SESSION['status_category'] = 'Thêm danh mục sản phẩm thất bại';
        header('Location: '.URL.'Admin/add-category.php');
    }

    unset($_POST['submit'],$_POST['Name-Category'], $_POST['Image-Category']);
    closeConnect($conn);
}
?>

<?php include('./layouts/footer.php') ?>