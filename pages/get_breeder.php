
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
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    WHERE tb_stock_detail.stock_detail_date BETWEEN '$st_date' AND '$en_date'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";
    
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    WHERE MONTH(tb_stock_detail.stock_detail_date)='$month' AND YEAR(tb_stock_detail.stock_detail_date)='$my'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";
    
} else if ($select == 'year' && $year != "") {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id 
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    WHERE  YEAR(tb_stock_detail.stock_detail_date)='$year'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";
   
} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id 
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_typeplant.type_plant_id='$type_plant'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";
} else if ($select == 'plant' && $plant != '0') {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id 
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_plant.plant_id='$plant'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";

} else if ($select == 'grade' && $grade != '0') {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id 
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_grade.grade_id='$grade'
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";
  
} else {
    $query = "SELECT  tb_stock_detail.stock_detail_id AS stock_detail_id, tb_plant.plant_name AS plant_name,tb_grade.grade_name AS grade_name,tb_stock_detail.stock_detail_amount AS stock_detail_amount,tb_plant.plant_id as plant_id 
    FROM tb_stock_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_stock_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_stock_detail.ref_grade_id
    GROUP BY tb_stock_detail.stock_detail_id
    ORDER BY tb_stock_detail.ref_plant_id,tb_grade.grade_id ASC ";
    
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
