
<?php
require 'connect.php';

date_default_timezone_set("Asia/Bangkok");
$date1 = date("Y-m-d");

$output = '';
$query = "";


$query = "SELECT tb_customer.customer_id as customer_id,
tb_customer.customer_firstname as customer_firstname,
tb_customer.customer_lastname as customer_lastname,
tb_customer.customer_gender as customer_gender,
tb_customer.customer_email as customer_email,
tb_customer.customer_detail as customer_detail,
tb_customer.customer_status as customer_status,
tb_customer.customer_handover_type as customer_handover_type
FROM tb_customer
ORDER BY tb_customer.customer_id ASC";



$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {

        $id = $row['customer_id'];

        if ($row['customer_detail'] == "") {
            $row['customer_detail'] = "-";
        } else {
            $row['customer_detail'];
        }

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['customer_id'];
        $subdata[] = $row['customer_firstname'] . " " . $row['customer_lastname'];
        $subdata[] = $row['customer_gender'];
        $subdata[] = $row['customer_email'];
        $subdata[] = $row['customer_handover_type'];
        $subdata[] = $row['customer_detail'];
        $subdata[] = $row['customer_status'];

        if ($row['customer_status'] == 'ปกติ') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "";
            $modal = "modal";
        } else {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $disabled = "disabled";
            $modal = "";
        }


        $subdata[] = '
        <a href="#modal_edit_customer' . $row['customer_id'] . '" data-toggle="' . $modal . '" class="' . $disabled . '" >
        <button type="button" class="btn btn-warning btn-sm"  id="btn_edit_customers"  data ="' . $row['customer_id'] . '"
        data-status="' . $row['customer_status'] . '"  data-name="' . $row['customer_firstname'] . '"
        data-toggle="tooltip"  title="แก้ไขข้อมูล"' . $disabled . ' ">

        <i  class="fas fa-edit" style="color:white"></i></button></a>' . '
        <button type="button" class="' . $color . '"  id="btn_remove_customer" data="' . $row['customer_id'] . '"data-status="' . $row['customer_status'] . '"  data-firstname="' . $row['customer_firstname'] . '" data-lastname="' . $row['customer_lastname'] . '" 
        data-toggle="tooltip"  title="' . $txt . '" ">
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
