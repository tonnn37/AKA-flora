<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


if ($id != "") {
    // Fetch state data based on the specific country

    $query = "SELECT tb_planting_detail.planting_detail_id as planting_detail_id
    ,tb_planting.planting_id as planting_id
    ,tb_order.order_name as order_name
    ,tb_customer.customer_firstname as customer_firstname
    ,tb_customer.customer_lastname as customer_lastname
    ,tb_plant.plant_name as plant_name
    ,tb_planting_detail.planting_detail_total as planting_detail_total

    FROM tb_planting_detail
    LEFT JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id = tb_planting_detail.planting_detail_id
    LEFT JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
    LEFT JOIN tb_planting ON tb_planting.planting_id = tb_planting_detail.ref_planting_id
    LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
    LEFT JOIN tb_order ON tb_order.order_id = tb_planting.ref_order_id
    LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
    WHERE tb_planting_detail.planting_detail_status = 'รอคัดเกรด' AND (SELECT COUNT( ref_planting_detail_id ) FROM tb_planting_week ) >=12 
    AND (SELECT COUNT(planting_week_status) FROM tb_planting_week WHERE planting_week_status ='เสร็จสิ้น' ) >=12 AND tb_planting_detail.planting_detail_id = '$id'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $planting_amount = $row['planting_detail_total'];
        
        $sql_dead = "SELECT SUM(tb_planting_week_detail.week_detail_dead) as dead FROM tb_planting_detail
        INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id =  tb_planting_detail.planting_detail_id
        INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
        WHERE  tb_planting_week.ref_planting_detail_id ='$id' AND tb_planting_week_detail.week_detail_status ='ปกติ'";
        $re_dead = mysqli_query($conn, $sql_dead);
        $r_dead = mysqli_fetch_assoc($re_dead);
        $sum_dead = $r_dead['dead'];

        if ($sum_dead == "") {
            $sum_dead = 0;
        }

        $total = $planting_amount - $sum_dead ;

        echo $total;;
    } else {
        echo "ไม่พบจำนวน";
    }
} else {
    echo "ไม่พบจำนวน";
}
