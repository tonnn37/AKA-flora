<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

$d = date("Y-m-d");
?>

<?php
$id = $_POST['id'];
$edit_order_plant_detail = $_POST['edit_order_plant_detail'];
$edit_order_amount_detail = $_POST['edit_order_amount_detail'];
$edit_order_end_detail = $_POST['edit_order_end_detail'];
$edit_order_amount_total_detail = $_POST['edit_order_amount_total_detail'];

$amount = str_replace(',', '', $edit_order_amount_detail);
$amount = intval($amount);
$total = intval($edit_order_amount_total_detail);

$sumper = $total - $amount;

$sql_order_detail = "UPDATE tb_order_detail  SET order_detail_amount='$amount',
                                                order_detail_per ='$sumper',
                                                order_detail_total = '$total',
                                                order_detail_enddate ='$edit_order_end_detail' ,
                                                ref_plant_id ='$edit_order_plant_detail', 
                                                update_by ='$name',
                                                update_at ='$d' 
                                                WHERE order_detail_id  ='$id'";



$sql_planting_detail_edit = "UPDATE tb_planting_detail SET planting_detail_amount ='$amount',
                                                            planting_detail_per ='$sumper',
                                                            planting_detail_total ='$total',
                                                            planting_detail_enddate='$edit_order_end_detail' , 
                                                            ref_plant_id ='$edit_order_plant_detail' 
                                                            WHERE ref_order_detail_id ='$id'";



if (mysqli_query($conn, $sql_order_detail) && mysqli_query($conn, $sql_planting_detail_edit)) {
    echo $sql_order_detail;
} else {
    echo mysqli_error($conn);
}
