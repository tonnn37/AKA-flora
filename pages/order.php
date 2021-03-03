<?php
include('connect.php');

//--- รันรหัสรายการสั่งซื้อ ---//
date_default_timezone_set("Asia/Bangkok");



function CalDate($time1, $time2)
{
    //Convert date to formate Timpstamp
    $time1 = strtotime($time1);
    $time2 = strtotime($time2);

    //$diffdate=$time1-$time2
    $distanceInSeconds = round(abs($time2 - $time1)); //จะได้เป็นวินาที
    $distanceInMinutes = round($distanceInSeconds / 60); //แปลงจากวินาทีเป็นนาที

    $days = floor(abs($distanceInMinutes / 1440));

    return $days;
}


$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$m = date('m', $datenow);

$sql_group = "SELECT Max(order_id) as maxid FROM tb_order";
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];

$tmp1 = "OR";
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
$run_order_id = $tmp1 . $sub_date . $minus . $m . $minus . $a;



@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];

?>


<input type="hidden" id="per" value='<?php echo $permiss ?>'>


<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target=".bd-example-modal-lg" id="btn_in_order"><i class="ni ni-fat-add"></i> เพิ่มรายการสั่งซื้อ</button>
        <!--   <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target=".add_order_detail" id="btn_add_order_detail"><i class="ni ni-fat-add"></i> เพิ่มจำนวนรายการสั่งซื้อ</button> -->
        <button type="button" class="btn btn-outline-success" id ="search_modal" title="ตัวเลือกการค้นหา" data-target="#modal_search" data-toggle="modal"><img src="image/1x/btnsearch.png" width="25px" height="25px"></button>
    </div>
</div><br>

<!-- แสดงข้อมูลในตาราง -->
<div class="row">
    <div class="col-sm-12">
        <table class="table-bordered text-center" id="orderTable" width="100%">

            <thead bgcolor="#2dce89">
                <th>ลำดับ</th>
                <th>รหัส<br></brt>รายการ</th>
                <th>ชื่อรายการ</th>
                <th>ชื่อลูกค้า</th>
                <th>จำนวนเงิน (บาท)</th>
                <th>รายการปลูก</th>
                <th>รายละเอียดเพิ่มเติม</th>
                <th>วันที่บันทึก</th>
                <th>สถานะ</th>
                <th width="120"></th>
            </thead>
        </table>
    </div>
</div>
<?php
$sql = "SELECT tb_order.order_id as order_id, tb_order.order_name as order_name,
                                tb_order.order_date as order_date,tb_order.order_status as order_status,tb_order.order_detail as order_detail,
                                tb_order.order_customer as order_customer , tb_order.order_price as order_price,
                                tb_customer.customer_firstname as customer_firstname, tb_customer.customer_lastname as customer_lastname, tb_customer.customer_id as customer_id,
                                tb_plant.plant_time as plant_time
                                FROM tb_order
                                LEFT JOIN tb_order_detail ON tb_order_detail.ref_order_id = tb_order.order_id
                                LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
                                LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
                                GROUP BY order_id 
                                ORDER BY order_id ASC";

$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {

        $i++;

        $order_id = $row['order_id'];

        $sql_count = "SELECT COUNT(tb_order_detail.order_detail_id) as count FROM tb_order_detail WHERE tb_order_detail.ref_order_id='$order_id'  ";
        $re_count = mysqli_query($conn, $sql_count);
        $r_count = mysqli_fetch_assoc($re_count);
        $sum_order = $r_count['count'];

        if ($sum_order == "") {
            $sum_order = 0;
        }

        $cutomer_id = $row['customer_id'];
        $order_name = $row['order_name'];
        $order_customer = $row['customer_firstname'] . " " . $row['customer_lastname'];
        $order_price = $row['order_price'];
        $order_detail = $row['order_detail'];
        $order_date = $row['order_date'];
        $order_status = $row['order_status'];
        $plant_time = $row['plant_time'];

?>
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
        <!--- เริ่ม modal แก้ไขรายการออเดอร์--->
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="edit_orders<?php echo $order_id; ?>">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="width:auto">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขรายการสั่งซื้อ</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="post" class="insert" id="editOrder<?= $order_id ?>">
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รหัสรายการ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="edit_order_id" name="edit_order_id" value="<?= $order_id ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ชื่อรายการ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit_order_name" id="edit_order_name<?= $order_id ?>" name="edit_order_name" data-id="<?= $order_id ?>" value="<?= $order_name ?>">
                                            </div>
                                        </div>
                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ชื่อลูกค้า : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <select name="edit_order_cutomer" class="form-control" id="edit_order_cutomer<?= $order_id ?>">
                                                    <option value="0">---โปรดเลือกชื่อลูกค้า---</option>
                                                    <?php
                                                    $sql_customer = "SELECT * FROM tb_customer                                                
                                            WHERE customer_status ='ปกติ' ORDER BY customer_firstname ASC";
                                                    $re_customer = mysqli_query($conn, $sql_customer);
                                                    while ($row_customer = mysqli_fetch_array($re_customer)) {
                                                    ?>
                                                        <option <?php if ($cutomer_id == $row_customer['customer_id']) {
                                                                    echo "selected";
                                                                } ?> value="<?php echo $row_customer["customer_id"]; ?>">
                                                            <?php echo $row_customer["customer_firstname"] . " " . $row_customer["customer_lastname"];  ?>
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
                                            <label>จำนวนเงิน : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">

                                                <input type="text" class="form-control edit_order_price" id="edit_order_price<?= $order_id ?>" onkeyup="this.value=Comma(this.value);" name="edit_order_price" value="<?php echo number_format($order_price) ?>">
                                            </div>
                                        </div>
                                        <span>บาท</span>&nbsp;<strong><span style="color:red" class=red_firstname> *</span> </strong>

                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รายละเอียดเพิ่มเติม : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <textarea class="form-control " id="edit_order_detail<?= $order_id ?>" rows="5" name="edit_order_detail"><?= $order_detail ?></textarea>
                                            </div>
                                        </div>
                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                    </div>

                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group" align="right">
                                        <button type="button" class="btn btn-outline-success" name="btn_edit_save_order" id="btn_edit_save_order" data-id="<?= $order_id ?>">บันทึก</button>
                                    </div>
                                </div>
                                <div class="col-6" align="left">
                                    <div class="form-group">
                                        <button type="button" data-dismiss="modal" class="btn btn-outline-danger">ยกเลิก</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
<?php
    } //end while
} //end if
?>

<!--- เริ่ม modal เพิ่มรายการสั่งซื้อ--->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="order">
    <div class="modal-dialog modal-lx">
        <div class="modal-content" style="width:auto">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มรายการสั่งซื้อ</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" class="insert" id="addOrder">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รหัสรายการ : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_order_id" name="in_order_id" value="<?= $run_order_id ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ชื่อรายการ : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control in_order_name" id="in_order_name" name="in_order_name" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ชื่อลูกค้า : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <select name="in_order_cutomer" class="form-control" id="in_order_cutomer">
                                            <option value="0">---โปรดเลือกชื่อลูกค้า---</option>
                                            <?php
                                            $sql_customer = "SELECT * FROM tb_customer                                                
                                            WHERE customer_status ='ปกติ' ORDER BY customer_firstname ASC";
                                            $re_customer = mysqli_query($conn, $sql_customer);
                                            while ($row_customer = mysqli_fetch_array($re_customer)) {
                                            ?>
                                                <option value="<?php echo $row_customer["customer_id"]; ?>">
                                                    <?php echo $row_customer["customer_firstname"] . " " . $row_customer["customer_lastname"];  ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>จำนวนเงิน : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <script LANGUAGE="JavaScript">
                                            function Comma(Num) {
                                                Num += '';
                                                Num = Num.replace(/,/g, '');

                                                x = Num.split('.');
                                                x1 = x[0];
                                                x2 = x.length > 1 ? '.' + x[1] : '';
                                                var rgx = /(\d+)(\d{3})/;
                                                while (rgx.test(x1))
                                                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                                                return x1 + x2;
                                            }
                                        </script>

                                        <input type="text" class="form-control in_order_price" id="in_order_price" name="in_order_price" onkeyup="this.value=Comma(this.value);" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <span>บาท</span>&nbsp;&nbsp;
                                <strong><span style="color:red"> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รายละเอียดเพิ่มเติม : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <textarea class="form-control in_order_detail" id="in_order_detail" rows="5" name="in_order_detail" placeholder="กรุณากรอกข้อมูล"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ประเภทพันธุ์ไม้ : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <select name="in_order_typeplant" class="form-control" id="in_order_typeplant">
                                            <option value="0">---โปรดเลือกประเภทพันธุ์ไม้---</option>
                                            <?php
                                            $sql_type1 = "SELECT * FROM tb_typeplant                                                
                                            WHERE type_plant_status ='ปกติ' ORDER BY type_plant_name ASC";
                                            $re_type1 = mysqli_query($conn, $sql_type1);
                                            while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                            ?>
                                                <option value="<?php echo $re_fac1["type_plant_id"]; ?>">
                                                    <?php echo $re_fac1["type_plant_name"];  ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span> </strong>
                            </div>

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>พันธุ์ไม้ : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <select name="in_order_plant" class="form-control " id="in_order_plant" data-id="<?= $run_order_id ?>">
                                            <option value="0">---โปรดเลือกพันธุ์ไม้---</option>

                                        </select>
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>จำนวนปลูก : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control in_order_amount" id="in_order_amount" name="in_order_amount" placeholder="กรุณากรอกข้อมูล">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <span class="show_amount" id="show_amount"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span>ต้น</span>&nbsp;&nbsp;
                                <strong><span style="color:red"> *</span> </strong>
                            </div>


                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>จำนวนที่ปลูกเผื่อ : </label>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control in_order_amount_for" min="0" max="100" id="in_order_amount_for" name="in_order_amount_for" placeholder="กรอกข้อมูล">
                                    </div>
                                </div>
                                <span>&nbsp;&nbsp;%<br>&nbsp;เป็น : </span>&nbsp;
                                <label></label>
                                <div class="col-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_order_plant_cal_amount_for" name="in_order_plant_cal_amount_for" readonly>
                                    </div>
                                </div>
                                <span>ต้น</span>&nbsp;
                                <strong><span style="color:red" class=red_firstname> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>จำนวนทั้งหมด : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="number" class="form-control in_order_amount_total" id="in_order_amount_total" name="in_order_amount_total" readonly>
                                    </div>
                                </div>
                                <span>ต้น</span>&nbsp;&nbsp;
                            </div>

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ระยะเวลาปลูก : </label>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_order_plant_time" name="in_order_plant_time" readonly>
                                    </div>
                                </div>
                                <span>สัปดาห์<br>&nbsp;หรือ : </span>&nbsp;

                                <label></label>

                                <div class="col-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="in_order_plant_time_day" name="in_order_plant_time_day" readonly>
                                    </div>
                                </div>
                                <span>วัน</span>&nbsp;
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>วันที่ส่งมอบ : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="date" class="form-control " id="in_order_end" name="in_order_end" placeholder="กรุณากรอกข้อมูล">
                                        <?php date_default_timezone_set("Asia/Bangkok");
                                        $datenow = date("Y-m-d"); ?>
                                        <input type="hidden" class="form-control" id="in_order_daynow" name="in_order_daynow" value="<?= $datenow ?>" readonly>
                                        <!--  <span>(วันที่ส่งมอบได้ทำการเผื่อจากระยะเวลาปลูกอีก 2 อาทิตย์)</span> -->
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ระยะเวลา : </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" class="form-control in_order_day" id="in_order_day" name="in_order_day" readonly>

                                    </div>
                                </div>
                                <span>วัน</span>&nbsp;&nbsp;
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="fileinput fileinput-new text-center a" data-provides="fileinput" align="center">
                                    <img src="image/plant.png" id="add_picture" align="center" width="200" height="250" style="object-fit: fill;  border-radius: 8px;"><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table-responsive table-bordered text-center" id="add_orderTable" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>รหัสรายการ</th>
                            <th>พันธุ์ไม้</th>
                            <th>จำนวน (ต้น)</th>
                            <th>ปลูกเผื่อ (ต้น)</th>
                            <th>จำนวนทั้งหมด (ต้น)</th>
                            <th>วันที่ส่งมอบ</th>
                            <th>ระยะเวลา (วัน)</th>
                            <th></th>
                        </thead>

                    </table>
            </div>
            <div class="modal-footer" align="center">
                <div class="form-group" align="right">
                    <button type="button" class="btn btn-outline-info" name="btn_add_order" id="btn_add_order" data-id="<?= $run_order_id ?>">เพิ่มรายการ</button>
                </div>
                <div class="form-group" align="right">
                    <button type="button" class="btn btn-outline-success" name="btn_save_order" id="btn_save_order">บันทึก</button>
                </div>

                <div class="form-group">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-danger">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<!-- ตารางรายละเอียดออเดอร์ ในปุ่มแสดงรายละเอียด -->
<div id="view_dialog" class="modal fade" role="dialog">
    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="modal-dialog modal-xxxxl">
            <!-- Modal content-->
            <div class="modal-content" style="width:auto">
                <div class="modal-header">
                    <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายละเอียดรายการสั่งซื้อ
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
                                        <label id="show_order_id"></label>
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
                                <div class="col-3">
                                    <div class="form-group">
                                        <label id="show_customer"></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="edit_item_id" value="<?php echo $order_id; ?>">
                    <table id="tb_order_detail" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>รหัสรายการ</th>
                            <th>ชื่อพันธุ์ไม้</th>
                            <th>จำนวน (ต้น)</th>
                            <th>ปลูกเผื่อ (ต้น)</th>
                            <th>จำนวนทั้งหมด (ต้น)</th>
                            <th>วันที่ส่งมอบ</th>
                            <th>ระยะเวลาที่เหลือ (วัน)</th>
                            <th>สถานะการปลูก</th>
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
$query = "SELECT tb_order_detail.order_detail_id as order_detail_id,tb_order_detail.order_detail_amount as order_detail_amount,tb_order_detail.order_detail_status as order_detail_status,
tb_order_detail.order_detail_enddate as order_detail_enddate, tb_order_detail.ref_plant_id as ref_plant_id, tb_order_detail.ref_order_id as ref_order_id,
tb_order_detail.order_detail_per as order_detail_per, tb_order_detail.order_detail_total as order_detail_total, 
tb_plant.plant_name as plant_name,tb_plant.picture as picture,
tb_typeplant.type_plant_name as type_plant_name
,tb_order_detail.order_detail_planting_status as order_detail_planting_status

FROM tb_order_detail
LEFT JOIN tb_order ON tb_order.order_id= tb_order_detail.ref_order_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
LEFT JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
ORDER BY tb_order_detail.order_detail_id ASC";

$re_new = mysqli_query($conn, $query);
if ($re_new->num_rows > 0) {
    // output data of each row

    $i = 0;
    while ($row = $re_new->fetch_assoc()) {
        $order_detail_id = $row['order_detail_id'];
        $order_detail_amount = $row['order_detail_amount'];
        $order_detail_status = $row['order_detail_status'];
        $order_detail_enddate = $row['order_detail_enddate'];
        $order_detail_per = $row['order_detail_per'];
        $order_detail_total = $row['order_detail_total'];


        $ref_plant_id = $row['ref_plant_id'];
        $plant_name = $row['plant_name'];
        $picture = $row['picture'];

        $type_name = $row['type_plant_name'];

        $ref_order_id = $row['ref_order_id'];

        date_default_timezone_set("Asia/Bangkok");
        $date1 = date("Y-m-d");

        if ($row['order_detail_planting_status'] == "ยังไม่ได้ทำการปลูก") {

            $readonly = "";
        } else {
            $readonly = "readonly";
        }

        /*    echo CalDate($date1,$date2); */



?>
        <div id="edit_detail<?php echo $order_detail_id; ?>" class="modal fade edit_detail" role="dialog">

            <div class="modal-dialog modal-lg">

                <!-- edit  detail-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="fas fa-edit"></i>
                            แก้ไขข้อมูลรายการสั่งซื้อ</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data" id="edit_detailorder<?= $order_detail_id ?>">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รหัสรายการ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" id="edit_detail_order_id<?= $order_detail_id ?>" name="edit_detail_order_id" value="<?= $ref_order_id ?>">
                                                <input type="text" class="form-control" id="edit_detail_id<?= $order_detail_id ?>" name="edit_detail_id" value="<?= $order_detail_id ?>" readonly>
                                            </div>
                                        </div>
                                        <strong><span style="color:red"> *</span></strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ประเภทพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <select name="edit_order_typeplant_detail" class="form-control edit_order_typeplant_detail" id="edit_order_typeplant_detail<?= $order_detail_id ?>" data-id="<?= $order_detail_id ?>">
                                                    <option value="0">---โปรดเลือกประเภทพันธุ์ไม้---</option>
                                                    <?php
                                                    $sql_type1 = "SELECT * FROM tb_typeplant                                                
                                                    WHERE type_plant_status ='ปกติ' ORDER BY type_plant_name ASC";
                                                    $re_type1 = mysqli_query($conn, $sql_type1);
                                                    while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                                    ?>
                                                        <option <?php if ($type_name == $re_fac1['type_plant_name']) {
                                                                    echo "selected";
                                                                } ?> value="<?php echo $re_fac1["type_plant_id"]; ?>">
                                                            <?php echo $re_fac1["type_plant_name"];  ?>
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
                                            <label>พันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <select name="edit_order_plant_detail" class="form-control edit_order_plant_detail" id="edit_order_plant_detail<?= $order_detail_id ?>" data-id="<?= $order_detail_id ?>">
                                                    <option value="0">---โปรดเลือกพันธุ์ไม้---</option>
                                                    <?php
                                                    $sql_type1 = "SELECT * FROM tb_plant WHERE plant_status ='ปกติ' ORDER BY plant_id ASC";
                                                    $re_type1 = mysqli_query($conn, $sql_type1);
                                                    while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                                    ?>
                                                        <option <?php if ($plant_name == $re_fac1['plant_name']) {
                                                                    echo "selected";
                                                                } ?> value="<?php echo $re_fac1["plant_id"]; ?>">
                                                            <?php echo $re_fac1["plant_name"];  ?>
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
                                            <label>จำนวน : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit_order_amount_detail" <?php echo $readonly ?> id="edit_order_amount_detail<?= $order_detail_id ?>" data-id="<?= $order_detail_id ?>" name="edit_order_amount_detail" value="<?= $order_detail_amount ?>">
                                            </div>
                                        </div>
                                        <span>ต้น</span>&nbsp;&nbsp;
                                        <strong><span style="color:red"> *</span></strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>จำนวนที่ปลูกเผื่อ : </label>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="number" class="form-control edit_order_amount_for_detail" <?php echo $readonly ?> min="0" max="100" id="edit_order_amount_for_detail<?= $order_detail_id ?>" data-id="<?= $order_detail_id ?>" name="edit_order_amount_for_detail">
                                            </div>
                                        </div>
                                        <span>&nbsp;&nbsp;%<br>&nbsp;เป็น : </span>&nbsp;
                                        <label></label>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="edit_order_amount_for_detail_for<?= $order_detail_id ?>" name="edit_order_amount_for_detail_for" readonly>
                                            </div>
                                        </div>
                                        <span>ต้น</span>&nbsp;
                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>จำนวนทั้งหมด : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="number" class="form-control edit_order_amount_total_detail" id="edit_order_amount_total_detail<?= $order_detail_id ?>" name="edit_order_amount_total_detail" value="<?= $order_detail_total ?>" readonly>
                                            </div>
                                        </div>
                                        <span>ต้น</span>&nbsp;&nbsp;
                                    </div>


                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ระยะเวลาปลูก : </label>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="edit_order_plant_time_detail<?= $order_detail_id ?>" name="edit_order_plant_time_detail" readonly>
                                            </div>
                                        </div>
                                        <span>สัปดาห์<br>&nbsp;หรือ : </span>&nbsp;

                                        <label></label>

                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="edit_order_plant_time_day_detail<?= $order_detail_id ?>" name="edit_order_plant_time_day_detail" readonly>
                                            </div>
                                        </div>
                                        <span>วัน</span>&nbsp;

                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>วันที่ส่งมอบ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="date" class="form-control edit_order_end_detail" id="edit_order_end_detail<?= $order_detail_id ?>" name="edit_order_end_detail" value="<?= $order_detail_enddate ?>" data-id="<?= $order_detail_id ?>">
                                                <?php date_default_timezone_set("Asia/Bangkok");
                                                $datenow = date("Y-m-d"); ?>
                                                <input type="hidden" class="form-control" id="edit_order_daynow_detail<?= $order_detail_id ?>" name="edit_order_daynow_detail" value="<?= $datenow ?>" readonly>
                                                <input type="hidden" class="form-control" id="edit_order_end_detail2<?= $order_detail_id ?>" name="edit_order_end_detail2" value="<?= $order_detail_enddate ?>" readonly>
                                            </div>
                                        </div>
                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ระยะเวลา : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit_order_day_detail" id="edit_order_day_detail<?= $order_detail_id ?>" name="edit_order_day_detail" readonly>

                                            </div>
                                        </div>
                                        <span>วัน</span>&nbsp;&nbsp;
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="fileinput fileinput-new text-center a" data-provides="fileinput" align="center">
                                        <img src="image/plant/<?php echo $picture ?>" class="edit_picture_detail" id="edit_picture_detail" align="center" width="200" height="250" style="object-fit: fill;  border-radius: 8px;"><br><br>
                                    </div>
                                </div>
                            </div>

                    </div>
                    <div class="row">
                        <div class="col-6">

                            <div class="form-group" align="right">
                                <button type="button" class="btn btn-outline-success" name="btn_detail_order" id="btn_detail_order" data-id="<?= $order_detail_id ?>">บันทึก</button>
                            </div>
                        </div>
                        <div class="col-6" align="left">
                            <div class="form-group">
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">ยกเลิก</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>

<?php
    }
}

?>
<?php

$sql3 = "SELECT tb_order.order_id as order_id, 
                tb_order.order_name as order_name,
                tb_order.order_date as order_date,
                tb_order.order_status as order_status,
                tb_order.order_detail as order_detail,
                tb_order.order_customer as order_customer , 
                tb_order.order_price as order_price,
                tb_customer.customer_firstname as customer_firstname, 
                tb_customer.customer_lastname as customer_lastname, 
                tb_customer.customer_id as customer_id,
                tb_plant.plant_time as plant_time
FROM tb_order
LEFT JOIN tb_order_detail ON tb_order_detail.ref_order_id = tb_order.order_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
GROUP BY order_id 
ORDER BY order_id ASC";

$result3 = mysqli_query($conn, $sql3);
if ($result3->num_rows > 0) {

    while ($row3 = $result3->fetch_assoc()) {

        $order_id = $row3['order_id'];

?>
        <div id="add_orders<?php echo $order_id ?>" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content" style="width:auto">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="fas fa-prescription-bottle"></i> เพิ่มรายการสั่งซื้อเพิ่มเติม
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_item_id" value="<?php echo $order_id; ?>">
                        <form role="form" method="post" class="orderDetail" id="orderDetail">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รหัสรายการ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="text" class="form-control in_order_id_detail<?= $order_id ?>" id="in_order_id_detail<?= $order_id ?>" name="in_order_id_detail" value="<?= $order_id ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ประเภทพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <select name="in_order_typeplant_detail" class="form-control in_order_typeplant_detail" id="in_order_typeplant_detail<?= $order_id ?>">
                                                    <option value="0">---โปรดเลือกประเภทพันธุ์ไม้---</option>
                                                    <?php
                                                    $sql_type1 = "SELECT * FROM tb_typeplant                                                
                                                        WHERE type_plant_status ='ปกติ' ORDER BY type_plant_name ASC";
                                                    $re_type1 = mysqli_query($conn, $sql_type1);
                                                    while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                                    ?>
                                                        <option value="<?php echo $re_fac1["type_plant_id"]; ?>">
                                                            <?php echo $re_fac1["type_plant_name"];  ?>
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
                                            <label>พันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <select name="in_order_plant_detail" class="form-control in_order_plant_detail" id="in_order_plant_detail<?= $order_id ?>">
                                                    <option value="0">---โปรดเลือกพันธุ์ไม้---</option>

                                                </select>
                                            </div>
                                        </div>
                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>จำนวน : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="text" class="form-control in_order_amount_detail" id="in_order_amount_detail<?= $order_id ?>" name="in_order_amount_detail" placeholder="กรุณากรอกข้อมูล">
                                            </div>
                                        </div>
                                        <span>ต้น</span>&nbsp;&nbsp;
                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>จำนวนที่ปลูกเผื่อ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="number" class="form-control in_order_amount_for_detail" min="0" max="100" id="in_order_amount_for_detail<?= $order_id ?>" name="in_order_amount_for_detail" placeholder="กรุณากรอกข้อมูล">
                                            </div>
                                        </div>
                                        <span>%</span>&nbsp;&nbsp;
                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>จำนวนทั้งหมด : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="number" class="form-control in_order_amount_total_detail" id="in_order_amount_total_detail<?= $order_id ?>" name="in_order_amount_total_detail" readonly>
                                            </div>
                                        </div>
                                        <span>ต้น</span>&nbsp;&nbsp;
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ระยะเวลาปลูก : </label>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control in_order_plant_time_detail" id="in_order_plant_time_detail<?= $order_id ?>" name="in_order_plant_time_detail" readonly>
                                            </div>
                                        </div>
                                        <span>สัปดาห์<br>&nbsp;หรือ : </span>&nbsp;
                                        <label></label>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control in_order_plant_time_day_detail" id="in_order_plant_time_day_detail<?= $order_id ?>" name="in_order_plant_time_day_detail" readonly>
                                            </div>
                                        </div>
                                        <span>วัน</span>&nbsp;
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>วันที่ส่งมอบ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="date" class="form-control in_order_end_detail" id="in_order_end_detail<?= $order_id ?>" name="in_order_end_detail" placeholder="กรุณากรอกข้อมูล">
                                                <?php date_default_timezone_set("Asia/Bangkok");
                                                $datenow = date("Y-m-d"); ?>
                                                <input type="hidden" class="form-control" id="in_order_daynow_detail<?= $order_id ?>" name="in_order_daynow_detail" value="<?= $datenow ?>" readonly>
                                            </div>
                                        </div>
                                        <strong><span style="color:red" class=red_firstname> *</span> </strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ระยะเวลา : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="text" class="form-control in_order_day_detail" id="in_order_day_detail<?= $order_id ?>" name="in_order_day_detail" readonly>
                                            </div>
                                        </div>
                                        <span>วัน</span>&nbsp;&nbsp;
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="fileinput fileinput-new text-center a" data-provides="fileinput" align="center">
                                        <img src="image/plant.png" class="add_picture_detail" id="add_picture_detail<?= $order_id ?>" align="center" width="200" height="250" style="object-fit: fill;  border-radius: 8px;"><br><br>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group" align="right">
                                        <button type="button" class="btn btn-outline-success" name="btn_save_order_detail" id="btn_save_order_detail" data-id="<?= $order_id ?>">บันทึก</button>
                                    </div>
                                </div>
                                <div class="col-6" align="left">
                                    <div class="form-group">
                                        <button type="button" data-dismiss="modal" class="btn btn-outline-danger">ยกเลิก</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
<?php
    }
}



?>