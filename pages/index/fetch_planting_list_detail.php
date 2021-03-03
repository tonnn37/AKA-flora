<?php
//fetch.php
require 'connect.php';
$output = '';
$query = "";
$id = $_POST['extra_search'];



$query = "SELECT tb_planting_week_detail.week_detail_id as week_detail_id
                ,tb_planting_week_detail.ref_drug_formula_id as ref_drug_formula_id
                ,tb_planting_week_detail.formula_amount as formula_amount
                ,tb_planting_week_detail.formula_price as formula_price
                ,tb_planting_week_detail.ref_material_id as ref_material_id
                ,tb_planting_week_detail.material_amount as material_amount
                ,tb_planting_week_detail.material_price as material_price
                ,tb_planting_week_detail.week_detail_dead as week_detail_dead   
                ,tb_planting_week_detail.week_detail_date as week_detail_date   
                ,tb_planting_week_detail.week_detail_status as week_detail_status   
                ,tb_planting_week_detail.ref_planting_week_id as ref_planting_week_id   
                ,tb_planting_week.planting_week_count as planting_week_count
                ,tb_drug_formula.drug_formula_name as drug_formula_name
                ,tb_material.material_id as material_id
                ,tb_material.material_name as material_name

FROM tb_planting_week_detail
LEFT JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
LEFT JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
LEFT JOIN tb_drug_formula ON tb_drug_formula.drug_formula_id = tb_planting_week_detail.ref_drug_formula_id
LEFT JOIN tb_material ON  tb_material.material_id = tb_planting_week_detail.ref_material_id
WHERE tb_planting_week_detail.ref_planting_week_id ='$id' 
ORDER BY tb_planting_week_detail.ref_planting_week_id ASC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        if($row['ref_drug_formula_id'] =="0"){
            $row['drug_formula_name'] = "-";
        }else{
            $row['drug_formula_name'];
        }

        if($row['formula_amount'] ==""){
            $row['formula_amount'] = "-";
        }else{
            number_format($row['formula_amount'],2);
        }

        if($row['formula_price'] ==""){
            $row['formula_price'] = "-";
        }else{
            number_format($row['formula_price'],2);
        }

        if($row['material_id'] =="0"){
            $row['material_name'] = "-";
        }else{
            $row['material_name'];
        }

        if($row['material_amount'] ==""){
            $row['material_amount'] = "-";
        }else{
            number_format($row['material_amount'],2);
        }

        if($row['material_price'] ==""){
            $row['material_price'] = "-";
        }else{
            number_format($row['material_price'],2);
        }


        $subdata = array();

        $subdata[] = $i;
        $subdata[] = $row['drug_formula_name'];
        $subdata[] = $row['formula_amount'];
        $subdata[] = $row['formula_price'];
        $subdata[] = $row['material_name'];
        $subdata[] = $row['material_amount'];
        $subdata[] = $row['material_price'];
        $subdata[] = $row['week_detail_dead'];
        $subdata[] = $row['week_detail_date'];
        $subdata[] = $row['week_detail_status'];

   
        $rows[] = $subdata;

        $i++;
    }
    $json_data = array(
  
        "data" => $rows,
    );
    echo json_encode($json_data);
} else {
    $json_data = array(
   
        "data" => "",
    );
    echo json_encode($json_data);
}

?>

