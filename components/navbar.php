<?php
@session_start();
include('connect.php');

$empid =  $_SESSION['emp_id'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$userlevel = $_SESSION['userlevel'];
$picture = $_SESSION['picture'];


$sql = "SELECT emp_id,firstname,lastname,sex,card_id,telephone,emp_status,picture 
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
WHERE tb_user.emp_id = '$empid'
ORDER BY tb_user.emp_id ASC";


$re = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($re);

$card_id = $row['card_id'];
$telephone = $row['telephone'];
$sex = $row['sex'];

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
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
  <div class="container-fluid">
    <!-- Brand -->
    <strong><a class="mb-0 text-black text-uppercase d-none d-lg-inline-block" style="font-size: 17px !important;">
        <?php
        if ($page == 'page_report_order') {
          echo $head[$page]["h"];
        } else if ($page == 'page_report_planting') {
          echo $head[$page]["h"];
        } else if ($page == 'page_report_handover') {
          echo $head[$page]["h"];
        } else if ($page == 'page_report_handover_stock') {
          echo $head[$page]["h"];
        } else if ($page == 'page_report_payment') {
          echo $head[$page]["h"];
        } else if ($page == 'page_report_top') {
          echo $head[$page]["h"];
        } else if ($page == 'page_report_breeder') {
          echo $head[$page]["h"];
        } else if ($page == 'page_report_material') {
          echo $head[$page]["h"];
        } else {
          echo $menu[$page]["name"];
        }
        ?>
      </a></strong>
    <!-- User -->
    <ul class="navbar-nav align-items-center d-none d-md-flex">
     
      <li class="nav-item dropdown">
        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="media align-items-center">

            <?php
            $picture = $_SESSION['picture'];
            ?>
            <img alt="Image placeholder" src="<?php echo base_url("image/emp/" . $picture) ?>" width="40px" height="40px" style="object-fit: fill; border-radius: 10px;">
            <div class="media-body ml-2 d-none d-lg-block">
              <span class="mb-0 text-sm namecolor font-weight-bold"><?php echo $firstname . "  " . $lastname . "  (" . $userlevel . ")"; ?></span>
            </div>

          </div>
        </a>
        <div class="dropdown-menu  dropdown-menu-arrow dropdown-menu-right ">
          <div class="dropdown-header noti-title">
            <span class="text-overflow m-0">AKA Flora</span>
          </div>

          <a href=".editnav" data-toggle="modal" id="modal_edit" data="<?= $empid ?>" class="dropdown-item modal_edit" onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
            <i class="ni ni-badge"></i>
            <span>ข้อมูลส่วนตัว</span>
          </a>
          <a href=".reset" data-toggle="modal" class="dropdown-item" onclick="resetpass()" onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
            <i class="ni ni-settings-gear-65"></i>
            <span>เปลี่ยนรหัสผ่าน</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="logout.php" class="dropdown-item" style="color: red;" onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
            <i class="ni ni-button-power" style="color: red;"></i>
            <span style="color: red;">ออกจากระบบ</span>
          </a>
        </div>
      </li>
    </ul>
  </div>

</nav>

<div class="header bg-gradient-green pb-7 pt-0 pt-md-11">
  <div class="container-fluid">
    <div class="header-body">
      <!-- Card stats -->

    </div>
  </div>
</div>

<!-- เริ่ม modal แก้ไขข้อมูลพนักงาน -->
<div id="editemps" class="editnav modal fade editemps" role="dialog">
  <form method="post" class="form-horizontal Updates" role="form" enctype="multipart/form-data" data='<?= $empid ?>' id="edit_emps<?= $empid ?>" enctype="multipart/form-data" autocomplete="off">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="width: autopx;">
        <div class="modal-header">
          <h5 class="modal-title card-title"><i class="ni ni-single-02"></i> ข้อมูลพนักงาน</h5>
          <button type="button" class="close " data-dismiss="modal" style="width:50px;">
            <h3>&times;</h3>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="edit_item_id" id="edit_item_id" value="<?php echo $empid; ?>">
          <div class="row">
            <div class="col-sm-8">
              <div class="row">
                <div class="col-4" align="right">
                  <label>รหัสพนักงาน : </label>
                </div>
                <div class="col-7">
                  <div class="form-group">
                    <input type="text" class="form-control edit_empids" id="edit_empids<?= $empid ?>" name="edit_empids" readonly value="<?php echo $empid ?>" name="empid">
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
                <div style="cursor:pointer;" title="เลือกไฟล์รูปภาพ">
                  <img src="image/emp/<?php echo $picture ?>" class="edit_imgs" id="edit_imgs<?= $empid ?>" data="<?= $empid ?>" width="200" style="object-fit: fill; border-radius: 8px;" height="300" align="center"><br><br>
                  <input type="file" name="fileUploads" id="fileUploads<?= $empid ?>" class="fileUploads" accept="image/*" style="display:none">
                  <span class="show_pic_edit">(เลือกไฟล์รูปภาพ)</span>
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
                <strong><span style="color:white" type="hidden"> *</span></strong>
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
                    <input type="text" class="form-control edit_address_district com_amphoe2" id="edit_address_district<?= $empid ?>" name="edit_address_district" value="<?php echo $address_district; ?>">
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
                    <input type="text" class="form-control edit_address_province com_province2" id="edit_address_province<?= $empid ?>" name="edit_address_province" value="<?php echo $address_province; ?>">
                  </div>
                </div>
                <strong><span style="color:red" class="red_telephone"> *</span> </strong>
                <div class="col-2" align="right">
                  <label>รหัสไปรษณีย์ : </label>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <input type="text" class="form-control edit_address_zipcode com_zipcode2" id="edit_address_zipcode<?= $empid ?>" name="edit_address_zipcode" value="<?php echo $address_zipcode; ?>">
                  </div>
                </div>
                <strong><span style="color:red" class="red_telephone"> *</span> </strong>
              </div>
            </div>
          </div>
          <input type="hidden" id="edit_address_id2<?= $empid ?>" name="edit_address_id2" value="<?php echo $address_id ?>">
          <input type="hidden" class='hd_subdistrict2<?= $empid ?>' id="hd_subdistrict2<?= $empid ?>" name="hd_subdistrict2">
          <input type="hidden" class='hd_district2<?= $empid ?>' id="hd_district2<?= $empid ?>" name="hd_district2">
          <input type="hidden" class='hd_province2<?= $empid ?>' id="hd_province2<?= $empid ?>" name="hd_province2">
          <input type="hidden" class='hd_zipcode2<?= $empid ?>' id="hd_zipcode2<?= $empid ?>" name="hd_zipcode2">
          <center><span class="error_spec_edit"></span></center>

          <div class="row">
            <div class="col-6">
              <div class="form-group" align="right">
                <button type="submit" class="btn btn-outline-success update_emp" name="btn_update_emp" data="<?= $empid ?>" data-id="<?php echo $address_id ?>" id="btn_update_emp">แก้ไข</button>
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

<div id="reset" class="reset modal fade " role="dialog">
  <div class="modal-dialog modal-lg">
    <form method="post" class="form-horizontal Resetpass" role="form" enctype="multipart/form-data" enctype="multipart/form-data" autocomplete="off" id="resetpassword">
      <div class="modal-content" style="width: autopx;">
        <div class="modal-header">
          <h5 class="modal-title card-title"><i class="fas fa-prescription-bottle-alt"></i> เปลี่ยนรหัสผ่าน</h5>
          <button type="button" class="close" data-dismiss="modal" style="width:50px;">
            <h3>&times;</h3>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-4" align="right">
                  <label>รหัสพนักงาน : </label>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <input type="text" class="form-control" id="emp" value="<?php echo $empid ?>" name="emp" readonly>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="row">
                <div class="col-4" align="right">
                  <label>รหัสผ่านเดิม : </label>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <input type="password" class="form-control old_password" id="old_password" name="old_password" placeholder="กรุณากรอกข้อมูล">
                  </div>
                </div>
                <span style="color:red"> *</span>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="row">
                <div class="col-4" align="right">
                  <label>รหัสผ่านใหม่ : </label>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <input type="password" class="form-control" id="new_password1" name="new_password1" placeholder="กรุณากรอกข้อมูล">
                  </div>
                </div>
                <span style="color:red"> *</span>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="row">
                <div class="col-4" align="right">
                  <label>ยืนยันรหัสผ่านใหม่ : </label>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <input type="password" class="form-control" id="new_password2" name="new_password2" placeholder="กรุณากรอกข้อมูล">
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
              <button type="submit" class="btn btn-outline-success" name="btn_reset_password" id="btn_reset_password">บันทึก</button>
            </div>
          </div>
          <div class="col-6" align="left">
            <div class="form-group">
              <button type="button" class="btn btn-outline-danger" id="cancel_unit" data-dismiss="modal">ยกเลิก</button>
            </div>
          </div>
        </div><br>
      </div>
  </div>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
<script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
<link rel="stylesheet" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
<script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
  $(".modal_edit").on("click", function(event) {

    $(".Updates")[0].reset();

  });

  // ---- check error update ----//
  $.Thailand({
    database: './jquery.Thailand.js/database/db.json',
    $district: $('.com_district2'), // input ของตำบล
    $amphoe: $('.com_amphoe2'), // input ของอำเภอ
    $province: $('.com_province2'), // input ของจังหวัด
    $zipcode: $('.com_zipcode2'), // input ของรหัสไปรษณีย์
  });


  //---เช็คชื่อ ให้กรอกเฉพาะตัวอักษร + เอาเว้นวรรคออก --//
  $(".edit_firstname").on("change", function() {
    var elem = $(this).val();
    elem = elem.replace(/ /g, '');
    $(this).val(elem)
    if (!elem.match(/^([A-Za-z ก-๐])+$/i)) {
      swal({
        text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
        icon: "warning",
        button: false,
      });
      $(this).val("")
    }
  });

  //---เช็คชื่อและนามสกุล ที่ซ้ำในดาต้าเบส --//
  $(".edit_lastname").on("change", function(event) {
    var id = $(this).attr('data-id');
    var elem = $(this).val();
    elem = elem.replace(/ /g, '');
    $(this).val(elem)
    if (!elem.match(/^([A-Z a-z ก-๐])+$/i)) {
      swal({
        text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
        icon: "warning",
        button: false,
      });
      $(this).val("")
    } else {
      var lastname = $(this).val();
      var firstname = $('#edit_firstname' + id).val();
      lastname = lastname.replace(/ /g, '');
      firstname = firstname.replace(/ /g, '');
      $(this).val(elem)
      $(this).val(elem)
      $.ajax({
        url: "./pages/user/check_name_emp.php",
        method: "POST",
        data: {
          firstname: firstname,
          lastname: lastname
        },
        success: function(data) {
          //alert(data)
          if (data == 0) {
            swal({
              text: "ชื่อและนามสกุลถูกใช้ไปแล้ว",
              icon: "warning",
              button: false,
            });
            $("#edit_lastname" + id).val("")
            $("#edit_firstname" + id).val("")

          }
        }
      });
    }
  });


  //-- เช็คเลขบัตรประชาชน --//

  function checkID(id) {
    if (id.length != 13) return false;
    for (i = 0, sum = 0; i < 12; i++)
      sum += parseFloat(id.charAt(i)) * (13 - i);
    if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
      return false;
    return true;
  }

  $(".edit_cardid").on("change", function() {

    var id = $(this).attr('data-id');
    var cardid = $(this).val();
    cardid = cardid.replace(/ /g, '');
    cardid = cardid.replace(/-/g, '');

    if (!cardid.match(/^([0-9])+$/i)) {
      swal({
        text: "กรุณากรอกเฉพาะตัวเลขเท่านั้น",
        icon: "warning",
        button: false,
      });
      $(this).val("")
    } else if (cardid.length < 13) {
      swal({
        text: "กรุณากรอกเลขบัตรประชาชน 13 หลัก",
        icon: "warning",
        button: false,
      });

      $(this).val("")
    } else if (!checkID(cardid)) {
      swal({
        text: "เลขบัตรประชาชนไม่ถูกต้อง",
        icon: "warning",
        button: false,
      });
      $(this).val("")
    } else {
      $.ajax({
        url: "./pages/user/check_cardid_emp.php",
        method: "POST",
        data: {
          cardid: cardid
        },
        success: function(data) {
          //alert(data)
          if (data == 0) {
            swal({
              text: "เลขบัตรประชาชนถูกใช้ไปแล้ว",
              icon: "warning",
              button: false,
            });
            $("#a" + id).val("")
          }
        }
      });
    }
  });

  //-- เช็คเบอร์โทรศัพท์ --//

  function CheckMobileNumber(data) {
    var patt = /^[0]{1}[8,9,6]{1}[0-9]{7,}/
    if (data.match(patt)) {
      return true
    } else {
      return false
    }
  }

  $(".edit_telephone").on("change", function() {
    var id = $(this).attr('data-id');
    var elem = $(this).val();
    elem = elem.replace(/ /g, '');

    $(this).val(elem)
    if (!elem.match(/^([0-9-])+$/i)) {
      swal({
        text: "กรอกได้เฉพาะตัวเลขเท่านั้น",
        icon: "warning",
        button: false,
      });
      $(this).val("")
    } else {
      if (elem.length > 10) {

        swal({
          text: "กรุณากรอกเบอร์โทรศัพท์ไม่เกิน 10 หลัก",
          icon: "warning",
          button: false,
        });
        $(this).val("")
      } else if (elem.length < 10) {
        swal({
          text: "กรุณากรอกเบอร์โทรศัพท์ 10 หลัก",
          icon: "warning",
          button: false,
        });
        $(this).val("")
      } else {
        if (!CheckMobileNumber(elem)) {
          swal({
            text: "เบอร์โทรศัพท์ไม่ถูกต้อง",
            icon: "warning",
            button: false,
          });
          $(this).val("")
        } else {
          $.ajax({
            url: "./pages/user/check_tel_emp.php",
            method: "POST",
            data: {
              elem: elem
            },
            success: function(data) {
              //alert(data)
              if (data == 0) {
                swal({
                  text: "เบอร์โทรศัพท์ถูกใช้งานไปแล้ว",
                  icon: "warning",
                  button: false,
                });
                $("#edit_telephone" + id).val("")
              }
            }
          });

        }
      }

    }
  });


  //-- เช็คบ้านเลขที่ --//
  $(".edit_address_home").on("change", function() {
    var elem = $(this).val();
    elem = elem.replace(/ /g, '');
    $(this).val(elem)
    if (!elem.match(/^([0-9/-])+$/i)) {
      swal({
        text: "กรอกเฉพาะตัวเลขเท่านั้น",
        icon: "warning",
        button: false,
      });
      $(this).val("")
    }
  });

  //--เช็คหมู่ --//
  $(".edit_address_swine").on("change", function() {
    var elem = $(this).val();
    elem = elem.replace(/ /g, '');
    $(this).val(elem)
    if (!elem.match(/^([0-9/-])+$/i)) {
      swal({
        text: "กรอกได้เฉพาะ (0-9, / , - ) เท่านั้น",
        icon: "warning",
        button: false,
      });
      $(this).val("")

    }
  });

  //-- เช็คซอย --//
  $(".edit_address_alley").on("change", function() {

    var elem = $(this).val();
    elem = elem.replace(/ /g, '');
    $(this).val(elem)


  });

  //-- เช็ค ถนน --//
  $(".edit_address_road").on("change", function() {
    var elem = $(this).val();
    elem = elem.replace(/ /g, '');
    $(this).val(elem)
  });
  //--เช็ค แขวง--//
  $(".edit_address_subdistrict").on("change", function() {
    var elem = $(this).val();
    elem = elem.replace(/ /g, '');
    $(this).val(elem)
    if (!elem.match(/^([A-Z a-z ก-๐])+$/i)) {
      swal({
        text: "กรอกได้เฉพาะตัวอักษรเท่านั้น",
        icon: "warning",
        button: false,
      });
      $(this).val("")
    }
  });
  //-- เช็ค เขต --//
  $(".edit_address_district").on("change", function() {

  });
  //-- เช็คจังหวัด --//
  $(".edit_address_province").on("change", function() {


  });
  //-- เช็ครหัสไปรษณีย์ --//
  $(".edit_address_zipcode").on("change", function() {
    var elem = $(this).val();
    elem = elem.replace(/ /g, '');
    $(this).val(elem)
    if (!elem.match(/^([0-9])+$/i)) {
      swal({
        text: "กรอกเฉพาะตัวเลขเท่านั้น",
        icon: "warning",
        button: false,
      });
      $(this).val("")
    }
  });
  //--- update emp ---//

  $('.Updates').on('submit', function(event) {

    event.preventDefault();

    var id = $(this).attr('data');
    var firstname = $('#edit_firstname' + id).val();
    var lastname = $('#edit_lastname' + id).val();
    var cardid = $('#a' + id).val();
    var telephone = $('#edit_telephone' + id).val();


    var address_home = $('#edit_address_home' + id).val();
    var address_subdistrict = $('#edit_address_subdistrict' + id).val();
    var address_district = $('#edit_address_district' + id).val();
    var address_province = $('#edit_address_province' + id).val();
    var address_zipcode = $('#edit_address_zipcode' + id).val();



    var gender;

    if ($('#edit_M' + id).is(':checked')) {
      gender = "ชาย";
    } else if ($('#edit_F' + id).is(':checked')) {
      gender = "หญิง";
    }
    cardid = cardid.replace(/-/g, "");

    if (firstname == "") {
      swal({
        text: "กรุณากรอกชื่อ",
        icon: "warning",
        button: false

      })
    } else if (lastname == "") {
      swal({
        text: "กรุณากรอกนามสกุล",
        icon: "warning",
        button: false
      })
    } else if (cardid == "") {
      swal({
        text: "กรุณากรอกเลขบัตรประชาชน",
        icon: "warning",
        button: false
      })
    } else if (gender == "") {
      swal({
        text: "กรุณาเลือกเพศ",
        icon: "warning",
        button: false
      })
    } else if (telephone == "") {
      swal({
        text: "กรุณากรอกเบอร์โทรศัพท์",
        icon: "warning",
        button: false
      })
    } else if (address_home == "") {
      swal({
        text: "กรุณากรอกบ้านเลขที่",
        icon: "warning",
        button: false
      })
    } else if (address_subdistrict == "") {
      swal({
        text: "กรุณากรอกแขวง/ตำบล",
        icon: "warning",
        button: false
      })
    } else if (address_district == "") {
      swal({
        text: "กรุณากรอกเขต/อำเภอ",
        icon: "warning",
        button: false
      })
    } else if (address_province == "") {
      swal({
        text: "กรุณากรอกจังหวัด",
        icon: "warning",
        button: false
      })
    } else if (address_zipcode == "") {
      swal({
        text: "กรุณากรอกรหัสไปรษณีย์",
        icon: "warning",
        button: false
      })

    } else {
      $('.hd_subdistrict2' + id).val(address_district)
      $('.hd_district2' + id).val(address_subdistrict)
      $('.hd_province2' + id).val(address_province)
      $('.hd_zipcode2' + id).val(address_zipcode)


      $.ajax({
        url: "update_emp2.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(data) {

          swal({
            text: "บันทึกเรียบร้อย",
            icon: "success",
            button: false
          })
          setTimeout(function() {
            location.reload();
          }, 2000);

        }
      });

    }

  });

  $('.old_password').on("change", function(event) {
    var id = $("#emp").val();
    var password = $(this).val();

    $.ajax({
      url: "check_password.php",
      method: "POST",
      data: {

        id: id,
        password: password

      },
      success: function(data) {
        if (data == 1) {
          swal({
            text: "รหัสผ่านเดิมไม่ถูกต้อง",
            icon: "warning",
            button: false
          });
          $("#old_password").val("");
          $(this).focus();
        }
      }
    });

  });

  $('.Resetpass').on('submit', function(event) {

    event.preventDefault();

    var emp = $('#emp').val();
    var old_password = $('#old_password').val();
    var new_password1 = $('#new_password1').val();
    var new_password2 = $('#new_password2').val();

    if (old_password == "") {
      swal({
        text: "กรุณากรอกรหัสผ่านเดิม",
        icon: "warning",
        button: false

      })
    } else if (new_password1 == "") {
      swal({
        text: "กรุณากรอกรหัสผ่านใหม่",
        icon: "warning",
        button: false
      })
    } else if (new_password2 == "") {
      swal({
        text: "กรุณากรอกยืนยันรหัสผ่านใหม่",
        icon: "warning",
        button: false
      })
    } else if (new_password1 != new_password2) {
      swal({
        text: "รหัสผ่านใหม่ต้องเหมือนกัน !",
        icon: "warning",
        button: false
      })

    } else {
      $.ajax({
        url: "update_password.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(data) {

          swal({
            text: "บันทึกเรียบร้อย",
            icon: "success",
            button: false
          })
          setTimeout(function() {
            location.reload();
          }, 2000);

        }
      });
    }
  });

  var id_imgs
  $(document).on("click", "#modal_edit", function(event) {

    id_imgs = $(this).attr("data")


    console.log(id_imgs)
  });
  (function($) {
    $.fn.checkFileType = function(options) {
      var defaults = {
        allowedExtensions: [],
        success: function() {},
        error: function() {}
      };
      options = $.extend(defaults, options);

      return this.each(function() {

        $(this).on('change', function() {
          var value = $(this).val(),
            file = value.toLowerCase(),
            extension = file.substring(file.lastIndexOf('.') + 1);

          if ($.inArray(extension, options.allowedExtensions) == -1) {
            options.error();
            $(this).focus();
          } else {
            options.success();

          }

        });

      });
    };

  })(jQuery);
  $(function() {
    $('fileUploads').checkFileType({
      allowedExtensions: ['png', 'jpg', 'jpeg', 'gif'],
      success: function() {


      },
      error: function() {
        swal({
          text: "กรุณาเลือกไฟล์รูปภาพ (png, jpg, jpeg)",
          icon: "warning",
          button: "ปิด"
        })
        $('.fileUploads').val("");
      }
    });
  });

  function readURL2s(input, id) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#edit_imgs' + id).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }

  }

  $(document).on("click", ".edit_imgs", function(event) {
    var id = $(this).attr("data")
    console.log(id)
    $("#fileUploads" + id_imgs).click();
    $("#fileUploads" + id_imgs).change(function() {

      readURL2s(this, id_imgs);

    });
  });

  var TableBackgroundNormalColor = "#ffffff";
  var TableBackgroundMouseoverColor = "#9efaaa";

  // These two functions need no customization.
  function ChangeBackgroundColor(row) {
    row.style.backgroundColor = TableBackgroundMouseoverColor;
  }

  function RestoreBackgroundColor(row) {
    row.style.backgroundColor = TableBackgroundNormalColor;
  }

  function resetpass() {
    document.getElementById("resetpassword").reset(); //เคลียค่าฟอร์ม เพิ่มพนักงาน
  }
</script>