<?php
 //รหัสหน่วยยา

 include('connect.php');
 date_default_timezone_set("Asia/Bangkok");
 $sql_group = "SELECT Max(drug_unit_id) as maxid FROM tb_drug_unit";
 $datenow = strtotime(date("Y-m-d"));
 $d = date('Y', $datenow) + 543;
 $result = mysqli_query($conn, $sql_group);
 $row_mem = mysqli_fetch_assoc($result);
 $mem_old = $row_mem['maxid'];
 $tmp1 = "UD"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
 $tmp2 = substr($mem_old, 5, 6);
 $Year = substr($mem_old, 2, 2);
 $sub_date = substr($d, 2, 3);
 if ($Year != $sub_date) {
     $tmp2 = 0;
     // $sub_date=$sub_date+1;
 } else {
     $tmp2;
 }
 $t = $tmp2 + 1;

 $a = sprintf("%02d", $t);

 $ud_id = $tmp1 . $sub_date . $a;

?>

<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");


$add_drug_unit_name = $_POST['add_drug_unit_name'];


$sql_drug_unit = "INSERT INTO tb_drug_unit  
            (drug_unit_id,drug_unit_name,drug_unit_status,created_by,created_at,update_by,update_at)
            VALUES('$ud_id','$add_drug_unit_name','ปกติ','$name','$d','$name','$d')";


if (mysqli_query($conn, $sql_drug_unit)) {

    echo  $sql_drug_unit;
}