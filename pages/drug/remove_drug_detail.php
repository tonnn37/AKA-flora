<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$detailid = $_POST['detailid'];
$detailstatus = $_POST['detailstatus'];


$d = date("Y-m-d");

if ($detailstatus =='ปกติ') {
    $sql_drugdetail = "UPDATE tb_drug_detail  SET drug_detail_status='ระงับ',update_by='$name',update_at='$d' WHERE drug_detail_id ='$detailid'";
}else{
    $sql_drugdetail = "UPDATE tb_drug_detail  SET drug_detail_status='ปกติ',update_by='$name',update_at='$d' WHERE drug_detail_id ='$detailid'";
}
if(mysqli_query($conn, $sql_drugdetail)){
       echo "บันทึกสำเร็จ";
}else{
    echo mysqli_error($conn);

}
    
?>