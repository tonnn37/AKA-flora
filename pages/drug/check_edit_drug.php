<?php
require('connect.php');
$id = $_POST['id'];
$drug_name = $_POST['drug_name'];
$drug_type = $_POST['drug_type'];
$drug_group = $_POST['drug_group'];
$unit = $_POST['unit'];
$drugamount = $_POST['drugamount'];

$sql = "SELECT * FROM tb_drug 
WHERE tb_drug.drug_name = '$drug_name' AND tb_drug.ref_group_drug = '$drug_group' AND tb_drug.ref_drug_unit = '$unit' AND tb_drug.drug_amount ='$drugamount' AND drug_id !='$id'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}



?>