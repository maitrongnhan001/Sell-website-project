<?php
ob_start();
include('./layouts/header.php');
if (isset($_SESSION['username_customer'])) {
    $username = $_SESSION['username_customer'];
} else {
    header('Location: ' . URL . 'Customer/login.php');
    die();
}
?>

<?php include('./layouts/child-menu.php'); ?>

<section class="register">
    <div class="container">
        <h1 class="text-center">Quản lý đơn hàng</h1>
        <?php
        //show nofication add admin successfully
        if (isset($_SESSION['status_order'])) {
            echo ("<br><div class='green text-center'>" . $_SESSION['status_order'] . "</div>");
            unset($_SESSION['status_order']);
        }
        if (isset($_SESSION['error'])) {
            echo ("<br><div class='red text-center'>" . $_SESSION['error'] . "</div>");
            unset($_SESSION['error']);
        }
        ?>
        <br><br>
        <table class="tbl-manager">
            <tr>
                <th>STT</th>
                <th>Tên khách hàng</th>
                <th>Sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Ngày ĐH</th>
                <th>Trạng thái ĐH</th>
                <th>Số lượng</th>
                <th>Tổng giá</th>
                <th>Quản lý</th>
            </tr>
            <?php
            //get data order by username
            if (isset($_GET['filter'])) {
                $filter = $_GET['filter'];
                unset($_GET['filter']);
            } else {
                $filter = 1;
            }

            $conn = connectToDatabase();


            $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
                    FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F
                    WHERE A.MSKH = B.MSKH
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND B.UserName = '$username'
                        ORDER BY A.SoDonDH DESC";
            $listOrder = executeSQLResult($conn, $sql);
            for ($i = 1; $i <= count($listOrder); $i++) {
                $codeProduct = $listOrder[$i - 1]['MSHH'];
                $noOrder = $listOrder[$i - 1]['SoDonDH'];
                $nameCustomer = $listOrder[$i - 1]['HoTenKH'];
                $product = $listOrder[$i - 1]['TenHH'];
                $dayOrder = $listOrder[$i - 1]['NgayDH'];
                $dayShip = $listOrder[$i - 1]['NgayGH'];
                $statusOrder = $listOrder[$i - 1]['TrangThaiDH'];
                $quality = $listOrder[$i - 1]['SoLuong'];
                $discount = $listOrder[$i - 1]['GiamGia'];
                $total = $listOrder[$i - 1]['GiaDatHang'];

                //format price
                $total = strval($total);
                $index = strlen($total) - 3;
                while ($index > 0) {
                    $total = substr($total, 0, $index).",".substr($total,$index);
                     $index = $index - 3;
                }

                //get image
                $sql = "SELECT * FROM HinhHangHoa WHERE MSHH = $codeProduct LIMIT 1";
                $result_image = executeSQLResult($conn, $sql);
                $image_name = $result_image[0]['TenHinh'];
                $pathImage = URL . 'images/products/' . $image_name;
                if ($i % 2 == 0) {
            ?>
                    <tr class="text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $nameCustomer; ?></td>
                        <td><?php echo $product; ?></td>
                        <td><a href=<?php echo $pathImage; ?>><img src=<?php echo $pathImage; ?> width="100px" height="100px" alt="No image" class="img-category"></a></td>
                        <td class="day-order"><?php echo $dayOrder; ?></td>
                        <td><?php echo $statusOrder; ?></td>
                        <td><?php echo $quality; ?></td>
                        <td><?php echo $total; ?></td>
                        <td>
                            <?php
                            if ($statusOrder == "Đặt hàng") {
                            ?>
                                <a href=<?php
                                        echo URL . "Customer/cancel-order.php?noOrder=" . $noOrder . "&filter=" . $filter;
                                        ?> class="btn btn-primary">Huỷ đơn</a>
                            <?php
                            } else {
                            ?>
                                <a en class="btn btn-disabled">Huỷ đơn</a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                } else {
                ?>
                    <tr class="white-row text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $nameCustomer; ?></td>
                        <td><?php echo $product; ?></td>
                        <td><a href=<?php echo $pathImage; ?>><img src=<?php echo $pathImage; ?> width="100px" height="100px" alt="No image" class="img-category"></a></td>
                        <td class="day-order"><?php echo $dayOrder; ?></td>
                        <td><?php echo $statusOrder; ?></td>
                        <td><?php echo $quality; ?></td>
                        <td><?php echo $total; ?></td>
                        <td>
                            <?php
                            if ($statusOrder == "Đặt hàng") {
                            ?>
                                <a href=<?php
                                        echo URL . "Customer/cancel-order.php?noOrder=" . $noOrder . "&filter=" . $filter;
                                        ?> class="btn btn-primary">Huỷ đơn</a>
                            <?php
                            } else {
                            ?>
                                <a class="btn btn-disabled">Huỷ đơn</a>
                            <?php
                            }
                            ?>
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