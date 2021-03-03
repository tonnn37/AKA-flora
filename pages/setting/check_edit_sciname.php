<?php
require('connect.php');

$edit_typeplant_sciencename = $_POST['edit_typeplant_sciencename'];



$sql = "SELECT * FROM tb_typeplant
     
        WHERE  tb_typeplant.type_plant_sciname = '$edit_typeplant_sciencename' AND tb_typeplant.type_plant_status ='ปกติ'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo $sql;
}



?>