<?php

require('connect.php');
$id = $_POST['id'];



$query = "SELECT * FROM tb_order_detail

INNER JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
WHERE tb_order.order_status ='ปกติ' AND tb_order_detail.order_detail_planting_status = 'เสร็จสิ้น' AND tb_order_detail.order_detail_status = 'รอส่งมอบ'
AND  tb_order_detail.ref_order_id = '$id' ";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    echo 0;
} else {
    echo 1;
}
