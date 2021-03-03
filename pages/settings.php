<?php

include('connect.php');
@session_start();
$emp = $_SESSION['emp_id'];
$level = $_SESSION['userlevel'];

//รหัสประเภทยา
$sql_group = "SELECT Max(drug_typeid) as maxid FROM tb_drug_type";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "DT"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp2 = substr($mem_old, 5, 6);
$Year = substr($mem_old, 2, 2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp2 = 0;
    //  $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;

$a = sprintf("%02d", $t);

$dt_id = $tmp1 . $sub_date . $a;

?>

<input type="hidden" id="setting" value='<?php echo $level ?>'>
<div class="nav-wrapper">

    <ul class="nav nav-pills nav-fill flex-column flex-md-row nav-tabs" id="tabs-icons-text" role="tablist">
        <li class="nav-item active">
            <a class="nav-link btn-outline-success mb-sm-3 mb-md-0 active" id="tab1" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fas fa-prescription-bottle-alt"></i> ประเภทยา</a>
        </li>
        <li class="nav-item nextab">
            <a class="nav-link  btn-outline-success mb-sm-3 mb-md-0" id="tab2" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="fas fa-prescription-bottle"></i> กลุ่มยา</a>
        </li>
        <li class="nav-item nextab">
            <a class="nav-link  btn-outline-success mb-sm-3 mb-md-0" id="tab3" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="ni ni-cart"></i> ประเภทหน่วย</a>
        </li>
        <li class="nav-item nextab">
            <a class="nav-link  btn-outline-success mb-sm-3 mb-md-0" id="tab5" data-toggle="tab" href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5" aria-selected="false"><i class="fas fa-leaf"></i> ประเภทพันธุ์ไม้</a>
        </li>
        <li class="nav-item nextab">
            <a class="nav-link  btn-outline-success mb-sm-3 mb-md-0" id="tab6" data-toggle="tab" href="#tabs-icons-text-6" role="tab" aria-controls="tabs-icons-text-6" aria-selected="false"><i class="fas fa-prescription-bottle"></i> ประเภทวัสดุปลูก</a>
        </li>
        <li class="nav-item nextab">
            <a class="nav-link  btn-outline-success mb-sm-3 mb-md-0" id="tab7" data-toggle="tab" href="#tabs-icons-text-7" role="tab" aria-controls="tabs-icons-text-7" aria-selected="false"><i class="fas fa-award"></i> เกรดพันธุ์ไม้</a>
        </li>
    </ul>

</div>

<div class="card1 shadow">
    <div class="card-body">
        <div class="tab-content" id="myTabContent">


            <!-- tap ประเภทยา-->
            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                <div class="row">
                    <div class="col-12">

                        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#dialog_type" id="btn_add_drugtype" onclick="add_typedrug()"><i class="ni ni-fat-add"></i>
                            เพิ่มประเภทยา</button>
                        <br>
                        <br>


                        <!-- แสดงข้อมูลใน ตาราง -->
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered text-center" id="drugtypeTable" width="100%">
                                    <thead bgcolor="#2dce89">
                                        <th>ลำดับ</th>
                                        <th>รหัสประเภทยา</th>
                                        <th>ชื่อประเภทยา</th>
                                        <th>สถานะ</th>
                                        <th class="a"></th>
                                    </thead>
                                    <?php
                                    $sql = "SELECT * FROM `tb_drug_type`
                             /*        WHERE drug_typestatus = 'ปกติ' */
                                    ORDER BY tb_drug_type.drug_typeid ASC";


                                    $result = mysqli_query($conn, $sql);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        $i = 0;

                                        while ($row = $result->fetch_assoc()) {
                                            $i++;
                                            $drug_typeid = $row['drug_typeid'];
                                            $drug_typename = $row['drug_typename'];
                                            $drug_typestatus = $row['drug_typestatus'];
                                          

                                
                                        

                                            $sql2 = "SELECT * FROM tb_drug_type
                                            INNER JOIN tb_group_drug ON tb_group_drug.ref_drug_type = tb_drug_type.drug_typeid
                                            INNER JOIN tb_drug ON tb_drug.ref_group_drug = tb_group_drug.group_drug_id
                                            WHERE tb_drug_type.drug_typeid='$drug_typeid' AND tb_drug.drug_status='ปกติ'";
                                            $res = mysqli_query($conn, $sql2);
                                            if ($rows = $res->num_rows > 0) {
                                                $dis = "disabled";
                                            } else {
                                                $dis = "";
                                            }
                                    ?>
                                            <tr onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
                                                <td class="type_id">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="type_id">
                                                    <?php echo $drug_typeid; ?>
                                                </td>
                                                <td>
                                                    <?php echo $drug_typename; ?>
                                                </td>
                                   
                                             
                                                <td <?php if ($drug_typestatus == 'ระงับ') {
                                                        echo "style='color:red'";
                                                    } ?>>
                                                    <?php echo $drug_typestatus; ?>
                                                </td>

                                                <?php
                                                if ($drug_typestatus == 'ปกติ') {
                                                    $image = 'fas fa-times';
                                                    $color = "btn btn-danger btn-sm";
                                                    $txt = "ยกเลิกข้อมูล";
                                                    $disabled = "";
                                                    $modal = "modal";
                                                } else if ($drug_typestatus == 'ระงับ') {
                                                    $image = 'fas fa-check';
                                                    $color = "btn btn-success btn-sm";
                                                    $txt = "ยกเลิกการระงับ";
                                                    $disabled = "disabled";
                                                    $modal = "";
                                                }
                                                ?>
                                                <td class="a">
                                                    <a href="#edit<?php echo $drug_typeid; ?>" data-toggle="<?php echo $modal ?>">
                                                        <button type='button' class='btn btn-warning btn-sm ' <?php echo $disabled ?> id="edit_drugtype" data-id="<?= $drug_typeid ?>" data-toggle="tooltip" title="แก้ไขข้อมูล"><i class="fas fa-edit" style="color:white;"></i></button>
                                                    </a>
                                                    <button type='button' class='<?= $color ?>' id="btn_remove_drugtype" <?php echo $dis; ?> data-toggle="tooltip" title="<?= $txt ?>" data-id="<?= $drug_typeid ?>" data-status="<?= $drug_typestatus ?>" data-name="<?= $drug_typename ?>"><i class="<?= $image ?>" style="color:white"></i></button>

                                                </td>
                                            </tr>

                                            <!--- เริ่ม modal แก้ไข ประเภทยา --->
                                            <div id="edit<?php echo $drug_typeid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content" style="width: auto;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขข้อมูลประเภทยา</h5>
                                                            <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                                                <h3>&times;</h3>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" method="post" id="myedit_drugtype<?= $drug_typeid ?>">
                                                                <div class="row">
                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>รหัสประเภทยา : </label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" id="edit_drug_typeid" name="edit_drug_typeid" value="<?php echo $drug_typeid ?>" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>ชื่อประเภทยา : </label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control edit_drug_typename" id="edit_drug_typename<?= $drug_typeid ?>" name="edit_drug_typename" data-id="<?= $drug_typeid ?>" value="<?php echo $drug_typename ?>">
                                                                                </div>
                                                                            </div>
                                                                            <strong><span style="color:red"> *</span></strong>
                                                                        </div>
                                                                    </div>
                                                                    <!-- <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>บรรจุภัณฑ์ : </label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <select name="edit_drug_typeunit" class="form-control edit_drug_typeunit" id="edit_drug_typeunit<?= $drug_typeid ?>" data-id="<?= $drug_typeid ?>">
                                                                                        <option value="0">----โปรดเลือกบรรจุภัณฑ์----</option>
                                                                                        <?php
                                                                                        $sql_type1 = "SELECT * FROM tb_drug_unit  WHERE drug_unit_status ='ปกติ'  AND drug_unit_name != 'กระสอบ' ORDER BY drug_unit_id ASC";
                                                                                        $re_type1 = mysqli_query($conn, $sql_type1);
                                                                                        while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                                                                        ?> <option <?php if ($drug_typeunit == $re_fac1['drug_unit_id']) {
                                                                                                        echo "selected";
                                                                                                    } ?> value="<?php echo $re_fac1["drug_unit_id"]; ?>">
                                                                                                <?php echo $re_fac1["drug_unit_name"]; ?>
                                                                                            </option>
                                                                                        <?php
                                                                                        }

                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <strong><span style="color:red"> *</span></strong>
                                                                        </div>
                                                                    </div> -->
                                                                </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group" align="right">
                                                                    <button type="button" class="btn btn-outline-success" name="btn_edit_drugtype_save" id="btn_edit_drugtype_save" re_drug_typeid='<?= $drug_typeid ?>'>บันทึก</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-6" align="left">
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-outline-danger" id="cancel_edit_drugtype" data-dismiss="modal">ยกเลิก</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                    <?php
                                        } //end loop while
                                    } // end if
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><br>
            </div>

            <!--- เริ่ม modal เพิ่มประเภทยา --->
            <div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="dialog_type">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="width: auto;">
                        <div class="modal-header">
                            <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มประเภทยา</h5>
                            <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                <h3>&times;</h3>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="post" action="" id="add_drugtype">
                                <div class="row">
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>รหัสประเภทยา : </label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="drug_typeid" value="<?php echo $dt_id ?>" name="drug_typeid" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>ชื่อประเภทยา : </label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control drug_typename" id="drug_typename" name="drug_typename" placeholder="กรุณากรอกข้อมูล">
                                                </div>
                                            </div>
                                            <strong><span style="color:red"> *</span></strong>
                                        </div>
                                    </div>
                                  <!--   <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>บรรจุภัณฑ์ : </label>
                                            </div>
                                            <div class="col-6">

                                                <div class="form-group">
                                                    <select name="drug_typeunit" class="form-control drug_typeunit" id="drug_typeunit">
                                                        <option value="0">----โปรดเลือกบรรจุภัณฑ์----</option>
                                                        <?php
                                                        $sql_type1 = "SELECT * FROM tb_drug_unit  WHERE drug_unit_status ='ปกติ' AND drug_unit_name != 'กระสอบ'
                                                        ORDER BY drug_unit_id ASC";
                                                        $re_type1 = mysqli_query($conn, $sql_type1);
                                                        while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                                        ?>
                                                            <option value="<?php echo $re_fac1["drug_unit_id"]; ?>">
                                                                <?php echo $re_fac1["drug_unit_name"]; ?>
                                                            </option>
                                                        <?php
                                                        }

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <strong><span style="color:red"> *</span></strong>
                                        </div>
                                    </div> -->

                                  <!--   <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>หน่วย : </label>
                                            </div>
                                            <div class="col-6">

                                                <div class="form-group">
                                                    <select name="drug_sm_unit" class="form-control drug_sm_unit" id="drug_sm_unit">
                                                        <option value="0">----โปรดเลือกหน่วย----</option>
                                                        <?php
                                                        $sql_type1 = "SELECT * FROM tb_drug_sm_unit  WHERE drug_sm_unit_status ='ปกติ' 
                                                        ORDER BY drug_sm_unit_id ASC";
                                                        $re_type1 = mysqli_query($conn, $sql_type1);
                                                        while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                                        ?>
                                                            <option value="<?php echo $re_fac1["drug_sm_unit_id"]; ?>">
                                                                <?php echo $re_fac1["drug_sm_unit_name"]; ?>
                                                            </option>
                                                        <?php
                                                        }

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <strong><span style="color:red"> *</span></strong>
                                        </div>
                                    </div> -->
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group" align="right">
                                    <button type="button" class="btn btn-outline-success" name="btn_drugtype_save" id="btn_drugtype_save">บันทึก</button>
                                </div>
                            </div>
                            <div class="col-6" align="left">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-danger" id="cancel_drugtype" data-dismiss="modal">ยกเลิก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <!-- จบ tab1 ประเภทยา -->

            <?php
            //รหัสกลุ่มยา
            $sql_group = "SELECT Max(group_drug_id) as maxid FROM tb_group_drug";
            $datenow = strtotime(date("Y-m-d"));
            $d = date('Y', $datenow) + 543;
            $result = mysqli_query($conn, $sql_group);
            $row_mem = mysqli_fetch_assoc($result);
            $mem_old = $row_mem['maxid'];
            $tmp1 = "GD"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
            $tmp2 = substr($mem_old, 5, 6);
            $Year = substr($mem_old, 2, 2);
            $sub_date = substr($d, 2, 3);
            if ($Year != $sub_date) {
                $tmp2 = 0;
                // $sub_date=$sub_date+1;
            } else {
                $tmp2;
            }
            $t = $tmp2 + 1;

            $a = sprintf("%02d", $t);

            $gd_id = $tmp1 . $sub_date . $a;
            ?>
            <!-- tap2 กลุ่มยา-->
            <div class="tab-pane fade " id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                <div class="row">
                    <div class="col-12">

                        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#dialog_druggroup" id="btn_add_druggroup" onclick="add_groupdrug()"><i class="ni ni-fat-add"></i> เพิ่มกลุ่มยา</button>
                        <br>
                        <br>
                        <!-- แสดงข้อมูลใน ตาราง -->
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered text-center " id="drugkindTable" width="100%">
                                    <thead bgcolor="#2dce89">
                                        <th>ลำดับ</th>
                                        <th>รหัสกลุ่มยา</th>
                                        <th>ประเภทยา</th>
                                        <th>ชื่อกลุ่มยา</th>
                                        <th>สถานะ</th>
                                        <th class="a"></th>
                                    </thead>
                                    <?php

                                    $sql = "SELECT * FROM tb_group_drug
                                  
                                    INNER JOIN tb_drug_type ON tb_drug_type.drug_typeid= tb_group_drug.ref_drug_type
                                    ORDER BY  tb_group_drug.group_drug_id ASC";

                                    $result = mysqli_query($conn, $sql);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        $i = 0;

                                        while ($row = $result->fetch_assoc()) {
                                            $i++;
                                            $group_drug_id = $row['group_drug_id'];
                                            $group_drug_name = $row['group_drug_name'];
                                            $group_drug_status = $row['group_drug_status'];

                                            $drug_typeid = $row['drug_typeid'];
                                            $drug_typename = $row['drug_typename'];


                                            $sql2 = "SELECT * FROM tb_group_drug
                                            INNER JOIN tb_drug ON tb_drug.ref_group_drug = tb_group_drug.group_drug_id
                                            WHERE tb_group_drug.group_drug_id='$group_drug_id' AND tb_drug.drug_status='ปกติ'";
                                            $res = mysqli_query($conn, $sql2);
                                            if ($rows = $res->num_rows > 0) {
                                                $dis = "disabled";
                                            } else {
                                                $dis = "";
                                            }
                                    ?>
                                            <tr onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
                                                <td class="type_id">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="type_id">
                                                    <?php echo $group_drug_id; ?>
                                                </td>
                                                <td>
                                                    <?php if ($drug_typeid == $row['drug_typeid']) {
                                                        echo $row["drug_typename"];
                                                    } ?>

                                                </td>
                                                <td>
                                                    <?php echo $group_drug_name; ?>
                                                </td>

                                                <td <?php if ($group_drug_status == 'ระงับ') {
                                                        echo "style='color:red'";
                                                    } ?>>
                                                    <?php echo $group_drug_status; ?>
                                                </td>
                                                <?php
                                                if ($group_drug_status == 'ปกติ') {
                                                    $image = 'fas fa-times';
                                                    $color = "btn btn-danger btn-sm";
                                                    $txt = "ยกเลิกข้อมูล";
                                                    $disabled = "";
                                                    $modal = "modal";
                                                } else if ($group_drug_status == 'ระงับ') {
                                                    $image = 'fas fa-check';
                                                    $color = "btn btn-success btn-sm";
                                                    $txt = "ยกเลิกการระงับ";
                                                    $disabled = "disabled";
                                                    $modal = "";
                                                }
                                                ?>
                                                <td class="a">
                                                    <a href="#edit<?php echo $group_drug_id; ?>" data-toggle="<?php echo $modal ?>">
                                                        <button type='button' class='btn btn-warning btn-sm ' <?php echo $disabled ?> id="edit_groupdrug" data-id="<?= $group_drug_id ?>" data-toggle="tooltip" title="แก้ไขข้อมูล"><i class="fas fa-edit" style="color:white;"></i></button>
                                                    </a>

                                                    <button type='button' class='<?= $color ?>' id="btn_remove_groupdrug" <?php echo $dis; ?> data-toggle="tooltip" title="<?= $txt ?>" data-id="<?= $group_drug_id ?>" data-status="<?= $group_drug_status ?>" data-name="<?= $group_drug_name ?>"><i class="<?= $image ?>" style="color:white"></i></button>

                                                </td>
                                            </tr>

                                            <!--- เริ่ม modal แก้ไข ชนิดยา --->
                                            <div id="edit<?php echo $group_drug_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content" style="width: auto;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขข้อมูลกลุ่มยา</h5>
                                                            <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                                                <h3>&times;</h3>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" method="post" id="myedit_groupdrug<?= $group_drug_id ?>">
                                                                <div class="row">
                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>รหัสกลุ่มยา : </label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" id="edit_group_drugid" value="<?php echo $group_drug_id ?>" name="edit_roup_drugid" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>ประเภทยา : </label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <select name="edit_drug_typeid" class="form-control edit_drug_typeid" id="edit_drug_typeid<?= $group_drug_id ?>" data-id="<?= $group_drug_id ?>">
                                                                                        <option value="0">----โปรดเลือกประเภทยา----</option>
                                                                                        <?php
                                                                                        $sql_type1 = "SELECT * FROM tb_drug_type                                                                
                                                                                        WHERE drug_typestatus ='ปกติ' 
                                                                                        ORDER BY drug_typename ASC";
                                                                                        $re_type1 = mysqli_query($conn, $sql_type1);
                                                                                        while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                                                                        ?>
                                                                                            <option <?php if ($drug_typeid == $re_fac1['drug_typeid']) {
                                                                                                        echo "selected";
                                                                                                    } ?> value="<?php echo $re_fac1["drug_typeid"]; ?>">
                                                                                                <?php echo $re_fac1["drug_typename"]; ?>
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
                                                                                <label>ชื่อกลุ่มยา : </label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control edit_group_drugname" id="edit_group_drugname<?= $group_drug_id ?>" data-id="<?= $group_drug_id ?>" name="edit_group_drugname" value="<?php echo $group_drug_name ?>">
                                                                                </div>
                                                                            </div>
                                                                            <strong><span style="color:red"> *</span></strong>
                                                                        </div>
                                                                    </div>
                                                                    <!-- <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>หน่วย : </label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <select name="edit_drug_sunit_id" class="form-control edit_drug_sunit_id" id="edit_drug_sunit_id<?= $group_drug_id ?>">
                                                                                        <option value="0">----โปรดเลือกหน่วย----</option>
                                                                                        <?php
                                                                                        $sql_type2 = "SELECT * FROM tb_drug_sm_unit  WHERE drug_sm_unit_status ='ปกติ' ORDER BY drug_sm_unit_id ASC";
                                                                                        $re_type2 = mysqli_query($conn, $sql_type2);
                                                                                        while ($re_fac2 = mysqli_fetch_array($re_type2)) {
                                                                                        ?>
                                                                                            <option <?php if ($drug_sm_unit_id == $re_fac2['drug_sm_unit_id']) {
                                                                                                        echo "selected";
                                                                                                    } ?> value="<?php echo $re_fac2["drug_sm_unit_id"]; ?>">
                                                                                                <?php echo $re_fac2["drug_sm_unit_name"]; ?>
                                                                                            </option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <strong><span style="color:red"> *</span></strong>
                                                                        </div>
                                                                    </div> -->
                                                                </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group" align="right">
                                                                    <button type="button" class="btn btn-outline-success" name="btn_edit_groupdrug" id="btn_edit_groupdrug" re_groupdrug='<?= $group_drug_id ?>'>บันทึก</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-6" align="left">
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-outline-danger" id="cancel_edit_groupdrug" data-dismiss="modal">ยกเลิก</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                    <?php
                                        } //end loop while
                                    } // end if
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><br>
            </div>

            <!--- เริ่ม modal เพิ่มกลุ่มยา --->
            <div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="dialog_druggroup">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="width: auto;">
                        <div class="modal-header">
                            <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มกลุ่มยา</h5>
                            <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                <h3>&times;</h3>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="post" id="add_groupdrug">
                                <div class="row">
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>รหัสกลุ่มยา : </label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="group_drugid" value="<?php echo $gd_id ?>" name="group_drugid" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>ประเภทยา : </label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <select name="add_drug_typeid" class="form-control" id="add_drug_typeid">
                                                        <option value="0">----โปรดเลือกประเภทยา----</option>
                                                        <?php
                                                        $sql_type3 = "SELECT * FROM tb_drug_type                                                                
                                                        WHERE drug_typestatus ='ปกติ' 
                                                        ORDER BY drug_typename ASC";
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
                                            <strong><span style="color:red"> *</span></strong>
                                        </div>
                                    </div>
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>ชื่อกลุ่มยา : </label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="group_drugname" name="group_drugname" placeholder="กรุณากรอกข้อมูล">
                                                </div>
                                            </div>
                                            <strong><span style="color:red"> *</span></strong>
                                        </div>
                                    </div>
                                   <!--  <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>หน่วย : </label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <select name="add_drug_suunit" class="form-control" id="add_drug_suunit">
                                                        <option value="0">----โปรดเลือกหน่วย----</option>
                                                        <?php
                                                        $sql_type4 = "SELECT * FROM tb_drug_sm_unit  WHERE drug_sm_unit_status ='ปกติ' ORDER BY drug_sm_unit_id ASC";
                                                        $re_type4 = mysqli_query($conn, $sql_type4);
                                                        while ($re_fac4 = mysqli_fetch_array($re_type4)) {
                                                        ?>
                                                            <option value="<?php echo $re_fac4["drug_sm_unit_id"]; ?>">
                                                                <?php echo $re_fac4["drug_sm_unit_name"]; ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <strong><span style="color:red"> *</span></strong>
                                        </div>
                                    </div> -->
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group" align="right">
                                    <button type="button" class="btn btn-outline-success" name="btn_group_save" id="btn_group_save">บันทึก</button>
                                </div>
                            </div>
                            <div class="col-6" align="left">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-danger" id="cancel_group" data-dismiss="modal">ยกเลิก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <!--จบ tab2 กลุ่มยา-->


            <?php
            //รหัสบรรจุภัณฑ์
            $sql_group = "SELECT Max(drug_unit_id) as maxid FROM tb_drug_unit";
            $datenow = strtotime(date("Y-m-d"));
            $d = date('Y', $datenow) + 543;
            $result = mysqli_query($conn, $sql_group);
            $row_mem = mysqli_fetch_assoc($result);
            $mem_old = $row_mem['maxid'];
            $tmp1 = "UD"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
            $tmp2 = substr($mem_old, 5, 6);
            $Year = substr($mem_old, 2, 2);
            $sub_date = substr($d, 2, 3);
            if ($Year != $sub_date) {
                $tmp2 = 0;
                // $sub_date=$sub_date+1;
            } else {
                $tmp2;
            }
            $t = $tmp2 + 1;

            $a = sprintf("%02d", $t);

            $ud_id = $tmp1 . $sub_date . $a;
            ?>

            <!-- tap3 บรรจุภัณฑ์-->
            <div class="tab-pane fade " id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                <div class="row">
                    <div class="col-12">

                        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#dialog_drugunit" id="btn_add_drugunit" onclick="add_drugunit()"><i class="ni ni-fat-add"></i> เพิ่มประเภทหน่วย</button>
                        <br>
                        <br>
                        <!-- แสดงข้อมูลใน ตาราง -->
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered text-center " id="drugunitTable" width="100%">
                                    <thead bgcolor="#2dce89">
                                        <th>ลำดับ</th>
                                        <th>รหัสประเภทหน่วย</th>
                                        <th>ชื่อประเภทหน่วย</th>
                                        <th>สถานะ</th>
                                        <th class="a"></th>
                                    </thead>
                                    <?php

                                    $sql = "SELECT * FROM tb_drug_unit ";

                                    $result = mysqli_query($conn, $sql);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        $i = 0;

                                        while ($row = $result->fetch_assoc()) {
                                            $i++;
                                            $drug_unit_id = $row['drug_unit_id'];
                                            $drug_unit_name = $row['drug_unit_name'];
                                            $drug_unit_status = $row['drug_unit_status'];

                                            $sql2 = "SELECT * FROM tb_drug
                                            WHERE ref_drug_unit ='$drug_unit_id' AND drug_status ='ปกติ'";
                                            $res = mysqli_query($conn, $sql2);
                                            if ($rows = $res->num_rows > 0) {
                                                $dis1 = "disabled";
                                            } else {
                                                $dis1 = "";
                                            }
                                            $sql3= "SELECT * FROM tb_material
                                            WHERE ref_drug_unit ='$drug_unit_id' AND material_status ='ปกติ'";
                                            $res3 = mysqli_query($conn, $sql3);
                                            if ($rows3 = $res3->num_rows > 0) {
                                                $dis3 = "disabled";
                                            } else {
                                                $dis3 = "";
                                            }

                                    ?>
                                            <tr onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
                                                <td class="type_id">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="type_id">
                                                    <?php echo $drug_unit_id; ?>
                                                </td>
                                                <td>
                                                    <?php echo $drug_unit_name; ?>
                                                </td>

                                                <td <?php if ($drug_unit_status == 'ระงับ') {
                                                        echo "style='color:red'";
                                                    } ?>>
                                                    <?php echo $drug_unit_status; ?>
                                                </td>

                                                <?php
                                                if ($drug_unit_status == 'ปกติ') {
                                                    $image = 'fas fa-times';
                                                    $color = "btn btn-danger btn-sm";
                                                    $txt = "ยกเลิกข้อมูล";
                                                    $disabled = "";
                                                    $modal = "modal";
                                                } else if ($drug_unit_status == 'ระงับ') {
                                                    $image = 'fas fa-check';
                                                    $color = "btn btn-success btn-sm";
                                                    $txt = "ยกเลิกการระงับ";
                                                    $disabled = "disabled";
                                                    $modal = "";
                                                }
                                                ?>
                                                <td class="a">
                                                    <a href="#edit<?php echo $drug_unit_id; ?>" data-toggle="<?php echo $modal ?>">
                                                        <button type='button' class='btn btn-warning btn-sm' <?php echo $disabled ?> id="edit_drugunit" data-id="<?= $drug_unit_id ?>" data-toggle="tooltip" title="แก้ไขข้อมูล"><i class="fas fa-edit" style="color:white;"></i></button>
                                                    </a>
                                                    <button type='button' class='<?= $color ?>' <?=$dis1 ?> <?=$dis3?> id="btn_remove_drugunit" data-toggle="tooltip" title="<?= $txt ?>" data-id="<?= $drug_unit_id ?>" data-status="<?= $drug_unit_status ?>" data-name="<?= $drug_unit_name ?>"><i class="<?= $image ?>" style="color:white"></i></button>
                                                </td>
                                            </tr>

                                            <!--- เริ่ม modal แก้ไข บรรจุภัณฑ์ --->
                                            <div id="edit<?php echo $drug_unit_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content" style="width: auto;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขข้อมูลประเภทหน่วย</h5>
                                                            <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                                                <h3>&times;</h3>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" method="post" id="myedit_drugunit<?= $drug_unit_id ?>">
                                                                <div class="row">
                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>รหัสประเภทหน่วย : </label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" id="edit_drug_unitid" name="edit_drug_unitid" value="<?php echo $drug_unit_id ?>" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>ชื่อประเภทหน่วย : </label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control edit_drug_unitname" id="edit_drug_unitname<?= $drug_unit_id ?>" data-id="<?= $drug_unit_id ?>" name="edit_drug_unitname" value="<?php echo $drug_unit_name ?>">
                                                                                </div>
                                                                            </div>
                                                                            <strong><span style="color:red"> *</span></strong>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group" align="right">
                                                                    <button type="button" class="btn btn-outline-success" name="btn_edit_drugunit" id="btn_edit_drugunit" re_drug_unit='<?= $drug_unit_id ?>'>บันทึก</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-6" align="left">
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-outline-danger" id="cancel_edit_drugunit" data-dismiss="modal">ยกเลิก</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>


                                    <?php
                                        } //end loop while
                                    } // end if
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><br>
            </div>

            <!--- เริ่ม modal บรรจุภัณฑ์ --->
            <div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="dialog_drugunit">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="width: auto;">
                        <div class="modal-header">
                            <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มประเภทหน่วย</h5>
                            <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                <h3>&times;</h3>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="post" id="add_unitdrug">
                                <div class="row">
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>รหัสประเภทหน่วย: </label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="add_drug_unit_id" value="<?php echo $ud_id ?>" name="add_drug_unit_id" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>ชื่อประเภทหน่วย : </label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="add_drug_unit_name" name="add_drug_unit_name" placeholder="ขวด/แกลลอน/ลัง/ถุง ฯลฯ">
                                                </div>
                                            </div>
                                            <strong><span style="color:red"> *</span></strong>
                                        </div>
                                    </div>


                                </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group" align="right">
                                    <button type="button" class="btn btn-outline-success" name="btn_unit_save" id="btn_unit_save">บันทึก</button>
                                </div>
                            </div>
                            <div class="col-6" align="left">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-danger" id="cancel_unit" data-dismiss="modal">ยกเลิก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>

            


            <?php
            //รหัสประเภทพันธุ์ไม้
            $sql_group = "SELECT Max(type_plant_id) as maxid FROM tb_typeplant";
            $datenow = strtotime(date("Y-m-d"));
            $d = date('Y', $datenow) + 543;
            $result = mysqli_query($conn, $sql_group);
            $row_mem = mysqli_fetch_assoc($result);
            $mem_old = $row_mem['maxid'];
            $tmp1 = "TYP"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
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

            $typid = $tmp1 . $sub_date . $a;

            ?>

            <!-- tap5 ประเภทพันธุ์ไม้-->
            <div class="tab-pane fade " id="tabs-icons-text-5" role="tabpanel" aria-labelledby="tabs-icons-text-5-tab">
                <div class="row">
                    <div class="col-12">

                        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#dialog_typeplant" id="btn_add_typeplant"><i class="ni ni-fat-add"></i> เพิ่มประเภทพันธุ์ไม้</button>
                        <br>
                        <br>


                        <!-- แสดงข้อมูลใน ตาราง -->
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered text-center" id="typeplantTable" width="100%">
                                    <thead bgcolor="#2dce89">
                                        <th>ลำดับ</th>
                                        <th>รหัสประเภทพันธุ์ไม้</th>
                                        <th>ชื่อประเภทพันธุ์ไม้</th>
                                        <th>สถานะ</th>
                                        <th></th>

                                    </thead>
                                    <?php
                                    $sql = "SELECT tb_typeplant.type_plant_id as type_plant_id,
                                                    tb_typeplant.type_plant_name as type_plant_name,

                                                    tb_typeplant.type_plant_status as type_plant_status

                                                 
                                    FROM  tb_typeplant
                                    ORDER BY type_plant_id ASC";



                                    $result = mysqli_query($conn, $sql);
                                    if ($result->num_rows > 0) {
                                        $i = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            $i++;

                                            $typeplant_id = $row['type_plant_id'];
                                            $typeplant_name = $row['type_plant_name'];
  
                                            $typeplant_status = $row['type_plant_status'];

                                            //---  เช็ค remove  --//
                                            $sql2 = "SELECT * FROM tb_typeplant
                                            INNER JOIN tb_plant ON   tb_plant.ref_type_plant =  tb_typeplant.type_plant_id
                                            WHERE tb_typeplant.type_plant_id='$typeplant_id' AND tb_plant.plant_status='ปกติ'";
                                            $res = mysqli_query($conn, $sql2);
                                            if ($rows = $res->num_rows > 0) {
                                                $dis1 = "disabled";
                                            } else {
                                                $dis1 = "";
                                            }

                                    ?>

                                            <tr onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)" style="text-align: center;">
                                                <td>
                                                    <?php echo $i; ?></td>
                                                <td>
                                                    <?php echo $typeplant_id; ?>
                                                </td>
                                                <td>
                                                    <?php echo $typeplant_name; ?>
                                                </td>
                                     

                                                <td <?php if ($typeplant_status == 'ระงับ') {
                                                        echo 'style="color:red"';
                                                    } ?>>
                                                    <?php echo $typeplant_status; ?>
                                                </td>

                                                <?php
                                                if ($typeplant_status ==  'ปกติ') {
                                                    $image = 'fas fa-times';
                                                    $color = "btn btn-danger  btn-sm";
                                                    $txt = "ยกเลิกข้อมูลประเภทพันธุ์ไม้";
                                                    $disabled = "";
                                                    $modal = "modal";
                                                } else if ($typeplant_status == 'ระงับ') {
                                                    $image = 'fas fa-check';
                                                    $color = "btn btn-success btn-sm";
                                                    $txt = "ยกเลิกการระงับข้อมูลประเภทพันธุ์ไม้";
                                                    $disabled = "disabled";
                                                    $modal = "";
                                                }
                                                ?>
                                                <td style="text-align: center;">
                                                    <!--- ปุ่มแก้ไข --->
                                                    <a href="#edit<?php echo $typeplant_id; ?>" data-toggle="<?php echo $modal ?>">
                                                        <button type='button' class='btn btn-warning btn-sm ' <?php echo $disabled ?> id="modal_edit_typeplant" data-toggle="tooltip" title="แก้ไขข้อมูล" data="<?= $typeplant_id ?>" date_at="<?= $update_at ?>"><i class="fas fa-edit" style="color:white;"></i></button>
                                                    </a>

                                                    <!--- ปุ่มยกเลิก --->
                                                    <button type='button' id="btn_remove_typeplant" class='<?= $color ?>' <?php echo $dis1; ?> data-toggle="tooltip" title="<?= $txt ?>" data-id="<?= $typeplant_id ?>" data-status="<?= $typeplant_status ?>" data-name="<?= $typeplant_name ?>"><i class="<?= $image ?>" style="color:white"></i></span></button>
                                                </td>
                                            </tr>

                                            <!--- เริ่ม modal แก้ไข  --->
                                            <div id="edit<?php echo $typeplant_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content" style="width: auto;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขข้อมูลประเภทพันธุ์ไม้</h5>
                                                            <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                                                <h3>&times;</h3>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" method="post" action="" id="edit_typeplant<?= $typeplant_id ?>">

                                                                <div class="row">
                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>รหัสประเภทพันธุ์ไม้ : </label>
                                                                            </div>
                                                                            <div class="col-6">

                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" id="edit_typeplant_id<?= $typeplant_id ?>" name="edit_typeplant_id" value="<?= $typeplant_id ?>" readonly>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>ชื่อประเภทพันธุ์ไม้ : </label>
                                                                            </div>
                                                                            <div class="col-6">

                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control edittypeplantname" id="edit_typeplant_name<?= $typeplant_id ?>" name="edit_typeplant_name" value="<?= $typeplant_name ?>" data-id="<?= $typeplant_id ?>">
                                                                                </div>
                                                                            </div>
                                                                            <span style="color:red"> *</span>
                                                                        </div>
                                                                    </div>

                                                                   

                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group" align="right">
                                                                            <button type="button" class="btn btn-outline-success" name="btn_save_edit_typeplant" id="btn_save_edit_typeplant" data-id="<?= $typeplant_id ?>">บันทึก</button>
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
                        </div>


                        <!--- เริ่ม modal เพิ่มประเภทพันธุ์ไม้ --->
                        <div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="dialog_typeplant">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="width: auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มประเภทพันธุ์ไม้</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                            <h3>&times;</h3>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" method="post" id="add_typeplant">
                                            <div class="row">

                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รหัสประเภทพันธุ์ไม้ : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="insert_type_plant_id" name="insert_type_plant_id" value="<?= $typid ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ชื่อประเภทพันธุ์ไม้ : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control typeplantname" id="insert_type_plant_name" name="insert_type_plant_name" placeholder="กรุณากรอกข้อมูล">
                                                            </div>
                                                        </div>
                                                        <span style="color:red"> *</span>
                                                    </div>
                                                </div>

                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group" align="right">
                                                <button type="button" class="btn btn-outline-success" name="btn_save_typeplant" id="btn_save_typeplant">บันทึก</button>
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
                        <!--จบ tab5 ประเภทพันธุ์ไม้-->


                    </div>
                </div>
            </div>

            <?php
            //รหัสประเภทวัสดุปลูก
            $sql_group = "SELECT Max(type_material_id) as maxid FROM tb_type_material";
            $datenow = strtotime(date("Y-m-d"));
            $d = date('Y', $datenow) + 543;
            $result = mysqli_query($conn, $sql_group);
            $row_mem = mysqli_fetch_assoc($result);
            $mem_old = $row_mem['maxid'];
            $tmp1 = "TYM"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
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

            $tymid = $tmp1 . $sub_date . $a;

            ?>

            <!-- tap6 ประเภทวัสดุปลูก-->
            <div class="tab-pane fade " id="tabs-icons-text-6" role="tabpanel" aria-labelledby="tabs-icons-text-6-tab">
                <div class="row">
                    <div class="col-12">

                        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#dialog_typematerial" id="btn_add_type_material"><i class="ni ni-fat-add"></i> เพิ่มประเภทวัสดุปลูก</button>
                        <br>
                        <br>


                        <!-- แสดงข้อมูลใน ตาราง -->
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered text-center" id="typematerialTable" width="100%">
                                    <thead bgcolor="#2dce89">
                                        <th>ลำดับ</th>
                                        <th>รหัสประเภทวัสดุปลูก</th>
                                        <th>ชื่อประเภทวัสดุปลูก</th>
                                   <!--      <th>หน่วย</th> -->
                                        <th>สถานะ</th>
                                        <th></th>

                                    </thead>
                                    <?php
                                    $sql = "SELECT  tb_type_material.type_material_id as type_material_id,
                                                    tb_type_material.type_material_name as type_material_name,
                                                    tb_type_material.type_material_status as type_material_status
                                                 

                                                 
                                    FROM  tb_type_material
                            
                                    ORDER BY type_material_id ASC";



                                    $result = mysqli_query($conn, $sql);
                                    if ($result->num_rows > 0) {
                                        $i = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            $i++;

                                            $typematerial_id = $row['type_material_id'];
                                            $typematerial_name = $row['type_material_name'];
                                            $typematerial_status = $row['type_material_status'];
                                            

                                            //---  เช็ค remove  --//
                                            $sql2 = "SELECT * FROM tb_type_material
                                            INNER JOIN tb_material ON   tb_material.ref_type_material =  tb_type_material.type_material_id
                                            WHERE tb_type_material.type_material_id='$typematerial_id' AND tb_material.material_status='ปกติ'";
                                            $res = mysqli_query($conn, $sql2);
                                            if ($rows = $res->num_rows > 0) {
                                                $dis1 = "disabled";
                                            } else {
                                                $dis1 = "";
                                            }


                                    ?>

                                            <tr onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)" style="text-align: center;">
                                                <td>
                                                    <?php echo $i; ?></td>
                                                <td>
                                                    <?php echo $typematerial_id; ?>
                                                </td>
                                                <td>
                                                    <?php echo $typematerial_name; ?>
                                                </td>
                                             <!--    <td>
                                                    <?php /* echo $drug_unit_name; */ ?>
                                                </td> -->

                                                <td <?php if ($typematerial_status == 'ระงับ') {
                                                        echo 'style="color:red"';
                                                    } ?>>
                                                    <?php echo $typematerial_status; ?>
                                                </td>

                                                <?php
                                                if ($typematerial_status ==  'ปกติ') {
                                                    $image = 'fas fa-times';
                                                    $color = "btn btn-danger  btn-sm";
                                                    $txt = "ยกเลิกข้อมูลประเภทวัสดุปลูก";
                                                    $disabled = "";
                                                    $modal = "modal";
                                                } else if ($typematerial_status == 'ระงับ') {
                                                    $image = 'fas fa-check';
                                                    $color = "btn btn-success btn-sm";
                                                    $txt = "ยกเลิกการระงับข้อมูลประเภทวัสดุปลูก";
                                                    $disabled = "disabled";
                                                    $modal = "";
                                                }
                                                ?>
                                                <td style="text-align: center;">
                                                    <!--- ปุ่มแก้ไข --->
                                                    <a href="#edit<?php echo $typematerial_id; ?>" data-toggle="<?php echo $modal ?>">
                                                        <button type='button' class='btn btn-warning btn-sm ' <?php echo $disabled ?> id="edit_type_material" data-toggle="tooltip" title="แก้ไขข้อมูลประเภทวัสดุปลูก" typematerial="<?= $typematerial_id ?>" date_at="<?= $update_at ?>"><i class="fas fa-edit" style="color:white;"></i></button>
                                                    </a>

                                                    <!--- ปุ่มยกเลิก --->
                                                    <button type='button' id="btn_remove_type_material" class='<?= $color ?>' <?php echo $dis1; ?> data-toggle="tooltip" title="<?= $txt ?>" data-id="<?= $typematerial_id ?>" data-status="<?= $typematerial_status ?>" data-name="<?= $typematerial_name ?>"><i class="<?= $image ?>" style="color:white"></i></span></button>
                                                </td>
                                            </tr>

                                            <!--- เริ่ม modal แก้ไข  --->
                                            <div id="edit<?php echo $typematerial_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content" style="width: auto;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขข้อมูลประเภทวัสดุปลูก</h5>
                                                            <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                                                <h3>&times;</h3>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" method="post" action="" id="edit_typematerial">

                                                                <div class="row">
                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>รหัสประเภทวัสดุปลูก : </label>
                                                                            </div>
                                                                            <div class="col-6">

                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" id="edit_type_material_id<?= $typematerial_id ?>" name="edit_type_material_id" value="<?= $typematerial_id ?>" readonly>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>ชื่อประเภทวัสดุปลูก : </label>
                                                                            </div>
                                                                            <div class="col-6">

                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control edittypematerialname" id="edit_type_material_name<?= $typematerial_id ?>" name="edit_type_material_name" value="<?= $typematerial_name ?>" data-id="<?= $typematerial_id ?>">
                                                                                </div>
                                                                            </div>
                                                                            <span style="color:red"> *</span>
                                                                        </div>
                                                                    </div>



                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group" align="right">
                                                                            <button type="button" class="btn btn-outline-success" name="btn_save_edit_material" id="btn_save_edit_material" data-id="<?= $typematerial_id ?>">บันทึก</button>
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
                        </div>


                        <!--- เริ่ม modal เพิ่มประเภทวัสดุปลูก --->
                        <div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="dialog_typematerial">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="width: auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มประเภทวัสดุปลูก</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                            <h3>&times;</h3>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" method="post" id="add_type_material">
                                            <div class="row">

                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รหัสประเภทวัสดุปลูก : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="insert_type_material_id" name="insert_type_material_id" value="<?= $tymid ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ชื่อประเภทวัสดุปลูก : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control typematerialname" id="insert_type_material_name" name="insert_type_material_name" placeholder="กรุณากรอกข้อมูล">
                                                            </div>
                                                        </div>
                                                        <span style="color:red"> *</span>
                                                    </div>
                                                </div>

                                               <!--  <div class="col-sm-11">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>ประเภทหน่วย : </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <select name="insert_type_material_smunit" class="form-control insert_type_material_smunit" id="insert_type_material_smunit">
                                                                    <option value="0">----โปรดเลือกประเภทหน่วย----</option>
                                                                    <?php
                                                                    $sql_type1 = "SELECT * FROM tb_drug_unit WHERE drug_unit_status ='ปกติ' AND drug_unit_name != 'แกลลอน' AND drug_unit_name != 'ขวด'
                                                                    ORDER BY drug_unit_id ASC";
                                                                    $re_type1 = mysqli_query($conn, $sql_type1);
                                                                    while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                                                    ?>
                                                                        <option value="<?php echo $re_fac1["drug_unit_id"]; ?>">
                                                                            <?php echo $re_fac1["drug_unit_name"]; ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <strong><span style="color:red"> *</span></strong>
                                                    </div>
                                                </div> -->
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group" align="right">
                                                <button type="button" class="btn btn-outline-success" name="btn_save_type_material" id="btn_save_type_material">บันทึก</button>
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
                        <!--จบ tab6 ประเภทวัสดุปลูก-->

                    </div>
                </div>
            </div>
            <?php
            $sql_group = "SELECT Max(grade_id) as maxid FROM tb_grade";
            $result = mysqli_query($conn, $sql_group);
            $row_mem = mysqli_fetch_assoc($result);
            $mem_old = $row_mem['maxid'];
            $tmp1 = "G"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
            $tmp2 = substr($mem_old, 1, 2);
            $tmp2 = intval($tmp2);
            $t = $tmp2 + 1;
            $a = sprintf("%02d", $t);

            $run_grade_id = $tmp1 . $a;
            ?>
            <!-- tap7 หน่วย-->
            <div class="tab-pane fade " id="tabs-icons-text-7" role="tabpanel" aria-labelledby="tabs-icons-text-7-tab">
                <div class="row">
                    <div class="col-12">

                        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#modal_grade" id="modal_add_grade" onclick="add_grade()"><i class="ni ni-fat-add"></i> เพิ่มเกรดพันธุ์ไม้</button>
                        <br>
                        <br>

                        <!-- แสดงข้อมูลใน ตาราง -->
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered text-center " id="gradeTable" width="100%">
                                    <thead bgcolor="#2dce89">
                                        <th>ลำดับ</th>
                                        <th>รหัสเกรด</th>
                                        <th>ชื่อเกรด</th>
                                        <th>สถานะ</th>
                                        <th></th>
                                    </thead>
                                    <?php

                                    $sql = "SELECT * FROM tb_grade ";



                                    $result = mysqli_query($conn, $sql);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        $i = 0;

                                        while ($row = $result->fetch_assoc()) {
                                            $i++;
                                            $grade_id = $row['grade_id'];
                                            $grade_name = $row['grade_name'];
                                            $grade_status = $row['grade_status'];


                                            $sql2 = "SELECT * FROM tb_plant
                                            LEFT JOIN tb_plant_detail ON tb_plant_detail.ref_plant_id = tb_plant.plant_id
                                            WHERE tb_plant.plant_status ='ปกติ' AND tb_plant_detail.ref_grade_id = '$grade_id' AND tb_plant_detail.plant_detail_status = 'ปกติ'
                                            GROUP BY tb_plant_detail.ref_grade_id";
                                            $res = mysqli_query($conn, $sql2);
                                            if ($rows = $res->num_rows > 0) {
                                                $dis1 = "disabled";
                                            } else {
                                                $dis1 = "";
                                            }


                                    ?>
                                            <tr onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                <td>
                                                    <?php echo $grade_id; ?>
                                                </td>
                                                <td>
                                                    <?php echo $grade_name; ?>
                                                </td>

                                                <td <?php if ($grade_status == 'ระงับ') {
                                                        echo "style='color:red'";
                                                    } ?>>
                                                    <?php echo $grade_status; ?>
                                                </td>

                                                <?php
                                                if ($grade_status == 'ปกติ') {
                                                    $image = 'fas fa-times';
                                                    $color = "btn btn-danger btn-sm";
                                                    $txt = "ยกเลิกข้อมูล";
                                                    $disabled = "";
                                                    $modal = "modal";
                                                } else if ($grade_status == 'ระงับ') {
                                                    $image = 'fas fa-check';
                                                    $color = "btn btn-success btn-sm";
                                                    $txt = "ยกเลิกการระงับ";
                                                    $disabled = "disabled";
                                                    $modal = "";
                                                }
                                                ?>
                                                <td class="a">
                                                    <a href="#edit_grade<?php echo $grade_id; ?>" data-toggle="<?php echo $modal ?>">
                                                        <button type='button' class='btn btn-warning btn-sm ' id="edit_grades" <?php echo $disabled ?> data-id="<?= $grade_id ?>" data-toggle="tooltip" title="แก้ไขข้อมูล"><i class="fas fa-edit" style="color:white;"></i></button>
                                                    </a>
                                                    <button type='button' class='<?= $color ?>' id="btn_remove_grade" <?php echo $dis1; ?> data-toggle="tooltip" title="<?= $txt ?>" data-id="<?= $grade_id ?>" data-status="<?= $grade_status ?>" data-name="<?= $grade_name ?>"><i class="<?= $image ?>" style="color:white"></i></button>

                                                </td>
                                            </tr>

                                            <!--- เริ่ม modal แก้ไข หน่วย --->
                                            <div id="edit_grade<?php echo $grade_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content" style="width: auto;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title card-title"><i class="fas fa-edit"></i></i> แก้ไขข้อมูลเกรดพันธุ์ไม้</h5>
                                                            <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                                                <h3>&times;</h3>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" method="post" id="edit_gradeForm<?= $grade_id ?>">
                                                                <div class="row">
                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>รหัสเกรด : </label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" id="edit_grade_id" name="edit_grade_id" value="<?php echo $grade_id ?>" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-11">
                                                                        <div class="row">
                                                                            <div class="col-4" align="right">
                                                                                <label>ชื่อเกรด : </label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control edit_grade_name" id="edit_grade_name<?= $grade_id ?>" data-id="<?= $grade_id ?>" oninput="javascript:this.value=this.value.toUpperCase();" name="edit_grade_name" value="<?php echo $grade_name ?>">
                                                                                </div>
                                                                            </div>
                                                                            <span style="color:red"> *</span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group" align="right">
                                                                    <button type="button" class="btn btn-outline-success" name="btn_save_edit_grade" id="btn_save_edit_grade" data-id='<?= $grade_id ?>'>บันทึก</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-6" align="left">
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-outline-danger" id="cancel_edit_grade" data-dismiss="modal">ยกเลิก</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>


                                    <?php
                                        } //end loop while
                                    } // end if
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><br>
            </div>

            <!--- เริ่ม modal เพิ่มหน่วย --->
            <div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_grade">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="width: auto;">
                        <div class="modal-header">
                            <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มเกรดพันธุ์ไม้</h5>
                            <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                <h3>&times;</h3>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="post" id="add_grade">
                                <div class="row">
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>รหัสเกรด : </label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="in_grade_id" value="<?php echo $run_grade_id ?>" name="in_grade_id" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-4" align="right">
                                                <label>ชื่อเกรด : </label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="in_grade_name" name="in_grade_name" oninput="javascript:this.value=this.value.toUpperCase();" placeholder="กรุณากรอกข้อมูล">
                                                </div>
                                            </div>
                                            <span style="color:red"> *</span>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group" align="right">
                                    <button type="button" class="btn btn-outline-success" name="btn_save_in_grade" id="btn_save_in_grade">บันทึก</button>
                                </div>
                            </div>
                            <div class="col-6" align="left">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-danger" id="cancel_grade" data-dismiss="modal">ยกเลิก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>

            <!--จบ tab4 หน่วยย่อย-->

            <script>
                function add_typedrug() {
                    document.getElementById("add_drugtype").reset();
                }

                function add_groupdrug() {
                    document.getElementById("add_groupdrug").reset();
                }

                function add_drugunit() {
                    document.getElementById("add_unitdrug").reset();
                }

                function add_drugsmunit() {
                    document.getElementById("add_smunitdrug").reset();
                }

                function add_grade() {
                    document.getElementById("add_grade").reset();
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