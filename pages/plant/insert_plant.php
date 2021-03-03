<?php

include('connect.php');

//รหัสหน่วยย่อย
$sql_group = "SELECT Max(plant_id) as maxid FROM tb_plant";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "PLA"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp2 = substr($mem_old, 5, 7);
$Year = substr($mem_old, 3, 2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp2 = 0;
    // $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;

$a = sprintf("%03d", $t);

$plantid = $tmp1 . $sub_date . $a;

$sql_week = "SELECT max(plant_detail_id) as Maxid  FROM tb_plant_detail";
$result_week = mysqli_query($conn, $sql_week);
$row_id = mysqli_fetch_assoc($result_week);
$old_id = $row_id['Maxid'];
$id_plant_detail = $old_id + 1;
?>


<?php
session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$insert_plant_typename = $_POST['insert_plant_typename'];
$insert_plant_name = $_POST['insert_plant_name'];
$insert_plant_time = $_POST['insert_plant_time'];
$insert_plant_detail = $_POST['insert_plant_detail'];

$grade_id = $_POST['insert_plant_grade'];
$grade_price = $_POST['insert_plant_grade_price'];


date_default_timezone_set("Asia/Bangkok");
$d = date("Y-m-d");
for ($count = 0; $count < count($grade_id); $count++) {

    $grade_ids = mysqli_real_escape_string($conn, $grade_id[$count]);
    $grade_prices = mysqli_real_escape_string($conn, $grade_price[$count]);

    $plant_detail = "INSERT INTO tb_plant_detail(plant_detail_id,plant_detail_price,plant_detail_status,ref_grade_id,ref_plant_id,created_by,created_at,update_by,update_at) 
    VALUES ('$id_plant_detail','$grade_prices','ปกติ','$grade_ids','$plantid','$name','$d','$name','$d')";
    mysqli_query($conn, $plant_detail);
    $id_plant_detail++
}

$sql = "INSERT INTO tb_plant(plant_id,plant_typename,plant_name,insert_plant_time,plant_detail,plant_status,created_by,created_at,update_by,update_at) 
VALUES ('$plantid','$insert_plant_typename','$insert_plant_name','$insert_plant_time','$insert_plant_detail','ปกติ','$name','$d','$name','$d')";


if (mysqli_query($conn, $sql)) {
    echo $sql;
} else {
    echo mysqli_error($conn);
}


?>