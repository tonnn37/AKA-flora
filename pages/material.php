<?php

@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];

//รหัสวัสดุปลูก
$sql_group = "SELECT Max(material_id) as maxid FROM tb_material";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "MAT"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp2 = substr($mem_old, 5, 7);
$Year = substr($mem_old, 3, 2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp2 = 0;
    // $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;

$a = sprintf("%03d", $t);

$matid = $tmp1 . $sub_date . $a;

?>


<input type="hidden" id="per" value='<?php echo $permiss ?>'>


<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target=".material" onclick="myFunction()"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลวัสดุปลูก</button>
    </div>
</div><br>

<!--- เริ่ม modal เพิ่มวัสดุปลูก --->
<div class="modal fade material" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="material">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลวัสดุปลูก</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="" id="insert_material">
                    <div class="row">

                        <div class="col-sm-11">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รหัสวัสดุปลูก : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="insert_material_id" name="insert_material_id" value="<?= $matid ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-11">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ประเภทวัสดุปลูก : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <select name="insert_type_material_name" class="form-control" id="insert_type_material_name">
                                            <option value="0">----โปรดเลือกประเภทวัสดุปลูก----</option>
                                            <?php
                                            $sql_type1 = "SELECT * FROM tb_type_material  
                                          
                                            WHERE type_material_status ='ปกติ'                                          
                                            ORDER BY type_material_name ASC";
                                            $re_type1 = mysqli_query($conn, $sql_type1);
                                            while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                            ?>
                                                <option value="<?php echo $re_fac1["type_material_id"]; ?>">
                                                    <?php echo $re_fac1["type_material_name"]; ?>
                                                </option>
                                            <?php
                                            }

                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span></strong>
                            </div>
                        </div>
                        <div class="col-sm-11">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>หน่วย : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <select name="insert_unit_name" class="form-control" id="insert_unit_name">
                                            <option value="0">----โปรดเลือกหน่วย----</option>
                                            <?php
                                            $sql_type2 = "SELECT * FROM tb_drug_unit
                                            WHERE drug_unit_status = 'ปกติ' AND drug_unit_name != 'แกลลอน' AND drug_unit_name !='ขวด'
                                            ORDER BY drug_unit_name ASC";
                                            $re_type2 = mysqli_query($conn, $sql_type2);
                                            while ($re_fac2 = mysqli_fetch_array($re_type2)) {
                                            ?>
                                                <option value="<?php echo $re_fac2["drug_unit_id"]; ?>">
                                                    <?php echo $re_fac2["drug_unit_name"]; ?>
                                                </option>
                                            <?php
                                            }

                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span></strong>
                            </div>
                        </div>
                        <div class="col-sm-11">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ชื่อวัสดุปลูก : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control materialname" id="insert_material_name" name="insert_material_name" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span></strong>
                            </div>
                        </div>

                        <!-- 
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ราคา/หน่วย : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="number" class="form-control materialprice" id="insert_material_price" name="insert_material_price" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <span> บาท</span>&nbsp;<span style="color:red"> *</span>
                            </div>
                        </div> -->

                        <div class="col-sm-11">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ปริมาตร/หน่วย : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="number" class="form-control insert_material_amount" id="insert_material_amount" name="insert_material_amount" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <span>กิโลกรัม</span>
                                &nbsp;<strong><span style="color:red"> *</span></strong>
                                <label></label>


                                <input type="hidden" class="form-control" id="insert_material_amount_gram" name="insert_material_amount_gram" readonly>



                            </div>
                        </div>
                        <div class="col-sm-11">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ราคา/หน่วย : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="number" class="form-control materialprice" id="insert_material_price" name="insert_material_price" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <span> บาท</span>&nbsp;<strong><span style="color:red"> *</span></strong>
                            </div>
                        </div>
                        <!-- <div class="col-sm-11">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ราคา/กรัม : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control insert_material_cost" id="insert_material_cost" name="insert_material_cost" readonly>
                                    </div>
                                </div>
                                <span> บาท</span>
                            </div>
                        </div> -->
                        <!-- <div class="col-sm-10">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>หน่วย : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="insert_material_unit" name="insert_material_unit" readonly>
                                    </div>
                                </div>
                                <span style="color:red"> *</span>
                            </div>
                        </div> -->
                    </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group" align="right">
                        <button type="button" class="btn btn-outline-success" name="btn_save_material" id="btn_save_material">บันทึก</button>
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
        <table class="table-bordered text-center" id="materialTable" width="100%">
            <thead bgcolor="#2dce89">
                <th>ลำดับ</th>
                <th>รหัสวัสดุปลูก</th>
                <th>ประเภทวัสดุปลูก</th>
                <th>ชื่อวัสดุปลูก</th>
                <th width ="100">ปริมาตร/หน่วย (กิโลกรัม)</th>
                <th>ราคา/หน่วย (บาท)</th>
                <th>สถานะ</th>
                <th width="100"></th>

            </thead>
            <?php
            $sql = "SELECT  tb_material.material_id as material_id,
                                   tb_material.material_name as material_name,
                                   tb_material.material_price as material_price,
                                   tb_material.material_status as material_status,
                                    tb_material.material_amount as material_amount,
                                   tb_type_material.type_material_name as type_material_name,
                                   tb_drug_unit.drug_unit_name as drug_unit_name,
                                   tb_drug_unit.drug_unit_id as drug_unit_id
                                   
                            FROM  tb_material
                            LEFT JOIN tb_type_material ON tb_type_material.type_material_id = tb_material.ref_type_material
                            LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_material.ref_drug_unit
                            ORDER BY material_id ASC";



            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $i++;

                    $material_id = $row['material_id'];
                    $material_name = $row['material_name'];
                    $material_price = $row['material_price'];
                    $material_status = $row['material_status'];
                    $type_material_name = $row['type_material_name'];
                    $material_amount = $row['material_amount'];
                    $drug_unit_id = $row['drug_unit_id'];
                    $drug_unit_name = $row['drug_unit_name'];

                    /* 
                    $cal_gram = $material_amount * 1000;
                    $cal_price = $material_price/ $cal_gram; */

                    //---  เช็ค remove  --//
                    $sql2 = "SELECT tb_planting_week_detail.ref_material_id as ref_material_id
                    FROM tb_planting_week_detail
                    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
                    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
                    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
                    WHERE tb_planting_week_detail.ref_material_id = '$material_id' 
                    AND (tb_planting_detail.planting_detail_status ='ปกติ' OR tb_planting_detail.planting_detail_status ='รอรับเข้า')
                    GROUP BY tb_planting_week_detail.ref_material_id";
                    $res = mysqli_query($conn, $sql2);
                    if ($rows = $res->num_rows > 0) {
                        $dis = "disabled";
                    } else {
                        $dis = "";
                    }

            ?>

                    <tr onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)" style="text-align: center;">
                        <td>
                            <?php echo $i; ?></td>
                        <td>
                            <?php echo $material_id; ?>
                        </td>
                        <td>
                            <?php echo $type_material_name; ?>
                        </td>
                        <td>
                            <?php echo $material_name . " " . "(" . $drug_unit_name . ")"; ?>
                        </td>

                        <td>
                            <?php echo number_format($material_amount, 1) ?>
                        </td>
                        <td>
                            <?php echo number_format($material_price, 2) ?>
                        </td>




                        <td <?php if ($material_status == 'ระงับ') {
                                echo 'style="color:red"';
                            } ?>>
                            <?php echo $material_status; ?>
                        </td>

                        <?php
                        if ($material_status ==  'ปกติ') {
                            $image = 'fas fa-times';
                            $color = "btn btn-danger  btn-sm";
                            $txt = "ยกเลิกข้อมูลวัสดุปลูก";
                            $disabled = "";
                            $modal = "modal";
                        } else if ($material_status == 'ระงับ') {
                            $image = 'fas fa-check';
                            $color = "btn btn-success btn-sm";
                            $txt = "ยกเลิกการระงับข้อมูลวัสดุปลูก";
                            $disabled = "disabled";
                            $modal = "";
                        }
                        ?>
                        <td style="text-align: center;">
                            <!-- ปุ่มแสดงข้อมูล -->
                            <a href="#view<?php echo $material_id; ?>" data-toggle="modal">
                                <button type='button' class='btn btn-sm ' style="background-color:#FFCC00;" id="view_material" data-toggle="tooltip" title="แสดงข้อมูลวัสดุปลูก" material="<?= $material_id ?>"><i class="fas fa-search-plus"></i></button>
                            </a>
                            <!--- ปุ่มแก้ไข --->
                            <a href="#edit<?php echo $material_id; ?>" data-toggle="<?php echo  $modal ?>">
                                <button type='button' class='btn btn-warning btn-sm ' <?php echo  $disabled ?> id="edit_material" data-toggle="tooltip" title="แก้ไขข้อมูลวัสดุปลูก" material="<?= $material_id ?>" date_at="<?= $update_at ?>"><i class="fas fa-edit" style="color:white;"></i></button>
                            </a>
                            <!--- ปุ่มยกเลิก --->
                            <button type='button' id="btn_remove_material" class='<?= $color ?>' <?php echo  $dis ?> data-toggle="tooltip" title="<?= $txt ?>" data-id="<?= $material_id ?>" data-status="<?= $material_status ?>" data-name="<?= $material_name ?>"><i class="<?= $image ?>" style="color:white"></i></span></button>
                        </td>

                        <!--- เริ่ม modal แสดงข้อมูล --->
                        <div id="view<?php echo $material_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="width: auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title card-title"><i class="fas fa-search-plus"></i> แสดงข้อมูลวัสดุปลูก</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                            <h3>&times;</h3>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" method="post" action="" id="view_material">


                                            <div class="row">
                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รหัสวัสดุปลูก : </label>
                                                        </div>
                                                        <div class="col-6">

                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="view_material_id" name="view_material_id" value="<?= $material_id ?>" readonly>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ประเภทวัสดุปลูก : </label>
                                                        </div>
                                                        <div class="col-6">

                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="view_material_typename" name="view_material_typename" value="<?= $type_material_name ?>" readonly>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">

                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="view_material_unit" name="view_material_unit" value="<?= $drug_unit_name ?>" readonly>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ชื่อวัสดุปลูก : </label>
                                                        </div>
                                                        <div class="col-6">

                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="view_material_name" name="view_material_name" value="<?= $material_name ?>" readonly>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label> ราคาวัสดุปลูก : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="view_material_price" name="view_material_price" value="<?= $material_price ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <span> บาท</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label> จำนวน : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="view_material_amount" name="view_material_amount" value="<?= $material_amount ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <span> กิโลกรัม</span>
                                                    </div>
                                                </div>
                                              <!--   <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label> หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="view_material_unit" name="view_material_unit" value="<?= $drug_sm_unit_name ?>" readonly>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
 -->
                                            </div>

                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>

                        <!--- เริ่ม modal แก้ไข --->
                        <div id="edit<?php echo $material_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="width: auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขข้อมูลวัสดุปลูก</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                            <h3>&times;</h3>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" method="post" action="" id="edit_material_form<?= $material_id ?>">

                                            <div class="row">
                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รหัสวัสดุปลูก : </label>
                                                        </div>
                                                        <div class="col-6">

                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="edit_material_id<?= $material_id ?>" name="edit_material_id" value="<?= $material_id ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ประเภทวัสดุปลูก : </label>
                                                        </div>
                                                        <div class="col-6">

                                                            <div class="form-group">
                                                                <select class="form-control edit_type_material_name" id="edit_type_material_name<?= $material_id ?>" name="edit_type_material_name" data-id="<?= $material_id ?>">


                                                                    <?php
                                                                    $sql_type3 = "SELECT * FROM tb_type_material  WHERE type_material_status ='ปกติ' ORDER BY type_material_id ASC";
                                                                    $re_type3 = mysqli_query($conn, $sql_type1);
                                                                    while ($re_fac3 = mysqli_fetch_array($re_type3)) {
                                                                    ?>
                                                                        <option <?php if ($type_material_name == $re_fac3['type_material_name']) {
                                                                                    echo "selected";
                                                                                } ?> value="<?php echo $re_fac3["type_material_id"]; ?>">
                                                                            <?php echo $re_fac3["type_material_name"]; ?>
                                                                        </option>
                                                                    <?php
                                                                    }

                                                                    ?>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <strong><span style="color:red"> *</span></strong>
                                                    </div>
                                                </div>
                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <select name="edit_unit_name" class="form-control edit_unit_name" id="edit_unit_name<?= $material_id ?>" data-id="<?= $material_id ?>">
                                                                    <option value="0">----โปรดเลือกหน่วย----</option>
                                                                    <?php
                                                                    $sql_type2 = "SELECT * FROM tb_drug_unit
                                            WHERE drug_unit_status = 'ปกติ' AND drug_unit_name != 'แกลลอน' AND drug_unit_name !='ขวด'
                                            ORDER BY drug_unit_name ASC";
                                                                    $re_type2 = mysqli_query($conn, $sql_type2);
                                                                    while ($re_fac2 = mysqli_fetch_array($re_type2)) {
                                                                    ?>
                                                                        <option <?php if ($drug_unit_id == $re_fac2['drug_unit_id']) {
                                                                                    echo "selected";
                                                                                } ?> value="<?php echo $re_fac2["drug_unit_id"]; ?>">
                                                                            <?php echo $re_fac2["drug_unit_name"]; ?>
                                                                        </option>
                                                                    <?php
                                                                    }

                                                                    ?>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <strong><span style="color:red"> *</span></strong>
                                                    </div>
                                                </div>

                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ชื่อวัสดุปลูก : </label>
                                                        </div>
                                                        <div class="col-6">

                                                            <div class="form-group">
                                                                <input type="text" class="form-control edit_material_name" id="edit_material_name<?= $material_id ?>" name="edit_material_name" value="<?= $material_name ?>" data-id="<?= $material_id ?>" placeholder="กรุณากรอกข้อมูล">
                                                            </div>
                                                        </div>
                                                        <strong><span style="color:red"> *</span></strong>
                                                    </div>
                                                </div>
                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label> ปริมาตร/หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="number" class="form-control edit_material_amount" id="edit_material_amount<?= $material_id ?>" name="edit_material_amount" value="<?= $material_amount ?>" data-id="<?= $material_id ?>" placeholder="กรุณากรอกข้อมูล">
                                                            </div>
                                                        </div>
                                                        <label>กิโลกรัม</label>&nbsp; <strong><span style="color:red"> *</span></strong>
                                                    </div>
                                                </div>
                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label> ราคา/หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="number" class="form-control edit_material_price" id="edit_material_price<?= $material_id ?>" name="edit_material_price" value="<?= $material_price ?>" placeholder="กรุณากรอกข้อมูล">
                                                            </div>
                                                        </div>
                                                        <span> บาท</span>&nbsp; <strong><span style="color:red"> *</span></strong>
                                                    </div>
                                                </div>
                                               
                                         <!--        <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label> หน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control " id="edit_material_unit<?= $material_id ?>" name="edit_material_unit" value="<?= $drug_sm_unit_name ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <span style="color:red"> *</span>
                                                    </div>
                                                </div> -->
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group" align="right">
                                                <button type="button" class="btn btn-outline-success" name="btn_save_edit_material" id="btn_save_edit_material" data-id="<?= $material_id ?>">บันทึก</button>
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
                        </div>
                        </form>
    </div>


<?php
                } //end while
            } //end if
?>
</table>

</div>





<script>
    function myFunction() {

        document.getElementById("insert_material").reset();

    }

    var TableBackgroundNormalColor = "#ffffff";
    var TableBackgroundMouseoverColor = "#9efaaa";

    // These two functions need no customization.
    function ChangeBackgroundColor(row) {
        row.style.backgroundColor = TableBackgroundMouseoverColor;
    }

    function RestoreBackgroundColor(row) {
        row.style.backgroundColor = TableBackgroundNormalColor;
    }
</script>