<?php
// Include the database config file
require('connect.php');
$id = $_POST['id_plant'];


if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_plant
            WHERE tb_plant.plant_status ='ปกติ' AND  tb_plant.plant_id = '$id'
            ORDER BY plant_id ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo $row['picture'];
    } else {
        echo "ไม่พบรูปภาพ";
    }
} else {
    echo "ไม่พบรูปภาพ";
}
