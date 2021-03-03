<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];

if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT tb_order_detail.order_detail_id as  order_detail_id
    ,tb_order_detail.order_detail_planting_status as order_detail_planting_status
    ,tb_order.order_id as order_id
    ,tb_order.order_name as order_name
    ,tb_customer.customer_firstname as customer_firstname
    ,tb_customer.customer_lastname as customer_lastname
    ,tb_plant.plant_name as plant_name
    
            FROM tb_order_detail
            LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
            LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
            LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
            WHERE tb_order.order_status ='ปกติ' AND tb_order_detail.order_detail_planting_status='ยังไม่ได้ทำการปลูก' 
            AND tb_order.order_id IN (SELECT ref_order_id FROM tb_planting WHERE tb_planting.planting_status='ปกติ') 
            AND tb_order_detail.ref_order_id = '$id'
            ORDER BY tb_order_detail.order_detail_id ASC";

    $result = mysqli_query($conn, $query);
 
    if ($result->num_rows > 0) {
        echo '<option value="0">----โปรดเลือกรายการสั่งซื้อ----</option>';
        while ($row = $result->fetch_assoc()) {
          
            echo '<option value="' . $row['order_detail_id'] . '">'. $row['plant_name'] . ''." (".''.$row['customer_firstname'].''." ".''.$row['customer_lastname'].''.")".'</option>';
        }
    } else {
        echo '<option value="">ไม่พบรายการสั่งซื้อ</option>';
    }
} else {
    echo '<option value="">ไม่พบรายการสั่งซื้อ</option>';
}
