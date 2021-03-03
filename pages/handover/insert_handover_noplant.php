<?php
require 'connect.php';
date_default_timezone_set("Asia/Bangkok");

$sql_detail = "SELECT max(handover_noplant_detail_id) as Maxid  FROM tb_handover_noplant_detail ";
$result_detail = mysqli_query($conn, $sql_detail);
$row_id = mysqli_fetch_assoc($result_detail);
$old_id = $row_id['Maxid'];
$run_handover_noplant_detail_id = $old_id + 1;

?>
<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");

$in_handover_noplant_id = $_POST['in_handover_noplant_id'];
$ref_order_id = $_POST['in_handover_noplant_order'];
$ref_order_detail_id = $_POST['in_handover_noplant_order_detail'];
$plant_amount = $_POST['in_handover_noplant_amount'];

$amount = $_POST['amounts'];
$grade = $_POST["grade"];

$sql_plant = "SELECT tb_plant.plant_name as plant_name,
tb_plant.plant_id as plant_id

FROM tb_order_detail
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
WHERE tb_plant.plant_status = 'ปกติ' AND tb_order_detail.order_detail_id ='$ref_order_detail_id'";

$re_plant = mysqli_query($conn, $sql_plant);
$row_plant = mysqli_fetch_assoc($re_plant);
$plant_id = $row_plant['plant_id'];

echo $sql_plant;

for ($count = 0; $count < count($grade); $count++) {

    $grades = mysqli_real_escape_string($conn, $grade[$count]);
    $amounts = mysqli_real_escape_string($conn, $amount[$count]);


    $sql_stock = "SELECT * FROM tb_stock_detail WHERE ref_plant_id='$plant_id'  
    AND ref_grade_id='$grades'AND stock_detail_status='ปกติ'";
    $result_stock = mysqli_query($conn, $sql_stock);
    echo $sql_stock;

    if (mysqli_num_rows($result_stock) > 0) {

        $row_stock = mysqli_fetch_assoc($result_stock);
        $stock_detail_amount = $row_stock['stock_detail_amount'];
        $stock_detail_id = $row_stock['stock_detail_id'];

        if ($amounts <= $stock_detail_amount) {
            $total = $stock_detail_amount - $amounts;

            $update_stock = "UPDATE tb_stock_detail SET stock_detail_amount ='$total',
            update_by ='$name',
            update_at ='$d'
           WHERE stock_detail_id='$stock_detail_id'";
            mysqli_query($conn, $update_stock);
            echo $update_stock;

            $query = "INSERT INTO tb_handover_noplant_detail (handover_noplant_detail_id,handover_noplant_detail_amount,handover_noplant_detail_date,handover_noplant_detail_status,ref_plant_id,ref_grade_id,ref_handover_noplant_id,created_by, created_at, update_by, update_at) 
            VALUES ('$run_handover_noplant_detail_id','$amounts','$d','เสร็จสิ้น','$plant_id','$grades', '$in_handover_noplant_id', '$name', '$d', '$name', '$d');";
            $run_handover_noplant_detail_id++;
            mysqli_query($conn,$query);
            echo $query;
        }
    }
}
$sql_select_hand ="SELECT * FROM tb_handover_noplant_detail WHERE ref_handover_noplant_id ='$in_handover_noplant_id' AND handover_noplant_detail_status='เสร็จสิ้น'";
$result_hand = mysqli_query($conn,$sql_select_hand);
if(mysqli_num_rows($result_hand) > 0){

    $hanover = "INSERT INTO tb_handover_noplant (handover_noplant_id,handover_noplant_date,handover_noplant_status,ref_order_detail_id,created_by, created_at, update_by, update_at) 
    VALUES ('$in_handover_noplant_id','$d','เสร็จสิ้น','$ref_order_detail_id','$name', '$d', '$name', '$d');";
    mysqli_query($conn, $hanover);
    echo $hanover;

     $update_order = "UPDATE tb_order_detail SET order_detail_status ='เสร็จสิ้น',
     order_detail_planting_status = 'เสร็จสิ้น',
     update_by ='$name',
     update_at ='$d'
    WHERE order_detail_id='$ref_order_detail_id'";
     mysqli_query($conn, $update_order);
     echo $update_order;
}

