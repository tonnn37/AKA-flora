
<?php
require 'connect.php';

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
$output = '';
$query = "";


$query = "SELECT tb_handover_noplant.handover_noplant_id as handover_noplant_id
,tb_order_detail.order_detail_id as order_detail_id
,tb_order.order_id as order_id
,tb_order.order_name as order_name
,tb_customer.customer_firstname as customer_firstname
,tb_customer.customer_lastname as customer_lastname
,tb_plant.plant_name as plant_name
,tb_handover_noplant.handover_noplant_date as handover_noplant_date
,tb_handover_noplant.handover_noplant_status as handover_noplant_status

FROM tb_handover_noplant
LEFT JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id = tb_handover_noplant.handover_noplant_id
LEFT JOIN tb_order_detail ON tb_order_detail.order_detail_id = tb_handover_noplant.ref_order_detail_id
LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
LEFT JOIN tb_plant ON tb_handover_noplant_detail.ref_plant_id = tb_plant.plant_id
WHERE tb_handover_noplant.handover_noplant_status != 'ยกเลิก'

GROUP BY tb_handover_noplant.handover_noplant_id
ORDER BY tb_handover_noplant.handover_noplant_id DESC";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        $id = $row['handover_noplant_id'];
        $dateat = $row['handover_noplant_date'];
        $caldate  = CalDate($date1, $dateat);
        if ($caldate > 7) {
            $dis1 = "disabled";
        } else {
            $dis1 = "";
        }

        $sql_amount = "SELECT SUM(tb_handover_noplant_detail.handover_noplant_detail_amount) as amount FROM tb_handover_noplant_detail  WHERE tb_handover_noplant_detail.ref_handover_noplant_id='$id'";
        $re_amount = mysqli_query($conn, $sql_amount);
        $r_amount = mysqli_fetch_assoc($re_amount);
        $sum_amount = $r_amount['amount'];

        if ($sum_amount == "") {
            $sum_amount = 0;
        }
        $days = date("d-m-Y", strtotime($row['handover_noplant_date']));
        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['handover_noplant_id'];
/*         $subdata[] = $row['order_id'];
        $subdata[] = $row['order_name']; */
        $subdata[] = $row['customer_firstname']." ".$row['customer_lastname'];
        $subdata[] = $row['plant_name'];
        $subdata[] = number_format($sum_amount);
        $subdata[] = $days;
        $subdata[] = $row['handover_noplant_status'];

        if ($row['handover_noplant_status'] == 'เสร็จสิ้น') {

            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "แสดงรายละเอียด";
            $disabled = "";
        } else {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $disabled = "";
        }
        $subdata[] = '
        <a href="#view_handover_noplant_detail" data-toggle="modal" class="' . $disabled . '" >
        <button type="button" class="btn btn-info btn-sm"  id="btn_handover_noplant_detail" data ="' . $row['handover_noplant_id'] . '"
        data-status="' . $row['handover_noplant_status'] . '"  data-name="' . $row['plant_name'] . '"
        data-order="' . $row['order_id'] . '"
        data-toggle="tooltip"  title="' . $txt . '"' . $disabled . ' ">
        <i  class="fas fa-list-ol" style="color:white"></i></button></a>' . '
        <button type="button" class="' . $color . '"  id="btn_remove_hanover_noplant" data="' . $row['handover_noplant_id'] . '"data-status="' . $row['handover_noplant_status'] . '"  data-name="' . $row['order_name'] . '" 
        order-name ="'.$row['order_name'].'"
        data-toggle="tooltip"  title="' . $txt . '" '.$dis1.'>
        <i  class="' . $image . '" style="color:white"></i></button>';
        $rows[] = $subdata;

        $i++;
    }
    $json_data = array(
    
        "data" => $rows,
    );
    echo json_encode($json_data);
} else {
    $json_data = array(
  
        "data" => "",
    );
    echo json_encode($json_data);
}

?>
