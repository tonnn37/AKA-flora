<?php
require('connect.php');
$tel = $_POST['elem'];

$sql = "SELECT * FROM tb_user WHERE telephone ='$tel'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}
