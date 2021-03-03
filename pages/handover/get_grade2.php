<?php
require 'connect.php';

$id = $_POST['id'];
$order_detail_id = $_POST['order_detail_id'];

$sql_plant = "SELECT tb_plant.plant_name as plant_name,
tb_plant.plant_id as plant_id
FROM tb_order_detail
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
WHERE tb_plant.plant_status = 'ปกติ' AND tb_order_detail.order_detail_id ='$order_detail_id'";

$re_plant = mysqli_query($conn, $sql_plant);
$row_plant = mysqli_fetch_assoc($re_plant);
$plant_id = $row_plant['plant_id'];

$sql1= "SELECT tb_grade.grade_id as grade_id ,
tb_grade.grade_name as grade_name
,tb_stock_recieve_detail.recieve_detail_amount as recieve_detail_amount
FROM tb_stock_recieve_detail
LEFT JOIN tb_stock_recieve ON tb_stock_recieve.stock_recieve_id = tb_stock_recieve_detail.ref_stock_recieve_id
LEFT JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_stock_recieve.ref_planting_detail_id
LEFT JOIN tb_order_detail ON tb_order_detail.order_detail_id = tb_planting_detail.ref_order_detail_id
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_recieve_detail.ref_grade_id
WHERE tb_order_detail.order_detail_id ='$order_detail_id' AND tb_stock_recieve_detail.ref_plant_id ='$plant_id' AND tb_stock_recieve_detail.ref_grade_id ='$id' AND tb_stock_recieve_detail.recieve_detail_status ='ปกติ'
GROUP BY tb_grade.grade_id";

$re = mysqli_query($conn, $sql1);
if (mysqli_num_rows($re) > 0) {
    $output = "";
    $row = mysqli_fetch_assoc($re);
    
    $grade_id = $row['grade_id'];
    $amount = $row['recieve_detail_amount'];

    $output .= '<input type="textbox" class="form-control cull_amount" id="cull_amount" name="cull_amount" value ="' . $amount . '" readonly>';
   

    echo $output;

} else {
}
