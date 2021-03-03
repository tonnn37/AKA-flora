<?php
require('connect.php');
$id = $_POST['id'];
$password = $_POST['password'];


$sql = "SELECT * FROM tb_user_detail WHERE password ='$password' AND ref_emp_id='$id' ";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}
