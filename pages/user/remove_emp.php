
<?php
require('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");

?>
<?php

$empid = $_POST['empid'];
$empstatus = $_POST['empstatus'];

$d = date("Y-m-d");


if($empstatus =='ปกติ'){  
    $sql_user = "UPDATE tb_user SET emp_status ='ระงับ',update_by ='$name',update_at='$d' WHERE emp_id ='$empid'";
    $sql_user_detail = "UPDATE tb_user_detail SET status ='ระงับ' WHERE ref_emp_id ='$empid' ";
}else{      
    $sql_user = "UPDATE tb_user SET emp_status='ปกติ' ,update_by ='$name',update_at='$d' WHERE emp_id ='$empid'";   
    $sql_user_detail = "UPDATE tb_user_detail SET status ='ใช้งาน' WHERE ref_emp_id ='$empid' ";
}
if(mysqli_query($conn, $sql_user)&& mysqli_query($conn,$sql_user_detail)){
       
}else{
    echo mysqli_error($conn);

}
    
?>