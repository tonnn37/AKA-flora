<?php
require('connect.php');

$id = $_POST['id'];
$name = $_POST['name'];

$sql = "SELECT * FROM tb_grade WHERE grade_name ='$name' AND grade_id != '$id'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}
