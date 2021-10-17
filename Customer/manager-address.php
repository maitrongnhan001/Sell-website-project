<?php
ob_start();
include('./layouts/header.php');
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: ' . URL . 'Customer/login.php');
    die();
}
?>

<?php include('./layouts/child-menu.php'); ?>

<section class="register">
    <div class="container">
        <h1 class="text-center">Quản lý địa chỉ giao hàng</h1>

        <br><br>
        <table class="tbl-manager">
            <tr>
                <th>STT</th>
                <th>Địa chỉ</th>
                <th>Quản lý</th>
            </tr>

            <?php
            //get code customer
            $conn = connectToDatabase();
            $sql = "SELECT * FROM KhachHang WHERE UserName='$username'";
            $result_customer = executeSQLResult($conn, $sql);
            $code_cutomer = $result_customer[0]['MSKH'];

            //get list address
            $sql = "SELECT * FROM DiaChiKH WHERE MSKH=$code_cutomer";
            $list_address = executeSQLResult($conn, $sql);
            for ($i = 1; $i <= count($list_address); $i++) {
                $code_address = $list_address[$i - 1]['MaDC'];
                $address = $list_address[$i - 1]['DiaChi'];
                if ($i % 2 == 0) {
            ?>
                    <tr class="white-row text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $address; ?></td>
                        <td>
                            <a href=<?php
                                    echo URL . "Customer/cancel-order.php?noOrder=" . $noOrder . "&filter=" . $filter;
                                    ?> class="btn btn-primary">Cập nhật</a>
                        </td>
                    </tr>
                <?php
                } else {
                ?>
                    <tr class="text-center">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $address; ?></td>
                        <td>
                            <a href=<?php
                                    echo URL . "Customer/cancel-order.php?noOrder=" . $noOrder . "&filter=" . $filter;
                                    ?> class="btn btn-primary">Cập nhật</a>
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