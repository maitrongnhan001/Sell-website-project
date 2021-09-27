<?php
include('../Config/connect.php');
function deleteItem($type, $id)
{
    /*
        type ?
            1 delete admin
            2 delete categogy
            3 delete product
    */
    $conn = connectToDatabase();
    if ($type == 1) {
        $sql = "DELETE FROM NhanVien WHERE MSNV = $id";
        $result = executeSQL($conn, $sql);
        closeConnect($conn);
        if ($result) {
            //delete successfully
            $_SESSION['status_user'] = 'Xoá nhân viên thành công.';
            header('Location: ' . URL . '/Admin/manager-admin.php');
        } else {
            //delete error
            $_SESSION['error'] = 'Xoá nhân viên không thành công.';
            header('Location: ' . URL . '/Admin/manager-admin.php');
        }
        return $result;
    }
    if ($type == 2) {
        $sql = "DELETE FROM LoaiHangHoa WHERE MSNV = $id";
        $result = executeSQL($conn, $sql);
        closeConnect($conn);
        return $result;
    }
    if ($type == 3) {
        $sql = "DELETE FROM HangHoa WHERE MSNV = $id";
        $result = executeSQL($conn, $sql);
        closeConnect($conn);
        return $result;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    unset($_GET['id'], $_GET['type']);
    deleteItem($type, $id);
}
