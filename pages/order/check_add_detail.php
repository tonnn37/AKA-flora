<?php
require('connect.php');

$od_id = $_POST['od_id'];
$plant_id = $_POST['plant_id'];
$type_plant = $_POST['type_plant'];

$sql = "SELECT * FROM tb_order_detail 
        LEFT JOIN tb_plant ON  tb_plant.plant_id =tb_order_detail.ref_plant_id
        WHERE tb_order_detail.ref_plant_id = '$plant_id' AND tb_plant.ref_type_plant = '$type_plant' AND tb_order_detail.ref_order_id ='$od_id'AND tb_order_detail.order_detail_status ='ปกติ' ";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo $sql;
}



?>