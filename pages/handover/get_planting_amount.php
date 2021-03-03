<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


if ($id != "") {
    // Fetch state data based on the specific country

    $query = "SELECT tb_order_detail.order_detail_id as order_detail_id
    ,tb_order_detail.order_detail_amount as order_detail_amount
    ,tb_order_detail.order_detail_status as order_detail_status
    
    FROM tb_order_detail
    LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
    WHERE tb_order_detail.order_detail_status ='รอส่งมอบ' AND tb_order_detail.order_detail_id = '$id'
    ORDER BY tb_order_detail.order_detail_id ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        echo $row['order_detail_amount'];;
    } else {
        echo "ไม่พบจำนวน";
    }
} else {
    echo "ไม่พบจำนวน";
}
