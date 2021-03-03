<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_planting_week WHERE (planting_week_status ='ปกติ' OR planting_week_status ='เสร็จสิ้น')AND ref_planting_detail_id ='$id' ORDER BY planting_week_id ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        echo '<option value="0">---โปรดเลือกสัปดาห์---</option>';
        while ($row = $result->fetch_assoc()) {
          
            echo '<option value="' . $row['planting_week_id'] . '">'.'สัปดาห์ที่ '. $row['planting_week_count'] . '</option>';
        }
    } else {
        echo '<option value="0">ไม่พบสัปดาห์</option>';
    }
} else {
    echo '<option value="0">ไม่พบสัปดาห์</option>';
}
