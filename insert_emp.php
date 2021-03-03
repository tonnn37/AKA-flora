
<?php
//Run id
include 'connect_new.php';


mysqli_query($object->connect, 'set names utf8');
date_default_timezone_set("Asia/Bangkok");
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$sqlm = "SELECT max(emp_id) as Maxid  FROM tb_user";
$result = $object->execute_query($sqlm);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['Maxid'];
//M003
$tmp1 = "EMP"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp2 = substr($mem_old, 5, 6);
$Year = substr($mem_old, 3 ,2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp2 = 0;
    //$sub_date = $sub_date + 1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;
$a = sprintf("%03d", $t);
$empid = $tmp1 . $sub_date . $a;

//run id address
$sql_addr = "SELECT max(address_id) as Maxid  FROM tb_address";
$re_addr = $object->execute_query($sql_addr);
$row_addr = mysqli_fetch_assoc($re_addr);
$addr_old = $row_addr['Maxid'];
//M003
$tmp4 = substr($addr_old, 0, 3); //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp5 = substr($addr_old, 5, 6);
$Year = substr($addr_old, 3, 2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp5 = 0;
    //$sub_date = $sub_date + 1;
} else {
    $tmp5;
}
$c = $tmp5 + 1;
$b = sprintf("%03d", $c);
$address_id = $tmp4 . $sub_date . $b;


$object = new Crud();
$firstname = mysqli_real_escape_string($object->connect, $_POST["firstname"]);
$lastname = mysqli_real_escape_string($object->connect, $_POST["lastname"]);
$gender = mysqli_real_escape_string($object->connect, $_POST["gender"]);
$cardid = mysqli_real_escape_string($object->connect, $_POST["cardid"]);
$telephone = mysqli_real_escape_string($object->connect, $_POST["telephone"]);
$status = mysqli_real_escape_string($object->connect, $_POST["status"]);
$cardid = str_replace('-', '', $cardid);

$address_home = mysqli_real_escape_string($object->connect, $_POST["address_home"]);
$address_swine = mysqli_real_escape_string($object->connect, $_POST["address_swine"]);
$address_alley = mysqli_real_escape_string($object->connect, $_POST["address_alley"]);
$address_road = mysqli_real_escape_string($object->connect, $_POST["address_road"]);
$address_subdistrict = mysqli_real_escape_string($object->connect, $_POST["subdistrict"]);
$address_district = mysqli_real_escape_string($object->connect, $_POST["district"]);
$address_province = mysqli_real_escape_string($object->connect, $_POST["province"]);
$address_zipcode = mysqli_real_escape_string($object->connect, $_POST["zipcode"]);


$date = date("Y-m-d");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


    //$_FILES คำสั่งอ่านค่าจากการอัพโหลด
    $old_filename = $_FILES['picture']['name'];
    //$new_filename = $_FILES['fileUpload']['name'];
    ///----
    list($txt, $ext) = explode(".", $old_filename);
    $new_file_name = $empid . "." . $ext;
    //ตั้งชื่อใหม่
    copy($_FILES['picture']['tmp_name'], "image/emp/" . $new_file_name); //copy ภาพไปใส่ในโฟลเดอร์ upload
    
    $sql_user = "INSERT INTO tb_user 
            (emp_id,firstname,lastname,sex,card_id,telephone,address_id,emp_status,status_login,created_by,created_at,update_by,update_at,picture)
            VALUES('$empid','$firstname','$lastname','$gender','$cardid','$telephone','$address_id'
            ,'ปกติ','ไม่อนุญาต','$name','$date','$name','$date','$new_file_name')";
    $sql_address = "INSERT INTO tb_address
                (address_id,address_home,address_swine,address_alley,address_road,address_subdistrict,address_district,address_province,address_zipcode,address_status,created_by,created_at,update_by,update_at)
                VALUES('$address_id','$address_home','$address_swine','$address_alley','$address_road','$address_subdistrict',' $address_district',' $address_province','$address_zipcode','ใช้งาน','$name','$date','$name','$date')";

    if ($object->execute_query($sql_user) && $object->execute_query($sql_address)) {
        echo $sql_user;
    } else {
        echo "Error";
    }

?>