<?php

@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];

?>


<input type="hidden" id="per" value='<?php echo $permiss ?>'>


<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="myFunction()"><i class="ni ni-fat-add"></i> เพิ่มผู้ใช้งาน</button>
    </div>
</div><br>

<!--- เริ่ม modal เพิ่มสิทธิ์ --->
<div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="permission">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="ni ni-fat-add"></i> เพิ่มผู้ใช้งาน</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="" id="in_per">
                    <div class="row">
                        <div class="col-sm-11">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>พนักงาน : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <select name="employee" class="form-control" id="employee">
                                            <option value="0">----โปรดเลือกพนักงาน----</option>
                                            <?php

                                            $sql_userlevel = "SELECT * FROM tb_user WHERE status_login='ไม่อนุญาต' AND emp_status ='ปกติ' ORDER BY emp_id ASC";
                                            $re_userlevel = mysqli_query($conn, $sql_userlevel);
                                            while ($re_row = mysqli_fetch_array($re_userlevel)) {
                                            ?>
                                                <option value="<?php echo $re_row["emp_id"]; ?>">
                                                    <?php echo $re_row["firstname"] . "  " . $re_row["lastname"]; ?>
                                                </option>
                                            <?php
                                            } //วน loop listview แสดงชื่อคนที่จะให้สิทธิ์
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <span style="color:red"> *</span>
                            </div>
                        </div>
                        <div class="col-sm-11">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <label>ระดับผู้ใช้งาน : </label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <select name="select_type" class="form-control" id="type">
                                            <option value="0">----โปรดเลือกระดับ----</option>
                                            <option value="ผู้ดูแลระบบ">ผู้ดูแลระบบ</option>
                                            <option value="พนักงาน">พนักงาน</option>
                                        </select>
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
                        <button type="button" class="btn btn-outline-success" name="btn_save" id="btn_save">เพิ่มสิทธิ</button>
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
        <table class="table table-bordered text-center" id="permissionsTable" width="100%">
            <thead bgcolor="#2dce89">
                <th>ลำดับ</th>
                <th>รหัสพนักงาน</th>
                <th>ชื่อ-นามสกุล</th>
                <th>ตำแหน่ง</th>
                <th>สถานะการใช้งาน</th>
                <th></th>

            </thead>
            <?php
            $sql = "SELECT username,status,userlevel,tb_user_detail.password as password,ref_emp_id,tb_user.emp_id as emp_id,tb_user.firstname as firstname,tb_user.lastname as lastname,
                                    tb_user_detail.update_at ,tb_user_detail.update_by as update_by, tb_user.card_id AS card_id
                            FROM tb_user_detail
                            INNER JOIN tb_user ON tb_user.emp_id = tb_user_detail.ref_emp_id
                         
                            ORDER BY emp_id ASC";

            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $i++;

                    $username = $row['username'];
                    $password = $row['password'];
                    $status = $row['status'];
                    $userlevel = $row['userlevel'];
                    $emp_id = $row['emp_id'];
                    $cardid = $row['card_id'];
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $update_at = $row['update_at'];
                    $update_by = $row['update_by'];


            ?>

                    <tr onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)" style="text-align: center;">
                        <td>
                            <?php echo $i; ?></td>
                        <td class="emp_id">
                            <?php echo $emp_id; ?>
                        </td>
                        <td class="emp_id">
                            <?php echo $firstname . "  " . $lastname; ?>
                        </td>
                        <td>
                            <?php echo $userlevel; ?>
                        </td>
                        <td <?php if ($status == 'ระงับ') {
                                echo 'style="color:red"';
                            } ?>>
                            <?php echo $status; ?>
                        </td>
                        <?php
                        if ($status == 'ใช้งาน') {
                            $image = 'fas fa-times';
                            $color = "btn btn-danger  btn-sm";
                            $txt = "ยกเลิกข้อมูล";
                            $edit = "edit";
                            $disabled = "";
                            $disableds = "";

                           
                        } else if ($status == 'ระงับ') {
                            $image = 'fas fa-check';
                            $color = "btn btn-success btn-sm";
                            $txt = "ยกเลิกการระงับ";
                            $edit = "";
                            $disabled = "";
                            $disableds = "disabled";
                           
                        }

                        if($emp_id == $empid){
                            $disabled2 = "disabled";
                            $edit = "";
                            
                        }else{
                            $disabled2 = "";
                            $edit = "edit";
                        }
                        ?>
                          <?php
                       /*  if($emp_id == $empid){
                            $disabled2 = "disabled";
                            $modal = "";
                            
                        }else{
                            $disabled2 = "";
                            $modal = "modal";
                        } */
                        ?>
                        
                        <td style="text-align: center;">
                            <a href="#<?php echo $edit?><?php echo $username;?>" data-toggle="modal" >
                                <button type='button' class='btn btn-warning btn-sm edit_per' id="edit_per" <?php echo $disableds;?> <?php echo $disabled;?>  <?php echo $disabled2;?> data-toggle="tooltip" onclick="edit_per()" title="แก้ไขข้อมูล" per="<?= $emp_id ?>" date_at="<?= $update_at ?>" ><i class="fas fa-edit" style="color:white;"></i></button>
                            </a>
                            <button type='button'  <?php echo $disabled;?> <?php echo $disableds;?> id="btn_reset_password" class ='btn btn-info btn-sm' data-toggle="tooltip" title="รีเซ็ตรหัสผ่าน" data="<?= $cardid?>" data-id="<?= $emp_id ?>" data-status="<?= $status ?>" data-name="<?= $firstname . ' ' . $lastname ?>"><i class="fas fa-history" style="color:white"></i></span></button>
                            <button type='button' <?php echo $disabled2;?>   <?php echo $disabled;?> id="btn_remove_permission" class='<?= $color ?>' data-toggle="tooltip" title="<?= $txt ?>" data-id="<?= $emp_id ?>" data-status="<?= $status ?>" data-name="<?= $firstname . ' ' . $lastname ?>" ><i class="<?= $image ?>" style="color:white"></i></span></button>
                        </td>

                      

                        <!--- เริ่ม modal แก้ไข --->
                        <div id="edit<?php echo $username; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
                            <div class="modal-dialog modal-lg">่
                                <div class="modal-content" style="width: auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title card-title"><i class="fas fa-edit"></i> แก้ไขตำแหน่งผู้ใช้งาน</h5>
                                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                                            <h3>&times;</h3>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" method="post" action="" id="edit_permission">
                                            <div class="row">
                                                <input type="hidden" name="edit_item_id" id="edit_item_id" value="<?php echo $username; ?>">
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-5" align="right">
                                                            <h4><label>ระดับผู้ใช้งาน : </label></h4>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <h1><select name="select_level" class="form-control" id="select_level<?= $username ?>">
                                                                        <option value="0">----โปรดเลือก----</option>
                                                                        <option <?php if ($userlevel == 'ผู้ดูแลระบบ') {
                                                                                    echo "selected";
                                                                                }
                                                                                ?> value="ผู้ดูแลระบบ">ผู้ดูแลระบบ</option>
                                                                        <option <?php if ($userlevel == 'พนักงาน') {
                                                                                    echo "selected";
                                                                                }
                                                                                ?> value="พนักงาน">พนักงาน</option>
                                                                    </select></h1>
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
                                                <button type="button" class="btn btn-outline-success" name="btn_edit_permission"  id="btn_edit_permission" re_username='<?=$username?>'>บันทึก</button>
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
        </table>

    </div>
</div>




<script>
    function myFunction() {

        document.getElementById("in_per").reset();

    }

    function edit_per() {

        document.getElementById("edit_permission").reset();

    }

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