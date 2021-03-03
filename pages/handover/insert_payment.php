<?php
//Run id
require 'connect.php';
date_default_timezone_set("Asia/Bangkok");

$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$m = date('m', $datenow);

$sql_payment = "SELECT max(payment_id) as Maxid  FROM tb_payment";
$result = mysqli_query($conn, $sql_payment);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['Maxid'];

$tmp1 = "PAY";
$minus = "-";
$tmp2 = substr($mem_old, 9, 3);
$Year = substr($mem_old, 3, 2);
$Month = substr($mem_old, 6, 2);
$sub_date = substr($d, 2, 2);

if ($Year != $sub_date) {
    $tmp2 = 0;
    //  $sub_date=$sub_date+1;
} else {
    $tmp2;
}

if ($Month != $m) {
    $tmp2 = 0;
    //  $sub_date=$sub_date+1;
} else {
    $tmp2;
}
$t = $tmp2 + 1;
$a = sprintf("%03d", $t);
$id_pay = $tmp1 . $sub_date . $minus . $m . $minus . $a;

?>
<?php

$d = date("Y-m-d");
$total = $_POST["total"];
$id = $_POST["id"];
$sale_money = $_POST["sale_money"];
$amount = $_POST["amount"];
$grade = $_POST["grade"];

$sec = date("Y-m-d H:i:s");

@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$sale_money = str_replace('-', '', $sale_money);

$query = '';
for ($count = 0; $count < count($id); $count++) {
    $ids = mysqli_real_escape_string($conn, $id[$count]);
    $totals = mysqli_real_escape_string($conn, $total[$count]);
    $amounts = mysqli_real_escape_string($conn, $amount[$count]);
    $grades = mysqli_real_escape_string($conn, $grade[$count]);

    $query .= 'INSERT INTO tb_payment_detail(payment_detail_amount,payment_detail_total,payment_detail_status,ref_plant_id,ref_payment_id,created_by,created_at,update_by,update_at,ref_grade_id)
                   VALUES("' . $amounts . '","' . $totals . '", "เสร็จสิ้น","' . $ids . '","' . $id_pay . '","' . $name . '","' . $d . '","' . $name . '","' . $d . '","'.$grades.'");';

    //-----------------------------เรียกค่า stock
    $sql_stock = "SELECT * FROM tb_stock_detail WHERE ref_plant_id='$ids' AND stock_detail_status='ปกติ' AND ref_grade_id='$grades'";
    $result_stock = mysqli_query($conn, $sql_stock);
    $row_stock = mysqli_fetch_assoc($result_stock);
    $amount_stock = $row_stock['stock_detail_amount'];
    $id_stock = $row_stock['stock_detail_id'];
    //------------------------------------------------
    //----------------------ตัดสต็อก
    $total_stock = $amount_stock - $amounts;
    $sql_update_stock = "UPDATE tb_stock_detail  SET stock_detail_amount='$total_stock' ,update_by='$name',update_at='$d' WHERE stock_detail_id  ='$id_stock'";
    mysqli_query($conn, $sql_update_stock);

}
$sql_add_borrow = 'INSERT INTO tb_payment(payment_id,payment_date,payment_recieve,payment_status,created_by,created_at,update_by,update_at)
   VALUES("' . $id_pay . '","'.$sec.'","'.$sale_money.'","เสร็จสิ้น","' . $name . '","' . $d . '","' . $name . '","' . $d . '");';
if (mysqli_query($conn, $sql_add_borrow) && mysqli_multi_query($conn, $query)) {
    echo $sql_add_borrow;
    echo $query;
  
} else {
    echo "error";
}
