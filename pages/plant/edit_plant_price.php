<?php
include('connect.php');

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
date_default_timezone_set("Asia/Bangkok");
$d = date("Y-m-d");

?>

<?php
$id = $_POST['id'];
$grade_id = $_POST['grade_id'];
$edit_grade_price = $_POST['edit_grade_price'];

$sql_edit_price = "UPDATE tb_plant_detail  
                SET plant_detail_price='$edit_grade_price' 
                ,update_by='$name'
                ,update_at='$d' 
                WHERE plant_detail_id ='$id' AND ref_grade_id ='$grade_id'";

if (mysqli_query($conn, $sql_edit_price)) {
    echo $sql_edit_price;
} else {
    echo mysqli_error($conn);
}


?>