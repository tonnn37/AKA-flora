<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

$d = date("Y-m-d");
?>

<?php
$id = $_POST['id'];
$edit_detail_drug = $_POST['edit_detail_drug'];
$edit_detail_amount = $_POST['edit_detail_amount'];
$edit_use_amount = $_POST['edit_use_amount'];
$edit_formula_price = $_POST['edit_formula_price'];

$d = date("Y-m-d");
$amount = str_replace(',','', $edit_detail_amount);
$use_amount = str_replace(',','', $edit_use_amount);
$price = str_replace(',','', $edit_formula_price);


$sql_formula_detail = "UPDATE tb_drug_formula_detail  
SET drug_formula_detail_amount='$amount', 
drug_formula_detail_amount_sm='$use_amount', 
drug_formula_detail_price='$price' , 
ref_drug_id = '$edit_detail_drug' ,update_by='$name',
update_at='$d' WHERE drug_formula_detail_id  ='$id'";

if(mysqli_query($conn, $sql_formula_detail)){
    echo $sql_formula_detail;
}else{
    echo mysqli_error($conn);

}
