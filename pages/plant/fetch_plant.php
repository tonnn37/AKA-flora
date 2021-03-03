
<?php
require 'connect.php';

date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");

$query = "";

$query = "SELECT  tb_plant.plant_id as plant_id,
tb_plant.plant_name as plant_name,
tb_plant.plant_time as plant_time,
tb_plant.plant_detail as plant_detail,
tb_plant.plant_status as plant_status,
tb_plant.picture as pic,
tb_typeplant.type_plant_name as type_plant_name

FROM tb_plant 
LEFT JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
ORDER BY tb_plant.plant_id ASC";

$result = mysqli_query($conn, $query);
if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $i++;
        $subdata = array();
        $plant_id = $row['plant_id'];
        $plant_name = $row['plant_name'];
        $plant_time = $row['plant_time'];
        $plant_detail = $row['plant_detail'];
        $plant_status = $row['plant_status'];
        $type_plant_name = $row['type_plant_name'];

        $sql2 = "SELECT * FROM tb_order_detail
        INNER JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
        
        WHERE tb_order_detail.ref_plant_id = '$plant_id' AND (tb_order_detail.order_detail_status='ปกติ' OR tb_order_detail.order_detail_status ='รอส่งมอบ')
        GROUP BY tb_plant.plant_id";
        $res = mysqli_query($conn, $sql2);
        $rows2 = mysqli_fetch_assoc($res);
        if ($rows2 = $res->num_rows > 0) {
            $disabled2 = "disabled";
        } else {
            $disabled2 = "";
        }

        $sql3 = "SELECT ref_plant_id FROM tb_stock_detail
        WHERE stock_detail_status ='ปกติ' AND ref_plant_id = '$plant_id'
        GROUP BY ref_plant_id";
        $result2 = mysqli_query($conn,$sql3);
        $row3 = mysqli_fetch_assoc($result2);
        
        if ($row3 = $result2->num_rows >0){
            $disabled3 = "disabled";
        }else{
            $disabled3 = "";
        }

        $subdata[] = $i;
        $subdata[] = $row['plant_id'];
        $subdata[] = $row['type_plant_name'];
        $subdata[] = $row['plant_name'];
        $subdata[] = $row['plant_time'];
        $subdata[] = $row['plant_status'];

           if ($row['plant_status'] == 'ปกติ') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $txt2 = "แสดงรายละเอียด";
            $disabled = "";
            $modal = "modal";
        } else if ($row['plant_status'] == 'ระงับ') {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $txt2 = "แสดงรายละเอียด";
            $disabled = "disabled";
            $modal ="";
        }
        
        $subdata[] = '
        <a href="#adds'.$row['plant_id'].'" data-toggle="'.$modal.'">
        <button type="button" class="btn btn-success btn-sm"  id="add_plant2" data ="' . $row['plant_id'] . '"
        data-toggle="tooltip"  title="เพิ่มเกรดและราคา" '.$disabled.' >
        <i  class="fas fa-plus" style="color:white "></i></button></a>' . '
       
        <a href="#view'.$row['plant_id'].'" data-toggle="'.$modal.'">
        <button type="button" class="btn btn-sm" style="background-color:#FFCC00;" id="view_plant" data ="' . $row['plant_id'] . '"
        data-toggle="tooltip"  title="แสดงข้อมูลพันธุ์ไม้" >
        <i  class="fas fa-search-plus" style="color:black" ></i></button></a>' . '

        <a href="#edit'.$row['plant_id'].'" data-toggle="'.$modal.'">
        <button type="button" class="btn btn-warning btn-sm"  id="edit_plant" data ="' . $row['plant_id'] . '"
        data-toggle="tooltip"  title="แก้ไขข้อมูลพันธุ์ไม้" '.$disabled.'>
        <i  class="fas fa-edit" style="color:white"></i></button></a>' . '

        <a href="#detail_plants" data-toggle="modal">
        <button type="button" class="btn btn-info btn-sm"  id="detail_plant" data ="' . $row['plant_id'] . '" data-name ="'.$row['plant_name'].'"
        data-toggle="tooltip"  title="' . $txt2 . '">
        <i  class="fas fa-list-ol" style="color:white"></i></button></a>' . '

        <button type="button" class="' . $color . '"   id="btn_remove_plant" data="' . $row['plant_id'] . '"data-status="' . $row['plant_status'] . '"  data-name="' . $row['plant_name'] . '" 
        data-toggle="tooltip"  title="' . $txt . '" '.$disabled2.' '.$disabled3.'>
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
