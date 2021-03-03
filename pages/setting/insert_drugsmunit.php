<?php
//รหัสหน่วยยา

include('connect.php');


//รหัสหน่วยย่อย
date_default_timezone_set("Asia/Bangkok");
$sql_group = "SELECT Max(drug_sm_unit_id) as maxid FROM tb_drug_sm_unit";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "UNT"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp2 = substr($mem_old, 5, 6);
$Year = substr($mem_old, 3, 2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp2 = 0;
    // $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;

$a = sprintf("%02d", $t);

$su_id = $tmp1 . $sub_date . $a;
?>

<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");


$drug_smunit_name = $_POST['drug_smunit_name'];



$sql_drug_smunit = "INSERT INTO tb_drug_sm_unit  
            (drug_sm_unit_id,drug_sm_unit_name,drug_sm_unit_status,created_by,created_at,update_by,update_at)
            VALUES('$su_id','$drug_smunit_name','ปกติ','$name','$d','$name','$d')";


if (mysqli_query($conn, $sql_drug_smunit)) {

    echo  $sql_drug_smunit;
}
