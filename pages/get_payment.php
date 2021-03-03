
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
$plant = $_POST['plant'];
$grade = $_POST['grade'];
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
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    SUM(tb_payment_detail.payment_detail_amount) AS SUM, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_payment.payment_date BETWEEN '$st_date' AND '$en_date'
    GROUP BY tb_plant.plant_name
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    SUM(tb_payment_detail.payment_detail_amount) AS SUM, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE MONTH(tb_payment.payment_date)='$month' AND YEAR(tb_payment.payment_date)='$my'
    GROUP BY tb_plant.plant_name
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    
} else if ($select == 'year' && $year != "") {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    SUM(tb_payment_detail.payment_detail_amount) AS SUM, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE  YEAR(tb_payment.payment_date)='$year'
    GROUP BY tb_plant.plant_name
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
   
} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    SUM(tb_payment_detail.payment_detail_amount) AS SUM, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_typeplant.type_plant_id='$type_plant'
    GROUP BY tb_plant.plant_name
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
  
} else if ($select == 'plant' && $plant != '0') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    SUM(tb_payment_detail.payment_detail_amount) AS SUM, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_plant.plant_id='$plant'
    GROUP BY tb_plant.plant_name
    ORDER BY tb_payment_detail.payment_detail_id ASC ";

} else if ($select == 'grade' && $grade != '0') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    SUM(tb_payment_detail.payment_detail_amount) AS SUM, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_grade.grade_id='$grade'
    GROUP BY tb_plant.plant_name
    ORDER BY tb_payment_detail.payment_detail_id ASC ";

} else {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    SUM(tb_payment_detail.payment_detail_amount) AS SUM, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    GROUP BY tb_plant.plant_name
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    
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
