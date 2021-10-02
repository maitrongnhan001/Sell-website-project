<?php
include('./layouts/header.php');
if (isset($_GET['id'])) {
    $codeProduct = $_GET['id'];
    //get data product
    $conn = connectToDatabase();
    $sql = "SELECT HangHoa.MSHH, TenHH, Gia, SoLuongHang, TenHinh 
            FROM HangHoa, LoaiHangHoa, HinhHangHoa 
            WHERE HangHoa.MaLoaiHang = LoaiHangHoa.MaLoaiHang
            AND HangHoa.MSHH = HinhHangHoa.MSHH LIMIT 6";
    $product = executeSQLResult($conn, $sql);
    $nameProduct = $product[0]['TenHH'];
    $price = $product[0]['Gia'];
    $quality = $product[0]['SoLuongHinh'];
    $pathImage = URL.'images/products/'.$product[0]['TenHinh'];
}
?>

<section class="product-order">
    <div class="container">

        <h2 class="text-center text-white">Điền thông tin vào form này để mua hàng.</h2>

        <form action="" class="order" method="POST">
            <fieldset>
                <legend>Sản phẩm đã chọn</legend>

                <div class="product-menu-img">
                    <img src=<?php echo $pathImage; ?> alt="No Iamge" class="img-responsive img-curve">
                </div>

                <div class="product-menu-desc">
                    <div class="row">
                        <div class="clearfix">
                            <h3>
                                <?php echo $nameProduct; ?>
                            </h3>
                            <p class="product-price">
                                VNĐ: <?php echo $price ?>
                            </p>

                            <input type="hidden" name="food" value="Product">
                            <input type="hidden" id="pr" name="price" value="100">
                        </div>
                        <div class="clearfix total-container">
                            <h3>Tổng</h3>
                            <p class="product-price" id="rt"></p>
                        </div>
                    </div>

                    <div class="order-label">Số lượng</div>
                    <input type="number" id="ipn" name="qty" class="input-responsive" value="1" required>

                </div>

            </fieldset>

            <fieldset>
                <legend>Thông tin liên lạc</legend>
                <div class="order-label">Số điện thoại</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                <div class="order-label">Địa chỉ</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

    </div>
</section>

<?php
closeConnect($conn);
include('./layouts/footer.php');
?>