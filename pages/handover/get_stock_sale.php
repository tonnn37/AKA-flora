<?php
require 'connect.php';

$plant_id = $_POST['plant_id'];
$grade_id = $_POST['grade_id'];


$sql = "SELECT stock_detail_amount FROM tb_stock_detail WHERE ref_plant_id ='$plant_id' AND ref_grade_id = '$grade_id' AND stock_detail_status ='ปกติ'";
$re = mysqli_query($conn,$sql);
if(mysqli_num_rows($re) > 0){
$row = mysqli_fetch_assoc($re);

echo $row['stock_detail_amount'];
}else{
    echo "0" ;
}
?>