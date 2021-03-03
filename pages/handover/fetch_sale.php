
<?php

require 'connect.php';
session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


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

$date = date("Y-m-d");
$sec = date("Y-m-d H:i:s");

$query = "SELECT tb_payment.payment_id as payment_id,
tb_payment.payment_status as payment_status,
tb_plant.plant_name as plant_name,
tb_payment.payment_date as payment_date,
tb_payment.created_by as created_by,
tb_payment.created_at as created_at

FROM tb_payment
LEFT JOIN tb_payment_detail ON tb_payment_detail.ref_payment_id = tb_payment.payment_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_payment_detail.ref_plant_id
WHERE tb_payment.payment_status ='เสร็จสิ้น'
GROUP BY tb_payment.payment_id
ORDER BY tb_payment.payment_id DESC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
       
        $id = $row['payment_id'];
        $dateat = $row['created_at'];
        $caldate = CalDate($date1,$dateat);

        if($caldate > 7){
            $dis1 = "disabled";
        }else{
            $dis1 = "";
        }

        $sql_amount = "SELECT SUM(tb_payment_detail.payment_detail_amount) as amount FROM tb_payment_detail  WHERE tb_payment_detail.ref_payment_id	='$id' AND tb_payment_detail.payment_detail_status ='เสร็จสิ้น' ";
        $re_amount = mysqli_query($conn, $sql_amount);
        $r_amount = mysqli_fetch_assoc($re_amount);
        $sum_amount = $r_amount['amount'];

        if ($sum_amount == "") {
            $sum_amount = 0;
        }

        $sql_price = "SELECT SUM(tb_payment_detail.payment_detail_total) as price FROM tb_payment_detail  WHERE tb_payment_detail.ref_payment_id	='$id' AND tb_payment_detail.payment_detail_status ='เสร็จสิ้น' ";
        $re_price = mysqli_query($conn, $sql_price);
        $r_price = mysqli_fetch_assoc($re_price);
        $sum_price = $r_price['price'];

        if ($sum_price == "") {
            $sum_price = 0;
        }

        $days = date("d-m-Y H:i:s", strtotime($row['payment_date']));
        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['payment_id'];
        $subdata[] = number_format($sum_amount);
        $subdata[] = number_format($sum_price,2);
        $subdata[] = $row['created_by'] ;
        $subdata[] = $days ;
        $subdata[] = $row['payment_status'];
  
        if ($row['payment_status'] == 'เสร็จสิ้น') {

            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "";
        } else {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $disabled = "";
        } 

        $subdata[] = '
        <a href="#view_payment_detail" data-toggle="modal" class="' . $disabled . '" >
        <button type="button" class="btn btn-info btn-sm"  id="btn_payment_detail" data ="' . $row['payment_id'] . '"
        data-status="' . $row['payment_status'] . '"  data-name="' . $row['plant_name'] . '"
        data-toggle="tooltip"  title="' . $txt . '"' . $disabled . ' ">
        <i  class="fas fa-list-ol" style="color:white"></i></button></a>' . '

        <button type="button" class="' . $color . '"  id="btn_remove_payment" data="' . $row['payment_id'] . '"data-status="' . $row['payment_status'] . '"  data-name="' . $row['plant_name'] . '" 
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
