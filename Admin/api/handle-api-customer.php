<?php
include('../../Config/connect.php');
//request
if (isset($_GET['position']) && isset($_GET['limit'])) {
    $position = $_GET['position'];
    $limit = $_GET['limit'];
    $conn = connectToDatabase();
    $sql = "SELECT * FROM KhachHang 
            LIMIT $limit OFFSET $position";
    $result = executeSQLResult($conn, $sql);
    $list_customer = array();
    for ($i = 0; $i < count($result); $i++) {
        //convert to json
        $customer = array(
            'id' => $result[$i]['MSKH'],
            'name_customer' => $result[$i]['HoTenKH'],
            'company' => $result[$i]['TenCongTy'],
            'phone' => $result[$i]['SoDienThoai'],
            'fax' => $result[$i]['SoFax']
        );

        $list_customer[$i] = $customer;
    }
    echo json_encode($list_customer, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}