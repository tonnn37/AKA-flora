
<?php
//fetch.php
require 'connect.php';
$output = '';
$query = "";

date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");

function CalDate($time1, $time2)
{
    $time1 = strtotime($time1);
    $time2 = strtotime($time2);

    $distanceInSeconds = round(abs($time2 - $time1)); //จะได้เป็นวินาที
    $distanceInMinutes = round($distanceInSeconds / 60); //แปลงจากวินาทีเป็นนาที

    $day = floor(abs($distanceInMinutes / 1440));

    return $day;
}
$sql = "SELECT * FROM tb_order
INNER JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id = tb_order.order_id
WHERE tb_order.order_status ='ปกติ' AND tb_order_detail.order_detail_planting_status = 'ยังไม่ได้ทำการปลูก' AND tb_order_detail.order_detail_status = 'ปกติ'
GROUP BY tb_order.order_id";

$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {

        $i++;

        $order_id = $row['order_id'];

        $sql_count = "SELECT COUNT(tb_order_detail.order_detail_id) as count FROM tb_order_detail 
        WHERE tb_order_detail.ref_order_id='$order_id' AND tb_order_detail.order_detail_status ='ปกติ'";
        $re_count = mysqli_query($conn, $sql_count);
        $r_count = mysqli_fetch_assoc($re_count);
        $sum_order = $r_count['count'];

        if ($sum_order == "") {
            $sum_order = 0;
        }


        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['order_id'];
        $subdata[] = $row['order_name'];
        $subdata[] = $row['customer_firstname'] . " " . $row['customer_lastname'];
        $subdata[] =  number_format($row['order_price']);
        $subdata[] = $sum_order;
        $subdata[] = $row['order_detail'];
        $subdata[] = $row['order_date'];
    


        $subdata[] = '
            <a href="#view_order_not_planting" data-toggle="modal">
            <button type="button" class="btn btn-info btn-sm"  id="btn_order_not_planting" data-id ="' . $row['order_id'] . '"
            data-toggle="tooltip"  title="แสดงรายละเอียด">
            <i  class="fas fa-list-ol" style="color:white"></i></button></a>' ;
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
