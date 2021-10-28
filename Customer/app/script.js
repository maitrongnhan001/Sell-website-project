//check input for form add-admin
function CheckUserName(UserName) {
    //check name is valid?
    const check = UserName.search(/\W/i);
    return (check === -1) ? true : false;
}

function CheckPassword(Password) {
    //check password is valid
    let status = 0;
    //haven't space
    if (Password.search(' ') !== -1) {
        return 0;
    }
    //length >= 8
    if (Password.length >= 8) {
        status++;
    }
    //have special characters
    if (Password.search(/\W/) !== -1) {
        status++;
    }
    //have number
    if (Password.search(/\d/) !== -1) {
        status++;
    }
    return status;
}

function CheckPhone(Phone) {
    //the first element is zero
    if (Phone[0] == 0 && (Phone.length === 10)) {
        return true;
    }
    return false;
}

function CheckSubmit() {
    //check all
    const UserName = $('input[name="username"]').val();
    const Password = $('input[name="password"]').val();
    const Phone = $('input[name="phone"]').val();
    if (CheckUserName(UserName) && (CheckPassword(Password) > 0) && CheckPhone(Phone)) {
        $('#register').removeAttr('disabled');
    } else {
        $('#register').prop('disabled', 'true');
    }
}

$('document').ready(() => {
    $('input[name="username"]').change(() => {
        //chck username
        const UserName = $('input[name="username"]').val();
        if (CheckUserName(UserName)) {
            $('#nofi-1').text("");
        } else {
            $('#nofi-1').text("Không đúng định dạng.");
        }
        CheckSubmit();
    });

    $('input[name="password"]').change(() => {
        //check password
        const Password = $('input[name="password"]').val();
        const status = CheckPassword(Password);
        switch (status) {
            case 0:
                $('#nofi-2').removeAttr('class');
                $('#nofi-2').addClass('red');
                $('#nofi-2').text('quá yếu');
                break;
            case 1:
                $('#nofi-2').removeAttr('class');
                $('#nofi-2').addClass('orange');
                $('#nofi-2').text('yếu');
                break;
            case 2:
                $('#nofi-2').removeAttr('class');
                $('#nofi-2').addClass('green');
                $('#nofi-2').text('Trung bình');
                break;
            case 3:
                $('#nofi-2').removeAttr('class');
                $('#nofi-2').addClass('green');
                $('#nofi-2').text('Mạnh');
                break;
        }
        CheckSubmit();
    });

    $('input[name="r-password"]').change(() => {
        //check confirm password
        const r_password = $('input[name="r-password"]').val();
        const password = $('input[name="password"]').val();
        if (r_password !== password) {
            $('#nofi-3').text("Không trùng khớp.");
            $('#register').prop('disabled', 'true');
        } else {
            $('#nofi-3').text("");
            $('#register').removeAttr('disabled');
        }
    });

    $('input[name="phone"]').change(() => {
        //check Phone
        const Phone = $('input[name="phone"]').val();
        if (CheckPhone(Phone)) {
            $('#nofi-4').text("");
        } else {
            $('#nofi-4').text("không đúng định dạng");
        }
        CheckSubmit();
    });

    $('input[name="qty"]').change(() => {
        //show total price
        const price = $('input[name="price"]').val();
        let quality = $('input[name="qty"]').val();
        if ($('input[name="qty"]').val() <= 0) {
            quality = 0;
            $('#nofi-1').text('Số lượng phải lớn hơn 0');
            $('#submit-order').prop('disabled', 'true');
            return;
        }
        $('#submit-order').removeAttr('disabled');
        const total_price = price * quality;
        $('#rt').text('VNĐ: ' + total_price);
    });

    //controll address
    $('#btn-new-address').click((e) => {
        e.preventDefault();
        $('input[name="address"]').prop('checked', false);
        $('#group-current-address').addClass('hide');
        $('input[name="address"]').prop('required', false);
        $('input[name="new-address"]').attr('required');
        $('#group-new-address').removeClass('hide');
    });

    $('#btn-current-address').click((e) => {
        e.preventDefault();
        $("#ipn-new-address").val('');
        $('input[name="new-address"]').removeAttr('required')
        $('#group-current-address').removeClass('hide');
        $('input[name="address"]').prop('required', true);
        $('#group-new-address').addClass('hide');
    });

    //load product
    $('#list-product-menu .container').on('click', '#load-product-index', () => {
        //because if user $("#load-product-index").click then dont't click element in following times
        //count element product
        var position = $('.product-menu-box').length;
        $.get(`http://localhost/B1805899_MTNhan/Customer/API/handle-api-product.php?position=${position}&limit=6`,
            (data, status, xhr) => {
                //render to display

                const list_product = JSON.parse(data);
                if (list_product.length > 0) {
                    $('#clearfix-load').remove();
                    $('#load-product-index').remove();
                } else {
                    $('#load-product-index').remove();
                    $('#list-product-menu .container').append('<p class="text-center">Đã hết sản phẩm</p>');
                    return;
                }

                for (let i = 0; i < list_product.length; i++) {
                    $('#list-product-menu .container').append(
                        `<div class="product-menu-box">
                            <div class="product-menu-img">
                                <img src='http://localhost/B1805899_MTNhan/images/products/${list_product[i].image_name}' alt="${list_product[i].food_name}" class="img-responsive img-curve">
                            </div>
                            <div class="product-menu-desc">
                                <h4>${list_product[i].name_product}</h4>
                                <p class="product-price">${list_product[i].price}</p>
                                <p class="product-detail">${list_product[i].description}</p>
                                <br>

                                <a href='http://localhost/B1805899_MTNhan/Customer/order.php?id=${list_product[i].id}' class="btn btn-primary">Mua ngay</a>
                            </div>
                        </div>`
                    );
                }

                $('#list-product-menu .container').append('<div id="clearfix-load" class="clearfix"></div>');
                $('#list-product-menu .container').append('<p id="load-product-index" class="text-center pink">Xem thêm sản phẩm</p>');
            }
        );
    });

    $('#list-product-menu .container').on('click', '#load-product', () => {
        //because if user $("#load-product").click then dont't click element in following times
        //count element product
        var position = $('.product-menu-box').length;
        $.get(`http://localhost/B1805899_MTNhan/Customer/API/handle-api-product.php?position=${position}&limit=12`,
            (data, status, xhr) => {
                //render to display

                const list_product = JSON.parse(data);
                if (list_product.length > 0) {
                    $('#clearfix-load').remove();
                    $('#load-product').remove();
                } else {
                    $('#load-product').remove();
                    $('#list-product-menu .container').append('<p id="load-product" class="text-center">Đã hết sản phẩm</p>');
                    return;
                }

                for (let i = 0; i < list_product.length; i++) {
                    $('#list-product-menu .container').append(
                        `<div class="product-menu-box">
                            <div class="product-menu-img">
                                <img src='http://localhost/B1805899_MTNhan/images/products/${list_product[i].image_name}' alt="${list_product[i].food_name}" class="img-responsive img-curve">
                            </div>
                            <div class="product-menu-desc">
                                <h4>${list_product[i].name_product}</h4>
                                <p class="product-price">${list_product[i].price}</p>
                                <p class="product-detail">${list_product[i].description}</p>
                                <br>

                                <a href='http://localhost/B1805899_MTNhan/Customer/order.php?id=${list_product[i].id}' class="btn btn-primary">Mua ngay</a>
                            </div>
                        </div>`
                    );
                }

                $('#list-product-menu .container').append('<div id="clearfix-load" class="clearfix"></div>');
                $('#list-product-menu .container').append('<p id="load-product" class="text-center pink">Xem thêm sản phẩm</p>');
            }
        );
    });

    //load category
    $('#list-categories .container').on('click', '#load-categories', () => {
        //because if user $("#load-product").click then dont't click element in following times
        //count element product
        var position = $('.box-3').length;
        $.get(`http://localhost/B1805899_MTNhan/Customer/API/handle-api-category.php?position=${position}&limit=12`,
            (data, status, xhr) => {
                //render to display
                const list_categories = JSON.parse(data);
                if (list_categories.length > 0) {
                    $('#clearfix-load').remove();
                    $('#load-categories').remove();
                } else {
                    $('#load-categories').remove();
                    $('#list-categories .container .container-category-center').append('<p class="text-center">Đã hết sản phẩm</p>');
                    return;
                }

                for (let i = 0; i < list_categories.length; i++) {
                    $('#list-categories .container .container-category-center').append(
                        `<a href="">
                            <div class="box-3 float-container">
    
                                <img src='http://localhost/B1805899_MTNhan/images/categories/${list_categories[i].image_name}'' width="330px" height="330px" alt="${list_categories[i].name_category}" class="img-curve">
                                <h3 class="float-text white">${list_categories[i].name_category}</h3>
                            </div>
                        </a>`
                    );
                }

                $('#list-categories .container .container-category-center').append('<div id="clearfix-load" class="clearfix"></div>');
                $('#list-categories .container .container-category-center').append('<p id="load-categories" class="text-center pink">Xem thêm danh mục</p>');
            }
        );
    });
});