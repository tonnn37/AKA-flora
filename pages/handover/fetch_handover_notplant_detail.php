
<?php
require 'connect.php';

date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");

$query = "";

$id = $_POST['extra_search'];

$query = "SELECT tb_handover_noplant_detail.handover_noplant_detail_id as handover_noplant_detail_id,
tb_grade.grade_name as grade_name,
tb_grade.grade_id as grade_id,
tb_handover_noplant_detail.handover_noplant_detail_amount as handover_noplant_detail_amount,
tb_handover_noplant_detail.handover_noplant_detail_status as handover_noplant_detail_status


FROM tb_handover_noplant_detail
LEFT JOIN tb_handover_noplant ON tb_handover_noplant.handover_noplant_id = tb_handover_noplant_detail.ref_handover_noplant_id
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_handover_noplant_detail.ref_grade_id
WHERE tb_handover_noplant_detail.ref_handover_noplant_id ='$id'
ORDER BY tb_handover_noplant_detail.handover_noplant_detail_id ASC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        $ids = $row['handover_noplant_detail_id'];

       

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['grade_name'];
        $subdata[] = number_format($row['handover_noplant_detail_amount']);
   

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
