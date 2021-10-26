<?php
include('../../Config/connect.php');
//request
if (isset($_GET['position']) && isset($_GET['limit'])) {
    $position = $_GET['position'];
    $limit = $_GET['limit'];
    $conn = connectToDatabase();
    $sql = "SELECT MaLoaiHang, TenLoaiHang, HinhAnh
                FROM LoaiHangHoa 
                LIMIT $limit OFFSET $position";
    $result = executeSQLResult($conn, $sql);
    $list_category = array();
    for ($i = 0; $i < count($result); $i++) {
        //convert to json
        $category = array(
            'id' => $result[$i]['MaLoaiHang'],
            'name_category' => $result[$i]['TenLoaiHang'],
            'image_name' => $result[$i]['HinhAnh']
        );

        $list_category[$i] = $category;
    }
    echo json_encode($list_category, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}