<?php
require('connect_new.php');
date_default_timezone_set("Asia/Bangkok");

?>
<?php

$object = new Crud();
mysqli_query($object->connect, 'set names utf8');
$empid = mysqli_real_escape_string($object->connect, $_POST["edit_empid"]);
$firstname = mysqli_real_escape_string($object->connect, $_POST["edit_firstname"]);
$lastname = mysqli_real_escape_string($object->connect, $_POST["edit_lastname"]);
$gender = mysqli_real_escape_string($object->connect, $_POST["edit_gender"]);
$cardid = mysqli_real_escape_string($object->connect, $_POST["edit_cardid"]);
$telephone = mysqli_real_escape_string($object->connect, $_POST["edit_telephone"]);
$cardid = str_replace('-', '', $cardid);

$address_id = mysqli_real_escape_string($object->connect, $_POST["edit_address_id"]);
$address_home = mysqli_real_escape_string($object->connect, $_POST["edit_address_home"]);
$address_swine = mysqli_real_escape_string($object->connect, $_POST["edit_address_swine"]);
$address_alley = mysqli_real_escape_string($object->connect, $_POST["edit_address_alley"]);
$address_road = mysqli_real_escape_string($object->connect, $_POST["edit_address_road"]);
$address_subdistrict = mysqli_real_escape_string($object->connect, $_POST["hd_subdistrict"]);
$address_district = mysqli_real_escape_string($object->connect, $_POST["hd_district"]);
$address_province = mysqli_real_escape_string($object->connect, $_POST["hd_province"]);
$address_zipcode = mysqli_real_escape_string($object->connect, $_POST["hd_zipcode"]);

$d = date("Y-m-d");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

//$Name_up = $_SESSION['firstName'] . " " . $_SESSION['lastName'];
$sql_update_user = "UPDATE tb_user SET
    firstname = '$firstname',
    lastname = '$lastname'  ,
    sex = '$gender',
    card_id = '$cardid',
    telephone ='$telephone',
    update_by = '$name',
    update_at = '$d'
    WHERE emp_id = '$empid'";

$sql_update_address = "UPDATE tb_address SET
    address_home = '$address_home', 
    address_swine = '$address_swine',
    address_alley = '$address_alley',
    address_road = '$address_road' ,
    address_subdistrict = '$address_subdistrict',
    address_district = '$address_district' ,
    address_province = '$address_province', 
    address_zipcode  = '$address_zipcode',
    update_by = '$name',
    update_at = '$d'
    WHERE address_id = '$address_id'";

if (!empty($_FILES['fileUpload']['name'])) {
    //$_FILES คำสั่งอ่านค่าจากการอัพโหลด
    $old_filename = $_FILES['fileUpload']['name'];
    //$new_filename = $_FILES['fileUpload']['name'];
    ///----
    list($txt, $ext) = explode(".", $old_filename);
    $new_file_name = $empid . "." . $ext;
    //ตั้งชื่อใหม่
    copy($_FILES['fileUpload']['tmp_name'], "image/emp/" . $new_file_name);

    $sql_update_user = "UPDATE tb_user SET
        firstname = '$firstname',
        lastname = '$lastname'  ,
        sex = '$gender',
        card_id = '$cardid',
        telephone ='$telephone',
        picture ='$new_file_name',
        update_by = '$name',
        update_at = '$d'
        WHERE emp_id = '$empid'";

    $sql_update_address = "UPDATE tb_address SET
        address_home = '$address_home', 
        address_swine = '$address_swine',
        address_alley = '$address_alley',
        address_road = '$address_road' ,
        address_subdistrict = '$address_subdistrict',
        address_district = '$address_district' ,
        address_province = '$address_province', 
        address_zipcode  = '$address_zipcode',
        update_by = '$name',
        update_at = '$d'
        WHERE address_id = '$address_id'";
    //----
    $object->execute_query($sql_update_user);
    $object->execute_query($sql_update_addr);
    //echo $sql_update_user;

} else if ($object->execute_query($sql_update_user) && $object->execute_query($sql_update_address)) {
    echo $sql_update_user. " " .$sql_update_address;
} else {
    echo "Error";
}



?>