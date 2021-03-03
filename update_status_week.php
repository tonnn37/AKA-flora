<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

$d = date("Y-m-d");
?>

<?php

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


$sql = "SELECT * FROM tb_planting_week
        WHERE  planting_week_status = 'ปกติ' ";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {

        $id = $row['planting_week_id'];
        $date = $row['planting_week_date'];
        $ref_planting_detail_id = $row['ref_planting_detail_id'];
        
        $cd = CalDate($date1,$date);
        if($cd >= 1){

            $sql_update = "UPDATE tb_planting_week SET planting_week_status ='เสร็จสิ้น' WHERE planting_week_id ='$id' ";

            mysqli_query($conn,$sql_update);
        }


        /* $sql_check = "SELECT * FROM tb_planting_week 
                     LEFT JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
                    WHERE tb_planting_detail.planting_detail_status = 'ปกติ' AND (SELECT COUNT( ref_planting_detail_id ) FROM tb_planting_week ) =12 
                    AND (SELECT COUNT(planting_week_status) FROM tb_planting_week WHERE planting_week_status ='เสร็จสิ้น' ) =12 AND tb_planting_detail.ref_planting_id = '$id' "; */

     /*  $sql_week_detail = "SELECT COUNT(ref_planting_detail_id) AS count FROM tb_planting_week WHERE ref_planting_detail_id ='$ref_planting_detail_id' AND planting_week_status ='เสร็จสิ้น'";
      $result2 = mysqli_query($conn, $sql_week_detail);
        $row2 = mysqli_fetch_array($result2);

        $count = $row2['count'];

        if($count >= 12){

            $sql_update2 = "UPDATE tb_planting_detail SET planting_detail_status ='เสร็จสิ้น' WHERE planting_detail_id ='$ref_planting_detail_id' ";

            mysqli_query($conn,$sql_update2);

        }
 */


        
}
