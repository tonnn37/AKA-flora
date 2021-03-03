<style>
    input.larger {
        width: 30px;
        height: 20px;
    }
</style>
<?php
include('connect.php');

$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$m = date('m', $datenow);

$sql_group = "SELECT Max(planting_id) as maxid FROM tb_planting";
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];

$tmp1 = "PLT";
$minus = "-";
$tmp2 = substr($mem_old, 9, 3);
$Year = substr($mem_old, 3, 2);
$Month = substr($mem_old, 6, 2);
$sub_date = substr($d, 2, 2);

if ($Year != $sub_date) {
    $tmp2 = 0;
    //  $sub_date=$sub_date+1;
} else {
    $tmp2;
}

if ($Month != $m) {
    $tmp2 = 0;
    //  $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;
$a = sprintf("%03d", $t);
$run_planting_id = $tmp1 . $sub_date . $minus . $m . $minus . $a;



$sql_group = "SELECT Max(planting_week_id) as maxid FROM tb_planting_week";
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];

$tmp1 = "PTW";
$minus = "-";
$tmp2 = substr($mem_old, 9, 3);
$Year = substr($mem_old, 3, 2);
$Month = substr($mem_old, 6, 2);
$sub_date = substr($d, 2, 2);

if ($Year != $sub_date) {
    $tmp2 = 0;
    //  $sub_date=$sub_date+1;
} else {
    $tmp2;
}

if ($Month != $m) {
    $tmp2 = 0;
    //  $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;
$a = sprintf("%02d", $t);
$run_planting_week_id = $tmp1 . $sub_date . $minus . $m . $minus . $a;


@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];

if ($permiss == "พนักงาน") {
    $hidden = "hidden";
    $disabled = "disabled";
} else {
    $hidden = "";
    $disabled = "";
}

?>
<input type="hidden" id="per" value='<?php echo $permiss ?>'>


<div class="row" <?php echo $hidden ?>>
    <div class="col-12">
        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target=".bd-example-modal-lg" id="btn_add_modal"><i class="ni ni-fat-add"></i> เพิ่มรายการปลูก</button>
        <button type="button" class="btn btn-outline-success" id="search_modal" title="ตัวเลือกการค้นหา" data-target="#modal_search" data-toggle="modal"><img src="image/1x/btnsearch.png" width="25px" height="25px"></button>
    </div>

</div>
<div id="modal_search" class="modal fade" role="dialog">
    <form role="form" method="post" action="pages/print_payment.php" target="_blank" id="serach_id">
        <div class="modal-dialog modal-md">
            <div class="modal-content" style="width:auto">
                <div class="modal-header">
                    <h5 class="modal-title card-title"><img src="image/1x/btnsearch.png " width="25px" height="25px">&nbsp; ตัวเลือกการค้นหา
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                        <h3>&times;</h3>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12">

                        <div class="row">
                            <div class="col-4" align="right">
                                <label>เลือกตามสถานะ : </label>
                            </div>
                            <div class="col-md-1.5">
                                <div class="dropdown">
                                    <div class="form-group">
                                        <select name="search_status" class="form-control" id="search_status">
                                            <option value="0">---โปรดเลือกสถานะ---</option>
                                            <option value="ปกติ">ปกติ</option>
                                            <option value="เสร็จสิ้น">เสร็จสิ้น</option>
                                            <option value="ระงับ">ระงับ</option>
                                        </select>

                                    </div>

                                </div>
                                <strong><span style="color:red"> *</span></strong>&nbsp;&nbsp;
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="btn_search"><img src="image/1x/btnsearch.png " width="25px" height="25px"></button>
                            </div>
                        </div>
                    </div><br>

                </div>
            </div>
        </div>
    </form>
</div>
<!--- เริ่ม modal รายการปลูก --->
<div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="add_planting">
    <div class="modal-dialog modal-lx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มรายการปลูก</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="" id="in_planting">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รหัสรายการปลูก : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_planting_id" name="in_planting_id" value="<?= $run_planting_id ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รายการสั่งซื้อ : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <select name="in_planting_ordername" class="form-control" id="in_planting_ordername">
                                            <option value="0">----โปรดเลือกรายการสั่งซื้อ----</option>
                                            <?php

                                            $sql_order = "SELECT tb_order_detail.order_detail_id as  order_detail_id
                                            ,tb_order_detail.order_detail_planting_status as order_detail_planting_status
                                            ,tb_order.order_id as order_id
                                            ,tb_order.order_name as order_name
                                            ,tb_customer.customer_firstname as customer_firstname
                                            ,tb_customer.customer_lastname as customer_lastname
                                            
                                                    FROM tb_order_detail
                                                    LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
                                                    LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
                                                    WHERE tb_order.order_status ='ปกติ'  AND tb_order.order_id  NOT IN (SELECT ref_order_id FROM tb_planting WHERE tb_planting.planting_status='ปกติ') 
                                                    AND tb_order_detail.order_detail_planting_status = 'ยังไม่ได้ทำการปลูก'
                                                    GROUP BY tb_order.order_id
                                                    ORDER BY tb_order_detail.order_detail_id ASC";
                                            $re_order = mysqli_query($conn, $sql_order);
                                            while ($re_row = mysqli_fetch_array($re_order)) {
                                            ?>
                                                <option value="<?php echo $re_row["order_id"]; ?>">
                                                    <?php echo $re_row["order_name"] . " " . "(" . $re_row["customer_firstname"] . " " . $re_row["customer_lastname"] . ")"; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span></strong>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table-bordered text-center" id="plantings_detailTable" width="100%">
                                        <thead bgcolor="#2dce89">
                                            <th width="5%"><input type="checkbox" class="larger" id="select_all" /> เลือกทั้งหมด</th>
                                            <th>ลำดับ</th>
                                            <th>รหัสรายการ</th>
                                            <th>พันธุ์ไม้</th>
                                            <th>จำนวนปลูก</th>
                                            <th>ปลูกเผื่อ</th>
                                            <th>ปลูกทั้งหมด</th>
                                            <th>วันที่ส่งมอบ</th>
                                            <th>ระยะเวลา</th>


                                        </thead>
                                    </table>
                                </div>
                            </div><br><br>
                        </div>

                    </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group" align="right">
                        <button type="button" class="btn btn-outline-success" name="btn_add_planting" id="btn_add_planting">เพิ่มรายการ</button>
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
        <table class="table-bordered text-center " id="plantingTable" style="width:100%">
            <thead bgcolor="#2dce89" style="text-align: center;">
                <th>ลำดับ</th>
                <th>รหัสรายการปลูก</th>
                <th>ชื่อรายการสั่งซื้อ</th>
                <th width="100">ชื่อลูกค้า</th>
                <th>รายการปลูก</th>
                <th>จำนวน<br>ต้นตาย (ต้น)</th>
                <th>ค่าใช้จ่ายรวม (บาท)</th>
                <th>วันที่บันทึก</th>
                <th>สถานะ</th>
                <th width="100"></th>


            </thead>


        </table>
    </div>
</div>

<?php
$sql = "SELECT tb_planting.planting_id as planting_id, tb_planting.planting_status as planting_status, tb_planting.ref_order_id as ref_order_id,tb_planting.planting_date as planting_date
,tb_order_detail.order_detail_id as order_detail_id
,tb_order.order_id as order_id, tb_order.order_name as order_name ,tb_order.order_customer as order_customer ,tb_order.order_detail as order_detail
,tb_planting_detail.planting_detail_id as planting_detail_id
,tb_customer.customer_firstname as customer_firstname , tb_customer.customer_lastname as customer_lastname  
,SUM(tb_planting_week.planting_week_count) as sum_week
FROM tb_planting
LEFT JOIN tb_order ON tb_order.order_id = tb_planting.ref_order_id
LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
LEFT JOIN tb_order_detail ON tb_order_detail.ref_order_id = tb_order.order_id
LEFT JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
LEFT JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id = tb_planting_detail.planting_detail_id

GROUP BY planting_id
ORDER BY planting_id ASC";

$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {

        $planting_id = $row['planting_id'];
        $planting_date = $row['planting_date'];
        $planting_status = $row['planting_status'];

        $planting_detail_id = $row['planting_detail_id'];

        $order_id = $row['order_id'];
        $order_name = $row['order_name'];
        $order_customer = $row['customer_firstname'] . " " . $row['customer_lastname'];
        $order_detail = $row['order_detail'];


?>

        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="add_planting_details<?php echo $planting_id ?>">
            <div class="modal-dialog modal-lx">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มรายการปลูกเพิ่มเติม</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="post" action="" id="in_planting2">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รายการสั่งซื้อ : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <select name="in_planting_ordername_detail" class="form-control in_planting_ordername_detail" id="in_planting_ordername_detail<?= $planting_id ?>">
                                                    <option value="0">----โปรดเลือกรายการสั่งซื้อ----</option>
                                                    <?php
                                                    $query = "SELECT tb_order_detail.order_detail_id as  order_detail_id
                                                ,tb_order_detail.order_detail_planting_status as order_detail_planting_status
                                                ,tb_order.order_id as order_id
                                                ,tb_order.order_name as order_name
                                                ,tb_customer.customer_firstname as customer_firstname
                                                ,tb_customer.customer_lastname as customer_lastname
                                                ,tb_plant.plant_name as plant_name
                                                
                                                        FROM tb_order_detail
                                                        LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
                                                        LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
                                                        LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
                                                        WHERE tb_order.order_status ='ปกติ' AND tb_order_detail.order_detail_planting_status='ยังไม่ได้ทำการปลูก' 
                                                        AND tb_order.order_id IN (SELECT ref_order_id FROM tb_planting WHERE tb_planting.planting_status='ปกติ') 
                                                        AND tb_order_detail.ref_order_id = '$order_id'
                                                        ORDER BY tb_order_detail.order_detail_id ASC";

                                                    $re_type1 = mysqli_query($conn, $query);
                                                    while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                                    ?>
                                                        <option value="<?php echo $re_fac1["order_detail_id"]; ?>">
                                                            <?php echo $re_fac1["plant_name"]; ?>
                                                        </option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <strong><span style="color:red"> *</span></strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รหัสรายการปลูก : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="in_planting_id_detail<?= $planting_id ?>" name="in_planting_id_detail" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table-bordered text-center" id="add_plantings_detailTable<?= $planting_id ?>" width="100%">
                                                <thead bgcolor="#2dce89">
                                                    <th>ลำดับ</th>
                                                    <th>รหัสรายการ</th>
                                                    <th>พันธุ์ไม้</th>
                                                    <th>จำนวนปลูก</th>
                                                    <th>ปลูกเผื่อ</th>
                                                    <th>ปลูกทั้งหมด</th>
                                                    <th>วันที่ส่งมอบ</th>
                                                    <th>ระยะเวลา</th>

                                                </thead>
                                            </table>
                                        </div>
                                    </div><br><br>
                                </div>

                            </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group" align="right">
                                <button type="button" class="btn btn-outline-success" name="btn_add_planting_detail" id="btn_add_planting_detail" data-id="<?= $planting_id ?>">เพิ่มรายการ</button>
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
<?php
    } //end while
} //end if
?>


<!-- ตารางรายละเอียดออเดอร์ ในปุ่มแสดงรายละเอียด -->
<div id="view_dialog" class="modal fade" role="dialog">
    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="modal-dialog modal-xxxl">
            <!-- Modal content-->
            <div class="modal-content" style="width:auto">
                <div class="modal-header">
                    <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายละเอียดรายการปลูก
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
                                    <strong><label>รหัสรายการปลูก : </label></strong>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label id="plant_id"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <strong><label>รหัสรายการสั่งซื้อ : </label></strong>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label id="order_id"></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <strong><label>ชื่อลูกค้า : </label></strong>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label id="view_customer_name"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="edit_item_id" value="<?php echo $planting_id; ?>">
                    <table id="planting_detailTable" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>รหัสรายการปลูก</th>
                            <th>ชื่อพันธุ์ไม้</th>
                            <th>ปลูก (ต้น)</th>
                            <th>ต้นตาย (ต้น)</th>
                            <th>คงเหลือ (ต้น)</th>
                            <th>ค่าใช้จ่ายรวม (บาท)</th>
                            <th>สัปดาห์ที่</th>
                            <th>วันที่ส่งมอบ</th>
                            <th>ระยะเวลาที่เหลือ</th>
                            <th>สถานะ</th>
                            <th></th>
                        </thead>


                    </table>
                </div>
            </div>
        </div>
    </form>
</div>




<?php
date_default_timezone_set("Asia/Bangkok");
$datenow = date("Y-m-d");




$sql_id_detail_borrow = "SELECT max(planting_week_count) as Maxid  FROM tb_planting_week";
$result_id_bor = mysqli_query($conn, $sql_id_detail_borrow);
$row_id = mysqli_fetch_assoc($result_id_bor);
$old_id = $row_id['Maxid'];
$id_count = $old_id + 1;

?>



<!-- ตารางรายละเอียดออเดอร์ ในปุ่มแสดงรายละเอียด -->
<div id="viewlist" class="modal fade viewlist" role="dialog">
    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="modal-dialog modal-lx">
            <!-- Modal content-->
            <div class="modal-content" style="width:auto">
                <div class="modal-header">
                    <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> แสดงรายละเอียดแต่ละสัปดาห์
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                        <h3>&times;</h3>
                    </button>
                </div>


                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            &nbsp;&nbsp;<button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target=".addmodal" id="modal_detail"><i class="ni ni-fat-add"></i>เพิ่มรายละเอียดแต่ละสัปดาห์</button>
                        </div>
                    </div><br><br>


                    <div class="row">
                        <div class="col-3" align="right">
                            <strong><label>รหัสรายการปลูก : </label></strong>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label id="view_order_name2"></label>
                            </div>
                        </div>
                        <div class="col-2" align="right">
                            <strong><label>ชื่อลูกค้า : </label></strong>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label id="view_customer_name2"></label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-3" align="right">
                            <strong><label>ชื่อพันธุ์ไม้ : </label></strong>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label id="week_plant_name"></label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="edit_item_id" value="<?php echo $planting_id; ?>">
                    <table id="planting_listTable" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับที่</th>
                            <th>สัปดาห์ที่</th>
                            <th>จำนวนต้นตาย (ต้น)</th>
                            <th>ค่าใช้จ่ายรวม (บาท)</th>
                            <th>วันที่บันทึก</th>
                            <th>สถานะ</th>
                            <th></th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>



<div class="modal fade addmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="add_planting_week">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มรายละเอียดการปลูกแต่ละสัปดาห์</h5>
                <button type="button" class="close" id="close_modal_add_week_detail" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="" id="in_planting_week_detail">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รหัสรายการปลูก : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_planting_week_id" name="in_planting_week_id" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ชื่อพันธุ์ไม้ : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_planting_week_name_plant" name="in_planting_week_name_plant" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>สัปดาห์ที่ : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">

                                        <input type="text" class="form-control" id="in_planting_week_amount" name="in_planting_week_amount" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <strong><label>สูตรยา : </label></strong>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <select name="in_planting_week_drug_formula" class="form-control" id="in_planting_week_drug_formula">
                                            <option value="0">---โปรดเลือกสูตรยา---</option>
                                            <?php
                                            $sql_order = "SELECT * FROM tb_drug_formula WHERE drug_formula_status ='ปกติ' ORDER BY drug_formula_id ASC";
                                            $re_order = mysqli_query($conn, $sql_order);
                                            while ($re_row = mysqli_fetch_array($re_order)) {

                                                $drug_formula_id = $re_row['drug_formula_id'];

                                                $sql_quality = "SELECT SUM(tb_drug_formula_detail.drug_formula_detail_amount_sm) as count FROM tb_drug_formula_detail WHERE tb_drug_formula_detail.ref_drug_formula='$drug_formula_id'  ";
                                                $re_quality = mysqli_query($conn, $sql_quality);
                                                $r_quality = mysqli_fetch_assoc($re_quality);
                                                $sum_quality = $r_quality['count'];

                                                if ($sum_quality == "") {
                                                    $sum_quality = 0;
                                                }
                                            ?>
                                                <option value="<?php echo $re_row["drug_formula_id"]; ?>">
                                                    <?php echo $re_row["drug_formula_name"] . " " . "(" . $sum_quality . " " . "ลิตร" . ")"; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span></strong>
                            </div>
                            <div class="row" id="hidden_formula1" type="hidden">
                                <div class="col-4" align="right">
                                    <label>สูตรยา/จำนวน : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_planting_week_formula_per_amount" name="in_planting_week_formula_per_amount" readonly>
                                    </div>
                                </div>
                                <span> ต้น</span>
                            </div>
                            <div class="row" id="hidden_formula4">
                                <div class="col-4" align="right">
                                    <label>ราคาสูตรยา : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control in_planting_week_amount_formula" id="in_planting_week_amount_formula" name="in_planting_week_amount_formula" readonly>
                                    </div>
                                </div>
                                <span> บาท</span>
                            </div>
                            <div class="row" id="hidden_formula2">
                                <div class="col-4" align="right">
                                    <label>ปริมาณการใช้สูตรยา : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="number" class="form-control" id="in_planting_week_amount_drug" name="in_planting_week_amount_drug">
                                        <span style="color:red" id="show_text_amounts">(กรณีไม่ถึง 1 ให้ใส่ 0.25, 0.5, 0.75) </span>
                                    </div>
                                </div>
                                <span> ลิตร</span>&nbsp; <strong><span style="color:red"> *</span></strong>
                            </div>

                            <div class="row" id="hidden_formula3">
                                <div class="col-4" align="right">
                                    <label>ราคาสูตรยารวม : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_planting_week_formula_price" name="in_planting_week_formula_price" readonly>
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
                                        <select name="in_planting_week_material" class="form-control" id="in_planting_week_material">
                                            <option value="0">---โปรดเลือกวัสดุปลูก---</option>
                                            <?php
                                            $sql_order = "SELECT * FROM tb_material 
                                             LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_material.ref_drug_unit
                                             LEFT JOIN tb_type_material ON tb_type_material.type_material_id = tb_material.ref_type_material
                                             WHERE material_status ='ปกติ' AND tb_type_material.type_material_status = 'ปกติ' AND tb_drug_unit.drug_unit_status = 'ปกติ'
                                             ORDER BY material_id ASC";
                                            $re_order = mysqli_query($conn, $sql_order);
                                            while ($re_row = mysqli_fetch_array($re_order)) {
                                            ?>
                                                <option value="<?php echo $re_row["material_id"]; ?>">
                                                    <?php echo $re_row["material_name"] . " " . "(" . $re_row['drug_unit_name'] . ")" . " " . "(" . $re_row['material_amount'] . " " . "กก." . ")"; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span></strong>
                            </div>

                            <div class="row" id="hidden1">
                                <div class="col-4" align="right">
                                    <label>ปริมาตร/หน่วย : </label>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control in_planting_week_material_per_amount" id="in_planting_week_material_per_amount" name="in_planting_week_material_per_amount" readonly>
                                    </div>
                                </div>
                                <span>กิโลกรัม<br>&nbsp;หรือ : </span>

                                <label></label>

                                <div class="col-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control in_planting_week_material_per_amount_gram" id="in_planting_week_material_per_amount_gram" name="in_planting_week_material_per_amount_gram" readonly>
                                    </div>
                                </div>
                                <span>กรัม</span>&nbsp;

                            </div>
                            <div class="row" id="hidden2">
                                <div class="col-4" align="right">
                                    <label>ราคา/หน่วย : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control in_planting_week_material_price" id="in_planting_week_material_price" name="in_planting_week_material_price" readonly>
                                    </div>
                                </div>
                                <span> บาท</span>
                            </div>
                            <div class="row" id="hidden3">
                                <div class="col-4" align="right">
                                    <label>ปริมาณการใช้วัสดุปลูก : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="number" class="form-control in_planting_week_amount_material" id="in_planting_week_amount_material" name="in_planting_week_amount_material">
                                        <span style="color:red" id="show_text_amount">(กรณีไม่ถึง 1 ให้ใส่ 0.25, 0.5, 0.75) </span>
                                    </div>
                                </div>

                                <label id="in_planting_week_material_unit" name="in_planting_week_material_unit" readonly></label>&nbsp;
                                <strong><span style="color:red"> *</span></strong>

                            </div>
                            <div class="row" id="hidden4">
                                <div class="col-4" align="right">

                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control in_planting_week_material_total_amount" id="in_planting_week_material_total_amount" name="in_planting_week_material_total_amount" readonly>
                                    </div>
                                </div>
                                <span>กิโลกรัม<br>&nbsp;หรือ : </span>

                                <label></label>

                                <div class="col-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control in_planting_week_material_total_amount_gram" id="in_planting_week_material_total_amount_gram" name="in_planting_week_material_total_amount_gram" readonly>
                                    </div>
                                </div>
                                <span>กรัม</span>&nbsp;

                            </div>

                            <div class="row" id="hidden5">
                                <div class="col-4" align="right">
                                    <label>ราคาวัสดุปลูกรวม : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_planting_week_material_price_total" name="in_planting_week_material_price_total" readonly>
                                    </div>
                                </div>
                                <span> บาท</span>
                            </div>


                            <div class="row">
                                <div class="col-4" align="right">
                                    <strong><label>จำนวนต้นไม้ที่ตาย : </label> </strong>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_planting_week_dead" name="in_planting_week_dead" placeholder="กรุณากรอกข้อมูล">
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
                                        <input type="hidden" class="form-control" id="in_planting_week_datenow" name="in_planting_week_datenow" value="<?= $datenow ?>">
                                        <input type="date" class="form-control" id="in_planting_week_date" name="in_planting_week_date" value="<?= $datenow ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group" align="right">
                        <button type="button" class="btn btn-outline-success" name="btn_add_planting_week" id="btn_add_planting_week">บันทึก</button>
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

<!-- ตารางรายละเอียดแต่ละ week  -->
<div id="planting_week_detail" class="modal fade" role="dialog">
    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="modal-dialog modal-xxl">
            <!-- Modal content-->
            <div class="modal-content" style="width:auto">
                <div class="modal-header">
                    <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> แสดงรายละเอียดการปลูกแต่ละสัปดาห์
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" id="close_week_detail" style="width:50px;">
                        <h3>&times;</h3>
                    </button>
                </div>

                <div class="modal-body">


                    <div class="row">
                        <div class="col-3" align="right">
                            <strong><label>รหัสรายการปลูก : </label></strong>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label id="view_order_name3"></label>
                            </div>
                        </div>

                        <div class="col-2" align="right">
                            <strong><label>ชื่อลูกค้า : </label></strong>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label id="view_customer_name3"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3" align="right">
                            <strong><label>ชื่อพันธุ์ไม้ : </label></strong>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label id="week_plant_name3"></label>
                            </div>
                        </div>
                        <div class="col-2" align="right">
                            <strong><label>สัปดาห์ที่ : </label></strong>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label id="week_name3"></label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="edit_item_id" value="<?php echo $planting_id; ?>">
                    <table id="planting_week_detailTable" class="table-bordered text-center" width="100%">

                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>ชื่อสูตรยา</th>
                            <th>สูตรยา/จำนวน (ต้น)</th>
                            <th>ปริมาณใช้สูตรยา (ลิตร)</th>
                            <th>ราคาใช้สูตรยา (บาท)</th>
                            <th>ชื่อวัสดุปลูก</th>
                            <th>ปริมาณใช้วัสดุปลูก (กิโลกรัม)</th>
                            <th>ราคาใช้วัสดุปลูก (บาท)</th>
                            <th>จำนวนต้นตาย (ต้น)</th>
                            <th>วันที่บันทึก</th>
                            <th>สถานะ</th>
                            <th></th>
                        </thead>
                        <colgroup span="2" width="100"></colgroup>
                        <colgroup span="3" width="100"></colgroup>
                        <colgroup span="4" width="100"></colgroup>
                        <colgroup span="5" width="100"></colgroup>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

    <form role="form" method="POST" action="" enctype="multipart/form-data" class="edit_planting_week_details" id="edit_planting_week_details">
        <div id="show_modal"></div>
    </form>

<form role="form" method="POST" action="" enctype="multipart/form-data" class="add_week_detail" id="add_week_detail">
    <div id="show_modal_add"></div>
</form>