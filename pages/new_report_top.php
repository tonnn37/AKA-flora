<?php
require_once 'connect.php';
require 'fpdf181/fpdf.php';
session_start();


$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
date_default_timezone_set('Asia/Bangkok');
$st_date = $_POST['st_date'];
$en_date = $_POST['en_date'];
$month = $_POST['month'];
$my = $_POST['month_year'];
$year = $_POST['txt_year'];
$p_year = $year - 543;
$select = $_POST['type'];
$type_plant = $_POST['type_plant'];
$sum = 0;
$sum1 = 0;
$date = date("d-m-Y");
$time_report = date("H:i");
function DateThai1($start)
{
    $strYear = date("Y", strtotime($start)) + 543;
    $strMonth = date("m", strtotime($start));
    $strDay = date("d", strtotime($start));
    $show = $strDay . "/" . $strMonth . "/" . $strYear;
    return $show;
}
$st = DateThai1($date);
$sql = '';
class PDF extends FPDF
{
    //กำหนด header
    public function Header()
    {
        global $title, $list, $i, $st, $time_report, $name;
        $w = $this->GetStringWidth($title) + 8;
        //$this->SetX((210 - $w) / 2); //จัดกึ่งกลางห
        global $total_name;
        $this->SetLineWidth(1); //เส้นขอบ
        $this->AddFont('angsa', '', 'angsa.php');
        $this->SetFont('angsa', '', 15);
        $this->Image('../image/aka_logo.jpg', 10, 10, -300);
        $this->Ln(30);
        $this->Cell(10, 5, iconv('UTF-8', 'TIS-620', 'ธุรกิจการเกษตร AKA FLORA'), 0, 1);
        $this->Cell($w, 5, iconv('UTF-8', 'TIS-620', '375 หมู่ 2 ถนนประชาอุทิศ ซอยประชาอุทิศ 76 '), 0, 1, "");
        $this->Cell($w, 5, iconv('UTF-8', 'TIS-620', 'ตำบลบ้านคลองสวน อำเภอพระสมุทรเจดีย์ '), 0, 1, "");
        $this->Cell($w, 5, iconv('UTF-8', 'TIS-620', 'จังหวัดสมุทรปราการ 10290'), 0, 1, "");
        $this->Cell(10, 5, iconv('UTF-8', 'TIS-620', 'โทร. 094-494-5632 , 081-769-0081 '), 0, 1);
        $this->Cell(10, 5, iconv('UTF-8', 'TIS-620', 'EMAIL: AKAFLORATH@GMAIL.COM '), 0, 1);
        $this->Cell(180, 10, iconv('UTF-8', 'cp874', $title), 0, 0, 'C');
        $this->SetFillColor(51, 204, 102);
        $this->SetDrawColor(1, 1, 1);
        $this->Ln();
        $this->Cell(40, 5, iconv('UTF-8', 'cp874', 'วันที่พิมพ์ : ' . $st . " เวลา : " . $time_report), 0, 0, "C");
        $this->Cell(150, 10, iconv('UTF-8', 'TIS-620', 'ผู้ออกรายงาน : ' . $name), 0, 1, "R");
        $this->Ln(5);
        $this->Cell(20, 10, iconv('UTF-8', 'cp874', 'ลำดับ'), 1, 0, 'C', true);
        $this->Cell(40, 10, iconv('UTF-8', 'cp874', 'รหัสพันธุ์ไม้'), 1, 0, 'C', true);
        $this->Cell(50, 10, iconv('UTF-8', 'cp874', 'ชื่อ'), 1, 0, 'C', true);
        $this->Cell(40, 10, iconv('UTF-8', 'cp874', 'จำนวนการขาย (ครั้ง)'), 1, 0, 'C', true);
        $this->Cell(40, 10, iconv('UTF-8', 'cp874', 'จำนวนยอดขาย (ต้น)'), 1, 0, 'C', true);
        if ($i != 0) {
            if ($i % 17 == 1) {
                $this->Ln();
            }
        }
    }
    public function footer()
    {
        $this->AddFont('angsa', '', 'angsa.php');
        $this->SetY(-15); //ตำแหน่ง 1.5 ซม จากด้านล่าง
        $this->SetFont('angsa', '', 14);
        $this->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'หน้า ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }
}
function month($strDate)
{
    $strMonth = $strDate;
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    return " $strMonthThai";
}

function year($start)
{
    $strYear = date("Y", strtotime($start)) + 543;
    return $strYear;
}

if ($select == 'day' && $st_date != "" && $en_date != '') {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
FROM tb_order_detail
INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE tb_order.order_date BETWEEN '$st_date' AND '$en_date'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
 $title = 'รายงานข้อมูลยอดพันธุ์ไม้ขายดี' ." ". 'วันที่' ." ". DateThai1($st_date) . " ถึง " . DateThai1($en_date);
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
FROM tb_order_detail
INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE MONTH(tb_order.order_date)='$month' AND YEAR(tb_order.order_date)='$my'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
    $title = 'รายงานข้อมูลยอดพันธุ์ไม้ขายดี ' ." ". 'เดือน' . month($month)." ". 'ปี'. " " . year($my);
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE  YEAR(tb_order.order_date)='$year'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
    $title = 'รายงานข้อมูลยอดพันธุ์ไม้ขายดี ' ." ". 'ประจำปี'." ". ($year - 543 + 1086);
} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
WHERE tb_typeplant.type_plant_id='$type_plant'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
$sql = "SELECT * FROM tb_typeplant WHERE type_plant_id='$type_plant'";
$re_p = mysqli_query($conn, $sql);
$row_p = mysqli_fetch_assoc($re_p);
$title = 'รายงานข้อมูลยอดพันธุ์ไม้ขายดี' ." ". 'ประเภท' ." ". $row_p['type_plant_name'];
} else {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
    $title = 'รายงานข้อมูลยอดพันธุ์ไม้ขายดีทั้งหมด';
}

ob_end_clean();
ob_start();
$pdf = new PDF(); //สร้าง object pdf จากคลาส PDF
//กำหนดชื่อรายงาน
$pdf->AliasNbPages();
$pdf->SetTitle($title, true);

$pdf->AddPage();

//เพิ่ม font
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->SetFont('angsa', '', 15);

//เติมสี
$pdf->SetFillColor(51, 204, 102);
$pdf->SetDrawColor(1, 1, 1);


$pdf->Ln();

//run คำสั่ง sql
$result = mysqli_query($conn, $query);

//แสดงค่า
$i = 0;
while ($array = mysqli_fetch_assoc($result)) {
    $i++;
    $id = $array['plant_id'];
    $fname = $array['plant_name'];
    $count = $array['count_number'];
    $cost   = $array['SUM'];

    //แสดงค่าในไฟล์ PDF
    $pdf->Cell(20, 10, iconv('UTF-8', 'cp874', $i), 1, 0, "C");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', $id), 1, 0, "C");
    $pdf->Cell(50, 10, iconv('UTF-8', 'cp874', $fname), 1, 0, "C");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', $count), 1, 0, "R");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', number_format($cost) ), 1, 0, "R");
    $pdf->Ln();
    $sum+=$cost;
    $sum1+=$count;
} //end while
    $pdf->Cell(110, 10, iconv('UTF-8', 'cp874', "รวม"), 1, 0, "C");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', number_format($sum1)), 1, 0, "R");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', number_format($sum)), 1, 0, "R");
    $pdf->Ln();
$pdf->ln();
$pdf->ln(3);

ob_end_clean();
$pdf->Output(); //คำสั่งแสดงผลลัพธ์
ob_end_flush(); //ปิด obj



//แนวนอน

/* <?php
require_once 'connect.php';
require 'fpdf181/fpdf.php';
session_start();


$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
date_default_timezone_set('Asia/Bangkok');
$st_date = $_POST['st_date'];
$en_date = $_POST['en_date'];
$month = $_POST['month'];
$my = $_POST['month_year'];
$year = $_POST['txt_year'];
$p_year = $year - 543;
$select = $_POST['type'];
$type_plant = $_POST['type_plant'];
$sum = 0;
$sum1 = 0;
$date = date("d-m-Y");
$time_report = date("H:i");
function DateThai1($start)
{
    $strYear = date("Y", strtotime($start)) + 543;
    $strMonth = date("m", strtotime($start));
    $strDay = date("d", strtotime($start));
    $show = $strDay . "/" . $strMonth . "/" . $strYear;
    return $show;
}
$st = DateThai1($date);
$sql = '';
class PDF extends FPDF
{
    //กำหนด header
    public function Header()
    {
        global $title, $list, $i, $st, $time_report, $name;
        $w = $this->GetStringWidth($title) + 8;
        //$this->SetX((210 - $w) / 2); //จัดกึ่งกลางห
        global $total_name;
        $this->SetLineWidth(1); //เส้นขอบ
        $this->AddFont('angsa', '', 'angsa.php');
        $this->SetFont('angsa', '', 15);
        $this->Image('../image/aka_logo.jpg', 10, 10, -300);
        $this->Ln(30);
        $this->Cell(10, 5, iconv('UTF-8', 'TIS-620', 'ธุรกิจการเกษตร AKA FLORA'), 0, 1);
        $this->Cell($w, 5, iconv('UTF-8', 'TIS-620', '375 หมู่ 2 ถนนประชาอุทิศ ซอยประชาอุทิศ 76 '), 0, 1, "");
        $this->Cell($w, 5, iconv('UTF-8', 'TIS-620', 'ตำบลบ้านคลองสวน อำเภอพระสมุทรเจดีย์ '), 0, 1, "");
        $this->Cell($w, 5, iconv('UTF-8', 'TIS-620', 'จังหวัดสมุทรปราการ 10290'), 0, 1, "");
        $this->Cell(10, 5, iconv('UTF-8', 'TIS-620', 'โทร. 094-494-5632 , 081-769-0081 '), 0, 1);
        $this->Cell(10, 5, iconv('UTF-8', 'TIS-620', 'EMAIL: AKAFLORATH@GMAIL.COM '), 0, 1);
        $this->Cell(270, 10, iconv('UTF-8', 'cp874', $title), 0, 0, 'C');
        $this->SetFillColor(51, 204, 102);
        $this->SetDrawColor(1, 1, 1);
        $this->Ln();
        $this->Cell(50, 5, iconv('UTF-8', 'cp874', 'วันที่พิมพ์ : ' . $st . " เวลา : " . $time_report), 0, 0, "C");
        $this->Cell(228, 10, iconv('UTF-8', 'TIS-620', 'ผู้ออกรายงาน : ' . $name), 0, 1, "R");
        $this->Ln(5);
        $this->Cell(40);
        $this->Cell(20, 10, iconv('UTF-8', 'cp874', 'ลำดับ'), 1, 0, 'C', true);
        $this->Cell(40, 10, iconv('UTF-8', 'cp874', 'รหัสพันธุ์ไม้'), 1, 0, 'C', true);
        $this->Cell(50, 10, iconv('UTF-8', 'cp874', 'ชื่อ'), 1, 0, 'C', true);
        $this->Cell(40, 10, iconv('UTF-8', 'cp874', 'จำนวนการขาย (ครั้ง)'), 1, 0, 'C', true);
        $this->Cell(40, 10, iconv('UTF-8', 'cp874', 'จำนวนยอดขาย (ต้น)'), 1, 0, 'C', true);
        if ($i != 0) {
            if ($i % 7 == 1) {
                $this->Ln();
            }
        }
    }
    public function footer()
    {
        $this->AddFont('angsa', '', 'angsa.php');
        $this->SetY(-15); //ตำแหน่ง 1.5 ซม จากด้านล่าง
        $this->SetFont('angsa', '', 14);
        $this->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'หน้า ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }
}
function month($strDate)
{
    $strMonth = $strDate;
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    return " $strMonthThai";
}

function year($start)
{
    $strYear = date("Y", strtotime($start)) + 543;
    return $strYear;
}

if ($select == 'day' && $st_date != "" && $en_date != '') {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
FROM tb_order_detail
INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE tb_order.order_date BETWEEN '$st_date' AND '$en_date'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
 $title = 'รายงานข้อมูลยอดพันธุ์ไม้ขายดี' ." ". 'วันที่' ." ". DateThai1($st_date) . " ถึง " . DateThai1($en_date);
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
FROM tb_order_detail
INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE MONTH(tb_order.order_date)='$month' AND YEAR(tb_order.order_date)='$my'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
    $title = 'รายงานข้อมูลยอดพันธุ์ไม้ขายดี ' ." ". 'เดือน' . month($month)." ". 'ปี'. " " . year($my);
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
WHERE  YEAR(tb_order.order_date)='$year'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
    $title = 'รายงานข้อมูลยอดพันธุ์ไม้ขายดี ' ." ". 'ประจำปี'." ". ($year - 543 + 1086);
} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
WHERE tb_typeplant.type_plant_id='$type_plant'
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
$sql = "SELECT * FROM tb_typeplant WHERE type_plant_id='$type_plant'";
$re_p = mysqli_query($conn, $sql);
$row_p = mysqli_fetch_assoc($re_p);
$title = 'รายงานข้อมูลยอดพันธุ์ไม้ขายดี' ." ". 'ประเภท' ." ". $row_p['type_plant_name'];
} else {
    $query = "SELECT tb_plant.plant_id AS plant_id,tb_plant.plant_name AS plant_name,tb_order_detail.ref_plant_id AS ref_plant_id,COUNT(tb_order_detail.ref_plant_id ) AS count_number , SUM(tb_order_detail.order_detail_amount) AS SUM
    FROM tb_order_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_order_detail.ref_plant_id
GROUP BY tb_order_detail.ref_plant_id
ORDER BY SUM(tb_order_detail.order_detail_amount) DESC LIMIT 5";
    $title = 'รายงานข้อมูลยอดพันธุ์ไม้ขายดีทั้งหมด';
}

ob_end_clean();
ob_start();
$pdf = new PDF('L'); //สร้าง object pdf จากคลาส PDF
//กำหนดชื่อรายงาน
$pdf->AliasNbPages();
$pdf->SetTitle($title, true);

$pdf->AddPage();

//เพิ่ม font
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->SetFont('angsa', '', 15);

//เติมสี
$pdf->SetFillColor(51, 204, 102);
$pdf->SetDrawColor(1, 1, 1);


$pdf->Ln();

//run คำสั่ง sql
$result = mysqli_query($conn, $query);

//แสดงค่า
$i = 0;
while ($array = mysqli_fetch_assoc($result)) {
    $i++;
    $id = $array['plant_id'];
    $fname = $array['plant_name'];
    $count = $array['count_number'];
    $cost   = $array['SUM'];

    //แสดงค่าในไฟล์ PDF
    $pdf->Cell(40);
    $pdf->Cell(20, 10, iconv('UTF-8', 'cp874', $i), 1, 0, "C");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', $id), 1, 0, "C");
    $pdf->Cell(50, 10, iconv('UTF-8', 'cp874', $fname), 1, 0, "C");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', $count), 1, 0, "R");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', number_format($cost) ), 1, 0, "R");
    $pdf->Ln();
    $sum+=$cost;
    $sum1+=$count;
} //end while
    $pdf->Cell(40);
    $pdf->Cell(110, 10, iconv('UTF-8', 'cp874', "รวม"), 1, 0, "C");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', number_format($sum1)), 1, 0, "R");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', number_format($sum)), 1, 0, "R");
    $pdf->Ln();
$pdf->ln();
$pdf->ln(3);

ob_end_clean();
$pdf->Output(); //คำสั่งแสดงผลลัพธ์
ob_end_flush(); //ปิด obj
 */