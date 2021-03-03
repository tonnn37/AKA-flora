<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");
session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
?>

<?php
$emp = $_POST['emp'];
$old_password = $_POST['old_password'];
$new_password1 = $_POST['new_password1'];
$new_password2 = $_POST['new_password2'];

$d = date("Y-m-d");


$sql_user_detail = "UPDATE tb_user_detail  SET password='$new_password2',update_by='$name',update_at='$d' WHERE ref_emp_id ='$emp' AND password ='$old_password' ";

if(mysqli_query($conn, $sql_user_detail)){
    echo $sql_user_detail;

}else{
    echo mysqli_error($conn);

}


?>