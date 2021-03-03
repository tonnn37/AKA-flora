<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" />

<form action="./pages/new_report_order.php" method="POST" target="_blank">
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
                        <option value="type">ชื่อลูกค้า</option>
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
                    <select name="customer" class="form-control" id="customer">
                        <option value="0">----เลือกชื่อลูกค้า----</option>
                        <?php
                        $sql_type1 = "SELECT * FROM tb_customer  WHERE customer_status ='ปกติ' ORDER BY customer_id ASC";
                        $re_type1 = mysqli_query($conn, $sql_type1);
                        while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                        ?>
                            <option value="<?php echo $re_fac1["customer_id"]; ?>">
                                <?php echo $re_fac1["customer_firstname"]; ?>
                                <?php echo $re_fac1["customer_lastname"]; ?>
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
                        $sql_type1 = "SELECT * FROM tb_order_detail  GROUP BY order_detail_planting_status   ORDER BY order_detail_id ASC";
                        $re_type1 = mysqli_query($conn, $sql_type1);
                        while ($re_fac1 = mysqli_fetch_array($re_type1)) {
                        ?>
                            <option value="<?php echo $re_fac1["order_detail_planting_status"]; ?>">
                                <?php echo $re_fac1["order_detail_planting_status"]; ?>
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
        <div class="form-group">
            <button type="button" class="btn btn-secondary" id="btn_grap" name="btn_grap"><img src="image/1x/g.png" width="25px" height="25px"></button>
        </div>
    </div>

</form>
<div id="order">
    <table id="g_order" class="highchart" data-graph-type="column" style="display:none;" data-graph-datalabels-enabled="1" data-graph-datalabels-formatter="foo.myAwesomeCallback">
        <thead>
            <tr>
                <th>ประจำเดือน</th>
                <th>จำนวน</th>
            </tr>
        </thead>
        <tbody id="order_show">

        </tbody>
    </table>
</div>

<div id="show"><br>
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
    $('#btn_grap').click(function() {
        //$('#btn_print').attr("disabled", false);
        var select = $('#type').val()
        var customer = $('#customer').val()
        var st_date = $('#st_date').val()
        var en_date = $('#en_date').val()
        var month = $('#month').val()
        var month_year = $('#month_year').val()
        var year = $('#txt_year').val()
        var status = $('#status').val()
        var firstname = $("#customer option:selected").text();
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

        } else if (select == 'type' && customer == 0) {

            swal({
                text: "กรุณาเลือกชื่อลูกค้า",
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
                url: "./pages/get_order.php",
                type: "POST",
                data: {
                    select: select,
                    st_date: st_date,
                    en_date: en_date,
                    month: month,
                    month_year: month_year,
                    year: year,
                    customer: customer,
                    status: status
                },
                success: function(data) {

                    if (select == 'type') {
                        $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
                      /*   $('#label2').text('ชื่อลูกค้า' + firstname) */
                    } else if (select == 'day') {
                        $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
                        $('#label2').text('ระหว่างวันที่' + " " + st_date2 + " " + "ถึง" + " " + en_date2)
                    } else if (select == 'month') {
                        $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
                        $('#label2').text('เดือน' + " " + months + " " + "ปี" + " " + (month_year - 543 + 1086))
                    } else if (select == 'year') {
                        $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
                        $('#label2').text('ประจำปี' + " " + (year - 543 + 1086))
                    } else if (select == 'status') {
                        $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
                       /*  $('#label2').text('สถานะ' + " " + status1) */
                    } else {
                        $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
                        $('#label2').text('รายงานข้อมูลทั้งหมด')

                    }
                    console.log(data);
                    $('#output').hide()
                    $('#g_show').show()
                    var customer = {
                        Name: [],
                        Count: []
                    };

                    var len = data.length;

                    for (var i = 0; i < len; i++) {
                        customer.Name.push(data[i].customer_firstname + " " + data[i].customer_lastname);
                        customer.Count.push(data[i].count_number);


                    }
                    var max_count = Math.max.apply(Math, customer.Count);
                    //get canvas
                    var ctx = $("#g_show");
                    //alert(max_count)
                    var data = {
                        labels: customer.Name,
                        datasets: [{
                            label: "จำนวน (ครั้ง)",
                            data: customer.Count,
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
                                    labelString: "ชื่อลูกค้า",
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
                                    labelString: "จำนวนการสั่งซื้อ (ครั้ง)",

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

    })

    function load_member(select, st_date, en_date, month, month_year, year, customer, status) {
        var firstname = $("#customer option:selected").text();
        var months = $("#month option:selected").text();
        var status1 = $("#status option:selected").text();
        var st_date1 = new Date (st_date);
        var st_date2 = st_date1.toLocaleDateString();
        var en_date1 = new Date (en_date);
        var en_date2 = en_date1.toLocaleDateString();
        $.ajax({
            url: "./pages/report_order.php",
            method: "POST",
            data: {
                select: select,
                customer: customer,
                st_date: st_date,
                en_date: en_date,
                month: month,
                month_year: month_year,
                year: year,
                status: status
            },
            success: function(data) {
                if (select == 'type') {
                    $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
                    $('#label2').text('ชื่อลูกค้า' + firstname)
                } else if (select == 'day') {
                    $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
                    $('#label2').text('ระหว่างวันที่' + " " + st_date2 + " " + "ถึง" + " " + en_date2)
                } else if (select == 'month') {
                    $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
                    $('#label2').text('เดือน' + " " + months + " " + "ปี" + " " + (month_year - 543 + 1086))
                } else if (select == 'year') {
                    $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
                    $('#label2').text('ประจำปี' + " " + (year - 543 + 1086 ))
                } else if (select == 'status') {
                    $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
                    $('#label2').text('สถานะ' + " " + status1)
                } else {
                    $('#h').text('รายงานข้อมูลการสั่งซื้อของลูกค้า')
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
        var customer = $('#customer').val()
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

        } else if (select == 'type' && customer == 0) {

            swal({
                text: "กรุณาเลือกชื่อลูกค้า",
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
            load_member(select, st_date, en_date, month, month_year, year, customer, status)
        } else if (select == 'month' && month != "" && month_year != '') {
            $('#output').show()
            $('#btn_print').show()
            $('#btn_grap').show()
            $('#g_show').hide()
            load_member(select, st_date, en_date, month, month_year, year, customer, status)
        } else if (select == 'year' && year != "") {
            $('#output').show()
            $('#btn_print').show()
            $('#btn_grap').show()
            $('#g_show').hide()
            load_member(select, st_date, en_date, month, month_year, year, customer, status)
        } else if (select != 0 && customer != 0) {
            $('#output').show()
            $('#btn_print').show()
            $('#btn_grap').show()
            $('#g_show').hide()
            load_member(select, st_date, en_date, month, month_year, year, customer, status)
        } else if (select != 0 && status != 0) {
            $('#output').show()
            $('#btn_print').show()
            $('#btn_grap').show()
            $('#g_show').hide()
            load_member(select, st_date, en_date, month, month_year, year, customer, status)
        } else {
            $('#output').show()
            $('#btn_print').show()
            $('#btn_grap').show()
            $('#g_show').hide()
            load_member(select, st_date, en_date, month, month_year, year, customer, status)
        }
    })
    $('#customer').hide()
    $('#type').change(function() {
        var select = $(this).val()
        if (select == 'type') {
            $('#customer').show()
            $("#st_date").hide()
            $("#en_date").hide()
            $("#div_month").hide()
            $("#div_year").hide()
            $("#div_txt_year").hide()
            $("#status").hide()
            $('#pass').hide()
        } else if (select == 'day') {
            $('#customer').hide()
            $("#st_date").show()
            $("#en_date").show()
            $("#div_month").hide()
            $("#div_year").hide()
            $("#div_txt_year").hide()
            $("#status").hide()
            $('#pass').show()
        } else if (select == 'month') {
            $('#customer').hide()
            $("#st_date").hide()
            $("#en_date").hide()
            $("#div_month").show()
            $("#div_year").show()
            $("#div_txt_year").hide()
            $("#status").hide()
            $('#pass').hide()
        } else if (select == 'year') {
            $('#customer').hide()
            $("#st_date").hide()
            $("#en_date").hide()
            $("#div_month").hide()
            $("#div_year").hide()
            $("#div_txt_year").show()
            $("#status").hide()
            $('#pass').hide()
        } else if (select == 'status') {
            $('#customer').hide()
            $("#st_date").hide()
            $("#en_date").hide()
            $("#div_month").hide()
            $("#div_year").hide()
            $("#div_txt_year").hide()
            $("#status").show()
            $('#pass').hide()
        } else {
            $('#customer').hide()
            $("#st_date").hide()
            $("#en_date").hide()
            $("#div_month").hide()
            $("#div_year").hide()
            $("#div_txt_year").hide()
            $("#status").hide()
            $('#pass').hide()
        }
    });
    $('#customer').change(function() {
        var select = $(this).val()
        if (select != 0) {
            $.ajax({
                type: 'POST',
                url: './pages/get_order.php',
                data: 'order_id=' + select,
                success: function(html) {
                    $('#customer').html(html);
                }
            });
        } else {
            swal({
                text: "กรุณาเลือกชื่อลูกค้า",
                icon: "warning",
                buttons: false,
            })
        }
    });
    //load_employee()
</script>