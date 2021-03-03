
<?php
require 'connect.php';

date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");

$query = "";

$id = $_POST['extra_search'];

$query = "SELECT tb_stock_handover_detail.handover_detail_id as handover_detail_id,
tb_grade.grade_name as grade_name,
tb_grade.grade_id as grade_id,
tb_stock_handover_detail.handover_detail_amount as handover_detail_amount,
tb_stock_handover_detail.handover_detail_status as handover_detail_status


FROM tb_stock_handover_detail
LEFT JOIN tb_stock_handover ON tb_stock_handover.handover_id = tb_stock_handover_detail.ref_handover_id
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_handover_detail.ref_grade_id
WHERE tb_stock_handover_detail.ref_handover_id ='$id'
ORDER BY tb_stock_handover_detail.handover_detail_id ASC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        $ids = $row['handover_detail_id'];

       

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['grade_name'];
        $subdata[] = number_format($row['handover_detail_amount']);
        $subdata[] = $row['handover_detail_status'];

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
