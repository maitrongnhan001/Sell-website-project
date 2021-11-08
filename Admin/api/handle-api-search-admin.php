<?php
include('../../Config/connect.php');
//request
if (isset($_GET['search'])) {
    //get product
    $search = $_GET['search'];
    unset($_GET['search']);

    //search from database
    $conn = connectToDatabase();
    $sql = "SELECT * FROM NhanVien";
    $result = executeSQLResult($conn, $sql);
    /*
    listProductSearch is all result search
    listProductsId is result search by id
    listProductsName is reuslt search by name product
    listProductsCategory is result search by name category
    */
    $listAdminSearch = array();
    $listAdminId = array();
    $listAdminName = array();

    //search by id
    for ($i = 0; $i < count($result); $i++) {
        if (strcmp($result[$i]['MSNV'], $search) == 0) {
            array_push($listAdminId, $i);
        }
    }

    //search by name
    $array_search = str_split($search);
    for ($i = count($array_search); $i > 0; $i--) {
        $str_child = substr($search, 0, $i);
        for ($j = 0; $j < count($result); $j++) {
            if (strpos($result[$j]['HoTenNV'], $str_child)) {
                array_push($listAdminName, $j);
            }
        }
    }
    $listAdminSearch = array_merge($listAdminId, $listAdminName);
    $listAdminSearch = array_unique($listAdminSearch);

    $list_admin = array();
    $i = 0;

    foreach($listAdminSearch as $index) {
        //convert to json
        $admin = array(
            'id' => $result[$index]['MSNV'],
            'name_admin' => $result[$index]['HoTenNV'],
            'position' => $result[$index]['ChucVu'],
            'address' => $result[$index]['DiaChi'],
            'phone' => $result[$index]['SoDienThoai']
        );

        $list_admin[$i] = $admin;
        $i ++;
    }
    echo json_encode($list_admin, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}
