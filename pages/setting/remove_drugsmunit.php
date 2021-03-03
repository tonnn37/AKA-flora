<?php
//Run id
require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$drug_sm_unit_id = $_POST['drug_sm_unit_id'];
$drug_sm_unit_status = $_POST['drug_sm_unit_status'];


$d = date("Y-m-d");

if ($drug_sm_unit_status =='ปกติ') {
    $sql_drugsmunit = "UPDATE tb_drug_sm_unit  SET drug_sm_unit_status='ระงับ',update_by='$name',update_at='$d' WHERE drug_sm_unit_id ='$drug_sm_unit_id'";
}else{
    $sql_drugsmunit = "UPDATE tb_drug_sm_unit  SET drug_sm_unit_status='ปกติ',update_by='$name',update_at='$d' WHERE drug_sm_unit_id ='$drug_sm_unit_id'";
}
if(mysqli_query($conn, $sql_drugsmunit)){
       
}else{
    echo mysqli_error($conn);

}
    
?>