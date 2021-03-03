<?php
// Include the database config file
require 'connect.php';
$grade = $_POST['grade'];
$type = $_POST['type'];
if ($grade != "" && $type != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_plant
            INNER JOIN tb_stock_detail ON tb_stock_detail.ref_plant_id=tb_plant.plant_id
            WHERE stock_detail_status ='ปกติ' AND  tb_plant.ref_type_plant= '$type' AND tb_stock_detail.ref_grade_id='$grade'
            ORDER BY tb_stock_detail.ref_grade_id ASC";

    $result = $conn->query($query);
    
    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        echo '<option value="0">----โปรดเลือกพันธ์ไม้----</option>';
        while ($row = $result->fetch_assoc()) {

            echo '<option value="' . $row['plant_id'] . '">' . $row['plant_name'] . '</option>';
        }
    } else {
        echo '<option value="">ไม่พบพันธ์ไม้</option>';
    }
} else {
    echo '<option value="">ไม่พบพันธ์ไม้</option>';
}
