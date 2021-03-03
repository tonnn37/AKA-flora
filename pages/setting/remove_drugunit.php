<?php
//Run id
require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$drug_unit_id = $_POST['drug_unit_id'];
$drug_unit_status = $_POST['drug_unit_status'];


$d = date("Y-m-d");

if ($drug_unit_status =='ปกติ') {
    $sql_drugunit = "UPDATE tb_drug_unit  SET drug_unit_status='ระงับ',update_by='$name',update_at='$d' WHERE drug_unit_id ='$drug_unit_id'";
}else{
    $sql_drugunit = "UPDATE tb_drug_unit  SET drug_unit_status='ปกติ',update_by='$name',update_at='$d' WHERE drug_unit_id ='$drug_unit_id'";
}
if(mysqli_query($conn, $sql_drugunit)){
       
}else{
    echo mysqli_error($conn);

}
    
?>