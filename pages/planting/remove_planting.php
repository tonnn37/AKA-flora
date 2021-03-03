    <?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$planting_id = $_POST['planting_id'];
$planting_status = $_POST['planting_status'];
$order_detail_id = $_POST['order_detail_id'];

$d = date("Y-m-d");

if ($planting_status =='ปกติ') {
    $sql_planting = "UPDATE tb_planting  SET planting_status='ระงับ',update_by='$name',update_at='$d' WHERE planting_id ='$planting_id'";
    $sql_planting_detail = "UPDATE tb_planting_detail SET planting_detail_status='ระงับ',update_by='$name',update_at='$d' WHERE ref_planting_id ='$planting_id' AND planting_detail_status ='ปกติ'";
    $sql_order_detail = "UPDATE tb_order_detail SET order_detail_planting_status ='ยังไม่ได้ทำการปลูก',
                                                                        update_by='$name',
                                                                        update_at='$d' 
                                                                        WHERE order_detail_id ='$order_detail_id'";
     mysqli_query($conn,$sql_order_detail);
     echo $sql_order_detail;                                                                   
}else{
    $sql_planting = "UPDATE tb_planting  SET planting_status='ปกติ',update_by='$name',update_at='$d' WHERE planting_id ='$planting_id'";
    $sql_planting_detail = "UPDATE tb_planting_detail SET planting_detail_status='ปกติ',update_by='$name',update_at='$d' WHERE ref_planting_id ='$planting_id' AND planting_detail_status ='ระงับ'";
    $sql_order_detail = "UPDATE tb_order_detail SET order_detail_planting_status ='กำลังทำการปลูก',
                                                                        update_by='$name',
                                                                        update_at='$d' 
                                                                        WHERE order_detail_id ='$order_detail_id'";
    mysqli_query($conn,$sql_order_detail);
    echo $sql_order_detail;
}
if(mysqli_query($conn, $sql_planting) && mysqli_query($conn, $sql_planting_detail)){
       echo $sql_planting;
       echo $sql_planting_detail;
}else{
    echo mysqli_error($conn);

}
    
?>