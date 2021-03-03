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
$customer = $_POST['customer'];
$handover = $_POST['handover'];
/* $IDS =1; */
if ($select == 'day' && $st_date != "" && $en_date != '') {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    WHERE tb_handover_noplant.handover_noplant_date BETWEEN '$st_date' AND '$en_date'
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
  
   
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    WHERE MONTH(tb_handover_noplant.handover_noplant_date)='$month' AND YEAR(tb_handover_noplant.handover_noplant_date)='$my'
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
  
   
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    WHERE  YEAR(tb_handover_noplant.handover_noplant_date)='$year'
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
  
    
} else if ($select == 'type' && $customer != '0') {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    WHERE tb_customer.customer_id='$customer'
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
  
   
} else if ($select == 'handover' && $handover != '0') {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    WHERE tb_order.order_name ='$handover'
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
   
} else {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
  
}

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= '
    <table class="table table-bordered text-center" id ="handoverTable" width = "100%">
        <thead bgcolor="#2dce89">
            <th align="center">ลำดับ</th>
            <th align="center">รหัสการส่งมอบ</th>
            <th align="center">ชื่อลูกค้า</th>
            <th align="center">ชื่อพันธุ์ไม้</th>
            <th align="center">เกรด</th>
            <th align="center">วันที่ส่งมอบ</th>
            <th align="center">จำนวนส่งมอบ (ต้น)</th>
            <th align="center">จำนวนเงิน (บาท)</th>
        </thead>
 ';
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $i++;
        $id = $row['handover_noplant_id'];
        $fname = $row['customer_firstname'];
        $lname = $row['customer_lastname'];
        $pname = $row['plant_name'];
      /*   if ($IDS == $id) {
            $ida = " ";
            $i2 = " ";
            $fname = " ";
            $lname = " ";
            $pname = " ";
        } else {
            $i2 = $i++;
            $ida = $id;
        }
        $IDS =  $id; */
        $output .= '
   <tr>
            <td  class="id">' . $i . '</td>
            <td  class="handover_id">' . $row["handover_noplant_id"] . '</td>
            <td  class="customer_firstname">' .  $fname ." "." ". $lname.  '</td>
            <td  class="plant_name">' . $pname . '</td>
            <td  class="grade_name">' . $row["grade_name"] . '</td>
            <td  class="grade_name">' . $row["handover_noplant_date"] . '</td>
            <td  align = right class="handover_noplant_detail_amount">' . number_format($row["handover_noplant_detail_amount"]). '</td>
            <td  align = right class="SUM">' . number_format($row["SUM"],2). '</td>
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

        var t = $('#handoverTable').DataTable({
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
                    className: 'dt-body-center'
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