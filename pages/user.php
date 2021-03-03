<?php

include('connect.php');
@session_start();
$emp = $_SESSION['emp_id'];
$permis = $_SESSION['userlevel'];

//รันรหัสพนักงาน
date_default_timezone_set("Asia/Bangkok");
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$sqlm = "SELECT max(emp_id) as Maxid  FROM tb_user";
$result = mysqli_query($conn, $sqlm);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['Maxid'];
//M003
$tmp1 = "EMP"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp2 = substr($mem_old, 5, 6);
$Year = substr($mem_old, 3, 2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp2 = 0;
    //$sub_date = $sub_date + 1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;
$a = sprintf("%03d", $t);
$empi = $tmp1 . $sub_date . $a;

//run id address
$sql_addr = "SELECT max(address_id) as Maxid  FROM tb_address";
$re_addr = mysqli_query($conn, $sql_addr);
$row_addr = mysqli_fetch_assoc($re_addr);
$addr_old = $row_addr['Maxid'];
//M003
$tmp4 = substr($addr_old, 0, 3); //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp5 = substr($addr_old, 5, 6);
$Year = substr($addr_old, 3, 2);
$sub_date = substr($d, 2, 3);
if ($Year != $sub_date) {
    $tmp5 = 0;
    //$sub_date = $sub_date + 1;
} else {
    $tmp5;
}
$c = $tmp5 + 1;
$b = sprintf("%03d", $c);
$id_address = $tmp4 . $sub_date . $b;


?>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
    function autoTab(obj) {

        var pattern = new String("_-____-_____-__-_"); // กำหนดรูปแบบในนี้
        var pattern_ex = new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
        var returnText = new String("");
        var obj_l = obj.value.length;
        var obj_l2 = obj_l - 1;
        var elem = document.getElementById('cardid').value;
        var id = elem.length;

        if (!elem.match(/^([0-9 -])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวเลขเท่านั้น",
                icon: "warning",
                button: false,
            });
            document.getElementById('cardid').value = "";
            return false;
        } else {
            for (i = 0; i < pattern.length; i++) {
                if (obj_l2 == i && pattern.charAt(i + 1) == pattern_ex) {
                    returnText += obj.value + pattern_ex;
                    obj.value = returnText;
                }
            }
            if (obj_l >= pattern.length) {
                obj.value = obj.value.substr(0, pattern.length);
            }
        }

    }

    function autoTab_edit(obj) {
        var pattern = new String("_-____-_____-__-_"); // กำหนดรูปแบบในนี้
        var pattern_ex = new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
        var returnText = new String("");
        var obj_l = obj.value.length;
        var obj_l2 = obj_l - 1;
        var elem = document.getElementsByName("edit_idcard").value;
        var id = elem.length;


        for (i = 0; i < pattern.length; i++) {
            if (obj_l2 == i && pattern.charAt(i + 1) == pattern_ex) {
                returnText += obj.value + pattern_ex;
                obj.value = returnText;
            }
        }
        if (obj_l >= pattern.length) {
            obj.value = obj.value.substr(0, pattern.length);
        }

    }
</script>




<!--ปุ่มเพิ่มข้อมูลพนักงาน-->

<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target=".bd-example-modal-lg" id="modal_add_emp"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลพนักงาน</button>
    </div>
</div><br>



<!--ส่วนของการค้นหา แสดงตาราง-->

<div class="row">
    <div class="col-12">
        <table class="table table-bordered text-center" id="userTable" width="100%">
            <thead bgcolor="#2dce89">
                <th>ลำดับ</th>
                <th>รหัสพนักงาน</th>
                <th>ชื่อ-นามสกุล</th>
                <th>เพศ</th>
                <!-- <th>การเข้าใช้งาน</th> -->
                <th>สถานะ</th>
                <th class="sta"></th>
            </thead>

            <?php

            $sql = "SELECT emp_id,firstname,lastname,sex,card_id,telephone,emp_status,picture,tb_user_detail.userlevel as level 
        ,tb_user.address_id AS add_id 
        ,tb_address.address_id AS address_id
        ,tb_address.address_home AS home
        ,tb_address.address_swine AS swine
        ,tb_address.address_alley AS alley
        ,tb_address.address_road AS road
        ,tb_address.address_subdistrict AS subdistrict
        ,tb_address.address_district AS district
        ,tb_address.address_province AS province
        ,tb_address.address_zipcode AS zipcode
        FROM tb_user
        INNER JOIN tb_address ON tb_user.address_id = tb_address.address_id
        LEFT JOIN tb_user_detail ON tb_user_detail.ref_emp_id=tb_user.emp_id
        ORDER BY tb_user.emp_id ASC";



            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                // output data of each row
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $i++;
                    $empid = $row['emp_id'];
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $sex = $row['sex'];
                    $emp_status = $row['emp_status'];
                    $card_id = $row['card_id'];
                    $telephone = $row['telephone'];
                    $userlevel = $row['level'];


                    if ($userlevel == '') {
                        $userlevel = "ยังไม่กำหนดสิทธิ์";
                    } else {
                        $userlevel;
                    }
                    $picture = $row['picture'];

                    $address_id = $row['address_id'];
                    $address_home = $row['home'];
                    $address_swine = $row['swine'];
                    $address_alley = $row['alley'];
                    $address_road = $row['road'];
                    $address_subdistrict = $row['subdistrict'];
                    $address_district = $row['district'];
                    $address_province = $row['province'];
                    $address_zipcode = $row['zipcode'];





            ?>
                    <tr onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)" style="text-align: center;">
                        <td>
                            <?php echo $i; ?>

                        <td>
                            <?php echo $empid; ?>
                        </td>
                        <td>
                            <?php echo $firstname . " " . $lastname; ?>
                        </td>
                        <td>
                            <?php echo $sex; ?>
                        </td>
                        <!--  <td>
                            <?php /* echo $userlevel;  */ ?>
                        </td> -->
                        <td <?php if ($emp_status == 'ระงับ') {
                                echo 'style="color:red"';
                            } ?>>
                            <?php echo $emp_status; ?>
                        </td>

                        <?php
                        if ($emp_status == 'ปกติ') {
                            $image = 'fas fa-times';
                            $color = "btn btn-danger btn-sm";
                            $txt = "ยกเลิกข้อมูล";
                        } else if ($emp_status == 'ระงับ') {
                            $image = 'fas fa-check';
                            $color = "btn btn-success btn-sm";
                            $txt = "ยกเลิกการระงับ";
                        }


                        if ($empid == $emp) {
                            $dis = "disabled";
                            $modal = "";
                        } else {
                            $dis = "";
                            $modal = "modal";
                        }


                        ?>

                        <td class="sta" width="20%">

                            <a href="#view<?php echo $empid; ?>" data-toggle="modal">
                                <button type='button' class='btn btn-sm' id="view" style="background-color:#FFCC00;" data-toggle="tooltip" title="แสดงข้อมูล"><i class="fas fa-search-plus"></i></button>
                            </a>
                            <a href="#edit<?php echo $empid; ?>" data-toggle="modal">
                                <button type='button' class='btn btn-warning btn-sm edits' id="edits" data="<?= $empid ?>" data-toggle="tooltip" title="แก้ไขข้อมูล"><i class="fas fa-edit" style="color:white"></i></button>
                            </a>

                            <button type='submit' id="btn_remove_emp" <?php echo $dis; ?> class='<?= $color ?>' data-toggle="tooltip" title="<?= $txt ?>" data-id="<?= $empid ?>" data-status="<?= $emp_status ?>" data-name="<?= $firstname . ' ' . $lastname ?>"><i class="<?= $image ?>" style="color:white"></i></span></button>
                        </td>
                    </tr>

                    <!--เริ่ม modal แสดงข้อมูล View-->
                    <div id="view<?php echo $empid; ?>" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                        <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title card-title"><i class="fas fa-search-plus"></i> แสดงข้อมูลพนักงาน</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                            <h3>&times;</h3>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="edit_item_id" value="<?php echo $empid; ?>">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-4" align="right">
                                                        <label>รหัสพนักงาน : </label>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="view_empid" readonly value="<?php echo $empid ?>" name="view_empid">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4" align="right">
                                                        <label>ชื่อ : </label>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="view_firstname" readonly name="view_firstname" value="<?php echo $firstname; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4" align="right">
                                                        <label>นามสกุล : </label>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="view_lastname" readonly name="view_lastname" value="<?php echo $lastname; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4" align="right">
                                                        <label>เลขบัตรประชาชน : </label>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="view_card_id" readonly value="<?php echo $card_id; ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-4" align="right">
                                                        <label>เพศ : </label>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="gender" class="custom-control-input" id="view_men" type="radio" readonly value="ชาย" <?php if ($sex == 'ชาย') {
                                                                                                                                                                    echo "checked";
                                                                                                                                                                }
                                                                                                                                                                ?>>
                                                            <label class="custom-control-label" for="men">ชาย </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="gender" class="custom-control-input" id="view_women" type="radio" readonly value="หญิง" <?php if ($sex == 'หญิง') {
                                                                                                                                                                        echo "checked";
                                                                                                                                                                    }
                                                                                                                                                                    ?>>
                                                            <label class="custom-control-label" for="women">หญิง </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-4" align="right">
                                                        <label>เบอร์โทร : </label>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="view_telephone" readonly name="view_telephone" value="<?php echo $telephone; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <img src="image/emp/<?php echo $picture ?>" width="200" height="300" class="a" style="object-fit: fill;  border-radius: 8px;" align="center"><br><br>
                                            </div>
                                            <div class="modal-header">
                                                <h5 class="modal-title card-title"><i class="ni ni-shop"></i> ข้อมูลที่อยู่</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-2" align="right">
                                                        <label>บ้านเลขที่ : </label>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="view_address_home" readonly name="view_address_home" value="<?php echo $address_home; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-2" align="right">
                                                        <label>หมู่ที่ : </label>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="view_address_swine" readonly name="view_address_swine" value="<?php echo $address_swine; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-2" align="right">
                                                        <label>ซอย : </label>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="view_alley" readonly name="view_alley" value="<?php echo $address_alley; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-2" align="right">
                                                        <label>ถนน : </label>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="view_road" readonly name="view_road" value="<?php echo $address_road; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-2" align="right">
                                                        <label>แขวง/ตำบล : </label>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" readonly id="view_subdistrict" value="<?php echo $address_subdistrict; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-2" align="right">
                                                        <label>เขต/อำเภอ : </label>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" readonly id="view_district" value="<?php echo $address_district; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-2" align="right">
                                                        <label>จังหวัด : </label>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" disabled id="view_province" name="view_province" value="<?php echo $address_province; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-2" align="right">
                                                        <label>รหัสไปรษณีย์ : </label>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" disabled id="view_zipcode" name="view_zipcode" value="<?php echo $address_zipcode; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="address_id" name="address_id" value="<?php echo $address_id ?>">
                                    </div>
                                </div>
                        </form>
                    </div>
    </div>
    <!-- จบ modal แสดงข้อมูลพนักงาน -->


    <!-- เริ่ม modal แก้ไขข้อมูลพนักงาน -->
    <div id="edit<?php echo $empid; ?>" class="modal fade edit_emp" role="dialog">
        <form method="post" class="form-horizontal Update" role="form" enctype="multipart/form-data" data='<?= $empid ?>' id="edit_emps<?= $empid ?>" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="width: autopx;">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขข้อมูลพนักงาน</h5>
                        <button type="button" class="close " data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_item_id" value="<?php echo $empid; ?>">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-4" align="right">
                                        <label>รหัสพนักงาน : </label>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_empid" id="edit_empid<?= $empid ?>" name="edit_empid" readonly value="<?php echo $empid ?>" name="empid">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4" align="right">
                                        <label>ชื่อ : </label>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_firstname" id="edit_firstname<?= $empid ?>" data-id="<?= $empid ?>" name="edit_firstname" value="<?php echo $firstname; ?>">

                                        </div>
                                    </div>
                                    <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                                </div>
                                <div class="row">
                                    <div class="col-4" align="right">
                                        <label>นามสกุล : </label>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_lastname" id="edit_lastname<?= $empid ?>" data-id="<?= $empid ?>" name="edit_lastname" value="<?php echo $lastname; ?>">
                                        </div>

                                    </div>
                                    <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                                </div>
                                <div class="row">
                                    <div class="col-4" align="right">
                                        <label>เลขบัตรประจำตัวประชาชน : </label>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_cardid" id="a<?= $empid ?>" data-id="<?= $empid ?>" name="edit_cardid" onkeyup="autoTab_edit(this)" value="<?php echo $card_id; ?>">
                                        </div>
                                    </div>
                                    <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                                </div>
                                <div class="row">
                                    <div class="col-4" align="right">
                                        <label>เพศ : </label>
                                    </div>
                                    <div class="col-2">
                                        <div class="custom-control custom-radio mb-3">
                                            <input name="edit_gender" class="custom-control-input" id="edit_M<?= $empid ?>" type="radio" value="ชาย" <?php if ($sex == 'ชาย') {
                                                                                                                                                            echo "checked";
                                                                                                                                                        }
                                                                                                                                                        ?>>
                                            <label class="custom-control-label" for="edit_M<?= $empid ?>">ชาย </label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="custom-control custom-radio mb-3">
                                            <input name="edit_gender" class="custom-control-input" id="edit_F<?= $empid ?>" type="radio" value="หญิง" <?php if ($sex == 'หญิง') {
                                                                                                                                                            echo "checked";
                                                                                                                                                        }
                                                                                                                                                        ?>>
                                            <label class="custom-control-label" for="edit_F<?= $empid ?>">หญิง </label>
                                        </div>
                                    </div>
                                    <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                                </div>





                                <div class="row">
                                    <div class="col-4" align="right">
                                        <label>เบอร์โทร : </label>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_telephone " id="edit_telephone<?= $empid ?>" data-id="<?= $empid ?>" name="edit_telephone" value="<?php echo $telephone; ?>">
                                        </div>
                                    </div>
                                    <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput" align="center">
                                    <div style="cursor:pointer;">
                                        <img src="image/emp/<?php echo $picture ?>" width="200" style="object-fit: fill;  border-radius: 8px;" height="250" align="center" class="edit_img" id="edit_img<?= $empid ?>"><br><br>
                                        <input type="file" name="fileUpload" id="fileUpload<?= $empid ?>" class="fileUpload" style="display:none" accept="image/*">
                                        <span class="show_pic_edit">(เลือกไฟล์รูปภาพ)</span>
                                    </div>
                                </div>
                                <span id="showspan<?= $empid ?>"></span>

                            </div>

                            <div class="modal-header">
                                <h5 class="modal-title card-title"><i class="ni ni-shop"></i> ข้อมูลที่อยู่</h5>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-2" align="right">
                                        <label>บ้านเลขที่ : </label>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_address_home" id="edit_address_home<?= $empid ?>" name="edit_address_home" value="<?php echo $address_home; ?>">
                                        </div>
                                    </div>
                                    <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                                    <div class="col-2" align="right">
                                        <label>หมู่ที่ : </label>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_address_swine" id="edit_address_swine<?= $empid ?>" name="edit_address_swine" value="<?php echo $address_swine; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2" align="right">
                                        <label>ซอย : </label>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_address_alley" id="edit_address_alley<?= $empid ?>" name="edit_address_alley" value="<?php echo $address_alley; ?>">
                                        </div>
                                    </div>
                                    <div class="col-2" align="right">
                                        <label>ถนน : </label>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_address_road" id="edit_address_road<?= $empid ?>" name="edit_address_road" value="<?php echo $address_road; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2" align="right">
                                        <label>แขวง/ตำบล : </label>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control  com_district edit_address_subdistrict" name="edit_address_subdistrict" id="edit_address_subdistrict<?= $empid ?>" value="<?php echo $address_subdistrict; ?>">
                                        </div>
                                    </div>
                                    <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                                    <div class="col-2" align="right">
                                        <label>เขต/อำเภอ : </label>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_address_district com_amphoe" id="edit_address_district<?= $empid ?>" name="edit_address_district" value="<?php echo $address_district; ?>">
                                        </div>
                                    </div>
                                    <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                                </div>
                                <div class="row">
                                    <div class="col-2" align="right">
                                        <label>จังหวัด : </label>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_address_province com_province" id="edit_address_province<?= $empid ?>" name="edit_address_province" value="<?php echo $address_province; ?>">
                                        </div>
                                    </div>
                                    <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                                    <div class="col-2" align="right">
                                        <label>รหัสไปรษณีย์ : </label>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control edit_address_zipcode com_zipcode" id="edit_address_zipcode<?= $empid ?>" name="edit_address_zipcode" value="<?php echo $address_zipcode; ?>">
                                        </div>
                                    </div>
                                    <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="edit_address_id<?= $empid ?>" name="edit_address_id" value="<?php echo $address_id ?>">
                        <input type="hidden" class='hd_subdistrict<?= $empid ?>' id="hd_subdistrict<?= $empid ?>" name="hd_subdistrict">
                        <input type="hidden" class='hd_district<?= $empid ?>' id="hd_district<?= $empid ?>" name="hd_district">
                        <input type="hidden" class='hd_province<?= $empid ?>' id="hd_province<?= $empid ?>" name="hd_province">
                        <input type="hidden" class='hd_zipcode<?= $empid ?>' id="hd_zipcode<?= $empid ?>" name="hd_zipcode">
                        <center><span class="error_spec_edit"></span></center>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group" align="right">
                                    <button type="submit" class="btn btn-outline-success update_emp" name="btn_update_emp" data="<?= $empid ?>" data-id="<?php echo $address_id ?>" id="btn_update_emp">บันทึก</button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="button" data-dismiss="modal" class="btn btn-outline-danger">ยกเลิก</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="delete_id" name="delete_id" value="<?php echo $empid ?>">
                    </div>
                </div>
            </div>
    </div>
    </form>
</div>
<!-- จบ modal แก้ไขข้อมูลพนักงาน -->

<?php
                } // while loop
            } // end if
?>
</table>
</div>
</div>


<!-- เริ่ม modal เพิ่มข้อมูลพนักงาน -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lgg">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลพนักงาน</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" class="insert" method="post" id="myForm">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รหัสพนักงาน : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="empid" placeholder="รหัสพนักงาน" readonly value="<?php echo $empi ?>" name='empid'>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ชื่อ : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control firstname" id="firstname" name="firstname" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>นามสกุล : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control lastname" id="lastname" name="lastname" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <strong><span style="color:red" class="red_lastname"> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>เลขบัตรประจำตัวประชาชน : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control cardid" id="cardid" placeholder="กรุณากรอกเลขบัตรประชาชน 13 หลัก" name="cardid" onkeyup="autoTab(this)">
                                    </div>
                                </div>
                                <strong><span style="color:red" class="red_cardid"> *</span> </strong>
                            </div>

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>เพศ : </label>
                                </div>
                                <div class="col-2">
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="gender" class="custom-control-input" id="M" type="radio" value="ชาย">
                                        <label class="custom-control-label" for="M">ชาย </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="gender" class="custom-control-input" id="W" type="radio" value="หญิง">
                                        <label class="custom-control-label" for="W">หญิง </label>
                                    </div>

                                </div>
                                <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                            </div>
                          

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>เบอร์โทร : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control  tel" id="telephone" placeholder="กรุณากรอกเบอร์โทรศัพท์ 10 หลัก" name="telephone">
                                    </div>
                                </div>
                                <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="fileinput fileinput-new text-center a" data-provides="fileinput" align="center">
                                <div style="cursor:pointer;">
                                    <img src="image/upload.png" alt="..." id="add_picture_img" name="add_picture_img" align="center" width="200px" height="200px" style="object-fit: fill; border-radius: 8px;"><br><br>
                                    <input type="file" style="display:none" name="picture" id="pictures" accept="image/*">
                                    <span class="show_pic">(เลือกไฟล์รูปภาพ)</span>
                                </div>
                            </div>

                        </div>
                    </div>


            </div>
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-shop"></i> ข้อมูลที่อยู่</h5>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-2" align="right">
                        <label>บ้านเลขที่ : </label>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <input type="text" class="form-control" id="address_home" name="address_home" placeholder="กรุณากรอกข้อมูล">
                        </div>

                    </div>
                    <strong><span style="color:red"> *</span></strong>
                    <div class="col-2" align="right">
                        <label>หมู่ที่ : </label>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="address_swine" name="address_swine" placeholder="กรุณากรอกข้อมูล">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-2" align="right">
                        <label>ซอย : </label>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <input type="text" class="form-control" id="address_alley" name="address_alley" placeholder="กรุณากรอกข้อมูล">
                        </div>
                    </div>
                    <strong><span style="color:white" type="hidden"> *</span></strong>
                    <div class="col-2" align="right">
                        <label>ถนน : </label>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="address_road" name="address_road" placeholder="กรุณากรอกข้อมูล">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2" align="right">
                        <label>แขวง/ตำบล : </label>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <input type="text" class="form-control address_subdistrict" id="address_subdistrict" name="address_subdistrict" placeholder="กรุณากรอกข้อมูล">
                        </div>
                    </div>
                    <strong><span style="color:red"> *</span></strong>
                    <div class="col-2" align="right">
                        <label>เขต/อำเภอ : </label>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <input type="text" class="form-control " id="address_district" name="address_district" placeholder="กรุณากรอกข้อมูล">
                        </div>
                    </div>
                    <strong><span style="color:red"> *</span></strong>
                </div>
                <div class="row">
                    <div class="col-2" align="right">
                        <label>จังหวัด : </label>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <input type="text" class="form-control" id="address_province" name="address_province" placeholder="กรุณากรอกข้อมูล">
                        </div>
                    </div>
                    <strong><span style="color:red"> *</span></strong>
                    <div class="col-2" align="right">
                        <label>รหัสไปรษณีย์ : </label>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <input type="text" class="form-control address_zipcode" id="address_zipcode" name="address_zipcode" placeholder="กรุณากรอกข้อมูล">
                        </div>
                    </div>
                    <strong><span style="color:red"> *</span></strong>
                    <input type="hidden" id="subdistrict" name="subdistrict">
                    <input type="hidden" id="district" name="district">
                    <input type="hidden" id="province" name="province">
                    <input type="hidden" id="zipcode" name="zipcode">
                </div>
                <center><strong><span class="error_spec" style="color:red"></span></strong></center>

                <br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group" align="right">
                            <button type="submit" class="btn btn-outline-success" id="btn_add_emp">บันทึก</button>
                        </div>
                    </div>
                    <div class="col-6" align="left">
                        <div class="form-group">
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- จบ modal เพิ่มข้อมูลพนักงาน -->





<script>
    //   Specify the normal table row background color
    //   and the background color for when the mouse
    //   hovers over the table row.

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