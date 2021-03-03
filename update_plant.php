<?php
require('connect_new.php');
date_default_timezone_set("Asia/Bangkok");
?>
<?php

$object = new Crud();
mysqli_query($object->connect, 'set names utf8');
$id = mysqli_real_escape_string($object->connect, $_POST["edit_plant_id"]);
$edit_plant_typename = mysqli_real_escape_string($object->connect, $_POST["edit_plant_typename"]);
$edit_plant_name = mysqli_real_escape_string($object->connect,   $_POST["edit_plant_name"]  );
$edit_plant_time = mysqli_real_escape_string($object->connect, $_POST["edit_plant_time"]);
$edit_plant_detail = mysqli_real_escape_string($object->connect,   $_POST["edit_plant_detail"]);

$d = date("Y-m-d");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];



//$Name_up = $_SESSION['firstName'] . " " . $_SESSION['lastName'];
$sql_editplant = "UPDATE tb_plant SET
    
    ref_type_plant = '$edit_plant_typename' ,
    plant_name = '$edit_plant_name',
    plant_time = '$edit_plant_time',
    plant_detail ='$edit_plant_detail',
    update_by = '$name',
    update_at = '$d'
    WHERE plant_id = '$id'";



if (!empty($_FILES['picture']['name'])) {
    //$_FILES คำสั่งอ่านค่าจากการอัพโหลด
    $old_filename = $_FILES['picture']['name'];
    //$new_filename = $_FILES['fileUpload']['name'];
    ///----
    list($txt, $ext) = explode(".", $old_filename);
    $new_file_name = $id . "." . $ext;
    //ตั้งชื่อใหม่
    copy($_FILES['picture']['tmp_name'], "image/plant/" . $new_file_name);

    $sql_editplant = "UPDATE tb_plant SET
        
    ref_type_plant = '$edit_plant_typename' ,
    plant_name = '$edit_plant_name',
    plant_time = '$edit_plant_time',
    plant_detail ='$edit_plant_detail',
    picture ='$new_file_name',
    update_by = '$name',
    update_at = '$d'
    WHERE plant_id = '$id'";


    //----
    $object->execute_query($sql_editplant);

    //echo $sql_update_user;

} else if ($object->execute_query($sql_editplant)) {
    echo $sql_editplant;
} else {
    echo "Error";
}






?>