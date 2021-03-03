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
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    WHERE tb_stock_detail.stock_detail_date BETWEEN '$st_date' AND '$en_date'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";
    
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    WHERE MONTH(tb_stock_detail.stock_detail_date)='$month' AND YEAR(tb_stock_detail.stock_detail_date)='$my'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";
    
} else if ($select == 'year' && $year != "") {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id 
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    WHERE  YEAR(tb_stock_detail.stock_detail_date)='$year'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";
   
} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id 
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_typeplant.type_plant_id='$type_plant'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";
  
} else if ($select == 'plant' && $plant != '0') {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id 
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_plant.plant_id='$plant'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";

} else if ($select == 'grade' && $grade != '0') {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id 
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_grade.grade_id='$grade'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";

} else {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id 
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";
    
}

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= '
    <table class="table table-bordered text-center" id ="stockTable" width = "100%">
        <thead bgcolor="#2dce89">
            <th align="center">ลำดับ</th>
            <th align="center">รหัสพันธุ์ไม้</th>
            <th align="center">ชื่อพันธุ์ไม้</th>
            <th align="center">เกรด </th>
            <th align="center">จำนวน(ต้น)</th>
        </thead>
 ';
    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['plant_id'];
        $fname = $row['plant_name'];
        if ($IDS == $id) {
            $ida = " ";
            $i2 = " ";
            $fname = " ";
        } else {
            $i2 = $i++;
            $ida = $id;
        }
        $IDS =  $id;
        $output .= '
        <tr>
            <td  class="id">' . $i . '</td>
            <td  class="order_id">' . $ida  . '</td>
            <td  class="plant_name">' . $fname. '</td>
            <td  class="grade_name">' . $row["grade_name"] . '</td>     
            <td  class="stock_detail_amount">' . number_format($row["stock_detail_amount"]). '</td>
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