<?php
// Include the database config file
require('connect.php');
$id_material = $_POST['id_material'];


if ($id_material != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_material
    INNER JOIN tb_type_material ON tb_type_material.type_material_id = tb_material.ref_type_material
    INNER JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_material.ref_drug_unit 
    WHERE tb_material.material_status ='ปกติ' AND tb_material.material_id = '$id_material'
    ORDER BY type_material_id ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['drug_unit_name'];
    } else {
        echo "";
    }
} else {
    echo "";
}
