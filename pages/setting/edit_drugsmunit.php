<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
$edit_drug_smunit_id = $_POST['edit_drug_smunit_id'];
$edit_drug_smunit_name = $_POST['edit_drug_smunit_name'];


$d = date("Y-m-d");


$sql_drugsmunit = "UPDATE tb_drug_sm_unit  SET drug_sm_unit_name='$edit_drug_smunit_name',update_by='$name',update_at='$d' WHERE drug_sm_unit_id ='$edit_drug_smunit_id'";

if(mysqli_query($conn, $sql_drugsmunit)){
    echo $sql_drugsmunit;

}else{
    echo mysqli_error($conn);

}


?>