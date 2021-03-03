<?php
require 'connect.php';

@session_start();
date_default_timezone_set("Asia/Bangkok");
$name =$_SESSION['firstname']." " .$_SESSION['lastname'];

$d = date("Y-m-d");


$empid = $_POST['empid'];
$status = $_POST['status'];
$cardid = $_POST['cardid'];



$sql_reset = "UPDATE tb_user_detail SET password ='$cardid' WHERE ref_emp_id ='$empid'";

if(mysqli_query($conn,$sql_reset)){

 echo $sql_reset;   
}else{
    echo mysqli_error($conn);
}

?>