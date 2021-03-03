<?php
require 'connect.php';
date_default_timezone_set("Asia/Bangkok");

$sql_week = "SELECT max(stock_detail_id) as Maxid  FROM tb_stock_detail";
$result_week = mysqli_query($conn, $sql_week);
$row_id = mysqli_fetch_assoc($result_week);
$old_id = $row_id['Maxid'];
$id_stock_detail = $old_id + 1;

$sql_recieve_detail = "SELECT max(recieve_detail_id) as Maxid  FROM tb_stock_recieve_detail";
$result_recieve_detail = mysqli_query($conn, $sql_recieve_detail);
$row_id = mysqli_fetch_assoc($result_recieve_detail);
$old_id = $row_id['Maxid'];
$id_recieve_detail = $old_id + 1;

?>
<?php
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$d = date("Y-m-d");

$in_stock_recieve_id = $_POST['in_stock_recieve_id'];
$ref_planting_id = $_POST['in_stock_recieve_planting'];
$ref_planting_detail_id = $_POST['in_stock_planting_detail'];
$in_stock_recieve_amount = $_POST['in_stock_recieve_amount'];

$amount = $_POST['amounts'];
$grade = $_POST["grade"];

$sql_plant = "SELECT tb_plant.plant_name as plant_name,
tb_plant.plant_id as plant_id

FROM tb_planting_detail
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_planting_detail.ref_plant_id
WHERE tb_plant.plant_status = 'ปกติ' AND tb_planting_detail.planting_detail_id ='$ref_planting_detail_id'";

$re_plant = mysqli_query($conn, $sql_plant);
$row_plant = mysqli_fetch_assoc($re_plant);
$plant_id = $row_plant['plant_id'];


$query = '';
$query2 = '';
for ($count = 0; $count < count($grade); $count++) {

    $grades = mysqli_real_escape_string($conn, $grade[$count]);
    $amounts = mysqli_real_escape_string($conn, $amount[$count]);

    /* เข้า Stock Detail */
    /* $sql_stock = "SELECT * FROM tb_stock_detail WHERE ref_plant_id='$plant_id'  
    AND ref_grade_id='$grades'AND stock_detail_status='ปกติ'";
    $result_stock = mysqli_query($conn, $sql_stock);

    if (mysqli_num_rows($result_stock) > 0) {
        $row_stock = mysqli_fetch_assoc($result_stock);
        $stock_detail_amount = $row_stock['stock_detail_amount'];
        $stock_detail_id = $row_stock['stock_detail_id'];

        $total = $stock_detail_amount + $amounts;
        $update_stock = "UPDATE tb_stock_detail SET stock_detail_amount ='$total',
            update_by ='$name',
            update_at ='$d'
           WHERE stock_detail_id='$stock_detail_id'";
        mysqli_query($conn, $update_stock);
    } else {

        $query = "INSERT INTO tb_stock_detail (stock_detail_id,stock_detail_amount,stock_detail_date,stock_detail_status,ref_plant_id,ref_grade_id,created_by, created_at, update_by, update_at) 
        VALUES ('$id_stock_detail','$amounts','$d','ปกติ','$plant_id','$grades','$name', '$d', '$name', '$d');";
        mysqli_query($conn, $query);
        $id_stock_detail++;
    } */

    /* เข้า Recieve Detail */
    $query2 = "INSERT INTO tb_stock_recieve_detail (recieve_detail_id,recieve_detail_amount,recieve_detail_status,ref_plant_id,ref_grade_id,ref_stock_recieve_id,created_by, created_at, update_by, update_at) 
                    VALUES ('$id_recieve_detail','$amounts','ปกติ','$plant_id','$grades', '$in_stock_recieve_id', '$name', '$d', '$name', '$d');";

    $id_recieve_detail++;

    mysqli_query($conn, $query2);
    echo $query2;
}

/* เข้า Recieve */
$sql_stock_recieve = "INSERT INTO tb_stock_recieve(stock_recieve_id,stock_recieve_amount,stock_recieve_date,stock_recieve_status,ref_planting_detail_id,created_by,created_at, update_by,update_at)
    VALUES ('$in_stock_recieve_id','$in_stock_recieve_amount','$d','ปกติ','$ref_planting_detail_id','$name', '$d', '$name', '$d');";

mysqli_query($conn, $sql_stock_recieve);

/* อัพเดท Planting_Detail */
$sql_update_planting_detail = "UPDATE tb_planting_detail SET planting_detail_status ='เสร็จสิ้น',
                                     update_by ='$name',
                                     update_at ='$d'
                                    WHERE planting_detail_id='$ref_planting_detail_id'";

mysqli_query($conn, $sql_update_planting_detail);


$sql_update_order_detail = "UPDATE tb_order_detail
                            INNER JOIN tb_planting_detail
                            ON (tb_order_detail.order_detail_id = tb_planting_detail.ref_order_detail_id)
                            SET tb_order_detail.order_detail_status = 'รอส่งมอบ',
                                tb_order_detail.update_by='$name',
                                tb_order_detail.update_at='$d'
                            WHERE tb_planting_detail.planting_detail_id='$ref_planting_detail_id' ";
mysqli_query($conn, $sql_update_order_detail);

$sql_update_order_detail2 = "UPDATE tb_order_detail
                            INNER JOIN tb_planting_detail
                            ON (tb_order_detail.order_detail_id = tb_planting_detail.ref_order_detail_id)
                            SET tb_order_detail.order_detail_planting_status = 'เสร็จสิ้น',
                                tb_order_detail.update_by='$name',
                                tb_order_detail.update_at='$d'
                            WHERE tb_planting_detail.planting_detail_id='$ref_planting_detail_id'";

mysqli_query($conn, $sql_update_order_detail2);

$sql_count2 = "SELECT COUNT(tb_planting_detail.planting_detail_id) as count ,(SELECT COUNT(tb_planting_detail.planting_detail_status )
FROM tb_planting_detail WHERE planting_detail_status ='เสร็จสิ้น' AND ref_planting_id = '$ref_planting_id' ) as count2
FROM tb_planting_detail WHERE tb_planting_detail.ref_planting_id='$ref_planting_id' ";

$re_count2 = mysqli_query($conn, $sql_count2);
$r_count2 = mysqli_fetch_assoc($re_count2);
$sum_order2 = $r_count2['count'];
$sum_status = $r_count2['count2'];
if ($sum_order2 == $sum_status) {

    $update_status = "UPDATE tb_planting  SET planting_status='เสร็จสิ้น' WHERE planting_id ='$ref_planting_id'";
    mysqli_query($conn, $update_status);
}

echo $query2;
echo $sql_stock_recieve;
echo $sql_update_planting_detail;
/* echo $query; */

/* echo $sql_stock; */
echo $sql_update_order_detail;
echo $sql_update_order_detail2;