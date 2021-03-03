<?php
// Include the database config file
require('connect.php');
$id = $_POST['type_id'];


if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM tb_group_drug WHERE ref_drug_type = '$id' AND group_drug_status='ปกติ' ORDER BY group_drug_name ASC";
    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        echo '<option value="0">----โปรดเลือกกลุ่มยา----</option>';

        while ($row = $result->fetch_assoc()) {

            echo '<option value="' . $row['group_drug_id'] . '">' . $row['group_drug_name'] . '</option>';
        }
    } else {
        echo '<option value="">ไม่พบกลุ่มยา</option>';
    }
} else {
    echo '<option value="">ไม่พบกลุ่มยา</option>';
}
