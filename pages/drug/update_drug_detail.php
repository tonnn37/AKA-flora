<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

$d = date("Y-m-d");
?>

<?php
$edit_detail_id = $_POST['id'];
$edit_detail_drug = $_POST['edit_detail_drug'];
$edit_detail_amount = $_POST['edit_detail_amount'];
$edit_detail_size = $_POST['edit_detail_size'];


$sql_detaildrug = "UPDATE tb_drug_detail  SET drug_detail_amount='$edit_detail_amount' , 
                                                ref_drug_id = '$edit_detail_drug' , 
                                                detail_size = '$edit_detail_size',
                                                update_by='$name',
                                                update_at='$d' 
                                                WHERE drug_detail_id  ='$edit_detail_id'";

if(mysqli_query($conn, $sql_detaildrug)){
    echo $sql_detaildrug;
}else{
    echo mysqli_error($conn);

}
