
<?php
require 'connect.php';
$id = $_POST['extra_search'];
date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");

$output = '';
$query = "";

@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];
$query = "SELECT tb_stock_detail.stock_detail_id as stock_detail_id,
tb_stock_detail.stock_detail_status as stock_detail_status,
tb_stock_detail.stock_detail_date as stock_detail_date,
tb_stock_detail.stock_detail_amount as stock_detail_amount,
tb_grade.grade_id as grade_id,
tb_grade.grade_name as grade_name,
tb_plant.plant_name as plant_name


FROM tb_stock_detail
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_detail.ref_grade_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_detail.ref_plant_id

WHERE tb_plant.plant_id = '$id' AND tb_stock_detail.stock_detail_status ='ปกติ'

ORDER BY tb_stock_detail.stock_detail_id";


$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        if($permiss =="พนักงาน")
        {
            $hidden = "hidden";
        }else{
            $hidden ="";
        }

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['grade_name'];
        $subdata[] = number_format($row['stock_detail_amount']);
     
       
        $subdata[] = '
        <a href="#edit_stock_detail' . $row['stock_detail_id'] . '" data-toggle="modal" '.$hidden.'>
        <button type="button" class="btn btn-warning btn-sm"  id="btn_editstock_detail" data ="' . $row['stock_detail_id'] . '" data-amount ="' . $row['stock_detail_amount'] . '" data-grade ="' . $row['grade_id'] . '"
        data-toggle="tooltip"  title="ปรับปรุงจำนวนต้นไม้" ">
        <i  class="fas fa-edit" style="color:white"></i></button></a>';
        $rows[] = $subdata;

        $i++;
    }
    $json_data = array(

        "data" => $rows,
    );
    echo json_encode($json_data);
} else {
    $json_data = array(
       
        "data" => "",
    );
    echo json_encode($json_data);
}

?>
