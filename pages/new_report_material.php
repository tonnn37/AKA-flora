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
$type_material = $_POST['type_material'];
$select = $_POST['type'];
$status = $_POST['status'];
$sum = 0;
$sum1 = 0;
$sum2 = 0;
$sum3= 0;
$sum4 = 0;
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
$stdate = DateThai1($date);
$sql = '';
class PDF extends FPDF
{
    //กำหนด header
    public function Header()
    {
        global $title, $list, $i, $stdate, $time_report, $name;
        $w = $this->GetStringWidth($title) + 8;
        //$this->SetX((210 - $w) / 2); //จัดกึ่งกลางหน้า
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
        $this->Cell(50, 5, iconv('UTF-8', 'cp874', 'วันที่พิมพ์ : ' . $stdate . " เวลา : " . $time_report), 0, 0, "C");
        $this->Cell(228, 10, iconv('UTF-8', 'TIS-620', 'ผู้ออกรายงาน : ' . $name), 0, 1, "R");
        $this->Ln(5);
        $this->Cell(15, 10, iconv('UTF-8', 'cp874', 'ลำดับ'), 1, 0, 'C', true);
        $this->Cell(33, 10, iconv('UTF-8', 'cp874', 'รหัสรายการปลูก'), 1, 0, 'C', true);
        $this->Cell(38, 10, iconv('UTF-8', 'cp874', 'ชื่อพันธุ์ไม้'), 1, 0, 'C', true);
        $this->Cell(31, 10, iconv('UTF-8', 'cp874', 'จำนวนที่ปลูก (ต้น)'), 1, 0, 'C', true);
        $this->Cell(34, 10, iconv('UTF-8', 'cp874', 'ปริมาณสูตรยา (ลิตร)'), 1, 0, 'C', true);
        $this->Cell(36, 10, iconv('UTF-8', 'cp874', 'ปริมาณวัสดุปลูก (กก.)'), 1, 0, 'C', true);
        $this->Cell(30, 10, iconv('UTF-8', 'cp874', 'ราคาสูตรยา'), 1, 0, 'C', true);
        $this->Cell(30, 10, iconv('UTF-8', 'cp874', 'ราคาวัสดุปลูก'), 1, 0, 'C', true);
        $this->Cell(30, 10, iconv('UTF-8', 'cp874', 'ราคาทั้งหมด'), 1, 0, 'C', true);
       
        if ($i != 0) {
            if ($i % 7 == 1) {
                $this->Ln();
            }
        }
    }
    public function footer() //เลขหน้า
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
    $query = "SELECT tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id , tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    WHERE  tb_planting_week_detail.week_detail_date BETWEEN '$st_date' AND '$en_date'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $title = 'รายงานข้อมูลต้นทุนรายการปลูก ' . " " . 'วันที่' . " " . DateThai1($st_date) . " ถึง " . DateThai1($en_date);
} else if ($select == 'month' && $month != "" && $my != '') {
    $query = "SELECT tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id , tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    WHERE MONTH(tb_planting_week_detail.week_detail_date)='$month' AND YEAR(tb_planting_week_detail.week_detail_date)='$my'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $title = 'รายงานข้อมูลต้นทุนรายการปลูก ' . " " . 'เดือน' . month($month) . " " . 'ปี' . " " . year($my);
} else if ($select == 'year' && $year != "") {
    $query = "SELECT tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id , tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    WHERE  YEAR(tb_planting_week_detail.week_detail_date)='$year'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $title = 'รายงานข้อมูลต้นทุนรายการปลูก '   . " " . 'ประจำปี' . " " . ($year - 543 + 1086);
} else if ($select == 'type' && $type_material != "0") {
    $query = "SELECT tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id , tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    WHERE tb_order.order_id ='$type_material'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $sql = "SELECT * FROM tb_order WHERE order_id='$type_material'";
    $re_m = mysqli_query($conn, $sql);
    $row_m = mysqli_fetch_assoc($re_m);
    $title = 'รายงานข้อมูลต้นทุนรายการปลูก' . " " . 'รายการปลูก' . " " . $row_m['order_name'];
} else if ($select == 'status' && $status != '0') {
    $query = "SELECT tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id , tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    WHERE tb_planting_detail.planting_detail_status='$status'
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $sql = "SELECT * FROM tb_planting_detail WHERE planting_detail_status='$status'";
    $re_m = mysqli_query($conn, $sql);
    $row_m = mysqli_fetch_assoc($re_m);
    $title = 'รายงานข้อมูลต้นทุนรายการปลูก' . " " . 'สถานะ' . " " . $row_m['planting_detail_status'];
} else {
    $query = "SELECT tb_plant.plant_name as plant_name, tb_planting_detail.planting_detail_id as planting_detail_id , tb_planting_detail.planting_detail_total as planting_detail_total, tb_order.order_name as order_name,tb_material.material_price as material_price,tb_material.material_status as material_status, 
    tb_material.material_amount as material_amount, SUM(tb_planting_week_detail.material_amount)  as SUM ,SUM(tb_planting_week_detail.material_price)  as SUM1 ,SUM(tb_planting_week_detail.formula_amount)  as SUM2,
    SUM(tb_planting_week_detail.formula_price)  as SUM3, SUM(tb_planting_week_detail.material_price + tb_planting_week_detail.formula_price) as SUM4
    FROM tb_planting_week_detail
    INNER JOIN tb_material ON tb_material.material_id = tb_planting_week_detail.ref_material_id
    INNER JOIN tb_planting_week ON tb_planting_week.planting_week_id = tb_planting_week_detail.ref_planting_week_id
    INNER JOIN tb_planting_detail ON tb_planting_detail.planting_detail_id = tb_planting_week.ref_planting_detail_id
    INNER JOIN tb_planting ON tb_planting.planting_id=tb_planting_detail.ref_planting_id
    INNER JOIN tb_order ON tb_order.order_id=tb_planting.ref_order_id
    INNER JOIN tb_plant ON tb_plant.plant_id=tb_planting_detail.ref_plant_id
    GROUP BY tb_planting_detail.planting_detail_id
    ORDER BY tb_planting_detail.planting_detail_id";
    $title = "รายงานข้อมูลต้นทุนรายการปลูกทั้งหมด";
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
    $id = $array['planting_detail_id'];
    $pname = $array['plant_name'];
    $plantamount = $array['planting_detail_total'];
    $drugamount = $array['SUM2'];
    $drugprice = $array['SUM3'];
    $amount = $array['SUM'];
    $matamount  = $array['material_amount'];
    $price = $array['SUM1'];
    $drugamount1 = $drugamount  ;
    $amount1 = $amount;
    $total = $price +  $drugprice;
    //แสดงค่าในไฟล์ PDF

    $pdf->Cell(15, 10, iconv('UTF-8', 'cp874', $i), 1, 0, "C");
    $pdf->Cell(33, 10, iconv('UTF-8', 'cp874', $id), 1, 0, "C");
    $pdf->Cell(38, 10, iconv('UTF-8', 'cp874', $pname), 1, 0, "C");
    $pdf->Cell(31, 10, iconv('UTF-8', 'cp874', number_format($plantamount)), 1, 0, "R");
    $pdf->Cell(34, 10, iconv('UTF-8', 'cp874', number_format($drugamount1,1)), 1, 0, "R");
    $pdf->Cell(36, 10, iconv('UTF-8', 'cp874', number_format($amount1,1)), 1, 0, "R");
    $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', number_format($drugprice, 2)), 1, 0, "R");
    $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', number_format($price, 2)), 1, 0, "R");
    $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', number_format($total, 2)), 1, 0, "R");
    $pdf->Ln();
    $sum += $drugamount1;
    $sum1 += $amount1;
    $sum2 += $drugprice;
    $sum3 += $price;
    $sum4 += $total;
} //end while


/* $re_ok = mysqli_query($conn, $sql_count_ok);
$obj_ok = mysqli_fetch_assoc($re_ok);

$re_ban = mysqli_query($conn, $sql_count_ban);
$obj_ban = mysqli_fetch_assoc($re_ban);

$re_main = mysqli_query($conn, $sql_count_main);
$obj_main = mysqli_fetch_assoc($re_main);

$re_total = mysqli_query($conn, $sql_total);
$obj_total = mysqli_fetch_assoc($re_total);

$re_cost = mysqli_query($conn, $sql_cost);
$obj_cost = mysqli_fetch_assoc($re_cost);

$pdf->Ln();
$pdf->Cell(0, 10, iconv('UTF-8', 'cp874', "สรุปข้อมูลอุปกรณ์"), 1, 0, "C");
$pdf->Ln();
$pdf->Cell(47, 10, iconv('UTF-8', 'TIS-620', 'ทั้งหมด : ' . $obj_total['main_count'] . " ชิ้น"), 1, 0, "C");
$pdf->Cell(49, 10, iconv('UTF-8', 'TIS-620', 'พร้อมใช้งาน : ' . $obj_ok['ok_count'] . " ชิ้น"), 1, 0, "C");
$pdf->Cell(47, 10, iconv('UTF-8', 'TIS-620', 'ยกเลิก : ' . $obj_ban['ban_count'] . " ชิ้น"), 1, 0, "C");
$pdf->Cell(47, 10, iconv('UTF-8', 'TIS-620', 'ชำรุด : ' . $obj_main['main_count'] . " ชิ้น"), 1, 1, "C");
$pdf->Cell(190, 10, iconv('UTF-8', 'TIS-620', 'ราคาทุนทั้งหมด : ' . number_format($obj_cost['Cost'], 2) . " บาท"), 1, 0, "C"); */

$pdf->Cell(117, 10, iconv('UTF-8', 'cp874', "รวม"), 1, 0, "C");
$pdf->Cell(34, 10, iconv('UTF-8', 'cp874', number_format($sum,1)), 1, 0, "R");
$pdf->Cell(36, 10, iconv('UTF-8', 'cp874', number_format($sum1,1)), 1, 0, "R");
$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', number_format($sum2,2)), 1, 0, "R");
$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', number_format($sum3,2)), 1, 0, "R");
$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', number_format($sum4,2)), 1, 0, "R");
$pdf->ln();
$pdf->ln(3);

ob_end_clean();
$pdf->Output(); //คำสั่งแสดงผลลัพธ์
ob_end_flush(); //ปิด obj
