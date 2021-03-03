
<?php
require 'connect.php';

date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");

$query = "";
$id = $_POST['extra_search'];



$query = "SELECT tb_plant_detail.plant_detail_id as plant_detail_id,
tb_plant_detail.plant_detail_price as plant_detail_price,
tb_plant_detail.plant_detail_status as plant_detail_status,
tb_grade.grade_name as grade_name

FROM tb_plant_detail
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_plant_detail.ref_plant_id
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_plant_detail.ref_grade_id
WHERE tb_plant_detail.ref_plant_id = '$id'
ORDER BY tb_plant_detail.plant_detail_id ASC";

$result = mysqli_query($conn, $query);
if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $i++;

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['grade_name'];
        $subdata[] = number_format($row['plant_detail_price'],2);
        $subdata[] = $row['plant_detail_status'];
        

        if ($row['plant_detail_status'] == 'ปกติ') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $txt2 = "แสดงรายละเอียด";
            $disabled = "";
            $modal ="modal";
        } else if ($row['plant_detail_status'] == 'ระงับ') {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $txt2 = "แสดงรายละเอียด";
            $disabled = "disabled";
            $modal = "";
        }

        $subdata[] = '
        <a href="#edit_detail' . $row['plant_detail_id'] . '" data-toggle="'.$modal.'">
        <button type="button" class="btn btn-warning btn-sm"  id="reset_edit_detail" data ="' . $row['plant_detail_id'] . '"
        data-toggle="tooltip"  title="แก้ไขราคาพันธุ์ไม้" '.$disabled.'>
        <i  class="fas fa-edit" style="color:white"></i></button></a>' . '

        <button type="button" class="' . $color . '"  id="btn_remove_plant_detail" data="' . $row['plant_detail_id'] . '"data-status="' . $row['plant_detail_status'] . '"  data-name="' . $row['grade_name'] . '" 
        data-toggle="tooltip"  title="' . $txt . '">
        <i  class="' . $image . '" style="color:white"></i></button>';

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
