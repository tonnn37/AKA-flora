
<?php
include 'connect_new.php';


//--- รันรหัสยา---//
$object = new Crud();
mysqli_query($object->connect, 'set names utf8');
date_default_timezone_set("Asia/Bangkok");
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$sql_group = "SELECT Max(drug_id) as maxid FROM tb_drug";
$result = mysqli_query($object->connect, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "DRU"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp2 = substr($mem_old, 5, 6);
$Year = substr($mem_old, 3, 2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp2 = 0;
    //$sub_date = $sub_date + 1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;
$a = sprintf("%03d", $t);
$run_drug_id = $tmp1 . $sub_date . $a;






$drugunit = mysqli_real_escape_string($object->connect, $_POST["drugunit"]);
$drugname = mysqli_real_escape_string($object->connect, $_POST["drugname"]);
$unit = mysqli_real_escape_string($object->connect, $_POST["unit"]);
$drugamount = mysqli_real_escape_string($object->connect, $_POST["drugamount"]);
$drug_price = mysqli_real_escape_string($object->connect, $_POST["drug_price"]);
$drugdetail = mysqli_real_escape_string($object->connect, $_POST["drugdetail"]);


$date = date("Y-m-d");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


    //$_FILES คำสั่งอ่านค่าจากการอัพโหลด
    $old_filename = $_FILES['add_picture']['name'];
    //$new_filename = $_FILES['fileUpload']['name'];
    ///----
    list($txt, $ext) = explode(".", $old_filename);
    $new_file_name = $run_drug_id . "." . $ext;
    //ตั้งชื่อใหม่
    copy($_FILES['add_picture']['tmp_name'], "image/drug/" . $new_file_name); //copy ภาพไปใส่ในโฟลเดอร์ upload

    $sql_drug = "INSERT INTO tb_drug 
            (drug_id,drug_name,drug_amount,drug_price,drug_detail,drug_status,ref_group_drug,ref_drug_unit,created_by,created_at,update_by,update_at,picture)
            VALUES('$run_drug_id','$drugname','$drugamount','$drug_price','$drugdetail','ปกติ','$drugunit','$unit','$name','$date','$name','$date','$new_file_name')";
   
    if ($object->execute_query($sql_drug)) {
        echo $sql_drug;
    } else {
        echo mysqli_error($object->connect);
    }

?>