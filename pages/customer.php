<?php
include('connect.php');
@session_start();
$emp = $_SESSION['emp_id'];
$permis = $_SESSION['userlevel'];


//รันรหัสพนักงาน
date_default_timezone_set("Asia/Bangkok");
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$sqlm = "SELECT max(customer_id) as Maxid  FROM tb_customer";
$result = mysqli_query($conn, $sqlm);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['Maxid'];
//M003
$tmp1 = "CUS"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
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
$a = sprintf("%04d", $t);
$run_customer_id = $tmp1 . $sub_date . $a;

?>

<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-outline-warning" id="modal_customer" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลลูกค้า</button>
    </div>
</div><br>



<div class="row">
    <div class="col-12">
        <table class="table-bordered text-center" id="customerTable" width="100%">
            <thead bgcolor="#2dce89">
                <th>ลำดับ</th>
                <th>รหัสลูกค้า</th>
                <th>ชื่อ-นามสกุล</th>
                <th>เพศ</th>
                <th>อีเมล</th>
                <th>ประเภท<br>ลูกค้า</th>
                <th>รายละเอียดเพิ่มเติม</th>
                <th>สถานะ</th>
                <th width ="100"></th>
            </thead>
            <?php

            $query = "SELECT tb_customer.customer_id as customer_id,
                        tb_customer.customer_firstname as customer_firstname,
                        tb_customer.customer_lastname as customer_lastname,
                        tb_customer.customer_gender as customer_gender,
                        tb_customer.customer_email as customer_email,
                        tb_customer.customer_detail as customer_detail,
                        tb_customer.customer_status as customer_status,
                        tb_customer.customer_handover_type as customer_handover_type
                        FROM tb_customer
                        ORDER BY tb_customer.customer_id ASC";

            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $i = 1;
                $data = array();
                while ($row = mysqli_fetch_array($result)) {

                    $customer_id = $row['customer_id'];
                    $customer_firstname = $row['customer_firstname'];
                    $customer_lastname = $row['customer_lastname'];
                    $customer_gender = $row['customer_gender'];
                    $customer_email = $row['customer_email'];
                    $customer_detail = $row['customer_detail'];
                    $customer_status = $row['customer_status'];
                    $type_handover = $row['customer_handover_type'];

            ?>

                    <div class="modal fade modal_edit_customer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_edit_customer<?php echo $customer_id; ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="width: auto;">
                                <div class="modal-header">
                                    <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขข้อมูลลูกค้า</h5>
                                    <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                        <h3>&times;</h3>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form role="form" method="post" id="edit_customerForm<?= $customer_id ?>">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-5" align="right">
                                                        <label>รหัสลูกค้า : </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="edit_customer_id" readonly value="<?php echo $customer_id ?>" name='edit_customer_id'>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-5" align="right">
                                                        <label>ชื่อ : </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control edit_customer_firstname" id="edit_customer_firstname<?= $customer_id ?>" name="edit_customer_firstname" value="<?= $customer_firstname ?>" data-id="<?= $customer_id ?>">
                                                        </div>
                                                    </div>
                                                    <strong><span style="color:red"> *</span> </strong>
                                                </div>
                                                <div class="row">
                                                    <div class="col-5" align="right">
                                                        <label>นามสกุล : </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control edit_customer_lastname" id="edit_customer_lastname<?= $customer_id ?>" name="edit_customer_lastname" value="<?= $customer_lastname ?>" data-id="<?= $customer_id ?>">
                                                        </div>
                                                    </div>
                                                    <strong><span style="color:red"> *</span> </strong>
                                                </div>

                                                <div class="row">
                                                    <div class="col-5" align="right">
                                                        <label>เพศ : </label>
                                                    </div>
                                                    <div class="col-3">

                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="edit_customer_gender" class="custom-control-input edit_M" id="edit_M<?= $customer_id ?>" type="radio" value="ชาย" <?php if ($customer_gender == 'ชาย') {
                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                            }
                                                                                                                                                                                            ?>>
                                                            <label class="custom-control-label" for="edit_M<?= $customer_id ?>">ชาย </label>
                                                        </div>

                                                    </div>
                                                    <div class="col-3">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="edit_customer_gender" class="custom-control-input edit_W" id="edit_W<?= $customer_id ?>" type="radio" value="หญิง" <?php if ($customer_gender == 'หญิง') {
                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                            }
                                                                                                                                                                                            ?>>
                                                            <label class="custom-control-label" for="edit_W<?= $customer_id ?>">หญิง </label>
                                                        </div>

                                                    </div>
                                                    <strong><span style="color:red"> *</span> </strong>
                                                </div><br>
                                                <div class="row">
                                                    <div class="col-5" align="right">
                                                        <label>ประเภทลูกค้า : </label>
                                                    </div>
                                                    <div class="col-3">

                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="edit_customer_genders" class="custom-control-input edit_in" id="edit_in<?= $customer_id ?>" type="radio" value="ในประเทศ" <?php if ($type_handover == 'ในประเทศ') {
                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                            }
                                                                                                                                                                                            ?>>
                                                            <label class="custom-control-label" for="edit_in<?= $customer_id ?>">ในประเทศ </label>
                                                        </div>

                                                    </div>
                                                    <div class="col-3">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="edit_customer_genders" class="custom-control-input z" id="edit_out<?= $customer_id ?>" type="radio" value="นอกประเทศ" <?php if ($type_handover == 'นอกประเทศ') {
                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                            }
                                                                                                                                                                                            ?>>
                                                            <label class="custom-control-label" for="edit_out<?= $customer_id ?>">นอกประเทศ </label>
                                                        </div>

                                                    </div>
                                                    <strong><span style="color:red"> *</span> </strong>
                                                </div><br>
                                                <div class="row">
                                                    <div class="col-5" align="right">
                                                        <label>อีเมล : </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <input type="email" class="form-control edit_customer_email" id="edit_customer_email<?= $customer_id ?>" value="<?= $customer_email ?>" name="edit_customer_email" data-id="<?= $customer_id ?>">
                                                        </div>
                                                    </div>
                                                    <strong><span style="color:red"> *</span> </strong>
                                                </div>

                                                <div class="row">
                                                    <div class="col-5" align="right">
                                                        <label>รายละเอียดเพิ่มเติม : </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <textarea class="form-control edit_customer_detail" rows="6" id="edit_customer_detail<?= $customer_id ?>" name="edit_customer_detail"><?= $customer_detail ?></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group" align="right">
                                                    <button type="button" class="btn btn-outline-success" id="btn_edit_customer" data-id="<?= $customer_id ?>">บันทึก</button>
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


            <?php
                }
            }
            ?>
        </table>
    </div>
</div>




<!-- เริ่ม modal เพิ่มข้อมูลพนักงาน -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_add_customer">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลลูกค้า</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" id="add_customerForm">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-5" align="right">
                                    <label>รหัสลูกค้า : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="customer_id" placeholder="รหัสพนักงาน" readonly value="<?php echo $run_customer_id ?>" name='empid'>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-5" align="right">
                                    <label>ชื่อ : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control customer_firstname" id="customer_firstname" name="customer_firstname" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span> </strong>
                            </div>
                            <div class="row">
                                <div class="col-5" align="right">
                                    <label>นามสกุล : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control customer_lastname" id="customer_lastname" name="customer_lastname" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span> </strong>
                            </div>

                            <div class="row">
                                <div class="col-5" align="right">
                                    <label>เพศ : </label>
                                </div>
                                <div class="col-3">

                                    <div class="custom-control custom-radio mb-3">
                                        <input name="customer_gender" class="custom-control-input" id="M" type="radio" value="ชาย">
                                        <label class="custom-control-label" for="M">ชาย </label>
                                    </div>

                                </div>
                                <div class="col-3">
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="customer_gender" class="custom-control-input" id="W" type="radio" value="หญิง">
                                        <label class="custom-control-label" for="W">หญิง </label>
                                    </div>

                                </div>
                                <strong><span style="color:red"> *</span> </strong>
                            </div><br>
                            <div class="row">
                                <div class="col-5" align="right">
                                    <label>ประเภทลูกค้า : </label>
                                </div>
                                <div class="col-3">

                                    <div class="custom-control custom-radio mb-3">
                                        <input name="type_hand" class="custom-control-input" id="in" type="radio" value="ในประเทศ">
                                        <label class="custom-control-label" for="in">ในประเทศ </label>
                                    </div>

                                </div>
                                <div class="col-3">
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="type_hand" class="custom-control-input" id="out" type="radio" value="นอกประเทศ">
                                        <label class="custom-control-label" for="out">นอกประเทศ </label>
                                    </div>

                                </div>
                                <strong><span style="color:red"> *</span> </strong>
                            </div><br>
                            <div class="row">
                                <div class="col-5" align="right">
                                    <label>อีเมล : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control customer_email" id="customer_email" placeholder="กรุณากรอกข้อมูล" name="customer_email">
                                    </div>
                                </div>
                                <strong><span style="color:red"> *</span> </strong>
                            </div>

                            <div class="row">
                                <div class="col-5" align="right">
                                    <label>รายละเอียดเพิ่มเติม : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="6" id="customer_detail" placeholder="กรุณากรอกข้อมูล" name="customer_detail"></textarea>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group" align="right">
                                <button type="button" class="btn btn-outline-success" id="btn_add_customer">บันทึก</button>
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