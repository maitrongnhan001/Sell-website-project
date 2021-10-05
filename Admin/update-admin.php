<?php
include('./layouts/header.php');
//get data of admin
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = connectToDatabase();
    $sql = "SELECT * FROM NhanVien WHERE MSNV = $id";
    $result = executeSQLResult($conn, $sql);
    $HoVaTen = $result[0]['HoTenNV'];
    $UserName = $result[0]['UserName'];
    $Password = $result[0]['Password'];
    $ChucVu = $result[0]['ChucVu'];
    $DiaChi = $result[0]['DiaChi'];
    $SoDienThoai = $result[0]['SoDienThoai'];
    unset($_GET['id']);
} else {
    $_SESSION['error'] = 'Không lấy được thông tin nhân viên';
    header('Location: ' . URL . '/Admin/manager-admin.php');
}


function CheckPosition($value, $ChucVu)
{
    //check Position
    if ($ChucVu == $value) {
        echo "selected";
    }
}

?>
<section class="main">
    <div class="container">
        <h1 class="text-center">Cập nhật nhân viên</h1>
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
                <p><b>Họ và Tên</b></p>
                <input type="text" name="FullName" value="<?php echo $HoVaTen; ?>" required placeholder="Nhập họ và tên *" class="format-ip">
                <p id="nofi-1"></p>
            </div>
            <div class="group-input">
                <p><b>Tên tài khoản</b></p>
                <input type="text" name="UserName" value="<?php echo $UserName; ?>" placeholder="Nhập tên tài khoản  *" class="format-ip" required>
                <p id="nofi-2" class="red"></p>
            </div>
            <div class="group-input">
                <p><b>Mật khẩu</b></p>
                <input type="password" name="Password" placeholder="Nhập mật khẩu" class="format-ip">
                <p id="nofi-3"></p>
            </div>
            <div class="group-input">
                <p><b>Số điện thoại</b></p>
                <input type="number" name="Phone" value="<?php echo $SoDienThoai; ?>" required placeholder="Nhập số điện thoại *" class="format-ip">
                <p id="nofi-4" class="red"></p>
            </div>
            <div class="group-input">
                <p><b>Địa chỉ</b></p>
                <input type="text" name="Address" value="<?php echo $DiaChi; ?>" required placeholder="Nhập địa chỉ *" class="format-ip">
                <p id="nofi-5"></p>
            </div>
            <div class="group-input">
                <p><b>Chức vụ</b></p>
                <Select name="Position" class="format-ip">
                    <option value="Nhân viên" <?php CheckPosition("Nhân viên", $ChucVu) ?>>Nhân viên</option>
                    <option value="Quản lý" <?php CheckPosition("Quản lý", $ChucVu) ?>>Quản lý</option>
                    <option value="Thủ kho" <?php CheckPosition("Thủ kho", $ChucVu) ?>>Thủ kho</option>
                    <option value="Bán hàng" <?php CheckPosition("Bán hàng", $ChucVu) ?>>Bán hàng</option>
                </Select>
            </div>
            <div class="group-input">
                <input type="submit" id="update" value="Cập Nhật" name="submit" class="btn-primary">
            </div>
            <?php
            //update admin
            if (isset($_POST["submit"])) {
                //get value
                $HoVaTen = $_POST['FullName'];
                $UserName = $_POST['UserName'];
                $Password = (md5($_POST["Password"]) != $Password) ? md5($_POST["Password"]) : $Password;
                $SoDienThoai = $_POST["Phone"];
                $DiaChi = $_POST['Address'];
                $ChucVu = $_POST['Position'];
                
                $sql = "UPDATE NhanVien SET 
                    HoTenNV = '$HoVaTen',
                    UserName = '$UserName',
                    Password = '$Password',
                    ChucVu = '$ChucVu',
                    DiaChi = '$DiaChi',
                    SoDienThoai = '$SoDienThoai' 
                WHERE MSNV = $id;";
                
                $result = executeSQL($conn, $sql);

                unset($_POST['FullName'], $_POST['UserName'], $_POST['Password'], $_POST['Phone'], $_POST['Address'], $_POST['Position']);
                if ($result) {
                    //update successfully
                    $_SESSION['status_user'] = 'Cập nhật nhân viên thành công.';
                    header('Location: ' . URL . '/Admin/manager-admin.php');
                } else {
                    //update error
                    $_SESSION['status_user'] = 'Cập nhật nhân viên thất bại.';
                    header('Location: ' . URL . '/Admin/update-admin.php?id=' . $id);
                }
            }
            ?>
        </form>
    </div>
</section>
<?php
closeConnect($conn);
include('./layouts/footer.php');
?>