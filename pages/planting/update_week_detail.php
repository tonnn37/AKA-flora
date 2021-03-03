<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
$edit2_week_id = $_POST['edit2_week_id'];
$edit2_planting_week_amount = $_POST['edit2_planting_week_amount'];

$edit2_planting_week_drug_formula = $_POST['edit2_planting_week_drug_formula'];
$edit2_planting_week_amount_drug = $_POST['edit2_planting_week_amount_drug'];
$edit2_planting_week_amount_drugs = str_replace(',','', $edit2_planting_week_amount_drug);
$edit2_planting_week_formula_price = $_POST['edit2_planting_week_formula_price'];
$edit2_planting_week_formula_prices = str_replace(',','', $edit2_planting_week_formula_price);

$edit2_planting_week_material = $_POST['edit2_planting_week_material'];
$edit2_planting_week_amount_material = $_POST['edit2_planting_week_amount_material'];
$edit2_planting_week_amount_materials = str_replace(',','', $edit2_planting_week_amount_material);
$edit2_planting_week_material_price = $_POST['edit2_planting_week_material_price'];
$edit2_planting_week_material_prices = str_replace(',','', $edit2_planting_week_material_price);

$edit2_planting_week_dead = $_POST['edit2_planting_week_dead'];
$edit2_planting_week_date = $_POST['edit2_planting_week_date'];


$d = date("Y-m-d");

if($edit2_planting_week_drug_formula == "0"){
    $edit2_planting_week_drug_formula ="-";
    $edit2_planting_week_amount_drugs ="-";
    $edit2_planting_week_formula_prices ="-";
}else{
    $edit2_planting_week_drug_formula = $edit2_planting_week_drug_formula;
    $edit2_planting_week_amount_drugs =  $edit2_planting_week_amount_drugs;
    $edit2_planting_week_formula_prices = $edit2_planting_week_formula_prices;
}

if($edit2_planting_week_material =="0"){
    $edit2_planting_week_material ="-";
    $edit2_planting_week_amount_materials ="-";
    $edit2_planting_week_material_prices ="-";
}else{
    $edit2_planting_week_material = $edit2_planting_week_material;
    $edit2_planting_week_amount_materials = $edit2_planting_week_amount_materials;
    $edit2_planting_week_material_prices = $edit2_planting_week_material_prices;
}

$sql_edit_week_detail = "UPDATE tb_planting_week_detail  SET ref_drug_formula_id ='$edit2_planting_week_drug_formula' 
                                                            ,formula_amount = '$edit2_planting_week_amount_drugs'
                                                            ,formula_price = '$edit2_planting_week_formula_prices'
                                                            ,ref_material_id = '$edit2_planting_week_material'
                                                            ,material_amount = '$edit2_planting_week_amount_materials'
                                                            ,material_price = '$edit2_planting_week_material_prices'
                                                            ,week_detail_dead = '$edit2_planting_week_dead'
                                                            ,week_detail_date = '$edit2_planting_week_date'
                                                            ,update_by='$name'
                                                            ,update_at='$d' 
                                                            WHERE week_detail_id ='$edit2_week_id'";

if(mysqli_query($conn, $sql_edit_week_detail)){
    echo $sql_edit_week_detail;

}else{
    echo mysqli_error($conn);

}


?>