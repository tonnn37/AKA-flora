<?php
require('connect.php');

$insert_material_name = $_POST['insert_material_name'];
$insert_type_material_name = $_POST['insert_type_material_name'];
$insert_unit_name = $_POST['insert_unit_name'];
$insert_material_amount = $_POST['insert_material_amount'];


$sql = "SELECT * FROM tb_material
      LEFT JOIN tb_type_material ON tb_type_material.type_material_id = tb_material.ref_type_material
      LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_material.ref_drug_unit
        WHERE  tb_material.material_name = '$insert_material_name' AND tb_material.material_status ='ปกติ'  AND tb_material.ref_drug_unit='$insert_unit_name' 
        AND tb_material.ref_type_material ='$insert_type_material_name' AND tb_material.material_amount ='$insert_material_amount'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo 0;
}



?>