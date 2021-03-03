<?php
include('connect.php');

$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$m = date('m', $datenow);

$sql_group = "SELECT Max(stock_recieve_id) as maxid FROM tb_stock_recieve";
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];

$tmp1 = "SR";
$minus = "-";
$tmp2 = substr($mem_old, 8, 3);
$Year = substr($mem_old, 2, 2);
$Month = substr($mem_old, 5, 2);
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
$run_stockrecieve_id = $tmp1 . $sub_date . $minus . $m . $minus . $a;

@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];

?>

<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-outline-warning" data-toggle="modal" id="modal_stock_recieve" data-target=".bd-example-modal-lg"><i class="ni ni-fat-add"></i> เพิ่มการคัดเกรดพันธุ์ไม้</button>
        <button type="button" class="btn btn-outline-success" id="search_modal" title="ตัวเลือกการค้นหา" data-target="#modal_search" data-toggle="modal"><img src="image/1x/btnsearch.png" width="25px" height="25px"></button>
    </div>
</div><br>

<!-- แสดงข้อมูลในตาราง -->
<div class="row">
    <div class="col-12">
        <table class="table table-bordered text-center" id="stock_recieveTable" width="100%">
            <thead bgcolor="#2dce89" style="text-align: center;">
                <th>ลำดับ</th>
                <th>รหัสคัดเกรด</th>
                <th>ชื่อลูกค้า</th>
                <th>ชื่อพันธุ์ไม้</th>
                <th>จำนวน (ต้น)</th>
                <th>วันที่บันทึก</th>
                <th>สถานะ</th>
                <th></th>
            </thead>
        </table>
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
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="add_stock_recieve">
    <div class="modal-dialog modal-lx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มการคัดเกรดพันธุ์ไม้</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="" id="in_stock_recieve">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รหัสคัดเกรด : </label>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_stock_recieve_id" name="in_stock_recieve_id" value="<?= $run_stockrecieve_id ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รายการปลูก : </label>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <select name="in_stock_recieve_planting" class="form-control" id="in_stock_recieve_planting">
                                            <option value="0">---โปรดเลือกรายการปลูก---</option>
                                            <?php

                                            $sql_order = "SELECT tb_planting.planting_id as planting_id, COUNT(tb_planting_week.ref_planting_detail_id) as COUNT
                                            ,tb_planting_detail.planting_detail_status as plating_detail_status
                                            ,tb_order.order_name as order_name
                                            ,tb_customer.customer_firstname as customer_firstname
                                            ,tb_customer.customer_lastname as customer_lastname
                                            ,tb_planting_detail.planting_detail_id as planting_detail_id
                                                          
                                                              FROM tb_planting_detail
                                                              LEFT JOIN tb_planting ON tb_planting.planting_id = tb_planting_detail.ref_planting_id
                                                              LEFT JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id = tb_planting_detail.planting_detail_id
                                                              LEFT JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
                                                              LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
                                                              LEFT JOIN tb_order ON tb_order.order_id = tb_planting.ref_order_id
                                                              LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
                                                              WHERE tb_planting_week.planting_week_status ='เสร็จสิ้น' AND tb_planting_detail.planting_detail_status ='รอคัดเกรด'
                                                        
                                                              GROUP BY tb_planting.planting_id
                                                              ORDER BY tb_planting_detail.planting_detail_id ASC";

                                            $re_order = mysqli_query($conn, $sql_order);
                                            while ($re_row = mysqli_fetch_array($re_order)) {
                                                $count = $re_row['COUNT'];
                                                $count = intval($count);
                                                if ($count >= 12) {

                                            ?>
                                                    <option value="<?php echo $re_row["planting_id"]; ?>">
                                                        <?php echo $re_row["order_name"] . " " . "(" . $re_row['customer_firstname'] . " " . $re_row['customer_lastname'] . ")"; ?>
                                                    </option>
                                            <?php
                                                }
                                            } //วน loop listview แสดงชื่อคนที่จะให้สิทธิ์
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span></strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>พันธุ์ไม้ : </label>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <select name="in_stock_planting_detail" class="form-control" id="in_stock_planting_detail">
                                            <option value="0">---โปรดเลือกพันธุ์ไม้---</option>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span></strong>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table-bordered text-center" id="add_stock_recieveTable" width="100%">
                                <thead bgcolor="#2dce89">
                                    <th>ลำดับ</th>
                                    <th>รหัสรายการปลูก</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>พันธุ์ไม้</th>
                                    <th>จำนวนปลูก (ต้น)</th>
                                    <th>ต้นตาย (ต้น)</th>
                                    <th>คงเหลือ (ต้น)</th>
                                    <th>วันที่ส่งมอบ</th>

                                </thead>
                            </table>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>จำนวนปลูกทั้งหมด : </label>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_stock_recieve_amount" name="in_stock_recieve_amount">
                                    </div>
                                </div>
                                <span> ต้น</span>
                            </div>
                        </div>
                        <?php
                        $sql_grade = "SELECT * FROM tb_grade WHERE grade_status ='ปกติ'";
                        $result = mysqli_query($conn, $sql_grade);
                        while ($row = mysqli_fetch_array($result)) {

                            $grade_id = $row['grade_id'];
                            $grade_name = $row['grade_name'];
                        ?>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-4" align="right">
                                        <label>เกรด <?= $grade_name ?> :</label>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <input type="checkbox" class="form-control in_stock_grade_id" id="in_stock_grade_id" name="in_stock_grade_id" value="<?= $grade_id ?>">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="textbox" class="form-control in_stock_grade_amount" id="in_stock_grade_amount<?= $grade_id ?>" name="in_stock_grade_amount" disabled>
                                        </div>
                                    </div>
                                    <span> ต้น</span>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>จำนวนคงเหลือ : </label>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control in_stock_recieve_amount_sum" id="in_stock_recieve_amount_sum" name="in_stock_recieve_amount_sum" readonly>
                                    </div>
                                </div>
                                <span> ต้น</span>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group" align="right">
                                <button type="button" class="btn btn-outline-success" name="btn_add_handover" id="btn_add_handover">บันทึก</button>
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
</div>


<!-- ตารางรายละเอียดออเดอร์ ในปุ่มแสดงรายละเอียด -->
<div id="view_recieve_detail" class="modal fade" role="dialog">
    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content" style="width:auto">
                <div class="modal-header">
                    <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายละเอียดการคัดเกรดพันธุ์ไม้
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                        <h3>&times;</h3>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-5" align="right">
                                    <strong><label>รหัสคัดเกรด : </label></strong>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label id="recieve_id"></label>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-5" align="right">
                                    <strong><label>รหัสรายการปลูก : </label></strong>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label id="planting_id"></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-5" align="right">
                                    <strong><label>ชื่อพันธุ์ไม้ : </label></strong>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label id="plant_name"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table id="stock_recieve_detailTable" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>เกรด</th>
                            <th>จำนวน (ต้น)</th>

                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<?php

$sql_detail = "SELECT tb_stock_recieve_detail.recieve_detail_id as recieve_detail_id,
tb_stock_recieve_detail.recieve_detail_amount as recieve_detail_amount,
tb_stock_recieve_detail.recieve_detail_status as recieve_detail_status,
tb_stock_recieve_detail.ref_stock_recieve_id as ref_stock_recieve_id,
tb_stock_recieve.stock_recieve_amount as stock_recieve_amount,
tb_grade.grade_id as grade_id,
tb_grade.grade_name as grade_name,
tb_plant.plant_id as plant_id,
tb_plant.plant_name as plant_name
FROM tb_stock_recieve_detail
LEFT JOIN tb_stock_recieve ON tb_stock_recieve_detail.ref_stock_recieve_id = tb_stock_recieve.stock_recieve_id
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_recieve_detail.ref_grade_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_recieve_detail.ref_plant_id
WHERE tb_stock_recieve_detail.recieve_detail_status ='เสร็จสิ้น'
ORDER BY tb_stock_recieve_detail.recieve_detail_id ASC";


$result2 = mysqli_query($conn, $sql_detail);
if ($result2->num_rows > 0) {

    while ($row2 = $result2->fetch_array()) {

        $recieve_detail_id = $row2['recieve_detail_id'];
        $recieve_detail_amount = $row2['recieve_detail_amount'];
        $plant_id = $row2['plant_id'];
        $ref_stock_recieve_id = $row2['ref_stock_recieve_id'];
        $plant_name = $row2['plant_name'];
        $recieve_amounts = $row2['stock_recieve_amount'];

?>

        <div id="edit_recieve_detail<?php echo $recieve_detail_id ?>" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="fas fa-prescription-bottle"></i>
                            แก้ไขจำนวนต้นไม้</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body"><br>
                        <form role="form" method="post" action="" id="edit_details<?php echo $recieve_detail_id; ?>" class="edit_details">
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <strong><label>ชื่อพันธุ์ไม้ : </label></strong>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label id="plant_name2"><?php echo $plant_name ?></label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <strong><label>จำนวนที่รับเข้า : </label></strong>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <!-- <input type="text" class="form-control " id="edit_detail_sum<?= $recieve_detail_id ?>" name="edit_detail_sum" value="<?= $recieve_amounts ?>" disabled> -->
                                                <label id="edit_detail_sum<?= $recieve_detail_id ?>"><?php echo $recieve_amounts ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-sm-12">

                                <?php
                                $sql_grade3 = "SELECT tb_grade.grade_id as grade_id,
                                    tb_grade.grade_name as grade_name,
                                    tb_stock_recieve_detail.recieve_detail_amount as recieve_detail_amount,
                                    tb_plant.plant_name as plant_name
                
                                    FROM tb_stock_recieve_detail
                                    LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_recieve_detail.ref_grade_id
                                    LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_recieve_detail.ref_plant_id
                                    WHERE tb_stock_recieve_detail.recieve_detail_status = 'เสร็จสิ้น' AND tb_stock_recieve_detail.ref_stock_recieve_id = '$ref_stock_recieve_id'
                                    AND tb_stock_recieve_detail.ref_plant_id ='$plant_id'
                                    ORDER BY tb_grade.grade_id ASC";
                                $result3 = mysqli_query($conn, $sql_grade3);
                                while ($row3 = mysqli_fetch_array($result3)) {

                                    $grade_id = $row3['grade_id'];
                                    $grade_name = $row3['grade_name'];
                                    $recieve_amount = $row3['recieve_detail_amount'];

                                ?>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>
                                                <h1>เกรด : <?= $grade_name ?></h1>
                                            </label>
                                        </div>&nbsp;&nbsp;
                                        <input type="hidden" class="form-control edit_detail_grade<?= $recieve_detail_id ?>" id="edit_detail_grade<?= $recieve_detail_id ?>" name="edit_detail_grade" value="<?= $grade_id ?>" data="<?= $recieve_detail_id ?>">

                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="textbox" class="form-control edit_detail_amount<?= $recieve_detail_id ?>" id="edit_detail_amount<?= $grade_id . $recieve_detail_id ?>" name="edit_detail_amount" value="<?= $recieve_amount ?>">
                                            </div>
                                        </div>
                                        <span> ต้น</span>&nbsp;
                                        <strong><span style="color:red"> *</span></strong>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                    </div>


                    <div class="row">
                        <div class="col-6">
                            <div class="form-group" align="right">
                                <button type="button" class="btn btn-outline-success" name="btn_edit_detail" id="btn_edit_detail" data-id="<?= $recieve_detail_id ?>">บันทึก</button>
                            </div>
                        </div>
                        <div class="col-6" align="left">
                            <div class="form-group">
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">ยกเลิก</button>
                            </div>
                        </div>
                    </div>
                </div><br>
            </div>
        </div>
        </div>

<?php
    }
}
?>