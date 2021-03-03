<?php
require('connect.php');


$insert_type_material_name = $_POST['insert_type_material_name'];


$sql = "SELECT * FROM tb_type_material
     
        WHERE  tb_type_material.type_material_name = '$insert_type_material_name' AND tb_type_material.type_material_status ='ปกติ'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo $sql;
}



?>