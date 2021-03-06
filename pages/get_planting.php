
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
$status = $_POST['status'];
$planting = $_POST['planting'];
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
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    SUM(tb_planting_week_detail.week_detail_dead) AS SUM,  SUM(tb_planting_detail.planting_detail_total) AS SUM1, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE tb_planting.planting_date BETWEEN '$st_date' AND '$en_date'
    GROUP BY tb_planting_detail.ref_plant_id
    ORDER BY tb_planting_detail.ref_plant_id";
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    SUM(tb_planting_week_detail.week_detail_dead) AS SUM,  SUM(tb_planting_detail.planting_detail_total) AS SUM1, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE MONTH(tb_planting.planting_date)='$month' AND YEAR(tb_planting.planting_date)='$my'
    GROUP BY tb_planting_detail.ref_plant_id
    ORDER BY tb_planting_detail.ref_plant_id";
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    SUM(tb_planting_week_detail.week_detail_dead) AS SUM,  SUM(tb_planting_detail.planting_detail_total) AS SUM1, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE  YEAR(tb_planting.planting_date)='$year'
    GROUP BY tb_planting_detail.ref_plant_id
    ORDER BY tb_planting_detail.ref_plant_id";
} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    SUM(tb_planting_week_detail.week_detail_dead) AS SUM,  SUM(tb_planting_detail.planting_detail_total) AS SUM1, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_typeplant.type_plant_id='$type_plant'
    GROUP BY tb_planting_detail.ref_plant_id
    ORDER BY tb_planting_detail.ref_plant_id";
} else if ($select == 'status' && $status != '0') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    SUM(tb_planting_week_detail.week_detail_dead) AS SUM,  SUM(tb_planting_detail.planting_detail_total) AS SUM1, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE tb_planting_detail.planting_detail_status='$status'
    GROUP BY tb_planting_detail.ref_plant_id
    ORDER BY tb_planting_detail.ref_plant_id";
} else if ($select == 'planting' && $planting != '0') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    SUM(tb_planting_week_detail.week_detail_dead) AS SUM,  SUM(tb_planting_detail.planting_detail_total) AS SUM1, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE tb_order.order_name ='$planting'
    GROUP BY tb_planting_detail.ref_plant_id
    ORDER BY tb_planting_detail.ref_plant_id";
} else {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name, 
    SUM(tb_planting_week_detail.week_detail_dead) AS SUM,  SUM(tb_planting_detail.planting_detail_total) AS SUM1, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    GROUP BY tb_planting_detail.ref_plant_id
    ORDER BY tb_planting_detail.ref_plant_id";
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
