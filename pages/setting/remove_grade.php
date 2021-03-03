<?php
//Run id
require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$grade_id = $_POST['grade_id'];
$grade_status = $_POST['grade_status'];

$d = date("Y-m-d");

if ($grade_status =='ปกติ') {
    $sql_grade = "UPDATE tb_grade  SET grade_status ='ระงับ',update_by='$name',update_at='$d' WHERE grade_id ='$grade_id'";
}else{
    $sql_grade = "UPDATE tb_grade  SET grade_status ='ปกติ',update_by='$name',update_at='$d' WHERE grade_id ='$grade_id'";
}
if(mysqli_query($conn, $sql_grade)){
       
}else{
    echo mysqli_error($conn);

}
    
?>