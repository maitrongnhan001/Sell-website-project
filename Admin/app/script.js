//config
const URL = `http://localhost/B1805899_MTNhan/`;

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
    const UserName = $('input[name="UserName"]').val();
    const Password = $('input[name="Password"]').val();
    const Phone = $('input[name="Phone"]').val();
    if (CheckUserName(UserName) && (CheckPassword(Password) > 0) && CheckPhone(Phone)) {
        $('#register').removeAttr('disabled');
    } else {
        $('#register').prop('disabled', 'true');
    }
}

function checkDayShip() {
    var dateOrder = $('input[name="dayOrder"]').val().split("-");;
    const dayOrder = dateOrder[2];
    const monthOrder = dateOrder[1];
    const yearOrder = dateOrder[0];
    var dateOrder = new Date(yearOrder, monthOrder, dayOrder);
    var dateShip = $("input[name='dayShip']").val().split("-");
    const dayShip = dateShip[2];
    const monthShip = dateShip[1];
    const yearShip = dateShip[0];
    var dateShip = new Date(yearShip, monthShip, dayShip);
    let reuslt = true;
    if (dateOrder.getTime() > dateShip.getTime()) {
        $('#nofi-2').text("Ngày giao hàng phải lớn hơn ngày đặt hàng");
        reuslt = false;
    } else {
        $('#nofi-2').text("");
        reuslt = true;
    }
    return reuslt;
}

function checkDiscount() {
    let result = true;
    if ($("input[name='discount']").val() >= 0) {
        $('#nofi-1').text('');
        reuslt = true;
    } else {
        $('#nofi-1').text("Số lượng phải lớn hơn hoặt bằng không");
        result = false;
    }
    return result;
}

$('document').ready(() => {

    $('input[name="UserName"]').change(() => {
        //chck username
        const UserName = $('input[name="UserName"]').val();
        if (CheckUserName(UserName)) {
            $('#nofi-2').text("");
        } else {
            $('#nofi-2').text("Không đúng định dạng.");
        }
        CheckSubmit();
    });

    $('input[name="Password"]').change(() => {
        //check password
        const Password = $('input[name="Password"]').val();
        const status = CheckPassword(Password);
        switch (status) {
            case 0:
                $('#nofi-3').removeAttr('class');
                $('#nofi-3').addClass('red');
                $('#nofi-3').text('quá yếu');
                break;
            case 1:
                $('#nofi-3').removeAttr('class');
                $('#nofi-3').addClass('orange');
                $('#nofi-3').text('yếu');
                break;
            case 2:
                $('#nofi-3').removeAttr('class');
                $('#nofi-3').addClass('green');
                $('#nofi-3').text('Trung bình');
                break;
            case 3:
                $('#nofi-3').removeAttr('class');
                $('#nofi-3').addClass('green');
                $('#nofi-3').text('Mạnh');
                break;
        }
        CheckSubmit();
    });

    $('input[name="Phone"]').change(() => {
        //check Phone
        const Phone = $('input[name="Phone"]').val();
        if (CheckPhone(Phone)) {
            $('#nofi-4').text("");
        } else {
            $('#nofi-4').text("không đúng định dạng");
        }
        CheckSubmit();
    });

    $('#image-upload-cagegory').change(() => {
        $('#img-review').empty();
        var File = new FileReader();
        File.readAsDataURL($('#image-upload-cagegory').prop('files')[0]);
        File.onload = (e) => {
            $('#img-review').append("<img class='format-img-review img-category' width=300px height=300px src='" + e.target.result + "' >")
        }
    });

    $("#group-input-img").on('change', '#image-upload', (e) => {

        //because if user  $('#image-upload').change() then dont't click element in following times
        const number_image = e.target.files.length;
        if (number_image <= 6) {
            //clear element
            $("#img-review").empty();
            $("#nofi-5").text("");
            $('#text-review-img').remove();

            //render list image to screen
            $("#img-review").append(
                `<div class="slider-content">
                    <div id='slider-img-review'></div>
                    <div class="slider-control" id="list-btn-slides"></div>
                 </div>`
            );

            //render btn
            const array_img = Object.keys(e.target.files);
            array_img.forEach((element, i) => {
                File = new FileReader();
                File.readAsDataURL($('#image-upload').prop('files')[i]);

                //add button slide
                if (i == 0) {
                    //first image is select
                    //add image
                    File.onload = (e) => {
                        $('#slider-img-review').append(
                            `<img class="my-slides" width=470px height=310px id="img-${i + 1}" src="${e.target.result}">`
                        );
                    }

                    //add button silde
                    $("#list-btn-slides").append(
                        `<span class="btn-slider-small forcus" id="btn-${i + 1}"></span>`
                    );
                } else {
                    //add image
                    File.onload = (e) => {
                        $('#slider-img-review').append(
                            `<img class="my-slides hide" width=470px height=310px id="img-${i + 1}" src="${e.target.result}">`
                        );
                    }

                    //add button silde
                    $("#list-btn-slides").append(
                        `<span class="btn-slider-small" id="btn-${i + 1}"></span>`
                    );
                }
            });
            $("#list-btn-slides").append("<div class='clearfix'></div>")

            //listening btn slides
            //listening click button sildes
            $(`#btn-1`).click(() => {
                const id_element = $(`#btn-1`).attr("id");
                const current_forcus_element = $('.slider-control').find('.forcus');
                current_forcus_element.removeClass('forcus');
                $(`#${id_element}`).addClass('forcus');

                //hide all img
                $(".my-slides").addClass('hide');

                //show image choose
                const position_img_element = id_element[id_element.length - 1];
                const id_img = `img-${position_img_element}`;
                $(`#${id_img}`).removeClass("hide");
            });
            $(`#btn-2`).click(() => {
                const id_element = $(`#btn-2`).attr("id");
                const current_forcus_element = $('.slider-control').find('.forcus');
                current_forcus_element.removeClass('forcus');
                $(`#${id_element}`).addClass('forcus');

                //hide all img
                $(".my-slides").addClass('hide');

                //show image choose
                const position_img_element = id_element[id_element.length - 1];
                const id_img = `img-${position_img_element}`;
                $(`#${id_img}`).removeClass("hide");
            });
            $(`#btn-3`).click(() => {
                const id_element = $(`#btn-3`).attr("id");
                const current_forcus_element = $('.slider-control').find('.forcus');
                current_forcus_element.removeClass('forcus');
                $(`#${id_element}`).addClass('forcus');

                //hide all img
                $(".my-slides").addClass('hide');

                //show image choose
                const position_img_element = id_element[id_element.length - 1];
                const id_img = `img-${position_img_element}`;
                $(`#${id_img}`).removeClass("hide");
            });
            $(`#btn-4`).click(() => {
                const id_element = $(`#btn-4`).attr("id");
                const current_forcus_element = $('.slider-control').find('.forcus');
                current_forcus_element.removeClass('forcus');
                $(`#${id_element}`).addClass('forcus');

                //hide all img
                $(".my-slides").addClass('hide');

                //show image choose
                const position_img_element = id_element[id_element.length - 1];
                const id_img = `img-${position_img_element}`;
                $(`#${id_img}`).removeClass("hide");
            });
            $(`#btn-5`).click(() => {
                const id_element = $(`#btn-5`).attr("id");
                const current_forcus_element = $('.slider-control').find('.forcus');
                current_forcus_element.removeClass('forcus');
                $(`#${id_element}`).addClass('forcus');

                //hide all img
                $(".my-slides").addClass('hide');

                //show image choose
                const position_img_element = id_element[id_element.length - 1];
                const id_img = `img-${position_img_element}`;
                $(`#${id_img}`).removeClass("hide");
            });
            $(`#btn-6`).click(() => {
                const id_element = $(`#btn-6`).attr("id");
                const current_forcus_element = $('.slider-control').find('.forcus');
                current_forcus_element.removeClass('forcus');
                $(`#${id_element}`).addClass('forcus');

                //hide all img
                $(".my-slides").addClass('hide');

                //show image choose
                const position_img_element = id_element[id_element.length - 1];
                const id_img = `img-${position_img_element}`;
                $(`#${id_img}`).removeClass("hide");
            });
        } else {
            //notification error
            $("#nofi-5").text("Số lượng hình ảnh không được nhiều hơn 6");
        }
    });

    //slides
    $("#btn-1").click(() => {
        const id_element = $("#btn-1").attr("id");
        const current_forcus_element = $('.slider-control').find('.forcus');
        current_forcus_element.removeClass('forcus');
        $(`#${id_element}`).addClass('forcus');

        //hide all img
        $(".my-slides").addClass('hide');

        //show image choose
        const position_img_element = id_element[id_element.length - 1];
        const id_img = `img-${position_img_element}`;
        $(`#${id_img}`).removeClass("hide");
    });

    $("#btn-2").click(() => {
        const id_element = $("#btn-2").attr("id");
        const current_forcus_element = $('.slider-control').find('.forcus');
        current_forcus_element.removeClass('forcus');
        $(`#${id_element}`).addClass('forcus');

        //hide all img
        $(".my-slides").addClass('hide');

        //show image choose
        const position_img_element = id_element[id_element.length - 1];
        const id_img = `img-${position_img_element}`;
        $(`#${id_img}`).removeClass("hide");
    });

    $("#btn-3").click(() => {
        const id_element = $("#btn-3").attr("id");
        const current_forcus_element = $('.slider-control').find('.forcus');
        current_forcus_element.removeClass('forcus');
        $(`#${id_element}`).addClass('forcus');

        //hide all img
        $(".my-slides").addClass('hide');

        //show image choose
        const position_img_element = id_element[id_element.length - 1];
        const id_img = `img-${position_img_element}`;
        $(`#${id_img}`).removeClass("hide");
    });

    $("#btn-4").click(() => {
        const id_element = $("#btn-4").attr("id");
        const current_forcus_element = $('.slider-control').find('.forcus');
        current_forcus_element.removeClass('forcus');
        $(`#${id_element}`).addClass('forcus');

        //hide all img
        $(".my-slides").addClass('hide');

        //show image choose
        const position_img_element = id_element[id_element.length - 1];
        const id_img = `img-${position_img_element}`;
        $(`#${id_img}`).removeClass("hide");
    });

    $("#btn-5").click(() => {
        const id_element = $("#btn-5").attr("id");
        const current_forcus_element = $('.slider-control').find('.forcus');
        current_forcus_element.removeClass('forcus');
        $(`#${id_element}`).addClass('forcus');

        //hide all img
        $(".my-slides").addClass('hide');

        //show image choose
        const position_img_element = id_element[id_element.length - 1];
        const id_img = `img-${position_img_element}`;
        $(`#${id_img}`).removeClass("hide");
    });

    $("#btn-6").click(() => {
        const id_element = $("#btn-6").attr("id");
        const current_forcus_element = $('.slider-control').find('.forcus');
        current_forcus_element.removeClass('forcus');
        $(`#${id_element}`).addClass('forcus');

        //hide all img
        $(".my-slides").addClass('hide');

        //show image choose
        const position_img_element = id_element[id_element.length - 1];
        const id_img = `img-${position_img_element}`;
        $(`#${id_img}`).removeClass("hide");
    });

    //check price and quality
    $('#price').change(() => {
        const price = $('#price').val();
        if (price <= 0) {
            $('#nofi-2').text('Giá phải lớn hơn 0');
            $('#register').prop('disabled', 'true');
        } else {
            $('#nofi-2').text('');
            const quality = $('#quality').val();
            if (quality > 0) {
                $('#register').removeAttr('disabled');
            }
        }
    });

    $('#quality').change(() => {
        const quality = $('#quality').val();
        if (quality <= 0) {
            $('#nofi-3').text('Số lượng phải lớn hơn 0');
            $('#register').prop('disabled', 'true');
        } else {
            $('#nofi-3').text('');
            const price = $('#price').val();
            if (price > 0) {
                $('#register').removeAttr('disabled');
            }
        }
    });


    let checkSubmit = true;
    //check discount > 0
    $("input[name='discount']").change(() => {
        if (checkDiscount() && checkDayShip()) {
            $('#update-order').removeAttr('disabled');
        } else {
            $('#update-order').prop('disabled', 'true');
        }
    });

    //check update order
    $("input[name='dayShip']").change(() => {
        if (checkDiscount() && checkDayShip()) {
            $('#update-order').removeAttr('disabled');
        } else {
            $('#update-order').prop('disabled', 'true');
        }
    });

    //handle click nofication
    $("#btn-notification").click(() => {
        $('#notification-order').removeClass('hide');
    });

    $("#btn-close-notification").click(() => {
        $('#notification-order').addClass('hide');
    });

    //auto fill name product and total price
    $('input[name="code-product"]').change(() => {
        const code_product = $('input[name="code-product"]').val();

        //use api to get name and price
        $.get(`http://localhost/B1805899_MTNhan/Admin/API/get-product-id.php?id=${code_product}`,
            (data, status, xhr) => {
                const product = JSON.parse(data);

                const price = product.price;
                const quatity = $('input[name="quatity"]').val();
                const name_product = product.name_product;
                const total = price * quatity;

                //render name and price to display
                $('input[name="name-product"]').val(name_product);

                if (quatity <= 0) {
                    $('input[name="price"]').val(price);
                } else {
                    $('input[name="price"]').val(total);
                }

                $('input[name="quatity"]').change(() => {
                    const quatity = $('input[name="quatity"]').val();
                    const total = price * quatity;

                    if (quatity <= 0) {
                        $('input[name="price"]').val(price);
                    } else {
                        $('input[name="price"]').val(total);
                    }
                });
            });
    });

    //load more product
    $('#load-product').click(() => {
        //count element product
        var position = $('.tbl-manager tr').length - 1;
        //load
        $.get(`http://localhost/B1805899_MTNhan/Admin/API/handle-api-product.php?position=${position}&limit=10`,
            (data, status, xhr) => {
                //render to display

                const list_product = JSON.parse(data);

                for (let i = 0; i < list_product.length; i++) {
                    const code_product = list_product[i]['id'];
                    const nameProduct = list_product[i]['name_product'];
                    const description = list_product[i]['description'];
                    const price = list_product[i]['price'];
                    const quality = list_product[i]['quatity'];
                    const category = list_product[i]['category'];
                    const path_image = `${URL}images/products/${list_product[i]['image_name']}`

                    if ((i + 1 + position) % 2 === 0) {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${position + i + 1} </td>
                                <td class="name-product"> ${nameProduct} </td>
                                <td class="description">
                                    <div class="limit-height"> ${description} </div>
                                </td>
                                <td>VNĐ: ${price} </td>
                                <td> ${quality} </td>
                                <td> ${category} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td>
                                    <a href='${`${URL}admin/update-product.php?id=${code_product}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_product}&type=3`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    } else {
                        $('.container table').append(
                            `
                            <tr class="white text-center">
                                <td> ${position + i + 1} </td>
                                <td class="name-product"> ${nameProduct} </td>
                                <td class="description">
                                    <div class="limit-height"> ${description} </div>
                                </td>
                                <td>VNĐ: ${price} </td>
                                <td> ${quality} </td>
                                <td> ${category} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td>
                                    <a href='${`${URL}admin/update-product.php?id=${code_product}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_product}&type=3`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    }
                }
            });
    });

    //load more category
    $('#load-category').click(() => {
        //count element product
        var position = $('.tbl-manager tr').length - 1;
        //load
        $.get(`http://localhost/B1805899_MTNhan/Admin/API/handle-api-category.php?position=${position}&limit=10`,
            (data, status, xhr) => {
                //render to display

                const list_category = JSON.parse(data);

                for (let i = 0; i < list_category.length; i++) {
                    const code_category = list_category[i]['id'];
                    const name_category = list_category[i]['name_category'];
                    const path_image = `${URL}images/categories/${list_category[i]['image_name']}`

                    if ((i + 1 + position) % 2 === 0) {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${position + i + 1} </td>
                                <td> ${name_category} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td>
                                    <a href='${`${URL}admin/update-category.php?id=${code_category}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_category}&type=2`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    } else {
                        $('.container table').append(
                            `
                            <tr class="white text-center">
                                <td> ${position + i + 1} </td>
                                <td> ${name_category} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td>
                                    <a href='${`${URL}admin/update-category.php?id=${code_category}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_category}&type=2`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    }
                }
            });
    });

    //load more admin
    $('#load-admin').click(() => {
        //count element product
        var position = $('.tbl-manager tr').length - 1;
        //load
        $.get(`http://localhost/B1805899_MTNhan/Admin/API/handle-api-admin.php?position=${position}&limit=10`,
            (data, status, xhr) => {
                //render to display

                const list_admin = JSON.parse(data);

                for (let i = 0; i < list_admin.length; i++) {
                    const code_admin = list_admin[i]['id'];
                    const name_admin = list_admin[i]['name_admin'];
                    const position_admin = list_admin[i]['position'];
                    const address = list_admin[i]['address'];
                    const phone = list_admin[i]['phone'];

                    if ((i + 1 + position) % 2 !== 0) {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${position + i + 1} </td>
                                <td> ${name_admin} </td>
                                <td> ${position_admin} </td>
                                <td> ${address} </td>
                                <td> ${phone} </td>
                                <td>
                                    <a href='${`${URL}admin/update-admin.php?id=${code_admin}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_admin}&type=1`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    } else {
                        $('.container table').append(
                            `
                            <tr class="white text-center">
                                <td> ${position + i + 1} </td>
                                <td> ${name_admin} </td>
                                <td> ${position_admin} </td>
                                <td> ${address} </td>
                                <td> ${phone} </td>
                                <td>
                                    <a href='${`${URL}admin/update-admin.php?id=${code_admin}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_admin}&type=1`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    }
                }
            });
    });

    //load more customer
    $('#load-customer').click(() => {
        //count element product
        var position = $('.tbl-manager tr').length - 1;
        //load
        $.get(`http://localhost/B1805899_MTNhan/Admin/API/handle-api-customer.php?position=${position}&limit=10`,
            (data, status, xhr) => {
                //render to display

                const list_customer = JSON.parse(data);

                for (let i = 0; i < list_customer.length; i++) {
                    const code_customer = list_customer[i]['id'];
                    const name_customer = list_customer[i]['name_customer'];
                    const company = list_customer[i]['company'];
                    const phone = list_customer[i]['phone'];
                    const fax = list_customer[i]['fax'];

                    if ((i + 1 + position) % 2 === 0) {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${position + i + 1} </td>
                                <td> ${name_customer} </td>
                                <td> ${company} </td>
                                <td> ${phone} </td>
                                <td> ${fax} </td>
                            </tr>
                            `
                        );
                    } else {
                        $('.container table').append(
                            `
                            <tr class="white text-center">
                                <td> ${position + i + 1} </td>
                                <td> ${name_customer} </td>
                                <td> ${company} </td>
                                <td> ${phone} </td>
                                <td> ${fax} </td>
                            </tr>
                            `
                        );
                    }
                }
            });
    });

    //load more order
    $('#load-order').click(() => {
        //get filter
        const filter = $("input[name='filter']").val();

        //count element product
        var position = $('.tbl-manager tr').length - 1;
        //load
        $.get(`http://localhost/B1805899_MTNhan/Admin/API/handle-api-order.php?position=${position}&limit=10&filter=${filter}`,
            (data, status, xhr) => {
                //render to display

                const list_order = JSON.parse(data);

                for (let i = 0; i < list_order.length; i++) {
                    const code_order = list_order[i]['id'];
                    const code_product = list_order[i]['codeProduct'];
                    const name_customer = list_order[i]['nameCustomer'];
                    const product = list_order[i]['product'];
                    const day_order = list_order[i]['dayOrder'];
                    const day_ship = list_order[i]['dayShip'];
                    const status_order = list_order[i]['statusOrder'];
                    const quatity = list_order[i]['quatity'];
                    const discount = list_order[i]['discount'];
                    const total = list_order[i]['total'];
                    const path_image = `${URL}images/products/${list_order[i]['image']}`

                    if ((i + 1 + position) % 2 === 0) {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${i + 1 + position} </td>
                                <td> ${name_customer} </td>
                                <td> ${product} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td class="day-order"> ${day_order} </td>
                                <td class="day-order"> ${day_ship} </td>
                                <td> ${status_order} </td>
                                <td> ${quatity} </td>
                                <td> ${discount} </td>
                                <td> ${total} </td>
                                <td>
                                    <a href='${URL}admin/update-order.php?noOrder=${code_order}&filter=${filter}' class="btn-primary">Cập nhật</a>
                                    <a href='${URL}admin/cancel-order.php?noOrder=${code_order}&filter=${filter}'' class="btn-danger">Huỷ đơn</a>
                                </td>
                            </tr>
                            `
                        );
                    } else {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${i + 1 + position} </td>
                                <td> ${name_customer} </td>
                                <td> ${product} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td class="day-order"> ${day_order} </td>
                                <td class="day-order"> ${day_ship} </td>
                                <td> ${status_order} </td>
                                <td> ${quatity} </td>
                                <td> ${discount} </td>
                                <td> ${total} </td>
                                <td>
                                    <a href='${URL}admin/update-order.php?noOrder=${code_order}&filter=${filter}' class="btn-primary">Cập nhật</a>
                                    <a href='${URL}admin/cancel-order.php?noOrder=${code_order}&filter=${filter}'' class="btn-danger">Huỷ đơn</a>
                                </td>
                            </tr>
                            `
                        );
                    }
                }
            });
    });

    //load search product
    $('#load-search-product').click(() => {
        //get filter
        const search = $('input[name="search"]').val();

        if (search.length === 0) {
            return;
        }

        //load
        $.get(`http://localhost/B1805899_MTNhan/Admin/API/handle-api-search-product.php?search=${search}`,
            (data, status, xhr) => {
                //render to display

                const list_product = JSON.parse(data);

                //clean table
                $('.container table').empty();
                $('.container table').append(`
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Quy cách</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Loại hàng</th>
                    <th>Hình ảnh</th>
                    <th>Quản lý</th>
                </tr>
                `);
                $('#load-product').remove();

                for (let i = 0; i < list_product.length; i++) {
                    const code_product = list_product[i]['id'];
                    const nameProduct = list_product[i]['name_product'];
                    const description = list_product[i]['description'];
                    const price = list_product[i]['price'];
                    const quality = list_product[i]['quatity'];
                    const category = list_product[i]['category'];
                    const path_image = `${URL}images/products/${list_product[i]['image_name']}`

                    if ((i + 1) % 2 === 0) {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${i + 1} </td>
                                <td class="name-product"> ${nameProduct} </td>
                                <td class="description">
                                    <div class="limit-height"> ${description} </div>
                                </td>
                                <td>VNĐ: ${price} </td>
                                <td> ${quality} </td>
                                <td> ${category} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td>
                                    <a href='${`${URL}admin/update-product.php?id=${code_product}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_product}&type=3`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    } else {
                        $('.container table').append(
                            `
                            <tr class="white text-center">
                                <td> ${i + 1} </td>
                                <td class="name-product"> ${nameProduct} </td>
                                <td class="description">
                                    <div class="limit-height"> ${description} </div>
                                </td>
                                <td>VNĐ: ${price} </td>
                                <td> ${quality} </td>
                                <td> ${category} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td>
                                    <a href='${`${URL}admin/update-product.php?id=${code_product}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_product}&type=3`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    }
                }
            });
    });

     //load search category
     $('#load-search-category').click(() => {
        //get filter
        const search = $('input[name="search"]').val();

        if (search.length === 0) {
            return;
        }

        //load category
        $.get(`http://localhost/B1805899_MTNhan/Admin/API/handle-api-search-category.php?search=${search}`,
            (data, status, xhr) => {
                //render to display

                const list_category = JSON.parse(data);

                //clean table
                $('.container table').empty();
                $('.container table').append(`
                <tr>
                    <th>STT</th>
                    <th>Tên danh mục</th>
                    <th>Hình ảnh</th>
                    <th>Quản lý</th>
                </tr>
                `);
                $('#load-category').remove();

                for (let i = 0; i < list_category.length; i++) {
                    const code_category = list_category[i]['id'];
                    const name_category = list_category[i]['name_category'];
                    const path_image = `${URL}images/categories/${list_category[i]['image_name']}`

                    if ((i + 1) % 2 === 0) {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${i + 1} </td>
                                <td> ${name_category} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td>
                                    <a href='${`${URL}admin/update-category.php?id=${code_category}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_category}&type=2`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    } else {
                        $('.container table').append(
                            `
                            <tr class="white text-center">
                                <td> ${i + 1} </td>
                                <td> ${name_category} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td>
                                    <a href='${`${URL}admin/update-category.php?id=${code_category}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_category}&type=2`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    }
                }
            });
    });

    //load search admin
    $('#load-search-admin').click(() => {
        //get filter
        const search = $('input[name="search"]').val();

        if (search.length === 0) {
            return;
        }

        //load admin
        $.get(`http://localhost/B1805899_MTNhan/Admin/API/handle-api-search-admin.php?search=${search}`,
            (data, status, xhr) => {
                //render to display

                const list_admin = JSON.parse(data);

                //clean table
                $('.container table').empty();
                $('.container table').append(`
                <tr>
                    <th>STT</th>
                    <th>Họ và Tên</th>
                    <th>Chức vụ</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Quản lý</th>
                </tr>
                `);
                $('#load-admin').remove();

                for (let i = 0; i < list_admin.length; i++) {
                    const code_admin = list_admin[i]['id'];
                    const name_admin = list_admin[i]['name_admin'];
                    const position_admin = list_admin[i]['position'];
                    const address = list_admin[i]['address'];
                    const phone = list_admin[i]['phone'];

                    if ((i + 1) % 2 !== 0) {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${i + 1} </td>
                                <td> ${name_admin} </td>
                                <td> ${position_admin} </td>
                                <td> ${address} </td>
                                <td> ${phone} </td>
                                <td>
                                    <a href='${`${URL}admin/update-admin.php?id=${code_admin}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_admin}&type=1`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    } else {
                        $('.container table').append(
                            `
                            <tr class="white text-center">
                                <td> ${i + 1} </td>
                                <td> ${name_admin} </td>
                                <td> ${position_admin} </td>
                                <td> ${address} </td>
                                <td> ${phone} </td>
                                <td>
                                    <a href='${`${URL}admin/update-admin.php?id=${code_admin}`}' class="btn-primary">Cập nhật</a>
                                    <a href='${`${URL}admin/delete-item.php?id=${code_admin}&type=1`}' class="btn-danger">Xoá</a>
                                    <div class="clear-fix"></div>
                                </td>
                            </tr>
                            `
                        );
                    }
                }
            });
    });

    //load search customer
    $('#load-search-customer').click(() => {
        //get filter
        const search = $('input[name="search"]').val();

        if (search.length === 0) {
            return;
        }

        //load customer
        $.get(`http://localhost/B1805899_MTNhan/Admin/API/handle-api-search-customer.php?search=${search}`,
            (data, status, xhr) => {
                //render to display

                const list_customer = JSON.parse(data);

                //clean table
                $('.container table').empty();
                $('.container table').append(`
                <tr>
                    <th>STT</th>
                    <th>Họ và Tên</th>
                    <th>Tên công ty</th>
                    <th>Số điện thoại</th>
                    <th>Số fax</th>
                </tr>
                `);
                $('#load-customer').remove();

                for (let i = 0; i < list_customer.length; i++) {
                    const code_customer = list_customer[i]['id'];
                    const name_customer = list_customer[i]['name_customer'];
                    const company = list_customer[i]['company'];
                    const phone = list_customer[i]['phone'];
                    const fax = list_customer[i]['fax'];

                    if ((i + 1) % 2 === 0) {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${i + 1} </td>
                                <td> ${name_customer} </td>
                                <td> ${company} </td>
                                <td> ${phone} </td>
                                <td> ${fax} </td>
                            </tr>
                            `
                        );
                    } else {
                        $('.container table').append(
                            `
                            <tr class="white text-center">
                                <td> ${i + 1} </td>
                                <td> ${name_customer} </td>
                                <td> ${company} </td>
                                <td> ${phone} </td>
                                <td> ${fax} </td>
                            </tr>
                            `
                        );
                    }
                }
            });
    });

    //load search order
    $('#load-search-order').click(() => {
        //get filter
        const search = $('input[name="search"]').val();

        if (search.length === 0) {
            return;
        }

        //load order
        $.get(`http://localhost/B1805899_MTNhan/Admin/API/handle-api-search-order.php?search=${search}`,
            (data, status, xhr) => {
                //render to display

                const list_order = JSON.parse(data);

                //clean table
                $('.container table').empty();
                $('.container table').append(`
                <tr>
                    <th>STT</th>
                    <th>Tên khách hàng</th>
                    <th>Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Ngày ĐH</th>
                    <th>Ngày GH</th>
                    <th>Trạng thái ĐH</th>
                    <th>Số lượng</th>
                    <th>Giảm giá</th>
                    <th>Tổng giá</th>
                    <th>Quản lý</th>
                </tr>
                `);
                $('#load-order').remove();

                for (let i = 0; i < list_order.length; i++) {
                    const code_order = list_order[i]['id'];
                    const code_product = list_order[i]['codeProduct'];
                    const name_customer = list_order[i]['nameCustomer'];
                    const product = list_order[i]['product'];
                    const day_order = list_order[i]['dayOrder'];
                    const day_ship = list_order[i]['dayShip'];
                    const status_order = list_order[i]['statusOrder'];
                    const quatity = list_order[i]['quatity'];
                    const discount = list_order[i]['discount'];
                    const total = list_order[i]['total'];
                    const path_image = `${URL}images/products/${list_order[i]['image']}`

                    if ((i + 1) % 2 === 0) {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${i + 1} </td>
                                <td> ${name_customer} </td>
                                <td> ${product} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td class="day-order"> ${day_order} </td>
                                <td class="day-order"> ${day_ship} </td>
                                <td> ${status_order} </td>
                                <td> ${quatity} </td>
                                <td> ${discount} </td>
                                <td> ${total} </td>
                                <td>
                                    <a href='${URL}admin/update-order.php?noOrder=${code_order}&filter=${1}' class="btn-primary">Cập nhật</a>
                                    <a href='${URL}admin/cancel-order.php?noOrder=${code_order}&filter=${1}'' class="btn-danger">Huỷ đơn</a>
                                </td>
                            </tr>
                            `
                        );
                    } else {
                        $('.container table').append(
                            `
                            <tr class="text-center">
                                <td> ${i + 1} </td>
                                <td> ${name_customer} </td>
                                <td> ${product} </td>
                                <td><a href='${path_image}'  ><img src='${path_image}' width="100px" height="100px" alt="No image" class="img-category"></a></td>
                                <td class="day-order"> ${day_order} </td>
                                <td class="day-order"> ${day_ship} </td>
                                <td> ${status_order} </td>
                                <td> ${quatity} </td>
                                <td> ${discount} </td>
                                <td> ${total} </td>
                                <td>
                                    <a href='${URL}admin/update-order.php?noOrder=${code_order}&filter=${1}' class="btn-primary">Cập nhật</a>
                                    <a href='${URL}admin/cancel-order.php?noOrder=${code_order}&filter=${1}'' class="btn-danger">Huỷ đơn</a>
                                </td>
                            </tr>
                            `
                        );
                    }
                }
            });
    });

});