<?php
//--------------------------sql-----------------
require('connect.php');

date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");
function CalDate($time1, $time2)
{
    //Convert date to formate Timpstamp
    $time1 = strtotime($time1);
    $time2 = strtotime($time2);

    //$diffdate=$time1-$time2
    $distanceInSeconds = round(abs($time2 - $time1)); //จะได้เป็นวินาที
    $distanceInMinutes = round($distanceInSeconds / 60); //แปลงจากวินาทีเป็นนาที

    $days = floor(abs($distanceInMinutes / 1440));

    return   $days;
}


$strSQL = "SELECT 
tb_order_detail.order_detail_id as order_detail_id
,tb_order.order_id as order_id
,tb_order.order_name as order_name
,tb_order_detail.order_detail_amount as order_detail_amount
,tb_order_detail.order_detail_enddate as order_detail_enddate
,tb_customer.customer_firstname as customer_firstname
,tb_customer.customer_lastname as customer_lastname
,tb_plant.plant_name as plant_name

FROM tb_order_detail 
INNER JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
INNER JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
INNER JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
WHERE tb_order_detail.order_detail_status ='รอส่งมอบ' AND tb_order.order_status = 'ปกติ'";
$objQuery = mysqli_query($conn, $strSQL);
date_default_timezone_set("Asia/Bangkok");
$i = 1;
$rowcount = mysqli_num_rows($objQuery);
if ($rowcount > 0) {
  while ($objResult = mysqli_fetch_array($objQuery)) {
   

    $header = "แจ้งเตือนรายการสั่งซื้อที่รอส่งมอบ";
    $text = $header .
      "\n" . ' รายการที่ ' . $i .
      "\n" . ' รหัสรายการสั่งซื้อ : ' . $objResult['order_id'] .
      "\n" . ' รหัสรายการสั่งซื้อย่อย : ' . $objResult['order_detail_id'] .
      "\n" . ' ชื่อรายการสั่งซื้อ : ' . $objResult['order_name'] .
      "\n" . ' ชื่อลูกค้า : ' . $objResult['customer_firstname']." ".$objResult['customer_lastname'] .
      "\n" . ' ชื่อพันธุ์ไม้ : ' . $objResult['plant_name'] .
      "\n" . ' จำนวนที่ต้องส่ง : ' . $objResult['order_detail_amount'] . ' ' . 'ต้น' .
      "\n" . ' วันที่ส่งมอบ : ' . $objResult['order_detail_enddate'];

    $message = $text;
    $token = 'xwbSR5JdH1neMwHFpHSGvBxU0NwJYSvyhlSTEhZKK7l';
    echo send_line_notify($message, $token);
    //---------------------close sql----------------
    $i++;
  }
} else {

  /* $text = "ไม่มีรายการสั่งซื้อที่ต้องปลูกในวันนี้";
  $message = $text;
  $token = 'xwbSR5JdH1neMwHFpHSGvBxU0NwJYSvyhlSTEhZKK7l';
  echo send_line_notify($message, $token); */
}
function send_line_notify($message, $token)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "message=$message");
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $headers = array("Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $token",);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}
mysqli_close($conn);
