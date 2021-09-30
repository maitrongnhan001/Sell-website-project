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
            <?php
            //get list products
            $conn = connectToDatabase();
            $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, SoLuongHang, TenLoaiHang, TenHinh 
                    FROM HangHoa, HinhHangHoa, LoaiHangHoa 
                    WHERE HangHoa.MSHH = HinhHangHoa.MSHH AND LoaiHangHoa.MaLoaiHang = HangHoa.MaLoaiHang;";
            $listProducts = executeSQLResult($conn, $sql);
            for ($i = 1; $i <= count($listProducts); $i++) {
                $id = $listProducts[$i - 1]['MSHH'];
                $nameProduct = $listProducts[$i - 1]['TenHH'];
                $description = $listProducts[$i - 1]['QuyCach'];
                $price = $listProducts[$i - 1]['Gia'];
                $quality = $listProducts[$i - 1]['SoLuongHang'];
                $category = $listProducts[$i - 1]['TenLoaiHang'];
                $pathImage = URL . 'images/products/' . $listProducts[$i - 1]['TenHinh'];
                if ($i % 2 == 0) {
            ?>
                    <tr class="text-center">
                        <td><?php echo $i; ?></td>
                        <td class="name-product"><?php echo $nameProduct; ?></td>
                        <td class="description"><?php echo $description; ?></td>
                        <td>VNĐ: <?php echo $price; ?></td>
                        <td><?php echo $quality; ?></td>
                        <td><?php echo $category; ?></td>
                        <td><a href=<?php echo $pathImage; ?>><img src=<?php echo $pathImage; ?> width="100px" height="100px" alt="No image" class="img-category"></a></td>
                        <td>
                            <a href=<?php echo URL . "admin/update-product.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
                            <a href=<?php echo URL . "admin/delete-item.php?id=" . $id . "&type=3"; ?> class="btn-danger">Xoá</a>
                            <div class="clear-fix"></div>
                        </td>
                    </tr>
                <?php
                } else {
                ?>
                    <tr class="white text-center">
                        <td><?php echo $i; ?></td>
                        <td class="name-product"><?php echo $nameProduct; ?></td>
                        <td class="description"><?php echo $description; ?></td>
                        <td>VNĐ: <?php echo $price; ?></td>
                        <td><?php echo $quality; ?></td>
                        <td><?php echo $category; ?></td>
                        <td><a href=<?php echo $pathImage; ?>><img src=<?php echo $pathImage; ?> width="100px" height="100px" alt="No image" class="img-category"></a></td>
                        <td>
                            <a href=<?php echo URL . "admin/update-product.php?id=" . $id; ?> class="btn-primary">Cập nhật</a>
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
include('./layouts/footer.php') ?>