<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" />


<form action="./pages/new_report_material.php" method="POST" target="_blank">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-md-2">
            <div class="form-group" align="right">
                <label for="inputState">ค้นหา : </label>
            </div>
        </div>
        <div class="col-md-1.5">
            <div class="dropdown">
                <div class="form-group">
                    <select id="type" class="form-control" name="type">
                        <option selected value="0">----โปรดเลือก----</option>
                        <option value="all">ทั้งหมด</option>
                        <option value="type">ชื่อรายการปลูก</option>
                        <option value="status">สถานะ</option>
                        <option value="day">วันที่</option>
                        <option value="month">เดือน</option>
                        <option value="year">ปี</option>
                    </select>
                    <span class="error_select"></span>
                </div>
            </div>
            <span style="color:red"> *</span>
        </div>

        <div class="form-group">
            <input type="date" class="form-control" id="st_date" name="st_date" placeholder="กรอกข้อมูลที่ต้องการค้นหา">
        </div>

        <div class="col-2" id="div_month">
            <div class="dropdown">
                <div class="form-group">
                    <select id="month" class="form-control" name="month">
                        <option selected value="0">----เลือกเดือน----</option>
                        <option value="1">มกราคม</option>
                        <option value="2">กุมภาพันธ์</option>
                        <option value="3">มีนาคม</option>
                        <option value="4">เมษายน</option>
                        <option value="5">พฤษภาคม</option>
                        <option value="6">มิถุนายน</option>
                        <option value="7">กรกฎาคม</option>
                        <option value="8">สิงหาคม</option>
                        <option value="9">กันยายน</option>
                        <option value="10">ตุลาคม</option>
                        <option value="11">พฤษจิกายน</option>
                        <option value="12">ธันวาคม</option>
                    </select>
                    <span class="error_select"></span>
                </div>
            </div>
        </div>

        <div class="col-md-1.5" id="div_year">
            <div class="dropdown">
                <div class="form-group">
                    <select id="month_year" class="form-control" name="month_year">
                        <option selected value="0">----เลือกปี----</option>
                        <?php
                        $datenow = strtotime(date("Y-m-d"));
                        $year = date('Y', $datenow) + 543;
                        for ($i = 2560; $i <= $year; $i++) {
                            $a = $i - 543;
                        ?>
                            <option value="<?= $a ?>"><?php echo $i; ?></option>
                            <?php
                            }
                            ?>
                    </select>
                    <span class="error_select"></span>
                </div>
            </div>
        </div>

        <div class="dropdown" id="div_txt_year">
            <div class="form-group">
                <select id="txt_year" class="form-control" name="txt_year">
                    <option selected value="0">----เลือกปี----</option>
                    <?php
                    $datenow = strtotime(date("Y-m-d"));
                    $year = date('Y', $datenow) + 543;
                    for ($i = 2560; $i <= $year; $i++) {
                        $a = $i - 543;
                    ?>
                        <option value="<?= $a ?>"><?php echo $i; ?></option>
                        <?php
                        }
                        ?>
                </select>
                <span class="error_select"></span>
            </div>
        </div>

        <div class="col-md-1.5">
            <div class="dropdown">
                <div class="form-group">
                    <select name="type_material" class="form-control" id="type_material">
                        <option value="0">----เลือกรายการปลูก----</option>
                        <?php
                           $sql_type1 = "SELECT * FROM tb_order WHERE order_status ='เสร็จสิ้น' OR order_status ='ปกติ' GROUP BY order_name  ORDER BY order_id ASC";
                        $re_type1 = mysqli_query($conn, $sql_type1);
                        while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                        ?>
                            <option value="<?php echo $re_fac1["order_id"]; ?>">
                                <?php echo $re_fac1["order_name"]; ?>
                            </option>
                        <?php
                        }

                        ?>
                    </select>
                    <span class="error_select"></span>
                </div>
            </div>

        </div>

        <div class="col-md-1.5">
            <div class="dropdown">
                <div class="form-group">
                    <select name="status" class="form-control" id="status">
                        <option value="0">----เลือกสถานะ----</option>
                        <?php
                        $sql_type1 = "SELECT * FROM tb_planting_detail  GROUP BY planting_detail_status  ORDER BY planting_detail_id ASC";
                        $re_type1 = mysqli_query($conn, $sql_type1);
                        while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                        ?>
                            <option value="<?php echo $re_fac1["planting_detail_status"]; ?>">
                                <?php echo $re_fac1["planting_detail_status"]; ?>
                            </option>
                        <?php
                        }

                        ?>
                    </select>
                    <span class="error_select"></span>
                </div>
            </div>

        </div>

        <label for="" id="pass">&ensp; ถึง &ensp;</label>
        <div class="form-group">
            <input type="date" class="form-control" id="en_date" name="en_date" placeholder="กรอกข้อมูลที่ต้องการค้นหา">
        </div> &ensp;

        <div class="form-group">
            <button type="button" class="btn btn-secondary" id="btn_search"><img src="image/1x/btnsearch.png" width="25px" height="25px"></button>
        </div> &ensp;
        <div class="form-group">
            <button type="submit" class="btn btn-secondary" id="btn_print"><img src="image/1x/btnprint.png " width="25px" height="25px"></button>
        </div> &ensp;
       <!--  <div class="form-group">
            <button type="button" class="btn btn-secondary" id="btn_grap" name="btn_grap"><img src="image/1x/g.png" width="25px" height="25px"></button>
        </div> -->
    </div>
</form>
<div id="material">
    <table id="g_material" class="highchart" data-graph-type="column" style="display:none;" data-graph-datalabels-enabled="1" data-graph-datalabels-formatter="foo.myAwesomeCallback">
        <thead>
            <tr>
                <th>ประจำเดือน</th>
                <th>จำนวน</th>
            </tr>
        </thead>
        <tbody id="material_show">

        </tbody>
    </table>
</div>

<div id="show">
    <strong>
        <center><label for="" style="font-size: 200px;" id="h"></label></center>
    </strong>
    <strong>
        <center><label for="" style="font-size: 200px;" id="label2"></label></center>
    </strong>
    <div id="output">
    </div>
    <canvas id="g_show" height="500px" width="1100px"></canvas>
</div>


<script>
    $("#st_date").hide()
    $("#en_date").hide()
    $("#div_month").hide()
    $("#div_year").hide()
    $("#div_txt_year").hide()
    $("#status").hide()
    $('#pass').hide()
    foo = {
        myAwesomeCallback: function(value) {
            return value
        }
    }
   /*  $('#btn_grap').click(function() {
        //$('#btn_print').attr("disabled", false);
        var select = $('#type').val()
        var type_material = $('#type_material').val()
        var st_date = $('#st_date').val()
        var en_date = $('#en_date').val()
        var month = $('#month').val()
        var month_year = $('#month_year').val()
        var year = $('#txt_year').val()
        var status = $('#status').val()
        var txt_type_material = $("#type_material option:selected").text();
        var months = $("#month option:selected").text();
        var status1 = $("#status option:selected").text();
        var st_date1 = new Date (st_date);
        var st_date2 = st_date1.toLocaleDateString();
        var en_date1 = new Date (en_date);
        var en_date2 = en_date1.toLocaleDateString();
        if (select == 0) {
            swal({
                text: "กรุณาเลือกวิธีการค้นหา",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'type' && type_material == 0) {

            swal({
                text: "กรุณาเลือกรายการปลูก",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'status' && status == 0) {

            swal({
                text: "กรุณาเลือกสถานะ",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'day' && st_date == 0 && en_date == 0) {

            swal({
                text: "กรุณาเลือกวันที่",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'day' && st_date != 0 && en_date == 0) {

            swal({
                text: "กรุณาเลือกวันที่ให้ครบถ้วน",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'day' && st_date == 0 && en_date != 0) {

            swal({
                text: "กรุณาเลือกวันที่ให้ครบถ้วน",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'month' && month == 0 && month_year == 0) {

            swal({
                text: "กรุณาเลือกเดือนและปี",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'month' && month != 0 && month_year == 0) {

            swal({
                text: "กรุณาเลือกเดือนและปีให้ครบถ้วน",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'month' && month == 0 && month_year != 0) {

            swal({
                text: "กรุณาเลือกเดือนและปีให้ครบถ้วน",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'year' && year == 0) {

            swal({
                text: "กรุณาเลือกปี",
                icon: "warning",
                buttons: false,
            })
        } else
            $.ajax({
                url: "./pages/get_material.php",
                type: "POST",
                data: {
                    select: select,
                    st_date: st_date,
                    en_date: en_date,
                    month: month,
                    month_year: month_year,
                    year: year,
                    type_material: type_material,
                    status: status
                },
                success: function(data) {
                    if (select == 'type') {
                        $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                        $('#label2').text('รายการปลูก' + txt_type_material)
                    } else if (select == 'day') {
                        $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                        $('#label2').text('ระหว่างวันที่' + " " + st_date2 + " " + "ถึง" + " " + en_date2)
                    } else if (select == 'month') {
                        $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                        $('#label2').text('เดือน' + " " + months + " " + "ปี" + " " + (month_year - 543 + 1086))
                    } else if (select == 'year') {
                        $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                        $('#label2').text('ประจำปี' + " " + (year - 543 + 1086))
                    } else if (select == 'status') {
                        $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                        $('#label2').text('สถานะ' + " " + status1)
                    } else {
                        $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                        $('#label2').text('รายงานข้อมูลทั้งหมด')
                    }
                    console.log(data);
                    $('#output').hide()
                    $('#g_show').show()
                    var material = {
                        Name: [],
                        SUM: []
                    };

                    var len = data.length;

                    for (var i = 0; i < len; i++) {
                        material.Name.push(data[i].order_name +" "+ "พันธุ์ไม้" + data[i].plant_name);
                        material.SUM.push(data[i].SUM4);


                    }
                    var max_count = Math.max.apply(Math, material.SUM);
                    //get canvas
                    var ctx = $("#g_show");
                    //alert(max_count)
                    var data = {
                        labels: material.Name,
                        datasets: [{
                            label: "ราคาต้นทุน (บาท)",
                            data: material.SUM,
                            backgroundColor: "lightgreen",
                            borderColor: "lightgreen",
                            fill: false,
                            lineTension: 0,
                            pointRadius: 5
                        }, ]
                    };

                    var options = {
                        responsive: false,
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                boxWidth: 80,
                                fontColor: 'black',

                            }
                        },
                        scales: {
                            labels: {
                                boxWidth: 80,
                                fontColor: 'rgb(255, 99, 132)',

                            },
                            xAxes: [{
                                gridLines: {
                                    drawBorder: true,
                                    display: true,
                                    color: "black"
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: "ชื่อรายการปลูกและพันธุ์ไม้",
                                    fontSize: 15,
                                    fontColor: 'black'
                                },
                                ticks: {
                                    fontSize: 15,
                                    fontColor: 'black'
                                }
                            }],
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: "ราคาต้นทุนทั้งหมด (บาท)",

                                    fontSize: 15,
                                    fontColor: 'black'
                                },
                                gridLines: {
                                    drawBorder: true,
                                    color: "black",
                                    display: true,
                                    lineWidth: 1,
                                },

                                ticks: {
                                    fontSize: 15,
                                    fontColor: 'black',
                                    min: 0,
                                    callback: function(value, index, values) {
                                        if (Math.floor(value) === value) {
                                            return value;
                                        }
                                    }
                                },

                            }]
                        }
                    };


                    var chart = new Chart(ctx, {
                        type: "bar",
                        data: data,
                        options: options

                    });

                },
                error: function(data) {
                    console.log(data);
                }
            });



    }) */

    function load_member(select, st_date, en_date, month, month_year, year, type_material, status) {
        var txt_type_material = $("#type_material option:selected").text();
        var months = $("#month option:selected").text();
        var status1 = $("#status option:selected").text();
        var st_date1 = new Date (st_date);
        var st_date2 = st_date1.toLocaleDateString();
        var en_date1 = new Date (en_date);
        var en_date2 = en_date1.toLocaleDateString();
        $.ajax({
            url: "./pages/report_material.php",
            method: "POST",
            data: {

                select: select,
                type_material: type_material,
                st_date: st_date,
                en_date: en_date,
                month: month,
                month_year: month_year,
                year: year,
                status: status
            },
            success: function(data) {
                if (select == 'type') {
                    $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                    $('#label2').text('รายการปลูก' + txt_type_material)
                } else if (select == 'day') {
                    $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                    $('#label2').text('ระหว่างวันที่' + " " +  st_date2 + " " + "ถึง" + " " +  en_date2)
                } else if (select == 'month') {
                    $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                    $('#label2').text('เดือน' + " " + months + " " + "ปี" + " " + (month_year - 543 + 1086))
                } else if (select == 'year') {
                    $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                    $('#label2').text('ประจำปี' + " " + (year - 543 + 1086))
                } else if (select == 'status') {
                    $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                    $('#label2').text('สถานะ' + " " + status1)
                } else {
                    $('#h').text('รายงานข้อมูลต้นทุนรายการปลูก')
                    $('#label2').text('รายงานข้อมูลทั้งหมด')
                }
                $('#output').html(data);
                console.log(data)
            }
        });
    }

    $('#output').show()
    $('#btn_print').hide()
    $('#btn_grap').hide()
    $('#btn_search').click(function() {
        var select = $('#type').val()
        var type_material = $('#type_material').val()
        var st_date = $('#st_date').val()
        var en_date = $('#en_date').val()
        var month = $('#month').val()
        var month_year = $('#month_year').val()
        var year = $('#txt_year').val()
        var status = $('#status').val()
        if (select == 0) {
            swal({
                text: "กรุณาเลือกวิธีการค้นหา",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'type' && type_material == 0) {

            swal({
                text: "กรุณาเลือกรายการปลูก",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'status' && status == 0) {

            swal({
                text: "กรุณาเลือกสถานะ",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'day' && st_date == 0 && en_date == 0) {

            swal({
                text: "กรุณาเลือกวันที่",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'day' && st_date != 0 && en_date == 0) {

            swal({
                text: "กรุณาเลือกวันที่ให้ครบถ้วน",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'day' && st_date == 0 && en_date != 0) {

            swal({
                text: "กรุณาเลือกวันที่ให้ครบถ้วน",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'month' && month == 0 && month_year == 0) {

            swal({
                text: "กรุณาเลือกเดือนและปี",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'month' && month != 0 && month_year == 0) {

            swal({
                text: "กรุณาเลือกเดือนและปีให้ครบถ้วน",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'month' && month == 0 && month_year != 0) {

            swal({
                text: "กรุณาเลือกเดือนและปีให้ครบถ้วน",
                icon: "warning",
                buttons: false,
            })

        } else if (select == 'year' && year == 0) {

            swal({
                text: "กรุณาเลือกปี",
                icon: "warning",
                buttons: false,
            })

        } else if (select == "day" && st_date != '' && en_date != '') {
            $('#output').show()
            $('#btn_print').show()
            $('#btn_grap').show()
            $('#g_show').hide()
            load_member(select, st_date, en_date, month, month_year, year, type_material, status)
        } else if (select == 'month' && month != "" && month_year != '') {
            $('#output').show()
            $('#btn_print').show()
            $('#btn_grap').show()
            $('#g_show').hide()
            load_member(select, st_date, en_date, month, month_year, year, type_material, status)
        } else if (select == 'year' && year != "") {
            $('#output').show()
            $('#btn_print').show()
            $('#btn_grap').show()
            $('#g_show').hide()
            load_member(select, st_date, en_date, month, month_year, year, type_material, status)
        } else if (select != 0 && type_material != 0) {
            $('#output').show()
            $('#btn_print').show()
            $('#btn_grap').show()
            $('#g_show').hide()
            load_member(select, st_date, en_date, month, month_year, year, type_material, status)
        } else if (select != 0 && status != 0) {
            $('#output').show()
            $('#btn_print').show()
            $('#btn_grap').show()
            $('#g_show').hide()
            load_member(select, st_date, en_date, month, month_year, year, type_material, status)
        } else {
            $('#output').show()
            $('#btn_print').show()
            $('#btn_grap').show()
            $('#g_show').hide()
            load_member(select, st_date, en_date, month, month_year, year, type_material, status)

        }
    })
    $('#type_material').hide()
    $('#type').change(function() {
        var select = $(this).val()
        if (select == 'type') {
            $('#type_material').show()
            $("#st_date").hide()
            $("#en_date").hide()
            $("#div_month").hide()
            $("#div_year").hide()
            $("#div_txt_year").hide()
            $("#status").hide()
            $('#pass').hide()
        } else if (select == 'day') {
            $('#type_material').hide()
            $("#st_date").show()
            $("#en_date").show()
            $("#div_month").hide()
            $("#div_year").hide()
            $("#div_txt_year").hide()
            $("#status").hide()
            $('#pass').show()
        } else if (select == 'month') {
            $('#type_material').hide()
            $("#st_date").hide()
            $("#en_date").hide()
            $("#div_month").show()
            $("#div_year").show()
            $("#div_txt_year").hide()
            $("#status").hide()
            $('#pass').hide()
        } else if (select == 'year') {
            $('#type_material').hide()
            $("#st_date").hide()
            $("#en_date").hide()
            $("#div_month").hide()
            $("#div_year").hide()
            $("#div_txt_year").show()
            $("#status").hide()
            $('#pass').hide()
        } else if (select == 'status') {
            $('#type_material').hide()
            $("#st_date").hide()
            $("#en_date").hide()
            $("#div_month").hide()
            $("#div_year").hide()
            $("#div_txt_year").hide()
            $("#status").show()
            $('#pass').hide()
        } else {
            $('#type_material').hide()
            $("#st_date").hide()
            $("#en_date").hide()
            $("#div_month").hide()
            $("#div_year").hide()
            $("#div_txt_year").hide()
            $("#status").hide()
            $('#pass').hide()
        }
    });
    $('#type_material').change(function() {
        var select = $(this).val()
        if (select != 0) {
            $.ajax({
                type: 'POST',
                url: './pages/get_material.php',
                data: 'type_material_id=' + select,
                success: function(html) {
                    $('#type_material').html(html);
                }
            });
        } else {
            swal({
                text: "กรุณาเลือกประเภทวัสดุปลูก",
                icon: "warning",
                buttons: false,
            })
        }
    });
    //load_employee()
</script>