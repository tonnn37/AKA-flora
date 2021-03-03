<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$order_detail_id = $_POST['order_detail_id'];
$order_detail_status = $_POST['order_detail_status'];


$d = date("Y-m-d");

if ($order_detail_status =='ปกติ' ) {
    $sql_order_detail = "UPDATE tb_order_detail  SET order_detail_status='ระงับ',update_by='$name',update_at='$d' WHERE order_detail_id ='$order_detail_id'";
   
}  else if($order_detail_status =='รอส่งมอบ'){
    $sql_order_detail = "UPDATE tb_order_detail  SET order_detail_status='ระงับ',update_by='$name',update_at='$d' WHERE order_detail_id ='$order_detail_id'";
}
else{
    $sql_order_detail = "UPDATE tb_order_detail  SET order_detail_status='ปกติ',update_by='$name',update_at='$d' WHERE order_detail_id ='$order_detail_id'";

}
if(mysqli_query($conn, $sql_order_detail)){
       echo $sql_order_detail;
}else{
    echo mysqli_error($conn);

}
    
?>