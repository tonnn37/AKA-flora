<?php
require('connect.php');
$type = $_POST['type'];
$id = $_POST['id'];

$sql = "SELECT * FROM tb_drug_type WHERE drug_typename ='$type' AND drug_typeid != '$id'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}
