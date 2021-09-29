<?php include('./layouts/header.php') ?>

<section class="main text-content">
    <div class="container">
        <h1>Quản lý danh mục sản phẩm</h1>
        <br>
        <a href=<?php echo URL . "admin/add-category.php"; ?> class="btn-200 btn-primary">Thêm danh mục</a>
        <?php
        //show nofication add admin successfully
        if (isset($_SESSION['status_category'])) {
            echo ("<br><div class='green'>" . $_SESSION['status_category'] . "</div>");
            unset($_SESSION['status_category']);
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
                <th>Tên danh mục</th>
                <th>Hình ảnh</th>
                <th>Quản lý</th>
            </tr>
            <?php
            //get data of category
            $conn = connectToDatabase();
            $sql = "SELECT * FROM LoaiHangHoa";
            $listCategories = executeSQLResult($conn, $sql);
            for ($i = 1; $i <= count($listCategories); $i++) {
                $id = $listCategories[$i - 1]['MaLoaiHang'];
                $NameCategory = $listCategories[$i - 1]['TenLoaiHang'];
                $pathImage = URL . 'images/categories/' . $listCategories[$i - 1]['HinhAnh'];
                if ($i % 2 == 0) {
            ?>
                    <tr class="text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $NameCategory; ?></td>
                        <td><a href=<?php echo $pathImage; ?>><img src=<?php echo $pathImage; ?> width="100px" height="100px" alt="No image" class="img-category"></a></td>
                        <td>
                            <a href=<?php echo URL . "admin/update-category.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                            <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=2"; ?> class="btn-danger">Xoá</a>
                            <div class="clear-fix"></div>
                        </td>
                    </tr>
                <?php
                } else {
                ?>
                    <tr class="white text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $NameCategory; ?></td>
                        <td><a href=<?php echo $pathImage; ?>><img src=<?php echo $pathImage; ?> width="100px" height="100px" alt="No image" class="img-category"></a></td>
                        <td>
                            <a href=<?php echo URL . "admin/update-category.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                            <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=2"; ?> class="btn-danger">Xoá</a>
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