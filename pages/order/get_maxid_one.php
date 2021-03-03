<?php
require 'connect.php';
//--- รันรหัสยา ---//
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$m = date('m', $datenow);

$sql_group = "SELECT Max(order_id) as maxid FROM tb_order";
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];

$tmp1 = "OR";
$minus ="-";
$tmp2 = substr($mem_old, 8, 3);
$Year = substr($mem_old, 2, 2);
$Month = substr($mem_old, 5, 2);
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
$run_order_id = $tmp1 . $sub_date .$minus. $m .$minus. $a;

echo $run_order_id;