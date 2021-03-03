<?php
include('connect.php');
//--- รันรหัสยา ---//
date_default_timezone_set("Asia/Bangkok");
$sql_group = "SELECT Max(drug_id) as maxid FROM tb_drug";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "DRU"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp2 = substr($mem_old, 5, 6);
$Year = substr($mem_old, 3, 2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp2 = 0;
    //  $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;
$a = sprintf("%03d", $t);
$run_drug_id = $tmp1 . $sub_date . $a;

@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];

?>


<input type="hidden" id="per" value='<?php echo $permiss ?>'>


<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="myFunction()"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลยา</button>
    </div>
</div><br>




<!--- เริ่ม modal เพิ่มข้อมูลยา--->
<div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="drug">
    <div class="modal-dialog modal-lgg">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลยา</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" class="insert" id="myDrug">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รหัสยา : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="drugid" name="drugid" value="<?= $run_drug_id ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ประเภทยา : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <select name="typedrug" class="form-control" id="typedrug">
                                            <option value="0">----โปรดเลือกประเภทยา----</option>
                                            <?php
                                            $sql_type1 = "SELECT * FROM tb_drug_type                               
                                            WHERE drug_typestatus ='ปกติ' 
                                            ORDER BY drug_typename ASC";
                                            $re_type1 = mysqli_query($conn, $sql_type1);
                                            while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                            ?>
                                                <option value="<?php echo $re_fac1["drug_typeid"]; ?>">
                                                    <?php echo $re_fac1["drug_typename"];  ?>
                                                </option>
                                            <?php
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>กลุ่มยา : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <select name="drugunit" class="form-control" id="drugunit">
                                            <option value="0">----โปรดเลือกกลุ่มยา----</option>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>
                            <!--  <div class="row">
                                <div class="col-4" align="right">
                                    <label>บรรจุภัณฑ์ : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <select name="unit" class="form-control" id="unit">
                                            <option value="0">----โปรดเลือกบรรจุภัณฑ์----</option>
                                            <?php
                                            $sql_type1 = "SELECT * FROM tb_drug_unit 
                                            WHERE drug_unit_status = 'ปกติ'
                                            ORDER BY drug_unit_name ASC";
                                            $re_type1 = mysqli_query($conn, $sql_type1);
                                            while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                            ?>
                                                <option value="<?php echo $re_fac1["drug_unit_id"]; ?>">
                                                    <?php echo $re_fac1["drug_unit_name"];  ?>
                                                </option>
                                            <?php
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ชื่อยา : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control drugname" id="drugname" name="drugname" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="fileinput fileinput-new text-center a" data-provides="fileinput" align="center">
                                <div style="cursor:pointer;">
                                    <img src="image/upload.png" alt="..." id="add_picture_img" align="center" style="object-fit: fill; border-radius: 8px;" width="200" height="200"><br><br>
                                    <input type="file" style="display:none" name="add_picture" id="add_picture" accept="image/*"></input>
                                    <span>(เลือกไฟล์รูปภาพ) </span>
                                </div>
                            </div>

                        </div>


                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>หน่วย : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <select name="unit" class="form-control" id="unit">
                                            <option value="0">----โปรดเลือกหน่วย----</option>
                                            <?php
                                            $sql_type1 = "SELECT * FROM tb_drug_unit 
                                            WHERE drug_unit_status = 'ปกติ'
                                            ORDER BY drug_unit_name ASC";
                                            $re_type1 = mysqli_query($conn, $sql_type1);
                                            while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                            ?>
                                                <option value="<?php echo $re_fac1["drug_unit_id"]; ?>">
                                                    <?php echo $re_fac1["drug_unit_name"];  ?>
                                                </option>
                                            <?php
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ปริมาตร/หน่วย : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control drugamounts " id="drugamount" name="drugamount" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <span><label id="show_formula_small_unit"></label><!-- <br>&nbsp;หรือ :  --></span>
                                &nbsp;<strong><span style="color:red" class=red_firstname> *</span> </strong>

                                <input type="hidden" class="form-control formula_small_unit" id="formula_small_unit" name="formula_small_unit" readonly>

                                <!--    <label id="show_formula_small_unit"></label> -->

                            </div>

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ราคา/หน่วย: </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" name="drug_price" class="form-control drug_price" id="drug_price" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <span> บาท</span>
                                &nbsp;<strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>
                            <!--   <div class="row">
                                <div class="col-4" align="right">
                                    <label>ราคา/<label>กรัม :</label> </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input name="total_price" class="form-control" id="total_price" readonly>
                                    </div>
                                </div>
                                <span> บาท</span>
                               
                            </div>
 -->
                            <!--  <div class="row">
                                <div class="col-4" align="right">
                                    <label>จำนวน : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control drugamount" id="drugamount" name="drugamount" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div> -->



                            <!--  <div class="row">
                                <div class="col-4" align="right">
                                    <label>หน่วย : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input name="add_drugsmunit" class="form-control" id="add_drugsmunit" readonly>
                                    </div>
                                </div>
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div> -->
                            <!--     <div class="row">
                                <div class="col-4" align="right">
                                    <label>ราคา : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control drugprice" id="drugprice" name="drugprice" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <span> บาท</span>&nbsp;
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div> -->
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รายละเอียดเพิ่มเติม : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <textarea class="form-control " id="drugdetail" rows="5" name="drugdetail" placeholder="กรุณากรอกข้อมูล"></textarea>
                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>

            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group" align="right">
                        <button type="submit" class="btn btn-outline-success" name="btn_add_drug" id="btn_add_drug">บันทึก</button>
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
</div>


<!-- แสดงข้อมูลในตาราง -->
<div class="row">
    <div class="col-12">
        <table class="table-bordered text-center" id="drugTable" width="100%">
            <thead bgcolor="#2dce89" style="text-align: center;">
                <th>ลำดับ</th>
                <th>รหัสยา</th>
                <th>ประเภทยา</th>
                <th>กลุ่มยา</th>
                <th>ชื่อยา</th>
                <th>จำนวน <br>(กิโลกรัม/ลิตร)</th>
                <th>ราคา (บาท)</th>
                <th>สถานะ</th>
                <th width ="120"></th>

            </thead>
            <?php
            $sql = "SELECT tb_drug.drug_id AS drug_id,
                        tb_drug.drug_name as drug_name,
                        tb_drug_type.drug_typename as type_name,
                        tb_drug_type.drug_typeid AS drug_type_id,
                        tb_group_drug.group_drug_name as group_name,
                        tb_group_drug.group_drug_id as group_drug_id,
                        tb_drug.drug_amount AS drug_amount,
                        tb_drug.drug_price AS drug_price,
                        tb_drug.drug_status as drug_status,
                        tb_drug.picture as pic, 
                        tb_drug.drug_detail AS drug_detail,
                        tb_drug_unit.drug_unit_name as drug_unit_name,
                        tb_drug_unit.drug_unit_id as drug_unit_id
                
                        
                        FROM tb_drug
                        LEFT JOIN tb_group_drug ON tb_group_drug.group_drug_id = tb_drug.ref_group_drug
                        LEFT JOIN tb_drug_type ON tb_drug_type.drug_typeid = tb_group_drug.ref_drug_type
                        LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_drug.ref_drug_unit
                        ORDER BY tb_drug.drug_id ASC";

            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $i++;
                    $drug_id = $row['drug_id'];
                    $drug_name = $row['drug_name'];


                    $drug_amount = $row['drug_amount'];
                    $drug_price = $row['drug_price'];
                    $drug_status = $row['drug_status'];
                    $drug_detail = $row['drug_detail'];
                    $picture = $row['pic'];


                    $drug_type_id = $row['drug_type_id'];
                    $type_name = $row['type_name'];

                    $group_drug_id = $row['group_drug_id'];
                    $group_name = $row['group_name'];
                    $drug_unit_id = $row['drug_unit_id'];
                    $drug_unit_name = $row['drug_unit_name'];


                    $sql2 = "SELECT * FROM tb_drug_formula_detail 
                    INNER JOIN tb_drug_formula ON tb_drug_formula.drug_formula_id = tb_drug_formula_detail.ref_drug_formula
                    INNER JOIN tb_drug ON tb_drug.drug_id = tb_drug_formula_detail.ref_drug_id
                    WHERE tb_drug_formula_detail.drug_formula_detail_status ='ปกติ' AND tb_drug_formula.drug_formula_status ='ปกติ'
                    AND tb_drug_formula_detail.ref_drug_id = '$drug_id'";
                    $res = mysqli_query($conn, $sql2);
                    if ($rows = $res->num_rows > 0) {
                        $dis = "disabled";
                    } else {
                        $dis = "";
                    }



            ?>
                    <tr onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)" style="text-align: center;">
                        <td><?php echo $i; ?></td>
                        <td class="emp_id">
                            <?php echo $drug_id; ?>
                        </td>
                        <td>
                            <?php echo $type_name ?>
                        </td>
                        <td>
                            <?php echo $group_name; ?>
                        </td>
                        <td class="emp_id">
                            <?php echo $drug_name . " " . "(" . $drug_unit_name . ")"; ?>
                        </td>
                        <td>
                            <?php echo  number_format($drug_amount, 1) ?>
                        </td>
                        <td>
                            <?php echo  number_format($drug_price, 2) ?>
                        </td>
                        <td <?php if ($drug_status == 'ระงับ') {
                                echo 'style="color:red"';
                            } ?>>
                            <?php echo $drug_status; ?>
                        </td>

                        <?php
                        if ($drug_status == 'ปกติ') {
                            $image = 'fas fa-times';
                            $color = "btn btn-danger  btn-sm";
                            $txt = "ยกเลิกข้อมูล";
                            $disabled = "";
                            $edit = "edit";
                        } else if ($drug_status == 'ระงับ') {
                            $image = 'fas fa-check';
                            $color = "btn btn-success btn-sm";
                            $txt = "ยกเลิกการระงับ";
                            $disabled = "disabled";
                            $edit = "";
                        }
                        ?>
                        <td style="text-align: center;">

                            <a href="#view<?php echo $drug_id; ?>" data-toggle="modal">
                                <button type='button' class='btn btn-sm views' id="view_drugs" style="background-color:#FFCC00;" data-toggle="tooltip" title="แสดงข้อมูล" data="<?= $drug_unit_id ?>" data-id="<?= $drug_id ?>"><i class="fas fa-search-plus"></i></button>
                            </a>
                            <a href="#<?php echo $edit?><?php echo $drug_id; ?>" data-toggle="modal">
                                <button type='button' class='btn btn-warning btn-sm edit_drug' <?php echo $disabled; ?> id="edit_drug<?= $drug_id ?>" data-toggle="tooltip" title="แก้ไขข้อมูล" data="<?= $drug_id ?>"><i class="fas fa-edit" style="color:white;"></i></button>
                            </a>

                            <button type='button' id="btn_remove_drug" class='<?= $color ?>' <?php echo $dis; ?> data-toggle="tooltip" title="<?= $txt ?>" data-id="<?= $drug_id ?>" data-status="<?= $drug_status ?>" data-name="<?= $drug_name ?>" <?php if ($permiss == 'พนักงาน') {
                                                                                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                                                                                        } ?>><i class="<?= $image ?>" style="color:white"></i></span></button>
                        </td>

                        <!--- เริ่ม modal แก้ไข --->
                        <div id="edit<?php echo $drug_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lgg">
                                <div class="modal-content" style="width: auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขข้อมูลยา</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                            <h3>&times;</h3>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" class="Update" role="form" data='<?= $drug_id ?>' id="edit_drugs<?= $drug_id ?>" enctype="multipart/form-data">
                                            <div class="row">
                                                <input type="hidden" name="edit_item_id" id="edit_item_id" value="<?php echo $drug_id; ?>">
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รหัสยา : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="edit_drugid<?= $drug_id ?>" name="edit_drugid" value="<?= $drug_id ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ประเภทยา : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <select name="edit_typedrug" class="form-control edit_typedrug" id="edit_typedrug<?= $drug_id ?>" data-id="<?= $drug_id ?>">
                                                                    <option value="0">----โปรดเลือกประเภทยา----</option>
                                                                    <?php
                                                                    $sql_type1 = "SELECT * FROM tb_drug_type                                                   
                                                                    WHERE drug_typestatus ='ปกติ' ORDER BY drug_typename ASC";
                                                                    $re_type1 = mysqli_query($conn, $sql_type1);
                                                                    while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                                                    ?>
                                                                        <option <?php if ($drug_type_id == $re_fac1['drug_typeid']) {
                                                                                    echo "selected";
                                                                                } ?> value="<?php echo $re_fac1["drug_typeid"]; ?>">
                                                                            <?php echo $re_fac1["drug_typename"];  ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>กลุ่มยา : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <select class="form-control edit_drugunit" id="edit_drugunit<?= $drug_id ?>" name="edit_drugunit" data-id="<?= $drug_id ?>">
                                                                    <option value="0">----โปรดเลือกกลุ่มยา----</option>
                                                                    <?php
                                                                    $sql_group = "SELECT * FROM tb_group_drug WHERE group_drug_status ='ปกติ' ORDER BY group_drug_id ASC";
                                                                    $re_group = mysqli_query($conn, $sql_group);
                                                                    while ($re_facgroup = mysqli_fetch_array($re_group)) {
                                                                    ?>
                                                                        <option <?php if ($group_drug_id == $re_facgroup['group_drug_id']) {
                                                                                    echo "selected";
                                                                                } ?> value="<?php echo $re_facgroup["group_drug_id"]; ?>">
                                                                            <?php echo $re_facgroup["group_drug_name"];  ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ชื่อยา : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control edit_drugname" id="edit_drugname<?= $drug_id ?>" data-id="<?= $drug_id ?>" name="edit_drugname" value="<?= $drug_name ?>">

                                                            </div>
                                                        </div>
                                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">

                                                                <select class="form-control edit_drugsmunit" id="edit_drugsmunit<?= $drug_id ?>" name="edit_drugsmunit" data-id="<?= $drug_id ?>">
                                                                    <option value="0">----โปรดเลือกหน่วย----</option>
                                                                    <?php
                                                                    $sql_group2 = "SELECT * FROM `tb_drug_unit` WHERE drug_unit_status ='ปกติ' ORDER BY `drug_unit_name` ASC";
                                                                    $re_group2 = mysqli_query($conn, $sql_group2);
                                                                    while ($re_facgroup2 = mysqli_fetch_array($re_group2)) {
                                                                    ?>
                                                                        <option <?php if ($drug_unit_id == $re_facgroup2['drug_unit_id']) {
                                                                                    echo "selected";
                                                                                } ?> value="<?php echo $re_facgroup2["drug_unit_id"]; ?>">
                                                                            <?php echo $re_facgroup2["drug_unit_name"];  ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ปริมาตร/หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control edit_drugamount" id="edit_drugamount<?= $drug_id ?>" name="edit_drugamount" value="<?= $drug_amount ?>" data-id="<?= $drug_id ?>">

                                                            </div>
                                                        </div>
                                                        <span><label id="show_edit_formula_small_unit<?= $drug_id ?>"></label></span>
                                                            &nbsp;<strong><span style="color:red" class=red_firstname> *</span> </strong>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ราคา/หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control edit_drugprice" id="edit_drugprice<?= $drug_id ?>" name="edit_drugprice" value="<?= $drug_price ?>">

                                                            </div>
                                                        </div>
                                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รายละเอียด : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control " rows="5" name="edit_detail" id="edit_detail<?= $drug_id ?>"><?php echo $drug_detail; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="fileinput fileinput-new text-center a" data-provides="fileinput" align="center">
                                                        <div style="cursor:pointer;">
                                                            <img src="image/drug/<?php echo $picture ?>" alt="..." class="edit_picture" id="edit_picture<?= $drug_id ?>" style="object-fit: fill; border-radius: 8px;" align="center" width="200px" height="200"><br><br>
                                                            <input type="file" name="picture" id="picture<?= $drug_id ?>" style="display:none" class="edit_file" accept="image/*">
                                                            <span class="show_pic">(เลือกไฟล์รูปภาพ) </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group" align="right">
                                                <button type="submit" class="btn btn-outline-success" name="btn_edit_drug" data-id="<?= $drug_id ?>" id="btn_edit_drug">บันทึก</button>
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
                        </div>

                        <!--- เริ่ม modal แสดงข้อมูล --->
                        <div id="view<?php echo $drug_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lgg">
                                <div class="modal-content" style="width: auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title card-title"><i class="fas fa-search-plus"></i> แสดงข้อมูลยา</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                            <h3>&times;</h3>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" method="post" action="" id="view_drug">
                                            <div class="row">
                                                <input type="hidden" name="view_item_id" id="view_item_id">
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รหัสยา : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="view_drugid" name="view_drugid" value="<?= $drug_id ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ประเภทยา : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input name="view_typedrug" class="form-control" id="view_typedrug" value="<?= $type_name ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>กลุ่มยา : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input name="view_drugunit" class="form-control" id="view_drugunit" value="<?= $group_name ?>" readonly>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ชื่อยา : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="view_drugname" name="view_drugname" value="<?= $drug_name ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input name="view_drugsmunit" class="form-control" id="view_drugsmunit" value="<?= $drug_unit_name ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ปริมาตร/หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="view_drugamount" name="view_drugamount" value="<?= $drug_amount ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <label id="show_unit<?= $drug_id ?>"></label>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ราคา/หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="view_drugprice" name="view_drugprice" value="<?= $drug_price ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <span>บาท</span>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รายละเอียดเพิ่มเติม : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <textarea class="form-control " id="view_drugdetail" rows="5" name="view_drugdetail" readonly><?= $drug_detail ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <img src="image/drug/<?php echo $picture ?>" width="200" height="200" class="a" style="object-fit: fill; border-radius: 8px;" align="center"><br><br>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>


                <?php
                } //end while
            } //end if
                ?>
                    </tr>
        </table>

    </div>
</div>

<script>
    var TableBackgroundNormalColor = "#ffffff";
    var TableBackgroundMouseoverColor = "#9efaaa";

    // These two functions need no customization.
    function ChangeBackgroundColor(row) {
        row.style.backgroundColor = TableBackgroundMouseoverColor;
    }

    function RestoreBackgroundColor(row) {
        row.style.backgroundColor = TableBackgroundNormalColor;
    }

    function myFunction() {
        document.getElementById("myDrug").reset();
    }

    function myFunction2() {
        document.getElementById("myDrugdetail").reset();
    }
</script>