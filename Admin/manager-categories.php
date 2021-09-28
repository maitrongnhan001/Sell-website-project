<?php include('./layouts/header.php') ?>

<section class="main text-content">
    <div class="container">
        <h1>Quản lý danh mục sản phẩm</h1>
        <br>
        <a href=<?php echo URL . "admin/add-category.php"; ?> class="btn-200 btn-primary">Thêm danh mục</a>
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
                <th>Tên danh mục</th>
                <th>Hình ảnh</th>
                <th>Quản lý</th>
            </tr>
            <tr class="white text-center">
                <td>1</td>
                <td>Bánh gì đó</td>
                <td><a href="../images//categories/Food_Category_530.jpg"><img src="../images//categories/Food_Category_530.jpg" width="100px" height="100px" alt="No image" class="img-category"></a></td>
                <td>
                    <a href=<?php echo URL . "admin/update-admin.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                    <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=1"; ?> class="btn-danger">Xoá</a>
                    <div class="clear-fix"></div>
                </td>
            </tr>
            <tr class="text-center">
                <td>1</td>
                <td>Bánh gì đó</td>
                <td><a href="../images//categories/Food_Category_530.jpg"><img src="../images//categories/Food_Category_530.jpg" width="100px" height="100px" alt="No image" class="img-category"></a></td>
                <td>
                    <a href=<?php echo URL . "admin/update-admin.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                    <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=1"; ?> class="btn-danger">Xoá</a>
                    <div class="clear-fix"></div>
                </td>
            </tr>
            <tr class="white text-center">
                <td>1</td>
                <td>Bánh gì đó</td>
                <td><a href="../images//categories/Food_Category_530.jpg"><img src="../images//categories/Food_Category_530.jpg" width="100px" height="100px" alt="No image" class="img-category"></a></td>
                <td>
                    <a href=<?php echo URL . "admin/update-admin.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                    <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=1"; ?> class="btn-danger">Xoá</a>
                    <div class="clear-fix"></div>
                </td>
            </tr>
            <tr class="text-center">
                <td>1</td>
                <td>Bánh gì đó</td>
                <td><a href="../images//categories/Food_Category_530.jpg"><img src="../images//categories/Food_Category_530.jpg" width="100px" height="100px" alt="No image" class="img-category"></a></td>
                <td>
                    <a href=<?php echo URL . "admin/update-admin.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                    <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=1"; ?> class="btn-danger">Xoá</a>
                    <div class="clear-fix"></div>
                </td>
            </tr>
            <tr class="white text-center">
                <td>1</td>
                <td>Bánh gì đó</td>
                <td><a href="../images//categories/Food_Category_530.jpg"><img src="../images//categories/Food_Category_530.jpg" width="100px" height="100px" alt="No image" class="img-category"></a></td>
                <td>
                    <a href=<?php echo URL . "admin/update-admin.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                    <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=1"; ?> class="btn-danger">Xoá</a>
                    <div class="clear-fix"></div>
                </td>
            </tr>
        </table>

    </div>
</section>

<?php
include('./layouts/footer.php') ?>