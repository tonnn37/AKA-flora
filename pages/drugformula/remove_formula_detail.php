<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$detail_id = $_POST['detail_id'];
$status = $_POST['status'];


$d = date("Y-m-d");

if ($status =='ปกติ') {
    $sql_formula_detail= "UPDATE tb_drug_formula_detail  SET drug_formula_detail_status='ระงับ',update_by='$name',update_at='$d' WHERE drug_formula_detail_id ='$detail_id'";
}else{
    $sql_formula_detail = "UPDATE tb_drug_formula_detail  SET drug_formula_detail_status='ปกติ',update_by='$name',update_at='$d' WHERE drug_formula_detail_id ='$detail_id'";
}
if(mysqli_query($conn, $sql_formula_detail))
{
    echo $sql_formula_detail;

}else{

    echo mysqli_error($conn);

}
    
?>