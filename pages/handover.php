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

$sql_group = "SELECT Max(handover_id) as maxid FROM tb_handover";
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
$run_handover_id = $tmp1 . $sub_date . $minus . $m . $minus . $a;


@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];

?>
<input type="hidden" id="per" value='<?php echo $permiss ?>'>


<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-outline-warning" data-toggle="modal" id="modal_handover" data-target=".bd-example-modal-lg"><i class="ni ni-fat-add"></i>เพิ่มการส่งมอบ</button>
    </div>
</div><br>

<!-- แสดงข้อมูลในตาราง -->
<div class="row">
    <div class="col-12">
        <table class="table table-bordered text-center" id="handoverTable" width="100%">
            <thead bgcolor="#2dce89" style="text-align: center;">
                <th>ลำดับ</th>
                <th>รหัสการส่งมอบ</th>
                <th>ชื่อรายการ</th>
                <th>ชื่อลูกค้า</th>
                <th>ชื่อพันธุ์ไม้</th>
                <th>จำนวนส่งมอบ</th>
                <th>คงเหลือเข้าสต็อค</th>
                <th>วันที่บันทึก</th>
                <th>สถานะ</th>
                <th></th>

            </thead>
        </table>
    </div>
</div>


<!--- เริ่ม modal รายการปลูก --->
<div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="add_handover">
    <div class="modal-dialog modal-lx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-single-02"></i> เพิ่มการส่งมอบ</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="" id="in_handover">
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
                                    <label>รายการปลูก : </label>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <select name="in_handover_planting" class="form-control" id="in_handover_planting">
                                            <option value="0">---โปรดเลือกรายการปลูก---</option>
                                            <?php

                                            $sql_order = "SELECT tb_planting.planting_id as planting_id
                                                                ,tb_plant.plant_name as plant_name
                                                                ,tb_order.order_name as order_name 
                                                                ,tb_order.order_customer as order_customer
                                                                ,tb_planting_detail.planting_detail_id as planting_detail_id
                                                        FROM tb_planting
                                                        LEFT JOIN tb_order ON tb_order.order_id = tb_planting.ref_order_id
                                                        LEFT JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
                                                        LEFT JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id = tb_planting_detail.planting_detail_id
                                                        LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
                                                        LEFT JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
                                                        WHERE tb_planting_detail.planting_detail_status ='ปกติ' AND  tb_planting_week.planting_week_status ='เสร็จสิ้น'  
                                                        GROUP BY tb_planting.planting_id
                                                        ORDER BY tb_planting_detail.planting_detail_id ASC";

                                            $re_order = mysqli_query($conn, $sql_order);
                                            while ($re_row = mysqli_fetch_array($re_order)) {
                                            ?>
                                                <option value="<?php echo $re_row["planting_id"]; ?>">
                                                    <?php echo $re_row["order_name"] . " " . "(" . $re_row['order_customer'] . ")"; ?>
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
                                        <select name="in_handover_planting_detail" class="form-control" id="in_handover_planting_detail" disabled>
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
                                    <th>รหัสรายการ</th>
                                    <th>รหัสพันธุ์ไม้</th>
                                    <th>พันธุ์ไม้</th>
                                    <th>จำนวนปลูก</th>
                                    <th>ต้นตาย</th>
                                    <th>วันที่ส่งมอบ</th>
                                    <th>สถานะ</th>
                                </thead>
                            </table>
                        </div>
                    </div><br><br>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>จำนวนที่ต้องส่งมอบ : </label>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_handover_planting_amount" name="in_handover_planting_amount" readonly>
                                    </div>
                                </div>
                                <span> ต้น</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>จำนวนปลูกทั้งหมด : </label>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_handover_amount" name="in_handover_amount">
                                    </div>
                                </div>
                                <span> ต้น</span>
                            </div>
                        </div>
                        <div class="modal-header">
                            <h5 class="modal-title card-title"><i class="fas fa-plus"></i> เพิ่มข้อมูลเข้าสต็อค</h5>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>จำนวนคงเหลือ : </label>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_handover_total" name="in_handover_total" readonly>
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
                                            <input type="checkbox" class="form-control in_handover_grade_id" id="in_handover_grade_id" name="in_handover_grade_id" value="<?= $grade_id ?>">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="textbox" class="form-control in_handover_grade_amount" id="in_handover_grade_amount<?= $grade_id ?>" name="in_handover_grade_amount" disabled>
                                        </div>
                                    </div>
                                    <span> ต้น</span>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div><br>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group" align="right">
                                <button type="button" class="btn btn-outline-success" name="btn_add_stock_recieve" id="btn_add_stock_recieve">บันทึก</button>
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