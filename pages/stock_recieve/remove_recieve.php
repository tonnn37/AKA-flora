<?php

require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$recieve_id = $_POST['recieve_id'];
$recieve_status = $_POST['recieve_status'];
echo $recieve_status;
$d = date("Y-m-d");

$sql_recieve_details = "SELECT * FROM `tb_stock_recieve` 
    WHERE stock_recieve_id = '$recieve_id'
    ORDER BY `stock_recieve_id` ASC";
$result2 = mysqli_query($conn, $sql_recieve_details);
$row2 = mysqli_fetch_assoc($result2);
$ref_planting_detail_id = $row2['ref_planting_detail_id'];

if ($recieve_status == 'ปกติ') {
    $sql_recieve = "UPDATE tb_stock_recieve  SET stock_recieve_status='ยกเลิก',update_by='$name',update_at='$d' WHERE stock_recieve_id ='$recieve_id'";
    mysqli_query($conn, $sql_recieve);
    echo $sql_recieve;

    $sql_recieve_detail = "UPDATE tb_stock_recieve_detail  SET recieve_detail_status='ยกเลิก',update_by='$name',update_at='$d' WHERE ref_stock_recieve_id ='$recieve_id'";
    mysqli_query($conn, $sql_recieve_detail);
    echo $sql_recieve_detail;



    $sql_planting_detail = "UPDATE tb_planting_detail  SET planting_detail_status='รอคัดเกรด',update_by='$name',update_at='$d' WHERE planting_detail_id ='$ref_planting_detail_id'";
    mysqli_query($conn, $sql_planting_detail);
    echo $sql_planting_detail;

    $sql_update_order_detail = "UPDATE tb_order_detail
                                INNER JOIN tb_planting_detail
                                ON (tb_order_detail.order_detail_id = tb_planting_detail.ref_order_detail_id)
                                SET tb_order_detail.order_detail_status = 'รอคัดเกรด',
                                    tb_order_detail.update_by='$name',
                                    tb_order_detail.update_at='$d'
                                WHERE tb_planting_detail.planting_detail_id='$ref_planting_detail_id'";
    mysqli_query($conn, $sql_update_order_detail);
    echo $sql_planting_detail;

    $sql_update_order_detail2 = "UPDATE tb_order_detail
                            INNER JOIN tb_planting_detail
                            ON (tb_order_detail.order_detail_id = tb_planting_detail.ref_order_detail_id)
                            SET tb_order_detail.order_detail_planting_status = 'กำลังทำการปลูก',
                                tb_order_detail.update_by='$name',
                                tb_order_detail.update_at='$d'
                            WHERE tb_planting_detail.planting_detail_id='$ref_planting_detail_id'";

    mysqli_query($conn, $sql_update_order_detail2);
    echo $sql_update_order_detail2;

    /* $sql_recieve_detail = "SELECT tb_stock_recieve_detail.recieve_detail_amount as recieve_detail_amount,
                                tb_stock_recieve_detail.ref_grade_id as ref_grade_id,
                                tb_stock_recieve_detail.ref_plant_id as ref_plant_id,
                                tb_stock_recieve.ref_planting_detail_id as ref_planting_detail_id
                FROM tb_stock_recieve_detail
                LEFT JOIN tb_stock_recieve ON tb_stock_recieve.stock_recieve_id = tb_stock_recieve_detail.ref_stock_recieve_id
                LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_recieve_detail.ref_grade_id
                LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_recieve_detail.ref_plant_id
                WHERE tb_stock_recieve_detail.ref_stock_recieve_id = '$recieve_id'";

    $result_recieve_detail = mysqli_query($conn, $sql_recieve_detail);
    while ($row = mysqli_fetch_array($result_recieve_detail)) {

        $ref_plant_id = $row['ref_plant_id'];
        $ref_grade_id = $row['ref_grade_id'];
        $recieve_detail_amount = $row['recieve_detail_amount'];
        $ref_planting_detail_id = $row['ref_planting_detail_id'];

        $sql_stock ="SELECT tb_stock_detail.stock_detail_id as stock_detail_id,
        tb_stock_detail.stock_detail_status as stock_detail_status,
        tb_stock_detail.stock_detail_date as stock_detail_date,
        tb_stock_detail.stock_detail_amount as stock_detail_amount,
        tb_grade.grade_id as grade_id,
        tb_grade.grade_name as grade_name,
        tb_plant.plant_name as plant_name
        
        FROM tb_stock_detail
        LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_detail.ref_grade_id
        LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_detail.ref_plant_id
        WHERE tb_stock_detail.ref_plant_id = '$ref_plant_id' AND tb_stock_detail.ref_grade_id = '$ref_grade_id' AND tb_stock_detail.stock_detail_status ='ปกติ'
        GROUP BY tb_grade.grade_id";
        $result2 = mysqli_query($conn, $sql_stock);
        $row2 = mysqli_fetch_assoc($result2);
        $stock_detail_amount = $row2['stock_detail_amount'];
        $stock_detail_id = $row2['stock_detail_id'];
        $total = $recieve_detail_amount - $stock_detail_amount;

        $update_stock = "UPDATE tb_stock_detail SET stock_detail_amount ='$total',
                        stock_detail_status ='ยกเลิก',
                        update_by ='$name',
                        update_at ='$d'
                       WHERE stock_detail_id='$stock_detail_id'";
        mysqli_query($conn, $update_stock);
        echo $update_stock;
    }
 */
} else {
    $sql_recieve = "UPDATE tb_stock_recieve  SET stock_recieve_status='ปกติ',update_by='$name',update_at='$d' WHERE stock_recieve_id ='$recieve_id'";
    mysqli_query($conn, $sql_recieve);
    echo $sql_recieve;
    $sql_recieve_detail = "UPDATE tb_stock_recieve_detail  SET recieve_detail_status='ปกติ',update_by='$name',update_at='$d' WHERE ref_stock_recieve_id ='$recieve_id'";
    mysqli_query($conn, $sql_recieve_detail);
    echo $sql_recieve_detail;

    $sql_update_order_detail = "UPDATE tb_order_detail
    INNER JOIN tb_planting_detail
    ON (tb_order_detail.order_detail_id = tb_planting_detail.ref_order_detail_id)
    SET tb_order_detail.order_detail_status = 'รอส่งมอบ',
        tb_order_detail.update_by='$name',
        tb_order_detail.update_at='$d'
    WHERE tb_planting_detail.planting_detail_id='$ref_planting_detail_id'";
    mysqli_query($conn, $sql_update_order_detail);
    echo $sql_planting_detail;

    $sql_update_order_detail2 = "UPDATE tb_order_detail
INNER JOIN tb_planting_detail
ON (tb_order_detail.order_detail_id = tb_planting_detail.ref_order_detail_id)
SET tb_order_detail.order_detail_planting_status = 'เสร็จสิ้น',
    tb_order_detail.update_by='$name',
    tb_order_detail.update_at='$d'
WHERE tb_planting_detail.planting_detail_id='$ref_planting_detail_id'";

    mysqli_query($conn, $sql_update_order_detail2);
    echo $sql_planting_detail2;
}


?>