<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$plant_id = $_POST['plant_id'];
$plant_status = $_POST['plant_status'];


$d = date("Y-m-d");

if ($plant_status =='ปกติ') {
    $sql_plant = "UPDATE tb_plant  SET plant_status='ระงับ',update_by='$name',update_at='$d' WHERE plant_id ='$plant_id'";
    $sql_plant_detail = "UPDATE tb_plant_detail  SET plant_detail_status ='ระงับ',update_by='$name',update_at='$d' WHERE ref_plant_id ='$plant_id'";

}else{
    $sql_plant = "UPDATE tb_plant  SET plant_status='ปกติ',update_by='$name',update_at='$d' WHERE plant_id ='$plant_id'";
    $sql_plant_detail = "UPDATE tb_plant_detail  SET plant_detail_status ='ปกติ',update_by='$name',update_at='$d' WHERE ref_plant_id ='$plant_id'";
}
if(mysqli_query($conn, $sql_plant)&& mysqli_query($conn,$sql_plant_detail)){
       echo $sql_plant;
       echo $sql_plant_detail;
}else{
    echo mysqli_error($conn);

}
    
?>