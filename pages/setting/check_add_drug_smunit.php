<?php
require('connect.php');
$smunitname = $_POST['smunitname'];

$sql = "SELECT * FROM tb_drug_sm_unit WHERE drug_sm_unit_name ='$smunitname'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}
