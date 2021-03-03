<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
$edit_drug_unitid = $_POST['edit_drug_unitid'];
$edit_drug_unitname = $_POST['edit_drug_unitname'];


$d = date("Y-m-d");


$sql_drugunit = "UPDATE tb_drug_unit  SET drug_unit_name='$edit_drug_unitname',update_by='$name',update_at='$d' WHERE drug_unit_id ='$edit_drug_unitid'";

if(mysqli_query($conn, $sql_drugunit)){
    echo $sql_drugunit;

}else{
    echo mysqli_error($conn);

}


?>