<?php

@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];

date_default_timezone_set("Asia/Bangkok");
//รหัสพันธุ์ไม้
$sql_group = "SELECT Max(plant_id) as maxid FROM tb_plant";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "PLA"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
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

$plaid = $tmp1 . $sub_date . $a;

?>



<input type="hidden" id="per" value='<?php echo $permiss ?>'>


<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target=".plant" id="btn_plant"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลพันธุ์ไม้</button>
    </div>
</div><br>

<!--- เริ่ม modal เพิ่มข้อมูลพันธุ์ไม้ --->
<div class="modal fade plant" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="plant">
    <div class="modal-dialog modal-lx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มข้อมูลพันธุ์ไม้</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form class="insert" role="form" method="post" action="" id="insert_plant">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>รหัสพันธุ์ไม้ : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="insert_plant_id" name="insert_plant_id" value="<?= $plaid ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ชื่อประเภทพันธุ์ไม้ : </label>
                                </div>
                                <div class="col-6">

                                    <div class="form-group">
                                        <select name="insert_plant_typename" class="form-control" id="insert_plant_typename">
                                            <option value="0">----โปรดเลือกชื่อประเภทพันธุ์ไม้----</option>
                                            <?php
                                            $sql_type1 = "SELECT * FROM tb_typeplant  WHERE type_plant_status ='ปกติ' ORDER BY type_plant_id ASC";
                                            $re_type1 = mysqli_query($conn, $sql_type1);
                                            while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                            ?>
                                                <option value="<?php echo $re_fac1["type_plant_id"]; ?>">
                                                    <?php echo $re_fac1["type_plant_name"]; ?>
                                                </option>
                                            <?php
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <span style="color:red"> *</span>
                            </div>
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label> ชื่อพันธุ์ไม้ : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control plantname" id="insert_plant_name" name="insert_plant_name" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <span style="color:red"> *</span>
                            </div>

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label> ระยะเวลาการปลูก : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control planttime" id="insert_plant_time" name="insert_plant_time" placeholder="กรุณากรอกข้อมูล">
                                    </div>
                                </div>
                                <label> สัปดาห์ </label>&nbsp; <span style="color:red"> * </span>
                            </div>

                            <div class="row">
                                <div class="col-4" align="right">
                                    <label> คุณลักษณะพันธุ์ไม้ : </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <textarea class="form-control " id="insert_plant_detail" rows="5" name="insert_plant_detail" placeholder="กรุณากรอกข้อมูล"></textarea>
                                    </div>
                                </div>
                                <span style="color:red"> *</span>
                            </div>


                        </div>
                        <div class="col-sm-4">
                            <div class="fileinput fileinput-new text-center a" data-provides="fileinput" align="center">
                                <div style="cursor:pointer;">
                                    <img src="image/upload.png" alt="..." id="add_picture_img" class="add_picture_img" name="add_picture_img" align="center" width="200px" height="200px" style="object-fit: fill; border-radius: 8px;"><br><br>
                                    <input type="file" style="display:none" name="add_picture" id="add_picture" class="add_picture" accept="image/*">
                                    <span class="show_pic">&nbsp;&nbsp;(เลือกไฟล์รูปภาพ) </span>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group" align="right">
                        <button type="submit" class="btn btn-outline-success" name="btn_save_plant" id="btn_save_plant">บันทึก</button>
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
        <table class="table-bordered text-center" id="plantTable" width="100%">
            <thead bgcolor="#2dce89" style="text-align: center;">
                <th>ลำดับ</th>
                <th>รหัสพันธุ์ไม้</th>
                <th>ชื่อประเภทพันธุ์ไม้</th>
                <th>ชื่อพันธุ์ไม้</th>
                <th width ="100">ระยะเวลา<br>การปลูก (สัปดาห์)</th>
                <th>สถานะ</th>
                <th width ="200"></th>
            </thead>
        </table>
    </div>
</div>




<?php
$sql = "SELECT  tb_plant.plant_id as plant_id,
                            tb_plant.plant_name as plant_name,
                            tb_plant.plant_time as plant_time,
                            tb_plant.plant_detail as plant_detail,
                            tb_plant.plant_status as plant_status,
                            tb_plant.picture as pic,
                            tb_typeplant.type_plant_name as type_plant_name,
                            tb_plant_detail.ref_grade_id as ref_grade_id

                            FROM tb_plant 
                            LEFT JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
                            LEFT JOIN tb_plant_detail ON tb_plant_detail.ref_plant_id = tb_plant.plant_id
                           ORDER BY plant_id ASC";

$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $i++;

        $plant_id = $row['plant_id'];
        $plant_name = $row['plant_name'];
        $plant_time = $row['plant_time'];
        $plant_detail = $row['plant_detail'];
        $plant_status = $row['plant_status'];
        $picture = $row['pic'];
        $type_plant_name = $row['type_plant_name'];

        $ref_grade_id = $row['ref_grade_id'];

?>


        <!--- เริ่ม modal แสดงข้อมูล --->
        <div id="view<?= $plant_id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lgg">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="fas fa-search-plus"></i> แสดงข้อมูลพันธุ์ไม้</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="post" action="" id="view_plant">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รหัสพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-6">

                                            <div class="form-group">
                                                <input type="text" class="form-control" id="view_plant_id" name="view_plant_id" value="<?= $plant_id ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ชื่อประเภทพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-6">

                                            <div class="form-group">
                                                <input type="text" class="form-control" id="view_plant_typename" name="view_plant_typename" value="<?= $type_plant_name ?>" readonly>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label> ชื่อพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="view_plant_name" name="view_plant_name" value="<?= $plant_name ?>" readonly>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label> ระยะเวลาการปลูก : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="view_plant_time" name="view_plant_time" value="<?= $plant_time ?>" readonly>
                                            </div>
                                        </div>
                                        <label> สัปดาห์ </label>
                                    </div>

                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label> คุณลักษณะพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="view_plant_detail" name="view_plant_detail" value="<?= $plant_detail ?>" readonly>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group" align="center">
                                        <img src="image/plant/<?php echo $picture ?>" width="200px" height="200px" class="a" style="object-fit: fill; border-radius: 8px;" align="center"><br><br>
                                    </div>
                                </div>
                            </div>
                    </div>

                </div>
            </div>
            </form>
        </div>

        <!--- เริ่ม modal แก้ไข --->
        <div id="edit<?= $plant_id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lx">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขข้อมูลพันธุ์ไม้</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="Update" role="form" data-id="<?= $plant_id ?>" id="edit_plant<?= $plant_id ?>" enctype="multipart/form-data">
                            <div class="row">
                                <input type="hidden" name="edit_item_id" id="edit_item_id" value="<?php echo $plant_id; ?>">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รหัสพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="edit_plant_id<?= $plant_id ?>" name="edit_plant_id" value="<?= $plant_id ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ชื่อประเภทพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-6">

                                            <div class="form-group">
                                                <select class="form-control" id="edit_plant_typename<?= $plant_id ?>" name="edit_plant_typename" data-id="<?= $plant_id ?>">

                                                    <?php
                                                    $sql_type1 = "SELECT * FROM tb_typeplant  WHERE type_plant_status ='ปกติ' ORDER BY type_plant_id ASC";
                                                    $re_type1 = mysqli_query($conn, $sql_type1);
                                                    while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                                                    ?>
                                                        <option <?php if ($type_plant_name == $re_fac1['type_plant_name']) {
                                                                    echo "selected";
                                                                } ?> value="<?php echo $re_fac1["type_plant_id"]; ?>">
                                                            <?php echo $re_fac1["type_plant_name"]; ?>
                                                        </option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                        <span style="color:red"> *</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label> ชื่อพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit_plant_name" id="edit_plant_name<?= $plant_id ?>" name="edit_plant_name" value="<?= $plant_name ?>" data-id="<?= $plant_id ?>">
                                            </div>
                                        </div>
                                        <span style="color:red"> *</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label> ระยะเวลาการปลูก : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control edit_plant_time" id="edit_plant_time<?= $plant_id ?>" name="edit_plant_time" value="<?= $plant_time ?>">
                                            </div>
                                        </div>
                                        <label> สัปดาห์ </label>&nbsp;<span style="color:red"> * </span>
                                    </div>

                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label> คุณลักษณะพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <textarea type="text" class="form-control" id="edit_plant_detail<?= $plant_id ?>" name="edit_plant_detail"  rows="5"><?php echo $plant_detail ?></textarea>
                                            </div>
                                        </div>
                                        <span style="color:red"> *</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group" align="center">
                                        <div class="fileinput fileinput-new text-center a" data-provides="fileinput">
                                            <div style="cursor:pointer;">
                                                <img src="image/plant/<?php echo $picture ?>" alt="..." id="edit_picture<?= $plant_id ?>" class="edit_picture" width="200px" height="200px" style="object-fit: fill; border-radius: 8px;"><br><br>
                                                <input type="file" style="display:none" name="picture" id="picture<?= $plant_id ?>" class="picture" accept="image/*">
                                                <span class="show_pic">(เลือกไฟล์รูปภาพ) </span></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group" align="right">
                                        <button type="submit" class="btn btn-outline-success" name="btn_save_edit_plant" data-id="<?= $plant_id ?>" id="btn_save_edit_plant">บันทึก</button>
                                    </div>
                                </div>
                                <div class="col-6" align="left">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-outline-danger" id="cancel" data-dismiss="modal">ยกเลิก</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="adds<?= $plant_id ?>" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lx">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มเกรดและราคาพันธุ์ไม้</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="post" action="" id="add_plant">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>รหัสพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-7">

                                            <div class="form-group">
                                                <input type="text" class="form-control" id="add_plant_id<?= $plant_id ?>" name="add_plant_id" value="<?= $plant_id ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label>ชื่อประเภทพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-7">

                                            <div class="form-group">
                                                <input type="text" class="form-control" id="add_plant_typename<?= $plant_id ?>" name="add_plant_typename" value="<?= $type_plant_name ?>" readonly>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <label> ชื่อพันธุ์ไม้ : </label>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="add_plant_name<?= $plant_id ?>" name="add_plant_name" value="<?= $plant_name ?>" readonly>
                                            </div>
                                        </div>

                                    </div><br>

                                    <?php
                                    $sql_grade = "SELECT * FROM tb_grade WHERE grade_status ='ปกติ' AND grade_id NOT IN (SELECT ref_grade_id FROM tb_plant_detail WHERE ref_plant_id ='$plant_id')  GROUP BY grade_id";
                                    $results = mysqli_query($conn, $sql_grade);
                                    $i = 0;
                                    if (mysqli_num_rows($results) > 0) {
                                        while ($rows = mysqli_fetch_array($results)) {
                                            $i++;
                                            $grade_id = $rows['grade_id'];
                                            $grade_name = $rows['grade_name'];

                                    ?>
                                            <div class="row">
                                                <div class="col-4" align="right">
                                                    <label>เกรด <?= $grade_name ?> :</label>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="checkbox" class="form-control add_plant_grade" id="add_plant_grade<?= $plant_id ?>" name="add_plant_grade" value="<?= $grade_id; ?>" data="<?= $plant_id ?>">
                                                    </div>
                                                </div>
                                                <span> ราคา :</span>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <input type="textbox" class="form-control add_plant_grade_price" id="add_plant_grade_price<?= $grade_id . $plant_id; ?>" name="add_plant_grade_price" disabled>
                                                    </div>
                                                </div>
                                                <span> บาท</span>
                                            </div>

                                        <?php
                                        }
                                    } else {
                                        ?>

                                        <p style="text-align:center;" id="show<?= $plant_id ?>"></p>

                                    <?php
                                    }
                                    ?>

                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group" align="center">
                                        <img src="image/plant/<?php echo $picture ?>" width="250" height="250" class="a" style="object-fit: fill;  border-radius: 10px;" align="center"><br><br>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group" align="right">
                                        <button type="button" class="btn btn-outline-success btn_add_plant" name="btn_add_plant" data-id="<?= $plant_id ?>" id="btn_add_plant">บันทึก</button>
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
    } //end loop while
} // end if
?>

<div id="detail_plants" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายละเอียดเกรดและราคาพันธุ์ไม้</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="detail" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="detail_id" id="detail_id" value="<?php echo $plant_id; ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-4" align="right">
                                            <strong><label>ชื่อพันธุ์ไม้ : </label></strong>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label id="detail_name2"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table-bordered text-center" id="plant_detailTable" width="100%">
                                <thead bgcolor="#2dce89" style="text-align: center;">
                                    <th>ลำดับ</th>
                                    <th>เกรด</th>
                                    <th>ราคา (บาท/ต้น)</th>
                                    <th>สถานะ</th>
                                    <th></th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$query_detail = "SELECT tb_plant_detail.plant_detail_id as plant_detail_id,
tb_plant_detail.plant_detail_price as plant_detail_price,
tb_plant_detail.plant_detail_status as plant_detail_status,
tb_grade.grade_name as grade_name,
tb_plant.plant_id as plant_id,
tb_grade.grade_id as grade_id

FROM tb_plant_detail
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_plant_detail.ref_plant_id
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_plant_detail.ref_grade_id
ORDER BY tb_plant_detail.plant_detail_id ASC";


$re_new = mysqli_query($conn, $query_detail);
if ($re_new->num_rows > 0) {

    while ($row_detail = $re_new->fetch_assoc()) {
        $plant_detail_id = $row_detail['plant_detail_id'];
        $plant_detail_price = $row_detail['plant_detail_price'];
        $plant_detail_status = $row_detail['plant_detail_status'];
        $grade_id = $row_detail['grade_id'];
        $grade_name = $row_detail['grade_name'];
        $plant_id = $row_detail['plant_id'];

?>
        <div id="edit_detail<?php echo $plant_detail_id; ?>" class="modal fade edit_detail" role="dialog">

            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="fas fa-prescription-bottle"></i>
                            แก้ไขข้อมูลราคาพันธุ์ไม้</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body"><br>
                        <form role="form" method="post" action="" id="edit_details<?php echo $plant_detail_id; ?>" class="edit_details">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-4" align="center">
                                            <label>
                                                <h1>เกรด : <?= $grade_name ?></h1>
                                            </label>
                                        </div>
                                        <input type="hidden" class="form-control edit_detail_grade" id="edit_detail_grade<?= $plant_detail_id ?>" name="edit_detail_grade" value="<?= $grade_id ?>" data="<?= $plant_detail_id ?>">
                                        <span> ราคา :</span>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="textbox" class="form-control edit_detail_price" id="edit_detail_price<?= $grade_id . $plant_detail_id ?>" name="add_plant_grade_price" value="<?= $plant_detail_price ?>">
                                            </div>
                                        </div>
                                        <span> บาท</span>&nbsp;
                                        <strong><span style="color:red"> *</span></strong>
                                    </div>
                                </div>
                            </div>
                    </div><br>
                    <div class="row">
                        <div class="col-6">

                            <div class="form-group" align="right">
                                <button type="button" class="btn btn-outline-success" name="btn_edit_detail" id="btn_edit_detail" data-id="<?= $plant_detail_id ?>">บันทึก</button>
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
        </div>

<?php
    }
}

?>

<script>
    function myFunction() {



    }
</script>