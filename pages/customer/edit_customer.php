<?php
include('connect.php');
date_default_timezone_set("Asia/Bangkok");

session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];


?>

<?php
$id = $_POST['id'];
$edit_customer_firstname = $_POST['edit_customer_firstname'];
$editcustomer_lastname = $_POST['editcustomer_lastname'];
$edit_gender = $_POST['edit_gender'];
$type_hand = $_POST['type_hand'];
$edit_customer_email = $_POST['edit_customer_email'];
$edit_customer_detail = $_POST['edit_customer_detail'];


$d = date("Y-m-d");


$sql_customer= "UPDATE tb_customer SET customer_firstname ='$edit_customer_firstname',
                                       customer_lastname = '$editcustomer_lastname',
                                       customer_gender = '$edit_gender',
                                       customer_handover_type = '$type_hand',
                                       customer_email ='$edit_customer_email',
                                       customer_detail ='$edit_customer_detail',

                                        update_by='$name',
                                        update_at='$d' 
                                        WHERE customer_id ='$id'";

if(mysqli_query($conn, $sql_customer)){
       echo $sql_customer;
}else{
    echo mysqli_error($conn);

}


?>