<?php include('./layouts/header.php') ?>

<section class="main text-content">
    <div class="container">
        <h1>Quản lý sản phẩm</h1>
        <div class="search">
            <input type="text" name='search' class="search-input" placeholder="Tìm kiểm sản phẩm">
            <button class="search-btn btn-primary" id="load-search-product"> Tiềm kiếm </button>
            <div class="clearfix"></div>
        </div>
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
            $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, SoLuongHang, TenLoaiHang 
                    FROM HangHoa, LoaiHangHoa 
                    WHERE LoaiHangHoa.MaLoaiHang = HangHoa.MaLoaiHang LIMIT 10;";
            $listProducts = executeSQLResult($conn, $sql);
            for ($i = 1; $i <= count($listProducts); $i++) {
                $id = $listProducts[$i - 1]['MSHH'];

                //check id same previous id
                if ($id !== $listProducts[$i - 2]['MSHH']) {
                    $nameProduct = $listProducts[$i - 1]['TenHH'];
                    $description = $listProducts[$i - 1]['QuyCach'];
                    $price = $listProducts[$i - 1]['Gia'];

                    //format price
                    $price = strval($price);
                    $index = strlen($price) - 3;
                    while ($index > 0) {
                        $price = substr($price, 0, $index).",".substr($price,$index);
                         $index = $index - 3;
                    }

                    $quality = $listProducts[$i - 1]['SoLuongHang'];
                    $category = $listProducts[$i - 1]['TenLoaiHang'];

                    //get image
                    $sql = "SELECT * FROM HinhHangHoa WHERE MSHH = $id LIMIT 1";
                    $result_image = executeSQLResult($conn, $sql);
                    $image_name = $result_image[0]['TenHinh'];
                    $pathImage = URL . 'images/products/' . $image_name;
                    if ($i % 2 == 0) {
            ?>
                        <tr class="text-center">
                            <td><?php echo $i; ?></td>
                            <td class="name-product"><?php echo $nameProduct; ?></td>
                            <td class="description">
                                <div class="limit-height"><?php echo $description; ?></div>
                            </td>
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
                            <td class="description">
                                <div class="limit-height"><?php echo $description; ?></div>
                            </td>
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
            }
            ?>
        </table>
        <br>
        <p class="text-center pink load-more" id="load-product">Xem Thêm</p>
    </div>
</section>

<?php
closeConnect($conn);
include('./layouts/footer.php');
?>