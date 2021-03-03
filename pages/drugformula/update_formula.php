<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

$d = date("Y-m-d");
?>

<?php
$id = $_POST['id'];
$edit_formula_name = $_POST['edit_formula_name'];
$edit_formula_amount = $_POST['edit_formula_amount'];

$d = date("Y-m-d");


$sql_formula = "UPDATE tb_drug_formula  SET drug_formula_name='$edit_formula_name',drug_formula_amount ='$edit_formula_amount' ,update_by ='$name',update_at ='$d' WHERE drug_formula_id  ='$id'";

if(mysqli_query($conn, $sql_formula)){
    echo "บันทึกสำเร็จ";
}else{
    echo mysqli_error($conn);

}
