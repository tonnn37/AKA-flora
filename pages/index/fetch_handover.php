
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

$query = "SELECT tb_order_detail.order_detail_id as order_detail_id,
tb_order_detail.order_detail_amount as order_detail_amount,
tb_order_detail.order_detail_enddate as order_detail_enddate,
tb_order_detail.order_detail_status as order_detail_status,
tb_plant.plant_name as plant_name,
tb_order.order_name as order_name,
tb_order.order_customer as order_customer,
tb_order.order_detail as order_detail,
tb_customer.customer_firstname as customer_firstname,
tb_customer.customer_lastname as customer_lastname,
tb_order.order_id as order_id,
tb_order.order_status as order_status

FROM tb_order_detail
LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
WHERE tb_order.order_status = 'ปกติ' AND tb_order_detail.order_detail_status = 'รอส่งมอบ'
GROUP BY tb_order.order_id
ORDER BY tb_order_detail.order_detail_id";




$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $date2 = $row['order_detail_enddate'];
        $id = $row['order_detail_id'];


        $day = CalDate($date1, $date2);

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['order_id'];
        $subdata[] = $row['order_name'];
        $subdata[] = $row['customer_firstname']." ".$row['customer_lastname'];
        $subdata[] = $row['plant_name'];
        $subdata[] = number_format($row['order_detail_amount']);
        $subdata[] = $row['order_detail'];
        $subdata[] = $row['order_status'];

        $subdata[] = '
        <a href="#view_handover_detail" data-toggle="modal">
        <button type="button" class="btn btn-info btn-sm"  id="btn_handover_detail" data-id ="' . $row['order_id'] . '"
        data-status="' . $row['order_status'] . '"  data-name="' . $row['order_name'] . '"
        data-toggle="tooltip"  title="แสดงรายละเอียด">
        <i  class="fas fa-list-ol" style="color:white"></i></button></a>';

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
