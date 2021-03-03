<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];

if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT tb_stock_detail.stock_detail_id as stock_detail_id,
    tb_stock_detail.stock_detail_status as stock_detail_status,
    tb_stock_detail.stock_detail_date as stock_detail_date,
    tb_stock_detail.stock_detail_amount as stock_detail_amount,
    tb_grade.grade_name as grade_name,
    tb_plant.plant_name as plant_name,
    SUM(tb_stock_detail.stock_detail_amount) as amount,
    tb_grade.grade_id as grade_id
    FROM tb_stock_detail
    LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_detail.ref_grade_id
    LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_detail.ref_plant_id
    WHERE tb_stock_detail.ref_plant_id ='$id'
    GROUP BY tb_grade.grade_id
    ORDER BY tb_stock_detail.stock_detail_id";

    $result = mysqli_query($conn, $query);
 
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        
        echo $row['stock_detail_amount'];
    } else {
        echo "0";
    }
} else {
    echo "0";
}
