
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
if ($select == 'day' && $st_date != "" && $en_date != '') {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
FROM tb_order_detail
INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE tb_order.order_date BETWEEN '$st_date' AND '$en_date'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
FROM tb_order_detail
INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE MONTH(tb_order.order_date)='$month' AND YEAR(tb_order.order_date)='$my'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE  YEAR(tb_order.order_date)='$year'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";

} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
WHERE tb_typeplant.type_plant_id='$type_plant'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
} else {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
}
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= '
    <table class="table table-bordered text-center" id ="topTable" width = "100%">
        <thead bgcolor="#2dce89">
            <th align="center">ลำดับ</th>
            <th align="center">รหัสพันธุ์ไม้</th>
            <th align="center">ชื่อพันธุ์ไม้</th>
            <th align="center">จำนวนการขาย (ครั้ง)</th>
            <th align="center">จำนวนยอดขาย (ต้น)</th>
        </thead>
 ';
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $i++;
        $output .= '
        <tr>
            <td class="ref_plant_id">' . $i . '</td>
            <td class="order_id">' . $row["plant_id"] . '</td>
            <td  class="plant_name">' . $row["plant_name"] . '</td>
            <td class="count_number">' . number_format($row["count_number"]). '</td>
            <td class="SUM">' . number_format($row["SUM"]). '</td>
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

        var t = $('#topTable').DataTable({
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