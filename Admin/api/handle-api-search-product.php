<?php
include('../../Config/connect.php');
//request
if (isset($_GET['search'])) {
    //get product
    $search = $_GET['search'];
    unset($_GET['search']);

    //search from database
    $conn = connectToDatabase();
    $sql = "SELECT HangHoa.MSHH, TenHH, QuyCach, Gia, TenLoaiHang, SoLuongHang
                FROM HangHoa, LoaiHangHoa 
                WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang";
    $result = executeSQLResult($conn, $sql);
    /*
    listProductSearch is all result search
    listProductsId is result search by id
    listProductsName is reuslt search by name product
    listProductsCategory is result search by name category
    */
    $listProductsSearch = array();
    $listProductsId = array();
    $listProductsName = array();

    //search by id
    for ($i = 0; $i < count($result); $i++) {
        if (strcmp($result[$i]['MSHH'], $search) == 0) {
            array_push($listProductsId, $i);
        }
    }

    //search by name
    $array_search = str_split($search);
    for ($i = count($array_search); $i > 0; $i--) {
        $str_child = substr($search, 0, $i);
        for ($j = 0; $j < count($result); $j++) {
            if (strpos($result[$j]['TenHH'], $str_child)) {
                array_push($listProductsName, $j);
            }
        }
    }
    $listProductsSearch = array_merge($listProductsId, $listProductsName);
    $listProductsSearch = array_unique($listProductsSearch);

    $list_product = array();
    $i = 0;

    foreach($listProductsSearch as $index) {
        //get image
        $id = $result[$index]['MSHH'];
        $sql = "SELECT * FROM HinhHangHoa WHERE MSHH=$id LIMIT 1";
        $result_image = executeSQLResult($conn, $sql);

        //convert to json
        $product = array(
            'id' => $id,
            'name_product' => $result[$index]['TenHH'],
            'price' => $result[$index]['Gia'],
            'description' => $result[$index]['QuyCach'],
            'category' => $result[$index]['TenLoaiHang'],
            'quatity' => $result[$index]['SoLuongHang'],
            'image_name' => $result_image[0]['TenHinh']
        );

        $list_product[$i] = $product;
        $i ++;
    }
    echo json_encode($list_product, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}
