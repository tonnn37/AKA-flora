<?php
require 'connect.php';
date_default_timezone_set("Asia/Bangkok");

//--- รันรหัสยา ---//
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$m = date('m', $datenow);

$sql_group = "SELECT Max(order_id) as maxid FROM tb_order";
$result = mysqli_query($conn, $sql_group);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];

$tmp1 = "OR";
$minus = "-";
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
$run_order_id = $tmp1 . $sub_date . $minus . $m . $minus . $a;


?>
<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");

$in_id_order = $_POST['in_id_order'];
$in_order_name = $_POST['in_order_name'];
$in_order_cutomer = $_POST['in_order_cutomer'];
$in_order_price = $_POST['in_order_price'];
$price = str_replace(',','', $in_order_price);

$in_order_plant = $_POST['in_order_plant'];

$in_order_amount = $_POST["in_order_amount"];
$in_order_amountfor = $_POST["in_order_amountfor"];
$in_order_amounttotal = $_POST["in_order_amounttotal"];

$in_order_end = $_POST["in_order_end"];
$in_order_detail = $_POST["in_order_detail"];




$query = '';
for ($count = 0; $count < count($in_id_order); $count++) {

    $in_id_orders = mysqli_real_escape_string($conn, $in_id_order[$count]);
    $in_order_plants = mysqli_real_escape_string($conn, $in_order_plant[$count]);
    $in_order_amounts = mysqli_real_escape_string($conn, $in_order_amount[$count]);
    $in_order_amountfors = mysqli_real_escape_string($conn, $in_order_amountfor[$count]);
    $in_order_amounttotals = mysqli_real_escape_string($conn, $in_order_amounttotal[$count]);
    $in_order_ends = mysqli_real_escape_string($conn, $in_order_end[$count]);

    $in_amount = str_replace(',','', $in_order_amounts);
    $in_amountfor = str_replace(',','', $in_order_amountfors);
    $in_amounttotal = str_replace(',','', $in_order_amounttotals);
   
    $query .= "INSERT INTO `tb_order_detail` (order_detail_id,order_detail_amount,order_detail_per,order_detail_total,order_detail_enddate,order_detail_planting_status,order_detail_status,ref_plant_id, ref_order_id, created_by, created_at, update_by, update_at) 
                    VALUES ('$in_id_orders','$in_amount','$in_amountfor','$in_amounttotal','$in_order_ends','ยังไม่ได้ทำการปลูก','ปกติ','$in_order_plants', '$run_order_id', '$name', '$d', '$name', '$d');";
}

$sql_add_order = "INSERT INTO tb_order(order_id,order_name,order_customer,order_price,order_detail,order_date,order_status,created_by,created_at, update_by,update_at)
    VALUES ('$run_order_id','$in_order_name','$in_order_cutomer','$price','$in_order_detail','$d','ปกติ','$name', '$d', '$name', '$d');";
if (mysqli_query($conn, $sql_add_order) && mysqli_multi_query($conn, $query)) {
    echo $query && $sql_add_order;
} else {
    echo mysqli_error($conn);
}
