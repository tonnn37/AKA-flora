<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


if ($id != "") {
    // Fetch state data based on the specific country

    $query = "SELECT tb_planting.planting_id as planting_id, COUNT(tb_planting_week.ref_planting_detail_id) as COUNT
    ,tb_planting_detail.planting_detail_status as plating_detail_status
    ,tb_order.order_name as order_name
    ,tb_customer.customer_firstname as customer_firstname
    ,tb_customer.customer_lastname as customer_lastname
    ,tb_planting_detail.planting_detail_id as planting_detail_id
    ,tb_plant.plant_name as plant_name
                  
                      FROM tb_planting_detail
                      LEFT JOIN tb_planting ON tb_planting.planting_id = tb_planting_detail.ref_planting_id
                      LEFT JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id = tb_planting_detail.planting_detail_id
                      LEFT JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
                      LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
                      LEFT JOIN tb_order ON tb_order.order_id = tb_planting.ref_order_id
                      LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
                      WHERE tb_planting_week.planting_week_status ='เสร็จสิ้น' AND tb_planting_detail.planting_detail_status ='รอคัดเกรด' AND tb_planting_detail.ref_planting_id ='$id'
                
                      GROUP BY tb_planting_detail.planting_detail_id
                      ORDER BY tb_planting_detail.planting_detail_id ASC";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo '<option value="0">---โปรดเลือกพันธุ์ไม้---</option>';
        while ($row = $result->fetch_assoc()) {

            $count = $row['COUNT'];
            $count = intval($count);
            if ($count >= 12) {
                echo '<option value="' . $row['planting_detail_id'] . '">' . $row['plant_name'] . '</option>';
            }
        }
    } else {
        echo '<option value="">ไม่พบพันธุ์ไม้</option>';
    }
} else {
    echo '<option value="">ไม่พบพันธุ์ไม้</option>';
}
