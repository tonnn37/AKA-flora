<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


if ($id != "") {
    // Fetch state data based on the specific country

    $query = "SELECT tb_order_detail.order_detail_id as order_detail_id,
    tb_order_detail.order_detail_amount as order_detail_amount,
    tb_order_detail.order_detail_enddate as order_detail_enddate,
    tb_order.order_name as order_name,
    tb_plant.plant_name as plant_name,
    tb_order.order_customer as order_customer,
    tb_order.order_id as order_id
    
    
FROM tb_order_detail
LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
WHERE tb_order_detail.order_detail_status ='รอส่งมอบ' AND tb_order_detail.ref_order_id = '$id'  AND tb_order_detail.order_detail_planting_status ='เสร็จสิ้น'
ORDER BY tb_order_detail.order_detail_id ASC";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo '<option value="0">---โปรดเลือกพันธุ์ไม้---</option>';
        while ($row = $result->fetch_assoc()) {
          
            echo '<option value="' . $row['order_detail_id'] . '" >' . $row['plant_name'] . '</option>';
        }
    } else {
        echo '<option value="">ไม่พบพันธุ์ไม้</option>';
    }
} else {
    echo '<option value="">ไม่พบพันธุ์ไม้</option>';
}