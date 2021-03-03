<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


if ($id != "") {
    // Fetch state data based on the specific country

    $query = "SELECT tb_planting_detail.planting_detail_id as planting_detail_id
,tb_planting_detail.planting_detail_status as planting_detail_status
,tb_planting_detail.planting_detail_amount as planting_detail_amount
,tb_planting_detail.planting_detail_per as planting_detail_per
,tb_planting_detail.planting_detail_total as planting_detail_total
,tb_planting_detail.ref_planting_id as ref_planting_id
,tb_planting_detail.ref_plant_id as ref_plant_id
,tb_planting_detail.ref_order_detail_id as ref_order_detail_id
,tb_planting_detail.planting_detail_enddate as planting_detail_enddate
,tb_plant.plant_name as plant_name

FROM tb_planting_detail
LEFT JOIN tb_planting ON tb_planting.planting_id = tb_planting_detail.ref_planting_id
LEFT JOIN tb_order ON tb_planting.ref_order_id = tb_order.order_id
LEFT JOIN tb_order_detail ON tb_order_detail.ref_order_id = tb_order.order_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
LEFT JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id = tb_planting_detail.planting_detail_id
LEFT JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
WHERE  tb_planting_week.planting_week_status='เสร็จสิ้น' AND tb_planting_week.planting_week_count = 12 AND tb_planting_detail.planting_detail_id = '$id'
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

        echo $total;
    } else {
        echo "ไม่พบจำนวน";
    }
} else {
    echo "ไม่พบจำนวน";
}
