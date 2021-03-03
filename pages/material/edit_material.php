<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
$id = $_POST['id'];
$edit_type_material_name = $_POST['edit_type_material_name'];
$edit_unit_name = $_POST['edit_unit_name'];
$edit_material_name = $_POST['edit_material_name'];
$edit_material_price = $_POST['edit_material_price'];
$edit_material_amount = $_POST['edit_material_amount'];

$d = date("Y-m-d");


$sql_editmaterial = "UPDATE tb_material  SET ref_type_material='$edit_type_material_name',
                                            ref_drug_unit = '$edit_unit_name',
                                            material_name='$edit_material_name' ,
                                            material_price = '$edit_material_price',
                                            material_amount = '$edit_material_amount',
                                            update_by='$name',
                                            update_at='$d' 
                                            WHERE material_id ='$id'";

if(mysqli_query($conn, $sql_editmaterial)){
    echo $sql_editmaterial;

}else{
    echo mysqli_error($conn);

}


?>