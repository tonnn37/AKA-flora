<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM  tb_drug
    LEFT JOIN tb_drug_unit ON tb_drug.ref_drug_unit = tb_drug_unit.drug_unit_id
    WHERE tb_drug_unit.drug_unit_status ='ปกติ' AND tb_drug.drug_id   = '$id'
    ORDER BY drug_unit_id ASC";

    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $unit_name = $row['drug_unit_name'];
        
        if($unit_name =="ขวด" || $unit_name =="แกลลอน"){

            echo "มิลลิลิตร";

        }else if($unit_name =="ถุง" || $unit_name =="กระสอบ"){

            echo "กรัม";
        }else {
             
            echo "กรัม";
        }
    } else {
        echo "";
    }
} else {
    echo "";
}
