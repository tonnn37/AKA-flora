<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

?>
<?php
$handover_id = $_POST['handover_id'];
$handover_status = $_POST['handover_status'];
$d = date("Y-m-d");

if ($handover_status == 'เสร็จสิ้น') {
    $update_handover = "UPDATE tb_stock_handover  SET handover_status='ยกเลิก',update_by='$name',update_at='$d' WHERE handover_id ='$handover_id'";
    mysqli_query($conn, $update_handover);
    echo $update_handover;

    $update_handover_detail = "UPDATE tb_stock_handover_detail  SET handover_detail_status='ยกเลิก',update_by='$name',update_at='$d' WHERE ref_handover_id ='$handover_id'";
    mysqli_query($conn, $update_handover_detail);
    echo $update_handover_detail;

    $sql_handover_detail = "SELECT tb_stock_handover_detail.handover_detail_amount as handover_detail_amount,
                            tb_stock_handover_detail.ref_grade_id as ref_grade_id,
                            tb_stock_handover_detail.ref_handover_id as ref_handover_id,
                            tb_plant.plant_id as plant_id,
                            tb_stock_handover.ref_order_detail_id as ref_order_detail_id
                        FROM tb_stock_handover_detail
                        LEFT JOIN tb_stock_handover ON tb_stock_handover.handover_id = tb_stock_handover_detail.ref_handover_id
                        LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_handover_detail.ref_grade_id
                        LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_handover_detail.ref_plant_id
                        WHERE tb_stock_handover_detail.ref_handover_id = '$handover_id'"; 

    $result_handover_detail = mysqli_query($conn, $sql_handover_detail);
    while ($row = mysqli_fetch_array($result_handover_detail)) {

        $plant_id = $row['plant_id'];
        $ref_grade_id = $row['ref_grade_id'];
        $handover_detail_amount = $row['handover_detail_amount'];
        $ref_order_detail_id = $row['ref_order_detail_id'];
        
        $sql_stock_recieve = "SELECT * FROM tb_planting_detail
        LEFT JOIN tb_stock_recieve ON tb_stock_recieve.ref_planting_detail_id = tb_planting_detail.planting_detail_id
        LEFT JOIN tb_stock_recieve_detail ON tb_stock_recieve_detail.ref_stock_recieve_id = tb_stock_recieve.stock_recieve_id
        WHERE tb_planting_detail.ref_order_detail_id = '$ref_order_detail_id' AND tb_stock_recieve_detail.ref_grade_id ='$ref_grade_id' AND tb_stock_recieve_detail.ref_plant_id ='$plant_id'";
        $result3 = mysqli_query($conn,$sql_stock_recieve);
        echo $sql_stock_recieve;
        $row3 = mysqli_fetch_assoc($result3);
        $recieve_id = $row3['stock_recieve_id'];
   
        $recieve_plant_id = $row3['ref_plant_id'];
        $recieve_grade_id = $row3['ref_grade_id'];
        $recieve_grade_amount = $row3['recieve_detail_amount'];

        $sql_stock ="SELECT tb_stock_detail.stock_detail_id as stock_detail_id,
        tb_stock_detail.stock_detail_status as stock_detail_status,
        tb_stock_detail.stock_detail_date as stock_detail_date,
        tb_stock_detail.stock_detail_amount as stock_detail_amount,
        tb_grade.grade_id as grade_id
        
        FROM tb_stock_detail
        LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_detail.ref_grade_id
        LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_detail.ref_plant_id
        WHERE tb_stock_detail.ref_plant_id = '$recieve_plant_id' AND tb_stock_detail.ref_grade_id = '$recieve_grade_id' AND tb_stock_detail.stock_detail_status ='ปกติ'
        GROUP BY tb_grade.grade_id";
        $result2 = mysqli_query($conn, $sql_stock);
        echo $sql_stock;
        $row2 = mysqli_fetch_assoc($result2);

        $stock_detail_amount = $row2['stock_detail_amount'];
        $stock_detail_id = $row2['stock_detail_id'];

        $cal_amount = $handover_detail_amount - $recieve_grade_amount;
        $cal_amounts = str_replace('-', '', $cal_amount);
        $cal_total = $cal_amounts + $stock_detail_amount;
      

        $update_stock = "UPDATE tb_stock_detail SET stock_detail_amount ='$cal_total',
                        update_by ='$name',
                        update_at ='$d'
                       WHERE stock_detail_id='$stock_detail_id'";
        mysqli_query($conn, $update_stock);
        echo $update_stock;
    }

    $sql_order_detail = "UPDATE tb_order_detail  SET order_detail_status='รอส่งมอบ',update_by='$name',update_at='$d' WHERE order_detail_id ='$ref_order_detail_id'";
    mysqli_query($conn, $sql_order_detail);
    echo $sql_order_detail;

    $sql_recieve= "UPDATE tb_stock_recieve  SET stock_recieve_status='ปกติ',update_by='$name',update_at='$d' WHERE stock_recieve_id ='$recieve_id'";
    mysqli_query($conn, $sql_recieve);
    echo $sql_recieve;

    $sql_recieve_detail = "UPDATE tb_stock_recieve_detail  SET recieve_detail_status='ปกติ',update_by='$name',update_at='$d' WHERE ref_stock_recieve_id ='$recieve_id'";
    mysqli_query($conn, $sql_recieve_detail);
    echo $sql_recieve_detail;

} else {

    $update_handover = "UPDATE tb_stock_handover  SET handover_status ='เสร็จสิ้น',update_by='$name',update_at='$d' WHERE handover_id ='$handover_id'";
    mysqli_query($conn, $update_handover);
    echo $update_handover;

    $update_handover_detail = "UPDATE tb_stock_handover  SET handover_detail_status ='เสร็จสิ้น',update_by='$name',update_at='$d' WHERE ref_handover_id ='$handover_id'";
    mysqli_query($conn, $update_handover_detail);
    echo $update_handover_detail;
}


?>