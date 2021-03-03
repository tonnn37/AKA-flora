<?php
//fetch.php
require('connect.php');
$output = '';
$select = $_POST['select'];
$date_new = $_POST['date'];
$month = $_POST['month'];
$my = $_POST['month_year'];
$year = $_POST['year'];
$customer = $_POST['customer']; 

 if ($select == "day" && $date_new != "") {
    $query = "SELECT tb_order.order_customer AS order_customer,tb_order_detail.order_detail_amount AS order_detail_amount , COUNT(tb_order_detail.ref_order_id ) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE  tb_order.order_date='$date_new'
GROUP BY tb_order.order_customer
ORDER BY COUNT(tb_order_detail.ref_order_id) DESC LIMIT 5";
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_order.order_customer AS order_customer,tb_order_detail.order_detail_amount AS order_detail_amount , COUNT(tb_order_detail.ref_order_id ) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE MONTH(tb_order.order_date)='$month' AND YEAR(tb_order.order_date)='$my'
GROUP BY tb_order.order_customer
ORDER BY COUNT(tb_order_detail.ref_order_id) DESC LIMIT 5";
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_order.order_customer AS order_customer,tb_order_detail.order_detail_amount AS order_detail_amount , COUNT(tb_order_detail.ref_order_id ) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    WHERE  YEAR(tb_order.order_date)='$year'
GROUP BY tb_order.order_customer
ORDER BY COUNT(tb_order_detail.ref_order_id) DESC LIMIT 5";
} else if ($select == 'type' && $customer != '0') {
    $query = "SELECT tb_order.order_customer AS order_customer,tb_order_detail.order_detail_amount AS order_detail_amount , COUNT(tb_order_detail.ref_order_id ) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE tb_order.order_id='$customer'
GROUP BY tb_order.order_customer
ORDER BY COUNT(tb_order_detail.ref_order_id) DESC LIMIT 5";
} else {
    $query = "SELECT tb_order.order_customer AS order_customer,tb_order_detail.order_detail_amount AS order_detail_amount , COUNT(tb_order_detail.ref_order_id ) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
GROUP BY tb_order.order_customer
ORDER BY COUNT(tb_order_detail.ref_order_id) DESC LIMIT 5";
} 




$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $output .= '
    <div class="table-responsive">
   <table class="table table bordered text-center" id="chart" width = "100%">
  
 ';
 foreach ($result as $row) {

    $output .= '
   <tr>
   <td width="5%" class="order_customer">' . $row["order_customer"] . '</td>
   <td width="5%" class="count_number">' . $row["count_number"] . '</td>
   </tr>
   
  ';
    }
    $output .= '</table>';
    echo $output;
} else {
    echo '<center>ไม่พบข้อมูล</center>';
}
