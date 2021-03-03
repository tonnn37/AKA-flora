<?php
include("connect.php");
$idcard = $_POST["idcard"];
$emp_id = $_POST["emp_id"];

$sql = "SELECT  * FROM tb_user_detail
INNER JOIN tb_user ON tb_user.emp_id = tb_user_detail.ref_emp_id
WHERE tb_user_detail.username ='$emp_id' AND tb_user_detail.status='ใช้งาน' 
AND tb_user.emp_id ='$emp_id' AND tb_user.emp_status ='ปกติ' 
AND tb_user.card_id ='$idcard'";


$obj_query = mysqli_query($conn, $sql);
$obj_result = mysqli_fetch_assoc($obj_query);

if($obj_result){
    echo 1;
}else{
    echo 0;
}