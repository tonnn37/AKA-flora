
<?php
require 'connect.php';

$output = '';
$id = $_POST['id'];

$sql_grade = "SELECT * FROM tb_grade WHERE grade_status ='ปกติ' AND grade_id NOT IN (SELECT ref_grade_id FROM tb_plant_detail WHERE ref_plant_id ='$id')  GROUP BY grade_id";
$results = mysqli_query($conn, $sql_grade);
$i = 0;
if (mysqli_num_rows($results) > 0) {

    echo 1;

} else {

    echo 0;
}
