<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

$date1 = date("Y-m-d");
$date2 = $_POST['date2'];



if ($date2 != "") {


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

    
    echo  $caldate1 =  CalDate($date1,$date2);
} else {
    echo "0";
}
