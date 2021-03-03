<?php
require('connect.php');
$id = $_POST['drug_id'];

if ($id != "") {
   
    $query = "SELECT * FROM tb_drug
    LEFT JOIN tb_group_drug ON tb_group_drug.group_drug_id = tb_drug.ref_group_drug
    WHERE tb_drug.drug_id = '$id'

    ORDER BY group_drug_id ASC";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          
            echo $row['group_drug_id'] ;
        }
    } else {
        echo '<option value="">ไม่พบกลุ่มยา</option>';
    }
} else {
    echo '<option value="">ไม่พบกลุ่มยา</option>';
}
