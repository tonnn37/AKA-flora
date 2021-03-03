<?php
require 'connect.php';

$material_id = $_POST['material_id'];
$amount_material = $_POST['amount_material'];




if ($amount_material != "") {

    $sql_price = "SELECT *  FROM tb_material WHERE tb_material.material_id='$material_id' AND tb_material.material_status ='ปกติ' ";
    $re_price = mysqli_query($conn, $sql_price);
    $r_price = mysqli_fetch_assoc($re_price);


    $sum_price = $r_price['material_price'];

    $sum_amount = $r_price['material_amount'];

    $cal_amount = $sum_amount * 1000 ;
    $peramount = $sum_price / $cal_amount; // 0.03125
    $peramount = number_format($peramount,10);

    $cal_use_amount = $amount_material * $sum_amount ; // 8
    $cal_use_amount_sm = $cal_use_amount * 1000; // 8000
    $sumtotal = $cal_use_amount_sm * $peramount; // 8000 * 0.03125

  
/*     $sumtotal = round($sumtotal,1); */
    
    echo number_format($sumtotal,2);

} else if ($amount_material == "0") {
    echo "0";
} else {
    echo "0";
}
