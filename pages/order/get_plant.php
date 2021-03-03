<?php
// Include the database config file
require('connect.php');
$id = $_POST['type_id'];


if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_plant
            WHERE tb_plant.plant_status ='ปกติ' AND  tb_plant.ref_type_plant = '$id'
            ORDER BY plant_id ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        echo '<option value="0">----โปรดเลือกพันธุ์ไม้----</option>';
        while ($row = $result->fetch_assoc()) {

            echo '<option value="' . $row['plant_id'] . '">' . $row['plant_name'] . '</option>';
        }
    } else {
        echo '<option value="">ไม่พบพันธุ์ไม้</option>';
    }
} else {
    echo '<option value="">ไม่พบพันธุ์ไม้</option>';
}
