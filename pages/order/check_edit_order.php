<?php
require('connect.php');
$id = $_POST['id'];
$edit_order_name = $_POST['edit_order_name'];

$sql = "SELECT * FROM tb_order WHERE order_name ='$edit_order_name' AND order_status !='ระงับ' AND order_id != '$id' ";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo 1;
}else{
	echo $sql;
}
