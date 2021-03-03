<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$week_detail_id = $_POST['week_detail_id'];
$week_detail_status = $_POST['week_detail_status'];


$d = date("Y-m-d");

if ($week_detail_status =='ปกติ') {
    $sql_week_detail = "UPDATE tb_planting_week_detail SET week_detail_status='ระงับ',update_by='$name',update_at='$d' WHERE week_detail_id ='$week_detail_id'";
}else{
    $sql_week_detail = "UPDATE tb_planting_week_detail SET week_detail_status='ปกติ',update_by='$name',update_at='$d' WHERE week_detail_id ='$week_detail_id'";
}
if(mysqli_query($conn, $sql_week_detail)){
       echo $sql_week_detail;
}else{
    echo mysqli_error($conn);

}
    
?>