<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

?>
<?php
$payment_id = $_POST['payment_id'];
$payment_status = $_POST['payment_status'];
$d = date("Y-m-d");

if ($payment_status == 'เสร็จสิ้น') {
    $update_payment = "UPDATE tb_payment  SET payment_status='ยกเลิก',update_by='$name',update_at='$d' WHERE payment_id ='$payment_id'";
    mysqli_query($conn, $update_payment);
    echo $update_payment;

    $update_payment_detail = "UPDATE tb_payment_detail  SET payment_detail_status='ยกเลิก',update_by='$name',update_at='$d' WHERE ref_payment_id ='$payment_id'";
    mysqli_query($conn, $update_payment_detail);
    echo $update_payment_detail;

    $sql_payment_detail = "SELECT tb_payment_detail.payment_detail_amount as payment_detail_amount,
                            tb_payment_detail.ref_grade_id as ref_grade_id,
                            tb_payment_detail.ref_plant_id as ref_plant_id
                        FROM tb_payment_detail
                        INNER JOIN tb_grade ON tb_grade.grade_id = tb_payment_detail.ref_grade_id
                        INNER JOIN tb_plant ON tb_plant.plant_id = tb_payment_detail.ref_plant_id
                        INNER JOIN tb_payment ON tb_payment.payment_id = tb_payment_detail.ref_payment_id
                        WHERE tb_payment_detail.ref_payment_id = '$payment_id' ";

    $result_payment_detail = mysqli_query($conn, $sql_payment_detail);
    while ($row = mysqli_fetch_array($result_payment_detail)) {

        $plant_id = $row['ref_plant_id'];
        $ref_grade_id = $row['ref_grade_id'];
        $payment_detail_amount = $row['payment_detail_amount'];

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
        $total = $payment_detail_amount + $stock_detail_amount;

        $update_stock = "UPDATE tb_stock_detail SET stock_detail_amount ='$total',
                        update_by ='$name',
                        update_at ='$d'
                       WHERE stock_detail_id='$stock_detail_id'";
        mysqli_query($conn, $update_stock);
        echo $update_stock;
    }
} else {
    $update_payment = "UPDATE tb_payment  SET payment_status='เสร็จสิ้น',update_by='$name',update_at='$d' WHERE payment_id ='$payment_id'";
    mysqli_query($conn, $update_payment);
    echo $update_payment;

    $update_payment_detail = "UPDATE tb_payment_detail  SET payment_detail_status='เสร็จสิ้น',update_by='$name',update_at='$d' WHERE ref_payment_id ='$payment_id'";
    mysqli_query($conn, $update_payment_detail);
    echo $update_payment_detail;
}


?>