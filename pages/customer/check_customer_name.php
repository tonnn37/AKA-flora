<?php
require('connect.php');
$id = $_POST['id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

$sql = "SELECT * FROM tb_customer WHERE customer_firstname ='$firstname' AND customer_lastname ='$lastname' AND customer_id !='$id'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}
