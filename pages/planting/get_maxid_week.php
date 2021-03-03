<?php

require('connect.php');
$id = $_POST['id'];

$sql_id_detail_borrow = "SELECT max(planting_week_count) as Maxid  FROM tb_planting_week WHERE ref_planting_detail_id ='$id' AND (planting_week_status ='ปกติ' OR planting_week_status ='เสร็จสิ้น')";
$result_id_bor = mysqli_query($conn, $sql_id_detail_borrow);
$row_id = mysqli_fetch_assoc($result_id_bor);
$old_id = $row_id['Maxid'];
$id_count = $old_id + 1;

echo $id_count;
