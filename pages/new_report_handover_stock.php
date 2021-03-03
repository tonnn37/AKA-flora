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
$customer = $_POST['customer'];
$handover = $_POST['handover'];
$sum = 0;
$sum1 = 0;
/* $IDS = 1; */
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
        $this->Cell(20, 10, iconv('UTF-8', 'cp874', 'ลำดับ'), 1, 0, 'C', true);
        $this->Cell(40, 10, iconv('UTF-8', 'cp874', 'รหัสการส่งมอบ'), 1, 0, 'C', true);
        $this->Cell(50, 10, iconv('UTF-8', 'cp874', 'ชื่อลูกค้า'), 1, 0, 'C', true);
        $this->Cell(40, 10, iconv('UTF-8', 'cp874', 'ชื่อพันธุ์ไม้'), 1, 0, 'C', true);
        $this->Cell(25, 10, iconv('UTF-8', 'cp874', 'เกรด'), 1, 0, 'C', true);
        $this->Cell(35, 10, iconv('UTF-8', 'cp874', 'วันที่ส่งมอบ'), 1, 0, 'C', true);
        $this->Cell(34, 10, iconv('UTF-8', 'cp874', 'จำนวนส่งมอบ (ต้น)'), 1, 0, 'C', true);
        $this->Cell(33, 10, iconv('UTF-8', 'cp874', 'จำนวนเงิน (บาท)'), 1, 0, 'C', true);

        if ($i != 0) {
            if ($i % 8 == 1) {
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
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
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
    $title = 'รายงานข้อมูลการส่งมอบ'  . " " . 'วันที่' . " " . DateThai1($st_date) . " ถึง " . DateThai1($en_date);
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
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
    $title = 'รายงานข้อมูลการส่งมอบ' . " " . 'เดือน' . month($month) . " " . 'ปี' . " " . year($my);
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
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
    $title = 'รายงานข้อมูลการส่งมอบ'  . " " . 'ประจำปี' . " " . ($year - 543 + 1086);
} else if ($select == 'type' && $customer != '0') {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
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
    $sql = "SELECT * FROM tb_customer WHERE customer_id='$customer'";
    $re_c = mysqli_query($conn, $sql);
    $row_c = mysqli_fetch_assoc($re_c);
    $title = 'รายงานข้อมูลการส่งมอบ'  . " " . 'ชื่อลูกค้า' . " " . $row_c['customer_firstname'] . " " . $row_c['customer_lastname'];
} else if ($select == 'handover' && $handover != '0') {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
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
    $sql = "SELECT * FROM tb_order WHERE order_name='$handover'";
    $re_p = mysqli_query($conn, $sql);
    $row_p = mysqli_fetch_assoc($re_p);
    $title = 'รายงานข้อมูลรายการส่งมอบ' . " " . 'ชื่อรายการส่งมอบ' . " " . $row_p['order_name'];
} else {
    $query = "SELECT tb_handover_noplant.handover_noplant_id AS handover_noplant_id, tb_handover_noplant.handover_noplant_date AS handover_noplant_date, tb_plant.plant_name AS plant_name,
    tb_customer.customer_firstname AS customer_firstname, tb_customer.customer_lastname AS customer_lastname,  tb_order.order_name AS order_name,  
    tb_grade.grade_name AS grade_name,tb_handover_noplant_detail.handover_noplant_detail_amount AS handover_noplant_detail_amount, SUM(tb_order.order_price) AS SUM
    FROM tb_handover_noplant
    INNER JOIN tb_order_detail ON tb_order_detail.order_detail_id=tb_handover_noplant.ref_order_detail_id
    INNER JOIN tb_order ON tb_order.order_id=tb_order_detail.ref_order_id
    INNER JOIN tb_customer ON tb_customer.customer_id=tb_order.order_customer
    INNER JOIN tb_handover_noplant_detail ON tb_handover_noplant_detail.ref_handover_noplant_id=tb_handover_noplant.handover_noplant_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_handover_noplant_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_handover_noplant_detail.ref_grade_id
    GROUP BY tb_handover_noplant.handover_noplant_id,tb_handover_noplant_detail.ref_grade_id
    ORDER BY tb_handover_noplant.handover_noplant_id,tb_grade.grade_id ASC";
    $title = 'รายงานข้อมูลการส่งมอบทั้งหมด';
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
    $id = $array['handover_noplant_id'];
    $fname = $array['plant_name'];
    $cname = $array['customer_firstname'];
    $lname = $array['customer_lastname'];
    $grade = $array['grade_name'];
    $date = $array['handover_noplant_date'];
    $amount   = $array['handover_noplant_detail_amount'];
    $price   = $array['SUM'];
    //แสดงค่าในไฟล์ PDF
    /*  if ($IDS == $id) {
        $ida = " ";
        $i2 = " ";
        $fname = " ";
        $cname = " ";
        $lname = " ";
    } else {
        $i2 = $i++;
        $ida = $id;
    } */

    $pdf->Cell(20, 10, iconv('UTF-8', 'cp874', $i), 1, 0, "C");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', $id), 1, 0, "C");
    $pdf->Cell(50, 10, iconv('UTF-8', 'cp874', $cname . " " . " " . " " . $lname), 1, 0, "C");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', $fname), 1, 0, "C");
    $pdf->Cell(25, 10, iconv('UTF-8', 'cp874', $grade), 1, 0, "C");
    $pdf->Cell(35, 10, iconv('UTF-8', 'cp874', $date), 1, 0, "C");
    $pdf->Cell(34, 10, iconv('UTF-8', 'cp874', number_format($amount)), 1, 0, "R");
    $pdf->Cell(33, 10, iconv('UTF-8', 'cp874', number_format($price, 2)), 1, 0, "R");
    $pdf->Ln();

    $sum += $amount;
    $sum1 += $price;
    /* $IDS =  $id; */
} //end while
$pdf->Cell(210, 10, iconv('UTF-8', 'cp874', "รวม"), 1, 0, "C");
$pdf->Cell(34, 10, iconv('UTF-8', 'cp874', number_format($sum, 2)), 1, 0, "R");
$pdf->Cell(33, 10, iconv('UTF-8', 'cp874', number_format($sum1, 2)), 1, 0, "R");
$pdf->ln();
$pdf->ln(3);

ob_end_clean();
$pdf->Output(); //คำสั่งแสดงผลลัพธ์
ob_end_flush(); //ปิด obj