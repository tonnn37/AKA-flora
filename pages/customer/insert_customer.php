<?php
//Run id
require('connect.php');

?>


<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");

$customer_id = $_POST['customer_id'];
$customer_firstname = $_POST['customer_firstname'];
$customer_lastname = $_POST['customer_lastname'];
$gender = $_POST['gender'];
$type_hand = $_POST['type_hand'];
$customer_email = $_POST['customer_email'];
$customer_detail = $_POST['customer_detail'];



$sql_customer = "INSERT INTO tb_customer
            (customer_id,customer_firstname,customer_lastname,customer_gender,customer_handover_type,customer_email,customer_detail,customer_status,created_by,created_at,update_by,update_at)
            VALUES('$customer_id','$customer_firstname','$customer_lastname','$gender','$type_hand','$customer_email','$customer_detail','ปกติ','$name','$d','$name','$d')";

if (mysqli_query($conn, $sql_customer)) {
    echo $sql_customer;
}else{
    mysqli_error($conn);
}
?>