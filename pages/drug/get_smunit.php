<?php
// Include the database config file
require('connect.php');
$id = $_POST['unit_id'];


if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_group_drug
            INNER JOIN tb_drug_sm_unit ON tb_drug_sm_unit.drug_sm_unit_id = tb_group_drug.ref_drug_sunit 
            WHERE tb_drug_sm_unit.drug_sm_unit_status ='ปกติ' AND tb_group_drug.group_drug_id = '$id'
            ORDER BY group_drug_id ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['drug_sm_unit_name'];
    } else {
        echo "";
    }
} else {
    echo "";
}
