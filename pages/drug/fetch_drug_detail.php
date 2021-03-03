<?php
//fetch.php
require 'connect.php';
$output = '';
$query = "";
$id = $_POST['extra_search'];

$query = "SELECT tb_drug_detail.drug_detail_id as dt_id,tb_drug.drug_name as d_name
,tb_drug_detail.drug_detail_amount as amount,tb_drug_detail.drug_detail_status as status
,tb_drug_sm_unit.drug_sm_unit_name as sm_name,tb_drug_detail.detail_size as size
FROM tb_drug_detail
LEFT JOIN tb_drug ON tb_drug.drug_id=tb_drug_detail.ref_drug_id
LEFT JOIN tb_group_drug ON tb_group_drug.group_drug_id = tb_drug.ref_group_drug
LEFT JOIN tb_drug_type ON tb_drug_type.drug_typeid = tb_group_drug.ref_drug_type
LEFT JOIN tb_drug_unit ON tb_drug_unit.drug_unit_id = tb_drug_type.ref_drug_unit
LEFT JOIN tb_drug_sm_unit ON tb_drug_sm_unit.drug_sm_unit_id = tb_group_drug.ref_drug_sunit
WHERE tb_drug_detail.ref_drug_id='$id'
ORDER BY tb_drug_detail.drug_detail_id ASC";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $i = 1;
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        $subdata = array();
        $subdata[] = $i;
        $subdata[] = $row['dt_id'];
        $subdata[] = $row['d_name'] . " (" . $row['size'] . ")";
        $subdata[] = $row['amount'] . '  ' . $row['sm_name'];

        $subdata[] = $row['status'];

        //$dt_re_id=$equ_id = str_replace('-', '', $equ_id);
       
        
        if ($row['status'] == 'ปกติ') {
            $image = 'fas fa-times';
            $color = "btn btn-danger  btn-sm";
            $txt = "ยกเลิกข้อมูล";
        } else if ($row['status'] == 'ระงับ') {
            $image = 'fas fa-check';
            $color = "btn btn-success btn-sm";
            $txt = "ยกเลิกการระงับ";
        }
        $subdata[] = '<a href="#a' . $row['dt_id'] . '" data-toggle="modal" >
        <button type="button" class="btn btn-warning btn-sm" id="tbl_edit_eq" data="' . $row['dt_id'] . '"
            data-toggle="tooltip"  title="แก้ไขข้อมูล"" >
            <i class="fas fa-edit" style="color:white"></i></button>
    </a>' . '
        <button type="button" class="' . $color . '"  id="btn_re_equ" data="' . $row['dt_id'] . '"data-status="' . $row['status'] . '"  data-name="' . $row['d_name'] . '" data-name2="' . $row['size'] . '" 
            data-toggle="tooltip"  title="' . $txt . '" ">
            <i  class="' . $image . '" style="color:white"></i></button>';
        $rows[] = $subdata;

        $i++;
    }
    $json_data = array(
        /*   "draw" => intval($request['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFilter), */
        "data" => $rows,
    );
    echo json_encode($json_data);
} else {
    $json_data = array(
        /* "draw" => intval($request['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFilter), */
        "data" => $rows,
    );
    echo json_encode($json_data);
}

?>
