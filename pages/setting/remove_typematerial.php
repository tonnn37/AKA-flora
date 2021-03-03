<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$typematerial_id = $_POST['typematerial_id'];
$typematerial_status = $_POST['typematerial_status'];


$d = date("Y-m-d");

if ($typematerial_status =='ปกติ') {
    $sql_typematerial = "UPDATE tb_type_material  SET type_material_status='ระงับ',update_by='$name',update_at='$d' WHERE type_material_id ='$typematerial_id'";
}else{
    $sql_typematerial = "UPDATE tb_type_material  SET type_material_status='ปกติ',update_by='$name',update_at='$d' WHERE type_material_id ='$typematerial_id'";
}
if(mysqli_query($conn, $sql_typematerial)){
       echo "บันทึกสำเร็จ";
}else{
    echo mysqli_error($conn);

}
    
?>