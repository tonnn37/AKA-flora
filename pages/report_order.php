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
$status = $_POST['status'];
$IDS =1;

if ($select == 'day' && $st_date != "" && $en_date != '') {
    $query = "SELECT tb_order_detail.order_detail_planting_status AS order_detail_planting_status,tb_customer.customer_id AS customer_id, tb_order_detail.order_detail_id AS order_detail_id,tb_order.order_customer AS order_customer,
    tb_plant.plant_name as plant_name,tb_order_detail.order_detail_amount AS order_detail_amount , tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname, COUNT( tb_plant.plant_id) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id=tb_order.order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
WHERE  tb_order.order_date BETWEEN '$st_date' AND '$en_date'
GROUP BY  tb_order_detail.order_detail_id
ORDER BY tb_order_detail.order_detail_id";
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_order_detail.order_detail_planting_status AS order_detail_planting_status,tb_customer.customer_id AS customer_id, tb_order_detail.order_detail_id AS order_detail_id,tb_order.order_customer AS order_customer,
    tb_plant.plant_name as plant_name,tb_order_detail.order_detail_amount AS order_detail_amount , tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname, COUNT( tb_plant.plant_id) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id=tb_order.order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
WHERE MONTH(tb_order.order_date)='$month' AND YEAR(tb_order.order_date)='$my'
GROUP BY  tb_order_detail.order_detail_id
ORDER BY tb_order_detail.order_detail_id";
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_order_detail.order_detail_planting_status AS order_detail_planting_status,tb_customer.customer_id AS customer_id, tb_order_detail.order_detail_id AS order_detail_id,tb_order.order_customer AS order_customer,
    tb_plant.plant_name as plant_name,tb_order_detail.order_detail_amount AS order_detail_amount , tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname, COUNT( tb_plant.plant_id) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id=tb_order.order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
    WHERE  YEAR(tb_order.order_date)='$year'
    GROUP BY  tb_order_detail.order_detail_id
ORDER BY tb_order_detail.order_detail_id";
} else if ($select == 'type' && $customer != '0') {
    $query = "SELECT tb_order_detail.order_detail_planting_status AS order_detail_planting_status,tb_customer.customer_id AS customer_id, tb_order_detail.order_detail_id AS order_detail_id,tb_order.order_customer AS order_customer,
    tb_plant.plant_name as plant_name,tb_order_detail.order_detail_amount AS order_detail_amount , tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname, COUNT( tb_plant.plant_id) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id=tb_order.order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
WHERE tb_customer.customer_id='$customer'
GROUP BY  tb_order_detail.order_detail_id
ORDER BY tb_order_detail.order_detail_id";
} else if ($select == 'status' && $status != '0') {
    $query = "SELECT tb_order_detail.order_detail_planting_status AS order_detail_planting_status,tb_customer.customer_id AS customer_id, tb_order_detail.order_detail_id AS order_detail_id,tb_order.order_customer AS order_customer,
    tb_plant.plant_name as plant_name,tb_order_detail.order_detail_amount AS order_detail_amount , tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname, COUNT( tb_plant.plant_id) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id=tb_order.order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
   WHERE tb_order_detail.order_detail_planting_status='$status'
   GROUP BY  tb_order_detail.order_detail_id
ORDER BY tb_order_detail.order_detail_id";
} else {
    $query = "SELECT tb_order_detail.order_detail_planting_status AS order_detail_planting_status,tb_customer.customer_id AS customer_id, tb_order_detail.order_detail_id AS order_detail_id,tb_order.order_customer AS order_customer,
    tb_plant.plant_name as plant_name,tb_order_detail.order_detail_amount AS order_detail_amount , tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname, COUNT( tb_plant.plant_id) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id=tb_order.order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
    GROUP BY  tb_order_detail.order_detail_id
ORDER BY tb_order_detail.order_detail_id";
}


$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= '
   <table class="table table-bordered text-center" id ="ordertable" width = "100%">
   <thead bgcolor="#2dce89">
                        <th align="center">ลำดับ</th>
                        <th align="center">รหัสรายการสั่งซื้อ</th>
                        <th align="center">ชื่อลูกค้า</th>
                        <th align="center">ชื่อพันธุ์ไม้</th>
                        <th align="center">สถานะการสั่งซื้อ</th>
                        <th align="center">จำนวน (ต้น)</th>
                        <th align="center">จำนวนเงิน (บาท)</th>
    </thead>
 ';
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['customer_id'];
        $id1 = $row['order_detail_id'];
        $fname = $row['customer_firstname'];
        $lname = $row['customer_lastname'];
        $pname = $row['plant_name'];
        $status = $row['order_detail_planting_status'];
        if ($IDS == $id) {
            $ida = " ";
            $i2 = " ";
            $fname = " ";
            $lname = " ";
        } else {
            $i2 = $i++;
            $ida = $id;
        }
        $IDS =  $id;
        $output .= '
        <tr>
            <td  class="id">' . $i . '</td>
            <td  class="order_id">' . $id1 . '</td>
            <td  align = center class="customer_firstname">' . $fname ." "." ".$lname. '</td>
            <td  class="plantname">' . $pname. '</td>
            <td  align = center class="status">' . $status. '</td>
            <td  align = right  class="order_detail_amount">' . number_format($row["order_detail_amount"]). '</td> 
            <td  align = right  class="SUM">' .number_format($row["SUM"],2). '</td>
          
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

        var t = $('#ordertable').DataTable({
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
                    className: 'dt-body-center'
                },
                {
                    targets: 2,
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