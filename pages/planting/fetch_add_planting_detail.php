
<?php
//fetch.php
require 'connect.php';
$output = '';
$query = "";
$id = $_POST['extra_search'];

date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");

function CalDate($time1,$time2)
{

     //Convert date to formate Timpstamp
     $time1 = strtotime($time1);
     $time2 = strtotime($time2);
 
     //$diffdate=$time1-$time2
     $distanceInSeconds = round(abs($time2 - $time1)); //จะได้เป็นวินาที
     $distanceInMinutes = round($distanceInSeconds / 60); //แปลงจากวินาทีเป็นนาที
 
     $day = floor(abs($distanceInMinutes / 1440));
 
     return $day;
}

$query = "SELECT tb_order_detail.order_detail_id as order_detail_id,tb_order_detail.order_detail_amount as order_detail_amount,tb_order_detail.order_detail_status as order_detail_status,
tb_order_detail.order_detail_enddate as order_detail_enddate, tb_order_detail.ref_plant_id as ref_plant_id,
tb_order_detail.order_detail_per as order_detail_per,tb_order_detail.order_detail_total as order_detail_total,tb_order_detail.order_detail_planting_status as order_detail_planting_status,
tb_plant.plant_name as plant_name

FROM tb_order_detail
LEFT JOIN tb_order ON tb_order.order_id= tb_order_detail.ref_order_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
LEFT JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
WHERE tb_order_detail.ref_order_id='$id'
ORDER BY tb_order_detail.order_detail_id ASC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $date2 = $row['order_detail_enddate'];
        $date4 = strtotime($date1);
        $date3 = strtotime($date2);
        if($date4 > $date3){
            $day = "สิ้นสุดการปลูก";
        }else{
            $day = CalDate($date1,$date2)." "."วัน";
        }
           
        $subdata = array();
     
        $subdata[] = '<input type="checkbox" name="check_order[]" class="checkbox larger" id="check"  value="' . $row['order_detail_id']. '"/>';
        $subdata[] = $i;
        $subdata[] = $row['order_detail_id'];
        $subdata[] = $row['plant_name'];
        $subdata[] =  number_format($row['order_detail_amount'])." "."ต้น";
        $subdata[] =  number_format($row['order_detail_per'])." "."ต้น";
        $subdata[] =  number_format($row['order_detail_total'])." "."ต้น";
        $subdata[] = $row['order_detail_enddate'];
        $subdata[] = $day;
        
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
