<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$order_id = $_POST['order_id'];
$order_status = $_POST['order_status'];

$d = date("Y-m-d");

if ($order_status =='ปกติ') {
    $sql_order = "UPDATE tb_order  SET order_status='ระงับ',update_by='$name',update_at='$d' WHERE order_id ='$order_id'";
    $sql_order_detail ="UPDATE tb_order_detail  SET order_detail_status='ระงับ',update_by='$name',update_at='$d' WHERE ref_order_id ='$order_id' AND (order_detail_status ='ปกติ' OR order_detail_status ='รอส่งมอบ')";
   
}else{
    $sql_order = "UPDATE tb_order  SET order_status='ปกติ',update_by='$name',update_at='$d' WHERE order_id ='$order_id'";
    $sql_order_detail ="UPDATE tb_order_detail  SET order_detail_status='ปกติ',update_by='$name',update_at='$d' WHERE ref_order_id ='$order_id' AND order_detail_status ='ระงับ'";
}
if(mysqli_query($conn, $sql_order) && mysqli_query($conn,$sql_order_detail)){
       echo $sql_order;
       echo $sql_order_detail;
}else{
    echo mysqli_error($conn);

}
    
?>