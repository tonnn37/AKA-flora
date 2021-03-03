<?php
require 'connect.php';

$id = $_POST['id'];

$query = "SELECT tb_drug_formula_detail.drug_formula_detail_id as detail_id, tb_drug_formula_detail.ref_drug_formula as ref_drug_formula, 
tb_drug_formula_detail.drug_formula_detail_amount as detail_amount , tb_drug_formula_detail.drug_formula_detail_status as status, 
tb_drug_formula_detail.ref_drug_id as ref_drug_id, 

tb_drug.drug_name as drug_name,tb_drug.drug_amount AS drug_amount , tb_drug.drug_price AS drug_price,
tb_drug_type.drug_typename AS drug_typename,
tb_group_drug.group_drug_name AS group_drug_name,
tb_drug_formula_detail.drug_formula_detail_price AS drug_formula_detail_price

FROM tb_drug_formula_detail 
LEFT JOIN tb_drug_formula ON tb_drug_formula.drug_formula_id = tb_drug_formula_detail.ref_drug_formula
LEFT JOIN tb_drug ON tb_drug.drug_id = tb_drug_formula_detail.ref_drug_id
LEFT JOIN tb_group_drug ON tb_group_drug.group_drug_id = tb_drug.ref_group_drug
LEFT JOIN tb_drug_type ON tb_drug_type.drug_typeid = tb_group_drug.ref_drug_type
LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_drug.ref_drug_unit
WHERE tb_drug_formula_detail.drug_formula_detail_id ='$id'
ORDER BY  tb_drug_formula_detail.ref_drug_id ASC";

$re_new = mysqli_query($conn, $query);

$output = '';
if ($re_new->num_rows > 0) {
    // output data of each row

    $i = 0;
    while ($row = $re_new->fetch_assoc()) {
        $id = $row['detail_id'];
        $ref_drug_formula = $row['ref_drug_formula'];
        $detail_amount = $row['detail_amount'];
        $status = $row['status'];

        $ref_drug_id = $row['ref_drug_id'];
        $drug_name = $row['drug_name'];
        $drug_amount = $row['drug_amount'];
        $drug_price = $row['drug_price'];

        $type_name = $row['drug_typename'];

        $group_name = $row['group_drug_name'];

        $formula_price = $row['drug_formula_detail_price'];

        $cal_amount = $detail_amount * $drug_amount;


        $output .= '<div id="edit_formula_detail' . $id . '" class="modal fade edit_formula_detail" role="dialog">';
        $output .=  '<div class="modal-dialog modal-lg">';

        $output .='<div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="fas fa-edit"></i>
                            แก้ไขรายละเอียดสูตรยา</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>';
        $output .='<div class="modal-body">
                        <form method="post" enctype="multipart/form-data" id="edit_detaildrug'. $id .'">
                            <div class="row">
                                <div class="col-sm-11">';
                                   $output .='<div class="row">
                                        <div class="col-4" align="right">
                                            <label>ประเภทยา : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <select name="edit_detail_type" class="form-control edit_detail_type" id="edit_detail_type">
                                                    <option value="0">----โปรดเลือกประเภทยา----</option>';
                                                 
                                                    $sql_type1 = "SELECT * FROM tb_drug_type                                                         
                                                    WHERE drug_typestatus ='ปกติ' ORDER BY drug_typename ASC";
                                                    $re_type1 = mysqli_query($conn, $sql_type1);
                                                    while ($re_fac1 = mysqli_fetch_array($re_type1)) {

                                                        if ($type_name == $re_fac1["drug_typename"]) {
                                                        $select1 = "selected";
                                                        }else{
                                                            $select1 = "";
                                                        }
                                                        $output.= '<option value="'.$re_fac1["drug_typeid"].'"'.$select1.'>'.$re_fac1["drug_typename"].'</option>';
                                                 
                                                    }
                                                
                                                $output .='</select>
                                            </div>
                                        </div>
                                        <span style="color:red" class=red_firstname> *</span>
                                    </div>';
                                    $output .= '<div class="row">
                                        <div class="col-4" align="right">
                                            <label>กลุ่มยา : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <select class="form-control edit_detail_group" id="edit_detail_group" name="edit_detail_group" >
                                                    <option value="0">----โปรดเลือกกลุ่มยา----</option>';

                                                    $sql_type2 = "SELECT * FROM tb_group_drug WHERE group_drug_status ='ปกติ' ORDER BY group_drug_id ASC";
                                                    $re_type2 = mysqli_query($conn, $sql_type2);
                                                    while ($re_fac2 = mysqli_fetch_array($re_type2)) {
                                                        if ($group_name == $re_fac2['group_drug_name']) {
                                                            $select2 = "selected";
                                                        }else{
                                                            $select2 = "";
                                                        }
                                                        $output .='<option value="'.$re_fac2["group_drug_id"].'"'.$select2.'> '.$re_fac2["group_drug_name"].'</option>';
                                                 
                                                    }
                                                   

                                                $output .='</select>
                                            </div>
                                        </div>
                                        <span style="color:red" class=red_firstname> *</span>
                                    </div>';
                                    $output .='<div class="row">
                                        <div class="col-4" align="right">
                                            <label>ชื่อยา : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <select name="edit_detail_drug" class="form-control edit_detail_drug" id="edit_detail_drug">
                                                    <option value="0">----โปรดเลือกยา----</option>';
                                                   
                                                    $sql_drug = "SELECT * FROM tb_drug 
                                                         LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_drug.ref_drug_unit
                                                    WHERE drug_status ='ปกติ' ORDER BY drug_id ASC";
                                                    $re_drug = mysqli_query($conn, $sql_drug);

                                                    
                                                    while ($re_fac3 = mysqli_fetch_array($re_drug)) {
                                                        $unit_name = $re_fac3['drug_unit_name'];
        
                                                        if($unit_name =="ขวด" || $unit_name =="แกลลอน"){
                                                
                                                            $unit =  "ลิตร";
                                                
                                                        }else if($unit_name =="ถุง" || $unit_name =="กระสอบ"){
                                                
                                                            $unit = "กิโลกรัม";
                                                        }else {
                                                            
                                                            $unit =  "กิโลกรัม";
                                                        }

                                                        if ($drug_name == $re_fac3['drug_name']) {

                                                            $select3 = "selected";
                                                        }else {
                                                            $select3 = "";
                                                        }
                                                        $output .='<option value="'.$re_fac3["drug_id"].'"'.$select3.'>'.$re_fac3["drug_name"].' '."(".''.$re_fac3["drug_unit_name"].''.")".' '."(".''.$re_fac3["drug_amount"].' '.$unit.''.")".'</option>';
                                                   
                                                    }
                                                   
                                               $output .= '</select>
                                            </div>
                                        </div>
                                        <span style="color:red" class=red_firstname> *</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รหัสยา : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" id="edit_drug_formula_id" name="edit_drug_formula_id" value="'.$ref_drug_formula .'">
                                                <input type="text" class="form-control" id="edit_detail_id" name="edit_detail_id" value="'. $ref_drug_id.'" readonly>
                                            </div>
                                        </div>
                                        <span style="color:red"> *</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ปริมาตร/หน่วย : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit_peramount" id="edit_peramount" name="edit_peramount" value="'.$drug_amount .'"readonly>
                                            </div>
                                        </div>
                                        <label id ="show_edit_unit1"> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ราคา/หน่วย : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input name="edit_perprice" class="form-control edit_perprice" id="edit_perprice" value="'. $drug_price .'" readonly>
                                            </div>
                                        </div>
                                        <span> บาท</span>
                                    </div>';
                                    $output .='<div class="row">
                                        <div class="col-4" align="right">
                                            <label>ปริมาณการใช้ยา : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit_detail_amount" id="edit_detail_amount" name="edit_detail_amount" value="'.$detail_amount .'">
                                                <span style="color:red" id="show_text_amount">(กรณีไม่ถึง 1 ให้ใส่ 0.25, 0.5, 0.75) </span>
                                                </div>
                                        </div>
                                        <label id ="show_edit_unit2"></label>'." ".'<span style="color:red"> *</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                          
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit_use_amount" id="edit_use_amount" name="edit_use_amount" value="'.$cal_amount .'" readonly>
                                             
                                                </div>
                                        </div>
                                        <label id ="show_edit_unit3"></label>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ราคาการใช้ยา : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input name="edit_formula_price" class="form-control edit_formula_price" id="edit_formula_price" value="'. $formula_price .'" readonly>
                                            </div>
                                        </div>
                                        <span> บาท</span>
                                    </div><br>
                                </div>
                                <div class="col-6">
                                    <div class="form-group" align="right">
                                        <button type="button" class="btn btn-outline-success" name="btn_detail_formula" id="btn_detail_formula" >บันทึก</button>
                                    </div>
                                </div>
                                <div class="col-6" align="left">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">ยกเลิก</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>';
    }
    echo $output;

}else{

}

?>