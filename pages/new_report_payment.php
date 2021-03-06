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
$plant = $_POST['plant'];
$grade = $_POST['grade'];
$date = date("d-m-Y");
$sum =0;
$sum1 =0;
$IDS = 1;
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
        $this->Cell(40, 10, iconv('UTF-8', 'cp874', 'รหัสรายการ'), 1, 0, 'C', true);
        $this->Cell(45, 10, iconv('UTF-8', 'cp874', 'ชื่อพันธุ์ไม้'), 1, 0, 'C', true);
        $this->Cell(22, 10, iconv('UTF-8', 'cp874', 'เกรด '), 1, 0, 'C', true);
        $this->Cell(35, 10, iconv('UTF-8', 'cp874', 'ราคา (บาท / ต้น) '), 1, 0, 'C', true);
        $this->Cell(45, 10, iconv('UTF-8', 'cp874', 'วันที่บันทึก '), 1, 0, 'C', true);
        $this->Cell(35, 10, iconv('UTF-8', 'cp874', 'จำนวน (ต้น)'), 1, 0, 'C', true);
        $this->Cell(35, 10, iconv('UTF-8', 'cp874', 'จำนวนเงิน (บาท)'), 1, 0, 'C', true);


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
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND tb_payment.payment_date BETWEEN '$st_date' AND '$en_date')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    $title = 'รายงานข้อมูลลูกค้า walk - in' ." ". 'วันที่' ." ". DateThai1($st_date) . " ถึง " . DateThai1($en_date);
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND MONTH(tb_payment.payment_date)='$month' AND YEAR(tb_payment.payment_date)='$my')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    $title = 'รายงานข้อมูลลูกค้า walk - in' ." ". 'เดือน' . month($month)." ". 'ปี'. " " . year($my);
} else if ($select == 'year' && $year != "") {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE  (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND YEAR(tb_payment.payment_date)='$year')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    $title = 'รายงานข้อมูลลูกค้า walk - in' ." ". 'ประจำปี'." ". ($year - 543 + 1086);
} else if ($select == 'type' && $type_plant != '0') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND tb_typeplant.type_plant_id='$type_plant')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    $sql = "SELECT * FROM tb_typeplant WHERE type_plant_id='$type_plant'";
    $re_p = mysqli_query($conn, $sql);
    $row_p = mysqli_fetch_assoc($re_p);
    $title = 'รายงานข้อมูลลูกค้า walk - in' . " " . 'ประเภทพันธุ์ไม้' . " " . $row_p['type_plant_name'];
} else if ($select == 'plant' && $plant != '0') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE  (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND tb_plant.plant_id='$plant')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    $sql = "SELECT * FROM tb_plant WHERE plant_id='$plant'";
    $re_p = mysqli_query($conn, $sql);
    $row_p = mysqli_fetch_assoc($re_p);
    $title = 'รายงานข้อมูลลูกค้า walk - in' . " " . 'ชื่อพันธุ์ไม้' . " " . $row_p['plant_name'];

} else if ($select == 'grade' && $grade != '0') {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE (tb_payment_detail.payment_detail_status ='เสร็จสิ้น' AND  tb_grade.grade_id='$grade')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    $sql = "SELECT * FROM tb_grade WHERE grade_id='$grade'";
    $re_p = mysqli_query($conn, $sql);
    $row_p = mysqli_fetch_assoc($re_p);
    $title = 'รายงานข้อมูลลูกค้า walk - in' . " " . 'เกรด' . " " . $row_p['grade_name']; 
  
} else {
    $query = "SELECT  tb_payment.payment_id AS payment_id, tb_plant.plant_name AS plant_name, tb_plant_detail.plant_detail_price AS plant_detail_price, tb_grade.grade_name AS grade_name, tb_payment.payment_date AS payment_date,
    tb_payment_detail.payment_detail_amount AS payment_detail_amount, tb_payment_detail.payment_detail_total AS payment_detail_total
    FROM tb_payment_detail
    INNER JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
    INNER JOIN tb_grade ON tb_grade.grade_id=tb_payment_detail.ref_grade_id
    INNER JOIN tb_plant_detail ON tb_plant_detail.ref_grade_id=tb_grade.grade_id
    INNER JOIN tb_typeplant ON tb_typeplant.type_plant_id = tb_plant.ref_type_plant
    WHERE (tb_payment_detail.payment_detail_status ='เสร็จสิ้น')
    GROUP BY tb_payment_detail.payment_detail_id
    ORDER BY tb_payment_detail.payment_detail_id ASC ";
    $title = 'รายงานข้อมูลลูกค้า walk - in ทั้งหมด';
}

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
$i = 1;
while ($array = mysqli_fetch_assoc($result)) {

    $id = $array['payment_id'];
    $pname = $array['plant_name'];
    $grade = $array['grade_name'];
    $price = $array['plant_detail_price'];
    $date = date("d-m-Y",strtotime($array['payment_date']));
    $amount = $array['payment_detail_amount'];
    $totalprice = $array['payment_detail_total'];
    //แสดงค่าในไฟล์ PDF
    if ($IDS == $id) {
        $ida = " ";
        $i2 = " ";
    } else {
        $i2 = $i++;
        $ida = $id;
    }

    $pdf->Cell(20, 10, iconv('UTF-8', 'cp874', $i2), 1, 0, "C");
    $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', $ida), 1, 0, "C");
    $pdf->Cell(45, 10, iconv('UTF-8', 'cp874', $pname), 1, 0, "C");
    $pdf->Cell(22, 10, iconv('UTF-8', 'cp874', $grade), 1, 0, "C");
    $pdf->Cell(35, 10, iconv('UTF-8', 'cp874',  number_format($price,2)), 1, 0, "R");
    $pdf->Cell(45, 10, iconv('UTF-8', 'cp874', $date), 1, 0, "C");
    $pdf->Cell(35, 10, iconv('UTF-8', 'cp874',  number_format($amount)), 1, 0, "R");
    $pdf->Cell(35, 10, iconv('UTF-8', 'cp874',  number_format($totalprice,2)), 1, 0, "R");
    $pdf->Ln();
    $sum += $amount;
    $sum1 += $price;
    $IDS =  $id;
} //end while
$pdf->Cell(207, 10, iconv('UTF-8', 'cp874', "รวม"), 1, 0, "C");
$pdf->Cell(35, 10, iconv('UTF-8', 'cp874', number_format($sum)), 1, 0, "R");
$pdf->Cell(35, 10, iconv('UTF-8', 'cp874', number_format($sum1,2)), 1, 0, "R");
$pdf->ln();
$pdf->ln(3);

ob_end_clean();
$pdf->Output(); //คำสั่งแสดงผลลัพธ์
ob_end_flush(); //ปิด obj