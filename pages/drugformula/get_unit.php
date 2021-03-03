<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


    $query = "SELECT * FROM tb_drug
                LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id  = tb_drug.ref_drug_unit
                WHERE drug_id = '$id'
    ORDER BY drug_id ASC";

    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_array();

        $drug_unit_name = $row['drug_unit_name'];
        
        echo $drug_unit_name;
    }

