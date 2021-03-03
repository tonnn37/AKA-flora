<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

?>
<?php
$handover_id = $_POST['id'];
$handover_status = $_POST['status'];
$d = date("Y-m-d");

if ($handover_status == 'เสร็จสิ้น') {
    $update_handover = "UPDATE tb_handover_noplant  SET handover_noplant_status='ยกเลิก',update_by='$name',update_at='$d' WHERE handover_noplant_id ='$handover_id'";
    mysqli_query($conn, $update_handover);
    echo $update_handover;

    $update_handover_detail = "UPDATE tb_handover_noplant_detail  SET handover_noplant_detail_status='ยกเลิก',update_by='$name',update_at='$d' WHERE ref_handover_noplant_id ='$handover_id'";
    mysqli_query($conn, $update_handover_detail);
    echo $update_handover_detail;

    $sql_handover_detail = "SELECT tb_handover_noplant_detail.handover_noplant_detail_amount as handover_noplant_detail_amount,
                            tb_handover_noplant_detail.ref_grade_id as ref_grade_id,
                            tb_handover_noplant_detail.ref_handover_noplant_id as ref_handover_noplant_id,
                            tb_plant.plant_id as plant_id,
                            tb_handover_noplant.ref_order_detail_id as ref_order_detail_id
                        FROM tb_handover_noplant_detail
                        LEFT JOIN tb_handover_noplant ON tb_handover_noplant.handover_noplant_id = tb_handover_noplant_detail.ref_handover_noplant_id
                        LEFT JOIN tb_grade ON tb_grade.grade_id = tb_handover_noplant_detail.ref_grade_id
                        LEFT JOIN tb_plant ON tb_plant.plant_id = tb_handover_noplant_detail.ref_plant_id
                        WHERE tb_handover_noplant_detail.ref_handover_noplant_id = '$handover_id'";

    $result_handover_detail = mysqli_query($conn, $sql_handover_detail);
    while ($row = mysqli_fetch_array($result_handover_detail)) {

        $plant_id = $row['plant_id'];
        $ref_grade_id = $row['ref_grade_id'];
        $handover_detail_amount = $row['handover_noplant_detail_amount'];
        $ref_order_detail_id = $row['ref_order_detail_id'];

        $sql_stock = "SELECT tb_stock_detail.stock_detail_id as stock_detail_id,
        tb_stock_detail.stock_detail_status as stock_detail_status,
        tb_stock_detail.stock_detail_date as stock_detail_date,
        tb_stock_detail.stock_detail_amount as stock_detail_amount,
        tb_grade.grade_id as grade_id
        
        FROM tb_stock_detail
        LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_detail.ref_grade_id
        LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_detail.ref_plant_id
        WHERE tb_stock_detail.ref_plant_id = '$plant_id' AND tb_stock_detail.ref_grade_id = '$ref_grade_id' AND tb_stock_detail.stock_detail_status ='ปกติ'
        GROUP BY tb_grade.grade_id";
        $result2 = mysqli_query($conn, $sql_stock);
        $row2 = mysqli_fetch_assoc($result2);

        $stock_detail_amount = $row2['stock_detail_amount'];
        $stock_detail_id = $row2['stock_detail_id'];
        $total = $handover_detail_amount + $stock_detail_amount;

        $update_stock = "UPDATE tb_stock_detail SET stock_detail_amount ='$total',
                        update_by ='$name',
                        update_at ='$d'
                       WHERE stock_detail_id='$stock_detail_id'";
        mysqli_query($conn, $update_stock);
        echo $update_stock;
    }
    $sql_order1 = "SELECT * FROM tb_order_detail
    LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
        WHERE tb_order_detail.order_detail_id = '$ref_order_detail_id'";
    $result3 = mysqli_query($conn, $sql_order1);
    $row3 = mysqli_fetch_assoc($result3);

    $order_id = $row3['order_id'];

    $sql_order = "UPDATE tb_order  SET order_status='ปกติ',update_by='$name',update_at='$d' WHERE order_id ='$order_id'";
    mysqli_query($conn, $sql_order);
    echo $sql_order;

    $sql_order_detail = "UPDATE tb_order_detail  SET order_detail_status='รอส่งมอบ',order_detail_planting_status ='ยังไม่ได้ทำการปลูก',update_by='$name',update_at='$d' WHERE order_detail_id ='$ref_order_detail_id'";
    mysqli_query($conn, $sql_order_detail);
    echo $sql_order_detail;
} else {
    $update_handover = "UPDATE tb_handover_noplant  SET handover_noplant_status='เสร็จสิ้น',update_by='$name',update_at='$d' WHERE handover_noplant_id ='$handover_id'";
    mysqli_query($conn, $update_handover);
    echo $update_handover;

    $update_handover_detail = "UPDATE tb_handover_noplant_detail  SET handover_noplant_detail_status='เสร็จสิ้น',update_by='$name',update_at='$d' WHERE ref_handover_noplant_id ='$handover_id'";
    mysqli_query($conn, $update_handover_detail);
    echo $update_handover_detail;
}
?>