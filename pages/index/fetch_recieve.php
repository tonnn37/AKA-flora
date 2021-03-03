
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


$query = "SELECT tb_planting.planting_id as planting_id, tb_planting.planting_status as planting_status, tb_planting.ref_order_id as ref_order_id,tb_planting.planting_date as planting_date
,tb_order_detail.order_detail_id as order_detail_id
,tb_order.order_id as order_id, tb_order.order_name as order_name ,tb_order.order_customer as order_customer ,tb_order.order_detail as order_detail
,tb_planting_detail.planting_detail_id as planting_detail_id
,tb_customer.customer_firstname as customer_firstname , tb_customer.customer_lastname as customer_lastname  

FROM tb_planting
LEFT JOIN tb_order ON tb_order.order_id = tb_planting.ref_order_id
LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
LEFT JOIN tb_order_detail ON tb_order_detail.ref_order_id = tb_order.order_id
LEFT JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
LEFT JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id = tb_planting_detail.planting_detail_id
WHERE  tb_planting.planting_status ='ปกติ' AND tb_planting_detail.planting_detail_status ='รอคัดเกรด' 
GROUP BY planting_id
ORDER BY planting_id ASC";


$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        $planting_id = $row['planting_id'];
        $planting_date = $row['planting_date'];
        $planting_status = $row['planting_status'];

        $planting_detail_id = $row['planting_detail_id'];

        $order_id = $row['order_id'];
        $order_name = $row['order_name'];
        $order_customer = $row['customer_firstname']." ".$row['customer_lastname'];
        $order_detail = $row['order_detail'];


        $sql_count_week = "SELECT COUNT(tb_planting_week.planting_week_count) as count FROM tb_planting_week WHERE  tb_planting_week.planting_week_status ='เสร็จสิ้น'
        AND tb_planting_week.ref_planting_detail_id='$planting_detail_id' ";

        $re_count_week = mysqli_query($conn, $sql_count_week);
        $r_count_week = mysqli_fetch_assoc($re_count_week);
        $count_week = $r_count_week['count'];

        $sql_count = "SELECT COUNT(tb_planting_detail.planting_detail_id) as count FROM tb_planting_detail WHERE tb_planting_detail.ref_planting_id='$planting_id' ";
        $re_count = mysqli_query($conn, $sql_count);
        $r_count = mysqli_fetch_assoc($re_count);
        $sum_order = $r_count['count'];

        if ($sum_order == "") {
            $sum_order = 0;
        }

        $sql_price1 = "SELECT SUM(tb_planting_week_detail.formula_price) as count FROM tb_planting
                        INNER JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
                        INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id =  tb_planting_detail.planting_detail_id
                        INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
                        WHERE  tb_planting.planting_id ='$planting_id' AND tb_planting_week_detail.week_detail_status ='ปกติ'";

        $re_price1 = mysqli_query($conn, $sql_price1);
        $r_price1 = mysqli_fetch_assoc($re_price1);
        $sum_price1 = $r_price1['count'];
        $sum_price1 = round($sum_price1,0);
        $sum_price1 = intval($sum_price1);

        if ($sum_price1 == "") {
            $sum_price1 = 0;
        }


        $sql_price2 = "SELECT SUM(tb_planting_week_detail.material_price) as count FROM tb_planting
                    INNER JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
                    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id =  tb_planting_detail.planting_detail_id
                    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
                    WHERE  tb_planting.planting_id ='$planting_id' AND tb_planting_week_detail.week_detail_status ='ปกติ'";

        $re_price2 = mysqli_query($conn, $sql_price2);
        $r_price2 = mysqli_fetch_assoc($re_price2);
        $sum_price2 = $r_price2['count'];
        $sum_price2 = round($sum_price2,0);
        $sum_price2 = intval($sum_price2);

        if ($sum_price2 == "") {
            $sum_price2 = 0;
        }

        $total_price = $sum_price1 + $sum_price2;
        $total_price = number_format($total_price, 2);

        $sql_dead = "SELECT SUM(tb_planting_week_detail.week_detail_dead) as dead FROM tb_planting
        INNER JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
        INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id =  tb_planting_detail.planting_detail_id
        INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
        WHERE  tb_planting.planting_id ='$planting_id' AND tb_planting_week_detail.week_detail_status ='ปกติ'";
        $re_dead = mysqli_query($conn, $sql_dead);
        $r_dead = mysqli_fetch_assoc($re_dead);
        $sum_dead = $r_dead['dead'];


        if ($sum_dead == "") {
            $sum_dead = 0;
        }

   
      
        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['planting_id'];
        $subdata[] = $row['order_name'];
        $subdata[] = $order_customer;
        $subdata[] = $row['planting_date'];
        $subdata[] = $row['planting_status'];

      
        $subdata[] = '
        <a href="#view_recieve_detail" data-toggle="modal">
        <button type="button" class="btn btn-info btn-sm"  id="btn_view_recieve_detail" data-id ="' . $row['planting_id'] . '"
        data-status="' . $row['planting_status'] . '"  data-name="' . $row['order_name'] . '"
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
