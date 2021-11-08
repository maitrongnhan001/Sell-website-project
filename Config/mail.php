<?php
if (mail("nhanb1805899@gstudent.ctu.edu.vn", "Forgot password", "your new password: 12345678", 'From: noreply@storee.com')) {
    echo "Successfully";
} else {
    echo "Error";
}
?>