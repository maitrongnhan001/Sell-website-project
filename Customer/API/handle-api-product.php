<?php
include('../../Config/connect.php');
//request
if (isset($_GET['position']) && isset($_GET['limit'])) {
    $position = $_GET['position'];
    $limit = $_GET['limit'];
    $conn = connectToDatabase();
    $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, TenLoaiHang, TenHinh 
                FROM HangHoa, LoaiHangHoa, HinhHangHoa 
                WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang
                AND HangHoa.MSHH = HinhHangHoa.MSHH LIMIT $limit OFFSET $position";
    $result = executeSQLResult($conn, $sql);
    $list_product = array();
    for ($i = 0; $i < count($result); $i++) {
        //convert to json
        $product = array(
            'id' => $result[$i]['MSHH'],
            'name_product' => $result[$i]['TenHH'],
            'price' => $result[$i]['Gia'],
            'description' => $result[$i]['QuyCach'],
            'category' => $result[$i]['TenLoaiHang'],
            'image_name' => $result[$i]['TenHinh']
        );

        $list_product[$i] = $product;
    }
    echo json_encode($list_product, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}