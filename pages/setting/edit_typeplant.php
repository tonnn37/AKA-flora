<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
$id = $_POST['id'];
$edit_typeplant_name = $_POST['edit_typeplant_name'];



$d = date("Y-m-d");


$sql_edittypeplant = "UPDATE tb_typeplant  SET type_plant_name='$edit_typeplant_name' ,update_by='$name',update_at='$d' WHERE type_plant_id ='$id'";

if(mysqli_query($conn, $sql_edittypeplant)){
    echo $sql_edittypeplant;

}else{
    echo mysqli_error($conn);

}


?>