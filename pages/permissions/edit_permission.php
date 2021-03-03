<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");
mysqli_query($object->connect, 'set names utf8');
session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
$username = $_POST['empid'];
$userlevel = $_POST['userlevel'];

$d = date("Y-m-d");


$sql_permission = "UPDATE tb_user_detail  SET userlevel='$userlevel',update_by='$name',update_at='$d' WHERE username ='$username'";

if(mysqli_query($conn, $sql_permission)){
       echo $sql_permission;
}else{
    echo mysqli_error($conn);

}


?>