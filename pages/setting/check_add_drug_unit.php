<?php
require('connect.php');
$add_drug_unit_name = $_POST['unitname'];

$sql = "SELECT * FROM tb_drug_unit WHERE drug_unit_name ='$add_drug_unit_name'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}
