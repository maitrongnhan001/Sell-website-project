<?php include('./layouts/header.php') ?>

<section class="main">
    <div class="container">
        <h1 class="text-center">Cập nhật danh mục</h1>
        <br>
        <form action="" method="POST" enctype="multipart/form-data">
            <?php
            //show nofication add admin error
            if (isset($_SESSION['status_category'])) {
                echo ("<br><div class='red'>" . $_SESSION['status_category'] . "</div>");
                unset($_SESSION['status_category']);
            }
            ?>
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $conn = connectToDatabase();
                $sql = "SELECT * FROM LoaiHangHoa WHERE MaLoaiHang = $id";
                $result = executeSQLResult($conn, $sql);
                $nameCategory = $result[0]['TenLoaiHang'];
                $nameImage = $result[0]['HinhAnh'];
                $pathImage = URL.'images/categories/'.$nameImage;
            } else {
                $_SESSION['error'] = 'Không lấy được thông tin danh mục';
                header('Location: '.URL.'Admin/manager-categories.php');
            }
            ?>
            <div class="group-input">
                <p>Tên danh mục</p>
                <input type="text" name="Name-Category" value="<?php echo $nameCategory; ?>" required placeholder="Tên danh mục" class="format-ip">
                <p id="nofi-1"></p>
            </div>
            <div class="group-input">
                <p>Hình ảnh</p>
                <br>
                <div id="img-review">
                    <img id='img-show' class='format-img-review img-category' width=300px height=300px src=<?php echo $pathImage; ?> >
                </div>
                <br>
                <label for="image-upload" class="input-file btn-secondary">
                    <input type="file" name="Image-Category" id="image-upload" placeholder="Thêm hình ảnh">
                    Chọn ảnh
                </label>
                <p id="nofi-5"></p>
            </div>
            <div class="group-input">
                <input type="submit" id="register" value="Cập nhật danh mục" name="submit" class="btn-primary">
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
        $imageName = "food_category_".rand(0000, 9999).'.'.$extension;
        $sourceFile = $_FILES['Image-Category']['tmp_name'];
        $delete = unlink('../images/categories/'.$nameImage);
        if (!$delete) {
            unset($_POST['submit'],$_POST['Name-Category'], $_POST['Image-Category']);
            $_SESSION['status_category'] = 'Cập nhật danh mục sản phẩm thất bại';
            header('Location: '.URL.'Admin/add-category.php?id='.$id);
            die();
        }
        $pathImage = "../images/categories/$imageName";
        $upload = move_uploaded_file($sourceFile, $pathImage);
        //check image
        if (!$upload) {
            unset($_POST['submit'],$_POST['Name-Category'], $_POST['Image-Category']);
            $_SESSION['status_category'] = 'Cập nhật danh mục sản phẩm thất bại';
            header('Location: '.URL.'Admin/add-category.php?id='.$id);
            die();
        }
    } else {
        $imageName = "";
    }
    
    //update category to database
    $conn = connectToDatabase();
    $sql = ($imageName != "") ? "UPDATE LoaiHangHoa SET 
        TenLoaiHang='$nameCategory', 
        HinhAnh='$imageName'
    WHERE MaLoaiHang = $id" : "UPDATE LoaiHangHoa SET 
        TenLoaiHang='$nameCategory'
    WHERE MaLoaiHang = $id";

    $result = executeSQL($conn, $sql);

    if ($result) {
        $_SESSION['status_category'] = 'Cập nhật danh mục sản phẩm thành công';
        header('Location: '.URL.'Admin/manager-categories.php');
    } else {
        $_SESSION['status_category'] = 'Cập nhật danh mục sản phẩm thất bại';
        header('Location: '.URL.'Admin/update-category.php?id='.$id);
    }

    unset($_POST['submit'],$_POST['Name-Category'], $_POST['Image-Category']);
}
?>

<?php include('./layouts/footer.php') ?>