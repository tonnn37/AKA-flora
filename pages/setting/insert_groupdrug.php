<?php
//Run id
require('connect.php');
date_default_timezone_set("Asia/Bangkok");
$sql_group = "SELECT Max(group_drug_id) as maxid FROM tb_group_drug";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "GD"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp2 = substr($mem_old, 5, 6);
$Year = substr($mem_old, 2, 2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp2 = 0;
    //  $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;

$a = sprintf("%02d", $t);


$gd_id = $tmp1 . $sub_date . $a;

?>

<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");

$drug_typeid = $_POST['add_drug_typeid'];
$group_drugname = $_POST['group_drugname'];
/* $add_drug_suunit = $_POST['add_drug_suunit']; */


$sql_group_drug = "INSERT INTO tb_group_drug
            (group_drug_id,group_drug_name,group_drug_status,ref_drug_type,created_by,created_at,update_by,update_at)
            VALUES('$gd_id','$group_drugname','ปกติ','$drug_typeid','$name','$d','$name','$d')";


if (mysqli_query($conn, $sql_group_drug)) {

    echo $sql_group_drug;
}