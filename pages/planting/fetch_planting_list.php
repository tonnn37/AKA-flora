
<?php
//fetch.php
require 'connect.php';
$output = '';
$query = "";
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

$query = "SELECT tb_planting_week.planting_week_id as planting_week_id
           
                ,tb_planting_week.planting_week_status as planting_week_status
                ,tb_planting_week.planting_week_count as planting_week_count
                ,tb_planting_week.ref_planting_detail_id as ref_planting_detail_id
                ,tb_planting_week.planting_week_date as planting_week_date

                ,tb_plant.plant_name as plant_name
                ,tb_planting_detail.planting_detail_amount as planting_detail_amount
                ,tb_planting_detail.planting_detail_enddate as planting_detail_enddate


FROM tb_planting_week
LEFT JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
LEFT JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
WHERE tb_planting_week.ref_planting_detail_id ='$id' AND tb_planting_week.planting_week_status !='ระงับ' 
GROUP BY tb_planting_week.planting_week_id
ORDER BY tb_planting_week.planting_week_count DESC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $week_id = $row['planting_week_id'];
        $date2 = $row['planting_detail_enddate'];
        $day = CalDate($date1, $date2);
        $check_date = $row['planting_week_date'];
        $cd = CalDate($date1,$check_date);
        
        $sql_price1 = "SELECT SUM(tb_planting_week_detail.formula_price) as count FROM tb_planting_week_detail  WHERE tb_planting_week_detail.ref_planting_week_id='$week_id' AND tb_planting_week_detail.week_detail_status ='ปกติ' ";
        $re_price1 = mysqli_query($conn, $sql_price1);
        $r_price1 = mysqli_fetch_assoc($re_price1);
        $sum_price1 = $r_price1['count'];
        $sum_price1 = round($sum_price1,0);
        $sum_price1 = intval($sum_price1);

        if ($sum_price1 == "") {
            $sum_price1 = 0;
        }

        $sql_price2 = "SELECT SUM(tb_planting_week_detail.material_price) as count FROM tb_planting_week_detail  WHERE tb_planting_week_detail.ref_planting_week_id='$week_id' AND tb_planting_week_detail.week_detail_status ='ปกติ' ";
        $re_price2 = mysqli_query($conn, $sql_price2);
        $r_price2 = mysqli_fetch_assoc($re_price2);
        $sum_price2 = $r_price2['count'];
        $sum_price2 = round($sum_price2,0);
        $sum_price2 =intval($sum_price2);
   
        
        if ($sum_price2 == "") {
            $sum_price2 = 0;
        }
      
        $total_price = $sum_price1 + $sum_price2;
 
        $total_price = number_format($total_price, 2);

        $sql_dead = "SELECT SUM(tb_planting_week_detail.week_detail_dead) as dead FROM tb_planting_week_detail  WHERE tb_planting_week_detail.ref_planting_week_id='$week_id' AND tb_planting_week_detail.week_detail_status ='ปกติ' ";
        $re_dead = mysqli_query($conn, $sql_dead);
        $r_dead = mysqli_fetch_assoc($re_dead);
        $sum_dead = $r_dead['dead'];

        if ($sum_dead == "") {
            $sum_dead = 0;
        }
      
        
        if($cd > 7){
            $disabled = "disabled";
        }else{
            $disabled = "";
        }

        $days = date("d-m-Y", strtotime($row['planting_week_date']));
        $subdata = array();

        $subdata[] = $i;
        $subdata[] = $row['planting_week_count'];
        $subdata[] = $sum_dead ;
        $subdata[] = $total_price ;
        $subdata[] = $days;
        $subdata[] = $row['planting_week_status'];

        if ($row['planting_week_status'] == 'ปกติ' || $row['planting_week_status'] == 'เสร็จสิ้น') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
        } else{
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
        }
        $subdata[] = '
        <a>
        <button type="button" class="btn btn-success btn-sm"  id="btn_add_week_detail" data ="' . $row['planting_week_id'] . '"  
        data-count ="' . $row['planting_week_count'] . '"  data-plant ="' . $row['plant_name'] . '" data-planting_detail_id ="' . $row['ref_planting_detail_id'] . '"
        data-planting_detail_id ="' . $row['ref_planting_detail_id'] . '" data-toggle="tooltip"  title="เพิ่มข้อมูลเพิ่มเติมแต่ละสัปดาห์"">
        <i  class="fas fa-plus" style="color:white "></i></button></a>' . '

        <a href="#planting_week_detail" data-toggle="modal" >
        <button type="button" class="btn btn-info btn-sm" id="view_week_detail"
            data-toggle="tooltip"  title="แสดงรายละเอียดการปลูก" data="' . $row['planting_week_id'] . '"
            data-status="' . $row['planting_week_status'] . '"  data-plant="' . $row['plant_name'] . '" data-count="' . $row['planting_week_count'] . '"
            data-planting_detail_id ="' . $row['ref_planting_detail_id'] . '">
            <i class="fas fa-list-ol" style="color:white"></i></button>
            </a>' . '

        <button type="button" class="' . $color . ' " '.$disabled.' id="btn_remove_week" data="' . $row['planting_week_id'] . '"data-status="' . $row['planting_week_status'] . '"  data-name="' . $row['planting_week_count'] . '" 
            data-toggle="tooltip"  title="' . $txt . '" ">
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
