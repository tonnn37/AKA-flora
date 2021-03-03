<?php
 //รหัสหน่วยยา

 include('connect.php');
 date_default_timezone_set("Asia/Bangkok");

?>

<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");

$in_grade_id = $_POST['in_grade_id'];
$in_grade_name = $_POST['in_grade_name'];

$sql_grade = "INSERT INTO tb_grade  
            (grade_id,grade_name,grade_status,created_by,created_at,update_by,update_at)
            VALUES('$in_grade_id','$in_grade_name','ปกติ','$name','$d','$name','$d')";


if (mysqli_query($conn, $sql_grade)) {

    echo  $sql_grade;
}