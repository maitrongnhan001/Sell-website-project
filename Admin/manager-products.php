<?php include('./layouts/header.php') ?>

<section class="main text-content">
    <div class="container">
        <h1>Quản lý sản phẩm</h1>
        <br>
        <a href=<?php echo URL . "admin/add-product.php"; ?> class="btn-200 btn-primary">Thêm sản phẩm</a>
        <?php
        //show nofication add admin successfully
        if (isset($_SESSION['status_product'])) {
            echo ("<br><div class='green'>" . $_SESSION['status_product'] . "</div>");
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
                <th>Tên sản phẩm</th>
                <th>Quy cách</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Loại hàng</th>
                <th>Hình ảnh</th>
                <th>Quản lý</th>
            </tr>
            <tr class="white text-center">
                <td>1</td>
                <td class="name-product">product product product product</td>
                <td class="description">Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá</td>
                <td>VNĐ: 100.000</td>
                <td>1000</td>
                <td>Không biết</td>
                <td><a href="../images/categories/Food_Category_530.jpg"><img src="../images/categories/Food_Category_530.jpg" width="100px" height="100px" alt="No image" class="img-category"></a></td>
                <td>
                    <a href=<?php echo URL . "admin/update-category.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                    <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=2"; ?> class="btn-danger">Xoá</a>
                    <div class="clear-fix"></div>
                </td>
            </tr>
            <tr class="text-center">
                <td>1</td>
                <td class="name-product">product</td>
                <td class="description">Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá</td>
                <td>VNĐ: 100.000</td>
                <td>1000</td>
                <td>Không biết</td>
                <td><a href="../images/categories/Food_Category_530.jpg"><img src="../images/categories/Food_Category_530.jpg" width="100px" height="100px" alt="No image" class="img-category"></a></td>
                <td>
                    <a href=<?php echo URL . "admin/update-category.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                    <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=2"; ?> class="btn-danger">Xoá</a>
                    <div class="clear-fix"></div>
                </td>
            </tr>
            <tr class="white text-center">
                <td>1</td>
                <td class="name-product">product</td>
                <td class="description">Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá Đây là hàng hoá</td>
                <td>VNĐ: 100.000</td>
                <td>1000</td>
                <td>Không biết</td>
                <td><a href="../images/categories/Food_Category_530.jpg"><img src="../images/categories/Food_Category_530.jpg" width="100px" height="100px" alt="No image" class="img-category"></a></td>
                <td>
                    <a href=<?php echo URL . "admin/update-category.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                    <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=2"; ?> class="btn-danger">Xoá</a>
                    <div class="clear-fix"></div>
                </td>
            </tr>
            <tr class="text-center">
                <td>1</td>
                <td class="name-product">product</td>
                <td class="description">Đây là hàng hoá</td>
                <td>VNĐ: 100.000</td>
                <td>1000</td>
                <td>Không biết</td>
                <td><a href="../images/categories/Food_Category_530.jpg"><img src="../images/categories/Food_Category_530.jpg" width="100px" height="100px" alt="No image" class="img-category"></a></td>
                <td>
                    <a href=<?php echo URL . "admin/update-category.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                    <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=2"; ?> class="btn-danger">Xoá</a>
                    <div class="clear-fix"></div>
                </td>
            </tr>
        </table>

    </div>
</section>

<?php
include('./layouts/footer.php') ?>