
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
$customer= $_POST['customer'];  
$handover= $_POST['handover'];  
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
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,SUM(tb_handover_noplant_detail.handover_noplant_detail_amount) AS SUM1, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    WHERE tb_handover_noplant.handover_noplant_date BETWEEN '$st_date' AND '$en_date'
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
  
   
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name, SUM(tb_handover_noplant_detail.handover_noplant_detail_amount) AS SUM1, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    WHERE MONTH(tb_handover_noplant.handover_noplant_date)='$month' AND YEAR(tb_handover_noplant.handover_noplant_date)='$my'
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
  
   
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name, SUM(tb_handover_noplant_detail.handover_noplant_detail_amount) AS SUM1, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    WHERE  YEAR(tb_handover_noplant.handover_noplant_date)='$year'
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
  
    
} else if ($select == 'type' && $customer != '0') {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name, SUM(tb_handover_noplant_detail.handover_noplant_detail_amount) AS SUM1, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    WHERE tb_customer.customer_id='$customer'
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
  
   
} else if ($select == 'handover' && $handover != '0') {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name, SUM(tb_handover_noplant_detail.handover_noplant_detail_amount) AS SUM1, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    WHERE tb_order.order_name ='$handover'
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
   
} else {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name, SUM(tb_handover_noplant_detail.handover_noplant_detail_amount) AS SUM1, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
  
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
