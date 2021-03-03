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


<!-- Sidenav -->
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white  " id="sidenav-main">
  <div class="container-fluid">
    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Brand -->
    <!-- Brand -->
    <a class="navbar-brand pt-50 " href="admin.php">
      <img src="image/akalogo.png" width="250px" height ="130px">
    </a>
    <!-- User -->
    <ul class="nav align-items-center d-md-none">
      <li class="nav-item dropdown">
        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="media align-items-center">
            <span class="avatar avatar-sm rounded-circle">
              <?php
              @session_start();
              $picture = $_SESSION['picture'];
              $permiss = $_SESSION['userlevel'];
              $firstname = $_SESSION['firstname'];
              ?>
              <img alt="Image placeholder" src="<?php echo base_url("image/emp/" . $picture) ?>">
            </span>
            <div class="media-body  ml-2  d-none d-lg-block">
              <span class="mb-0 text-sm  font-weight-bold"><?php echo $_SESSION['username']; ?></span>
            </div>
          </div>
        </a>

        <div class="dropdown-menu  dropdown-menu-arrow dropdown-menu-right ">
          <div class="dropdown-header noti-title">
            <h6 class="text-overflow m-0">AKA Frola</h6>
          </div>
          <a href=".editnav" data-toggle="modal" class="dropdown-item" onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
            <i class="ni ni-badge"></i>
            <span>ข้อมูลส่วนตัว</span>
          </a>
          <a href=".reset" data-toggle="modal" class="dropdown-item" onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
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
    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="sidenav-collapse-main">
      <!-- Collapse header -->
      <div class="navbar-collapse-header d-md-none">
        <div class="row">
          <div class="col-6 collapse-brand">
            <a href="admin.php">
              <img src="<?php echo base_url("image/akalogo.png") ?>" width="100px">
            </a>
          </div>
          <div class="col-6 collapse-close">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
              <span></span>
              <span></span>
            </button>
          </div>
        </div>
      </div>
    
      <!-- Navigation -->
      <ul class="navbar-nav">
   
        <?php
        foreach ($menu as $m) { ?>
          <li class="nav-item" onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
            <a class="nav-link" href="<?php echo  $m["paht"] ?>">
              <i class="fas fa-<?php echo $m["icon"] ?>" style="color: <?php echo $m["color"] ?>"></i> <strong><?php echo $m["name"]; ?> </strong>
            </a>
          </li>
        <?php  } ?>


        <?php if ($permiss == "ผู้ดูแลระบบ") {
        ?>
          <li class="nav-item" onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" style="margin:25px;color:#2F4F4F;" class="dropdown-toggle"><i class="fas fa-chart-bar" style="margin-top:13px;color:#CC0000"></i><strong>&nbsp; &nbsp;รายงาน</strong></a>
          </li>

      </ul>
      <ul class="collapse list-unstyled sub" id="pageSubmenu">
        <li onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
          <i class="fas fa-user" style="color:#CC0000;  margin:15px;"> <a href="?page=page_report_order" style="color:#2F4F4F; margin:10px;"> การสั่งซื้อของลูกค้า</a>
            <!--หัวตารางรายงานข้อมูลสั่งซื้อของลูกค้า-->
          </i>
        </li>
        <li onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
          <i class="fas fa-seedling" style="color:#CC0000;  margin:15px;"><a href="?page=page_report_planting" style="color:#2F4F4F; margin:10px;">รายการปลูก</a>
            <!--หัวตารางรายงานข้อมูลการปลูก-->
          </i>
        </li>
        <li onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
          <i class="fas fa-hand-holding-usd" style="color:#CC0000;  margin:15px;"><a href="?page=page_report_handover" style="color:#2F4F4F; margin:10px;">การส่งมอบ</a>
            <!--หัวตารางรายงานข้อมูลการส่งมอบตามจำนวนการปลูก-->
          </i>
        </li>
      <!--   <li onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
          <i class="fas fa-list-alt" style="color:#CC0000;  margin:15px;"><a href="?page=page_report_handover_stock" style="color:#2F4F4F; margin:10px;">การส่งมอบตามจำนวนสต็อค</a>
          </i>
        </li> -->
        <!--หัวตารางรายงานข้อมูลการส่งมอบตามจำนวนสต็อค-->
        <li onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
          <i class="fas fa-store" style="color:#CC0000;  margin:15px;"><a href="?page=page_report_payment" style="color:#2F4F4F; margin:10px;">ลูกค้า walk-in</a>
            <!--หัวตารางรายงานข้อมูลลูกค้า walk-in-->
          </i>
        </li>
        <li onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
          <i class="fas fa-star" style="color:#CC0000;  margin:15px;"><a href="?page=page_report_top" style="color:#2F4F4F; margin:10px;">พันธุ์ไม้ขายดี</a>
            <!--หัวตารางรายงานข้อมูลพันธุ์ไม้ขายดี-->
          </i>
        </li>
        <li onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
          <i class="fas fa-tree" style="color:#CC0000;  margin:15px;"><a href="?page=page_report_breeder" style="color:#2F4F4F; margin:10px;"> สต็อคพันธุ์ไม้</a>
            <!--หัวตารางรายงานข้อมูลสต็อคพันธุ์ไม้-->
          </i>
        </li>
        <li onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">
          <i class="fas fa-prescription-bottle" style="color:#CC0000;  margin:15px;"><a href="?page=page_report_material" style="color:#2F4F4F; margin:10px;"> ต้นทุนรายการปลูก </a>
            <!--หัวตารางรายงานข้อมูลวัสดุปลูก-->
          </i>
        </li>
      </ul>
    <?php } ?>

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
  </script>






</nav>