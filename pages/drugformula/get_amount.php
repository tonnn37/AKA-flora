<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


    $query = "SELECT * FROM tb_drug
                WHERE drug_id = '$id'
    ORDER BY drug_id ASC";

    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_array();

        $drug_amount = $row['drug_amount'];
        
        echo $drug_amount;
    }

