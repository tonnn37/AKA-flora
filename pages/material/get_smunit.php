<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_type_material
            INNER JOIN tb_drug_sm_unit ON tb_drug_sm_unit.drug_sm_unit_id = tb_type_material.ref_drug_sm_unit 
            WHERE tb_drug_sm_unit.drug_sm_unit_status ='ปกติ' AND tb_type_material.type_material_id = '$id'
            ORDER BY type_material_id ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['drug_sm_unit_name'];
    } else {
        echo "ไม่พบหน่วย";
    }
} else {
    echo "ไม่พบหน่วย";
}
