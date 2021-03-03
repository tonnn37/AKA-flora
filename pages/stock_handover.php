<style>
    a.disabled {
        pointer-events: none;
        cursor: default;
    }
</style>
<?php
include('connect.php');

$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$m = date('m', $datenow);

$sql_group = "SELECT Max(handover_id) as maxid FROM tb_stock_handover";
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];

$tmp1 = "HO";
$minus = "-";
$tmp2 = substr($mem_old, 8, 3);
$Year = substr($mem_old, 2, 2);
$Month = substr($mem_old, 5, 2);
$sub_date = substr($d, 2, 2);

if ($Year != $sub_date) {
    $tmp2 = 0;
} else {
    $tmp2;
}

if ($Month != $m) {
    $tmp2 = 0;
} else {
    $tmp2;
}
$t = $tmp2 + 1;
$a = sprintf("%03d", $t);
$run_handover_id = $tmp1 . $sub_date . $minus . $m . $minus . $a;


$sql_group2 = "SELECT Max(handover_noplant_id) as maxid FROM tb_handover_noplant";
$result2 = mysqli_query($conn, $sql_group2);
$row_mem2 = mysqli_fetch_assoc($result2);
$mem_old2 = $row_mem2['maxid'];

$tmp12 = "HN";
$minus2 = "-";
$tmp22 = substr($mem_old2, 8, 3);
$Year2 = substr($mem_old2, 2, 2);
$Month2 = substr($mem_old2, 5, 2);
$sub_date2 = substr($d, 2, 2);

if ($Year2 != $sub_date2) {
    $tmp22 = 0;
} else {
    $tmp22;
}

if ($Month2 != $m) {
    $tmp22 = 0;
} else {
    $tmp22;
}
$t2 = $tmp22 + 1;
$a2 = sprintf("%03d", $t2);
$run_handover_noplant_id = $tmp12 . $sub_date2 . $minus . $m . $minus2 . $a2;

@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];

?>
<input type="hidden" id="per" value='<?php echo $permiss ?>'>
<div class="nav-wrapper">

    <ul class="nav nav-pills nav-fill flex-column flex-md-row nav-tabs" id="tabs-icons-text" role="tablist">
        <li class="nav-item active">
            <a class="nav-link btn-outline-success mb-sm-3 mb-md-0 active" id="tab1" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fas fa-comments-dollar"></i> รายการพรีออเดอร์</a>
        </li>
        <li class="nav-item nextab">
            <a class="nav-link  btn-outline-success mb-sm-3 mb-md-0" id="tab2" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="fas fa-store"></i> รายการลูกค้า walk-in</a>
        </li>

    </ul>

</div>

<div class="card1 shadow">
    <div class="card-body">

        <div class="tab-content" id="myTabContent">
            <?php
            if ($permiss == "พนักงาน") {
                $hidden = "hidden";
            } else {
                $hidden = "";
            }
            ?>

            <div class="tab-pane fade show active" <?php echo $hidden; ?> id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">

                <div class="row">
                    <div class="col-12">


                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row nav-tabs" id="tabs-icons-text" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link btn-outline-success mb-sm-2 mb-md-0 active" id="tab3" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="true"><i class="fas fa-seedling"></i> ส่งมอบตามจำนวนการปลูก</a>
                                </li>
                                <li class="nav-item nextab">
                                    <a class="nav-link  btn-outline-success mb-sm-2 mb-md-0" id="tab4" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false"><i class="fas fa-list-alt"></i> ส่งมอบตามจำนวนสต็อก</a>
                                </li>
                            </ul>

                        </div>


                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target=".bd-example-modal-lg" id="modal_handover"><i class="ni ni-fat-add"></i>
                                            ส่งมอบพันธุ์ไม้</button>
                                      
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table-bordered text-center" id="handoverTable" width="100%">
                                            <thead bgcolor="#2dce89" style="text-align: center;">
                                                <th>ลำดับ</th>
                                                <th>รหัสการส่งมอบ</th>
                                                <!--   <th>รหัสรายการคัดเกรด</th>
                                                <th>รหัสรายการสั่งซื้อ</th> -->
                                                <!--   <th>ชื่อรายการสั่งซื้อ</th> -->
                                                <th>ชื่อลูกค้า</th>
                                                <th>ชื่อพันธุ์ไม้</th>
                                                <th>จำนวนส่งมอบ (ต้น)</th>
                                                <th>วันที่บันทึก</th>
                                                <th>สถานะ</th>
                                                <th width="60"></th>

                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                           

                            <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target=".bd-example-modal-lg2" id="modal_handover_notplant"><i class="ni ni-fat-add"></i>
                                            ส่งมอบพันธุ์ไม้</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table-bordered text-center" width="100%" id="handover_notplanttable">
                                            <thead bgcolor="#2dce89" style="text-align: center;">
                                                <th>ลำดับ</th>
                                                <th>รหัสการส่งมอบ</th>
                                                <th>ชื่อลูกค้า</th>
                                                <th>ชื่อพันธุ์ไม้</th>
                                                <th>จำนวนส่งมอบ (ต้น)</th>
                                                <th>วันที่บันทึก</th>
                                                <th>สถานะ</th>
                                                <th width="100"></th>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--- เริ่ม modal ส่งมอบ --->
                        <div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="add_handover">
                            <div class="modal-dialog modal-lx">
                                <div class="modal-content" style="width: auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i>
                                            เพิ่มการส่งมอบ</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                            <h3>&times;</h3>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" method="post" action="pages/show_handover.php" target="_blank" id="in_handover">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รหัสการส่งมอบ : </label>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="in_handover_id" name="in_handover_id" value="<?= $run_handover_id ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รายการสั่งซื้อ : </label>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <select name="in_handover_order" class="form-control" id="in_handover_order">
                                                                    <option value="0">---โปรดเลือกรายการสั่งซื้อ---
                                                                    </option>
                                                                    <?php

                                                                    $sql_order = "SELECT tb_order_detail.order_detail_id as order_detail_id
                                                                    ,tb_order.order_id as order_id
                                                                    ,tb_order.order_name as order_name
                                                                    ,tb_customer.customer_firstname as customer_firstname
                                                                    ,tb_customer.customer_lastname as  customer_lastname

                                                                    FROM tb_stock_recieve_detail
                                                                    LEFT JOIN tb_stock_recieve ON tb_stock_recieve.stock_recieve_id = tb_stock_recieve_detail.ref_stock_recieve_id
                                                                    LEFT JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_stock_recieve.ref_planting_detail_id
                                                                    LEFT JOIN tb_order_detail ON tb_order_detail.order_detail_id = tb_planting_detail.ref_order_detail_id
                                                                    LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
                                                                    LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_recieve_detail.ref_plant_id
                                                                    LEFT JOIN tb_grade ON tb_grade.grade_id  = tb_stock_recieve_detail.ref_grade_id
                                                                    LEFT JOIN tb_customer ON tb_order.order_customer = tb_customer.customer_id
                                                                    
                                                                    WHERE tb_order_detail.order_detail_status = 'รอส่งมอบ'
                                                                    GROUP BY tb_order_detail.order_detail_id";

                                                                    $re_order = mysqli_query($conn, $sql_order);
                                                                    while ($re_row = mysqli_fetch_array($re_order)) {


                                                                    ?>
                                                                        <option value="<?php echo $re_row["order_id"]; ?>">
                                                                            <?php echo $re_row["order_name"] . " " . "(" . $re_row['customer_firstname'] . " " . $re_row['customer_lastname'] . ")"; ?>
                                                                        </option>
                                                                    <?php

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
                                                                <select name="in_handover_order_detail" class="form-control" id="in_handover_order_detail" disabled>
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
                                                    <table class="table-striped table-bordered text-center" id="handover_detailTable" width="100%">
                                                        <thead bgcolor="#2dce89">
                                                            <th>ลำดับ</th>
                                                            <th>ชื่อรายการ</th>
                                                            <th>ชื่อลูกค้า</th>
                                                            <th>ชื่อพันธุ์ไม้</th>
                                                            <th>จำนวนที่ต้องส่ง (ต้น)</th>
                                                            <th>รายละเอียด</th>
                                                            <th>วันที่นัดส่งมอบ</th>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div><br>
                                            <div class="row" id="show_1">
                                                <div class="col-4" align="right">
                                                    <strong><label>รายการคัดเกรด : </label></strong>
                                                </div>
                                            </div>
                                            <div id="show_modal"></div>
                                            <div id="show_modal2" hidden></div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <strong><label>จำนวนที่ต้องส่งมอบ : </label></strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control in_handover_planting_amount" id="in_handover_planting_amount" name="in_handover_planting_amount" readonly>
                                                            </div>
                                                        </div>
                                                        <span> ต้น</span>
                                                    </div>
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
                                                            <label>เกรด&nbsp;<?= $grade_name ?> :</label>
                                                        </div>
                                                        <div class="col-1">
                                                            <div class="form-group">
                                                                <input type="checkbox" class="form-control in_handover_grade_id" id="in_handover_grade_id<?= $grade_id ?>" name="in_handover_grade_id_use" value="<?= $grade_id ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <input type="textbox" class="form-control in_handover_grade_amount" id="in_handover_grade_amount<?= $grade_id ?>" name="in_handover_grade_amount" disabled data-grade="<?= $grade_id ?>">
                                                                <span class="error_grade" id="error_grade<?= $grade_id ?>"></span>
                                                                <div id="show_modal3<?= $grade_id ?>" hidden></div>
                                                                <div id="show_modal4<?= $grade_id ?>" hidden></div>

                                                            </div>
                                                        </div>
                                                        <span> ต้น</span>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group" align="right">
                                                        <button type="button" class="btn btn-outline-success" name="btn_add_stock_handover" id="btn_add_stock_handover">บันทึก</button>
                                                    </div>
                                                </div>
                                                <div class="col-6" align="left">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-outline-danger" id="cancel" data-dismiss="modal">ยกเลิก</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--- เริ่ม modal ส่งมอบ --->
                        <div class="modal fade bd-example-modal-lg2 " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="add_handover_noplanting">
                            <div class="modal-dialog modal-lx">
                                <div class="modal-content" style="width: auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i>
                                            เพิ่มการส่งมอบ</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                            <h3>&times;</h3>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" method="post" action="pages/show_handover.php" target="_blank" id="in_handover">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รหัสการส่งมอบ : </label>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="in_handover_noplant_id" name="in_handover_noplant_id" value="<?= $run_handover_noplant_id ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <label>รายการสั่งซื้อ : </label>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <select name="in_handover_noplant_order" class="form-control" id="in_handover_noplant_order">
                                                                    <option value="0">---โปรดเลือกรายการสั่งซื้อ---
                                                                    </option>
                                                                    <?php

                                                                    $sql_order = "SELECT * FROM tb_order_detail
                                                                    LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
                                                                    LEFT JOIN tb_customer  ON tb_customer.customer_id = tb_order.order_customer
                                                                    WHERE tb_order_detail.order_detail_status = 'รอส่งมอบ' AND tb_order_detail.order_detail_planting_status = 'ยังไม่ได้ทำการปลูก'";

                                                                    $re_order = mysqli_query($conn, $sql_order);
                                                                    while ($re_row = mysqli_fetch_array($re_order)) {


                                                                    ?>
                                                                        <option value="<?php echo $re_row["order_id"]; ?>">
                                                                            <?php echo $re_row["order_name"] . " " . "(" . $re_row['customer_firstname'] . " " . $re_row['customer_lastname'] . ")"; ?>
                                                                        </option>
                                                                    <?php

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
                                                                <select name="in_handover_noplant_order_detail" class="form-control" id="in_handover_noplant_order_detail" disabled>
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
                                                    <table class="table-striped table-bordered text-center" id="handover_detail_noplantTable" width="100%">
                                                        <thead bgcolor="#2dce89">
                                                            <th>ลำดับ</th>
                                                            <th>รหัสรายการ</th>
                                                            <th>ชื่อรายการ</th>
                                                            <th>ชื่อลูกค้า</th>
                                                            <th>ชื่อพันธุ์ไม้</th>
                                                            <th>จำนวนที่ต้องส่ง (ต้น)</th>
                                                            <th>รายละเอียด</th>
                                                            <th>วันที่ส่งมอบ</th>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <strong><label>จำนวนที่ต้องส่งมอบ : </label></strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control in_handover_noplant_amount" id="in_handover_noplant_amount" name="in_handover_noplant_amount" readonly>
                                                            </div>
                                                        </div>
                                                        <span> ต้น</span>
                                                    </div>
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
                                                            <label>เกรด&nbsp;<?= $grade_name ?> :</label>
                                                        </div>
                                                        <div class="col-1">
                                                            <div class="form-group">
                                                                <input type="checkbox" class="form-control in_handover_noplant_grade_id" id="in_handover_noplant_grade_id<?= $grade_id ?>" name="in_handover_noplant_grade_id" value="<?= $grade_id ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <input type="textbox" class="form-control in_handover_noplant_grade_amount" id="in_handover_noplant_grade_amount<?= $grade_id ?>" name="in_handover_noplant_grade_amount" disabled data-grade="<?= $grade_id ?>">
                                                                <span class="show_stock_amount" id="show_stock_amount<?= $grade_id ?>"></span>
                                                            </div>
                                                        </div>
                                                        <span> ต้น</span>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group" align="right">
                                                        <button type="button" class="btn btn-outline-success" name="btn_add_stock_handover_noplant" id="btn_add_stock_handover_noplant">บันทึก</button>
                                                    </div>
                                                </div>
                                                <div class="col-6" align="left">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-outline-danger" id="cancel" data-dismiss="modal">ยกเลิก</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div id="view_handover_detail" class="modal fade" role="dialog">
                            <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                                <div class="modal-dialog modal-lg">
                                    <!-- Modal content-->
                                    <div class="modal-content" style="width:auto">
                                        <div class="modal-header">
                                            <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายละเอียดการส่งมอบพันธุ์ไม้
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
                                                            <strong><label>รหัสการส่งมอบ : </label></strong>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <label id="recieve_id"></label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-5" align="right">
                                                            <strong><label>รหัสรายการสั่งซื้อ : </label></strong>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <label id="order_id"></label>
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

                                            </div><br>

                                            <table id="stock_handover_detailTable" class="table-bordered text-center" width="100%">
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

                        <div id="view_handover_noplant_detail" class="modal fade" role="dialog">
                            <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                                <div class="modal-dialog modal-lg">
                                    <!-- Modal content-->
                                    <div class="modal-content" style="width:auto">
                                        <div class="modal-header">
                                            <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายละเอียดการส่งมอบพันธุ์ไม้
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
                                                            <strong><label>รหัสรายการสั่งซื้อ : </label></strong>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <label id="order_ids"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-4" align="right">
                                                            <strong><label>ชื่อพันธุ์ไม้ : </label></strong>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <label id="plant_names"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table id="handover_noplant_detailTable" class="table-bordered text-center" width="100%">
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

                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-outline-warning" data-toggle="modal" id="modal_sale" data-target="#sale2"><i class="ni ni-fat-add"></i> เพิ่มรายการขาย</button>
                            <button type="submit" class="btn btn-outline-success" data-target="#modal_print" data-toggle="modal"><img src="image/1x/btnprint.png " width="25px" height="25px"></button>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered text-center" id="tb_sale" width="100%">
                                    <thead bgcolor="#2dce89" style="text-align: center;">
                                        <th>ลำดับ</th>
                                        <th>รหัสรายการ</th>
                                        <th>จำนวน (ต้น)</th>
                                        <th>ราคา (บาท)</th>
                                        <th>ผู้บันทึก</th>
                                        <th>วันที่บันทึก</th>
                                        <th>สถานะ</th>
                                        <th></th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="sale2">
    <div class="modal-dialog modal-lx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มรายการขาย</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="pages/show_payment.php" target="_blank" id="fm_total" class="fm_total">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ประเภทพันธุ์ไม้ : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <select name="sale_type_plant" class="form-control" id="sale_type_plant">
                                            <option value="0">---โปรดเลือกประเภทพันธ์ไม้---</option>
                                            <?php

                                            $sql_type_plant = "SELECT * FROM `tb_typeplant` WHERE type_plant_status='ปกติ'";

                                            $re_type_plant = mysqli_query($conn, $sql_type_plant);
                                            while ($row_type_plant = mysqli_fetch_array($re_type_plant)) {
                                            ?>
                                                <option value="<?php echo $row_type_plant["type_plant_id"]; ?>">
                                                    <?php echo $row_type_plant["type_plant_name"]; ?>
                                                </option>
                                            <?php
                                            } //วน loop listview แสดงชื่อคนที่จะให้สิทธิ์
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span></strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>เกรด : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <select name="sale_grade" class="form-control" id="sale_grade">
                                            <option value="0">---โปรดเลือกเกรดพันธ์ไม้---</option>
                                            <?php

                                            $sql_type_plant = "SELECT * FROM `tb_grade` WHERE grade_status='ปกติ'";

                                            $re_type_plant = mysqli_query($conn, $sql_type_plant);
                                            while ($row_type_plant = mysqli_fetch_array($re_type_plant)) {
                                            ?>
                                                <option value="<?php echo $row_type_plant["grade_id"]; ?>">
                                                    <?php echo $row_type_plant["grade_name"]; ?>
                                                </option>
                                            <?php
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
                                <div class="col-7">
                                    <div class="form-group">
                                        <select name="sale_plant" class="form-control sale_plant" id="sale_plant" disabled>
                                            <option value="0">---โปรดเลือกพันธุ์ไม้---</option>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span></strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ราคา : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="sale_price" readonly name="sale_price">
                                    </div>
                                </div>
                                <span>บาท</span>&nbsp;
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>จำนวน : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control sale_amount" id="sale_amount" name="sale_amount" min='0'>
                                        <span class="stock_amount" id="stock_amount"></span>
                                    </div>
                                </div>
                                <span>ต้น</span>&nbsp;
                                <strong><span style="color:red">*</span></strong>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="fileinput fileinput-new text-center a" data-provides="fileinput" align="center">
                                    <img src="image/plant.png" id="sale_picture" align="center" width="200" height="250" style="object-fit: fill;  border-radius: 8px;"><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table-striped table-bordered text-center" id="tbl_sale_list" width="100%">
                                <thead bgcolor="#2dce89">
                                    <th>ลำดับ</th>
                                    <th>รหัสพันธ์ไม้</th>
                                    <th>ชื่อพันธุ์ไม้</th>
                                    <th>เกรด</th>
                                    <th>ราคา (บาท)</th>
                                    <th>จำนวน (ต้น)</th>
                                    <th>รวม (บาท)</th>
                                    <th></th>
                                </thead>
                            </table>
                        </div>
                    </div><br><br>
            </div>
            <div class="row">
                <div class="col-8" align="right">
                    <label>ราคารวม : </label>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <input type="text" class="form-control" id="sale_total" readonly name="sale_total">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8" align="right">
                    <label>รับเงิน : </label>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <input type="text" class="form-control" id="sale_money" name="sale_money">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8" align="right">
                    <label>เงินทอน : </label>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <input type="text" class="form-control" id="sale_change" readonly name="sale_change">
                    </div>
                </div>
            </div>
            <div class="modal-footer" align="center">
                <div class="form-group" align="right">
                    <button type="button" class="btn btn-outline-info" name="btn_add_order" id="btn_add_list">เพิ่มรายการ</button>
                </div>
                <div class="form-group" align="right">
                    <button type="button" class="btn btn-outline-success" name="btn_save_order" id="btn_save_order">บันทึก</button>
                </div>

                <div class="form-group">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-danger">ยกเลิก</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<div id="view_payment_detail" class="modal fade" role="dialog">
    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="width:auto">
                <div class="modal-header">
                    <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายละเอียดรายการขาย
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                        <h3>&times;</h3>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="payment_detailTable" class="table-striped table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>ชื่อพันธุ์ไม้</th>
                            <th>เกรด</th>
                            <th>จำนวน (ต้น)</th>
                            <th>ราคา (บาท/ต้น)</th>
                            <th>ราคารวม (บาท)</th>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal_print" class="modal fade" role="dialog">
    <form role="form" method="post" action="pages/print_payment.php" target="_blank" id="print_salelist">
        <div class="modal-dialog modal-md">
            <div class="modal-content" style="width:auto">
                <div class="modal-header">
                    <h5 class="modal-title card-title"><img src="image/1x/btnprint.png " width="25px" height="25px">&nbsp; พิมพ์ใบเสร็จการขาย
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                        <h3>&times;</h3>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12">

                        <div class="row">
                            <div class="col-3" align="right">
                                <label>รายการขาย : </label>
                            </div>
                            <div class="col-md-1.5">
                                <div class="dropdown">
                                    <div class="form-group">
                                        <select name="sale_list" class="form-control" id="sale_list">
                                            <option value="0">---โปรดเลือกรายการขาย---</option>
                                            <?php

                                            $sql_type_plant = "SELECT * FROM `tb_payment` WHERE payment_status='เสร็จสิ้น'
                                            ORDER BY payment_id DESC";

                                            $re_type_plant = mysqli_query($conn, $sql_type_plant);
                                            while ($row_type_plant = mysqli_fetch_array($re_type_plant)) {
                                            ?>
                                                <option value="<?php echo $row_type_plant["payment_id"]; ?>">
                                                    <?php echo $row_type_plant["payment_id"]; ?>
                                                </option>
                                            <?php
                                            } //วน loop listview แสดงชื่อคนที่จะให้สิทธิ์
                                            ?>
                                        </select>

                                    </div>

                                </div>
                                <strong><span style="color:red"> *</span></strong>&nbsp;&nbsp;
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="print_sale"><img src="image/1x/btnprint.png " width="25px" height="25px"></button>
                            </div>
                        </div>
                    </div><br>

                </div>
            </div>
        </div>
    </form>
</div>


<form role="form" method="post" action="pages/show_payment_remove.php" target="_blank" id="remove_payment">
    <input type="hidden" class="form-control" id="remove_payment_id" readonly name="remove_payment_id">
</form>