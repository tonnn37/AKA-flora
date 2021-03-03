<?php
require('connect.php');

$insert_type_plant_name = $_POST['insert_type_plant_name'];



$sql = "SELECT * FROM tb_typeplant
     
        WHERE  tb_typeplant.type_plant_name = '$insert_type_plant_name' AND tb_typeplant.type_plant_status ='ปกติ'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo $sql;
}



?>