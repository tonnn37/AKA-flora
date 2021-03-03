<?php

include('connect.php');

$sql_week = "SELECT max(plant_detail_id) as Maxid  FROM tb_plant_detail";
$result_week = mysqli_query($conn, $sql_week);
$row_id = mysqli_fetch_assoc($result_week);
$old_id = $row_id['Maxid'];
$id_plant_detail = $old_id + 1;

session_start();
date_default_timezone_set("Asia/Bangkok");
$d = date("Y-m-d");
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


$plant_id = $_POST['plant_id'];

$grade_id = $_POST['grade'];
$grade_price = $_POST['price'];


$plant_detail = '';
for($count = 0; $count < count($grade_id); $count++){

    $grade_ids = mysqli_real_escape_string($conn, $grade_id[$count]);
    $grade_prices = mysqli_real_escape_string($conn, $grade_price[$count]);

    $plant_detail = "INSERT INTO tb_plant_detail(plant_detail_id,plant_detail_price,plant_detail_status,ref_grade_id,ref_plant_id,created_by,created_at,update_by,update_at) 
    VALUES ('$id_plant_detail','$grade_prices','ปกติ','$grade_ids','$plant_id','$name','$d','$name','$d')";
    
    mysqli_query($conn, $plant_detail);
    $id_plant_detail++;
}

echo $plant_detail;




?>