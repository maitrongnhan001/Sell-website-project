<?php include('./layouts/header.php') ?>

<section class="main">
    <div class="container">
        <h1 class="text-center">Thêm nhân viên</h1>
        <br>
        <form action="" method="POST">
            <?php
            //show nofication add admin error
            if (isset($_SESSION['status_add_user'])) {
                echo ("<br><div class='red'>" . $_SESSION['status_add_user'] . "</div>");
                unset($_SESSION['status_add_user']);
            }
            ?>
            <div class="group-input">
                <p>Họ và Tên</p>
                <input type="text" name="FullName" required placeholder="Nhập họ và tên *" class="format-ip">
                <p id="nofi-1"></p>
            </div>
            <div class="group-input">
                <p>Tên tài khoản</p>
                <input type="text" name="UserName" placeholder="Nhập tên tài khoản  *" class="format-ip" required>
                <p id="nofi-2" class="red"></p>
            </div>
            <div class="group-input">
                <p>Mật khẩu</p>
                <input type="password" name="Password" required placeholder="Nhập mật khẩu *" class="format-ip">
                <p id="nofi-3"></p>
            </div>
            <div class="group-input">
                <p>Số điện thoại</p>
                <input type="number" name="Phone" required placeholder="Nhập số điện thoại *" class="format-ip">
                <p id="nofi-4" class="red"></p>
            </div>
            <div class="group-input">
                <p>Địa chỉ</p>
                <input type="text" name="Address" required placeholder="Nhập địa chỉ *" class="format-ip">
                <p id="nofi-5"></p>
            </div>
            <div class="group-input">
                <p>Chức vụ</p>
                <Select name="Position" class="format-ip">
                    <option value="Nhân viên">Nhân viên</option>
                    <option value="Quản lý">Quản lý</option>
                    <option value="Quản lý">Thủ kho</option>
                    <option value="Quản lý">Bán hàng</option>
                </Select>
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
    unset($FullName, $UserName, $Password, $Phone, $Address, $Position);

    $conn = connectToDatabase();
    $result = executeSQL($conn, $sql);
    if ($result) {
        $_SESSION['status_add_user'] = 'Thêm nhân viên thành công.';
        header('Location: ' . URL . '/Admin/manager-admin.php');
    } else {
        $_SESSION['status_add_user'] = 'Thêm nhân viên thất bại.';
        header('Location: ' . URL . '/Admin/add-admin.php');
    }
}
?>

<?php include('./layouts/footer.php') ?>