
<?php
//fetch.php
require 'connect.php';
$output = '';
$query = "";

@session_start();
$permiss = $_SESSION['userlevel'];
$empid = $_SESSION["emp_id"];
if ($permiss == "พนักงาน") {
    $hidden = "hidden";
    $dis = "disabled";
} else {
    $hidden = "";
    $dis = "";
}
$sql = "SELECT tb_planting.planting_id as planting_id, tb_planting.planting_status as planting_status, tb_planting.ref_order_id as ref_order_id,tb_planting.planting_date as planting_date
,tb_order_detail.order_detail_id as order_detail_id
,tb_order.order_id as order_id, tb_order.order_name as order_name ,tb_order.order_customer as order_customer ,tb_order.order_detail as order_detail
,tb_planting_detail.planting_detail_id as planting_detail_id
,tb_planting_detail.planting_detail_status as planting_detail_status
,tb_customer.customer_firstname as customer_firstname , tb_customer.customer_lastname as customer_lastname  

FROM tb_planting
LEFT JOIN tb_order ON tb_order.order_id = tb_planting.ref_order_id
LEFT JOIN tb_customer ON tb_customer.customer_id = tb_order.order_customer
LEFT JOIN tb_order_detail ON tb_order_detail.ref_order_id = tb_order.order_id
LEFT JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
LEFT JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id = tb_planting_detail.planting_detail_id
WHERE  tb_planting.planting_status = 'ปกติ'
GROUP BY planting_id
ORDER BY planting_id DESC";

$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {


        $planting_id = $row['planting_id'];
        $planting_date = $row['planting_date'];
        $planting_status = $row['planting_status'];

        $planting_detail_id = $row['planting_detail_id'];

        $order_id = $row['order_id'];
        $order_name = $row['order_name'];
        $order_customer = $row['customer_firstname'] . " " . $row['customer_lastname'];
        $order_detail = $row['order_detail'];

        $sql_count_week = "SELECT COUNT(tb_planting_week.ref_planting_detail_id) as count FROM tb_planting_week 
        INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
        INNER JOIN tb_planting ON tb_planting.planting_id = tb_planting_detail.ref_planting_id
        WHERE  tb_planting_week.planting_week_status ='เสร็จสิ้น' AND (tb_planting_detail.planting_detail_status ='ปกติ' OR tb_planting_detail.planting_detail_status ='รอคัดเกรด')
        AND tb_planting.planting_id = '$planting_id' AND tb_planting_detail.planting_detail_id = '$planting_detail_id'";

        $re_count_week = mysqli_query($conn, $sql_count_week);
        $r_count_week = mysqli_fetch_assoc($re_count_week);
        $count_week = $r_count_week['count'];

        $sql_count = "SELECT COUNT(tb_planting_detail.planting_detail_id) as count FROM tb_planting_detail WHERE tb_planting_detail.ref_planting_id='$planting_id' ";
        $re_count = mysqli_query($conn, $sql_count);
        $r_count = mysqli_fetch_assoc($re_count);
        $sum_order = $r_count['count'];

        if ($sum_order == "") {
            $sum_order = 0;
        }

        $sql_price1 = "SELECT SUM(tb_planting_week_detail.formula_price) as count FROM tb_planting
                        INNER JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
                        INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id =  tb_planting_detail.planting_detail_id
                        INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
                        WHERE  tb_planting.planting_id ='$planting_id' AND tb_planting_detail.planting_detail_status !='ระงับ' ";

        $re_price1 = mysqli_query($conn, $sql_price1);
        $r_price1 = mysqli_fetch_assoc($re_price1);
        $sum_price1 = $r_price1['count'];
        $sum_price1 = round($sum_price1, 0);
        $sum_price1 = intval($sum_price1);

        if ($sum_price1 == "") {
            $sum_price1 = 0;
        }


        $sql_price2 = "SELECT SUM(tb_planting_week_detail.material_price) as count FROM tb_planting
                    INNER JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
                    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id =  tb_planting_detail.planting_detail_id
                    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
                    WHERE  tb_planting.planting_id ='$planting_id' AND (tb_planting_detail.planting_detail_status ='ปกติ' OR tb_planting_detail.planting_detail_status ='รอคัดเกรด')";

        $re_price2 = mysqli_query($conn, $sql_price2);
        $r_price2 = mysqli_fetch_assoc($re_price2);
        $sum_price2 = $r_price2['count'];
        $sum_price2 = round($sum_price2, 0);
        $sum_price2 = intval($sum_price2);

        if ($sum_price2 == "") {
            $sum_price2 = 0;
        }

        $total_price = $sum_price1 + $sum_price2;
        $total_price = number_format($total_price, 2);

        $sql_dead = "SELECT SUM(tb_planting_week_detail.week_detail_dead) as dead FROM tb_planting
        INNER JOIN tb_planting_detail ON tb_planting_detail.ref_planting_id = tb_planting.planting_id
        INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id =  tb_planting_detail.planting_detail_id
        INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id = tb_planting_week.planting_week_id
        WHERE  tb_planting.planting_id ='$planting_id' AND tb_planting_week_detail.week_detail_status ='ปกติ'";
        $re_dead = mysqli_query($conn, $sql_dead);
        $r_dead = mysqli_fetch_assoc($re_dead);
        $sum_dead = $r_dead['dead'];


        if ($sum_dead == "") {
            $sum_dead = 0;
        }

        $sql_count2 = "SELECT COUNT(tb_planting_detail.planting_detail_id) as count ,(SELECT COUNT(tb_planting_detail.planting_detail_status )
        FROM tb_planting_detail WHERE planting_detail_status ='เสร็จสิ้น' AND ref_planting_id = '$planting_id' ) as count2
        FROM tb_planting_detail WHERE tb_planting_detail.ref_planting_id='$planting_id' ";

        $re_count2 = mysqli_query($conn, $sql_count2);
        $r_count2 = mysqli_fetch_assoc($re_count2);
        $sum_order2 = $r_count2['count'];
        $sum_status = $r_count2['count2'];
        if ($sum_order2 == $sum_status) {

            $update_status = "UPDATE tb_planting  SET planting_status='เสร็จสิ้น' WHERE planting_id ='$planting_id'";
            mysqli_query($conn, $update_status);
        }

        $day = date("d-m-Y", strtotime($row['planting_date']));

        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['planting_id'];
        $subdata[] = $row['order_name'];
        $subdata[] = $order_customer;
        $subdata[] = $sum_order . " " . "รายการ";
        $subdata[] = $sum_dead;
        $subdata[] = $total_price;
        $subdata[] =  $day;
        $subdata[] = $row['planting_status'];




        if ($row['planting_status'] == 'ปกติ' && $count_week == "0") {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "";
        } else if ($row['planting_status'] == 'ระงับ') {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
            $disabled = "";
        } else {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
            $disabled = "disabled";
        }

        $subdata[] = '
        <a href="#add_planting_details' . $row['planting_id'] . '" data-toggle="modal" ' . $hidden . '>
        <button type="button" class="btn btn-success btn-sm"  id="btn_add_planting_details" data ="' . $row['planting_id'] . '"  data-order ="' . $row['order_id'] . '"
        data-toggle="tooltip"  title="เพิ่มรายการปลูกเพิ่มเติม"">
        <i  class="fas fa-plus" style="color:white "></i></button></a>' . '

        <a href="#view_dialog" data-toggle="modal">
        <button type="button" class="btn btn-info btn-sm"  id="btn_viewdialog" data ="' . $row['planting_id'] . '"
        data-order="' . $row['order_name'] . '"  data-name="' . $row['customer_firstname'] . '" data-lastname="' . $row['customer_lastname'] . '"
        data-order-id="' . $row['order_id'] . '"
        data-toggle="tooltip"  title="แสดงรายละเอียด">
        <i  class="fas fa-list-ol" style="color:white"></i></button></a>' . '

        <button type="button" class="' . $color . '"  id="btn_remove_planting" data="' . $row['planting_id'] . '"data-status="' . $row['planting_status'] . '"  data-name="' . $row['order_name'] . '" 
        data-order="' . $row['order_detail_id'] . '" data-toggle="tooltip"  title="' . $txt . '" ' . $disabled . ' ' . $hidden . '>
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
