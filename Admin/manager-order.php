<?php
include('./layouts/header.php');
?>
<!--nofication-->
<div id="notification-order" class="notification hide">
    <div class="main-notification">
        <br><br>
        <h1 class="text-center">Thông báo</h1>
        <br>
        <ul class="list-notification">
            <?php
            //get notification
            $conn = connectToDatabase();
            $status_order = 'Đặt hàng';
            $sql = "SELECT COUNT(SoDonDH) AS SoLuong FROM DatHang WHERE TrangThaiDH='$status_order'";
            $result = executeSQLResult($conn, $sql);
            $amount_new_order = $result[0]['SoLuong'];
            if ($amount_new_order > 0) {
            ?>
                <li><a href="<?php echo URL . 'Admin/manager-order.php?filter=2'; ?>">Có <?php echo $amount_new_order; ?> đơn hàng mới đang chờ bạn giải quyết</a></li>
            <?php
            }
            //get notification
            $status_order = 'Đang giao';
            $sql = "SELECT COUNT(SoDonDH) AS SoLuong FROM DatHang WHERE TrangThaiDH='$status_order'";
            $result = executeSQLResult($conn, $sql);
            $amount = $result[0]['SoLuong'];
            if ($amount > 0) {
            ?>
                <li><a href="<?php echo URL . 'Admin/manager-order.php?filter=3'; ?>">Có <?php echo $amount; ?> đơn hàng đang giao</a></li>
            <?php
            }
            //get notification
            $status_order = 'Đã giao';
            $sql = "SELECT COUNT(SoDonDH) AS SoLuong FROM DatHang WHERE TrangThaiDH='$status_order'";
            $result = executeSQLResult($conn, $sql);
            $amount = $result[0]['SoLuong'];
            if ($amount > 0) {
            ?>
                <li><a href="<?php echo URL . 'Admin/manager-order.php?filter=4'; ?>">Có <?php echo $amount; ?> đơn hàng đă giao thành công</a></li>
            <?php
            }
            //get notification
            $status_order = 'Bị huỷ';
            $sql = "SELECT COUNT(SoDonDH) AS SoLuong FROM DatHang WHERE TrangThaiDH='$status_order'";
            $result = executeSQLResult($conn, $sql);
            $amount = $result[0]['SoLuong'];
            if ($amount > 0) {
            ?>
                <li><a href="<?php echo URL . 'Admin/manager-order.php?filter=5'; ?>">Có <?php echo $amount; ?> đơn hàng bị huỷ</a></li>
            <?php
            }
            ?>
        </ul>
        <br><br>
        <button id="btn-close-notification" class="btn-primary"><span>Quay lại</span></button>
        <br><br>
    </div>
</div>
<!--end nofication-->

<section class="main text-content">
    <div class="container">
        <h1>Quản lý đơn hàng</h1>
        <br>
        <div class="group-btn-notification">
            <?php
            if ($amount_new_order > 0) {
            ?>
                <div class="on-notification"></div>
            <?php
            }
            ?>
            <button id="btn-notification" class="btn-200 btn-primary btn-add-order">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
                </svg>
                <span>Thông báo</span>
            </button>
            <a href="add-order.php" class="btn-200 btn-primary btn-add-order">Thêm đơn hàng</a>
            <div class="clearfix"></div>
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
        <br>
        <div class="menu-filter">
            <ul>
                <a href=<?php echo URL . 'admin/manager-order.php?filter=1'; ?>>
                    <li>Tất cả</li>
                </a>
                <a href=<?php echo URL . 'admin/manager-order.php?filter=2'; ?>>
                    <li>Đặt hàng</li>
                </a>
                <a href=<?php echo URL . 'admin/manager-order.php?filter=3'; ?>>
                    <li>Đang giao</li>
                </a>
                <a href=<?php echo URL . 'admin/manager-order.php?filter=4'; ?>>
                    <li>Đã giao</li>
                </a>
                <a href=<?php echo URL . 'admin/manager-order.php?filter=5'; ?>>
                    <li>Bị huỷ</li>
                </a>
                <div class="clearfix"></div>
            </ul>
        </div>
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
            switch ($filter) {
                case 1:
                    $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
                    FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F
                    WHERE A.MSKH = B.MSKH
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        ORDER BY A.SoDonDH DESC LIMIT 10";
                    break;
                case 2:
                    $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
                    FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F
                    WHERE A.MSKH = B.MSKH
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND A.TrangThaiDH = 'Đặt hàng'
                        ORDER BY A.SoDonDH DESC LIMIT 10";
                    break;
                case 3:
                    $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
                    FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F
                    WHERE A.MSKH = B.MSKH
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND A.TrangThaiDH = 'Đang giao'
                        ORDER BY A.SoDonDH DESC LIMIT 10";
                    break;
                case 4:
                    $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
                    FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F
                    WHERE A.MSKH = B.MSKH
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND A.TrangThaiDH = 'Đã giao'
                        ORDER BY A.SoDonDH DESC LIMIT 10";
                    break;
                case 5:
                    $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
                    FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F
                    WHERE A.MSKH = B.MSKH
                        AND A.SoDonDH = E.SoDonDH
                        AND E.MSHH = F.MSHH
                        AND A.TrangThaiDH = 'Bị huỷ'
                        ORDER BY A.SoDonDH DESC LIMIT 10";
                    break;
            }
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
                        <td class="day-order"><?php echo $dayShip; ?></td>
                        <td><?php echo $statusOrder; ?></td>
                        <td><?php echo $quality; ?></td>
                        <td><?php echo $discount; ?></td>
                        <td><?php echo $total; ?></td>
                        <td>
                            <a href=<?php echo URL . "admin/update-order.php?noOrder=" . $noOrder . "&filter=" . $filter; ?> class="btn-primary">Cập nhật</a>
                            <a href=<?php echo URL . "admin/cancel-order.php?noOrder=" . $noOrder . "&filter=" . $filter; ?> class="btn-danger">Huỷ đơn</a>
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
                            <a href=<?php echo URL . "admin/update-order.php?noOrder=" . $noOrder . "&filter=" . $filter; ?> class="btn-primary">Cập nhật</a>
                            <a href=<?php echo URL . "admin/cancel-order.php?noOrder=" . $noOrder . "&filter=" . $filter; ?> class="btn-danger">Huỷ đơn</a>
                        </td>
                    </tr>
            <?php
                }
            }

            ?>
        </table>
        <br>
        <input type="hidden" name="filter" value="<?php echo $filter; ?>">
        <p class="text-center pink load-more" id="load-order">Xem thêm</p>

    </div>
</section>

<?php
closeConnect($conn);
include('./layouts/footer.php');
?>