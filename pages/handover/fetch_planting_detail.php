
<?php

require 'connect.php';
$id = $_POST['extra_search'];

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

$query = "SELECT tb_planting_detail.planting_detail_id as planting_detail_id
,tb_planting_detail.planting_detail_status as planting_detail_status
,tb_planting_detail.planting_detail_amount as planting_detail_amount
,tb_planting_detail.planting_detail_per as planting_detail_per
,tb_planting_detail.planting_detail_total as planting_detail_total
,tb_planting_detail.ref_planting_id as ref_planting_id
,tb_planting_detail.ref_plant_id as ref_plant_id
,tb_planting_detail.ref_order_detail_id as ref_order_detail_id
,tb_planting_detail.planting_detail_enddate as planting_detail_enddate
,tb_plant.plant_name as plant_name

FROM tb_planting_detail
LEFT JOIN tb_planting ON tb_planting.planting_id = tb_planting_detail.ref_planting_id
LEFT JOIN tb_order ON tb_planting.ref_order_id = tb_order.order_id
LEFT JOIN tb_order_detail ON tb_order_detail.ref_order_id = tb_order.order_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
LEFT JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id = tb_planting_detail.planting_detail_id
LEFT JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
WHERE  tb_planting_week.planting_week_status='เสร็จสิ้น' AND tb_planting_week.planting_week_count = 12 AND tb_planting_detail.planting_detail_id = '$id'
GROUP BY tb_planting_detail.planting_detail_id
ORDER BY tb_planting_detail.planting_detail_id ASC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $date2 = $row['planting_detail_enddate'];
        $id = $row['planting_detail_id'];


        $sql_dead = "SELECT SUM(tb_planting_week_detail.week_detail_dead) as dead FROM tb_planting_detail
        INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id =  tb_planting_detail.planting_detail_id
        INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
        WHERE  tb_planting_week.ref_planting_detail_id ='$id' AND tb_planting_week_detail.week_detail_status ='ปกติ'";
        $re_dead = mysqli_query($conn, $sql_dead);
        $r_dead = mysqli_fetch_assoc($re_dead);
        $sum_dead = $r_dead['dead'];


        if ($sum_dead == "") {
            $sum_dead = 0;
        }

        $day = CalDate($date1, $date2);

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['planting_detail_id'];
        $subdata[] = $row['ref_plant_id'];
        $subdata[] = $row['plant_name'];
        $subdata[] = $row['planting_detail_total'] . " " . "ต้น";
        $subdata[] = $sum_dead." ". "ต้น";
        $subdata[] = $row['planting_detail_enddate'];
        $subdata[] = $row['planting_detail_status'];


        /*   if ($row['planting_detail_status'] == 'ปกติ') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "";
        } else if( $row['planting_detail_status'] == 'เสร็จสิ้น'){
            
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "disabled";
        }else {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $disabled = "";
        } */

        $rows[] = $subdata;

        $i++;
    }
    $json_data = array(
        /*   "draw" => intval($request['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFilter), */
        "data" => $rows,
    );
    echo json_encode($json_data);
} else {
    $json_data = array(
        /* "draw" => intval($request['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFilter), */
        "data" => "",
    );
    echo json_encode($json_data);
}

?>
