<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
$edit_drug_typeid = $_POST['edit_drug_typeid'];
$edit_drug_typename = $_POST['edit_drug_typename'];
/* $edit_drug_typeunit = $_POST['edit_drug_typeunit']; */

$d = date("Y-m-d");


$sql_drugtype = "UPDATE tb_drug_type  SET drug_typename='$edit_drug_typename',update_by='$name',update_at='$d' WHERE drug_typeid ='$edit_drug_typeid'";

if(mysqli_query($conn, $sql_drugtype)){
    echo $sql_drugtype;
}else{
    echo mysqli_error($conn);

}


?>