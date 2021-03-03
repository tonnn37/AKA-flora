<?php
include('connect.php');
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

// ---- รันรหัส ประเภทยา ----//
$sql_group = "SELECT Max(drug_typeid) as maxid FROM tb_drug_type";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "DT"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
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
$dt_id = $tmp1 . $sub_date . $a;
?>

<?php
date_default_timezone_set("Asia/Bangkok");
$d = date("Y-m-d");

$drug_typename = $_POST['drug_typename'];




$sql_drugtype ="INSERT INTO tb_drug_type (drug_typeid,drug_typename,drug_typestatus,created_by,created_at,update_by,update_at)
            VALUES('$dt_id','$drug_typename','ปกติ','$name','$d','$name','$d')";

if(mysqli_query($conn, $sql_drugtype)){
    echo $sql_drugtype;
}else{
    echo mysqli_error($conn);

}

?>