<?php
include('connect.php');
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
date_default_timezone_set("Asia/Bangkok");
$d = date("Y-m-d");
$id=$_POST['id'];
$ref_drug_id = $_POST['add_detail_drug'];
$add_detail_drugamount = $_POST['add_detail_drugamount'];



$sql_drugdetail ="INSERT INTO tb_drug_detail (drug_detail_id,drug_detail_amount,drug_detail_status,created_by,created_at,update_by,update_at,ref_drug_id)
            VALUES('$id','$add_detail_drugamount','ปกติ','$name','$d','$name','$d','$ref_drug_id')";

if(mysqli_query($conn, $sql_drugdetail)){
    echo  $sql_drugdetail;
}else{
    echo mysqli_error($conn);

}

?>