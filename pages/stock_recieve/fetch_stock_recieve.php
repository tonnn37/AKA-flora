
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


$query = "SELECT tb_stock_recieve.stock_recieve_id as stock_recieve_id,
tb_stock_recieve.stock_recieve_amount as stock_recieve_amount,
tb_stock_recieve.stock_recieve_date as stock_recieve_date,
tb_stock_recieve.stock_recieve_status as stock_recieve_status,
tb_stock_recieve.ref_planting_detail_id as ref_planting_detail_id,
tb_plant.plant_name as plant_name,
tb_customer.customer_firstname as customer_firstname,
tb_customer.customer_lastname as customer_lastname

FROM tb_stock_recieve
LEFT JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_stock_recieve.ref_planting_detail_id
LEFT JOIN tb_order_detail ON tb_order_detail.order_detail_id = tb_planting_detail.ref_order_detail_id
LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
LEFT JOIN tb_customer ON tb_order.order_customer = tb_customer.customer_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
WHERE tb_stock_recieve.stock_recieve_status ='ปกติ'
ORDER BY tb_stock_recieve.stock_recieve_id DESC";


$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        $id = $row['stock_recieve_id'];

        $days = date("d-m-Y", strtotime($row['stock_recieve_date']));
      
        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['stock_recieve_id'];
        $subdata[] = $row['customer_firstname']." ".$row['customer_lastname'];
        $subdata[] = $row['plant_name'];
        $subdata[] = number_format($row['stock_recieve_amount']);
        $subdata[] = $days;
        $subdata[] = $row['stock_recieve_status'];
     
        if ($row['stock_recieve_status'] == 'เสร็จสิ้น') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $txt2 = "แสดงรายละเอียด";
            $disabled = "disabled";
        } else if ($row['stock_recieve_status'] == 'ยกเลิก') {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $txt2 = "แสดงรายละเอียด";
            $disabled = "";
        }else{
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $txt2 = "แสดงรายละเอียด";
            $disabled = "";
        }
        $subdata[] = '
        <a href="#view_recieve_detail" data-toggle="modal"  >
        <button type="button" class="btn btn-info btn-sm"  id="btn_viewstock_detail" data ="' . $row['stock_recieve_id'] . '"
        data-status="' . $row['stock_recieve_status'] . '"  data-name="' . $row['plant_name'] . '"
        planting-id = "'.$row['ref_planting_detail_id'].'"
        data-toggle="tooltip"  title="' . $txt2 . '"">
        <i  class="fas fa-list-ol" style="color:white"></i></button></a>' . '

        <button type="button" class="' . $color . '" id="btn_remove_recieve" data="' . $row['stock_recieve_id'] . '"data-status="' . $row['stock_recieve_status'] . '"  data-name="' . $row['plant_name'] . '" 
        data-toggle="tooltip"  title="' . $txt . '" " ' . $disabled . ' >
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
