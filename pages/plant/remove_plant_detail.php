<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$plant_detail_ids = $_POST['plant_detail_ids'];
$plant_detail_status = $_POST['plant_detail_status'];


$d = date("Y-m-d");

if ($plant_detail_status =='ปกติ') {
    $sql_plant_detail = "UPDATE tb_plant_detail  SET plant_detail_status ='ระงับ',update_by='$name',update_at='$d' WHERE plant_detail_id ='$plant_detail_ids'";
}else{
    $sql_plant_detail = "UPDATE tb_plant_detail  SET plant_detail_status ='ปกติ',update_by='$name',update_at='$d' WHERE plant_detail_id ='$plant_detail_ids'";
}
if(mysqli_query($conn, $sql_plant_detail)){
       echo $sql_plant_detail;
}else{
    echo mysqli_error($conn);

}
    
?>