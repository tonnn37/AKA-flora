
<?php

/**
 * filename: data.php
 * description: this will return the score of the teams.
 */

$select = $_POST['select'];
$st_date = $_POST['st_date'];
$en_date = $_POST['en_date'];
$month = $_POST['month'];
$my=$_POST['month_year'];
$year = $_POST['year'];
$customer = $_POST['customer'];
$status = $_POST['status'];
//setting header to json
header('Content-Type: application/json');

//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'db_ntk');
//get connection
$mysqli = new mysqli (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$mysqli->set_charset("utf8");
if (!$mysqli) {
    die("Connection failed: " . $mysqli->error);
}
if ($select == 'day' && $st_date != "" && $en_date != '') {
    $query = "SELECT tb_order.order_customer AS order_customer,tb_order_detail.order_detail_amount AS order_detail_amount , tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname, COUNT(tb_order.order_id ) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id=tb_order.order_id
WHERE  tb_order.order_date BETWEEN '$st_date' AND '$en_date'
GROUP BY tb_customer.customer_id
ORDER BY tb_order.order_id";
    
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_order.order_customer AS order_customer,tb_order_detail.order_detail_amount AS order_detail_amount , tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname, COUNT(tb_order.order_id ) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id=tb_order.order_id
WHERE MONTH(tb_order.order_date)='$month' AND YEAR(tb_order.order_date)='$my'
GROUP BY tb_customer.customer_id
ORDER BY tb_order.order_id";
    
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_order.order_customer AS order_customer,tb_order_detail.order_detail_amount AS order_detail_amount , tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname, COUNT(tb_order.order_id ) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id=tb_order.order_id
    WHERE  YEAR(tb_order.order_date)='$year'
    GROUP BY tb_customer.customer_id
ORDER BY tb_order.order_id";

} else if ($select == 'type' && $customer != '0') {
    $query = "SELECT tb_order.order_customer AS order_customer,tb_order_detail.order_detail_amount AS order_detail_amount , tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname, COUNT(tb_order.order_id ) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id=tb_order.order_id
WHERE tb_customer.customer_id='$customer'
GROUP BY tb_customer.customer_id
ORDER BY tb_order.order_id";
  
} else {
    $query = "SELECT tb_order.order_customer AS order_customer,tb_order_detail.order_detail_amount AS order_detail_amount , tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname, COUNT(tb_order.order_id ) AS count_number , SUM(tb_order.order_price) AS SUM
    FROM tb_order
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_order_detail ON tb_order_detail.ref_order_id=tb_order.order_id
GROUP BY tb_customer.customer_id
ORDER BY tb_order.order_id";
  
}
//query to get data from the table


//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);
