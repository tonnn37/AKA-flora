<?php
include('connect.php');

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
date_default_timezone_set("Asia/Bangkok");
$d = date("Y-m-d");

?>

<?php
$id = $_POST['id'];
$grade_id = $_POST['grade'];
$grade_amount = $_POST['amount'];

$sql_edit_amount ='';
for ($count = 0; $count < count($grade_id); $count++) {

    $grade_ids = mysqli_real_escape_string($conn, $grade_id[$count]);
    $grade_amounts = mysqli_real_escape_string($conn, $grade_amount[$count]);

    
    $sql_edit_amount = "UPDATE tb_stock_recieve_detail  
                SET recieve_detail_amount='$grade_amounts' 
                ,update_by='$name'
                ,update_at='$d' 
                WHERE ref_grade_id ='$grade_ids'";

                mysqli_query($conn, $sql_edit_amount);
                echo $sql_edit_amount;
}




?>