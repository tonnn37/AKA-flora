<?php
//fetch.php
require 'connect.php';
$output = '';
$st_date = $_POST['st_date'];
$en_date = $_POST['en_date'];
$month = $_POST['month'];
$my = $_POST['month_year'];
$year = $_POST['year'];
$select = $_POST['select'];
$type_plant = $_POST['type_plant'];
$status = $_POST['status'];
$planting = $_POST['planting'];
$sum1 = 0;
if ($select == 'day' && $st_date != "" && $en_date != '') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE tb_planting.planting_date BETWEEN '$st_date' AND '$en_date'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE MONTH(tb_planting.planting_date)='$month' AND YEAR(tb_planting.planting_date)='$my'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE  YEAR(tb_planting.planting_date)='$year'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_typeplant.type_plant_id='$type_plant'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
} else if ($select == 'status' && $status != '0') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE tb_planting_detail.planting_detail_status='$status'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
} else if ($select == 'planting' && $planting != '0') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE tb_order.order_name ='$planting'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
} else {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
}
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= '

   <table class="table table-bordered text-center" id ="plantingTable" width = "100%">
   <thead bgcolor="#2dce89">
                        <th align="center">ลำดับ</th>
                        <th align="center">ชื่อพันธุ์ไม้</th>
                        <th align="center">วันที่เริ่มปลูก</th>
                        <th align="center">สัปดาห์</th>
                        <th align="center">จำนวนต้น</th>
                        <th align="center">จำนวนต้นตาย</th>
                        <th align="center">จำนวนคงเหลือ</th>
    </thead>
 ';
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $i++;
        $total = $row['planting_detail_total'];
        $dead   = $row['SUM'];
        $week   = $row['MAX'];
        $time   = $row['plant_time'];
        $sum1 = $total - $dead;
        $date = date("d-m-Y",strtotime($row['planting_date']));
        $output .= '
   <tr>
            <td  class="ref_plant_id">' . $i . '</td>
            <td  class="plant_name">' . $row["plant_name"] . '</td>
            <td  class="planting_id">' .$date. '</td>
            <td  class="plant_week">' . $week . " / " . $time . '</td>
            <td  class="planting_detail_total">' . number_format($row["planting_detail_total"]) . '</td>
            <td  class="SUM">' . number_format($row["SUM"]) . '</td>
            <td align = right class="SUM1">' . number_format($sum1) . '</td>
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

        var t = $('#plantingTable').DataTable({
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
                {
                    targets: 5,
                    className: 'dt-body-right'
                }

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
        t.on('order.dt search.dt', function() {
            t.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    });
</script>