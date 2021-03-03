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
$status = $_POST['status'];
$planting = $_POST['planting'];
$sum = 0;
$sum1 = 0;
$sum2 = 0;
$sum3 = 0;
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
        $w = $this->GetStringWidth($title) +8;
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
        $this->Cell(20, 10, iconv('UTF-8', 'cp874', 'ลำดับ'), 1, 0, 'C', true);
        $this->Cell(50, 10, iconv('UTF-8', 'cp874', 'ชื่อพันธุ์ไม้'), 1, 0, 'C', true);
        $this->Cell(45, 10, iconv('UTF-8', 'cp874', 'วันที่เริ่มปลูก'), 1, 0, 'C', true);
        $this->Cell(35, 10, iconv('UTF-8', 'cp874', 'สัปดาห์'), 1, 0, 'C', true);
        $this->Cell(42, 10, iconv('UTF-8', 'cp874', 'จำนวนต้น'), 1, 0, 'C', true);
        $this->Cell(42, 10, iconv('UTF-8', 'cp874', 'จำนวนต้นตาย'), 1, 0, 'C', true);
        $this->Cell(43, 10, iconv('UTF-8', 'cp874', 'จำนวนคงเหลือ'), 1, 0, 'C', true);
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
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE tb_planting.planting_date BETWEEN '$st_date' AND '$en_date'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $title = 'รายงานข้อมูลรายการปลูก' . " " . 'วันที่' . " " . DateThai1($st_date) . " ถึง " . DateThai1($en_date);
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE MONTH(tb_planting.planting_date)='$month' AND YEAR(tb_planting.planting_date)='$my'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $title = 'รายงานข้อมูลรายการปลูก' . " " . 'เดือน' . month($month) . " " . 'ปี' . " " . year($my);
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE  YEAR(tb_planting.planting_date)='$year'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $title = 'รายงานข้อมูลรายการปลูก' . " " . 'ประจำปี' . " " . ($year - 543 + 1086);
} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE tb_typeplant.type_plant_id='$type_plant'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $sql = "SELECT * FROM tb_typeplant WHERE type_plant_id='$type_plant'";
    $re_p = mysqli_query($conn, $sql);
    $row_p = mysqli_fetch_assoc($re_p);
    $title = 'รายงานข้อมูลรายการปลูก' . " " . 'ประเภท' . " " . $row_p['type_plant_name'];
} else if ($select == 'status' && $status != '0') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE tb_planting_detail.planting_detail_status='$status'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $sql = "SELECT * FROM tb_planting_detail WHERE planting_detail_status='$status'";
    $re_p = mysqli_query($conn, $sql);
    $row_p = mysqli_fetch_assoc($re_p);
    $title = 'รายงานข้อมูลรายการปลูก' . " " . 'สถานะ' . " " . $row_p['planting_detail_status'];
} else if ($select == 'planting' && $planting != '0') {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    WHERE tb_order.order_name ='$planting'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $sql = "SELECT * FROM tb_order WHERE order_name='$planting'";
    $re_p = mysqli_query($conn, $sql);
    $row_p = mysqli_fetch_assoc($re_p);
    $title = 'รายงานข้อมูลรายการปลูก' . " " . 'ชื่อรายการปลูก' . " " . $row_p['order_name'];
} else {
    $query = "SELECT tb_planting_detail.planting_detail_id AS planting_detail_id, tb_planting.planting_date AS planting_date, tb_order.order_name AS order_name, tb_plant.plant_time AS plant_time,tb_plant.plant_name AS plant_name,
    tb_planting_detail.planting_detail_total AS planting_detail_total , SUM(tb_planting_week_detail.week_detail_dead) AS SUM, MAX(tb_planting_week.planting_week_count) AS MAX
    FROM tb_planting_detail
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_planting_week ON tb_planting_week.ref_planting_detail_id=tb_planting_detail.planting_detail_id
    INNER JOIN tb_planting_week_detail ON tb_planting_week_detail.ref_planting_week_id=tb_planting_week.planting_week_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $title = 'รายงานข้อมูลรายการปลูกทั้งหมด';
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
    $date = date("d-m-Y",strtotime($array['planting_date']));
    $pname = $array['plant_name'];
    $time = $array['plant_time'];
    $total = $array['planting_detail_total'];
    $week = $array['MAX'];
    $dead   = $array['SUM'];
    $sum2 = $total - $dead;

    //แสดงค่าในไฟล์ PDF
 
    $pdf->Cell(20, 10, iconv('UTF-8', 'cp874', $i), 1, 0, "C");
    $pdf->Cell(50, 10, iconv('UTF-8', 'cp874', $pname), 1, 0, "C");
    $pdf->Cell(45, 10, iconv('UTF-8', 'cp874', $date), 1, 0, "C");
    $pdf->Cell(35, 10, iconv('UTF-8', 'cp874', $week." / ". $time), 1, 0, "C");
    $pdf->Cell(42, 10, iconv('UTF-8', 'cp874', number_format($total)), 1, 0, "R");
    $pdf->Cell(42, 10, iconv('UTF-8', 'cp874', number_format($dead)), 1, 0, "R");
    $pdf->Cell(43, 10, iconv('UTF-8', 'cp874', number_format($sum2)), 1, 0, "R");
    $pdf->Ln();
    $sum += $dead;
    $sum1 += $total;
    $sum3 += $sum2;
} //end while

$pdf->Cell(150, 10, iconv('UTF-8', 'cp874', "รวม"), 1, 0, "C");
$pdf->Cell(42, 10, iconv('UTF-8', 'cp874', number_format($sum1)), 1, 0, "R");
$pdf->Cell(42, 10, iconv('UTF-8', 'cp874', number_format($sum)), 1, 0, "R");
$pdf->Cell(43, 10, iconv('UTF-8', 'cp874', number_format($sum3)), 1, 0, "R");


$pdf->ln();
$pdf->ln(3);
ob_end_clean();
$pdf->Output(); //คำสั่งแสดงผลลัพธ์
ob_end_flush(); //ปิด obj