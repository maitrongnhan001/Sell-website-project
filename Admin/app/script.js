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
        var File = new FileReader();
        File.readAsDataURL($('#image-upload').prop('files')[0]);
        File.onload = (e) => {
            $('#img-review').append("<img class='img-category' width=400px height=400px src='" + e.target.result + "' >")
        }
    });
});