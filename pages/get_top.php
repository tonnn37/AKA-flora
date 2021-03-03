
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
$type_plant= $_POST['type_plant'];  
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
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
FROM tb_order_detail
INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE tb_order.order_date BETWEEN '$st_date' AND '$en_date'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
FROM tb_order_detail
INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE MONTH(tb_order.order_date)='$month' AND YEAR(tb_order.order_date)='$my'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE  YEAR(tb_order.order_date)='$year'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";

} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
WHERE tb_typeplant.type_plant_id='$type_plant'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
} else {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
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
