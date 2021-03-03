<?php
// Include the database config file
require('connect.php');
$id = $_POST['drug_id'];


if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_drug
            WHERE tb_drug.drug_status ='ปกติ' AND  tb_drug.ref_group_drug = '$id'
            ORDER BY drug_id ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        echo '<option value="0">----โปรดเลือกยา----</option>';
        while ($row = $result->fetch_assoc()) {
          
            echo '<option value="' . $row['drug_id'] . '">' . $row['drug_name'] . '</option>';
        }
    } else {
        echo '<option value="">ไม่พบยา</option>';
    }
} else {
    echo '<option value="">ไม่พบยา</option>';
}
