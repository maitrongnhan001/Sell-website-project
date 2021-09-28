<?php include('./layouts/header.php') ?>

<section class="main">
    <div class="container">
        <h1 class="text-center">Thêm danh mục</h1>
        <br>
        <form action="" method="POST">
            <?php
            //show nofication add admin error
            if (isset($_SESSION['status_user'])) {
                echo ("<br><div class='red'>" . $_SESSION['status_user'] . "</div>");
                unset($_SESSION['status_user']);
            }
            ?>
            <div class="group-input">
                <p>Họ và Tên</p>
                <input type="text" name="Name" required placeholder="Tên danh mục" class="format-ip">
                <p id="nofi-1"></p>
            </div>
            <div class="group-input">
                <p>Địa chỉ</p>
                <br>
                <div id="img-review"">
                    <p id="text-review-img">Chưa chọn ảnh nào</p>
                </div>
                <br>
                <label for="image-upload" class="input-file btn-secondary">
                    <input type="file" name="image" id="image-upload" required placeholder="Thêm hình ảnh">
                    Chọn ảnh
                </label>
                <p id="nofi-5"></p>
            </div>
            <div class="group-input">
                <input type="submit" id="register" value="Đăng ký" name="submit" class="btn-primary">
            </div>
        </form>
    </div>
</section>
<?php
if (isset($_POST['submit'])) {
    //get value of method post
    $FullName = trim($_POST['FullName']);
    $UserName = $_POST['UserName'];
    $Password = md5($_POST['Password']);
    $Phone = $_POST['Phone'];
    $Address = $_POST['Address'];
    $Position = $_POST['Position'];


    $sql = "INSERT INTO NhanVien (HoTenNV, UserName, Password, ChucVu, DiaChi, SoDienThoai) VALUES (
            '$FullName',
            '$UserName',
            '$Password',
            '$Position',
            '$Address',
            '$Phone')";

    //clear data
    unset($_POST['FullName'], $_POST['UserName'], $_POST['Password'], $_POST['Phone'], $_POST['Address'], $_POST['Position']);

    $conn = connectToDatabase();
    $result = executeSQL($conn, $sql);
    if ($result) {
        $_SESSION['status_user'] = 'Thêm nhân viên thành công.';
        header('Location: ' . URL . '/Admin/manager-admin.php');
    } else {
        $_SESSION['status_user'] = 'Thêm nhân viên thất bại.';
        header('Location: ' . URL . '/Admin/add-admin.php');
    }
}
?>

<?php include('./layouts/footer.php') ?>