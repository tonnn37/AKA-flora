<?php
require('connect_new.php');
date_default_timezone_set("Asia/Bangkok");

?>
<?php

$object = new Crud();
mysqli_query($object->connect, 'set names utf8');
$id = mysqli_real_escape_string($object->connect, $_POST["edit_drugid"]);
$edit_drugname = mysqli_real_escape_string($object->connect, $_POST["edit_drugname"]);
$edit_drugamount = mysqli_real_escape_string($object->connect, $_POST["edit_drugamount"]);
$edit_drugprice = mysqli_real_escape_string($object->connect, $_POST["edit_drugprice"]);
$edit_drugsmunit = mysqli_real_escape_string($object->connect, $_POST["edit_drugsmunit"]);
$edit_detail = mysqli_real_escape_string($object->connect, $_POST["edit_detail"]);
$ref_group_drug = mysqli_real_escape_string($object->connect, $_POST["edit_drugunit"]);

$d = date("Y-m-d");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];



//$Name_up = $_SESSION['firstName'] . " " . $_SESSION['lastName'];
$sql_update_drug = "UPDATE tb_drug SET
    
    drug_name = '$edit_drugname' ,
    drug_amount = '$edit_drugamount',
    drug_price = '$edit_drugprice',
    drug_detail = '$edit_detail',
    ref_group_drug ='$ref_group_drug',
    ref_drug_unit = '$edit_drugsmunit',
    update_by = '$name',
    update_at = '$d'
    WHERE drug_id = '$id'";



if (!empty($_FILES['picture']['name'])) {
    //$_FILES คำสั่งอ่านค่าจากการอัพโหลด
    $old_filename = $_FILES['picture']['name'];
    //$new_filename = $_FILES['fileUpload']['name'];
    ///----
    list($txt, $ext) = explode(".", $old_filename);
    $new_file_name = $id . "." . $ext;
    //ตั้งชื่อใหม่
    copy($_FILES['picture']['tmp_name'], "image/drug/" . $new_file_name);

    $sql_update_drug = "UPDATE tb_drug SET
        
    drug_name = '$edit_drugname' ,
    drug_amount = '$edit_drugamount',
    drug_price = '$edit_drugprice',
    drug_detail = '$edit_detail',
    ref_group_drug ='$ref_group_drug',
    ref_drug_unit = '$edit_drugsmunit',
    picture ='$new_file_name',
    update_by = '$name',
    update_at = '$d'
    WHERE drug_id = '$id'";


    //----
    $object->execute_query($sql_update_drug);

    //echo $sql_update_user;

} else if ($object->execute_query($sql_update_drug)) {
    echo $sql_update_drug;
} else {
    echo "Error";
}






?>