<?php
require 'connect.php';
$id = $_POST['id'];

$sql = "SELECT Max(order_detail_id) as Maxid FROM tb_order_detail WHERE ref_order_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
//echo $sql;
if (mysqli_num_rows($result)>0) {
    echo $row['Maxid'];
} else {
    echo "ไม่พบรหัส";
}
?>