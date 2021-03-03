<?php
include("connect.php");
session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
date_default_timezone_set("Asia/Bangkok");
$d = date("Y-m-d");

$emp_id= $_POST["in_reset_id"];
$idcard  = $_POST["in_reset_cid"];

$sql = "SELECT * FROM tb_user_detail
INNER JOIN tb_user ON tb_user_detail.ref_emp_id = tb_user.emp_id
WHERE tb_user_detail.username='$emp_id' AND tb_user_detail.status='ใช้งาน' AND  tb_user.emp_id = '$emp_id' AND tb_user.emp_status ='ปกติ' AND tb_user.card_id = '$idcard'";


$obj_query = mysqli_query($conn, $sql);
$obj_result = mysqli_fetch_assoc($obj_query);

if($obj_result){
    $sql_reset = "UPDATE tb_user_detail SET password = '$idcard',
                                                update_by = '$name',
                                                update_at = '$d'
                                            WHERE username = '$emp_id'";
    mysqli_query($conn,$sql_reset);
    echo 1;
}else{
    echo 0;
}