<?php
// Include the database config file
require('connect.php');
$id = $_POST['id'];


if ($id != "") {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM `tb_drug_formula` 
    WHERE drug_formula_id = '$id'
    ORDER BY `drug_formula_id` ASC";

    $result = $conn->query($query);

    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['drug_formula_amount'];
    } else {
        echo "0";
    }
} else {
    echo "0";
}
