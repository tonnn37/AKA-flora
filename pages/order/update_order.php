<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

$d = date("Y-m-d");
?>

<?php
$id = $_POST['id'];
$edit_order_name = $_POST['edit_order_name'];
$edit_order_cutomer = $_POST['edit_order_cutomer'];
$edit_order_price = $_POST['edit_order_price'];
$edit_order_detail = $_POST['edit_order_detail'];

$price = str_replace(',','', $edit_order_price);

$d = date("Y-m-d");


$sql_order = "UPDATE tb_order  SET order_name='$edit_order_name',order_customer ='$edit_order_cutomer' ,order_price ='$price',order_detail ='$edit_order_detail', update_by ='$name',update_at ='$d' WHERE order_id  ='$id'";

if(mysqli_query($conn, $sql_order)){
    echo $sql_order;
}else{
    echo mysqli_error($conn);

}
