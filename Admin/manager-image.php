<?php 
ob_start();
include('./layouts/header.php');
//get id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    unset($_GET['id']);
} else {
    $_SESSION['error'] = 'Không lấy được dữ liệu';
    header('Location: ' . URL . 'Admin/manager-products.php');
}
?>

<section class="main text-content">
    <div class="container">
        <h1>Quản lý sản phẩm</h1>
        <br>
        <a href=<?php echo URL . "admin/add-image.php?id=$id"; ?> class="btn-200 btn-primary">Thêm hình</a>
        <?php
        //show nofication add admin successfully
        if (isset($_SESSION['status-image'])) {
            echo ("<br><div class='green'>" . $_SESSION['status-image'] . "</div>");
            unset($_SESSION['status_product']);
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
                <th>Tên ảnh</th>
                <th>Hình ảnh</th>
                <th>Quản lý</th>
            </tr>
            <?php
            //get list images
            $conn = connectToDatabase();
            $sql = "SELECT * FROM `HinhHangHoa` WHERE MSHH=$id";
            $listImages = executeSQLResult($conn, $sql);
            for ($i = 1; $i <= count($listImages); $i++) {
                $id_image = $listImages[$i - 1]['MaHinh'];
                $image_name = $listImages[$i - 1]['TenHinh'];
                $path_image = URL.'images/products/'.$image_name;
                if ($i % 2 == 0) {
            ?>
                        <tr class="text-center">
                            <td><?php echo $i; ?></td>
                            <td class="name-product"><?php echo $image_name; ?></td>
                            <td><a href=<?php echo $path_image; ?>><img src=<?php echo $path_image; ?> width="400px" alt="No image" class="img-category"></a></td>
                            <td>
                                <a href=<?php echo URL . "admin/update-image-product.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                                <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=3"; ?> class="btn-danger">Xoá</a>
                                <div class="clear-fix"></div>
                            </td>
                        </tr>
                    <?php
                    } else {
                    ?>
                        <tr class="white text-center">
                            <td><?php echo $i; ?></td>
                            <td class="name-product"><?php echo $image_name; ?></td>
                            <td><a href=<?php echo $path_image; ?>><img src=<?php echo $path_image; ?> width="400px" alt="No image" class="img-category"></a></td>
                            <td>
                                <a href=<?php echo URL . "admin/update-image-product.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                                <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=3"; ?> class="btn-danger">Xoá</a>
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
include('./layouts/footer.php'); 
ob_end_flush();
?>