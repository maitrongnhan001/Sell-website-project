<?php
include('../../Config/connect.php');
//request
if (isset($_GET['search'])) {
    //get product
    $search = $_GET['search'];
    unset($_GET['search']);

    //search from database
    $conn = connectToDatabase();
    $sql = "SELECT * FROM KhachHang";
    $result = executeSQLResult($conn, $sql);
    /*
    listProductSearch is all result search
    listProductsId is result search by id
    listProductsName is reuslt search by name product
    listProductsCategory is result search by name category
    */
    $listCustomerSearch = array();
    $listCustomerId = array();
    $listCustomerName = array();

    //search by id
    for ($i = 0; $i < count($result); $i++) {
        if (strcmp($result[$i]['MSKH'], $search) == 0) {
            array_push($listCustomerId, $i);
        }
    }

    //search by name
    $array_search = str_split($search);
    for ($i = count($array_search); $i > 0; $i--) {
        $str_child = substr($search, 0, $i);
        for ($j = 0; $j < count($result); $j++) {
            if (strpos($result[$j]['HoTenKH'], $str_child)) {
                array_push($listCustomerName, $j);
            }
        }
    }
    $listCustomerSearch = array_merge($listCustomerId, $listCustomerName);
    $listCustomerSearch = array_unique($listCustomerSearch);

    $list_customer = array();
    $i = 0;

    foreach($listCustomerSearch as $index) {
        //convert to json
        $customer = array(
            'id' => $result[$index]['MSKH'],
            'name_customer' => $result[$index]['HoTenKH'],
            'company' => $result[$index]['TenCongTy'],
            'phone' => $result[$index]['SoDienThoai'],
            'fax' => $result[$index]['SoFax']
        );

        $list_customer[$i] = $customer;
        $i ++;
    }
    echo json_encode($list_customer, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}
