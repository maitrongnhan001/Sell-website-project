<?php
ob_start();

include('../Config/connect.php');
function deleteItem($type, $id)
{
    /*
        type ?
            1 delete admin
            2 delete categogy
            3 delete product
            4 delete image
    */
    $conn = connectToDatabase();
    if ($type == 1) {
        //check user is admin
        if (isset($_SESSION['position'])) {
            if (!($_SESSION['position'] == "Quản lý")) {
                $_SESSION['error'] = "Bạn không có quyền sử dụng tính năng này";
                header('location: ' . URL . '/admin/manager-admin.php');
                closeConnect($conn);
                die();
            }
        } else {
            header('location: ' . URL . '/admin/login.php');
            closeConnect($conn);
            die();
        }

        //delete admin
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
        //check user is stocker
        if (isset($_SESSION['position'])) {
            if ($_SESSION['position'] == "Bán hàng") {
                $_SESSION['error'] = "Bạn không có quyền sử dụng tính năng này";
                header('location: ' . URL . '/admin/manager-categories.php');
                die();
            }
        } else {
            header('location: ' . URL . '/admin/login.php');
            die();
        }

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
        //check user is stocker
        if (isset($_SESSION['position'])) {
            if ($_SESSION['position'] == "Bán hàng") {
                $_SESSION['error'] = "Bạn không có quyền sử dụng tính năng này";
                header('location: ' . URL . '/admin/manager-products.php');
                die();
            }
        } else {
            header('location: ' . URL . '/admin/login.php');
            die();
        }

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

    if ($type == 4) {
        //delete image
        $sql = "SELECT * FROM HinhHangHoa WHERE MaHinh = $id";
        $listImageName = executeSQLResult($conn, $sql);
        $pathImage = '../images/products/' . $listImageName[0]['TenHinh'];
        $id_product = $listImageName[0]['MSHH'];
        
        //check amount image > 1
        $sql = "SELECT COUNT(MaHinh) as SoLuongHinh FROM HinhHangHoa WHERE MSHH = $id_product";
       
        $amount_image = executeSQLResult($conn, $sql);
        if ($amount_image[0]['SoLuongHinh'] <= 1) {
             //delete error
             $_SESSION['error'] = 'chỉ còn một hình, không thể xoá.';
             header('Location: ' . URL . '/Admin/manager-image.php?id='.$id_product);
             closeConnect($conn);
             return;
        }

        $delete  = unlink($pathImage);
        if (!$delete) {
            //delete error
            $_SESSION['error'] = 'Xoá sản phẩm không thành công.';
            header('Location: ' . URL . '/Admin/manager-image.php?id='.$id_product);
            closeConnect($conn);
            return;
        }

        //delete table HinhHanHoa
        $sql = "DELETE FROM HinhHangHoa WHERE MaHinh = $id";
        $result = executeSQL($conn, $sql);

        closeConnect($conn);
        
        if ($result) {
            //delete successfully
            $_SESSION['status-image'] = 'Xoá hình ảnh thành công.';
            header('Location: ' . URL . '/Admin/manager-image.php?id='.$id_product);
        } else {
            //delete error
            $_SESSION['error'] = 'Xoá sản phẩm không thành công.';
            header('Location: ' . URL . '/Admin/manager-image.php?id='.$id_product);
        }
        return $result;
    }
}

//check id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    unset($_GET['id'], $_GET['type']);
    deleteItem($type, $id);
}

ob_end_flush();
