<?php
require('connect.php');
$id = $_POST['drug_type'];

if ($id != "") {

    $query = "SELECT * FROM `tb_group_drug` 
    INNER JOIN tb_drug_type ON tb_drug_type.drug_typeid = tb_group_drug.ref_drug_type
    WHERE tb_group_drug.group_drug_id = '$id'
    ORDER BY `group_drug_id` ASC";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          
            echo $row['drug_typeid'] ;
        }
    } else {
        echo '<option value="">ไม่พบประเภทยา</option>';
    }
} else {
    echo '<option value="">ไม่พบประเภทยา</option>';
}
