<?php
include('../../Config/connect.php');
//request
if (isset($_GET['position']) && isset($_GET['limit'])) {
    $position = $_GET['position'];
    $limit = $_GET['limit'];
    $conn = connectToDatabase();
    $sql = "SELECT * FROM NhanVien 
            LIMIT $limit OFFSET $position";
    $result = executeSQLResult($conn, $sql);
    $list_admin = array();
    for ($i = 0; $i < count($result); $i++) {
        //convert to json
        $admin = array(
            'id' => $result[$i]['MSNV'],
            'name_admin' => $result[$i]['HoTenNV'],
            'position' => $result[$i]['ChucVu'],
            'address' => $result[$i]['DiaChi'],
            'phone' => $result[$i]['SoDienThoai']
        );

        $list_admin[$i] = $admin;
    }
    echo json_encode($list_admin, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}