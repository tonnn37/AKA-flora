<?php
require 'connect.php';
$id = $_POST['id_plant'];

$sql = "SELECT plant_time FROM tb_plant WHERE plant_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
//echo $sql;
if (mysqli_num_rows($result)>0) {
    echo $row['plant_time']* 7;
} else {
    echo "";
}
?>