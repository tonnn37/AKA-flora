<?php
require('connect.php');
$id = $_POST['id'];
$typename = $_POST['typename'];
$group_drugname = $_POST['group_drugname'];

$sql = "SELECT * FROM tb_group_drug WHERE group_drug_name ='$group_drugname' AND ref_drug_type='$typename' AND group_drug_id != '$id' ";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}
