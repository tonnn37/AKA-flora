<!-- แสดงข้อมูลในตาราง -->
<div class="row">
    <div class="col-12">
        <table class="table table-bordered text-center" id="stockTable" width="100%">
            <thead bgcolor="#2dce89" style="text-align: center;">
                <th>ลำดับ</th>
                <th>ชื่อพันธุ์ไม้</th>
                <th>จำนวน (ต้น)</th>
                <th></th>
            </thead>


        </table>
    </div>
</div>



<!-- ตารางรายละเอียดออเดอร์ ในปุ่มแสดงรายละเอียด -->
<div id="view_stock_detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="modal-dialog modal-lx">
            <!-- Modal content-->
            <div class="modal-content" style="width:auto">
                <div class="modal-header">
                    <h5 class="modal-title card-title"><i class="fas fa-list-ol"></i> รายละเอียดสต็อก
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                        <h3>&times;</h3>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-4" align="right">
                                    <strong><label>ชื่อพันธุ์ไม้ : </label></strong>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label id="detail_name"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table id="stock_detailTable" class="table-striped table-bordered text-center" width="100%">
                        <thead bgcolor="#2dce89">
                            <th>ลำดับ</th>
                            <th>เกรด</th>
                            <th>จำนวน (ต้น)</th>
                            <th></th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
$query_detail = "SELECT tb_stock_detail.stock_detail_id as stock_detail_id,
tb_stock_detail.stock_detail_status as stock_detail_status,
tb_stock_detail.stock_detail_date as stock_detail_date,
tb_stock_detail.stock_detail_amount as stock_detail_amount,
tb_grade.grade_id as grade_id,
tb_grade.grade_name as grade_name,
tb_plant.plant_id as plant_id,
tb_plant.plant_name as plant_name


FROM tb_stock_detail
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_detail.ref_grade_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_detail.ref_plant_id
WHERE tb_stock_detail.stock_detail_status ='ปกติ'
ORDER BY tb_stock_detail.stock_detail_id";



$result = mysqli_query($conn, $query_detail);
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $stock_detail_id = $row['stock_detail_id'];
        $stock_detail_amount = $row['stock_detail_amount'];
        $grade_id = $row['grade_id'];
        $grade_name = $row['grade_name'];
        $plant_id = $row['plant_id'];

?>
        <div id="edit_stock_detail<?php echo $stock_detail_id; ?>" class="modal fade edit_detail" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title card-title"><i class="fas fa-prescription-bottle"></i>
                            ปรับปรุงจำนวนต้นไม้</h5>
                        <button type="button" class="close" data-dismiss="modal" style="width:50px;">
                            <h3>&times;</h3>
                        </button>
                    </div>
                    <div class="modal-body"><br>
                        <form role="form" method="post" action="" id="edit_details<?php echo $stock_detail_id; ?>" class="edit_details">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">



                                        <div class="col-4" align="center">
                                            <label>
                                                <h1>เกรด : <?= $grade_name ?></h1>
                                            </label>
                                        </div>
                                        <input type="hidden" class="form-control edit_detail_grade" id="edit_detail_grade<?= $stock_detail_id ?>" name="edit_detail_grade" value="<?= $grade_id ?>" data="<?= $stock_detail_id ?>">
                                        <span> จำนวน :</span>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="textbox" class="form-control edit_detail_amount" id="edit_detail_amount<?= $grade_id . $stock_detail_id ?>" name="edit_detail_amount" value="<?= $stock_detail_amount ?>">
                                            </div>
                                        </div>
                                        <span> ต้น</span>&nbsp;
                                        <strong><span style="color:red"> *</span></strong>
                                    </div>
                                </div>
                            </div>
                    </div><br>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group" align="right">
                                <button type="button" class="btn btn-outline-success" name="btn_edit_detail" id="btn_edit_detail" data-id="<?= $stock_detail_id ?>">บันทึก</button>
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
