<?php

require 'connect.php';
$id = $_POST['plant_id'];
$grade_id = $_POST['grade_id'];

if ($id != "") {
  
    $query = "SELECT tb_plant_detail.plant_detail_price as plant_detail_price FROM tb_plant
    LEFT JOIN tb_plant_detail ON tb_plant_detail.ref_plant_id  = tb_plant.plant_id
    LEFT JOIN tb_grade ON tb_grade.grade_id = tb_plant_detail.ref_grade_id
    WHERE tb_plant.plant_status ='ปกติ' AND  tb_plant.plant_id='$id' AND tb_grade.grade_id = '$grade_id'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['plant_detail_price'];
    } else {
        echo "ไม่พบราคา";
    }
} else {
   echo "ไม่พบราคา";

}
