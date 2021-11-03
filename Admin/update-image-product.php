//store image
// if ($imageName != "") {
//     //random name product
//     $extension = end(explode('.', $imageName));
//     $imageName = 'product_' . rand(0000, 9999) . '.' . $extension;
//     //delete image
//     $delete = unlink('../images/products/' . $products[0]['TenHinh']);
//     if (!$delete) {
//         unset($_POST['submit'], $_POST['Name-Product'], $_POST['Description'], $_POST['Price'], $_POST['Quality'], $_POST['Category'], $_FILES['Image-Product']['name']);
//         $_SESSION['status_product'] = 'Cập nhật sản phẩm thất bại';
//         header('Location: ' . URL . 'Admin/update-product.php?id=' . $id);
//         die();
//     }
//     //store image
//     $sourceFile = $_FILES['Image-Product']['tmp_name'];
//     $pathImage = "../images/products/$imageName";
//     $upload = move_uploaded_file($sourceFile, $pathImage);
//     //check store success?
//     if (!$upload) {
//         unset($_POST['submit'], $_POST['Name-Product'], $_POST['Description'], $_POST['Price'], $_POST['Quality'], $_POST['Category'], $_FILES['Image-Product']['name']);
//         $_SESSION['status_product'] = 'Cập nhật sản phẩm thất bại';
//         header('Location: ' . URL . 'Admin/update-product.php?id=' . $id);
//         die();
//     }
// } else {
//     $imageName = "";
// }

// insert data to table HinhHangHoa
// if ($imageName != "") {
//     $sql = "UPDATE HinhHangHoa SET
//                 TenHinh = '$imageName',
//                 MSHH = '$category'
//             WHERE MaHinh = $codeImage";
//     $result = $result && executeSQL($conn, $sql);
// }