<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$planting_detail_id = $_POST['planting_detail_id'];
$planting_detail_status = $_POST['planting_detail_status'];


$d = date("Y-m-d");

if ($planting_detail_status =='ปกติ') {
    $sql_planting_detail = "UPDATE tb_planting_detail SET planting_detail_status='ระงับ',update_by='$name',update_at='$d' WHERE planting_detail_id ='$planting_detail_id'";
}else{
    $sql_planting_detail = "UPDATE tb_planting_detail SET planting_detail_status='ปกติ',update_by='$name',update_at='$d' WHERE planting_detail_id ='$planting_detail_id'";
}
if(mysqli_query($conn, $sql_planting_detail)){
       echo $sql_planting_detail;
}else{
    echo mysqli_error($conn);

}
    
?>