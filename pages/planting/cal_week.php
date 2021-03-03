<?php

require('connect.php');
$id = $_POST['id'];

$sql_week = "SELECT COUNT(ref_planting_detail_id) as count , tb_plant.plant_time
FROM tb_planting_week
INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
INNER JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
WHERE planting_week_status ='เสร็จสิ้น' AND ref_planting_detail_id='$id'";
$result_week= mysqli_query($conn, $sql_week);
$row_week = mysqli_fetch_assoc($result_week);

$plant_time = $row_week['plant_time'];
$old_week = $row_week['count'];

/* 
$sql_time ="SELECT tb_plant.plant_time as time FROM tb_planting_week
INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id=tb_planting_week.ref_planting_detail_id
INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
WHERE ref_planting_detail_id='$id' 
GROUP BY ref_planting_detail_id"; */

/* $result_time= mysqli_query($conn, $sql_time);
$row_time = mysqli_fetch_assoc($result_time);
$time = $row_time['time'];//5 */



if($old_week >= $plant_time){
    echo 1;
}else{
    echo 0;
}

