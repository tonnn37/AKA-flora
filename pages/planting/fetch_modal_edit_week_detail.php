<?php

require 'connect.php';
$id = $_POST['id'];

date_default_timezone_set("Asia/Bangkok");
$datenow = date("Y-m-d");

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
,tb_drug_formula.drug_formula_id as drug_formula_id
,tb_drug_formula.drug_formula_name as drug_formula_name
,tb_drug_formula.drug_formula_amount as drug_formula_amount
,tb_material.material_name as material_name
,tb_drug_unit.drug_unit_name as drug_unit_name

,tb_material.material_amount as m_amount
,tb_material.material_price as m_price

FROM tb_planting_week_detail
LEFT JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
LEFT JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
LEFT JOIN tb_drug_formula ON tb_drug_formula.drug_formula_id = tb_planting_week_detail.ref_drug_formula_id
LEFT JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
LEFT JOIN tb_type_material ON tb_type_material.type_material_id = tb_material.ref_type_material
LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_material.ref_drug_unit
WHERE tb_planting_week_detail.week_detail_id ='$id' 
ORDER BY tb_planting_week_detail.ref_planting_week_id ASC";



$result = mysqli_query($conn, $query);

$output = '';
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        $week_detail_id = $row['week_detail_id'];

        $ref_drug_formula_id = $row['ref_drug_formula_id'];
        $drug_formula_id = $row['drug_formula_id'];
        $drug_formula_amount = $row['drug_formula_amount'];
        $formula_amount = $row['formula_amount'];
        $formula_price = $row['formula_price'];

        $ref_material_id = $row['ref_material_id'];
        $material_amount = $row['material_amount'];
        $material_price = $row['material_price'];

        $week_detail_dead = $row['week_detail_dead'];
        $week_detail_date = $row['week_detail_date'];

        $unit_names = $row['drug_unit_name'];
        $drug_formula_name = $row['drug_formula_name'];

        $material_name = $row['material_name'];
        $m_amount = $row['m_amount'];
        $m_price = $row['m_price'];

        $sql_count = "SELECT SUM(tb_drug_formula_detail.drug_formula_detail_price) as count FROM tb_drug_formula_detail WHERE tb_drug_formula_detail.ref_drug_formula='$ref_drug_formula_id' AND tb_drug_formula_detail.drug_formula_detail_status ='ปกติ'   ";
        $re_count = mysqli_query($conn, $sql_count);
        $r_count = mysqli_fetch_assoc($re_count);
        $sum_price = $r_count['count'];

        $sum_price = round($sum_price);
        $sum_price =  number_format($sum_price, 2, '.', '');

        if ($sum_price == "") {
            $sum_price = 0;
        }
        

        if($ref_drug_formula_id == "-"){
            $formula_amount = "";
            $formula_price = "";
            $sum_price = "";
            $hidden = "hidden";
        }else{
            $formula_amount = $formula_amount;
            $formula_price = $formula_price;
            $sum_price = $sum_price;
            $hidden = "";
        }

        if($ref_material_id == "-"){
            $material_amount = "";
            $material_price = "";
            $hidden2 = "hidden";
        }else{
            $material_amount = $material_amount;
            $material_price = $material_price;
            $hidden2 = "";
        }
        
        if($material_amount == ""){
            $material_amount = 0;
        }else{
            $material_amount = $material_amount;
        }

        $cal_material_use_amount = $material_amount * $m_amount;

            $output .= '<div id="edit_planting_week_detail'. $week_detail_id.'" class="modal fade edit_planting_week_detail" role="dialog">';
            $output .='<div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขรายละเอียดในแต่ละสัปดาห์</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                    
                        <form role="form" method="post" class="edit_week_detail" action="" id="edit_week_detail">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รหัสรายการปลูก : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit2_planting_week_id" id="edit2_planting_week_id" name="edit2_planting_week_id" readonly>
                                                <input type="hidden" class="form-control edit2_week_id" id="edit2_week_id" name="edit2_week_id" readonly>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ชื่อพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit2_planting_week_name_plant" id="edit2_planting_week_name_plant" name="edit2_planting_week_name_plant" readonly>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-4" align="right">
                                            <label>สัปดาห์ที่ : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input name="edit2_planting_week_amount" class="form-control edit2_planting_week_amount" id="edit2_planting_week_amount" readonly>

                                                </input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <strong><label>สูตรยา : </label></strong>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <select name="edit2_planting_week_drug_formula" class="form-control edit2_planting_week_drug_formula" id="edit2_planting_week_drug_formula" data-id="'.$week_detail_id.'">
                                                    <option value="0">---โปรดเลือกสูตรยา---</option>';
                                                    

                                                    $sql_order = "SELECT *
                                                    FROM tb_drug_formula 
                                                    INNER JOIN tb_drug_formula_detail ON tb_drug_formula_detail.ref_drug_formula = tb_drug_formula.drug_formula_id
                                                    WHERE tb_drug_formula.drug_formula_status ='ปกติ' AND tb_drug_formula_detail.drug_formula_detail_status = 'ปกติ'
                                                    GROUP BY tb_drug_formula.drug_formula_id
                                                    ORDER BY tb_drug_formula.drug_formula_id ASC";
                                                    $re_order = mysqli_query($conn, $sql_order);
                                                    while ($re_rows = mysqli_fetch_array($re_order)) {
                                                        if ($ref_drug_formula_id == $re_rows['drug_formula_id']) {
                                                            $select1 = "selected";
                                                        }else{
                                                            $select1 = "";
                                                        }
                                                        $drug_formula_id = $re_rows['drug_formula_id'];
        
                                                        $sql_quality = "SELECT SUM(tb_drug_formula_detail.drug_formula_detail_amount_sm) as count FROM tb_drug_formula_detail WHERE tb_drug_formula_detail.ref_drug_formula='$drug_formula_id'  ";
                                                        $re_quality = mysqli_query($conn, $sql_quality);
                                                        $r_quality = mysqli_fetch_assoc($re_quality);
                                                        $sum_quality = $r_quality['count'];
                                    
                                                        if ($sum_quality == "") {
                                                            $sum_quality = 0;
                                                        }
                                                        $output .='<option  value="'.$re_rows["drug_formula_id"].'"'.$select1.'>'.$re_rows["drug_formula_name"].''." ".''."(".''.$sum_quality.''." ".''."ลิตร".''.")".'</option>';
                                               
                                                    }
                                                   
                                                $output .='</select>
                                            </div>
                                        </div>
                                        <strong><span style="color:red"> *</span></strong>

                                    </div>
                                <div class="row" id ="hidden_formula5" '.$hidden.'>
                                    <div class="col-4" align="right">
                                        <label>สูตรยา/จำนวน : </label>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit2_planting_week_formula_per_amount" id="edit2_planting_week_formula_per_amount" value="'.$drug_formula_amount.'" name="edit2_planting_week_formula_per_amount" readonly>
                                        </div>
                                    </div>
                                    <span> ต้น</span>

                                </div>
                                <div class="row" id ="hidden_formula6" '.$hidden.'>
                                    <div class="col-4" align="right">
                                        <label>ราคาสูตรยา : </label>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit2_planting_week_formula_per_price" id="edit2_planting_week_formula_per_price" value="'.$sum_price.'" name="edit2_planting_week_formula_per_price" readonly>
                                        </div>
                                    </div>
                                    <span> บาท</span>

                                </div>
                                    <div class="row" id ="hidden_formula7" '.$hidden.'>
                                        <div class="col-4" align="right">
                                            <label>ปริมาณการใช้สูตรยา : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit2_planting_week_amount_drug" id="edit2_planting_week_amount_drug" value="'.$formula_amount.'" name="edit2_planting_week_amount_drug">
                                                <span style="color:red" id="show_text_amounts">(กรณีไม่ถึง 1 ให้ใส่ 0.25, 0.5, 0.75) </span>
                                            </div>
                                        </div>
                                        <span> ลิตร</span>&nbsp; <strong><span style="color:red"> *</span></strong>

                                    </div>
                                    <div class="row" id ="hidden_formula8" '.$hidden.'>
                                        <div class="col-4" align="right">
                                            <label>ราคาสูตรยารวม : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit2_planting_week_formula_price" id="edit2_planting_week_formula_price" value="'.$formula_price.'" name="edit2_planting_week_formula_price" readonly>
                                            </div>
                                        </div>
                                        <span> บาท</span>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <strong><label>วัสดุปลูก : </label></strong>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <select name="edit2_planting_week_material" class="form-control edit2_planting_week_material" id="edit2_planting_week_material">
                                                    <option value="0">---โปรดเลือกวัสดุปลูก---</option>';
                                                  

                                                    $sql_order2 = "SELECT * FROM tb_material 
                                                    LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_material.ref_drug_unit
                                                    WHERE material_status ='ปกติ' 
                                                    ORDER BY material_name ASC";
                                                    $re_order2 = mysqli_query($conn, $sql_order2);
                                                    while ($re_row = mysqli_fetch_array($re_order2)) {
                                                        if ($ref_material_id == $re_row['material_id']) {
                                                            $select2 = "selected";
                                                        }else{
                                                            $select2 = "";
                                                        }
                                                        $unit_name = $re_row['drug_unit_name'];
                                                      $output .='<option  value="'.$re_row["material_id"].'"'.$select2.'>'.$re_row["material_name"].''." ".''. "(" . $re_row['drug_unit_name'] . ''.")". " " . "(" . $re_row['material_amount'] . " " . "กก." . ")".'</option>';
                                                
                                                    }
                                                   
                                                $output .='</select>
                                            </div>
                                        </div>
                                        <strong><span style="color:red"> *</span></strong>

                                    </div>
                                       <div class="row" id="hide_materail1" '.$hidden2.'>
                                <div class="col-4" align="right">
                                    <label>ปริมาตร/หน่วย : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control edit2_planting_week_per_amount" id="edit2_planting_week_per_amount" value="'.$m_amount.'" name="edit2_planting_week_per_amount" readonly>
                                    </div>
                                </div>
                                <span>กิโลกรัม
                                        <input type="hidden" class="form-control edit2_planting_week_per_amount_sm" id="edit2_planting_week_per_amount_sm" name="edit2_planting_week_per_amount_sm" readonly>
                             
                            </div>
                            <div class="row" id="hide_materail2" '.$hidden2.'>
                            <div class="col-4" align="right">
                                <label>ราคา/หน่วย : </label>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <input type="text" class="form-control edit2_planting_week_per_price" id="edit2_planting_week_per_price" value="'.$m_price.'" name="edit2_planting_week_per_price" readonly>
                                </div>
                            </div>
                            <span> บาท</span>

                        </div>
                                    <div class="row" id="hide_materail3" '.$hidden2.'>
                                        <div class="col-4" align="right">
                                            <label>ปริมาณการใช้วัสดุปลูก : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit2_planting_week_amount_material" id="edit2_planting_week_amount_material" value="'.$material_amount.'" name="edit2_planting_week_amount_material">
                                                <span style="color:red" id="show_text_amounts">(กรณีไม่ถึง 1 ให้ใส่ 0.25, 0.5, 0.75) </span>
                                                </div>
                                        </div>
                                        <label id ="show_unit" class ="show_unit">'.$unit_names.'</label><strong>&nbsp<span style="color:red"> *</span></strong>
                                    
                                    </div>
                                    <div class="row" id="hide_materail4" '.$hidden2.'>
                                        <div class="col-4" align="right">
                                          
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit2_planting_week_use_amount" id="edit2_planting_week_use_amount" value ="'.$cal_material_use_amount.'" name="edit2_planting_week_use_amount" readonly>
                                            </div>
                                        </div>
                                        <span> กิโลกรัม</span>

                                    </div>
                                    <div class="row" id="hide_materail5" '.$hidden2.'>
                                        <div class="col-4" align="right">
                                            <label>ราคาวัสดุปลูกรวม : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit2_planting_week_material_price" id="edit2_planting_week_material_price" value="'.$material_price.'" name="edit2_planting_week_material_price" readonly>
                                            </div>
                                        </div>
                                        <span> บาท</span>

                                    </div>

                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <strong><label>จำนวนต้นไม้ที่ตาย : </label></strong>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit2_planting_week_dead" id="edit2_planting_week_dead" value="'.$week_detail_dead.'" name="edit2_planting_week_dead">

                                            </div>
                                        </div>
                                        <span>ต้น</span>&nbsp;<strong><span style="color:red"> *</span></strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>วันที่บันทึก : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control edit2_planting_week_datenow" id="edit2_planting_week_datenow" name="edit2_planting_week_datenow" value="'.$datenow.'">
                                                <input type="date" class="form-control edit2_planting_week_date" id="edit2_planting_week_date" name="edit2_planting_week_date" value="'.$week_detail_date.'">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group" align="right">
                                <button type="button" class="btn btn-outline-success" name="btn_edit2_planting_week" id="btn_edit2_planting_week" data-id="'.$week_detail_id.'">บันทึก</button>
                            </div>
                        </div>
                        <div class="col-6" align="left">
                            <div class="form-group">
                                <button type="button" class="btn btn-outline-danger" id="cancel" data-dismiss="modal">ยกเลิก</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

    }
    echo $output;
}
