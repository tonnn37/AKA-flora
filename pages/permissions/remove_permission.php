<?php
//Run id
require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$empid = $_POST['empid'];
$status = $_POST['status'];


$d = date("Y-m-d");

if ($status =='ใช้งาน') {
    $sql_permission = "UPDATE tb_user_detail  SET status='ระงับ',update_by='$name',update_at='$d' WHERE username ='$empid'";
}else{
    $sql_permission = "UPDATE tb_user_detail SET status='ใช้งาน',update_by='$name',update_at='$d' WHERE username ='$empid'";
}
if(mysqli_query($conn, $sql_permission)){
       
}else{
    echo mysqli_error($conn);

}
    
?>