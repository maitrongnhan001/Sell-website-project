<?php
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'Quanlydathang');
define('URL', 'http://localhost/B1805899_MTNHAN/');
session_start();

function connectToDatabase () {
    //connect to database
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    if ($conn -> connect_error) {
        die();
    }
    return $conn;
}

function executeSQL ($conn, $sql) {
    //execute sql and no return result
    if ($conn -> connect_error) {
        die();
    }
    $result = mysqli_query($conn, $sql);
    return $result;
}

function executeSQLResult ($conn, $sql) {
    //execute sql and return result
    if ($conn -> connect_error) {
        die();
    }
    $result = mysqli_query($conn, $sql);
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $data[] = $row;
    }
    return $data;
}

function closeConnect ($conn) {
    if ($conn -> connect_error) {
        die();
    }
    $conn -> close();
}

?>