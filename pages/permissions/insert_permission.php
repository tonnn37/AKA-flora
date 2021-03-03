<?php
//Run id
require('connect.php');
date_default_timezone_set("Asia/Bangkok");
mysqli_query($object->connect, 'set names utf8');
$sqlm = "SELECT max(user_id) as Maxid  FROM tb_user_detail";
$result = mysqli_query($conn, $sqlm);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['Maxid'];
$user_id = $mem_old + 1;
?>

<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");

$userlevel = $_POST['userlevel'];
$empid = $_POST['emp_id'];

$sql = "SELECT card_id FROM tb_user WHERE emp_id='$empid'";

$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      $cardid = $row['card_id'];
    }
}

$sql_permission = "INSERT INTO tb_user_detail
            (user_id,username,password,userlevel,status,ref_emp_id,created_by,created_at,update_by,update_at)
            VALUES('$user_id','$empid','$cardid','$userlevel','ใช้งาน','$empid','$name','$d','$name','$d')";
$sql = "UPDATE tb_user SET status_login='อนุญาต',update_by ='$name',update_at='$d' WHERE emp_id='$empid'";
if (mysqli_query($conn, $sql_permission)&& mysqli_query($conn,$sql)) {
    echo "บันทึกเรียบร้อย";
}
?>