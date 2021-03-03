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
                ,tb_planting_week_detail.material_amount as material_amounts
                ,tb_planting_week_detail.material_price as material_price
                ,tb_planting_week_detail.week_detail_dead as week_detail_dead   
                ,tb_planting_week_detail.week_detail_date as week_detail_date   
                ,tb_planting_week_detail.week_detail_status as week_detail_status   
                ,tb_planting_week_detail.ref_planting_week_id as ref_planting_week_id   
                ,tb_planting_week.planting_week_count as planting_week_count
                ,tb_drug_formula.drug_formula_id as drug_formula_id
                ,tb_drug_formula.drug_formula_name as drug_formula_name
                ,tb_drug_formula.drug_formula_amount as drug_formula_amount
                ,tb_material.material_id as material_id
                ,tb_material.material_name as material_name
                ,tb_material.material_amount as material_amount
                ,tb_drug_unit.drug_unit_name as drug_unit_name
                ,tb_planting_week.ref_planting_detail_id as ref_planting_detail_id
                ,tb_plant.plant_name as plant_name
                

FROM tb_planting_week_detail
LEFT JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
LEFT JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
LEFT JOIN tb_drug_formula ON tb_drug_formula.drug_formula_id = tb_planting_week_detail.ref_drug_formula_id
LEFT JOIN tb_material ON  tb_material.material_id = tb_planting_week_detail.ref_material_id
LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_material.ref_drug_unit
WHERE tb_planting_week_detail.ref_planting_week_id ='$id' 
ORDER BY tb_planting_week_detail.ref_planting_week_id ASC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        $drug_formula_id = $row['drug_formula_id'];
        

        $sql_quality = "SELECT SUM(tb_drug_formula_detail.drug_formula_detail_amount_sm) as count FROM tb_drug_formula_detail WHERE tb_drug_formula_detail.ref_drug_formula='$drug_formula_id'  AND tb_drug_formula_detail.drug_formula_detail_status ='ปกติ' ";
        $re_quality = mysqli_query($conn, $sql_quality);
        $r_quality = mysqli_fetch_assoc($re_quality);
        $sum_quality = $r_quality['count'];

        if ($sum_quality == "") {
            $sum_quality = 0;
        }
       

        if($row['ref_drug_formula_id'] == "-"){
            $drug_name = "-";
            $formula = "";
            $sum_quality = "";
            $drug_formula_amount ="-";

        }else{

            $drug_name = $row['drug_formula_name'];
            $formula = "(".$sum_quality." "."ลิตร".")";
            $drug_formula_amount = $row['drug_formula_amount'];
        }

        if($row['ref_material_id'] == "-"){
            $material_name = "-";
            $material_amount = "";
            $drug_unit_name = "";
            $material = "";
        }else{
            
            $material_amount = $row['material_amount'];
            $drug_unit_name = $row['drug_unit_name'];
            $material_name = $row['material_name'];
            $material = "(".$drug_unit_name.")"." "."(".$material_amount." "."กก.".")";
        }

        $days = date("d-m-Y", strtotime($row['week_detail_date']));
        $subdata = array();

        $subdata[] = $i;
        $subdata[] = $drug_name." ".$formula;
        $subdata[] = $drug_formula_amount;
        $subdata[] = $row['formula_amount'];
        $subdata[] = $row['formula_price'];
        $subdata[] = $material_name." ".$material;
        $subdata[] = $row['material_amounts'];
        $subdata[] = $row['material_price'];
        $subdata[] = $row['week_detail_dead'];
        $subdata[] = $days;
        $subdata[] = $row['week_detail_status'];


        if ($row['week_detail_status'] == 'ปกติ') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
        } else if ($row['week_detail_status'] == 'ระงับ') {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
        }
        $subdata[] = '
        <a>
        <button type="button" class="btn btn-warning btn-sm" id="btn_edit_planting_week" data="'.$row['week_detail_id'].'" 
        week="' . $row['planting_week_count'] . '" plant="' . $row['plant_name'] . '" planting-id="' . $row['ref_planting_detail_id'] . '"
            data-toggle="tooltip"  title="แก้ไขข้อมูล"" >
            <i class="fas fa-edit" style="color:white"></i></button></a>' . '

        <button type="button" class="' . $color . '"  id="btn_remove_week_detail" data="' . $row['week_detail_id'] . '"data-status="' . $row['week_detail_status'] . '"  data-id="' . $i . '" data-name="' . $row['drug_formula_name'] . '" 
            data-toggle="tooltip"  title="' . $txt . '" ">
            <i  class="' . $image . '" style="color:white"></i></button>';
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

