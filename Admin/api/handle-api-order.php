<?php
include('../../Config/connect.php');

//get data order
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
    unset($_GET['filter']);
} else {
    $filter = 1;
}

//request
if (isset($_GET['position']) && isset($_GET['limit'])) {
    //get product
    $position = $_GET['position'];
    $limit = $_GET['limit'];
    $conn = connectToDatabase();

    /* 
        filter: 1 filter all 
        filter: 2 filter success order 
        filter: 3 filter cancel order
        filter: 4 filter waiting
    */
    switch ($filter) {
        case 1:
            $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
            FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F
            WHERE A.MSKH = B.MSKH
                AND A.SoDonDH = E.SoDonDH
                AND E.MSHH = F.MSHH
                ORDER BY A.SoDonDH DESC LIMIT $limit OFFSET $position";
            break;
        case 2:
            $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
            FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F
            WHERE A.MSKH = B.MSKH
                AND A.SoDonDH = E.SoDonDH
                AND E.MSHH = F.MSHH
                AND A.TrangThaiDH = 'Đặt hàng'
                ORDER BY A.SoDonDH DESC LIMIT $limit OFFSET $position";
            break;
        case 3:
            $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
            FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F
            WHERE A.MSKH = B.MSKH
                AND A.SoDonDH = E.SoDonDH
                AND E.MSHH = F.MSHH
                AND A.TrangThaiDH = 'Đang giao'
                ORDER BY A.SoDonDH DESC LIMIT $limit OFFSET $position";
            break;
        case 4:
            $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
            FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F
            WHERE A.MSKH = B.MSKH
                AND A.SoDonDH = E.SoDonDH
                AND E.MSHH = F.MSHH
                AND A.TrangThaiDH = 'Đã giao'
                ORDER BY A.SoDonDH DESC LIMIT $limit OFFSET $position";
            break;
        case 5:
            $sql = "SELECT A.SoDonDH, B.HoTenKH, A.NgayDH, A.NgayGH, A.TrangThaiDH, E.GiamGia, E.SoLuong, E.GiaDatHang, F.TenHH, F.MSHH
            FROM DatHang AS A, KhachHang AS B, ChiTietDatHang AS E, HangHoa AS F
            WHERE A.MSKH = B.MSKH
                AND A.SoDonDH = E.SoDonDH
                AND E.MSHH = F.MSHH
                AND A.TrangThaiDH = 'Bị huỷ'
                ORDER BY A.SoDonDH DESC LIMIT $limit OFFSET $position";
            break;
    }
    $result = executeSQLResult($conn, $sql);
    $list_order = array();

    for ($i = 0; $i < count($result); $i++) {
        //get image
        $codeProduct = $result[$i]['MSHH'];
        $noOrder = $result[$i]['SoDonDH'];
        $nameCustomer = $result[$i]['HoTenKH'];
        $product = $result[$i]['TenHH'];
        $dayOrder = $result[$i]['NgayDH'];
        $dayShip = $result[$i]['NgayGH'];
        $statusOrder = $result[$i]['TrangThaiDH'];
        $quatity = $result[$i]['SoLuong'];
        $discount = $result[$i]['GiamGia'];
        $total = $result[$i]['GiaDatHang'];

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
    }
    echo json_encode($list_order, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}
