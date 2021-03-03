<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

?>

<?php
$id = $_POST['id'];
$edit_grade_name = $_POST['edit_grade_name'];


$d = date("Y-m-d");


$sql_edit_grade = "UPDATE tb_grade  SET grade_name='$edit_grade_name',update_by='$name',update_at='$d' WHERE grade_id ='$id'";

if(mysqli_query($conn, $sql_edit_grade)){
    echo $sql_edit_grade;

}else{
    echo mysqli_error($conn);

}


?>