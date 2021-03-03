<?php
require('connect.php');

$insert_plant_name = $_POST['insert_plant_name'];
$insert_plant_typename = $_POST['insert_plant_typename'];


$sql = "SELECT * FROM tb_plant
        LEFT JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
        WHERE  tb_plant.plant_name = '$insert_plant_name' AND tb_plant.plant_status ='ปกติ'  AND tb_plant.ref_type_plant='$insert_plant_typename'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo $sql;
}



?>