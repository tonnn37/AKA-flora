<?php
//fetch.php
require 'connect.php';
$output = '';
$query = "";

$query = "SELECT tb_drug_formula.drug_formula_id as drug_formula_id, tb_drug_formula.drug_formula_name as drug_formula_name,
tb_drug_formula.drug_formula_status as drug_formula_status 
,tb_drug_formula.drug_formula_amount as drug_formula_amount

FROM tb_drug_formula
ORDER BY drug_formula_id ASC";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $drug_formula_id = $row['drug_formula_id'];
        $drug_formula_amount = $row['drug_formula_amount'];

          $sql_count = "SELECT SUM(tb_drug_formula_detail.drug_formula_detail_price) as count FROM tb_drug_formula_detail WHERE tb_drug_formula_detail.ref_drug_formula='$drug_formula_id' AND tb_drug_formula_detail.drug_formula_detail_status ='ปกติ'   ";
        $re_count = mysqli_query($conn, $sql_count);
        $r_count = mysqli_fetch_assoc($re_count);
        $sum_amount = $r_count['count'];

        $sum_amount = round($sum_amount);
        $sum_amount =  number_format($sum_amount, 2, '.', '');

        if ($sum_amount == "") {
            $sum_amount = 0;
        }

        $sql_quality = "SELECT SUM(tb_drug_formula_detail.drug_formula_detail_amount_sm) as count FROM tb_drug_formula_detail WHERE tb_drug_formula_detail.ref_drug_formula='$drug_formula_id'  AND tb_drug_formula_detail.drug_formula_detail_status ='ปกติ' ";
        $re_quality = mysqli_query($conn, $sql_quality);
        $r_quality = mysqli_fetch_assoc($re_quality);
        $sum_quality = $r_quality['count'];

        if ($sum_quality == "") {
            $sum_quality = 0;
        }


/* 
        $sql2 = "SELECT tb_planting_week_detail.ref_drug_formula_id as ref_drug_formula_id
                    FROM tb_planting_week_detail
                    INNER JOIN tb_drug_formula ON tb_drug_formula.drug_formula_id = tb_planting_week_detail.ref_drug_formula_id
                    WHERE tb_planting_week_detail.ref_drug_formula_id = '$drug_formula_id' AND tb_planting_week_detail.week_detail_status = 'ปกติ'
                    GROUP BY tb_planting_week_detail.ref_drug_formula_id";
        $res = mysqli_query($conn, $sql2);
        if ($rows2 = $res->num_rows > 0) {
            $dis = "disabled";
        } else {
            $dis = "";
        } */

        $drug_formula_name = $row['drug_formula_name'];
        $drug_formula_status = $row['drug_formula_status'];

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $drug_formula_id;
        $subdata[] = $drug_formula_name;
        $subdata[] = number_format($drug_formula_amount);
        $subdata[] = number_format($sum_quality,1);
        $subdata[] = number_format($sum_amount, 2);
        $subdata[] = $drug_formula_status;



        if ($drug_formula_status == 'ปกติ') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "";
            $edit = "edit";
        } else if ($drug_formula_status == 'ระงับ') {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $disabled = "disabled";
            $edit = "";
        }
        
        $subdata[] = '
        <a href="#'.$edit.''.$drug_formula_id.'" data-toggle="modal">
        <button type="button" class="btn btn-warning btn-sm edit_formula" '.$disabled.' id="edit_formula" data-toggle="tooltip" title="แก้ไขข้อมูล" data-id="'.$drug_formula_id.'">
        <i class="fas fa-edit" style="color:white;"></i></button>
        </a>' . '
        <a href="#view_dialog" data-toggle="modal" class="">
        <button type="button" class="btn btn-info btn-sm" title="แสดงรายละเอียด" id="btn_viewdialog" data-id="'.$drug_formula_id.'" 
        data-name="'.$drug_formula_name.'" data-toggle="tooltip">
        <i class="fas fa-list-ol" style="color:black"></i></button>
        </a>' . '

        <button type="button" id="btn_remove_formula" class="'.$color.'"   data-toggle="tooltip" title="'.$txt.'" data-id="'.$drug_formula_id.'" 
        data-status="'.$drug_formula_status.'" data-name="'.$drug_formula_name.'">
        <i class="'.$image.'" style="color:white"></i></button>';

        $rows[] = $subdata;

        $i++;
    }
    $json_data = array(

        "data" => $rows,
    );
    echo json_encode($json_data);
} else {
    $json_data = array(

        "data" => $rows,
    );
    echo json_encode($json_data);
}
