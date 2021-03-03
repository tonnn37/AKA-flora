<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$recieve_detail_id = $_POST['recieve_detail_id'];
$recieve_detail_status = $_POST['recieve_detail_status'];

$d = date("Y-m-d");

if ($recieve_detail_status =='เสร็จสิ้น') {
    $sql_recieve_detail = "UPDATE tb_stock_recieve_detail  SET recieve_detail_status='ระงับ',update_by='$name',update_at='$d' WHERE recieve_detail_id ='$recieve_detail_id'";
}else{
    $sql_recieve_detail = "UPDATE tb_stock_recieve_detail  SET recieve_detail_status='เสร็จสิ้น',update_by='$name',update_at='$d' WHERE recieve_detail_id ='$recieve_detail_id'";
}
if(mysqli_query($conn, $sql_recieve_detail)){
       echo $sql_recieve_detail;
}else{
    echo mysqli_error($conn);

}
    
?>