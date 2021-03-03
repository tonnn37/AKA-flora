<?php
require('connect.php');

$id = $_POST['id'];
$formula_name = $_POST['formula_name'];

$sql = "SELECT * FROM tb_drug_formula
    WHERE drug_formula_status = 'ปกติ' AND drug_formula_name = '$formula_name' AND drug_formula_id != '$id'";

$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    echo 1;

}else{
    echo $sql;
}
