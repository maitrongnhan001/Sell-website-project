<?php
include('../../Config/connect.php');
//request
if (isset($_GET['position']) && isset($_GET['limit'])) {
    //get product
    $position = $_GET['position'];
    $limit = $_GET['limit'];
    $conn = connectToDatabase();
    $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, TenLoaiHang 
                FROM HangHoa, LoaiHangHoa 
                WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang
                LIMIT $limit OFFSET $position";
    $result = executeSQLResult($conn, $sql);

    $list_product = array();

    for ($i = 0; $i < count($result); $i++) {
        //get image
        $id = $result[$i]['MSHH'];
        $sql = "SELECT * FROM HinhHangHoa WHERE MSHH=$id LIMIT 1";
        $result_image = executeSQLResult($conn, $sql);

        //convert to json
        $product = array(
            'id' => $id,
            'name_product' => $result[$i]['TenHH'],
            'price' => $result[$i]['Gia'],
            'description' => $result[$i]['QuyCach'],
            'category' => $result[$i]['TenLoaiHang'],
            'image_name' => $result_image[0]['TenHinh']
        );

        $list_product[$i] = $product;
    }
    echo json_encode($list_product, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}
