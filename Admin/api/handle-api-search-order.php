<?php
include('../../Config/connect.php');
//request
if (isset($_GET['search'])) {
    //get product
    $search = $_GET['search'];
    unset($_GET['search']);

    //search from database
    $conn = connectToDatabase();
    $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
                        FROM ( DatHang AS A LEFT JOIN KhachHang AS B ON A.MSKH = B.MSKH ), ChiTietDatHang AS E, HangHoa AS F
                        WHERE A.SoDonDH = E.SoDonDH
                            AND E.MSHH = F.MSHH";
    $result = executeSQLResult($conn, $sql);
    /*
    listProductSearch is all result search
    listProductsId is result search by id
    listProductsName is reuslt search by name product
    listProductsCategory is result search by name category
    */
    $listOrderSearch = array();
    $listOrderId = array();
    $listOrderName = array();

    //search by id
    for ($i = 0; $i < count($result); $i++) {
        if (strcmp($result[$i]['SoDonDH'], $search) == 0) {
            array_push($listOrderId, $i);
        }
    }

    //search by name
    $array_search = str_split($search);
    for ($i = count($array_search); $i > 0; $i--) {
        $str_child = substr($search, 0, $i);
        for ($j = 0; $j < count($result); $j++) {
            if (strpos($result[$j]['TenHH'], $str_child)) {
                array_push($listOrderName, $j);
            }
        }
    }
    $listOrderSearch = array_merge($listOrderId, $listOrderName);
    $listOrderSearch = array_unique($listOrderSearch);

    $list_order = array();
    $i = 0;

    foreach($listOrderSearch as $index) {
        //get image
        //get image
        $codeProduct = $result[$index]['MSHH'];
        $noOrder = $result[$index]['SoDonDH'];
        $nameCustomer = $result[$index]['HoTenKH'];
        $product = $result[$index]['TenHH'];
        $dayOrder = $result[$index]['NgayDH'];
        $dayShip = $result[$index]['NgayGH'];
        $statusOrder = $result[$index]['TrangThaiDH'];
        $quatity = $result[$index]['SoLuong'];
        $discount = $result[$index]['GiamGia'];
        $total = $result[$index]['GiaDatHang'];

        //get image
        $sql = "SELECT * FROM HinhHangHoa WHERE MSHH = $codeProduct LIMIT 1";
        $result_image = executeSQLResult($conn, $sql);
        $image_name = $result_image[0]['TenHinh'];
        //convert to json
        $order = array(
            'id' => $noOrder,
            'codeProduct' => $codeProduct,
            'nameCustomer' => $nameCustomer,
            'product' => $product,
            'dayOrder' => $dayOrder,
            'dayShip' => $dayShip,
            'statusOrder' => $statusOrder,
            'quatity' => $quatity,
            'discount' => $discount,
            'total' => $total,
            'image' => $image_name
        );

        $list_order[$i] = $order;
        $i ++;
    }
    echo json_encode($list_order, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}
