
<?php
//fetch.php
require 'connect.php';
$output = '';
$query = "";
$id = $_POST['extra_search'];
@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];
if($permiss == "พนักงาน")
{
    $hidden = "hidden";
    $dis = "disabled";
}else{
    $hidden ="";
    $dis = "";
}
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

$query = "SELECT tb_planting_detail.planting_detail_id as planting_detail_id, tb_planting_detail.planting_detail_status as planting_detail_status
        ,tb_plant.plant_id as plant_id ,tb_plant.plant_name as plant_name
        ,tb_planting.planting_id as planting_id 
        ,tb_planting_detail.planting_detail_amount as planting_detail_amount
        ,tb_planting_detail.planting_detail_id as planting_detail_id
        ,tb_planting_detail.ref_planting_id as ref_planting_id
        ,tb_planting_detail.planting_detail_total as planting_detail_total
        ,tb_planting_detail.planting_detail_enddate as planting_detail_enddate 
        ,tb_planting_week.planting_week_id as planting_week_id
        ,tb_planting_week_detail.week_detail_id as week_detail_id
        ,tb_planting_week.planting_week_status as planting_week_status
        ,tb_plant.plant_time as plant_time

FROM tb_planting_detail
LEFT JOIN tb_planting ON tb_planting.planting_id = tb_planting_detail.ref_planting_id
LEFT JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id = tb_planting_detail.planting_detail_id
LEFT JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
WHERE tb_planting_detail.ref_planting_id ='$id' 
GROUP BY tb_planting_detail.planting_detail_id 
ORDER BY tb_planting_detail.planting_detail_id ASC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $date2 = $row['planting_detail_enddate'];
        $id = $row['planting_detail_id'];
        $date4 = strtotime($date1);
        $date3 = strtotime($date2);


        $sql_count_week = "SELECT COUNT(tb_planting_week.planting_week_count) as count FROM tb_planting_week WHERE  tb_planting_week.planting_week_status ='เสร็จสิ้น'
        AND tb_planting_week.ref_planting_detail_id='$id' ";

        $re_count_week = mysqli_query($conn, $sql_count_week);
        $r_count_week = mysqli_fetch_assoc($re_count_week);
        $count_week = $r_count_week['count'];



        $sql_price1 = "SELECT SUM(tb_planting_week_detail.formula_price) as count FROM tb_planting_detail
                    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id =  tb_planting_detail.planting_detail_id
                    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
                    WHERE  tb_planting_week.ref_planting_detail_id ='$id' AND tb_planting_week_detail.week_detail_status ='ปกติ'";

        $re_price1 = mysqli_query($conn, $sql_price1);
        $r_price1 = mysqli_fetch_assoc($re_price1);
        $sum_price1 = $r_price1['count'];
        $sum_price1 = round($sum_price1,0);
        $sum_price1 = intval($sum_price1);


        if ($sum_price1 == "") {
            $sum_price1 = 0;
        }

        $sql_price2 = "SELECT SUM(tb_planting_week_detail.material_price) as count FROM tb_planting_detail
                    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id =  tb_planting_detail.planting_detail_id
                    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
                    WHERE  tb_planting_week.ref_planting_detail_id ='$id' AND tb_planting_week_detail.week_detail_status ='ปกติ'";

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

        $dead =  $row['planting_detail_total'] - $sum_dead ;
        
        if($date4 > $date3){
            $day = "สิ้นสุด";
        }else{
            $day = CalDate($date1,$date2)." "."วัน";
        }

       

        $sql_count2 = "SELECT COUNT(tb_planting_week.ref_planting_detail_id) as count 
        FROM tb_planting_week 
        INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
        INNER JOIN tb_planting ON tb_planting.planting_id = tb_planting_detail.ref_planting_id
        WHERE tb_planting_week.ref_planting_detail_id ='$id' AND tb_planting.planting_status ='ปกติ' 
        AND tb_planting_week.planting_week_status ='เสร็จสิ้น' AND tb_planting_detail.planting_detail_status ='ปกติ'";

        $re_count2 = mysqli_query($conn, $sql_count2);
        $r_count2 = mysqli_fetch_assoc($re_count2);
        $sum_order2 = $r_count2['count'];
        if ($sum_order2 >= 12) {

            $update_status = "UPDATE tb_planting_detail  SET planting_detail_status ='รอคัดเกรด' WHERE planting_detail_id ='$id'";
            mysqli_query($conn, $update_status);
        }

        $days = date("d-m-Y", strtotime($row['planting_detail_enddate']));

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['planting_detail_id'];
        $subdata[] = $row['plant_name'];
        $subdata[] = number_format($row['planting_detail_total']);
        $subdata[] = number_format($sum_dead);
        $subdata[] = number_format($dead);
        $subdata[] = $total_price;
        $subdata[] = $count_week."/".$row['plant_time'];
        $subdata[] = $days;
        $subdata[] = $day;
        $subdata[] = $row['planting_detail_status'];



        if ($row['planting_detail_status'] == 'ปกติ' && $count_week >= 1 ) {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "disabled";
        } else if( $row['planting_detail_status'] == 'เสร็จสิ้น'){
            
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "disabled";
        } else if ($row['planting_detail_status'] =='ระงับ'){
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $disabled = "";
        } else if( $row['planting_detail_status'] == 'รอคัดเกรด'){
            
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "disabled";
        }else {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "";
        }
        $subdata[] = '
        <a href="#viewlist" data-toggle="modal">
        <button type="button" class="btn btn-info btn-sm"  id="btn_view_planting_list" data ="' . $row['planting_detail_id'] . '"
        data-status="' . $row['planting_detail_status'] . '"  data-name="' . $row['plant_name'] . '" data-id="' . $row['week_detail_id'] . '"
        data-toggle="tooltip"  title="แสดงรายละเอียดแต่ละสัปดาห์" >
        <i  class="fas fa-list-ol" style="color:white"></i></button></a>' . '
        
        <button type="button" class="' . $color . '"  id="btn_remove_planting_detail" data="' . $row['planting_detail_id'] . '"data-status="' . $row['planting_detail_status'] . '"  data-name="' . $row['plant_name'] . '" 
        data-toggle="tooltip"  title="' . $txt . '" '.$disabled.' '.$hidden.'>
        <i  class="' . $image . '" style="color:white"></i></button>';
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
