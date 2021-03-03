<?php
require 'connect.php';

$drug_formula_id = $_POST['drug_formula_id'];


if ($drug_formula_id != "") {


    $sql_count = "SELECT SUM(tb_drug_formula_detail.drug_formula_detail_price) as count FROM tb_drug_formula_detail WHERE tb_drug_formula_detail.ref_drug_formula='$drug_formula_id' AND tb_drug_formula_detail.drug_formula_detail_status ='ปกติ'   ";
    $re_count = mysqli_query($conn, $sql_count);
    $r_count = mysqli_fetch_assoc($re_count);
    $sum_price = $r_count['count'];

    $sum_price = round($sum_price);
    $sum_price =  number_format($sum_price, 2);

    if ($sum_price == "") {
        $sum_price = 0;
    }
            
            echo $sum_price;
    

} else {
    echo "0";
}
