<?php
require('connect.php');
$drugformula_detail_id = $_POST['drugformula_detail_id'];
$ref_drug_formula = $_POST['ref_drug_formula'];
$drug_id = $_POST['drug_id'];
$drug_type = $_POST['drug_type'];
$drug_group = $_POST['drug_group'];

$sql = "SELECT * FROM tb_drug_formula_detail
INNER JOIN tb_drug_formula ON tb_drug_formula.drug_formula_id = tb_drug_formula_detail.ref_drug_formula 
WHERE tb_drug_formula_detail.ref_drug_id = '$drug_id' 
AND tb_drug_formula.drug_formula_status ='ปกติ' 
AND tb_drug_formula_detail.drug_formula_detail_status ='ปกติ' 
AND tb_drug_formula_detail.ref_drug_formula = '$ref_drug_formula' 
AND tb_drug_formula_detail.drug_formula_detail_id !='$drugformula_detail_id'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo $sql;
}
