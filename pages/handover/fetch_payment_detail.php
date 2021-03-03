
<?php

require 'connect.php';
date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");

$id = $_POST['extra_search'];

$query = "SELECT tb_payment_detail.payment_detail_id as payment_detail_id
,tb_plant.plant_name as plant_name
,tb_grade.grade_name as grade_name
,tb_plant_detail.plant_detail_price as plant_detail_price
,tb_payment_detail.payment_detail_amount as payment_detail_amount
,tb_payment_detail.payment_detail_total as payment_detail_total

FROM tb_payment_detail
LEFT JOIN tb_payment ON tb_payment.payment_id = tb_payment_detail.ref_payment_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_payment_detail.ref_plant_id
LEFT JOIN tb_plant_detail ON tb_plant_detail.ref_plant_id = tb_plant.plant_id
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_plant_detail.ref_grade_id
WHERE tb_payment_detail.ref_payment_id = '$id' AND tb_grade.grade_id = tb_payment_detail.ref_grade_id 
ORDER BY tb_payment_detail.payment_detail_id ASC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
       
        $id = $row['payment_detail_id'];

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['plant_name'];
        $subdata[] = $row['grade_name'];
        $subdata[] = number_format($row['payment_detail_amount']);
        $subdata[] = number_format($row['plant_detail_price'],2 );
        $subdata[] = number_format($row['payment_detail_total'],2);
       /*  $subdata[] = $row['payment_detail_status'];
  
         if ($row['payment_detail_status'] == 'เสร็จสิ้น') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "";
        } else {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $disabled = "";
        } 

        $subdata[] = '
        <button type="button" class="' . $color . '"  id="btn_remove_payment_detail" data="' . $row['payment_detail_id'] . '"data-status="' . $row['payment_detail_status'] . '"  
        data-grade="' . $row['grade_name'] . '" data-plant ="' . $row['plant_name'] . '" 
        data-toggle="tooltip"  title="' . $txt . '" ">
        <i  class="' . $image . '" style="color:white"></i></button>'; */

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
