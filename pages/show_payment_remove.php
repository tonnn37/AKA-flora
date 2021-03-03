<?php
require 'fpdf181/fpdf.php';
require 'connect.php';
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

//---

date_default_timezone_set("Asia/Bangkok");

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    if ($strDay < 10) {
        $strDay = "0" . $strDay;

    }
    if($strMonth < 10){
    $strMonth = "0" . $strMonth;

    }
    return "$strDay/$strMonth/$strYear $strHour:$strMinute";
}
$datenow = date("Y-m-d H:i");

class myPDF extends FPDF
{
    public function header()
    {
        $this->AddFont('angsa', '', 'angsa.php');
        $this->SetFont('angsa', '', 14);
        //$this->Image('logo-1.png',10,10);
        //$this->Image('logo-1.png', 10, 6, 30);
        $this->Cell(90, 5, iconv('UTF-8', 'TIS-620', 'ธุรกิจการเกษตร AKA FLORA'), 0, 1, "C");
        $this->Cell(90, 5, iconv('UTF-8', 'TIS-620', '375 หมู่ 2 ถนนประชาอุทิศ ซอยประชาอุทิศ 76'), 0, 1, "C");
        $this->Cell(90, 5, iconv('UTF-8', 'TIS-620', 'ตำบลบ้านคลองสวน อำเภอพระสมุทรเจดีย์'), 0, 1, "C");
        $this->Cell(90, 5, iconv('UTF-8', 'TIS-620', 'จังหวัดสมุทรปราการ 10290'), 0, 1, "C");
        $this->Cell(90, 5, iconv('UTF-8', 'TIS-620', 'โทร. 080-5579464'), 0, 1, "C");
        $this->Cell(90, 5, iconv('UTF-8', 'TIS-620', 'ใบเสร็จยกเลิกรับเงิน / ใบกำกับภาษีอย่างย่อ'), 0, 1, "C");

    }
    public function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->AddFont('angsa', '', 'angsa.php');
        $this->SetFont('angsa', '', 14);

    }
}
$payment_id = $_POST['remove_payment_id'];

$pdf = new myPDF('P', 'mm', array(200, 105));
$pdf->AliasNbPages();
$pdf->SetTitle('ใบเสร็จยกเลิกรับเงิน / ใบกำกับภาษีอย่างย่อ', true);

$pdf->addPage();
$pdf->Ln();

//$pdf->Cell(100, 10, iconv('UTF-8', 'TIS-620', 'รายละเอียด'), 0, 0, "C");
$pdf->Cell(62, 2, iconv('UTF-8', 'TIS-620', 'เลขที่ใบเสร็จ : ' . $payment_id), 0, 0);
$pdf->Cell(10, 2, iconv('UTF-8', 'TIS-620', 'วันที่ออกใบเสร็จ :'), 0, 1);
$pdf->Cell(62, 2, iconv('UTF-8', 'TIS-620',''), 0, 0);
$pdf->Cell(60, 9, iconv('UTF-8', 'TIS-620',DateThai($datenow)), 0, 1);
$pdf->Cell(44, 5, iconv('UTF-8', 'TIS-620', 'ผู้ขาย  : ' . $name), 0, 1);

//$pdf->Ln();
$pdf->Cell(13, 8, iconv('UTF-8', 'TIS-620', 'ลำดับ'), 0, 0);
$pdf->Cell(30, 8, iconv('UTF-8', 'TIS-620', 'รายการ'), 0, 0);
$pdf->Cell(18, 8, iconv('UTF-8', 'TIS-620', 'จำนวน'), 0, 0);
$pdf->Cell(18, 8, iconv('UTF-8', 'TIS-620', 'ราคา'), 0, 0);
$pdf->Cell(15, 8, iconv('UTF-8', 'TIS-620', 'รวม'), 0, 0);

$pdf->Ln();

$pdf->Cell(80, 5, iconv('UTF-8', 'TIS-620', '-------------------------------------------------------------------------------'), 0, 0);
$pdf->Ln();
$sql1 = "SELECT tb_plant.plant_name as plant_name,
tb_plant_detail.plant_detail_price as plant_detail_price,
tb_payment_detail.payment_detail_amount as amount,
tb_grade.grade_id as grade_id,
tb_grade.grade_name as g_name,
tb_payment_detail.payment_detail_total as total 

FROM tb_payment_detail
LEFT JOIN tb_payment ON tb_payment.payment_id=tb_payment_detail.ref_payment_id
LEFT JOIN tb_plant ON tb_plant.plant_id=tb_payment_detail.ref_plant_id
LEFT JOIN tb_plant_detail ON tb_plant_detail.ref_plant_id =tb_plant.plant_id
LEFT JOIN tb_grade ON tb_grade.grade_id=tb_plant_detail.ref_grade_id
WHERE tb_payment_detail.ref_payment_id='$payment_id' AND tb_grade.grade_id = tb_payment_detail.ref_grade_id
GROUP BY tb_grade.grade_id";
$result = mysqli_query($conn, $sql1);

//แสดงค่า
$sumval = 0;
$number=0;
while ($array = mysqli_fetch_assoc($result)) {
    
    $plant_name = $array['plant_name'];
    $price = $array['plant_detail_price'];
    $amount = $array['amount'];
    $total = $array['total'];
$g_name =$array['g_name'];
    //แสดงค่าในไฟล์ PDF
    $number++;
    $pdf->Cell(2, 5, iconv('UTF-8', 'cp874', ''), 0, 0);
    $pdf->Cell(10, 5, iconv('UTF-8', 'TIS-620', $number), 0, 0);
    $pdf->Cell(34, 5, iconv('UTF-8', 'cp874', $plant_name.' ('.$g_name.')'), 0, 0);
    $pdf->Cell(7, 5, iconv('UTF-8', 'cp874', "-".$amount), 0, 0);
    $pdf->Cell(17, 5, iconv('UTF-8', 'cp874', number_format("-".$price, 2)), 0, 0, "R");
$pdf->Cell(17, 5, iconv('UTF-8', 'cp874', number_format("-".$total, 2)), 0, 0, "R");
    $sumval += $total;
    $pdf->Ln();
}
$pdf->Cell(80, 5, iconv('UTF-8', 'TIS-620', '-------------------------------------------------------------------------------'), 0, 0);


$pdf->Ln();
$pdf->Cell(15, 5, iconv('UTF-8', 'TIS-620', 'ยอดสุทธิ'), 0, 0);
$pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620', number_format("-".$sumval, 2)), 0, 0, "R");

$pdf->Ln();
$total = str_replace(",", "", $total);

$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', 'เงินสด/เงินทอน'), 0, 0);
$pdf->Cell(20, 5, iconv('UTF-8', 'TIS-620', number_format(0, 2)), 0, 0, "R");

$change = $total/*  - $sumval */;
$pdf->Cell(17, 5, iconv('UTF-8', 'TIS-620', number_format($change, 2)), 0, 0, "R");

$pdf->Ln();
$pdf->Cell(80, 5, iconv('UTF-8', 'TIS-620', '-------------------------------------------------------------------------------'), 0, 0);
$pdf->Ln();

$pdf->Cell(0, 15, iconv('UTF-8', 'TIS-620', '****ขอบคุณที่ใช้บริการ****'), 0, 1, "C");

$pdf->Output();
