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

function checkDayShip () {
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
    return result;
}

function checkDiscount () {
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
            const array_img = Object.keys( e.target.files);
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
                }else {
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
});