<?php
require 'connect.php';
date_default_timezone_set("Asia/Bangkok");


?>
<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");

$order_ids = $_POST['order_ids'];
$ref_order_detail_id = $_POST['order_detail_id'];
$ref_planting_id = $_POST['id'];
$ref_planting_detail_id = $_POST['planting_detail_id'];



$sql_planting_detail = "SELECT * FROM tb_order_detail 
                        INNER JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
                        WHERE tb_order_detail.order_detail_id = '$ref_order_detail_id' AND order_detail_status ='ปกติ'";

$result = mysqli_query($conn, $sql_planting_detail);
$row = mysqli_fetch_assoc($result);

$plant_id = $row['ref_plant_id'];
$order_detail_amount = $row['order_detail_amount'];
$order_detail_per = $row['order_detail_per'];
$order_detail_total = $row['order_detail_total'];
$order_detail_enddate = $row['order_detail_enddate'];
$order_detail_status = $row['order_detail_status'];
$order_detail_id = $row['order_detail_id'];



$sql_add_order_detail = "INSERT INTO tb_planting_detail (planting_detail_id,ref_plant_id,planting_detail_amount,planting_detail_per,planting_detail_total,planting_detail_enddate,planting_detail_status,ref_planting_id, ref_order_detail_id, created_by, created_at, update_by, update_at) 
VALUES ('$ref_planting_detail_id','$plant_id','$order_detail_amount','$order_detail_per','$order_detail_total','$order_detail_enddate','ปกติ','$ref_planting_id', '$ref_order_detail_id', '$name', '$d', '$name', '$d');";

mysqli_query($conn, $sql_add_order_detail);


$sql_order = "UPDATE tb_order_detail SET order_detail_planting_status ='กำลังทำการปลูก' , update_by = '$name' , update_at ='$d' WHERE order_detail_id='$ref_order_detail_id'";
mysqli_query($conn, $sql_order);



echo $sql_planting_detail;
echo $sql_add_order_detail;
echo $sql_order;