<?php
require('connect.php');
$order_name = $_POST['order_name'];


$sql = "SELECT * FROM tb_order WHERE order_name ='$order_name' AND order_status !='ระงับ'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo 1;
}else{
	echo $sql;
}
