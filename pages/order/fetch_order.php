
<?php
//fetch.php
require 'connect.php';
$output = '';
$query = "";


date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");

function CalDate($time1, $time2)
{
    $time1 = strtotime($time1);
    $time2 = strtotime($time2);

    $distanceInSeconds = round(abs($time2 - $time1)); //จะได้เป็นวินาที
    $distanceInMinutes = round($distanceInSeconds / 60); //แปลงจากวินาทีเป็นนาที

    $day = floor(abs($distanceInMinutes / 1440));

    return $day;
}

$sql = "SELECT tb_order.order_id as order_id, tb_order.order_name as order_name,
tb_order.order_date as order_date,tb_order.order_status as order_status,tb_order.order_detail as order_detail,
tb_order.order_customer as order_customer , tb_order.order_price as order_price,
tb_customer.customer_firstname as customer_firstname, tb_customer.customer_lastname as customer_lastname, tb_customer.customer_id as customer_id,
tb_plant.plant_time as plant_time,
tb_order_detail.order_detail_id as order_detail_id
FROM tb_order
LEFT JOIN tb_order_detail ON tb_order_detail.ref_order_id = tb_order.order_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
WHERE (tb_order_detail.order_detail_status ='ปกติ' OR tb_order_detail.order_detail_status ='รอส่งมอบ' OR tb_order_detail.order_detail_status ='ระงับ')
GROUP BY order_id 
ORDER BY tb_order.order_id DESC";

$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {

        $i++;

        $order_id = $row['order_id'];
        $order_detail = $row['order_detail'];
        if($order_detail == ""){
            $order_detail = "-";
        }else{
            $order_detail = $order_detail;
        }

        $sql_count = "SELECT COUNT(tb_order_detail.order_detail_id) as count FROM tb_order_detail WHERE tb_order_detail.ref_order_id='$order_id'  ";
        $re_count = mysqli_query($conn, $sql_count);
        $r_count = mysqli_fetch_assoc($re_count);
        $sum_order = $r_count['count'];

        if ($sum_order == "") {
            $sum_order = 0;
        }

        
        $sql_count2 = "SELECT COUNT(tb_order_detail.order_detail_id) as count ,(SELECT COUNT(tb_order_detail.order_detail_status )
        FROM tb_order_detail WHERE order_detail_status ='เสร็จสิ้น' AND ref_order_id = '$order_id' ) as count2
        FROM tb_order_detail WHERE tb_order_detail.ref_order_id='$order_id'";

        $re_count2 = mysqli_query($conn, $sql_count2);
        $r_count2 = mysqli_fetch_assoc($re_count2);
        $sum_order2 = $r_count2['count'];
        $sum_status = $r_count2['count2'];
        if ($sum_order2 == $sum_status) {

            $update_status = "UPDATE tb_order  SET order_status='เสร็จสิ้น' WHERE order_id ='$order_id'";
            mysqli_query($conn, $update_status);
        }else{
            $update_status = "UPDATE tb_order  SET order_status='ปกติ' WHERE order_id ='$order_id'";
            mysqli_query($conn, $update_status);
        }
        
        $day = date("d-m-Y",strtotime($row['order_date']));
     

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['order_id'];
        $subdata[] = $row['order_name'];
        $subdata[] = $row['customer_firstname'] . " " . $row['customer_lastname'];
        $subdata[] =  number_format($row['order_price']);
        $subdata[] = $sum_order;
        $subdata[] = $order_detail;
        $subdata[] = $day;
        $subdata[] = $row['order_status'];

        if ($row['order_status'] == 'ปกติ') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $modal = "modal";
            $disabled = "";
            $disabled2 = "";
        } else if ($row['order_status'] == 'ระงับ') {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $modal = "";
            $disabled = "";
            $disabled2 = "disabled";
        } else if ($row['order_status'] == 'รอส่งมอบ') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "disabled";
            $modal = "modal";
            $disabled2 = "disabled";
        } else {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "disabled";
            $modal = "";
            $disabled2 = "disabled";
        }

        /* <a href="#add_orders'.$row['order_id'].'" data-toggle="modal">
        <button type="button" class="btn btn-success btn-sm"  id="btn_add_orders" data ="' . $row['order_id'] . '" 
        data-toggle="tooltip"  title="เพิ่มรายการสั่งซื้อเพิ่มเติม" ' . $disabled . '' . $disabled2 . '>
        <i  class="fas fa-plus" style="color:white "></i></button></a>' . ' */

        $subdata[] = '
      
        
        <a href="#edit_orders' . $row['order_id'] . '" data-toggle="' . $modal . '">
        <button type="button" class="btn btn-warning btn-sm" id="btn_edit_orders" data="' . $row['order_id'] . '" 
        data-toggle="tooltip"  title="แก้ไขข้อมูล" ' . $disabled . ' ' . $disabled2 . '>
            <i class="fas fa-edit" style="color:white"></i></button></a>' . '

            <a href="#view_dialog" data-toggle="modal">
            <button type="button" class="btn btn-info btn-sm"  id="btn_viewdialog" data-id ="' . $row['order_id'] . '"
            data-customer ="' . $row['customer_firstname'] . ''." ".''.$row['customer_lastname'] .'"
            data-toggle="tooltip"  title="แสดงรายละเอียด">
            <i  class="fas fa-list-ol" style="color:white"></i></button></a>' . '

        <button type="button" class="' . $color . '"   id="btn_remove_order" data="' . $row['order_id'] . '"data-status="' . $row['order_status'] . '"  data-name="' . $row['order_name'] . '" 
        data-order="' . $row['order_detail_id'] . '" data-toggle="tooltip"  title="' . $txt . '" ' . $disabled . '>
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
