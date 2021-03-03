<?php
include('connect.php');

//--- รันรหัสสูตรยา ---//
date_default_timezone_set("Asia/Bangkok");
$sql_group = "SELECT Max(drug_formula_id) as maxid FROM tb_drug_formula";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "DF";
$tmp2 = substr($mem_old, 5, 7);
$sub_date = substr($d, 2, 3);
$Year = substr($mem_old, 2, 2);
if ($Year != $sub_date) {
    $tmp2 = 0;
    //  $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;
$a = sprintf("%03d", $t);
$run_formula_id = $tmp1 . $sub_date . $a;


@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];

?>

<input type="hidden" id="per" value='<?php echo $permiss ?>'>
<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-outline-warning" data-toggle="modal" id="modal_add" data-target=".bd-example-modal-lg" onclick="myFunction()"><i class="ni ni-fat-add"></i> เพิ่มสูตรยา</button>
    </div>
</div><br>


<!-- แสดงข้อมูลในตาราง -->
<div class="row">
    <div class="col-12">
        <table class="table-bordered text-center" id="formulaTable" width="100%">
            <thead bgcolor="#2dce89">
                <th>ลำดับ</th>
                <th>รหัสสูตรยา</th>
                <th>ชื่อสูตรยา</th>
                <th>สูตรยา/จำนวน (ต้น)</th>
                <th>ปริมาณยารวม (ลิตร)</th>
                <th>ราคายารวม (บาท)</th>
                <th>สถานะ</th>
                <th width ="100"></th>

            </thead>
            <?php
            $sql = "SELECT tb_drug_formula.drug_formula_id as drug_formula_id, tb_drug_formula.drug_formula_name as drug_formula_name,
                                tb_drug_formula.drug_formula_status as drug_formula_status 
                                ,tb_drug_formula.drug_formula_amount as drug_formula_amount
                              
                                FROM tb_drug_formula
                                ORDER BY drug_formula_id ASC";

            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                $i = 0;
                while ($row = $result->fetch_assoc()) {

                    $i++;

                    $drug_formula_id = $row['drug_formula_id'];
                    $drug_formula_amount = $row['drug_formula_amount'];
                    $drug_formula_name = $row['drug_formula_name'];
                    $drug_formula_status = $row['drug_formula_status'];

            ?>

                    <div id="edit<?php echo $drug_formula_id; ?>" class="modal fade" role="dialog">

                        <div class="modal-dialog modal-lg">

                            <!-- edit  detail-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title card-title"><i class="fas fa-edit"></i>
                                        แก้ไขรายละเอียดสูตรยา</h5>
                                    <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                        <h3>&times;</h3>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" enctype="multipart/form-data" id="edit_drugformula<?= $drug_formula_id ?>">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-4" align="right">
                                                        <label>รหัสสูตรยา : </label>
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="edit_formula_id<?= $drug_formula_id ?>" name="edit_formula_id" value="<?= $drug_formula_id ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <span style="color:red"> *</span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4" align="right">
                                                        <label>ชื่อสูตรยา : </label>
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control edit_formula_name" id="edit_formula_name<?= $drug_formula_id ?>" name="edit_formula_name" value="<?php echo $drug_formula_name ?>" data-id="<?= $drug_formula_id ?>">
                                                        </div>
                                                    </div>
                                                    <span style="color:red"> *</span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4" align="right">
                                                        <label>สูตรยา/จำนวน : </label>
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control edit_formula_amount" id="edit_formula_amount<?= $drug_formula_id ?>" name="edit_formula_amount" value="<?php echo $drug_formula_amount ?>">
                                                        </div>
                                                    </div>
                                                    <span>ต้น</span>&nbsp;<span style="color:red"> *</span>
                                                </div>
                                            </div>
                                            <div class="col-6">

                                                <div class="form-group" align="right">
                                                    <button type="button" class="btn btn-outline-success" name="btn_edit_formula" id="btn_edit_formula" data-id='<?= $drug_formula_id ?>'>บันทึก</button>
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
                    </div>





            <?php
                } //end while
            } //end if
            ?>
        </table>

    </div>
</div>



<!-- ตารางรายละเอียดสูตรยา -->
<div id="view_dialog" class="modal fade" role="dialog">
    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="modal-dialog modal-lxx">
            <!-- Modal content-->
            <div class="modal-content" style="width:auto">
                <div class="modal-header">
                    <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายละเอียดสูตรยา
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                        <h3>&times;</h3>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <strong><label>รหัสสูตรยา : </label></strong>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label id="show_formula_id"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <strong><label>ชื่อสูตรยา : </label></strong>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label id="show_formula_name"></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="edit_item_id" value="<?php echo $id; ?>">
                    <table id="tb_drug_formula_detail" class=" table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสยา</th>
                                <th>ประเภทยา</th>
                                <th>กลุ่มยา</th>
                                <th>ชื่อยา</th>
                                <th>ปริมาณการใช้ยา</th>
                                <th>หน่วยย่อย</th>
                                <th>ราคาการใช้ยา (บาท)</th>
                                <th>สถานะ</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </form>
</div>






<!--- เริ่ม modal เพิ่มข้อมูลยา--->
<div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="drug">
    <div class="modal-dialog modal-lx">
        <div class="modal-content" style="width:auto">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลสูตรยา</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" class="insert" id="myDrug">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รหัสสูตรยา : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_drug_formula_id" name="in_drug_formula_id" value="<?= $run_formula_id ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ชื่อสูตรยา : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control formula_name" id="formula_name" name="formula_name" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>สูตรยา/จำนวน : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control formula_total" min="1" id="formula_total" name="formula_total" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <span>ต้น</span>&nbsp;<strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ประเภทยา : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <select name="add_formula_typedrug" class="form-control" id="add_formula_typedrug">
                                            <option value="0">----โปรดเลือกประเภทยา----</option>
                                            <?php
                                            $sql_type3 = "SELECT * FROM tb_drug_type                                                          
                                            WHERE drug_typestatus ='ปกติ' ORDER BY drug_typename ASC";
                                            $re_type3 = mysqli_query($conn, $sql_type3);
                                            while ($re_fac3 = mysqli_fetch_array($re_type3)) {
                                            ?>
                                                <option value="<?php echo $re_fac3["drug_typeid"]; ?>">
                                                    <?php echo $re_fac3["drug_typename"];  ?>
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
                                <div class="col-5">
                                    <div class="form-group">
                                        <select name="add_formula_groupdrug" class="form-control" id="add_formula_groupdrug">
                                            <option value="0">----โปรดเลือกกลุ่มยา----</option>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ชื่อยา : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <select name="add_formula_drug" class="form-control" id="add_formula_drug">
                                            <option value="0">----โปรดเลือกยา----</option>

                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>
                            <div class="row" id="show1">
                                <div class="col-4" align="right">
                                    <label>ปริมาตร/หน่วย : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="number" class="form-control drugamount " min="1" id="drugamount" name="drugamount" readonly>
                                    </div>
                                </div>
                                <span><label id="show_amount_unit"></label></span>
                            </div>
                            <div class="row" id="show2">
                                <div class="col-4" align="right">
                                    <label>ราคา/หน่วย: </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input name="add_formula_price" class="form-control" id="add_formula_price" readonly>
                                    </div>
                                </div>
                                <span> บาท</span>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ปริมาณการใช้ยา : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="number" min="1" class="form-control formula_amount" id="formula_amount" name="formula_amount" placeholder="กรุณากรอกข้อมูล">
                                        &nbsp;&nbsp;<span style="color:red" id="show_text_amount">(กรณีไม่ถึง 1 ให้ใส่ 0.25, 0.5, 0.75) </span>
                                    </div>

                                </div>
                                <label id="show_formula_unit"></label>
                                &nbsp;<strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label></label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control formula_use_amount " id="formula_use_amount" name="formula_use_amount" readonly>
                                    </div>
                                </div>
                                <label id="show_formula_smunit"></label>
                            </div>


                            <!--  <div class="row">
                                <div class="col-4" align="right">
                                    <label>หน่วย : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input name="add_formula_drugsmunit" class="form-control" id="add_formula_drugsmunit" readonly>
                                    </div>
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ราคาการใช้ยา: </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input name="add_formula_total_price" class="form-control" id="add_formula_total_price" readonly>
                                    </div>
                                </div>
                                <span> บาท</span>
                            </div>
                        </div>
                    </div>
                    <table class="table-striped table-bordered text-center" id="add_formulaTable" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>ประเภทยา</th>
                            <th>กลุ่มยา</th>
                            <th>ชื่อยา</th>
                            <th>ราคา/หน่วย (บาท)</th>
                            <th>ปริมาณการใช้ยา</th>
                            <th></th>
                            <th>ราคาการใช้ยา (บาท)</th>
                            <th></th>
                        </thead>

                    </table>
            </div>

            <div class="modal-footer">
                <div class="form-group" align="right">
                    <button type="button" class="btn btn-outline-info" name="btn_add_formulalist" id="btn_add_formulalist">เพิ่มรายการ</button>
                </div>
                <div class="form-group" align="right">
                    <button type="button" class="btn btn-outline-success" name="btn_add_formula" id="btn_add_formula">บันทึก</button>
                </div>

                <div class="form-group">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-danger">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>



<form role="form" method="POST" action="" enctype="multipart/form-data" class="edit_formula_detail" id="edit_formula_detail">
    <div id="show_modal"></div>
</form>


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
</script>