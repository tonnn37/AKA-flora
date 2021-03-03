<?php

require 'connect.php';
$id = $_POST['id'];

date_default_timezone_set("Asia/Bangkok");
$datenow = date("Y-m-d");

$sql = "SELECT tb_planting_week.planting_week_id as planting_week_id
           
,tb_planting_week.planting_week_status as planting_week_status
,tb_planting_week.planting_week_count as planting_week_count
,tb_planting_week.ref_planting_detail_id as ref_planting_detail_id
,tb_planting_week.planting_week_date as planting_week_date

,tb_plant.plant_name as plant_name
,tb_planting_detail.planting_detail_amount as planting_detail_amount
,tb_planting_detail.planting_detail_enddate as planting_detail_enddate


FROM tb_planting_week
LEFT JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
LEFT JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
WHERE tb_planting_week.planting_week_id ='$id' AND tb_planting_week.planting_week_status !='ระงับ' 
GROUP BY tb_planting_week.planting_week_id
ORDER BY tb_planting_week.planting_week_id ASC";

$result = mysqli_query($conn, $sql);
$output ='';
if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {

        $i++;

        $planting_detail_id = $row['ref_planting_detail_id'];
        $planting_week_id = $row['planting_week_id'];
        $plant_name  = $row['plant_name'];


$output .= '<div id="add_week_detail'. $planting_week_id.'" class="modal fade add_week_detail" role="dialog">';
            $output .='<div class="modal-dialog modal-lg">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลเพิ่มเติมในแต่ละสัปดาห์</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="post" action="" id="in_planting_week_detail2" class="in_planting_week_detail2">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รหัสรายการปลูก : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="in2_planting_week_id" name="in2_planting_week_id" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ชื่อพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="in2_planting_week_name_plant" name="in2_planting_week_name_plant" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>สัปดาห์ที่ : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input name="in2_planting_week_amount" class="form-control" id="in2_planting_week_amount" readonly>
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
                                                <select name="in2_planting_week_drug_formula" class="form-control in2_planting_week_drug_formula" id="in2_planting_week_drug_formula">
                                                    <option value="0">---โปรดเลือกสูตรยา---</option>';
                                          
                                                    $sql_order = "SELECT * FROM tb_drug_formula WHERE drug_formula_status ='ปกติ' ORDER BY drug_formula_id ASC";
                                                    $re_order = mysqli_query($conn, $sql_order);
                                                    while ($re_rows = mysqli_fetch_array($re_order)) {
                                                        $drug_formula_id = $re_rows['drug_formula_id'];
        
                                                        $sql_quality = "SELECT SUM(tb_drug_formula_detail.drug_formula_detail_amount_sm) as count FROM tb_drug_formula_detail WHERE tb_drug_formula_detail.ref_drug_formula='$drug_formula_id'  ";
                                                        $re_quality = mysqli_query($conn, $sql_quality);
                                                        $r_quality = mysqli_fetch_assoc($re_quality);
                                                        $sum_quality = $r_quality['count'];
                                    
                                                        if ($sum_quality == "") {
                                                            $sum_quality = 0;
                                                        }
                                          
                                                        $output .='<option  value="'.$re_rows["drug_formula_id"].'">'.$re_rows["drug_formula_name"].''." ".''."(".''.$sum_quality.''." ".''."ลิตร".''.")".'</option>';
                                             
                                                    }
                                                
                                                $output .='</select>
                                            </div>
                                        </div>
                                        <strong><span style="color:red"> *</span></strong>
                                    </div>
                                    <div class="row" id ="hidden_formula5" hidden>
                                        <div class="col-4" align="right">
                                            <label>สูตรยา/จำนวน : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control in2_planting_week_formula_amount" id="in2_planting_week_formula_amount" name="in2_planting_week_formula_amount" readonly>
                                            </div>
                                        </div>
                                        <span> ต้น</span>
                                    </div>
                                    <div class="row" id ="hidden_formula6" hidden>
                                        <div class="col-4" align="right">
                                            <label>ราคาสูตรยา : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control in2_planting_week_formula_price" id="in2_planting_week_formula_price" name="in2_planting_week_formula_price" readonly>
                                            </div>
                                        </div>
                                        <span> บาท</span>
                                    </div>
                                    <div class="row" id ="hidden_formula7" hidden>
                                        <div class="col-4" align="right">
                                            <label>ปริมาณการใช้สูตรยา : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control in2_planting_week_amount_formula" id="in2_planting_week_amount_formula" name="in2_planting_week_amount_formula">
                                                <span style="color:red" id="show_text_amounts">(กรณีไม่ถึง 1 ให้ใส่ 0.25, 0.5, 0.75) </span>
                                                </div>
                                        </div>
                                        <label >ลิตร</label>&nbsp<strong><span style="color:red"> *</span></strong>
                                    </div>
                                    <div class="row" id ="hidden_formula8" hidden>
                                        <div class="col-4" align="right">
                                            <label>ราคาสูตรยารวม : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control in2_planting_week_formula_total_price" id="in2_planting_week_formula_total_price" name="in2_planting_week_formula_total_price" readonly>
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
                                                <select name="in2_planting_week_material" class="form-control in2_planting_week_material" id="in2_planting_week_material">
                                                    <option value="0">---โปรดเลือกวัสดุปลูก---</option>';
                                            
                                                    $sql_order = "SELECT * FROM tb_material 
                                                    LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_material.ref_drug_unit
                                                    WHERE material_status ='ปกติ' 
                                                    ORDER BY material_name ASC";
                                                    $re_order = mysqli_query($conn, $sql_order);
                                                    while ($re_row = mysqli_fetch_array($re_order)) {
                                                        $unit_name = $re_row['drug_unit_name'];
                                                        $output .='<option  value="'.$re_row["material_id"].'">'.$re_row["material_name"].''." ".''. "(" . $re_row['drug_unit_name'] . ''.")". " " . "(" . $re_row['material_amount'] . " " . "กก." . ")".'</option>';
                                                 
                                                    }
                                               
                                                $output .='</select>
                                            </div>
                                        </div>
                                        <strong><span style="color:red"> *</span></strong>
                                    </div>
                                    <div class="row" id ="hidden_material10" hidden>
                                        <div class="col-4" align="right">
                                            <label>ปริมาตร/หน่วย : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control in2_planting_week_material_per_amount" id="in2_planting_week_material_per_amount" name="in2_planting_week_material_per_amount" readonly>
                                            </div>
                                        </div>
                                        <span> กิโลกรัม</span>
                                    </div>
                                    <div class="row" id ="hidden_material11" hidden>
                                        <div class="col-4" align="right">
                                            <label>ราคา/หน่วย : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control in2_planting_week_material_per_price" id="in2_planting_week_material_per_price" name="in2_planting_week_material_per_price" readonly>
                                            </div>
                                        </div>
                                        <span> บาท</span>
                                    </div>
                                    <div class="row" id ="hidden_material12" hidden>
                                        <div class="col-4" align="right">
                                            <label>ปริมาณการใช้วัสดุปลูก : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control in2_planting_week_amount_material" id="in2_planting_week_amount_material" name="in2_planting_week_amount_material">
                                            </div>
                                        </div>
                                        <label id ="show_unit_add"></label>&nbsp<strong><span style="color:red"> *</span></strong>                                       
                                    </div>
                                    <div class="row" id ="hidden_material13" hidden>
                                    <div class="col-4" align="right">
                            
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input type="text" class="form-control in2_planting_week_material_use_amount_sm" id="in2_planting_week_material_use_amount_sm" name="in2_planting_week_material_use_amount_sm" readonly>
                                        </div>
                                    </div>
                                   <span>กิโลกรัม</span>                                   
                                </div>
                                    <div class="row" id ="hidden_material14" hidden>
                                        <div class="col-4" align="right">
                                            <label>ราคาวัสดุปลูกรวม : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control in2_planting_week_material_price" id="in2_planting_week_material_price" name="in2_planting_week_material_price" readonly>
                                            </div>
                                        </div>
                                        <span> บาท</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>จำนวนต้นไม้ที่ตาย : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control in2_planting_week_dead" id="in2_planting_week_dead" name="in2_planting_week_dead">
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
                                                <input type="hidden" class="form-control" id="in2_planting_week_datenow" name="in2_planting_week_datenow" value="'.$datenow.'">
                                                <input type="date" class="form-control in2_planting_week_date" id="in2_planting_week_date" name="in2_planting_week_date" value="'.$datenow.'">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group" align="right">
                                <button type="button" class="btn btn-outline-success" name="btn_add2_planting_week" id="btn_add2_planting_week" data-id="'.$planting_week_id.'">บันทึก</button>
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
            </form>
        </div>';
    } 
    echo $output;
}
