<?php
// Include the database config file
require('connect.php');
$id_material = $_POST['id_material'];


if ($id_material != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_material
    WHERE tb_material.material_status ='ปกติ' AND tb_material.material_id = '$id_material'
    ORDER BY material_id ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo number_format($row['material_price'],2);
    } else {
        echo "";
    }
} else {
    echo "";
}
