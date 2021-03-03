<?php
require('connect.php');
$id = $_POST['id'];
$edit_material_name = $_POST['edit_material_name'];
$edit_type_material_name = $_POST['edit_type_material_name'];
$edit_material_unit = $_POST['edit_material_unit'];
$edit_material_amount = $_POST['edit_material_amount'];


$sql = "SELECT * FROM tb_material
      LEFT JOIN tb_type_material ON tb_type_material.type_material_id = tb_material.ref_type_material
      LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_material.ref_drug_unit
        WHERE  tb_material.material_name = '$edit_material_name' AND tb_material.material_status ='ปกติ'  AND tb_material.ref_drug_unit='$edit_material_unit' 
        AND tb_material.ref_type_material ='$edit_type_material_name' AND tb_material.material_amount ='$edit_material_amount' AND tb_material.material_id != '$id'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo 0;
}



?>