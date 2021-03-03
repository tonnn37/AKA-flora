<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];

$sql = "SELECT Max(planting_detail_id) as Maxid FROM tb_planting_detail 
            LEFT JOIN tb_planting ON tb_planting.planting_id = tb_planting_detail.ref_planting_id

            WHERE tb_planting.ref_order_id = '$id'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
//echo $sql;
if (mysqli_num_rows($result)>0) {
    echo $row['Maxid'];
} else {
    echo "ไม่พบรหัส";
}
