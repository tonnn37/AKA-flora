<?php
//fetch.php
require('connect.php');
$output = '';
$st_date = $_POST['st_date'];
$en_date = $_POST['en_date'];
$month = $_POST['month'];
$my = $_POST['month_year'];
$year = $_POST['year'];
$select = $_POST['select'];
$type_material = $_POST['type_material'];
$status = $_POST['status'];

date_default_timezone_set('Asia/Bangkok');
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    if ($strDay < 10) {
        $strDay = "0" . $strDay;
        $strMonth ="0".$strMonth;
    }
    return "$strDay/$strMonth/$strYear $strHour:$strMinute";
}

if ($select == 'day' && $st_date != "" && $en_date != '') {
    $query = "SELECT tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id , tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    WHERE  tb_planting_week_detail.week_detail_date BETWEEN '$st_date' AND '$en_date'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id , tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    WHERE MONTH(tb_planting_week_detail.week_detail_date)='$month' AND YEAR(tb_planting_week_detail.week_detail_date)='$my'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id , tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    WHERE  YEAR(tb_planting_week_detail.week_detail_date)='$year'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
} else if ($select == 'type' && $type_material != "0") {
    $query = "SELECT  tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id , tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    WHERE tb_order.order_id ='$type_material'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
} else if ($select == 'status' && $status != '0') {
    $query = "SELECT tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id , tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    WHERE tb_planting_detail.planting_detail_status='$status'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
} else {
    $query = "SELECT tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id, tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
}
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= '
    <table class="table table-bordered text-center" id ="materialTable" width = "100%">
        <thead bgcolor="#2dce89">
            <th align="center">ลำดับ</th>
            <th align="center">รหัสรายการปลูก</th>
            <th align="center">ชื่อพันธุ์ไม้</th>
            <th align="center">จำนวนที่ปลูก (ต้น)</th>
            <th align="center">ปริมาณสูตรยา (ลิตร)</th>
            <th align="center">ปริมาณวัสดุปลูก (กก.)</th>
            <th align="center">ราคาสูตรยา (บาท)</th>
            <th align="center">ราคาวัสดุปลูก (บาท)</th>
            <th align="center">ราคาทั้งหมด (บาท)</th>
        </thead>
 ';
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $i++;

        $pname  = $row['plant_name'];
        $plantamount  = $row['planting_detail_total'];
        $amount  = $row['SUM'];
        $matamount  = $row['material_amount'];
        $price   = $row['SUM1'];
        $drugamount = $row['SUM2'];
        $drugprice = $row['SUM3'];
        $total =   $price + $drugprice;
        $drugamount1 = $drugamount ;
        $amount1 = $amount;
        $output .= '
        <tr>
            <td class="material_id">' . $i . '</td>
            <td class="material_id">' . $row["planting_detail_id"] . '</td>
            <td class="material_id">' . $row["plant_name"] . '</td>
            <td align = right class="plantamount">' . number_format($plantamount) . '</td>
            <td align = right class="drugamount">' . number_format($drugamount1,1) . '</td>
            <td align = right class="amount">' . number_format($amount1,1) . '</td>
            <td align = right class="drugprice">' . number_format($drugprice, 2) . '</td>
            <td align = right class="price">' .  number_format($price, 2) . '</td>
            <td align = right class="SUM1">' .  number_format($total, 2) . '</td>
        </tr>
  ';
    }
    echo $output;
} else {
    echo '<center>ไม่พบข้อมูล</center>';
}


?>
<script>
    $(document).ready(function() {

        var t = $('#materialTable').DataTable({
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
                    targets: 5,
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