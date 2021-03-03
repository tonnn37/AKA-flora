<?php
// Include the database config file
require('connect.php');
$id = $_POST['drug_id'];


if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_drug
            LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_drug.ref_drug_unit
            WHERE tb_drug.drug_status ='ปกติ' AND  tb_drug.ref_group_drug = '$id'

            ORDER BY drug_id ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        echo '<option value="0">----โปรดเลือกยา----</option>';
        while ($row = $result->fetch_assoc()) {

            $unit_name = $row['drug_unit_name'];
        
            if($unit_name =="ขวด" || $unit_name =="แกลลอน"){
    
                $unit =  "ลิตร";
    
            }else if($unit_name =="ถุง" || $unit_name =="กระสอบ"){
    
                $unit = "กิโลกรัม";
            }else {
                 
                $unit =  "กิโลกรัม";
            }
          
            echo '<option value="' . $row['drug_id'] . '">' . $row['drug_name'] ." "."("."$unit_name".")"." "."(". $row['drug_amount'] ." "."$unit".")" .'</option>';
        }
    } else {
        echo '<option value="">ไม่พบยา</option>';
    }
} else {
    echo '<option value="">ไม่พบยา</option>';
}
