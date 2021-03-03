<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$material_id = $_POST['material_id'];
$material_status = $_POST['material_status'];


$d = date("Y-m-d");

if ($material_status =='ปกติ') {
    $sql_material = "UPDATE tb_material  SET material_status='ระงับ',update_by='$name',update_at='$d' WHERE material_id ='$material_id'";
}else{
    $sql_material = "UPDATE tb_material  SET material_status='ปกติ',update_by='$name',update_at='$d' WHERE material_id ='$material_id'";
}
if(mysqli_query($conn, $sql_material)){
       echo "บันทึกสำเร็จ";
}else{
    echo mysqli_error($conn);

}
    
?>