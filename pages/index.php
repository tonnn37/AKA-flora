    <br>
<div class="header  pb-6">
    <div class="container-fluid">
        <div class="header-body">


            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats shadow-lg-pink ">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col" align="center">
                                    <strong><a href="./admin.php?page=order" title="รายการสั่งซื้อ" class="card-title text-uppercase text-muted mb-0" style="font-size: 18px !important;">รายการสั่งซื้อ </a></strong>&nbsp;&nbsp;<div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="fas fa-list-ol" style="color:white;"></i>
                                    </div>
                                </div>

                            </div>
                            <hr style="background:pink; height:1px;">
                            </hr>
                            <?php
                            $sql_count = "SELECT COUNT(order_id) as count FROM tb_order WHERE order_status ='ปกติ'";
                            $re_count = mysqli_query($conn, $sql_count);
                            $r_count = mysqli_fetch_assoc($re_count);
                            $sum_order = $r_count['count'];

                            if ($sum_order == "") {
                                $sum_order = 0;
                            }

                            ?>
                            <div class="row">
                                <div class="col" align="center">
                                    <div class="col-7" style="padding-right: 0px; padding-left: 10px;">
                                        <a href="#modal_order_all" data-toggle="modal" title="รายการสั่งซื้อทั้งหมด">
                                            <div class="card text-white bg-gradient-red mb-3" style="max-width: 9rem;">
                                                <strong>
                                                    <div class="card-header text-muted" align="center">ทั้งหมด</div>
                                                </strong>
                                                <div class="card-body" align="center">
                                                    <h5 class="card-title" style="font-size: 25px !important; color:white"><?php echo $sum_order ?></h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $sql = "SELECT * FROM tb_order
                            INNER JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
                            INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id = tb_order.order_id
                            WHERE tb_order.order_status ='ปกติ' AND tb_order_detail.order_detail_planting_status = 'ยังไม่ได้ทำการปลูก' AND tb_order_detail.order_detail_status = 'ปกติ'
                            GROUP BY tb_order.order_id";

                            $result = mysqli_query($conn, $sql);
                            if ($result->num_rows > 0) {
                                $i = 0;
                                while ($row = $result->fetch_assoc()) {

                                    $i++;
                                }
                            }else{
                                $i = 0;
                            }

                            ?>

                            <div class="row">
                                <div class="col-6" style="padding-right: 0px; padding-left: 10px;">
                                    <a href="#modal_order_not_plant" data-toggle="modal" title="รายการที่ยังไม่ได้ปลูก">
                                        <div class="card text-white bg-gradient-red mb-3" style="max-width: 9rem;">
                                            <strong>
                                                <div class="card-header text-muted" align="center">ยังไม่ได้ปลูก</div>
                                            </strong>
                                            <div class="card-body" align="center">
                                                <h5 class="card-title" style="font-size: 25px !important; color:white"><?php echo $i ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <?php
                                $sql = "SELECT * FROM tb_order
                               INNER JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
                               INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id = tb_order.order_id
                               WHERE tb_order.order_status ='ปกติ' AND tb_order_detail.order_detail_planting_status = 'กำลังทำการปลูก' AND tb_order_detail.order_detail_status = 'ปกติ'
                               GROUP BY tb_order.order_id";

                                $result = mysqli_query($conn, $sql);
                                if ($result->num_rows > 0) {
                                    $i2 = 0;
                                    while ($row = $result->fetch_assoc()) {

                                        $i2++;
                                    }
                                }else{
                                    $i2 = 0;
                                }

                                ?>
                                <div class="col-6" style="padding-right: 0px; padding-left: 10px;">
                                    <a href="#modal_order_planting" data-toggle="modal" title="รายการสั่งซื้อที่กำลังปลูก">
                                        <div class="card text-white bg-gradient-red mb-3" style="max-width: 9rem;">
                                            <strong>
                                                <div class="card-header text-muted" align="center">กำลังปลูก</div>
                                            </strong>
                                            <div class="card-body" align="center">
                                                <h5 class="card-title" style="font-size: 25px !important; color:white" id="order_planting_text"><?php echo $i2 ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats shadow-lg ">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col" align="center">
                                    <strong> <a href="./admin.php?page=planting" title="รายการปลูก" class="card-title text-uppercase text-muted mb-0" style="font-size: 18px !important;">รายการปลูก</a></strong>&nbsp;&nbsp;<div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                        <i class="fas fa-seedling" style="color:white;"></i>

                                    </div>
                                </div>

                            </div>
                            <hr style="background:green; height:1px;">
                            <div class="row">
                                <div class="col" align="center">

                                    <?php
                                    $sql_count4 = "SELECT *
                                                    FROM tb_planting 
                                                    INNER JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
                                                    WHERE tb_planting.planting_status ='ปกติ' AND (tb_planting_detail.planting_detail_status = 'ปกติ' OR tb_planting_detail.planting_detail_status = 'รอคัดเกรด')
                                                    GROUP BY tb_planting.planting_id
                                                    ";
                                   /* $re_count4 = mysqli _query($conn, $sql_count4);
                                    $r_count4 = mysqli_fetch_assoc($re_count4);
                                    $sum_order4 = $r_count4['count'];

                                    if ($sum_order4 == "") {
                                        $sum_order4 = 0;
                                    } */

                                    $result2 = mysqli_query($conn, $sql_count4);
                                if ($result2->num_rows > 0) {
                                    $i22 = 0;
                                    while ($row2 = $result2->fetch_assoc()) {

                                        $i22++;
                                    }
                                }else{
                                    $i22 = 0;
                                }
                                    ?>
                                    <div class="col-7" style="padding-right: 0px; padding-left: 10px;">
                                        <a href="#modal_planting" data-toggle="modal" title="รายการปลูกทั้งหมด">
                                            <div class="card text-white bg-gradient-green mb-3" style="max-width: 9rem;">
                                                <strong>
                                                    <div class="card-header text-muted" align="center">ทั้งหมด</div>
                                                </strong>
                                                <div class="card-body" align="center">
                                                    <h5 class="card-title" style="font-size: 25px !important; color:white"><?php echo $i22 ?></h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats shadow-lg-orange">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col" align="center">
                                    <strong><a href="./admin.php?page=stock_recieve" title="รายการรอรับเข้า" class="card-title text-uppercase text-muted mb-0" style="font-size: 18px !important;">รอคัดเกรด</a></strong>&nbsp;&nbsp;<div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                        <i class="fas fa-ad" style="color:white;"></i>
                                    </div>
                                </div>
                            </div>
                            <hr style="background:orange; height:1px;">
                            <div class="row">
                                <div class="col" align="center">

                                    <?php
                                    $sql_count5 = "SELECT COUNT(tb_planting.planting_id) as count
                                    FROM tb_planting 
                                    INNER JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
                                    WHERE tb_planting.planting_status ='ปกติ' AND tb_planting_detail.planting_detail_status = 'รอคัดเกรด'";
                                    $re_count5 = mysqli_query($conn, $sql_count5);
                                    $r_count5 = mysqli_fetch_assoc($re_count5);
                                    $sum_order5 = $r_count5['count'];

                                    if ($sum_order5 == "") {
                                        $sum_order5 = 0;
                                    }
                                    ?>
                                    <div class="col-7" style="padding-right: 0px; padding-left: 10px;">
                                        <a href="#modal_recieve" data-toggle="modal" title="รายการรอคัดเกรดทั้งหมด">
                                            <div class="card text-white bg-gradient-orange mb-3" style="max-width: 9rem;">
                                                <strong>
                                                    <div class="card-header text-muted" align="center">ทั้งหมด</div>
                                                </strong>
                                                <div class="card-body" align="center">
                                                    <h5 class="card-title" style="font-size: 25px !important; color:white"><?php echo $sum_order5 ?></h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats shadow-lg-purple ">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col" align="center">
                                    <strong> <a href="./admin.php?page=stock_handover" title="รายการรอส่งมอบ" class="card-title text-uppercase text-muted mb-0" style="font-size: 18px !important;">รอส่งมอบ</a></strong>&nbsp;&nbsp;<div class="icon icon-shape bg-gradient-purple text-white rounded-circle shadow">
                                        <i class="fas fa-hand-holding-usd" style="color:white;"></i>
                                    </div>
                                </div>

                            </div>
                            <hr style="background:purple; height:1px;">
                            <div class="row">
                                <div class="col" align="center">
                                    <?php
                                        $sql_count6 = "SELECT COUNT(tb_order_detail.order_detail_id) as count
                                                        FROM tb_order_detail 
                                                        INNER JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
                                                        WHERE tb_order_detail.order_detail_status ='รอส่งมอบ' AND tb_order.order_status = 'ปกติ'";
                                    $re_count6 = mysqli_query($conn, $sql_count6);
                                    $r_count6 = mysqli_fetch_assoc($re_count6);
                                    $sum_order6 = $r_count6['count'];

                                    if ($sum_order6 == "") {
                                        $sum_order6 = 0;
                                    }

                                    ?>
                                    <div class="col-7" style="padding-right: 0px; padding-left: 10px;">
                                        <a href="#modal_handover" data-toggle="modal" title="รายการรอส่งมอบทั้งหมด">
                                            <div class="card text-white bg-gradient-purple mb-3" style="max-width: 9rem;">
                                                <strong>
                                                    <div class="card-header text-muted" align="center">ทั้งหมด</div>
                                                </strong>
                                                <div class="card-body" align="center">
                                                    <h5 class="card-title" style="font-size: 25px !important; color:white"><?php echo $sum_order6 ?></h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><br>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_order_all">
    <div class="modal-dialog modal-lxx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายการสั่งซื้อทั้งหมด</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" id="form_modal_order_all">
                    <table id="tb_order_all" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>รหัสรายการ</th>
                            <th>ชื่อรายการ</th>
                            <th>ชื่อลูกค้า</th>
                            <th>จำนวนเงิน (บาท)</th>
                            <th>รายการปลูก</th>
                            <th>รายละเอียด</th>
                            <th>วันที่บันทึก</th>

                            <th></th>
                        </thead>
                    </table>
            </div>

        </div>
    </div>
    </form>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="view_order_all">
    <div class="modal-dialog modal-lxx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายละเอียดรายการสั่งซื้อ</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" id="form_view_order_all">
                    <table id="tb_view_order_all" class="table-bordered text-center" width="100%">
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

                        </thead>
                    </table>
            </div>

        </div>
    </div>
    </form>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_order_not_plant">
    <div class="modal-dialog modal-lxx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายการสั่งซื้อที่ยังไม่ได้ปลูก</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" id="form_modal_order_not_plant">
                    <table id="tb_order_not_planting" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>รหัสรายการ</th>
                            <th>ชื่อรายการ</th>
                            <th>ชื่อลูกค้า</th>
                            <th>จำนวนเงิน (บาท)</th>
                            <th>รายการปลูก</th>
                            <th>รายละเอียด</th>
                            <th>วันที่บันทึก</th>
                            <th></th>
                        </thead>
                    </table>
            </div>

        </div>
    </div>
    </form>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="view_order_not_planting">
    <div class="modal-dialog modal-lxx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายการสั่งซื้อที่ยังไม่ได้ปลูก</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" id="form_modal_order_not_plant_detail">
                    <table id="tb_order_not_planting_detail" class="table-bordered text-center" width="100%">
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

                        </thead>
                    </table>
            </div>

        </div>
    </div>
    </form>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_order_planting">
    <div class="modal-dialog modal-lxx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายการสั่งซื้อที่กำลังปลูก</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" id="form_modal_order_planting">
                    <table id="tb_order_planting" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>รหัสรายการ</th>
                            <th>ชื่อรายการ</th>
                            <th>ชื่อลูกค้า</th>
                            <th>จำนวนเงิน (บาท)</th>
                            <th>รายการปลูก</th>
                            <th>รายละเอียด</th>
                            <th>วันที่บันทึก</th>
                            <th></th>

                        </thead>
                    </table>
            </div>

        </div>
    </div>
    </form>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="view_order_planting_detail">
    <div class="modal-dialog modal-lxx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายการสั่งซื้อที่กำลังปลูก</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" id="form_modal_order_planting">
                    <table id="tb_order_planting_detail" class="table-bordered text-center" width="100%">
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
                        </thead>
                    </table>
            </div>

        </div>
    </div>
    </form>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_planting">
    <div class="modal-dialog modal-lxx">
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-seedling"></i> รายการปลูกทั้งหมด</h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" id="form_modal_order_planting">
                    <table id="tb_planting" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>รหัสรายการปลูก</th>
                            <th>ชื่อรายการ</th>
                            <th>ชื่อลูกค้า</th>
                            <th>รายการปลูก</th>
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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="view_planting">
    <div class="modal-dialog modal-xxxl">
        <!-- Modal content-->
        <div class="modal-content" style="width:auto">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-seedling"></i> รายละเอียดรายการปลูกทั้งหมด
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <table id="tb_planting_detail" class="table-bordered text-center" width="100%">
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
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="view_planting_list">
    <div class="modal-dialog modal-lx">
        <!-- Modal content-->
        <div class="modal-content" style="width:auto">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-seedling"></i> รายละเอียดแต่ละสัปดาห์
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <table id="tb_planting_list" class="table-bordered text-center" width="100%">
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
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="planting_week_detail">
    <div class="modal-dialog modal-lxx">
        <!-- Modal content-->
        <div class="modal-content" style="width:auto">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-seedling"></i> ข้อมูลการปลูกแต่ละสัปดาห์
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <table id="tb_planting_list_detail" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>ชื่อสูตรยา</th>
                            <th>ปริมาณสูตรยา (มิลลิลิตร)</th>
                            <th>ราคาสูตรยา (บาท)</th>
                            <th>ชื่อวัสดุปลูก</th>
                            <th>ปริมาณวัสดุปลูก (กรัม)</th>
                            <th>ราคาวัสดุปลูก (บาท)</th>
                            <th>จำนวนต้นตาย (ต้น)</th>
                            <th>วันที่บันทึก</th>
                            <th>สถานะ</th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_recieve">
    <div class="modal-dialog modal-lx">
        <!-- Modal content-->
        <div class="modal-content" style="width:auto">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-ad"></i> รายการรอคัดเกรด
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <table id="tb_recieve" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>รหัสรายการปลูก</th>
                            <th>ชื่อรายการ</th>
                            <th>ชื่อลูกค้า</th>
                            <th>วันที่บันทึก</th>
                            <th>สถานะ</th>
                            <th></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="view_recieve_detail">
    <div class="modal-dialog modal-lxx">
        <!-- Modal content-->
        <div class="modal-content" style="width:auto">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-ad"></i> รายละเอียดรายการรอคัดเกรด
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <table id="tb_recieve_detail" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>รหัสรายการปลูก</th>
                            <th>ชื่อพันธุ์ไม้</th>
                            <th>ปลูก (ต้น)</th>
                            <th>ต้นตาย (ต้น)</th>
                            <th>คงเหลือ (ต้น)</th>
                            <th>ค่าใช้จ่ายรวม (บาท)</th>
                            <th>วันที่ส่งมอบ</th>
                            <th>ระยะเวลาที่เหลือ</th>
                            <th>สถานะ</th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_handover">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="width:auto">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-hand-holding-usd"></i> รายการรอส่งมอบ
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <table id="tb_handover" class="table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>รหัสรายการปลูก</th>
                            <th>ชื่อรายการ</th>
                            <th>ชื่อลูกค้า</th>
                            <th>ชื่อพันธุ์ไม้</th>
                            <th>จำนวน (ต้น)</th>
                            <th>รายละเอียดเพิ่มเติม</th>
                            <th>สถานะ</th>
                            <th></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="view_handover_detail">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content" style="width:auto">
            <div class="modal-header">
                <h5 class="modal-title card-title"><i class="fas fa-hand-holding-usd"></i> รายละเอียดรายการรอส่งมอบ
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                    <h3>&times;</h3>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <table id="tb_handover_detail" class="table-bordered text-center" width="100%">
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
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>




<script src="assets/js/apps/index.js"></script>