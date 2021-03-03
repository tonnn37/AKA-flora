<?php
//fetch.php
require 'connect.php';
$output = '';
$query = "";
$id = $_POST['extra_search'];

$query = "SELECT tb_drug_formula_detail.drug_formula_detail_id as detail_id, tb_drug_formula_detail.ref_drug_formula as ref_drug_formula, 
                tb_drug_formula_detail.drug_formula_detail_amount as detail_amount ,  tb_drug_formula_detail.drug_formula_detail_amount_sm as drug_formula_detail_amount_sm ,
                tb_drug_formula_detail.drug_formula_detail_status as status, 
                tb_drug_formula_detail.ref_drug_id as ref_drug_id,tb_drug_formula_detail.drug_formula_detail_price AS drug_formula_detail_price,

                tb_drug.drug_name as drug_name ,tb_drug.drug_amount AS drug_amount , tb_drug.drug_price AS drug_price,

                tb_drug_type.drug_typename AS drug_typename,

                tb_group_drug.group_drug_name AS group_drug_name,

                tb_drug_unit.drug_unit_name AS drug_unit_name,

                tb_drug_formula.drug_formula_status AS drug_formula_status,

                tb_drug.drug_id as drug_id,
                tb_drug_formula.drug_formula_id as drug_formula_id

  



FROM tb_drug_formula_detail 
LEFT JOIN tb_drug_formula ON tb_drug_formula.drug_formula_id = tb_drug_formula_detail.ref_drug_formula
LEFT JOIN tb_drug ON tb_drug.drug_id = tb_drug_formula_detail.ref_drug_id
LEFT JOIN tb_group_drug ON tb_group_drug.group_drug_id = tb_drug.ref_group_drug
LEFT JOIN tb_drug_type ON tb_drug_type.drug_typeid = tb_group_drug.ref_drug_type
LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_drug.ref_drug_unit
WHERE tb_drug_formula_detail.ref_drug_formula ='$id'
ORDER BY  tb_drug_formula_detail.ref_drug_id ASC";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $detail_id = $row['detail_id'];
        $drug_id = $row['drug_id'];
        $drug_amount = $row['drug_amount'];
        $formula_detail_amount = $row['detail_amount'];
        $drug_formula_detail_amount_sm = $row['drug_formula_detail_amount_sm'];
        $drug_unit_name = $row['drug_unit_name'];
        $drug_formula_id = $row['drug_formula_id'];

        if ($drug_unit_name == "ขวด" || $drug_unit_name == "แกลลอน") {

            $unit =  "ลิตร";
        } else if ($drug_unit_name == "ถุง" || $drug_unit_name == "กระสอบ") {

            $unit = "กิโลกรัม";
        } else {

            $unit =  "กิโลกรัม";
        }

       /*  $sql2 = "SELECT tb_planting_week_detail.ref_drug_formula_id as ref_drug_formula_id
        FROM tb_planting_week_detail
        INNER JOIN tb_drug_formula ON tb_drug_formula.drug_formula_id = tb_planting_week_detail.ref_drug_formula_id
        WHERE tb_planting_week_detail.ref_drug_formula_id = '$id' AND tb_planting_week_detail.week_detail_status = 'ปกติ'
        GROUP BY tb_planting_week_detail.ref_drug_formula_id";
        $res = mysqli_query($conn, $sql2);
        if ($rows2 = $res->num_rows > 0) {
            $dis3 = "disabled";
        } else {
            $dis3 = "";
        } */


        $sql3 = "SELECT * FROM tb_drug 
        WHERE drug_id = '$drug_id'
        ORDER BY drug_id ASC";

        $res2 = mysqli_query($conn, $sql3);
        $rows3 = mysqli_fetch_assoc($res2);
        $drug_amount = $rows3['drug_amount'];

        $total_amount_gram = $drug_amount * 1000;
        $total = $total_amount_gram * $formula_detail_amount;
        $totals = $total / 1000;
        if ($totals == "0") {
            $totals = "0";
        } else {
            $totals = $totals;
        }



        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['ref_drug_id'];
        $subdata[] = $row['drug_typename'];
        $subdata[] = $row['group_drug_name'];
        $subdata[] = $row['drug_name'] . " (" . $row['drug_unit_name'] . ")" . " " . "(" . $drug_amount . " " . $unit . ")";
        $subdata[] = number_format($row['detail_amount'], 1) . " (" . $row['drug_unit_name'] . ")";
        $subdata[] = number_format($drug_formula_detail_amount_sm,1) . " " . "(" . $unit . ")";
        $subdata[] = number_format($row['drug_formula_detail_price'], 2);
        $subdata[] = $row['status'];

        if ($row['drug_formula_status'] == "ระงับ") {
            $dis = "disabled";
        } else {
            $dis = "";
        }

        //$dt_re_id=$equ_id = str_replace('-', '', $equ_id);


        if ($row['status'] == 'ปกติ') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "";
            $modal = "modal";
        } else if ($row['status'] == 'ระงับ') {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $disabled = "disabled";
            $modal = "";
        }
        $subdata[] = '<a>
        <button type="button" class="btn btn-warning btn-sm" id="btn_edit_formula_detail" data="' . $row['detail_id'] . '" data-unit ="' . $drug_unit_name . '" data-smunit ="' . $unit . '"
            data-formulaid ="' . $drug_formula_id . '" data-toggle="tooltip"  title="แก้ไขข้อมูล" ' . $disabled . '>
            <i class="fas fa-edit" style="color:white"></i></button></a>' . '
            
        <button type="button" class="' . $color . '"id="btn_remove_detail" data="' . $row['detail_id'] . '"data-status="' . $row['status'] . '"  data-name="' . $row['drug_name'] . '" 
            data-toggle="tooltip"  title="' . $txt . '" ' . $dis . ' >
            <i  class="' . $image . '" style="color:white"></i></button>';
        $rows[] = $subdata;

        $i++;
    }
    $json_data = array(
        /*   "draw" => intval($request['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFilter), */
        "data" => $rows,
    );
    echo json_encode($json_data);
} else {
    $json_data = array(
        /* "draw" => intval($request['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFilter), */
        "data" => $rows,
    );
    echo json_encode($json_data);
}
