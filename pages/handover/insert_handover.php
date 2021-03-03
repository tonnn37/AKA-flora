<?php
require 'connect.php';
date_default_timezone_set("Asia/Bangkok");

$sql_detail = "SELECT max(handover_detail_id) as Maxid  FROM tb_stock_handover_detail ";
$result_detail = mysqli_query($conn, $sql_detail);
$row_id = mysqli_fetch_assoc($result_detail);
$old_id = $row_id['Maxid'];
$run_handover_detail_id = $old_id + 1;

$sql_week = "SELECT max(stock_detail_id) as Maxid  FROM tb_stock_detail";
$result_week = mysqli_query($conn, $sql_week);
$row_id = mysqli_fetch_assoc($result_week);
$old_id = $row_id['Maxid'];
$id_stock_detail = $old_id + 1;
?>
<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");

$in_handover_id = $_POST['in_handover_id'];
$ref_order_id = $_POST['in_handover_order'];
$ref_order_detail_id = $_POST['in_handover_order_detail'];
$plant_amount = $_POST['in_handover_planting_amount'];

$grade = $_POST["grade"];
$amount = $_POST['amounts'];
$stock_amount = $_POST["show_stock_amounts"];
$cull_amount = $_POST["cull_grade_amounts"];


$arr_cull_grade_name = $_POST["arr_cull_grade_names"];
$arr_cull_grade = $_POST["arr_cull_grades"];
$array_stock_amount = $_POST["array_stock_amounts"];
$use_grade_amount = $_POST["use_grade_amounts"];

$sql_planting = "SELECT * FROM tb_planting_detail
LEFT JOIN tb_order_detail ON tb_planting_detail.ref_order_detail_id = tb_order_detail.order_detail_id
WHERE tb_order_detail.order_detail_status = 'รอส่งมอบ' AND tb_order_detail.order_detail_id = '$ref_order_detail_id' AND tb_planting_detail.planting_detail_status = 'เสร็จสิ้น'";

$re_planting = mysqli_query($conn, $sql_planting);
$row_planting = mysqli_fetch_assoc($re_planting);
$planting_detail_id = $row_planting['planting_detail_id'];
echo $sql_planting;


$update_recieve = "UPDATE tb_stock_recieve SET stock_recieve_status ='เสร็จสิ้น',
update_by ='$name',
update_at ='$d'
WHERE tb_stock_recieve.ref_planting_detail_id='$planting_detail_id'";
mysqli_query($conn, $update_recieve);
echo $update_recieve;

$sql_recieve = "SELECT * FROM tb_stock_recieve 
WHERE ref_planting_detail_id = '$planting_detail_id'";
$result4 =  mysqli_query($conn, $sql_recieve);
$row4 = mysqli_fetch_assoc($result4);
$stock_recieve_id = $row4['stock_recieve_id'];


$update_recieve_detail = "UPDATE tb_stock_recieve_detail SET recieve_detail_status ='เสร็จสิ้น',
update_by ='$name',
update_at ='$d'
WHERE tb_stock_recieve_detail.ref_stock_recieve_id='$stock_recieve_id'";
mysqli_query($conn, $update_recieve_detail);
echo $update_recieve_detail;

//--- เรียกพันธุ์ไม้ ---//
$sql_plant = "SELECT tb_plant.plant_name as plant_name,
tb_plant.plant_id as plant_id

FROM tb_order_detail
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
WHERE tb_plant.plant_status = 'ปกติ' AND tb_order_detail.order_detail_id ='$ref_order_detail_id'";

$re_plant = mysqli_query($conn, $sql_plant);
$row_plant = mysqli_fetch_assoc($re_plant);
$plant_id = $row_plant['plant_id'];
echo $sql_plant;



for ($count = 0; $count < count($arr_cull_grade); $count++) {

    $arr_cull_grade_ids = mysqli_real_escape_string($conn, $arr_cull_grade_name[$count]);
    $arr_cull_grades = mysqli_real_escape_string($conn, $arr_cull_grade[$count]);
    $array_stock_amounts = mysqli_real_escape_string($conn, $array_stock_amount[$count]);
    $use_grade_amounts = mysqli_real_escape_string($conn, $use_grade_amount[$count]);

    $sql_stock = "SELECT * FROM tb_stock_detail WHERE ref_plant_id='$plant_id'  
    AND ref_grade_id='$arr_cull_grade_ids'AND stock_detail_status='ปกติ'";
    $result_stock = mysqli_query($conn, $sql_stock);
    echo $sql_stock;

    if (mysqli_num_rows($result_stock) > 0) {
        $row_stock = mysqli_fetch_assoc($result_stock);

        $stock_detail_amount = $row_stock['stock_detail_amount'];
        $stock_detail_id = $row_stock['stock_detail_id'];

        $cal_sum_amount = $array_stock_amounts + $arr_cull_grades;

        $cal_total_amount = $cal_sum_amount - $use_grade_amounts;
        /* if ($amounts <= $stock_detail_amount) { */
        /* $total = $stock_detail_amount - $amounts; */

        $update_stock = "UPDATE tb_stock_detail SET stock_detail_amount ='$cal_total_amount',
            update_by ='$name',
            update_at ='$d'
           WHERE stock_detail_id='$stock_detail_id'";
        mysqli_query($conn, $update_stock);
        echo $update_stock;

        /*  } */
    } else {
        $query2 = "INSERT INTO tb_stock_detail (stock_detail_id,stock_detail_amount,stock_detail_date,stock_detail_status,ref_plant_id,ref_grade_id,created_by, created_at, update_by, update_at) 
        VALUES ('$id_stock_detail','$arr_cull_grades','$d','ปกติ','$plant_id','$arr_cull_grade_ids','$name', '$d', '$name', '$d');";
        mysqli_query($conn, $query2);
        $id_stock_detail++;
    }
}

for ($count2 = 0; $count2 < count($grade); $count2++) {

    $grades = mysqli_real_escape_string($conn, $grade[$count2]);
    $amounts = mysqli_real_escape_string($conn, $amount[$count2]);
    /* $stock_amounts = mysqli_real_escape_string($conn, $stock_amount[$count2]);
    $cull_amounts = mysqli_real_escape_string($conn, $cull_amount[$count2]);
 */
    $query = "INSERT INTO tb_stock_handover_detail (handover_detail_id,handover_detail_amount,handover_detail_date,handover_detail_status,ref_plant_id,ref_grade_id,ref_handover_id,created_by, created_at, update_by, update_at) 
    VALUES ('$run_handover_detail_id','$amounts','$d','เสร็จสิ้น','$plant_id','$grades', '$in_handover_id', '$name', '$d', '$name', '$d');";
    $run_handover_detail_id++;
    mysqli_query($conn, $query);
    echo $query;
}

$sql_select_hand = "SELECT * FROM tb_stock_handover_detail WHERE ref_handover_id ='$in_handover_id' AND handover_detail_status='เสร็จสิ้น'";
$result_hand = mysqli_query($conn, $sql_select_hand);
if (mysqli_num_rows($result_hand) > 0) {

    $hanover = "INSERT INTO tb_stock_handover (handover_id,handover_date,handover_status,ref_order_detail_id,created_by, created_at, update_by, update_at) 
    VALUES ('$in_handover_id','$d','เสร็จสิ้น','$ref_order_detail_id','$name', '$d', '$name', '$d');";
    mysqli_query($conn, $hanover);
    echo $hanover;
}

$update_order = "UPDATE tb_order_detail SET order_detail_status ='เสร็จสิ้น',
update_by ='$name',
update_at ='$d'
WHERE order_detail_id='$ref_order_detail_id'";
mysqli_query($conn, $update_order);
echo $update_order;
