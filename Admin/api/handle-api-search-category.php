<?php
include('../../Config/connect.php');
//request
if (isset($_GET['search'])) {
    //get product
    $search = $_GET['search'];
    unset($_GET['search']);

    //search from database
    $conn = connectToDatabase();
    $sql = "SELECT MaLoaiHang, TenLoaiHang, HinhAnh FROM LoaiHangHoa";
    $result = executeSQLResult($conn, $sql);
    /*
    listProductSearch is all result search
    listProductsId is result search by id
    listProductsName is reuslt search by name product
    listProductsCategory is result search by name category
    */
    $listCategorySearch = array();
    $listCategoryId = array();
    $listCategoryName = array();

    //search by id
    for ($i = 0; $i < count($result); $i++) {
        if (strcmp($result[$i]['MaLoaiHang'], $search) == 0) {
            array_push($listCategoryId, $i);
        }
    }

    //search by name
    $array_search = str_split($search);
    for ($i = count($array_search); $i > 0; $i--) {
        $str_child = substr($search, 0, $i);
        for ($j = 0; $j < count($result); $j++) {
            if (strpos($result[$j]['TenLoaiHang'], $str_child)) {
                array_push($listCategoryName, $j);
            }
        }
    }
    $listCategorySearch = array_merge($listCategoryId, $listCategoryName);
    $listCategorySearch = array_unique($listCategorySearch);

    $list_category = array();
    $i = 0;

    foreach($listCategorySearch as $index) {
        //convert to json
        $category = array(
            'id' => $result[$index]['MaLoaiHang'],
            'name_category' => $result[$index]['TenLoaiHang'],
            'image_name' => $result[$index]['HinhAnh']
        );

        $list_category[$i] = $category;
        $i ++;
    }
    echo json_encode($list_category, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}
