<?php
include('connect.php');

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$username = str_replace(' ', '', $username);
$usernames = preg_replace("/[^a-z\d]/i", '', $username);
$password = str_replace(' ', '', $password);
$passwords = preg_replace("/[^a-z\d]/i", '', $password);

$_SESSION['userlevel'] = 1;
date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");
$sql_line = "SELECT * FROM tb_line_notify WHERE line_notify_id =(SELECT MAX(line_notify_id) FROM tb_line_notify)";

$sql = "SELECT tb_user.firstname AS FN, tb_user.lastname AS LN , tb_user_detail.userlevel AS LEVEL, tb_user.picture AS PIC, tb_user.emp_id AS emp_id FROM tb_user 
INNER JOIN tb_user_detail ON tb_user_detail.ref_emp_id = tb_user.emp_id
WHERE  tb_user_detail.username='$usernames' AND tb_user_detail.password='$passwords' AND tb_user.emp_status ='ปกติ' AND tb_user_detail.status='ใช้งาน' ";


$sql_check = "SELECT tb_user.firstname AS FN, tb_user.lastname AS LN , tb_user_detail.userlevel AS LEVEL, tb_user.picture AS PIC, tb_user.emp_id AS emp_id FROM tb_user 
INNER JOIN tb_user_detail ON tb_user_detail.ref_emp_id = tb_user.emp_id
WHERE  tb_user_detail.username='$usernames'  AND tb_user.emp_status ='ปกติ' AND tb_user_detail.status='ใช้งาน' ";
$objQuery = mysqli_query($conn, $sql);
$objResult = mysqli_fetch_assoc($objQuery);
$obj_check = mysqli_query($conn, $sql_check); 
$re_check = mysqli_fetch_assoc($obj_check);
if (!$re_check) {
    echo 1;
} else {
    if (!$objResult) {
        echo 0;
    } else {
        if ($_SESSION['userlevel'] == 1) {
            
            $result_line = mysqli_query($conn, $sql_line);
            $check_line = mysqli_fetch_assoc($result_line);
            $data_date = $check_line['line_notify_date'];
            if($date != $data_date){
                $sql_insert_line = "INSERT INTO tb_line_notify (line_notify_date,line_notify_status) VALUES ('$date','1')";
                mysqli_query($conn, $sql_insert_line);
                echo "4".",";
            }else{

                echo "x".",";
            }
        
            if ($objResult['LEVEL'] == 'ผู้ดูแลระบบ') {

                $_SESSION['emp_id'] = $objResult['emp_id'];
                $_SESSION['firstname'] = $objResult['FN'];
                $_SESSION['lastname'] = $objResult['LN'];
                $_SESSION['userlevel'] = $objResult['LEVEL'];
                $_SESSION['picture'] = $objResult['PIC'];
               
                echo 2;
            } else {
                $_SESSION['emp_id'] = $objResult['emp_id'];
                $_SESSION['firstname'] = $objResult['FN'];
                $_SESSION['lastname'] = $objResult['LN'];
                $_SESSION['userlevel'] = $objResult['LEVEL'];
                $_SESSION['picture'] = $objResult['PIC'];

                echo 3;
            }

        } else {
            
            $result_line = mysqli_query($conn, $sql_line);
            $check_line = mysqli_fetch_assoc($result_line);
            $data_date = $check_line['line_notify_date'];
            if($date != $data_date){
                $sql_insert_line = "INSERT INTO tb_line_notify (line_notify_date,line_notify_status) VALUES ('$date','1')";
                mysqli_query($conn, $sql_insert_line);
                echo "4".",";
            }else{

                echo "x".",";
            }
        
            if ($objResult['LEVEL'] == 'ผู้ดูแลระบบ') {

                $_SESSION['emp_id'] = $objResult['emp_id'];
                $_SESSION['firstname'] = $objResult['FN'];
                $_SESSION['lastname'] = $objResult['LN'];
                $_SESSION['userlevel'] = $objResult['LEVEL'];
                $_SESSION['picture'] = $objResult['PIC'];

                require 'notify_line.php';
                echo 2;
            } else {
                $_SESSION['emp_id'] = $objResult['emp_id'];
                $_SESSION['firstname'] = $objResult['FN'];
                $_SESSION['lastname'] = $objResult['LN'];
                $_SESSION['userlevel'] = $objResult['LEVEL'];
                $_SESSION['picture'] = $objResult['PIC'];

                require 'notify_line.php';
                echo 3;
            }
        }
    }
}
