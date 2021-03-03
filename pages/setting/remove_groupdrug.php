<?php
//Run id
require('connect.php');
date_default_timezone_set("Asia/Bangkok");
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>
<?php
$group_drug_id = $_POST['group_drug_id'];
$group_drug_status = $_POST['group_drug_status'];


$d = date("Y-m-d");

if ($group_drug_status =='ปกติ') {
    $sql_groupdrug = "UPDATE tb_group_drug  SET group_drug_status='ระงับ',update_by='$name',update_at='$d' WHERE group_drug_id ='$group_drug_id'";
}else{
    $sql_groupdrug = "UPDATE tb_group_drug SET group_drug_status='ปกติ',update_by='$name',update_at='$d' WHERE group_drug_id ='$group_drug_id'";
}
if(mysqli_query($conn, $sql_groupdrug)){
       
}else{
    echo mysqli_error($conn);

}
    
?>