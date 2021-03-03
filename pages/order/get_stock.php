<?php
require 'connect.php';

$id_plant = $_POST['id_plant'];


$sql_plant = "SELECT tb_plant.plant_name as plant_name,
tb_plant.plant_id as plant_id
FROM tb_plant
WHERE tb_plant.plant_status = 'ปกติ' AND tb_plant.plant_id ='$id_plant'";

$re_plant = mysqli_query($conn, $sql_plant);
$row_plant = mysqli_fetch_assoc($re_plant);
$plant_id = $row_plant['plant_id'];

$sql = "SELECT tb_stock_detail.stock_detail_amount,tb_grade.grade_name as grade_name 
        FROM tb_stock_detail 
        INNER JOIN tb_grade ON tb_grade.grade_id = tb_stock_detail.ref_grade_id 
        WHERE ref_plant_id ='$plant_id' AND stock_detail_status ='ปกติ'";
$re = mysqli_query($conn, $sql);

if (mysqli_num_rows($re) > 0) {
    while ($row = mysqli_fetch_array($re)) {
        $stock_detail_amount = $row['stock_detail_amount'];
        $grade_name = $row['grade_name'];
        
        echo "จำนวนคงเหลือในสต็อก เกรด $grade_name :" ." ".$row['stock_detail_amount']." "."ต้น";
        echo "<br/>";
    }
} else {
    echo "ไม่มีข้อมูลในสต็อก";
    echo "<br/>";
}
