<?php
//Run id
require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$stock_id = $_POST['stock_id'];
$stock_status = $_POST['stock_status'];


$d = date("Y-m-d");

if ($stock_status =='ปกติ') {
    $sql_stock = "UPDATE tb_stock_detail  SET stock_detail_status='ยกเลิก',update_by='$name',update_at='$d' WHERE stock_detail_id ='$stock_id'";
}else{
    $sql_stock = "UPDATE tb_stock_detail SET stock_detail_status='ปกติ',update_by='$name',update_at='$d' WHERE stock_detail_id ='$stock_id'";
}
if(mysqli_query($conn, $sql_stock)){
       
}else{
    echo mysqli_error($conn);

}
    
?>