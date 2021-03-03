<?php
include('connect.php');
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
date_default_timezone_set("Asia/Bangkok");
$d = date("Y-m-d");


$sql_week_detail = "SELECT max(week_detail_id) as Maxid  FROM tb_planting_week_detail";
$result_week_detail = mysqli_query($conn, $sql_week_detail);
$row_id = mysqli_fetch_assoc($result_week_detail);
$old_id = $row_id['Maxid'];
$id_week_detail = $old_id + 1;



$ref_week_id = $_POST['in2_week_id'];


$ref_formula = $_POST['in2_planting_week_drug_formula'];
$formula_amount = $_POST['in2_planting_week_amount_drug'];
$formula_amounts = str_replace(',','', $formula_amount);
$formula_price = $_POST['in2_planting_week_formula_price'];
$formula_prices = str_replace(',','', $formula_price);

$ref_material = $_POST['in2_planting_week_material'];
$material_amount = $_POST['in2_planting_week_amount_material'];
$material_amounts = str_replace(',','', $material_amount);
$material_price = $_POST['in2_planting_week_material_price'];
$material_prices = str_replace(',','', $material_price);

$week_dead = $_POST['in2_planting_week_dead'];
$week_date = $_POST['in2_planting_week_date'];


if($ref_formula == "0"){
    $ref_formula ="-";
    $formula_amounts ="-";
    $formula_prices ="-";
}else{
    $ref_formula = $ref_formula;
    $formula_amounts =  $formula_amounts;
    $formula_prices = $formula_prices;
}

if($ref_material =="0"){
    $ref_material ="-";
    $material_amounts ="-";
    $material_prices ="-";
}else{
    $ref_material = $ref_material;
    $material_amounts = $material_amounts;
    $material_prices = $material_prices;
}

$sql_week_detail ="INSERT INTO tb_planting_week_detail(week_detail_id,ref_drug_formula_id,formula_amount,formula_price,ref_material_id,material_amount,material_price,week_detail_dead
                                                        ,week_detail_date,week_detail_status,ref_planting_week_id,created_by,created_at,update_by,update_at) 
                VALUES('$id_week_detail','$ref_formula','$formula_amounts','$formula_prices','$ref_material','$material_amounts','$material_prices','$week_dead','$week_date','ปกติ','$ref_week_id'
                        ,'$name','$d','$name','$d')";


if(mysqli_query($conn,$sql_week_detail)){
    echo  $sql_week_detail;
}else{
    echo mysqli_error($conn);

}

?>