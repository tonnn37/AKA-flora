<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_drug_unit 
            WHERE drug_unit_status = 'ปกติ' AND drug_unit_id = '$id'
            ORDER BY drug_unit_name ASC";

    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $unit_name = $row['drug_unit_name'];
        
        if($unit_name =="ขวด" || $unit_name =="แกลลอน"){

            echo "ลิตร";

        }else if($unit_name =="ถุง" || $unit_name =="กระสอบ"){

            echo "กิโลกรัม";
        }else {
             
            echo "กิโลกรัม";
        }
    } else {
        echo "";
    }
} else {
    echo "";
}
