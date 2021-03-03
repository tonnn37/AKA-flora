
<?php
require 'connect.php';

date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");


$id = $_POST['extra_search'];

$query = "SELECT tb_stock_recieve_detail.recieve_detail_id as recieve_detail_id,
                tb_stock_recieve_detail.recieve_detail_amount as recieve_detail_amount,
                tb_stock_recieve_detail.recieve_detail_status as recieve_detail_status,
                tb_grade.grade_name as grade_name
FROM tb_stock_recieve_detail
LEFT JOIN tb_stock_recieve ON tb_stock_recieve_detail.ref_stock_recieve_id = tb_stock_recieve.stock_recieve_id
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_recieve_detail.ref_grade_id
WHERE tb_stock_recieve_detail.ref_stock_recieve_id = '$id' AND (tb_stock_recieve_detail.recieve_detail_status ='เสร็จสิ้น' OR tb_stock_recieve_detail.recieve_detail_status ='ปกติ')
ORDER BY tb_stock_recieve_detail.recieve_detail_id ASC";


$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        $id = $row['recieve_detail_id'];
      
        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['grade_name'];
        $subdata[] = number_format($row['recieve_detail_amount']);
     
  

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
