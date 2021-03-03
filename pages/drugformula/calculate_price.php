<?php
// Include the database config file
require('connect.php');
$id_amount = $_POST['id_drugamount'];
$id_drug = $_POST['id_drug'];


if ($id_amount != "") {
    // Fetch state data based on the specific country
    $query = "SELECT tb_drug.drug_id AS drug_id , tb_drug.drug_amount AS drug_amount, tb_drug.drug_price As drug_price, tb_drug.drug_status AS drug_status
            FROM tb_drug
            LEFT JOIN tb_drug_formula_detail ON tb_drug_formula_detail.ref_drug_id= tb_drug.drug_id
            WHERE tb_drug.drug_status ='ปกติ' AND  tb_drug.drug_id = '$id_drug' ";

    $result = $conn->query($query);


    // Generate HTML of state options list
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $amount = $row['drug_amount']; //3 ลิตร
        $price = $row['drug_price']; // 300 บาท
        $cal_amount = $amount * 1000; // 3ลิตร * 1000 = 3000มิลลิลิตร
        $formula = $price / $cal_amount; // 300 บาท / 3000มิลลิลิตร = 0.1 บาท/มิลลิลิตร

        $cal_useamount = $id_amount * $amount; // ใช้2 ขวด 2 ขวด * 3 ลิตร = 6 ลิตร
        $cal_useamount_sm = $cal_useamount * 1000; // 6 ลิตร * 1000 = 6000 มิลลิลิตร

        $total = $cal_useamount_sm * $formula; // 6000 มิลลิลิตร * 0.1 บาท/มิลลิลิตร = 600 บาท !!
        $total = round($total);
        $total = number_format($total, 2);

        echo $total;
    } else {
        echo "ไม่พบราคา";
    }
} else {
    echo "ไม่พบราคา";
}
