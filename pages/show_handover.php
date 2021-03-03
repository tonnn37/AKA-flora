<?php
require 'connect.php';
require 'fpdf181/fpdf.php';
@session_start();
$name = $_SESSION['firstname'] . " " . $_SESSION['lastname'];

$sql_mem = "SELECT MAX(handover_id)AS max  FROM tb_stock_handover WHERE handover_status ='เสร็จสิ้น'";
$re_max = mysqli_query($conn, $sql_mem);
$row = mysqli_fetch_assoc($re_max);
$handover_id = $row['max'];


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
    function header()
    {
        $this->AddFont('angsa', '', 'angsa.php');
        $this->SetFont('angsa', '', 14);
        $this->Image('../image/aka_logo.jpg', 5, 5, 40,40);
        $this->Cell(90, 7, iconv('UTF-8', 'TIS-620', ''), 0, 1, "C");
        $this->Cell(114, 6, iconv('UTF-8', 'TIS-620', 'ธุรกิจการเกษตร AKA FLORA'), 0, 1, "C");
        $this->Cell(162, 6, iconv('UTF-8', 'TIS-620', '375 หมู่ 2 ถนนประชาอุทิศ ซอยประชาอุทิศ 76 ตำบลบ้านคลองสวน'), 0, 1, "C");
        $this->Cell(164, 6, iconv('UTF-8', 'TIS-620', 'อำเภอพระสมุทรเจดีย์ จังหวัดสมุทรปราการ 10290 โทร. 080-5579464'), 0, 1, "C");
        $this->Ln();
        
        $this->AddFont('angsa', 'B', 'angsa.php');
        $this->SetFont('angsa', 'B', 18);
        $this->Cell(190, 8, iconv('UTF-8', 'TIS-620', 'ใบส่งมอบ'), 1, 1, "C");

        $this->AddFont('angsa', '', 'angsa.php');
        $this->SetFont('angsa', '', 14);
    }

    public function Footer()
    {

        $this->SetY(-15);
    }
}
$pdf = new myPDF('P');


$sql = "SELECT tb_stock_handover.handover_id as handover_id,
			tb_customer.customer_firstname as  customer_firstname,
            tb_customer.customer_lastname as customer_lastname,
            tb_order_detail.order_detail_id as order_detail_id,
            tb_order_detail.order_detail_amount as order_detail_amount,
            tb_grade.grade_name as grade_name
            
FROM tb_stock_handover
LEFT JOIN tb_stock_handover_detail ON tb_stock_handover_detail.ref_handover_id = tb_stock_handover.handover_id
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_handover_detail.ref_grade_id
LEFT JOIN tb_order_detail ON tb_order_detail.order_detail_id = tb_stock_handover.ref_order_detail_id
LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
LEFT JOIN tb_customer ON tb_order.order_customer = tb_customer.customer_id 
WHERE tb_stock_handover.handover_id ='$handover_id' AND tb_stock_handover.handover_status ='เสร็จสิ้น'
AND tb_stock_handover_detail.handover_detail_status ='เสร็จสิ้น' 
ORDER BY tb_stock_handover.handover_id";

$result = mysqli_query($conn, $sql);
$array = mysqli_fetch_assoc($result);
    
    $customer_firstname = $array['customer_firstname'];
    $customer_lastname = $array['customer_lastname'];
    $handover_ids = $array['handover_id'];
    $order_detail_id = $array['order_detail_id'];


$pdf->AliasNbPages();
$pdf->SetTitle("ใบส่งมอบสินค้า AKA Flora", true);
$pdf->addPage();
$pdf->Ln();

$pdf->Cell(42, 8, iconv('UTF-8', 'TIS-620', 'ชื่อลูกค้า : ' . $customer_firstname . '  ' . $customer_lastname), 0, 0);
$pdf->Cell(149, 8, iconv('UTF-8', 'TIS-620', ' เลขที่ใบส่งสินค้า : ' . $handover_ids),  0, 0, "R");
$pdf->Ln();
$pdf->Cell(191, 8, iconv('UTF-8', 'TIS-620', 'วันที่ส่งสินค้า : ' . Datethai($datenow)), 0, 0, "R");

$pdf->Ln();
$pdf->Cell(191, 8, iconv('UTF-8', 'TIS-620', ' เลขที่ใบสั่งซื้อ (อ้างอิง) : ' . $order_detail_id),  0, 0, "R");
$pdf->Ln();


$pdf->Ln();
$pdf->Ln();



$pdf->Ln();
$pdf->Cell(30, 8, iconv('UTF-8', 'cp874', ''), 0, 0, "C");
$pdf->Cell(20, 8, iconv('UTF-8', 'TIS-620', 'ลำดับ'), 1, 0, "C");
$pdf->Cell(40, 8, iconv('UTF-8', 'TIS-620', 'พันธุ์ไม้'), 1, 0, "C");
$pdf->Cell(30, 8, iconv('UTF-8', 'TIS-620', 'เกรด'), 1, 0, "C");
$pdf->Cell(50, 8, iconv('UTF-8', 'TIS-620', 'จำนวนที่ส่ง (ต้น)'), 1, 0, "C");
$pdf->Cell(15, 8, iconv('UTF-8', 'cp874', ''), 0, 0, "C");




$pdf->Ln();


$sql2 = "SELECT tb_stock_handover.handover_id as handover_id,
			tb_customer.customer_firstname as  customer_firstname,
            tb_customer.customer_lastname as customer_lastname,
            tb_order_detail.order_detail_id as order_detail_id,
            tb_order_detail.order_detail_amount as order_detail_amount,
            tb_grade.grade_name as grade_name,
            tb_plant.plant_name as plant_name,
            tb_order_detail.order_detail_amount as order_detail_amount
            
FROM tb_stock_handover
LEFT JOIN tb_stock_handover_detail ON tb_stock_handover_detail.ref_handover_id = tb_stock_handover.handover_id
LEFT JOIN tb_grade ON tb_grade.grade_id = tb_stock_handover_detail.ref_grade_id
LEFT JOIN tb_order_detail ON tb_order_detail.order_detail_id = tb_stock_handover.ref_order_detail_id
LEFT JOIN tb_order ON tb_order.order_id = tb_order_detail.ref_order_id
LEFT JOIN tb_plant ON tb_plant.plant_id = tb_order_detail.ref_plant_id
LEFT JOIN tb_customer ON tb_order.order_customer = tb_customer.customer_id 
WHERE tb_stock_handover.handover_id ='$handover_id' AND tb_stock_handover.handover_status ='เสร็จสิ้น'
AND tb_stock_handover_detail.handover_detail_status ='เสร็จสิ้น' 
ORDER BY tb_stock_handover.handover_id";

$result2 = mysqli_query($conn, $sql2);
$i = 0;
while ($array2 = mysqli_fetch_assoc($result2)) {

    $i++;

    $plant_name = $array2['plant_name'];
    $grade_name = $array2['grade_name'];
    $order_detail_amount = $array2['order_detail_amount'];
    

    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', ''), 0, 0, "C");
    $pdf->Cell(20, 8, iconv('UTF-8', 'cp874', $i), 1, 0, "C");
    $pdf->Cell(40, 8, iconv('UTF-8', 'cp874', $plant_name) . '', 1, 0, 'C');
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874',$grade_name),  1, 0, "C");
    $pdf->Cell(50, 8, iconv('UTF-8', 'cp874', number_format($order_detail_amount)),  1, 0, "R");
    $pdf->Cell(15, 8, iconv('UTF-8', 'cp874', ''), 0, 0, "C");


}

/* $pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->Cell(92, 5, iconv('UTF-8', 'TIS-620', 'ผู้รับสินค้า __________________'), 0, 0, "C");
$pdf->Cell(92, 5, iconv('UTF-8', 'TIS-620', 'ผู้ส่งสินค้า __________________'), 0, 0, "C");
$pdf->Ln();

$pdf->Cell(103, 5, iconv('UTF-8', 'TIS-620', '(                                )'), 0, 0, "C");
$pdf->Cell(82, 5, iconv('UTF-8', 'TIS-620', '(                              )'), 0, 0, "C");
 */


ob_end_clean();
$pdf->Output();

?>
<?php
/* 
function convert($number)
{
    $txtnum1 = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
    $txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
    $number = str_replace(",", "", $number);
    $number = str_replace(" ", "", $number);
    $number = str_replace("บาท", "", $number);
    $number = explode(".", $number);
    if (sizeof($number) > 2) {
        return 'ทศนิยมหลายตัวนะจ๊ะ';
        exit;
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for ($i = 0; $i < $strlen; $i++) {
        $n = substr($number[0], $i, 1);
        if ($n != 0) {
            if ($i == ($strlen - 1) and $n == 1) {
                $convert .= 'เอ็ด';
            } elseif ($i == ($strlen - 2) and $n == 2) {
                $convert .= 'ยี่';
            } elseif ($i == ($strlen - 2) and $n == 1) {
                $convert .= '';
            } else {
                $convert .= $txtnum1[$n];
            }
            $convert .= $txtnum2[$strlen - $i - 1];
        }
    }

    $convert .= 'บาท';
    if (
        $number[1] == '0' or $number[1] == '00' or
        $number[1] == ''
    ) {
        $convert .= 'ถ้วน';
    } else {
        $strlen = strlen($number[1]);
        for ($i = 0; $i < $strlen; $i++) {
            $n = substr($number[1], $i, 1);
            if ($n != 0) {
                if ($i == ($strlen - 1) and $n == 1) {
                    $convert
                        .= 'เอ็ด';
                } elseif (
                    $i == ($strlen - 2) and
                    $n == 2
                ) {
                    $convert .= 'ยี่';
                } elseif (
                    $i == ($strlen - 2) and
                    $n == 1
                ) {
                    $convert .= '';
                } else {
                    $convert .= $txtnum1[$n];
                }
                $convert .= $txtnum2[$strlen - $i - 1];
            }
        }
        $convert .= 'สตางค์';
    }
    return $convert;
} */

?>
