<?php
require('connect.php');
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

$sql = "SELECT * FROM tb_user WHERE firstname ='$firstname' AND lastname='$lastname'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}
