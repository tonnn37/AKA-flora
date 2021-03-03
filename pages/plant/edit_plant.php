<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");


session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
$id = $_POST['id'];
$edit_plant_typename = $_POST['edit_plant_typename'];
$edit_plant_name = $_POST['edit_plant_name'];
$edit_plant_time = $_POST['edit_plant_time'];
$edit_plant_detail = $_POST['edit_plant_detail'];


$d = date("Y-m-d");



$sql_editplant = "UPDATE tb_plant  SET ref_type_plant='$edit_plant_typename' ,plant_name = '$edit_plant_name' .,plant_time = '$edit_plant_time' ,plant_detail = '$edit_plant_detail',update_by='$name',update_at='$d' WHERE plant_id ='$id'";

if (mysqli_query($conn, $sql_editplant)) {
    echo $sql_editplant;
} else {
    echo mysqli_error($conn);
}


?>