<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$typeplant_id = $_POST['typeplant_id'];
$typeplant_status = $_POST['typeplant_status'];


$d = date("Y-m-d");

if ($typeplant_status =='ปกติ') {
    $sql_typeplant = "UPDATE tb_typeplant  SET type_plant_status='ระงับ',update_by='$name',update_at='$d' WHERE type_plant_id ='$typeplant_id'";
}else{
    $sql_typeplant = "UPDATE tb_typeplant  SET type_plant_status='ปกติ',update_by='$name',update_at='$d' WHERE type_plant_id ='$typeplant_id'";
}
if(mysqli_query($conn, $sql_typeplant)){
       echo "บันทึกสำเร็จ";
}else{
    echo mysqli_error($conn);

}
    
?>