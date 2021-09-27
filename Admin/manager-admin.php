<?php include('./layouts/header.php') ?>

<section class="main text-content">
    <div class="container">
        <h1>Quản lý nhân viên</h1>
        <br>
        <a href=<?php echo URL . "admin/add-admin.php"; ?> class="btn-200 btn-primary">Thêm nhân viên</a>
        <?php
        //show nofication add admin successfully
        if (isset($_SESSION['status_user'])) {
            echo ("<br><div class='green'>" . $_SESSION['status_user'] . "</div>");
            unset($_SESSION['status_user']);
        }
        if (isset($_SESSION['error'])) {
            echo ("<br><div class='red'>" . $_SESSION['error'] . "</div>");
            unset($_SESSION['error']);
        }
        ?>
        <br><br>
        <table class="tbl-manager">
            <tr>
                <th>STT</th>
                <th>Họ và Tên</th>
                <th>Chức vụ</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Quản lý</th>
            </tr>
            <?php
            //get data admin
            $conn = connectToDatabase();
            $sql = "SELECT * FROM NhanVien";
            $listAdmin = executeSQLResult($conn, $sql);
            for ($i = 1; $i <= count($listAdmin); $i++) {
                //show data admin to screen
                if ($i % 2 == 0) {
                    //gray
                    $id = $listAdmin[$i-1]['MSNV'];
                    $hoVaTen = $listAdmin[$i - 1]['HoTenNV'];
                    $chucVu = $listAdmin[$i - 1]['ChucVu'];
                    $diaChi = $listAdmin[$i - 1]['DiaChi'];
                    $soDienThoai = $listAdmin[$i - 1]['SoDienThoai'];
            ?>
                    <tr class="text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $hoVaTen; ?></td>
                        <td><?php echo $chucVu; ?></td>
                        <td><?php echo $diaChi; ?></td>
                        <td><?php echo $soDienThoai; ?></td>
                        <td>
                            <a href=<?php echo URL."admin/update-admin.php?id=".$id; ?> class="btn-primary">Cập nhật</a>
                            <a href=<?php echo URL."admin/delete-item.php?id=".$id."&type=1"; ?> class="btn-danger">Xoá</a>
                            <div class="clear-fix"></div>
                        </td>
                    </tr>
            <?php
                } else {
                    //white
                    $id = $listAdmin[$i-1]['MSNV'];
                    $hoVaTen = $listAdmin[$i - 1]['HoTenNV'];
                    $chucVu = $listAdmin[$i - 1]['ChucVu'];
                    $diaChi = $listAdmin[$i - 1]['DiaChi'];
                    $soDienThoai = $listAdmin[$i - 1]['SoDienThoai'];
            ?>
                    <tr class="white text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $hoVaTen; ?></td>
                        <td><?php echo $chucVu;?></td>
                        <td><?php echo $diaChi; ?></td>
                        <td><?php echo $soDienThoai; ?></td>
                        <td>
                            <a href=<?php echo URL."admin/update-admin.php?id=".$id; ?> class="btn-primary">Cập nhật</a>
                            <a href=<?php echo URL."admin/delete-item.php?id=".$id."&type=1"; ?> class="btn-danger">Xoá</a>
                            <div class="clear-fix"></div>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>

    </div>
</section>

<?php 
closeConnect($conn);
include('./layouts/footer.php') ?>