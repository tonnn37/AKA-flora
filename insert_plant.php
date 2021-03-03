
<?php
include 'connect_new.php';

//--- รันรหัสพันธุ์ไม้---//
$object = new Crud();
mysqli_query($object->connect, 'set names utf8');
date_default_timezone_set("Asia/Bangkok");
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$sql_group = "SELECT Max(plant_id) as maxid FROM tb_plant";
$result = mysqli_query($object->connect, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "PLA"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
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

$plaid = $tmp1 . $sub_date . $a;


$insert_plant_typename = mysqli_real_escape_string($object->connect, $_POST["insert_plant_typename"]);
$insert_plant_name = mysqli_real_escape_string($object->connect, $_POST["insert_plant_name"]);
$insert_plant_time = mysqli_real_escape_string($object->connect, $_POST["insert_plant_time"]);
$insert_plant_detail = mysqli_real_escape_string($object->connect, $_POST["insert_plant_detail"]);


$date = date("Y-m-d");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


    //$_FILES คำสั่งอ่านค่าจากการอัพโหลด
    $old_filename = $_FILES['add_picture']['name'];
    //$new_filename = $_FILES['fileUpload']['name'];
    ///----
    list($txt, $ext) = explode(".", $old_filename);
    $new_file_name = $plaid . "." . $ext;
    //ตั้งชื่อใหม่
    copy($_FILES['add_picture']['tmp_name'], "image/plant/" . $new_file_name); //copy ภาพไปใส่ในโฟลเดอร์ upload

    $sql_typeplant = "INSERT INTO tb_plant(plant_id,plant_name,plant_time,plant_detail,plant_status,ref_type_plant,created_by,created_at,update_by,update_at,picture) 
    VALUES ('$plaid','$insert_plant_name','$insert_plant_time','$insert_plant_detail','ปกติ','$insert_plant_typename','$name','$date','$name','$date','$new_file_name')";
       
    if ($object->execute_query($sql_typeplant)) {
        echo $sql_typeplant;
    } else {
        echo mysqli_error($object->connect);
    }

?>