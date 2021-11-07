<?php
include('../../Config/connect.php');
//request
if (isset($_GET['id'])) {
    //get product
    $id = $_GET['id'];
    $conn = connectToDatabase();
    $sql = "SELECT * FROM HangHoa 
                WHERE MSHH = $id";
    $result = executeSQLResult($conn, $sql);

    //convert to json
    try {
        $product = array(
            'id' => $id,
            'name_product' => $result[0]['TenHH'],
            'price' => $result[0]['Gia'],
            'description' => $result[0]['QuyCach']
        );
    } catch (Exception) {
        echo null;
    }
    echo json_encode($product, JSON_UNESCAPED_UNICODE);
    closeConnect($conn);
}
