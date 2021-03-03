<?php
require 'connect.php';

$drug_formula_id = $_POST['drug_formula_id'];
$amount_drug_formula = $_POST['amount_drug_formula'];

if ($drug_formula_id != "") {
    if ($amount_drug_formula != "") {

        $sql_count = "SELECT SUM(tb_drug_formula_detail.drug_formula_detail_price) as count FROM tb_drug_formula_detail WHERE tb_drug_formula_detail.ref_drug_formula='$drug_formula_id' AND tb_drug_formula_detail.drug_formula_detail_status ='ปกติ' ";
        $re_count = mysqli_query($conn, $sql_count);
        $r_count = mysqli_fetch_assoc($re_count);
        $sum_price = $r_count['count'];

        $sum_price = intval($sum_price);


        $sql_quality = "SELECT SUM(tb_drug_formula_detail.drug_formula_detail_amount_sm) as count FROM tb_drug_formula_detail WHERE tb_drug_formula_detail.ref_drug_formula='$drug_formula_id' AND tb_drug_formula_detail.drug_formula_detail_status ='ปกติ' ";
        $re_quality = mysqli_query($conn, $sql_quality);
        $r_quality = mysqli_fetch_assoc($re_quality);
        $quality = $r_quality['count'];
        $quality = $quality * 1000;
        $sum_quality = intval($quality);

        $peramount = $sum_price / $sum_quality;
       
        $cal_per_price = $amount_drug_formula * 1000;

        $sumtotal = $cal_per_price * $peramount;


        $sumtotal = round($sumtotal, 1);

            
            echo number_format($sumtotal,2);
    
    } else {
        echo "0";
    }
} else {
    echo "0";
}
