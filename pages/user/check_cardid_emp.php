<?php
require('connect.php');
$cardid = $_POST['cardid'];

$sql = "SELECT * FROM tb_user WHERE card_id ='$cardid'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo 0;
}else{
	echo 1;
}
