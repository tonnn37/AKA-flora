<?php
//Run id
require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$drug_typeid = $_POST['drug_typeid'];
$drug_typestatus = $_POST['drug_typestatus'];


$d = date("Y-m-d");

if ($drug_typestatus =='ปกติ') {
    $sql_drugtype = "UPDATE tb_drug_type  SET drug_typestatus='ระงับ',update_by='$name',update_at='$d' WHERE drug_typeid ='$drug_typeid'";
}else{
    $sql_drugtype = "UPDATE tb_drug_type SET drug_typestatus='ปกติ',update_by='$name',update_at='$d' WHERE drug_typeid ='$drug_typeid'";
}
if(mysqli_query($conn, $sql_drugtype)){
       
}else{
    echo mysqli_error($conn);

}
    
?>