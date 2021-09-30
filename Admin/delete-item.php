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
        //delete image
        $image = executeSQLResult($conn, "SELECT HinhAnh FROM LoaiHangHoa WHERE MaLoaiHang = $id");
        $image = $image[0]['HinhAnh'];
        $pathImage = '../images/categories/' . $image;
        $delete = unlink($pathImage);
        if (!$delete) {
            //delete error
            $_SESSION['error'] = 'Xoá Danh mục không thành công.';
            header('Location: ' . URL . '/Admin/manager-categories.php');
            closeConnect($conn);
            return;
        }
        //delete row in databas
        $sql = "DELETE FROM LoaiHangHoa WHERE MaLoaiHang = $id";
        $result = executeSQL($conn, $sql);
        closeConnect($conn);
        if ($result) {
            //delete successfully
            $_SESSION['status_category'] = 'Xoá danh mục thành công.';
            header('Location: ' . URL . '/Admin/manager-categories.php');
        } else {
            //delete error
            $_SESSION['error'] = 'Xoá danh mục không thành công.';
            header('Location: ' . URL . '/Admin/manager-categories.php');
        }
        return $result;
    }
    if ($type == 3) {
        require('../Debug/Debug.php');
        //delete image
        $sql = "SELECT TenHinh FROM HinhHangHoa WHERE MSHH = $id";
        $listImageName = executeSQLResult($conn, $sql);
        for ($i = 0; $i < count($listImageName); $i++) {
            $pathImage = '../images/products/' . $listImageName[$i]['TenHinh'];
            $delete  = unlink($pathImage);
            if (!$delete) {
                //delete error
                $_SESSION['error'] = 'Xoá sản phẩm không thành công.';
                header('Location: ' . URL . '/Admin/manager-products.php');
                closeConnect($conn);
                return;
            }
        }
        //delete table HinhHanHoa
        $sql = "DELETE FROM HinhHangHoa WHERE MSHH = $id";
        $result = executeSQL($conn, $sql);
        //delete table HangHoa
        $sql = "DELETE FROM HangHoa WHERE MSHH = $id";
        $result = $result && executeSQL($conn, $sql);
        closeConnect($conn);
        if ($result) {
            //delete successfully
            $_SESSION['status_product'] = 'Xoá sản phẩm thành công.';
            header('Location: ' . URL . '/Admin/manager-products.php');
        } else {
            //delete error
            $_SESSION['error'] = 'Xoá sản phẩm không thành công.';
            header('Location: ' . URL . '/Admin/manager-products.php');
        }
        return $result;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    unset($_GET['id'], $_GET['type']);
    deleteItem($type, $id);
}
