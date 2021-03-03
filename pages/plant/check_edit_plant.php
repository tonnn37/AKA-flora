<?php
require('connect.php');

$id = $_POST['id'];
$edit_plant_name = $_POST['edit_plant_name'];
$edit_plant_typename = $_POST['edit_plant_typename'];



$sql = "SELECT * FROM tb_plant
        LEFT JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
        WHERE  tb_plant.plant_name = '$edit_plant_name' AND tb_plant.plant_status ='ปกติ'  AND tb_plant.ref_type_plant='$edit_plant_typename' AND tb_plant.plant_id != '$id'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo $sql;
}



?>