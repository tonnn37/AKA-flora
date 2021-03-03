<?php
require('connect.php');

$edit_type_material_name = $_POST['edit_type_material_name'];
$id = $_POST['id'];


$sql = "SELECT * FROM tb_type_material
     
        WHERE  tb_type_material.type_material_name = '$edit_type_material_name' AND tb_type_material.type_material_status ='ปกติ' AND type_material_id !='$id'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo $sql;
}



?>