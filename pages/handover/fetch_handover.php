
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

$query = "SELECT tb_stock_handover.handover_id as handover_id,
tb_stock_handover.handover_status as handover_status,
tb_stock_handover.handover_date as handover_date,
tb_stock_handover.ref_order_detail_id as ref_order_detail_id,
tb_order.order_name as order_name,
tb_order.order_customer as order_customer,
tb_plant.plant_id as plant_id,
tb_plant.plant_name as plant_name,
tb_customer.customer_firstname as customer_firstname,
tb_customer.customer_lastname as customer_lastname,
tb_stock_handover_detail.handover_detail_id as handover_detail_id,
tb_order.order_id as order_id,
tb_stock_recieve.stock_recieve_id  as stock_recieve_id

FROM tb_stock_handover
LEFT JOIN tb_stock_handover_detail ON tb_stock_handover_detail.ref_handover_id = tb_stock_handover.handover_id
LEFT JOIN tb_order_detail ON tb_order_detail.order_detail_id = tb_stock_handover.ref_order_detail_id
LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
LEFT JOIN tb_planting_detail ON tb_planting_detail.ref_order_detail_id = tb_order_detail.order_detail_id
LEFT JOIN tb_stock_recieve ON tb_stock_recieve.ref_planting_detail_id = tb_planting_detail.planting_detail_id
WHERE tb_stock_handover.handover_status ='เสร็จสิ้น'
GROUP BY tb_stock_handover.handover_id
ORDER BY tb_stock_handover.handover_id DESC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        $id = $row['handover_id'];
        $dateat = $row['handover_date'];

        $caldate  = CalDate($date1, $dateat);
        if ($caldate > 7) {
            $dis1 = "disabled";
        } else {
            $dis1 = "";
        }

        $sql_amount = "SELECT SUM(tb_stock_handover_detail.handover_detail_amount) as amount FROM tb_stock_handover_detail  WHERE tb_stock_handover_detail.ref_handover_id	='$id'";
        $re_amount = mysqli_query($conn, $sql_amount);
        $r_amount = mysqli_fetch_assoc($re_amount);
        $sum_amount = $r_amount['amount'];

        if ($sum_amount == "") {
            $sum_amount = 0;
        }

        $days = date("d-m-Y", strtotime($row['handover_date']));
        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['handover_id'];
      /*   $subdata[] = $row['stock_recieve_id'];
        $subdata[] = $row['order_id']; */
       /*  $subdata[] = $row['order_name']; */
        $subdata[] = $row['customer_firstname'] . " " . $row['customer_lastname'];
        $subdata[] = $row['plant_name'];
        $subdata[] = number_format($sum_amount);
        $subdata[] = $days;
        $subdata[] = $row['handover_status'];

        if ($row['handover_status'] == 'เสร็จสิ้น') {

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
        <a href="#view_handover_detail" data-toggle="modal" class="' . $disabled . '" >
        <button type="button" class="btn btn-info btn-sm"  id="btn_handover_detail" data ="' . $row['handover_id'] . '"
        data-status="' . $row['handover_status'] . '"  data-name="' . $row['plant_name'] . '"
        data-order="' . $row['order_id'] . '" data-grade="' . $row['stock_recieve_id'] . '"
        data-toggle="tooltip"  title="' . $txt . '"' . $disabled . ' ">
        <i  class="fas fa-list-ol" style="color:white"></i></button></a>' . '
        <button type="button" class="' . $color . '"  id="btn_remove_hanover" data="' . $row['handover_id'] . '"data-status="' . $row['handover_status'] . '"  data-name="' . $row['order_name'] . '" 
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
