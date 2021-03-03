<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
$id = $_POST['id'];
$edit_type_material_name = $_POST['edit_type_material_name'];



$d = date("Y-m-d");


$sql_edit_typematerial = "UPDATE tb_type_material  SET type_material_name='$edit_type_material_name' ,update_by='$name',update_at='$d' WHERE type_material_id ='$id'";

if(mysqli_query($conn, $sql_edit_typematerial)){
    echo $sql_edit_typematerial;

}else{
    echo mysqli_error($conn);

}


?>