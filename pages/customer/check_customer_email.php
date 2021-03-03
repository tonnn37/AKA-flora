<?php
require('connect.php');

$id = $_POST['id'];
$email = $_POST['email'];


$sql = "SELECT * FROM tb_customer WHERE customer_email ='$email' AND customer_id !='$id'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}
