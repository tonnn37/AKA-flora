
<?php
require 'connect.php';


date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");

$output = '';
$query = "";


$query = "SELECT tb_plant.plant_name as plant_name
                ,tb_plant.plant_id as plant_id
          
FROM tb_stock_detail
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_stock_detail.ref_plant_id
WHERE stock_detail_status ='ปกติ'
GROUP BY ref_plant_id
ORDER BY tb_stock_detail.stock_detail_id ASC";


$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        $plant_id = $row['plant_id'];

        $sql_amount = "SELECT SUM(tb_stock_detail.stock_detail_amount) as amount FROM tb_stock_detail  WHERE tb_stock_detail.ref_plant_id ='$plant_id' AND tb_stock_detail.stock_detail_status ='ปกติ' ";
        $re_amount = mysqli_query($conn, $sql_amount);
        $r_amount = mysqli_fetch_assoc($re_amount);
        $sum_amount = $r_amount['amount'];

        if ($sum_amount == "") {
            $sum_amount = 0;
        }

     
           
      
        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['plant_name'];
        $subdata[] = number_format($sum_amount);

        $subdata[] = '
       
        <a href="#view_stock_detail" data-toggle="modal">
        <button type="button" class="btn btn-info btn-sm" id="btn_viewstock_detail" data ="' . $row['plant_id'] . '"
        data-name="' . $row['plant_name'] . '" data-toggle="tooltip"  title="แสดงรายละเอียด" ">
        <i  class="fas fa-list-ol" style="color:white"></i></button>';
        
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
