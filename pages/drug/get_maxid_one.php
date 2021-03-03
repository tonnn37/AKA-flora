<?php
require 'connect.php';

$id_drug = $_POST['id'];
$sql = "SELECT max(drug_detail_id) as Maxid  FROM tb_drug_detail  WHERE ref_drug_id ='$id_drug'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
//echo $sql;
if (mysqli_num_rows($result)>0) {
    echo $row['Maxid'];
} else {
    echo "";
}