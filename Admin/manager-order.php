<?php 
include('./layouts/header.php');
?>

<section class="main text-content">
    <div class="container">
        <h1>Quản lý đơn hàng</h1>
        <br>
        <div class="menu-filter">
            <ul>
                <a href=<?php echo URL.'admin/manager-order.php?filter=1'; ?>><li>Tất cả</li></a>
                <a href=<?php echo URL.'admin/manager-order.php?filter=2'; ?>><li>Đặt hàng</li></a>
                <a href=<?php echo URL.'admin/manager-order.php?filter=3'; ?>><li>Đang giao</li></a>
                <a href=<?php echo URL.'admin/manager-order.php?filter=4'; ?>><li>Đã giao</li></a>
                <a href=<?php echo URL.'admin/manager-order.php?filter=5'; ?>><li>Bị huỷ</li></a>
                <div class="clearfix"></div>
            </ul>
        </div>
        <?php
        //show nofication add admin successfully
        if (isset($_SESSION['status_order'])) {
            echo ("<br><div class='green'>" . $_SESSION['status_order'] . "</div>");
            unset($_SESSION['status_order']);
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
                <th>Tên khách hàng</th>
                <th>Sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Ngày ĐH</th>
                <th>Ngày GH</th>
                <th>Trạng thái ĐH</th>
                <th>Số lượng</th>
                <th>Giảm giá</th>
                <th>Tổng giá</th>
                <th>Quản lý</th>
            </tr>
            <?php
            //get data order
            if (isset($_GET['filter'])) {
                $filter = $_GET['filter'];
                unset($_GET['filter']);
            } else {
                $filter = 1;
            }
            /* 
            filter: 1 filter all 
            filter: 2 filter success order 
            filter: 3 filter cancel order
            filter: 4 filter waiting
            */
            $conn = connectToDatabase();
            switch ($filter) {
                case 1:
                    $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, G.TenHinh
                    FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F, HinhHangHoa as G
                    WHERE A.MSKH = B.MSKH
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND G.MSHH = F.MSHH";
                    break;
                case 2:
                    $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, G.TenHinh
                    FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F, HinhHangHoa as G
                    WHERE A.MSKH = B.MSKH
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND G.MSHH = F.MSHH
                        AND A.TrangThaiDH = 'Đặt hàng'";
                    break;
                case 3:
                    $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, G.TenHinh
                    FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F, HinhHangHoa as G
                    WHERE A.MSKH = B.MSKH
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND G.MSHH = F.MSHH
                        AND A.TrangThaiDH = 'đang giao'";
                    break;
                case 4:
                    $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, G.TenHinh
                    FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F, HinhHangHoa as G
                    WHERE A.MSKH = B.MSKH
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND G.MSHH = F.MSHH
                        AND A.TrangThaiDH = 'Đã giao'";
                    break;
                case 5:
                    $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, G.TenHinh
                    FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F, HinhHangHoa as G
                    WHERE A.MSKH = B.MSKH
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND G.MSHH = F.MSHH
                        AND A.TrangThaiDH = 'Bị huỷ'";
                    break;
            }
            $listOrder = executeSQLResult($conn, $sql);
            for ($i = 1; $i < count($listOrder); $i++) {
                $noOrder = $listOrder[$i - 1]['SoDonDH'];
                $nameCustomer = $listOrder[$i - 1]['HoTenKH'];
                $product = $listOrder[$i - 1]['TenHH'];
                $pathImage = URL.'images/products/'.$listOrder[$i - 1]['TenHinh'];
                $dayOrder = $listOrder[$i - 1]['NgayDH'];
                $dayShip = $listOrder[$i - 1]['NgayGH'];
                $statusOrder = $listOrder[$i - 1]['TrangThaiDH'];
                $quality = $listOrder[$i - 1]['SoLuong'];
                $discount = $listOrder[$i - 1]['GiamGia'];
                $total = $listOrder[$i - 1]['GiaDatHang'];
                if ($i % 2 == 0) {
            ?>
                    <tr class="text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $nameCustomer; ?></td>
                        <td><?php echo $product; ?></td>
                        <td><a href=<?php echo $pathImage; ?>><img src=<?php echo $pathImage; ?> width="100px" height="100px" alt="No image" class="img-category"></a></td>
                        <td class="day-order"><?php echo $dayOrder; ?></td>
                        <td class="day-order"><?php echo $dayShip; ?></td>
                        <td><?php echo $statusOrder; ?></td>
                        <td><?php echo $quality; ?></td>
                        <td><?php echo $discount; ?></td>
                        <td><?php echo $total; ?></td>
                        <td>
                            <a href=<?php echo URL . "admin/update-order.php?noOrder=" . $noOrder; ?> class="btn-primary">Cập nhật</a>
                            <a href=<?php echo URL . "admin/cancel-order.php?noOrder=" . $noOrder; ?> class="btn-danger">Huỷ đơn</a>
                        </td>
                    </tr>
                <?php
                } else {
                ?>
                    <tr class="white text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $nameCustomer; ?></td>
                        <td><?php echo $product; ?></td>
                        <td><a href=<?php echo $pathImage; ?>><img src=<?php echo $pathImage; ?> width="100px" height="100px" alt="No image" class="img-category"></a></td>
                        <td class="day-order"><?php echo $dayOrder; ?></td>
                        <td class="day-order"><?php echo $dayShip; ?></td>
                        <td><?php echo $statusOrder; ?></td>
                        <td><?php echo $quality; ?></td>
                        <td><?php echo $discount; ?></td>
                        <td><?php echo $total; ?></td>
                        <td>
                            <a href=<?php echo URL . "admin/update-order.php?noOrder=" . $noOrder; ?> class="btn-primary">Cập nhật</a>
                            <a href=<?php echo URL . "admin/cancel-order.php?noOrder=" . $noOrder; ?> class="btn-danger">Huỷ đơn</a>
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