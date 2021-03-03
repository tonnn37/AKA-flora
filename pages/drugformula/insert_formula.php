<?php
require 'connect.php';
date_default_timezone_set("Asia/Bangkok");



$sql_id_detail_borrow = "SELECT max(drug_formula_detail_id) as Maxid  FROM tb_drug_formula_detail";
$result_id_bor = mysqli_query($conn, $sql_id_detail_borrow);
$row_id = mysqli_fetch_assoc($result_id_bor);
$old_id = $row_id['Maxid'];
$ids = $old_id + 1;


//--- รันรหัสยา ---//
date_default_timezone_set("Asia/Bangkok");
$sql_group = "SELECT Max(drug_formula_id) as maxid FROM tb_drug_formula";
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];
$tmp1 = "DF"; //จะได้เฉพาะตัวแรกที่เป็นตัวอักษร
$tmp2 = substr($mem_old, 5, 7);

$sub_date = substr($d, 2, 3);
$Year = substr($mem_old, 2, 2);
if ($Year != $sub_date) {
    $tmp2 = 0;
    //  $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;
$a = sprintf("%03d", $t);
$run_formula_id = $tmp1 . $sub_date . $a;


?>
<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");



$formula_name = $_POST['formula_name'];
$formula_total = $_POST['formula_total'];
$drug_id = $_POST['arr_id'];
$drug_amount = $_POST["arr_amount"];
$arr_amount_sm = $_POST["arr_amount_sm"];
$drug_price = $_POST["arr_price"];

$query = '';
for ($count = 0; $count < count($drug_id); $count++) {
    $drug_ids = mysqli_real_escape_string($conn, $drug_id[$count]);
    $drug_amounts = mysqli_real_escape_string($conn, $drug_amount[$count]);
    $drug_amount_sms = mysqli_real_escape_string($conn, $arr_amount_sm[$count]);
    $drug_prices = mysqli_real_escape_string($conn, $drug_price[$count]);

    $amount = str_replace(',','', $drug_amounts);
    $amount_sm = str_replace(',','', $drug_amount_sms);
    $price = str_replace(',','', $drug_prices);

    $query .= "INSERT INTO `tb_drug_formula_detail` (drug_formula_detail_id,ref_drug_formula,drug_formula_detail_amount,drug_formula_detail_amount_sm,drug_formula_detail_price, drug_formula_detail_status, ref_drug_id, created_by, created_at, update_by, update_at) 
                    VALUES ('$ids','$run_formula_id', '$amount','$amount_sm','$price', 'ปกติ', '$drug_ids', '$name', '$d', '$name', '$d');";
    $ids++;
}

$sql_add_borrow = "INSERT INTO tb_drug_formula(drug_formula_id,drug_formula_name,drug_formula_amount,drug_formula_status,created_by,created_at, update_by,update_at)
    VALUES ('$run_formula_id','$formula_name','$formula_total','ปกติ','$name', '$d', '$name', '$d');";
if (mysqli_query($conn, $sql_add_borrow) && mysqli_multi_query($conn, $query)) {
    echo $query;
} else {
    echo mysqli_error($conn);
}
