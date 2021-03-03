<?php

include('connect.php');

$sql_group = "SELECT Max(type_material_id) as maxid FROM tb_type_material";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "TYM"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp2 = substr($mem_old, 5, 7);
$Year = substr($mem_old, 3, 2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp2 = 0;
    // $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;

$a = sprintf("%03d", $t);

$tymid = $tmp1 . $sub_date . $a;

?>


<?php
session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

$insert_type_material_name = $_POST['insert_type_material_name'];


date_default_timezone_set("Asia/Bangkok");
$d = date("Y-m-d");

$sql = "INSERT INTO tb_type_material(type_material_id,type_material_name,type_material_status,created_by,created_at,update_by,update_at) VALUES ('$tymid','$insert_type_material_name','ปกติ','$name','$d','$name','$d')";


if(mysqli_query($conn, $sql)){
    echo $sql;
}else{
    echo mysqli_error($conn);

}


?>