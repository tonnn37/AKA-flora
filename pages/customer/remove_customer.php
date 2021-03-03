<?php
//Run id
require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$customer_id = $_POST['customer_id'];
$customer_status = $_POST['customer_status'];


$d = date("Y-m-d");

if ($customer_status =='ปกติ') {
    $sql_customer = "UPDATE tb_customer  SET customer_status='ระงับ',update_by='$name',update_at='$d' WHERE customer_id ='$customer_id'";
}else{
    $sql_customer = "UPDATE tb_customer SET customer_status='ปกติ',update_by='$name',update_at='$d' WHERE customer_id ='$customer_id'";
}
if(mysqli_query($conn, $sql_customer)){
       
}else{
    echo mysqli_error($conn);

}
    
?>