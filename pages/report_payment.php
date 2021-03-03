<?php
//fetch.php
require ('connect.php');
$output = '';
$st_date = $_POST['st_date'];
$en_date = $_POST['en_date'];
$month = $_POST['month'];
$my = $_POST['month_year'];
$year = $_POST['year'];
$select = $_POST['select'];
$type_plant = $_POST['type_plant'];
$plant = $_POST['plant'];
$grade = $_POST['grade'];
$IDS =1;
if ($select == 'day' && $st_date != "" && $en_date != '') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND tb_payment.payment_date BETWEEN '$st_date' AND '$en_date')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND MONTH(tb_payment.payment_date)='$month' AND YEAR(tb_payment.payment_date)='$my')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    
} else if ($select == 'year' && $year != "") {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE  (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND YEAR(tb_payment.payment_date)='$year')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
   
} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND tb_typeplant.type_plant_id='$type_plant')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
  
} else if ($select == 'plant' && $plant != '0') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND tb_plant.plant_id='$plant')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";

} else if ($select == 'grade' && $grade != '0') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND tb_grade.grade_id='$grade')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";

} else {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE (tb_payment_detail.payment_detail_status ='เสร็จสิ้น')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    
}

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= '
    <table class="table table-bordered text-center" id ="stockTable" width = "100%">
        <thead bgcolor="#2dce89">
            <th align="center">ลำดับ</th>
            <th align="center">รหัสรายการ</th>
            <th align="center">ชื่อพันธุ์ไม้</th>
            <th align="center">เกรด</th>
            <th align="center">ราคา (บาท/ต้น)</th>
            <th align="center">วันที่บันทึก</th>
            <th align="center">จำนวน(ต้น)</th>
            <th align="center">จำนวนเงิน(บาท)</th>
        </thead>
 ';
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['payment_id'];
        $plantprice  = $row['plant_detail_price'];
        $total  = $row['payment_detail_total'];
        $date = date("d-m-Y",strtotime($row['payment_date']));
        if ($IDS == $id) {
            $ida = " ";
            $i2 = " ";
        } else {
            $i2 = $i++;
            $ida = $id;
        }
        $IDS =  $id;
        $output .= '
        <tr>
        <td class="id">' . $i . '</td>
        <td class="payment_id">' . $ida . '</td>
        <td  class="plant_name">' . $row["plant_name"] . '</td>
        <td  class="grade_name">' . $row["grade_name"] . '</td>
        <td align = right class="plantprice">' .  number_format($plantprice, 2) . '</td>
        <td  class="date">' . $date. '</td>
        <td align = right class="amount">' . number_format($row["payment_detail_amount"]). '</td>
        <td align = right class="total">' .  number_format($total, 2) . '</td>
        </tr>
  ';                                                 
    }
    //echo $query;
    echo $output;
} else {
    echo '<center>ไม่พบข้อมูล</center>';
}

?>
<script>
    $(document).ready(function() {

        var t = $('#stockTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 2,
                    targets: 1
                },
                {
                    targets: 4,
                    className: 'dt-body-right'
                },

            ],

            "language": {
                "search": "ค้นหา:",


                "info": "<h4> แสดง  _START_  ถึง _END_ ทั้งหมด จาก <strong style='color:red;'> _TOTAL_ </strong> รายการ </h4>",
                "zeroRecords": "ไม่พบรายการค้นหา",
                "infoEmpty": "แสดงรายการ 0 ถึง 0 ทั้งหมด 0 รายการ",
                "paginate": {
                    "first": "หน้าแรก",
                    "last": "หน้าสุดท้าย",
                    "next": ">>>",
                    "previous": "<<<"
                },


                "infoFiltered": "( คำที่ค้นหา จาก _MAX_ รายการ ทั้งหมด ) ",

            },

        });
        t.on('order.dt search.dt', function () {
            t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    });
</script>