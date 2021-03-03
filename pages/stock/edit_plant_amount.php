<?php
include('connect.php');

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
date_default_timezone_set("Asia/Bangkok");
$d = date("Y-m-d");

?>

<?php
$id = $_POST['id'];
$edit_detail_grade = $_POST['edit_detail_grade'];
$edit_detail_amount = $_POST['edit_detail_amount'];



$sql_edit_amount = "UPDATE tb_stock_detail  
                SET stock_detail_amount='$edit_detail_amount' 
                ,update_by='$name'
                ,update_at='$d' 
                WHERE stock_detail_id ='$id' AND ref_grade_id ='$edit_detail_grade'";

if (mysqli_query($conn, $sql_edit_amount)) {
    echo $sql_edit_amount;
} else {
    echo mysqli_error($conn);
}

?>