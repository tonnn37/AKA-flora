<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
$edit_group_drug_id = $_POST['edit_group_drug_id'];
$edit_drug_typeid = $_POST['edit_drug_typeid'];
$edit_group_drugname = $_POST['edit_group_drugname'];
/* $edit_drug_sunit_id = $_POST['edit_drug_sunit_id']; */

$d = date("Y-m-d");


$sql_groupdrug = "UPDATE tb_group_drug  SET group_drug_name='$edit_group_drugname',ref_drug_type ='$edit_drug_typeid',update_by='$name',update_at='$d' WHERE group_drug_id ='$edit_group_drug_id'";

if(mysqli_query($conn, $sql_groupdrug)){
    echo $sql_groupdrug;
}else{
    echo mysqli_error($conn);

}


?>