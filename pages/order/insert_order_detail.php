<?php
require 'connect.php';
date_default_timezone_set("Asia/Bangkok");


?>
<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");
$od_id =$_POST['od_id'];
$in_order_id_detail = $_POST['in_order_id_detail'];
$in_order_plant_detail = $_POST['in_order_plant_detail'];

$in_order_amount_detail = $_POST["in_order_amount_detail"];
$in_order_amount_details = str_replace(',','', $in_order_amount_detail);

$in_order_amount_for_detail = $_POST["in_order_amount_for_detail"];

$in_order_amount_total_detail = $_POST["in_order_amount_total_detail"];
$in_order_amount_total_details = str_replace(',','', $in_order_amount_total_detail);
$in_order_end_detail = $_POST["in_order_end_detail"];


$planting_for = $in_order_amount_total_details - $in_order_amount_details;

$sql_add_order_detail = "INSERT INTO tb_order_detail (order_detail_id,order_detail_amount,order_detail_per,order_detail_total,order_detail_enddate,order_detail_planting_status,order_detail_status,ref_plant_id, ref_order_id, created_by, created_at, update_by, update_at) 
VALUES ('$in_order_id_detail','$in_order_amount_details','$planting_for','$in_order_amount_total_details','$in_order_end_detail','ยังไม่ได้ทำการปลูก','ปกติ','$in_order_plant_detail', '$od_id', '$name', '$d', '$name', '$d');";

if (mysqli_query($conn, $sql_add_order_detail)) {
    echo $sql_add_order_detail;
    
} else {
    echo mysqli_error($conn);
}
