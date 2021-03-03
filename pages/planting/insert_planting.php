<?php
//Run id
require('connect.php');

date_default_timezone_set("Asia/Bangkok");
$datenow = strtotime(date("Y-m-d"));
$d = date('Y', $datenow) + 543;
$m = date('m', $datenow);

$sql_planting = "SELECT Max(planting_id) as maxid FROM tb_planting";
$result = mysqli_query($conn, $sql_planting);
$row_mem = mysqli_fetch_assoc($result);
$mem_old = $row_mem['maxid'];

$tmp1 = "PLT";
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
$planting_id = $tmp1 . $sub_date . $minus . $m . $minus . $a;
?>

<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");

$in_planting_id = $_POST['in_planting_id'];
$ref_order_id = $_POST['ref_order_id'];
$check = $_POST['check'];

$sql_planting = "INSERT INTO tb_planting(planting_id,planting_date,planting_status,ref_order_id,created_by,created_at,update_by,update_at)
            VALUES('$planting_id','$d','ปกติ','$ref_order_id','$name','$d','$name','$d')";

$sql ='';
$i = 0;
for ($count = 0; $count < count($check); $count++) {

    $checks = mysqli_real_escape_string($conn, $check[$count]);

    $sql_planting_detail = "SELECT * FROM tb_order_detail 
                        INNER JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
                         WHERE order_detail_id = '$checks' AND order_detail_status ='ปกติ'";

    $result = mysqli_query($conn, $sql_planting_detail);
    if ($result->num_rows > 0) {
        
        while ($row = $result->fetch_assoc()) {

            $plant_id = $row['ref_plant_id'];
            $order_detail_amount = $row['order_detail_amount'];
            $order_detail_per = $row['order_detail_per'];
            $order_detail_total = $row['order_detail_total'];
            $order_detail_enddate = $row['order_detail_enddate'];
            $order_detail_status = $row['order_detail_status'];
            $order_detail_id = $row['order_detail_id'];
            $ref_order_id = $row['ref_order_id'];

            $i++;
            $a = sprintf("%02d", $i);
            $total = $planting_id . "-" . $a;

            $sql = "INSERT INTO tb_planting_detail(planting_detail_id,ref_plant_id,planting_detail_amount,planting_detail_per,planting_detail_total,planting_detail_enddate,planting_detail_status,ref_planting_id,created_by,created_at,update_by,update_at,ref_order_detail_id) 
                VALUES('$total','$plant_id','$order_detail_amount','$order_detail_per','$order_detail_total','$order_detail_enddate','ปกติ','$planting_id','$name','$d','$name','$d','$order_detail_id')";

            mysqli_query($conn, $sql);
            echo $sql;
            $sql_order = "UPDATE tb_order_detail SET order_detail_planting_status ='กำลังทำการปลูก' , update_by = '$name' , update_at ='$d' WHERE order_detail_id='$checks'";
            mysqli_query($conn, $sql_order);

            
        }
    }
}


if (mysqli_query($conn, $sql_planting)) {
 
  echo $sql;
}
echo mysqli_error($conn);
?>