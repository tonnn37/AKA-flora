<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$drug_formula_id = $_POST['drug_formula_id'];
$drug_formula_status = $_POST['drug_formula_status'];


$d = date("Y-m-d");

if ($drug_formula_status =='ปกติ') {
    $sql_formula = "UPDATE tb_drug_formula  SET drug_formula_status='ระงับ',update_by='$name',update_at='$d' WHERE drug_formula_id ='$drug_formula_id'";
    $sql_formula_detail ="UPDATE tb_drug_formula_detail SET drug_formula_detail_status ='ระงับ',update_by='$name',update_at='$d' WHERE ref_drug_formula ='$drug_formula_id'";
}else{
    $sql_formula = "UPDATE tb_drug_formula  SET drug_formula_status='ปกติ',update_by='$name',update_at='$d' WHERE drug_formula_id ='$drug_formula_id'";
    $sql_formula_detail ="UPDATE tb_drug_formula_detail SET drug_formula_detail_status ='ปกติ',update_by='$name',update_at='$d' WHERE ref_drug_formula ='$drug_formula_id'";
}
if(mysqli_query($conn, $sql_formula) && mysqli_query($conn, $sql_formula_detail))
{
    echo $sql_formula;

}else{

    echo mysqli_error($conn);

}
    
?>