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
});