<?php

require 'connect.php';

$id = $_POST['id'];

$query = "SELECT tb_grade.grade_id as grade_id ,
tb_grade.grade_name as grade_name
,tb_stock_recieve_detail.recieve_detail_amount as recieve_detail_amount
FROM tb_stock_recieve_detail
LEFT JOIN tb_stock_recieve ON tb_stock_recieve.stock_recieve_id = tb_stock_recieve_detail.ref_stock_recieve_id
LEFT JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_stock_recieve.ref_planting_detail_id
LEFT JOIN tb_order_detail ON tb_order_detail.order_detail_id = tb_planting_detail.ref_order_detail_id
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_recieve_detail.ref_grade_id
WHERE tb_order_detail.order_detail_id ='$id' AND tb_stock_recieve_detail.recieve_detail_status ='ปกติ'

GROUP BY tb_grade.grade_id";

$re_new = mysqli_query($conn, $query);

$output = '';
if ($re_new->num_rows > 0) {
    // output data of each row
    while ($row = $re_new->fetch_assoc()) {
        $grade_id = $row['grade_id'];
        $grade_name = $row['grade_name'];
        $grade_amount = $row['recieve_detail_amount'];

        $output .= ' 
       
            <div class="col-sm-12" class="hidden_grade10">
                <div class="row" >
                    <div class="col-4" align="right">
                        <label class ="hidden_grade1">เกรด'." ".' ' . $grade_name . ' :</label>
                        <input type="hidden" class="form-control in_handover_grade_name2" id="in_handover_grade_name2" name="in_handover_grade_name2" value ="' . $grade_id . '" >
                       
                    </div>
                    <div class="col-4">
                        <div class="form-group" >
                            <input type="textbox" class="form-control in_handover_grade_amount2" id="in_handover_grade_amount2" name="in_handover_grade_amount2" value ="' . $grade_amount . '" data-grade="' . $grade_id . '" readonly>
                            <span class="error_grade" id="error_grade"></span>
                        </div>
                    </div>
                    <span class ="hidden_grade2"> ต้น</span>
                </div>
            </div>';
    }
    echo $output;
} else {
}
