<?php

include('connect.php');

   //รหัสวัสดุปลูก
$sql_group = "SELECT Max(material_id) as maxid FROM tb_material";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "MAT"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
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

$matid = $tmp1 . $sub_date . $a;

?>

<?php
session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


$insert_type_material_name = $_POST['insert_type_material_name'];
$insert_unit_name = $_POST['insert_unit_name'];
$insert_material_name = $_POST['insert_material_name'];
$insert_material_price = $_POST['insert_material_price'];
$insert_material_amount = $_POST['insert_material_amount'];


date_default_timezone_set("Asia/Bangkok");
$d = date("Y-m-d");

$sql = "INSERT INTO tb_material(material_id,material_name,material_price,material_status,ref_type_material,ref_drug_unit,created_by,created_at,update_by,update_at,material_amount) 
        VALUES ('$matid','$insert_material_name','$insert_material_price','ปกติ','$insert_type_material_name','$insert_unit_name','$name','$d','$name','$d','$insert_material_amount')";


if(mysqli_query($conn, $sql)){
    echo $sql;
}else{
    echo mysqli_error($conn);

}


?>