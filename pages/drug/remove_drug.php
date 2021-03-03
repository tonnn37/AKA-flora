<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$drugid = $_POST['drug_id'];
$drugstatus = $_POST['drug_status'];


$d = date("Y-m-d");

if ($drugstatus =='ปกติ') {
    $sql_drug = "UPDATE tb_drug  SET drug_status='ระงับ',update_by='$name',update_at='$d' WHERE drug_id ='$drugid'";
}else{
    $sql_drug = "UPDATE tb_drug  SET drug_status='ปกติ',update_by='$name',update_at='$d' WHERE drug_id ='$drugid'";
}
if(mysqli_query($conn, $sql_drug)){
       echo "บันทึกสำเร็จ";
}else{
    echo mysqli_error($conn);

}
    
?>