<?php include('./layouts/header.php') ?>

<section class="main text-content">
    <div class="container">
        <h1>Quản lý khách hàng</h1>
        <br><br>
        <table class="tbl-manager">
            <tr>
                <th>STT</th>
                <th>Họ và Tên</th>
                <th>Tên công ty</th>
                <th>Số điện thoại</th>
                <th>Số fax</th>
            </tr>
            <?php
            //get data admin
            $conn = connectToDatabase();
            $sql = "SELECT * FROM KhachHang LIMIT 10";
            $listCustomer = executeSQLResult($conn, $sql);
            for ($i = 1; $i <= count($listCustomer); $i++) {
                //show data admin to screen
                if ($i % 2 == 0) {
                    //gray
                    $id = $listAdmin[$i-1]['MSKH'];
                    $name = $listCustomer[$i - 1]['HoTenKH'];
                    $company = $listCustomer[$i - 1]['TenCongTy'];
                    $phone = $listCustomer[$i - 1]['SoDienThoai'];
                    $fax = $listCustomer[$i - 1]['SoFax'];
            ?>
                    <tr class="text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $company; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $fax; ?></td>
                    </tr>
            <?php
                } else {
                    //white
                    $id = $listAdmin[$i-1]['MSKH'];
                    $name = $listCustomer[$i - 1]['HoTenKH'];
                    $company = $listCustomer[$i - 1]['TenCongTy'];
                    $phone = $listCustomer[$i - 1]['SoDienThoai'];
                    $fax = $listCustomer[$i - 1]['SoFax'];
            ?>
                    <tr class="white text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $company;?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $fax; ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>
        <br>
        <p class="text-center pink load-more" id="load-customer">Xem thêm</p>
    </div>
</section>

<?php 
closeConnect($conn);
include('./layouts/footer.php') ?>