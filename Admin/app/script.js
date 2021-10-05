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

    //review image before upload
    $('#image-upload').change(() => {
        $('#text-review-img').remove();
        $('#img-show').remove();
        var File = new FileReader();
        File.readAsDataURL($('#image-upload').prop('files')[0]);
        File.onload = (e) => {
            $('#img-review').append("<img class='format-img-review img-category' width=300px height=300px src='" + e.target.result + "' >")
        }
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
});