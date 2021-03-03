<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$planting_week_id = $_POST['planting_week_id'];
$planting_week_status = $_POST['planting_week_status'];


$d = date("Y-m-d");

if ($planting_week_status =='เสร็จสิ้น') {
    $sql_planting_week = "UPDATE tb_planting_week SET planting_week_status='ระงับ',update_by='$name',update_at='$d' WHERE planting_week_id ='$planting_week_id'";
}else{
    $sql_planting_week = "UPDATE tb_planting_week SET planting_week_status='เสร็จสิ้น',update_by='$name',update_at='$d' WHERE planting_week_id ='$planting_week_id'";
}
if(mysqli_query($conn, $sql_planting_week)){
       echo $sql_planting_week;
}else{
    echo mysqli_error($conn);

}
    
?>