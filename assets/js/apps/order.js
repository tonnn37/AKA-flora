$(document).ready(function () {

    //---- ตารางรายการ-----//
    fetch_order()
    function fetch_order() {
        var t = $('#orderTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 4,
                    className: 'dt-body-right'
                },
                {
                    targets: 8,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ระงับ") {
                            color = "red";
                        } else if (data == "เสร็จสิ้น") {
                            color = "green";
                        } else {
                            color = "black";
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },

            ],

            "language": {
                "search": "ค้นหา:",


                "info": "<h4> แสดง  _START_  ถึง _END_ ทั้งหมด จาก <strong style='color:red;'> _TOTAL_ </strong> รายการ </h4>",
                "zeroRecords": "ไม่พบรายการค้นหา",
                "infoEmpty": "แสดงรายการ 0 ถึง 0 ทั้งหมด 0 รายการ",
                "paginate": {
                    "first": "หน้าแรก",
                    "last": "หน้าสุดท้าย",
                    "next": ">>>",
                    "previous": "<<<"
                },


                "infoFiltered": "( คำที่ค้นหา จาก _MAX_ รายการ ทั้งหมด ) ",

            },
            "ajax": {
                url: "./pages/order/fetch_order.php",
                type: "post",

            }
        });
        t.on('order.dt search.dt', function () {
            t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }
    $(document).on("click", "#search_modal", function (event) {

        $("#serach_id")[0].reset()
    });
    $(document).on("click", "#btn_search", function (event) {


        var status = $("#search_status").val()
        console.log(status)
        var table = $("#orderTable").DataTable()
        table.destroy()

        $("#modal_search").modal("toggle")
        var tsd = $('#orderTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 4,
                    className: 'dt-body-right'
                },
                {
                    targets: 8,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ระงับ") {
                            color = "red";
                        } else if (data == "เสร็จสิ้น") {
                            color = "green";
                        } else {
                            color = "black";
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },

            ],

            "language": {
                "search": "ค้นหา:",


                "info": "<h4> แสดง  _START_  ถึง _END_ ทั้งหมด จาก <strong style='color:red;'> _TOTAL_ </strong> รายการ </h4>",
                "zeroRecords": "ไม่พบรายการค้นหา",
                "infoEmpty": "แสดงรายการ 0 ถึง 0 ทั้งหมด 0 รายการ",
                "paginate": {
                    "first": "หน้าแรก",
                    "last": "หน้าสุดท้าย",
                    "next": ">>>",
                    "previous": "<<<"
                },


                "infoFiltered": "( คำที่ค้นหา จาก _MAX_ รายการ ทั้งหมด ) ",

            },
            "ajax": {
                url: "./pages/order/fetch_order_search.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = status
                }
            }
        });
        tsd.on('order.dt search.dt', function () {
            tsd.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();




    });

    //-- ล้างค่าปุ่ม เพิ่มรายการ --//
    $(document).on("click", "#btn_in_order", function (event) {

        $("#addOrder")[0].reset();
        $('#add_picture').attr('src', "image/plant.PNG");
        var table = $("#add_orderTable").DataTable()
        table.clear().draw();
        arr_plant = []


    });
    $(document).on("change", "#in_order_typeplant", function (event) {

        var id_type = $(this).val();

        $.ajax({
            type: 'POST',
            url: './pages/order/get_plant.php',
            data: 'type_id=' + id_type,
            success: function (html) {
                $('#in_order_plant').html(html);
            }
        });


    });

    //เช็คแอดซ้ำ
    $(".in_order_name").on("change", function (event) {

        var order_name = $(this).val()

        $.ajax({
            url: "./pages/order/check_add_order.php",
            method: "POST",
            data: {
                order_name: order_name,

            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "มีรายการนี้อยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด"
                    });
                    $(".in_order_name").val("");
                    $(this).focus();
                }
            }
        });

    });

    $("#in_order_end").attr("disabled", true);
    $(document).on("change", "#in_order_plant", function (event) {

        var in_order_plant = $(this).val();
        $("#in_order_end").attr("disabled", false);
        if (in_order_plant == "0") {
            $("#in_order_end").attr("disabled", true);
        }

    });


    // เช็คจำนวนเงิน 
    $(".in_order_price").keyup(function () {

        var id = $(this).val()
        if (!id.match(/^([0-9 / .,])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }
    });

    // เช็คจำนวนต้น
    $(".in_order_amount").keyup(function () {

        var id = $(this).val()
        if (!id.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนปลูกเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#in_order_amount_total").val("");
            $("#in_order_plant_cal_amount_for").val("");
            $(this).focus();
            return false;
        }
    });

    // เรียกรูปภาพ 

    $("#in_order_plant").on("change", function (event) {

        var plant_id = $(this).val();
        if (plant_id == 0) {

            $('#add_picture').attr('src', "image/plant.PNG");
        } else {
            $.ajax({
                type: 'POST',
                url: './pages/order/get_image.php',
                data: 'id_plant=' + plant_id,
                success: function (html) {
                    $('#add_picture').attr('src', "image/plant/" + html);

                }
            });
        }
    });


    //เรียก สัปดาห์
    $(document).on("change", "#in_order_plant", function (event) {

        var id_plant = $(this).val();

        $.ajax({
            type: 'POST',
            url: './pages/order/get_week.php',
            data: 'id_plant=' + id_plant,
            success: function (html) {

                $('#in_order_plant_time').val(html);
            }
        });

    });
    //เรียก วัน

    $(document).on("change", "#in_order_plant", function (event) {

        var id_plant = $(this).val();
        if (id_plant == 0) {


            $('.show_amount').prop("hidden", true);
            $("#in_order_plant_time_day").val("");
            $("#in_order_end").val("");
            $("#in_order_day").val("");


        } else {

            $('.show_amount').prop("hidden", false);


            $.ajax({
                type: 'POST',
                url: './pages/order/get_day.php',
                data: 'id_plant=' + id_plant,
                success: function (html) {

                    $('#in_order_plant_time_day').val(html);

                    days1 = html
                    days1 = parseInt(days1);
                    days2 = days1 + 14;



                    $.ajax({
                        type: 'POST',
                        url: './pages/order/get_date.php',
                        data: {
                            date2: days2
                        },
                        success: function (html) {

                            console.log(html);
                            $('#in_order_end').val(html);
                            totalday = html;
                            /*      if (in_order_end < datenow) {
         
                                     swal({
                                         title: "แจ้งเตือน",
                                         text: "กรุณาเลือกวันที่ให้มากกว่า ระยะเวลาปลูกอย่างน้อย " + " " + days2 + " " + "วัน",
                                         icon: "warning",
                                         buttons: "ปิด",
                                     })
                                 }           */
                            $('#in_order_day').val(days2);

                            daytotal = days2
                        }
                    });
                }
            });

            $.ajax({
                type: 'POST',
                url: './pages/order/get_stock.php',
                data: {
                    id_plant: id_plant

                },
                success: function (html) {
                    /* console.log(html) */
                    $('.show_amount').html(html);
                    $('.show_amount').css('color', 'red');

                }
            });
        }
    });
    var totalday;
    var daytotal

    //เช็ค แอดซ้ำ 
    $(document).on("change", "#in_order_plant", function (event) {

        var id_type = $(this).val();
        var txt_plant = $("#in_order_plant option:selected").text();
        var l1 = $('#add_orderTable td:nth-child(3)').map(function () {
            return $(this).text();
        }).get();
        //l1.shift()
        if ($.inArray(txt_plant, l1) >= 0) {
            swal({
                title: "แจ้งเตือน",
                text: "คุณได้เพิ่มพันธุ์ไม้นี้ไปแล้ว กรุณาเลือกใหม่อีกครั้ง",
                icon: "warning",
                buttons: "ปิด",
            })
            $("#in_order_typeplant option[value='0']").prop('selected', true);
            $("#in_order_plant option[value='0']").prop('selected', true);
            $("#in_order_plant_time").val("");
            $("#in_order_plant_cal_amount_for").val("");

            $("#in_order_plant_time").val("");
            $("#in_order_plant_time_day").val("");
            $("#in_order_end").val("");
            $("#in_order_day").val("");

        }

    });

    // เรียกวันที่ 


    $(document).on("change", "#in_order_end", function (event) {

        var date2 = $(this).val();
        var datenow = $("#in_order_daynow").val();

        if (date2 <= datenow) {

            swal({
                title: "แจ้งเตือน",
                text: "ควรเลือกวันที่ปลูกให้มากกว่าวันที่ปัจจุบัน",
                icon: "warning",
                buttons: "ปิด",
            })
            $('#in_order_end').val(totalday);
            $('#in_order_day').val(daytotal);
        } else {

            $.ajax({
                type: 'POST',
                url: './pages/order/get_date_change.php',
                data: {
                    date2: date2
                },
                success: function (html) {

                    console.log(html);

                    if (html < daytotal) {

                        swal({
                            title: "คำแนะนำ",
                            text: "ควรเลือกระยะเวลาปลูกอย่างน้อย " + " " + daytotal + " " + "วัน" +
                                " " + "หรือวันที่" + " " + totalday,
                            icon: "warning",
                            buttons: "ปิด",
                        })
                    }
                    $('#in_order_day').val(html);


                }
            });

        }

    });


    //คำนวน จำนวนปลูกเผื่อ

    $(document).on("change", "#in_order_amount_for", function (event) {

        var in_order_amount = $("#in_order_amount").val();
        var in_order_amount_for = $(this).val();

        in_order_amount = in_order_amount.replace(/,/g, "");
        in_order_amount = parseInt(in_order_amount);
        if (in_order_amount_for > 100) {
            swal({
                text: "กรุณากรอกจำนวนปลูกเผื่อไม่เกิน 100%",
                icon: "warning",
                button: "ปิด"
            });
            $('#in_order_amount_for').val("");
            $('#in_order_amount_total').val("");

        } else if (in_order_amount_for == 0 || in_order_amount_for <= 0) {

            $('#in_order_amount_for').val("0");
            $('#in_order_amount_total').val(in_order_amount);
        } else if (!in_order_amount_for.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนปลูกเผื่อ เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;

        } else {


            var sum = (in_order_amount * in_order_amount_for) / 100;
            var total = in_order_amount + sum;

            $('#in_order_plant_cal_amount_for').val(sum);
            $('#in_order_amount_total').val(total);
        }
    });


    $(document).on("change", "#in_order_amount", function (event) {

        var in_order_amount_for = $("#in_order_amount_for").val();
        var in_order_amount = $(this).val();
        in_order_amount = in_order_amount.replace(/,/g, "");
        in_order_amount = parseInt(in_order_amount);

        if (in_order_amount <= 0) {
            swal({
                text: "กรุณากรอกจำนวนปลูก ให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");

        } else if (in_order_amount_for > 100) {
            swal({
                text: "กรุณากรอกจำนวนปลูกเผื่อไม่เกิน 100%",
                icon: "warning",
                button: "ปิด"
            });
            $('#in_order_amount_for').val("");
            $('#in_order_amount_total').val("");

        } else if (in_order_amount_for == 0 || in_order_amount_for <= 0) {

            $('#in_order_amount_for').val("0");
            $('#in_order_amount_total').val(in_order_amount);
        } else {


            var sum = (in_order_amount * in_order_amount_for) / 100;
            var total = in_order_amount + sum;

            $('#in_order_plant_cal_amount_for').val(sum);
            $('#in_order_amount_total').val(total);
        }
    });



    //ตาราง รายละเอียดรายการ
    var td = $('#add_orderTable').DataTable({
        autoWidth: true,


        "responsive": true,
        "lengthChange": false,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            {
                targets: 8,
                render: function (data, type, row) {
                    var color = 'black';
                    if (data == "เสร็จสิ้น") {
                        color = "green";
                    } else if (data == "ระงับ") {
                        color = "red";
                    } else {
                        color = "black";
                    }
                    return '<span style="color:' + color + '">' + data + '</span>';
                }
            },

        ],

        "language": {
            "search": "ค้นหา:",


            "info": "<h4> แสดง  _START_  ถึง _END_ ทั้งหมด จาก <strong style='color:red;'> _TOTAL_ </strong> รายการ </h4>",
            "zeroRecords": "ไม่พบรายการค้นหา",
            "infoEmpty": "แสดงรายการ 0 ถึง 0 ทั้งหมด 0 รายการ",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": ">>>",
                "previous": "<<<"
            },


            "infoFiltered": "( คำที่ค้นหา จาก _MAX_ รายการ ทั้งหมด ) ",

        }
    });




    var i = 1;
    var runid
    //-- เพิ่มรหัส ยา ใหม่ ให้เป็น EMP63001-1 --//
    $(document).on("click", "#in_order_plant", function (event) {

        var id = $(this).attr('data-id')

        $.ajax({
            type: 'POST',
            url: './pages/order/get_maxid_one.php',
            data: 'id=' + id,
            success: function (data) {
                console.log(data)

                runid = data + "-" + checknumid2(i)

            }
        });

    })

    // เพิ่่ม รหัสยา ให้เป็น -01 //
    function checknumid2(i) {
        if (i < 10) {
            i = "0" + i
        } else {
            i = i
        }
        return i
    }




    // ปุ่มเพิ่มข้อมูลรายการออเดอร์  // 
    var arr_plant = []
    $(document).on("click", "#btn_add_order", function (event) {

        i++
        var txt_typeplant = $("#in_order_typeplant option:selected").text();


        var in_order_typeplant = $("#in_order_typeplant").val();
        var in_order_plant = $("#in_order_plant").val();
        var txt_plant = $("#in_order_plant option:selected").text();
        var in_order_amount = $("#in_order_amount").val();
        var in_order_amount_for = $("#in_order_amount_for").val();

        var in_order_amount_total = $("#in_order_amount_total").val();

        var in_order_end = $("#in_order_end").val();

        var in_order_day = $("#in_order_day").val();


        var amount_for = parseInt(in_order_amount_total) - parseInt(in_order_amount)
        var button = '<button id="re" class="btn btn-danger btn-xs my-xs-btn" data-toggle="tooltip"  title="ลบข้อมูล" type="button"><i class="fas fa-trash-alt" style="color:white;"></i></button>';

        if (in_order_typeplant == "0") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกประเภทพันธุ์ไม้",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_order_plant == "0") {  //เช็คจำนวนห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกพันธุ์ไม้",
                icon: "warning",
                buttons: "ปิด",
            })


        } else if (in_order_amount == "" || in_order_amount <= 0) {  //เช็คจำนวนห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวน",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_order_amount_for == "") {  //เช็คจำนวนห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนปลูกเผื่อ",
                icon: "warning",
                buttons: "ปิด",
            })

        } else if (in_order_end == "") {  // เช็คยาห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกวันที่ส่งมอบ",
                icon: "warning",
                buttons: "ปิด",
            })

        } else {
            td.row.add([  // ส่งข้อมูลเข้าไปแสดงที่ตาราง 
                "",
                runid,
                txt_plant,
                in_order_amount,
                amount_for,
                in_order_amount_total,
                in_order_end,
                in_order_day,
                button

            ]).draw(false);
            arr_plant.push(in_order_plant)
            console.log(arr_plant)

            $('#add_picture').attr('src', "image/plant.PNG");
            $("#in_order_typeplant option[value='0']").prop('selected', true);
            $("#in_order_plant option[value='0']").prop('selected', true);
            $("#in_order_day").val("");
            $("#in_order_end").val("");
            $("#in_order_amount_total").val("");
            $("#in_order_plant_time").val("");
            $("#in_order_plant_time_day").val("");
            $("#in_order_amount").val("");
            $("#in_order_amount_for").val("");

        }

    });
    td.on('order.dt search.dt', function () {
        td.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
    $(document).on("click", "#re", function (event) {   //คำสั่งลบข้อมูลในตาราง
        td
            .row($(this).parents('tr'))
            .remove()
            .draw();

    });


    //จบปุ่มเพิ่มรายการออเดอร์
    //--- ปุ่มบันทึกรายการออเดอร์  ---//
    $(document).on("click", "#btn_save_order", function (event) {


        var in_order_cutomer = $("#in_order_cutomer").val()
        var in_order_price = $("#in_order_price").val()
        var in_order_detail = $("#in_order_detail").val()

        var in_id_order = $('#add_orderTable td:nth-child(2)').map(function () {
            return $(this).text();
        }).get();

        var in_order_name = $('#in_order_name').val();
        /*     var in_order_plant = $('#add_orderTable td:nth-child(3)').map(function () {
                return $(this).text();
            }).get();
     */
        var in_order_amount = $('#add_orderTable td:nth-child(4)').map(function () {
            return $(this).text();
        }).get();
        var in_order_amountfor = $('#add_orderTable td:nth-child(5)').map(function () {
            return $(this).text();
        }).get();

        var in_order_amounttotal = $('#add_orderTable td:nth-child(6)').map(function () {
            return $(this).text();
        }).get();

        var in_order_end = $('#add_orderTable td:nth-child(7)').map(function () {
            return $(this).text();
        }).get();

        if (in_id_order.length == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกรายการสั่งซื้อ",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_order_name == "") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกชื่อรายการ",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_order_cutomer == "") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกชื่อลูกค้า",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_order_price == "") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนเงิน",
                icon: "warning",
                buttons: "ปิด",
            })
            /*   } else if (in_order_detail == "") {
                  swal({
                      title: "แจ้งเตือน",
                      text: "กรุณากรอกรายละเอียด",
                      icon: "warning",
                      buttons: "ปิด",
                  }) */
        } else {

            $.ajax({
                url: "./pages/order/insert_order.php",
                method: "POST",
                data: {
                    in_id_order: in_id_order,
                    in_order_cutomer: in_order_cutomer,
                    in_order_price: in_order_price,
                    in_order_name: in_order_name,
                    in_order_plant: arr_plant,
                    in_order_amount: in_order_amount,
                    in_order_amountfor: in_order_amountfor,
                    in_order_amounttotal: in_order_amounttotal,
                    in_order_end: in_order_end,
                    in_order_detail: in_order_detail
                },
                success: function (data) {

                    swal({
                        text: "เพิ่มข้อมูลเรียบร้อย",
                        icon: "success",
                        button: false
                    })
                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                    console.log(data)
                }
            });
        }

    });
    //จบปุ่มบันทึก รายการออเดอร์

    //-- ล้างค่าปุ่ม เพิ่มรายการออเดอร์ --//
    $(document).on("click", "#btn_add_orders", function (event) {
        var id = $(this).attr("data")
        console.log(id)

        od_id = id;
        console.log(od_id);
        /* $(".orderDetail")[0].reset();
        $('#add_picture_detail' + id).attr('src', "image/plant.PNG"); */



        $.ajax({
            type: 'POST',
            url: './pages/order/get_maxid_detail.php',
            data: 'id=' + id,
            success: function (data) {
                console.log(data)
                maxid = data;
                if (data == '') {

                    var sub_data = id.substr(12, 2)
                    var t_id = id + '-' + '01'
                    $('#in_order_id_detail' + id).val(t_id)
                } else {

                    var num = data.substr(12, 2)

                    sub_data = parseInt(num) + 1
                    console.log(sub_data)
                    var t_id = id + '-' + checknumid2(sub_data)

                    $('#in_order_id_detail' + id).val(t_id)
                }

            }
        });



    })


    // เพิ่่ม รหัสยา ให้เป็น -01 //
    function checknumid2(i) {
        if (i < 10) {
            i = "0" + i
        } else {
            i = i
        }
        return i
    }


    var od_id

    $(document).on("change", ".in_order_typeplant_detail", function (event) {

        var id_type = $(this).val();
        console.log(id_type)

        $.ajax({
            type: 'POST',
            url: './pages/order/get_plant.php',
            data: 'type_id=' + id_type,
            success: function (html) {
                $('#in_order_plant_detail' + od_id).html(html);
            }
        });
    });

    //--- เช็คแอดเพิ่มจำนวนรายการ ซ้ำ ---//
    $(".in_order_plant_detail").on("change", function (event) {
        var plant_id = $(this).val();
        var type_plant = $("#in_order_typeplant_detail" + od_id).val();
        /*   console.log(od_id)
          console.log(plant_id)
          console.log(type_plant) */
        $.ajax({
            url: "./pages/order/check_add_detail.php",
            method: "POST",
            data: {
                od_id: od_id,
                plant_id: plant_id,
                type_plant: type_plant
            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "มีพันธุ์ไม้นี้อยู่ในรายการแล้ว กรุณาเลือกใหม่",
                        icon: "warning",
                        button: "ปิด"
                    });
                    /*  $(".in_order_typeplant_detail option[value='0']").prop('selected', true); */
                    $(".in_order_plant_detail option[value='0']").prop('selected', true);
                    $('.add_picture_detail').attr('src', "image/plant.PNG");
                    $(this).focus();
                } else {
                    $.ajax({
                        type: 'POST',
                        url: './pages/order/get_image.php',
                        data: 'id_plant=' + plant_id,
                        success: function (html) {
                            $('#add_picture_detail' + od_id).attr('src', "image/plant/" + html);

                        }
                    });
                }
            }
        });

    });


    // เช็คจำนวนต้น
    $(".in_order_amount_detail").keyup(function () {

        var id = $(this).val()
        if (!id.match(/^([0-9 / .,])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }
    });


    $(".in_order_plant_detail").attr("disabled", true);
    $(".in_order_end_detail").attr("disabled", true);



    $(document).on("change", ".in_order_typeplant_detail", function (event) {
        var in_order_typeplant_detail = $(this).val()

        $("#in_order_plant_detail" + od_id).attr("disabled", false)
        if (in_order_typeplant_detail == "0") {

            $(".in_order_plant_detail option[value='0']").prop('selected', true);
            $(".in_order_plant_detail").attr("disabled", true);
            $('#in_order_plant_time_detail' + od_id).val("");
            $('#in_order_plant_time_day_detail' + od_id).val("");
            $('#in_order_end_detail' + od_id).val("");
            $('#in_order_day_detail' + od_id).val("");

        } else {
            $(".in_order_plant_detail").attr("disabled", false)
        }

    });


    /* $(document).on("change", "#in_order_typeplant_detail", function (event) {
        var in_order_typeplant_detail = $(this).val();

        $("#in_order_plant_detail").attr("disabled", false);

        if (in_order_typeplant_detail == "0") {

            $("#in_order_plant_detail").attr("disabled", true);
            $("#in_order_plant_detail option[value='0']").prop('selected', true);
            $('#in_order_plant_time_detail').val("");
            $('#in_order_plant_time_day_detail').val("");
            $('#in_order_end_detail').val("");
            $('#in_order_day_detail').val("");
        }
    });
 */
    $(document).on("change", ".in_order_plant_detail", function (event) {

        var in_order_plant_detail = $(this).val();
        $(".in_order_end_detail").attr("disabled", false);

        if (in_order_plant_detail == "0") {
            $(".in_order_end_detail").attr("disabled", true);
            $('.in_order_end_detail').val("");
            $('.in_order_day_detail').val("");


        }
    });


    //เรียก สัปดาห์
    $(document).on("change", ".in_order_plant_detail", function (event) {

        var id_plant = $(this).val();

        $.ajax({
            type: 'POST',
            url: './pages/order/get_week.php',
            data: 'id_plant=' + id_plant,
            success: function (html) {

                $('#in_order_plant_time_detail' + od_id).val(html);
            }
        });

    });
    //เรียก วัน
    $(document).on("change", ".in_order_plant_detail", function (event) {

        var id_plant = $(this).val();

        $.ajax({
            type: 'POST',
            url: './pages/order/get_day.php',
            data: 'id_plant=' + id_plant,
            success: function (html) {

                $('#in_order_plant_time_day_detail' + od_id).val(html);
            }
        });

    });

    // เรียกวันที่ 
    $(document).on("change", ".in_order_end_detail", function (event) {

        var total;
        var date2 = $("#in_order_end_detail" + od_id).val();
        var in_order_plant_time_day = $("#in_order_plant_time_day_detail" + od_id).val()
        var in_order_plant_time = $("#in_order_plant_time_detail" + od_id).val()
        $.ajax({
            type: 'POST',
            url: './pages/order/get_date.php',
            data: {
                date2: date2

            },
            success: function (html) {

                console.log(html);
                console.log(in_order_plant_time_day);
                html = parseInt(html);
                in_order_plant_time_day = parseInt(in_order_plant_time_day);
                total = html - in_order_plant_time_day;
                var day = in_order_plant_time_day + 14;
                day = parseInt(day)
                if (total < 14) {

                    swal({
                        title: "แจ้งเตือน",
                        text: "กรุณาเลือกวันที่ให้มากกว่า ระยะเวลาปลูกอย่างน้อย " + " " + day + " " + "วัน",
                        icon: "warning",
                        buttons: "ปิด",
                    })
                    $('#in_order_day_detail' + od_id).val("");

                } else if (in_order_plant_time == "") {

                    $('#in_order_day_detail' + od_id).val("");

                } else {
                    $('#in_order_day_detail' + od_id).val(html);
                }
            }
        });

    });

    $(document).on("change", ".in_order_amount_for_detail", function (event) {

        var in_order_amount = $("#in_order_amount_detail" + od_id).val();
        var in_order_amount_for = $(this).val();

        in_order_amount = in_order_amount.replace(/,/g, "");
        in_order_amount = parseInt(in_order_amount);

        if (in_order_amount_for > 100) {
            swal({
                text: "กรุณากรอกจำนวนปลูกเผื่อไม่เกิน 100%",
                icon: "warning",
                button: "ปิด"
            });
            $('#in_order_amount_for_detail' + od_id).val("");
            $('#in_order_amount_total_detail' + od_id).val("");

        } else if (in_order_amount_for == 0 || in_order_amount_for < 0) {

            $('#in_order_amount_for_detail' + od_id).val("0");
            $('#in_order_amount_total_detail' + od_id).val(in_order_amount);
        } else {



            var sum = (in_order_amount * in_order_amount_for) / 100;
            var total = in_order_amount + sum;

            $('#in_order_amount_total_detail' + od_id).val(total);
        }
    });


    $(document).on("change", ".in_order_amount_detail", function (event) {

        var in_order_amount_for = $("#in_order_amount_for_detail" + od_id).val();
        var in_order_amount = $(this).val();
        in_order_amount = in_order_amount.replace(/,/g, "");
        in_order_amount = parseInt(in_order_amount);
        if (in_order_amount_for > 100) {
            swal({
                text: "กรุณากรอกจำนวนปลูกเผื่อไม่เกิน 100%",
                icon: "warning",
                button: "ปิด"
            });
            $('#in_order_amount_for_detail' + od_id).val("");
            $('#in_order_amount_total_detail' + od_id).val("");

        } else if (in_order_amount_for == 0 || in_order_amount_for < 0) {

            $('#in_order_amount_for_detail' + od_id).val("0");
            $('#in_order_amount_total_detail' + od_id).val(in_order_amount);
        } else {


            var sum = (in_order_amount * in_order_amount_for) / 100;
            var total = in_order_amount + sum;


            $('#in_order_amount_total_detail' + od_id).val(total);
        }
    });


    /*     var maxid; */
    //-- เพิ่มรหัส ยา ใหม่ ให้เป็น EMP63001-1 --//
    /*   $(document).on("change", "#in_order_name_detail", function (event) {
  
          var id = $(this).val()
  
          $.ajax({
              type: 'POST',
              url: './pages/order/get_maxid_detail.php',
              data: 'id=' + id,
              success: function (data) {
                  console.log(data)
                  maxid = data;
                  if (data == '') {
  
                      var sub_data = id.substr(12, 2)
                      var t_id = id + '-' + '01'
                      $('#in_order_id_detail').val(t_id)
                  } else {
  
                      var num = data.substr(12, 2)
  
                      sub_data = parseInt(num) + 1
                      console.log(sub_data)
                      var t_id = id + '-' + checknumid2(sub_data)
  
                      $('#in_order_id_detail').val(t_id)
                  }
  
              }
          });
  
      })
  
      // เพิ่่ม รหัสยา ให้เป็น -01 //
      function checknumid2(i) {
          if (i < 10) {
              i = "0" + i
          } else {
              i = i
          }
          return i
      }
  
   */



    //--- ปุ่มเพิ่มรายการออเดอร์  ---//
    $(document).on("click", "#btn_save_order_detail", function (event) {


        var in_order_id_detail = $("#in_order_id_detail" + od_id).val()
        var in_order_typeplant_detail = $("#in_order_typeplant_detail" + od_id).val()
        var in_order_plant_detail = $("#in_order_plant_detail" + od_id).val()
        var in_order_amount_detail = $("#in_order_amount_detail" + od_id).val()
        var in_order_amount_for_detail = $("#in_order_amount_for_detail" + od_id).val()
        var in_order_amount_total_detail = $("#in_order_amount_total_detail" + od_id).val()

        var in_order_end_detail = $("#in_order_end_detail" + od_id).val()

        /* console.log(od_id)
        console.log(in_order_id_detail)
        console.log(in_order_typeplant_detail)
        console.log(in_order_plant_detail)
        console.log(in_order_amount_detail)
        console.log(in_order_amount_for_detail)
        console.log(in_order_amount_total_detail)
        console.log(in_order_end_detail) */

        if (in_order_typeplant_detail == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกประเภทพันธุ์ไม้",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_order_plant_detail == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกพันธุ์ไม้",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_order_amount_detail == "" || in_order_amount_detail <= 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวน",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_order_end_detail == "") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกวันที่ส่งมอบ",
                icon: "warning",
                buttons: "ปิด",
            })
        } else {


            $.ajax({
                url: "./pages/order/insert_order_detail.php",
                method: "POST",
                data: {
                    od_id: od_id,
                    in_order_id_detail: in_order_id_detail,
                    in_order_plant_detail: in_order_plant_detail,
                    in_order_amount_detail: in_order_amount_detail,
                    in_order_amount_for_detail: in_order_amount_for_detail,
                    in_order_amount_total_detail: in_order_amount_total_detail,
                    in_order_end_detail: in_order_end_detail,
                },
                success: function (data) {

                    swal({
                        text: "เพิ่มข้อมูลเรียบร้อย",
                        icon: "success",
                        button: false
                    })
                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                    console.log(data)
                }
            });
        }

    });
    //จบปุ่มเพิ่มรายการออเดอร์

    //-- รีเซ็ตค่า --//
    $(document).on("click", "#edit_orders", function (event) {

        var id = $(this).attr('data');

        $("#editOrder" + id)[0].reset();


    });


    //--- เช็คเปลี่ยนชื่อรายการ ซ้ำ ---//
    $(".edit_order_name").on("change", function (event) {
        var id = $(this).attr("data-id");
        var edit_order_name = $("#edit_order_name" + id).val();

        $.ajax({
            url: "./pages/order/check_edit_order.php",
            method: "POST",
            data: {
                id: id,
                edit_order_name: edit_order_name

            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "ชื่อรายการนี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด"
                    });
                    $("#edit_order_name" + id).val("");
                    $(this).focus();
                }
            }
        });

    });

    // เช็คจำนวนเงิน 
    $(".edit_order_price").keyup(function () {

        var id = $(this).val()
        if (!id.match(/^([0-9 / .,])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }
    });




    //--- ปุ่มแก้ไขรายการออเดอร์  ---//
    $(document).on("click", "#btn_edit_save_order", function (event) {
        var id = $(this).attr('data-id');

        var edit_order_name = $("#edit_order_name" + id).val()
        var edit_order_cutomer = $("#edit_order_cutomer" + id).val()
        var edit_order_price = $("#edit_order_price" + id).val()
        var edit_order_detail = $("#edit_order_detail" + id).val()


        if (edit_order_name == "") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกชื่อรายการ",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (edit_order_cutomer == "") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกชื่อลูกค้า",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (edit_order_price == "" || edit_order_price <= 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนเงิน",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (edit_order_detail == "") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกรายละเอียด",
                icon: "warning",
                buttons: "ปิด",
            })
        } else {


            $.ajax({
                url: "./pages/order/update_order.php",
                method: "POST",
                data: {
                    id: id,
                    edit_order_name: edit_order_name,
                    edit_order_cutomer: edit_order_cutomer,
                    edit_order_price: edit_order_price,
                    edit_order_detail: edit_order_detail,
                },
                success: function (data) {

                    swal({
                        text: "แก้ไขข้อมูลเรียบร้อย",
                        icon: "success",
                        button: false
                    })
                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                    console.log(data)
                }
            });
        }

    });
    //จบปุ่มแก้ไขรายการออเดอร์

    //---- Remove order-----//
    $(document).on("click", "#btn_remove_order", function (event) {
        var order_id = $(this).attr('data')
        var order_status = $(this).attr('data-status')
        var order_name = $(this).attr("data-name")
        var order_detail_id = $(this).attr("data-order")
        console.log(order_id)
        console.log(order_status)

        if (order_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลรายการ : " + order_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "pages/order/remove_order.php",
                            method: "POST",
                            data: {
                                order_id: order_id,
                                order_status: order_status,
                                order_detail_id: order_detail_id
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
                                console.log(data)
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        } else {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกการระงับข้อมูลรายการ : " + order_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "pages/order/remove_order.php",
                            method: "POST",
                            data: {
                                order_id: order_id,
                                order_status: order_status,
                                order_detail_id: order_detail_id
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกการระงับข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        }

    });
    function fetch_order_detail(id) {
        var a = $('#tb_order_detail').DataTable({
            retrieve: true,
            paging: true,

            "responsive": true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 9,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ระงับ") {
                            color = 'red';
                        } else if (data == "รอส่งมอบ") {
                            color = "#CC00FF"
                        } else if (data == "เสร็จสิ้น") {
                            color = "green"
                        } else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 8,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "เสร็จสิ้น") {
                            color = 'green';
                        } else if (data == "กำลังทำการปลูก") {
                            color = 'blue';
                        }
                        else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 7,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "สิ้นสุด") {
                            color = 'red';
                        } else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 3,
                    className: 'dt-body-right'
                },
                {
                    targets: 4,
                    className: 'dt-body-right'
                },
                {
                    targets: 5,
                    className: 'dt-body-right'
                },
            ],

            "language": {
                "search": "ค้นหา:",

                "sLengthMenu": "",
                "info": "<h4> แสดง  _START_  ถึง _END_ จาก <strong style='color:red;'> _TOTAL_ </strong> รายการ </h4>",
                "zeroRecords": "ไม่พบรายการค้นหา",
                "infoEmpty": "แสดงรายการ 0 ถึง 0 จาก 0 รายการ",
                "paginate": {
                    "first": "หน้าแรก",
                    "last": "หน้าสุดท้าย",
                    "next": ">>>",
                    "previous": "<<<"
                },


                "infoFiltered": "( คำที่ค้นหา _TOTAL_ จาก _MAX_ รายการ  ) ",

            },
            "ajax": {
                url: "./pages/order/fetch_order_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }
            }
        })
        a.on('order.dt search.dt', function () {
            a.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    }
    //---  ตารางรายละเอียด Order  --//
    $(document).on("click", "#btn_viewdialog", function (event) {
        var table = $('#tb_order_detail').DataTable();
        table.destroy();
        var id = $(this).attr('data-id')
        var customer_name = $(this).attr('data-customer')

        $("#show_order_id").text(id)
        $("#show_customer").text(customer_name)

        o_detail_id = id
        console.log(id)
        fetch_order_detail(id)
    });

    var o_detail_id;

    $(document).on("click", "#edit_details", function (event) {

        var order_detail_id = $(this).attr("data");
        var plant_id = $(this).attr("data-plant");
        var order_amount = $(this).attr("data-amount");
        var order_for = $(this).attr("data-for");
        var order_total = $(this).attr("data-total");
        order_amount = parseInt(order_amount);
        order_for = parseInt(order_for);
        order_total = parseInt(order_total);

        var sum1 = order_total - order_amount;
        var sum2 = sum1 / order_amount;
        var total = sum2 * 100;
        console.log(total)

        sumper = (order_amount * order_for) / 100

        $("#edit_detailorder" + order_detail_id)[0].reset();

        $('#edit_order_amount_for_detail' + order_detail_id).val(total);
        $('#edit_order_amount_for_detail_for' + order_detail_id).val(order_for);

        console.log(order_detail_id)
        $.ajax({
            type: 'POST',
            url: './pages/order/get_week.php',
            data: 'id_plant=' + plant_id,
            success: function (html) {

                $('#edit_order_plant_time_detail' + order_detail_id).val(html);
            }
        });

        $.ajax({
            type: 'POST',
            url: './pages/order/get_day.php',
            data: 'id_plant=' + plant_id,
            success: function (html) {

                $('#edit_order_plant_time_day_detail' + order_detail_id).val(html);
            }
        });



        var date2 = $("#edit_order_end_detail" + order_detail_id).val();
        var date1 = $("#edit_order_daynow_detail" + order_detail_id).val();


        $.ajax({
            type: 'POST',
            url: './pages/order/get_edit_day.php',
            data: {
                date2: date2

            },
            success: function (html) {
                console.log(html)
                var date3 = date2;
                var date4 = date1;

                console.log(html);
                if (date4 > date3) {

                    $('#edit_order_day_detail' + order_detail_id).val("สิ้นสุดการปลูก");
                } else {
                    $('#edit_order_day_detail' + order_detail_id).val(html);

                }
            }
        });

    });



    $(document).on("change", ".edit_order_amount_for_detail", function (event) {
        var id = $(this).attr("data-id")
        var edit_order_amount_for = $(this).val();
        var edit_order_amount = $("#edit_order_amount_detail" + id).val();

        edit_order_amount = edit_order_amount.replace(/,/g, "");
        edit_order_amount = parseInt(edit_order_amount);

        if (edit_order_amount_for > 100) {
            swal({
                text: "กรุณากรอกจำนวนปลูกเผื่อไม่เกิน 100%",
                icon: "warning",
                button: "ปิด"
            });
            $('#edit_order_amount_for_detail' + id).val("");
            $('#edit_order_amount_total_detail' + id).val("");

        } else if (edit_order_amount_for == 0 || edit_order_amount_for < 0) {

            $('#edit_order_amount_for_detail' + id).val("0");
            $('#edit_order_amount_total_detail' + id).val(edit_order_amount);
        } else {

            var sum = (edit_order_amount * edit_order_amount_for) / 100;
            var total = edit_order_amount + sum;

            $('#edit_order_amount_total_detail' + id).val(total);
            $('#edit_order_amount_for_detail_for' + id).val(sum);
        }
    });

    $(document).on("change", ".edit_order_amount_detail", function (event) {
        var id = $(this).attr("data-id")
        var edit_order_amount_for = $("#edit_order_amount_for_detail" + id).val();
        var edit_order_amount = $(this).val();

        edit_order_amount_for = edit_order_amount_for.replace(/,/g, "");
        edit_order_amount_for = parseInt(edit_order_amount_for);

        edit_order_amount = edit_order_amount.replace(/,/g, "");
        edit_order_amount = parseInt(edit_order_amount);

        if (edit_order_amount_for > 100) {
            swal({
                text: "กรุณากรอกจำนวนปลูกเผื่อไม่เกิน 100%",
                icon: "warning",
                button: "ปิด"
            });
            $('#edit_order_amount_for_detail' + id).val("");
            $('#edit_order_amount_total_detail' + id).val("");

        } else if (edit_order_amount_for == 0 || edit_order_amount_for < 0) {

            $('#edit_order_amount_for_detail' + id).val("0");
            $('#edit_order_amount_total_detail' + id).val(edit_order_amount);
        } else {

            var sum = (edit_order_amount * edit_order_amount_for) / 100;
            var total = edit_order_amount + sum;

            $('#edit_order_amount_total_detail' + id).val(total);
            $('#edit_order_amount_for_detail_for' + id).val(sum);
        }
    });


    $(document).on("change", ".edit_order_typeplant_detail", function (event) {
        var id = $(this).attr("data-id");
        var type_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: './pages/order/get_plant.php',
            data: 'type_id=' + type_id,
            success: function (html) {
                console.log(html)
                $('#edit_order_plant_detail' + id).html(html);
            }
        });
    });

    //--- เช็คแอดเพิ่มจำนวนรายการ ซ้ำ ---//
    $(".edit_order_plant_detail").on("change", function (event) {

        var id = $(this).attr("data-id")
        var ref_order_id = $("#edit_detail_order_id" + id).val();
        var plant_id = $(this).val();
        var type_plant = $("#edit_order_typeplant_detail" + id).val();

        if (plant_id == "0") {
            $('#edit_order_plant_time_detail' + id).val("");
            $('#edit_order_plant_time_day_detail' + id).val("");
            $('#edit_order_day_detail' + id).val("");
            $('.edit_picture_detail').attr('src', "image/plant.PNG");

        } else {
            $.ajax({
                url: "./pages/order/check_edit_detail.php",
                method: "POST",
                data: {
                    id: id,
                    ref_order_id: ref_order_id,
                    plant_id: plant_id,
                    type_plant: type_plant
                },
                success: function (data) {
                    console.log(data)
                    if (data == 1) {
                        swal({
                            text: "มีพันธุ์ไม้นี้มีอยู่ในรายการแล้ว",
                            icon: "warning",
                            button: "ปิด"
                        });


                        $(".edit_order_plant_detail option[value='0']").prop('selected', true);
                    } else {

                        $.ajax({
                            type: 'POST',
                            url: './pages/order/get_image.php',
                            data: 'id_plant=' + plant_id,
                            success: function (html) {
                                $('.edit_picture_detail').attr('src', "image/plant/" + html);

                            }
                        });
                    }
                }
            });

            $.ajax({
                type: 'POST',
                url: './pages/order/get_week.php',
                data: 'id_plant=' + plant_id,
                success: function (html) {

                    $('#edit_order_plant_time_detail' + id).val(html);
                }
            });

            $.ajax({
                type: 'POST',
                url: './pages/order/get_day.php',
                data: 'id_plant=' + plant_id,
                success: function (html) {

                    $('#edit_order_plant_time_day_detail' + id).val(html);

                    days_detail1 = html
                    days_detail1 = parseInt(days_detail1);
                    days_detail2 = days_detail1 + 14;

                    $.ajax({
                        type: 'POST',
                        url: './pages/order/get_date.php',
                        data: {
                            date2: days_detail2
                        },
                        success: function (html) {

                            console.log(html);
                            $('#edit_order_end_detail' + id).val(html);
                            totalday_detail = html;
                            /*      if (in_order_end < datenow) {
         
                                     swal({
                                         title: "แจ้งเตือน",
                                         text: "กรุณาเลือกวันที่ให้มากกว่า ระยะเวลาปลูกอย่างน้อย " + " " + days2 + " " + "วัน",
                                         icon: "warning",
                                         buttons: "ปิด",
                                     })
                                 }           */
                            $('#edit_order_day_detail' + id).val(days_detail2);

                            daytotal_detail = days_detail2
                        }
                    });
                }
            });

            /* $('#edit_order_end_detail' + id).val("");
            $('#edit_order_day_detail' + id).val(""); */
        }

    });


    //เรียกวันที่

    $(document).on("change", ".edit_order_end_detail", function (event) {
        var id = $(this).attr("data-id");
        var date3 = $(this).val();
        var total;
        var datenow = $("#edit_order_daynow_detail" + id).val()
        var in_order_plant_time_day = $("#edit_order_plant_time_day_detail" + id).val()
        var in_order_plant_time = $("#edit_order_plant_time_detail" + id).val()
        var plant_id = $("#edit_order_plant_detail" + id).val();
        /*  var edit_order_day_detail = $("#edit_order_day_detail"+ id).val() */
        var edit_order_end_detail2 = $("#edit_order_end_detail2" + id).val()


        var edit_order_day_details;
        if (date3 <= datenow) {

            swal({
                title: "แจ้งเตือน",
                text: "ควรเลือกวันที่ปลูกให้มากกว่าวันที่ปัจจุบัน",
                icon: "warning",
                buttons: "ปิด",
            })
            $.ajax({
                type: 'POST',
                url: './pages/order/get_date_change.php',
                data: {
                    date2: edit_order_end_detail2
                },
                success: function (html) {

                    console.log(html);
                    /*  $('#edit_order_end_detail' + id).val(html); */

                    $('#edit_order_end_detail' + id).val(edit_order_end_detail2);
                    $('#edit_order_day_detail' + id).val(html);
                }
            });


        } else {

            $.ajax({
                type: 'POST',
                url: './pages/order/get_date_change.php',
                data: {
                    date2: edit_order_end_detail2
                },
                success: function (html) {

                    console.log(html);
                    /*  $('#edit_order_end_detail' + id).val(html); */
                    edit_order_day_detail = html;
                    edit_order_day_details = edit_order_day_detail

                }
            });

            $.ajax({
                type: 'POST',
                url: './pages/order/get_date_change.php',
                data: {
                    date2: date3
                },
                success: function (html) {

                    console.log(html);

                    if (html < edit_order_day_details) {

                        swal({
                            title: "คำแนะนำ",
                            text: "ควรเลือกระยะเวลาปลูกอย่างน้อย " + " " + edit_order_day_details + " " + "วัน" +
                                " " + "หรือวันที่" + " " + edit_order_end_detail2,
                            icon: "warning",
                            buttons: "ปิด",
                        })
                    }
                    $('#edit_order_day_detail' + id).val(html);


                }
            });

        }


        /* $.ajax({
            type: 'POST',
            url: './pages/order/get_date.php',
            data: {
                date2: date3

            },
            success: function (html) {

                html = parseInt(html);
                console.log(html)
                in_order_plant_time_day = parseInt(in_order_plant_time_day);
                total = html - in_order_plant_time_day;
                var day = in_order_plant_time_day + 14;
                day = parseInt(day)
                if (total < 14) {

                    swal({
                        title: "แจ้งเตือน",
                        text: "กรุณาเลือกวันที่ให้มากกว่า ระยะเวลาปลูกอย่างน้อย " + " " + day + " " + "วัน",
                        icon: "warning",
                        buttons: "ปิด",
                    })
                    $('#edit_order_day_detail' + id).val("");
                    $('#edit_order_end_detail' + id).val("");
                } else if (in_order_plant_time == "") {

                    $('#edit_order_day_detail' + id).val("");
                } else {
                    $('#edit_order_day_detail' + id).val(html);
                }
            }
        }); */
    });

    // เช็คต้น ในปุ่มแก้ไขรายละเอียดรายการ
    $(".edit_order_amount_detail").keyup(function () {

        var id = $(this).val()
        if (!id.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }
    });





    //--- ปุ่มแก้ไข รายละเอียดรายการ ---//
    $(document).on("click", "#btn_detail_order", function (event) {

        var id = $(this).attr("data-id");

        var edit_order_typeplant_detail = $("#edit_order_typeplant_detail" + id).val();
        var edit_order_plant_detail = $("#edit_order_plant_detail" + id).val();
        var edit_order_amount_detail = $("#edit_order_amount_detail" + id).val();
        var edit_order_end_detail = $("#edit_order_end_detail" + id).val();
        var edit_order_amount_total_detail = $("#edit_order_amount_total_detail" + id).val();

        if (edit_order_typeplant_detail == 0) {
            swal({
                text: "กรุณาเลือกประเภทพันธ์ไม้",
                icon: "warning",
                button: "ปิด"
            });
        } else if (edit_order_plant_detail == 0) {
            swal({
                text: "กรุณาเลือกพันธ์ไม้",
                icon: "warning",
                button: "ปิด"
            });
        } else if (edit_order_amount_detail == "") {
            swal({
                text: "กรุณากรอกจำนวน",
                icon: "warning",
                button: "ปิด"
            });
        } else if (edit_order_end_detail == "") {
            swal({
                text: "กรุณาเลือกวันที่ส่งมอบ",
                icon: "warning",
                button: "ปิด"
            });
        } else {
            $.ajax({
                url: "./pages/order/update_order_detail.php",
                method: "POST",
                data: {
                    id: id,
                    edit_order_plant_detail: edit_order_plant_detail,
                    edit_order_amount_detail: edit_order_amount_detail,
                    edit_order_end_detail: edit_order_end_detail,
                    edit_order_amount_total_detail: edit_order_amount_total_detail

                },
                success: function (data) {
                    swal({
                        text: "แก้ไขข้อมูลเรียบร้อย",
                        icon: "success",
                        button: false
                    });
                    $('#edit_detail' + id).modal('toggle')
                    setTimeout(function () {
                        swal.close()
                    }, 1500);

                    console.log(data)

                    var table = $("#tb_order_detail").DataTable()
                    table.destroy()
                    fetch_order_detail(o_detail_id)
                }
            });
        }
    });

    //---- Remove orderdetail -----//
    $(document).on("click", "#btn_re_equ", function (event) {
        var order_detail_id = $(this).attr('data')
        var order_detail_status = $(this).attr('data-status')
        var plant_name = $(this).attr("data-name")

        if (order_detail_status == 'ปกติ') {
            swal({
                title: "!" + " " + "คำเตือน" + "หากยกเลิกรายการสั่งซื้อที่ทำการปลูกแล้ว" + " " + "รายการปลูกนั้นจะไม่ถูกยกเลิก",
                text: " ยกเลิกข้อมูลรายการ : " + plant_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "pages/order/remove_order_detail.php",
                            method: "POST",
                            data: {
                                order_detail_id: order_detail_id,
                                order_detail_status: order_detail_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    swal.close()
                                }, 1500);

                                var table = $("#tb_order_detail").DataTable()
                                table.destroy()
                                fetch_order_detail(o_detail_id)
                                console.log(data)
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        } else {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกการระงับข้อมูลรายการ : " + plant_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "pages/order/remove_order_detail.php",
                            method: "POST",
                            data: {
                                order_detail_id: order_detail_id,
                                order_detail_status: order_detail_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกการระงับข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    swal.close()
                                }, 1500);

                                var table = $("#tb_order_detail").DataTable()
                                table.destroy()
                                fetch_order_detail(o_detail_id)
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        }

    });

    $(document).on("click", "#btn_handover_now", function (event) {
        var order_detail_id = $(this).attr('data')
        var order_detail_status = $(this).attr('data-status')
        var plant_name = $(this).attr("data-name")
        if (order_detail_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " เปลี่ยนสถานะเป็นรอส่งมอบ รายการ : " + plant_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "pages/order/update_status_order.php",
                            method: "POST",
                            data: {
                                order_detail_id: order_detail_id,
                                order_detail_status: order_detail_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    swal.close()
                                }, 1500);

                                var table = $("#tb_order_detail").DataTable()
                                table.destroy()
                                fetch_order_detail(o_detail_id)
                                console.log(data)
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        } else {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกสถานะรอส่งมอบ รายการ: " + plant_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "pages/order/update_status_order.php",
                            method: "POST",
                            data: {
                                order_detail_id: order_detail_id,
                                order_detail_status: order_detail_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกการระงับข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    swal.close()
                                }, 1500);

                                var table = $("#tb_order_detail").DataTable()
                                table.destroy()
                                fetch_order_detail(o_detail_id)
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        }

    });

    $(document).on("click", "#btn_edit_orders", function (event) {
        var id = $(this).attr("data")
        $("#editOrder" + id)[0].reset();


    });

});

