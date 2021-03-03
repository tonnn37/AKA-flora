<?php
require('connect.php');
$id = $_POST['id'];
$ref_order_id = $_POST['ref_order_id'];
$plant_id = $_POST['plant_id'];
$type_plant = $_POST['type_plant'];

$sql = "SELECT * FROM tb_order_detail 
        LEFT JOIN tb_plant ON  tb_plant.plant_id =tb_order_detail.ref_plant_id
        LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
        WHERE tb_order_detail.ref_plant_id = '$plant_id' AND tb_plant.ref_type_plant = '$type_plant' AND tb_order.order_id ='$ref_order_id'AND tb_order_detail.order_detail_id != '$id' ";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo $sql;
}



?>