<?php
require 'connect.php';

$id = $_POST['elem'];
$order_detail_id = $_POST['order_detail_id'];
$grade = $_POST['grade'];

$sql_plant = "SELECT tb_plant.plant_name as plant_name,
tb_plant.plant_id as plant_id
FROM tb_order_detail
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
WHERE tb_plant.plant_status = 'ปกติ' AND tb_order_detail.order_detail_id ='$order_detail_id'";

$re_plant = mysqli_query($conn, $sql_plant);
$row_plant = mysqli_fetch_assoc($re_plant);
$plant_id = $row_plant['plant_id'];

$sql = "SELECT stock_detail_amount as stock_detail_amount FROM tb_stock_detail WHERE ref_plant_id ='$plant_id' AND ref_grade_id = '$grade' AND stock_detail_status ='ปกติ'";
$re = mysqli_query($conn, $sql);

if (mysqli_num_rows($re) > 0) {
    $row = mysqli_fetch_assoc($re);


    if ($id > $row['stock_detail_amount']) {
        echo 1;
    } else {
        echo 0;
    }
}else{
    echo 1;
}
