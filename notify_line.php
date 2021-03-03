<?php 
//--------------------------sql-----------------
  require('connect.php');

$strSQL="SELECT tb_order.order_id AS order_id
,tb_order.order_name AS order_name
,tb_order.order_customer AS order_customer
,tb_customer.customer_firstname as customer_firstname
,tb_customer.customer_lastname as customer_lastname
,tb_order_detail.order_detail_amount AS order_detail_amount
,tb_order_detail.order_detail_enddate AS order_detail_enddate
,tb_order_detail.ref_plant_id as ref_plant_id
,tb_plant.plant_name as plant_name
            FROM tb_order
            INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id =tb_order.order_id
            INNER JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
            INNER JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
         /*     WHERE DATEDIFF(tb_order.order_date ,NOW())=1 */
         WHERE tb_order_detail.order_detail_status='ปกติ' AND tb_order.order_status ='ปกติ' AND tb_order_detail.order_detail_planting_status ='ยังไม่ได้ทำการปลูก'";
$objQuery = mysqli_query($conn,$strSQL);
date_default_timezone_set("Asia/Bangkok");
$i=1;
$rowcount=mysqli_num_rows($objQuery);
if($rowcount > 0){
while($objResult = mysqli_fetch_array($objQuery))
{

$header = "แจ้งเตือนรายการสั่งซื้อที่ต้องปลูก";
$text = $header.
        "\n".' รายการที่ '.$i.
        "\n".' รหัสรายการสั่งซื้อ : '.$objResult['order_id'].
        "\n".' ชื่อรายการสั่งซื้อ : '.$objResult['order_name'].
        "\n".' ชื่อลูกค้า : '.$objResult['customer_firstname']." ".$objResult['customer_lastname'].
        "\n".' ชื่อพันธุ์ไม้ : '.$objResult['plant_name'].
        "\n".' จำนวนปลูก : '.$objResult['order_detail_amount'].' '.'ต้น'.
        "\n".' วันที่ส่งมอบ : '.$objResult['order_detail_enddate'];

$message = $text;
$token = 'xwbSR5JdH1neMwHFpHSGvBxU0NwJYSvyhlSTEhZKK7l';
echo send_line_notify($message, $token);
//---------------------close sql----------------
$i++;  
}

} else {

$text = "ไม่มีรายการสั่งซื้อที่ต้องปลูกในวันนี้";
$message = $text;
$token = 'xwbSR5JdH1neMwHFpHSGvBxU0NwJYSvyhlSTEhZKK7l';
echo send_line_notify($message, $token);

} 
function send_line_notify($message, $token)
{ $ch = curl_init(); curl_setopt( $ch, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt( $ch, CURLOPT_POST, 1); 
    curl_setopt( $ch, CURLOPT_POSTFIELDS, "message=$message"); 
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1); 
    $headers = array( "Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $token", );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1); 
    $result = curl_exec( $ch ); curl_close( $ch ); return $result;
}
mysqli_close($conn);
