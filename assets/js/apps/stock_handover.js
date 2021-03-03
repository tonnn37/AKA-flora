$(document).ready(function () {

    //---- ตารางรายการ-----//
    handover_table();

    function handover_table() {

        var ta = $('#handoverTable').DataTable({
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
                    targets: 6,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ยกเลิก") {
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
                url: "./pages/handover/fetch_handover.php",
                type: "post",

            }
        });
        ta.on('order.dt search.dt', function () {
            ta.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    handover_details()

    function handover_details() {
        var t = $('#handover_detailTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "info": false,
            "paginate": false,
            "columnDefs": [

                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },


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
        });
        t.on('order.dt search.dt', function () {
            t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    }

    function handover_detail(id) {

        //---- ตารางรายการ-----//
        var t = $('#handover_detailTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "info": false,
            "paginate": false,

            "columnDefs": [

                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },


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
                url: "./pages/handover/fetch_order_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }
            }
        });

        t.on('order.dt search.dt', function () {
            t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    function stock_handover_detailTable(id) {
        var ts = $('#stock_handover_detailTable').DataTable({
            "responsive": true,
            "lengthChange": false,

            "columnDefs": [

                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 2,
                    className: 'dt-body-right'
                }

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
                url: "./pages/handover/fetch_handover_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }

            }

        });
        ts.on('order.dt search.dt', function () {
            ts.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }




    $(".in_handover_grade_amount").on("change", function (event) { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        var grade_id = $(this).data('grade');
        var grade = $('#in_handover_grade_id' + grade_id).val()
        var in_handover_planting_amount = $("#in_handover_planting_amount").val()
        var order_detail_id = $('#in_handover_order_detail').val();
        in_handover_planting_amount = parseInt(in_handover_planting_amount)
        var sum = 0;

        sum = parseInt(sum)
        var sumval;

        if (!elem.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        } else if (elem <= 0) {
            swal({
                text: "กรุณากรอกจำนวนให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();

        } else {
            /* $.ajax({
                type: 'POST',
                url: './pages/handover/check_amount.php',
                data: {
                    elem: elem,
                    order_detail_id: order_detail_id,
                    grade: grade
                },
                success: function (html) {
                    console.log(html)
                    if (html == 1) {
                        swal({
                            title: "แจ้งเตือน",
                            text: "จำนวนต้นไม้ในสต็อกไม่เพียงพอ",
                            icon: "warning",
                            buttons: "ปิด",
                        })
                        $(this).val("");
                        $(this).focus();
                        $("#in_handover_grade_amount" + grade_id).val("")


                    } */
            // arr1
            var arr_stock_amount = []
            var arr_stock_0 = []
            var arr_stock_1 = []
            var arr_stock_2 = []
            $.ajax({
                type: 'POST',
                url: './pages/handover/get_stock2.php',
                data: {
                    id: grade_id,
                    order_detail_id: order_detail_id
                },
                success: function (html) {
                    /*  console.log(html) */

                    $("#show_modal2").html(html)

                    $('.stock_amount').each(function (i) {

                        if ($(this).val() != "") {
                            arr_stock_amount[i] = parseInt($(this).val())
                        } else {
                            arr_stock_amount[i] = 0;
                        }
                    });
                    arr_stock_0 = arr_stock_amount[0]
                    arr_stock_1 = arr_stock_amount[1]
                    arr_stock_2 = arr_stock_amount[2]


                    var arr_use_amount = []
                    var arr_grade_name = []
                    //-------- arr 1 ----//
                    $('.in_handover_grade_amount').each(function (i) {

                        if ($(this).val() != "") {
                            arr_use_amount[i] = parseInt($(this).val())
                        } else {
                            arr_use_amount[i] = 0
                        }
                    });
                    var arr_use_amounts = arr_use_amount.filter(function (el) {
                        return el != "empty";
                    });

                    $(".in_handover_grade_amount2").each(function (i) {

                        if ($(this).val() != "") {
                            arr_amount_grade[i] = $(this).val()
                        } else {
                            arr_amount_grade[i] = 0
                        }
                    });
                    var arr_amount_grades = arr_amount_grade.filter(function (el) {
                        return el != "empty";
                    });
                    $(".in_handover_grade_name2").each(function (i) {

                        if ($(this).val() != "") {
                            arr_grade_name[i] = $(this).val()

                        }
                    });

                    arr_name0 = arr_grade_name[0]
                    arr_0 = arr_amount_grades[0]
                    if (arr_0 == null) {
                        arr_0 = 0
                    } else {
                        arr_0 = arr_amount_grades[0]
                    }
                    use_0 = arr_use_amounts[0]
                    cal_amount0 = parseInt(arr_0) + parseInt(arr_stock_0)
                    console.log(cal_amount0)

                    arr_name1 = arr_grade_name[1]
                    arr_1 = arr_amount_grades[1]
                    use_1 = arr_use_amounts[1]
                    if (arr_1 == null) {
                        arr_1 = 0
                    } else {
                        arr_1 = arr_amount_grades[1]
                    }
                    cal_amount1 = parseInt(arr_1) + parseInt(arr_stock_1)
                    console.log(cal_amount1)

                    arr_name2 = arr_grade_name[2]
                    arr_2 = arr_amount_grades[2]
                    use_2 = arr_use_amounts[2]
                    if (arr_2 == null) {
                        arr_2 = 0
                    } else {
                        arr_2 = arr_amount_grades[2]
                    }

                    cal_amount2 = parseInt(arr_2) + parseInt(arr_stock_2)
                    console.log(arr_2)


                    $('.in_handover_grade_amount').each(function (i) {
                        sumval = parseInt($(this).val())
                        if ($(this).val() != "") {
                            sum = sum + sumval
                        }
                    });

                    console.log(sum)


                    if (sum > in_handover_planting_amount) {
                        swal({
                            title: "แจ้งเตือน",
                            text: "จำนวนรวมต้นไม้ของแต่ละเกรด ต้องไม่มากกว่า" + " " + in_handover_planting_amount + " " + "ต้น",
                            icon: "warning",
                            buttons: "ปิด",
                        })
                        $("#in_handover_grade_amount" + grade_id).val("")
                        $(this).val("");
                        $(this).focus();
                    } else if (use_0 > cal_amount0) {
                        swal({
                            title: "แจ้งเตือน",
                            text: "จำนวนส่งมอบต้องไม่มากกว่า จำนวนเกรด" + " " + "A" + " " + cal_amount0 + " " + "ต้น",
                            icon: "warning",
                            buttons: "ปิด",
                        })
                        $("#in_handover_grade_amount" + grade_id).val("")
                        $(this).focus();
                    } else if (use_1 > cal_amount1) {
                        swal({
                            title: "แจ้งเตือน",
                            text: "จำนวนส่งมอบต้องไม่มากกว่า จำนวนเกรด" + " " + "B" + " " + cal_amount1 + " " + "ต้น",
                            icon: "warning",
                            buttons: "ปิด",
                        })
                        $("#in_handover_grade_amount" + grade_id).val("")
                        $(this).focus();

                    } else if (use_2 > cal_amount2) {
                        swal({
                            title: "แจ้งเตือน",
                            text: "จำนวนส่งมอบต้องไม่มากกว่า จำนวนเกรด" + " " + "C" + " " + cal_amount2 + " " + "ต้น",
                            icon: "warning",
                            buttons: "ปิด",
                        })
                        $("#in_handover_grade_amount" + grade_id).val("")
                        $(this).focus();
                    } else {
                        checksum = sum
                        console.log(checksum)
                    }

                    /*     }
                    }); */
                }
            });

        }


    });

    var checksum;
    //-- รีเซ็ตค่า --//
    $(document).on("click", "#modal_handover", function (event) {

        $("#in_handover")[0].reset();
        var table = $('#handover_detailTable').DataTable();
        table
            .clear()
            .draw();

        $("#show_1").prop("hidden", true)
        $("#show_modal2").prop("hidden", true)

        $(".error_grade").prop("hidden", true)
        $("#show_modal").prop("hidden", true)

        $(".in_handover_grade_amount").prop("disabled", true)
        $(".in_handover_grade_id").prop("disabled", true)
    });

    $("#in_handover_order").on("change", function (event) {

        var id = $(this).val();
        console.log(id)
        if (id == 0) {

            var table = $('#handover_detailTable').DataTable();
            table
                .clear()
                .draw();

            $("#in_handover_order_detail option[value='0']").prop('selected', true);
            $("#in_handover_order_detail").attr("disabled", true);
            $(".in_handover_grade_id").attr("disabled", true);
            $('.in_handover_grade_id').prop("checked", false);
            $(".in_handover_grade_amount").attr("disabled", true);
            $('.in_handover_grade_amount').val("");

            $('#in_handover_planting_amount').val("");
            $('.error_grade').prop("hidden", true);
            $("#show_1").prop("hidden", true)
            $("#show_modal").prop("hidden", true)
        } else {
            var table = $('#handover_detailTable').DataTable();
            table
                .clear()
                .draw();

            $("#in_handover_order_detail").attr("disabled", false);

            /*  $.ajax({
                 type: 'POST',
                 url: './pages/handover/check_order_detail.php',
                 data: 'id=' + id,
                 success: function (data) {
                     console.log(data)
                     if (data == 1) {
 
                         swal({
                             title: "แจ้งเตือน",
                             text: "กรุณาเลือกรายการส่งมอบที่ลูกค้าพรีออเดอร์ให้หมดก่อน",
                             icon: "warning",
                             buttons: "ปิด",
                         })
                     }
                 }
             });
  */
            $.ajax({
                type: 'POST',
                url: './pages/handover/get_order_detail.php',
                data: 'id=' + id,
                success: function (html) {

                    $('#in_handover_order_detail').html(html);

                }
            });
        }

    });
    var arr_amount_grade = []
    /* var arr_1 , arr_2  , arr_3 , arr_4  */
    $('#show_1').prop("hidden", true);
    $("#in_handover_order_detail").on("change", function (event) {
        var id = $(this).val();
        console.log(id)
        var name = $(this).attr('data')

        if (id == "0") {
            var table = $('#handover_detailTable').DataTable();
            table
                .clear()
                .draw();
            $(".in_handover_grade_id").attr("disabled", true);
            $('.in_handover_grade_id').prop("checked", false);
            $(".in_handover_grade_amount").attr("disabled", true);
            $('.in_handover_grade_amount').val("");
            $('.in_handover_grade_amount2').val("");
            $('.in_handover_grade_amount2').prop("hidden", true);
            $('.hidden_grade1').prop("hidden", true);
            $('.hidden_grade2').prop("hidden", true);
            $('#in_handover_planting_amount').val("");
            $('#show_1').prop("hidden", true);
            $('.error_grade').prop("hidden", true);

        } else {
            $('#show_1').prop("hidden", false);
            $("#show_modal").prop("hidden", false)
            var table = $('#handover_detailTable').DataTable();
            table.destroy();

            handover_detail(id);
            $(".in_handover_grade_id").attr("disabled", false);



            $.ajax({
                type: 'POST',
                url: './pages/handover/get_planting_amount.php',
                data: 'id=' + id,
                success: function (html) {
                    console.log(html)
                    $('#in_handover_planting_amount').val(html);

                }
            });

            $.ajax({
                type: 'POST',
                url: './pages/handover/fetch_grade.php',
                data: 'id=' + id,
                success: function (html) {
                    /*console.log(html) */
                    $('#show_modal').html(html);

                    /*   $(".in_handover_grade_amount2").each(function (i) {
  
                          if ($(this).val() != "") {
                              arr_amount_grade[i] = $(this).val()
                          }
                      });
  
                      var arr_amount_grades = arr_amount_grade.filter(function (el) {
                          return el != "empty";
                      });
                      
                      console.log(arr_amount_grades) */

                }
            });


        }

    });



    $(".in_handover_grade_id").attr("disabled", true);
    $(".in_handover_grade_id").on("change", function (event) {

        var id = $(this).val();
        var order_detail_id = $('#in_handover_order_detail').val();
        console.log(id)
        console.log(order_detail_id)

        if (this.checked) {
            $('#error_grade' + id).show()
            $('#show_grade' + id).show()
            $('.error_grade').prop("hidden", false);
            $("#in_handover_grade_amount" + id).attr("disabled", false);
            $.ajax({
                type: 'POST',
                url: './pages/handover/get_stock.php',
                data: {
                    id: id,
                    order_detail_id: order_detail_id
                },
                success: function (html) {

                    $('#error_grade' + id).html("คงเหลือในสต็อก : " + html + ' ต้น');
                    $('#error_grade' + id).css('color', 'red');
                }
            });

            $.ajax({
                type: 'POST',
                url: './pages/handover/get_stock3.php',
                data: {
                    id: id,
                    order_detail_id: order_detail_id
                },
                success: function (html) {
                    console.log(html)
                    $('#show_modal3' + id).html(html);
                }
            });

            $.ajax({
                type: 'POST',
                url: './pages/handover/get_grade2.php',
                data: {
                    id: id,
                    order_detail_id: order_detail_id
                },
                success: function (html) {
                    console.log(html)
                    $('#show_modal4' + id).html(html);


                }
            });
        } else {
            $('#error_grade' + id).hide()
            $("#in_handover_grade_amount" + id).attr("disabled", true);
            $("#in_handover_grade_amount" + id).val("");
            $('#show_modal4' + id).html("");
            $('#show_modal3' + id).html("");

        }

    });


    $("#btn_add_stock_handover").on("click", function (event) {

        var in_handover_id = $("#in_handover_id").val();
        var in_handover_order = $("#in_handover_order").val();
        var in_handover_order_detail = $("#in_handover_order_detail").val();
        var in_handover_planting_amount = $("#in_handover_planting_amount").val();

        var grade = []
        var amount = []
        var show_stock_amount = []
        var cull_grade_amount = []
        var arr_cull_grade_name = []
        var arr_cull_grade = []
        var use_grade_amount = []

        var array_stock_amount = []
        $('.in_handover_grade_id:checked').each(function (i) {

            grade[i] = $(this).val()
        });
        $('.in_handover_grade_amount').each(function (i) {

            if ($(this).val() != "") {
                amount[i] = $(this).val()
            }
        });

        var amounts = amount.filter(function (el) {
            return el != "empty";
        });

        $('.stock_amount3').each(function (i) {

            if ($(this).val() != "") {
                show_stock_amount[i] = $(this).val()
            } else {
                show_stock_amount[i] = 0
            }
        });

    /*     var show_stock_amounts = show_stock_amount.filter(function (el) {
            return el != "empty";
        }); */
        if(show_stock_amount == ""){
            show_stock_amount[i] = 0
        }else{
            show_stock_amount
        }
        $('.cull_amount').each(function (i) {

            if ($(this).val() != "") {
                cull_grade_amount[i] = $(this).val()
            } else {
                cull_grade_amount[i] = 0
            }
        });

        var cull_grade_amounts = cull_grade_amount.filter(function (el) {
            return el != "empty";
        });

        $(".in_handover_grade_name2").each(function (i) {

            if ($(this).val() != "") {
                arr_cull_grade_name[i] = $(this).val()
            }
        });

        var arr_cull_grade_names = arr_cull_grade_name.filter(function (el) {
            return el != "empty";
        });

        $(".in_handover_grade_amount2").each(function (i) {

            if ($(this).val() != "") {
                arr_cull_grade[i] = $(this).val()
            }
        });

        var arr_cull_grades = arr_cull_grade.filter(function (el) {
            return el != "empty";
        });

        $('.stock_amount').each(function (i) {

            if ($(this).val() != "") {
                array_stock_amount[i] = parseInt($(this).val())

            } else {
                array_stock_amount = [0,0]
            }
        });
       /*  var array_stock_amounts = array_stock_amount.filter(function (el) {
            return el != "empty";
        }); */

        $('.in_handover_grade_amount').each(function (i) {

            if ($(this).val() != "") {
                use_grade_amount[i] = parseInt($(this).val())
            } else {
                use_grade_amount[i] = 0
            }
        });
        var use_grade_amounts = use_grade_amount.filter(function (el) {
            return el != "empty";
        });


        /* 
                if (cull_grade_amounts == "") {
                    swal({
                        title: "แจ้งเตือน",
                        text: "กรุณาเลือกรายการสั่งซื้อ",
                        icon: "warning",
                        buttons: "ปิด",
                    })
                } */
        console.log(grade)
        console.log(amounts)
        console.log(show_stock_amount)
        console.log(cull_grade_amounts)
        console.log(arr_cull_grade_names)
        console.log(arr_cull_grades)
        console.log(array_stock_amount)
        console.log(use_grade_amounts)
      

        if (in_handover_order == "0") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกรายการสั่งซื้อ",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_handover_order_detail == "0") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกพันธุ์ไม้",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_handover_planting_amount == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนส่งมอบ",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (grade.length != amounts.length) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนต้นไม้ของแต่ละเกรด",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (grade.length == 0 && amounts.length == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกเกรดพันธุ์ไม้",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_handover_planting_amount - checksum != 0) {
            var sumtotal = in_handover_planting_amount - checksum

            swal({
                title: "แจ้งเตือน",
                text: "จำนวนต้นไม้ยังขาดอีก " + sumtotal + " " + "ต้น" + " " + "ต้องการส่งมอบหรือไม่ ?",
                icon: "warning",
                buttons: ["ยกเลิก", "ตกลง"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        url: "./pages/handover/insert_handover.php",
                        method: "POST",
                        data: {

                            in_handover_id: in_handover_id,
                            in_handover_order: in_handover_order,
                            in_handover_order_detail: in_handover_order_detail,
                            in_handover_planting_amount: in_handover_planting_amount,
                            amounts: amounts,
                            grade: grade,
                            show_stock_amounts: show_stock_amount,
                            cull_grade_amounts: cull_grade_amounts,

                            arr_cull_grade_names: arr_cull_grade_names,
                            arr_cull_grades: arr_cull_grades,
                            array_stock_amounts: array_stock_amount,
                            use_grade_amounts: use_grade_amounts

                        },
                        success: function (data) {
                            console.log(data)
                                             /* swal({
                 
                                                 text: "บันทึกข้อมูลเรียบร้อย",
                                                 icon: "success",
                                                 button: false,
                                             });
                                             setTimeout(function () {
                                                 location.reload();
                                             }, 1500); */


                        }
                    });
                } else {

                }
            });
        } else {
            $.ajax({
                url: "./pages/handover/insert_handover.php",
                method: "POST",
                data: {

                    in_handover_id: in_handover_id,
                    in_handover_order: in_handover_order,
                    in_handover_order_detail: in_handover_order_detail,
                    in_handover_planting_amount: in_handover_planting_amount,
                    amounts: amounts,
                    grade: grade,
                    show_stock_amounts: show_stock_amount,
                    cull_grade_amounts: cull_grade_amounts,

                    arr_cull_grade_names: arr_cull_grade_names,
                    arr_cull_grades: arr_cull_grades,
                    array_stock_amounts: array_stock_amount,
                    use_grade_amounts: use_grade_amounts
                },
                success: function (data) {
                    console.log(data)
                   /*   swal({
 
                         text: "บันทึกข้อมูลเรียบร้อย",
                         icon: "success",
                         button: false,
                     });
                     setTimeout(function () {
                         location.reload();
                     }, 1500); */
                }
            });
        }
    });

    $('.error_grade').hide()
    $(document).on("click", "#btn_handover_detail", function (event) {

        var id = $(this).attr("data")
        var plant_name = $(this).attr("data-name")
        var order_id = $(this).attr("data-order")
        var recieve_id = $(this).attr("data-grade")
        console.log(id)
        console.log(plant_name)

        $("#recieve_id").text(recieve_id)
        $("#plant_name").text(plant_name)
        $("#order_id").text(order_id)

        var table = $('#stock_handover_detailTable').DataTable();
        table.destroy();

        stock_handover_detailTable(id);

    });


    $(document).on("click", "#btn_remove_hanover", function (event) {
        var handover_id = $(this).attr('data')
        var handover_status = $(this).attr('data-status')
        var order_name = $(this).attr("data-name")
        console.log(handover_id)
        if (handover_status == 'เสร็จสิ้น') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลการส่งมอบ : " + order_name + " " + "(" + handover_id + ")",
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "pages/handover/remove_stock_handover.php",
                            method: "POST",
                            data: {
                                handover_id: handover_id,
                                handover_status: handover_status
                            },
                            success: function (data) {
                                console.log(data)
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
                text: " ยกเลิกการระงับข้อมูลการส่งมอบ : " + order_name + (handover_id),
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "pages/handover/remove_stock_handover.php",
                            method: "POST",
                            data: {
                                handover_id: handover_id,
                                handover_status: handover_status
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
    var table = $("#fetch_handover_noplant").DataTable()
    table.destroy()
    fetch_handover_noplant()

    function fetch_handover_noplant() {
        var tads = $('#handover_notplanttable').DataTable({
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
                    targets: 6,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ยกเลิก") {
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
                url: "./pages/handover/fetch_handover_notplant.php",
                type: "post",

            }
        });
        tads.on('order.dt search.dt', function () {
            tads.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    var tasds = $('#handover_detail_noplantTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            /*   {
                  targets: 6,
                  className: 'dt-body-right'
              },
              {
                  targets: 8,
                  render: function (data, type, row) {
                      var color = 'black';
                      if (data == "ยกเลิก") {
                          color = "red";
                      } else if (data == "เสร็จสิ้น") {
                          color = "green";
                      } else {
                          color = "black";
                      }
                      return '<span style="color:' + color + '">' + data + '</span>';
                  }
              }, */
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
    tasds.on('order.dt search.dt', function () {
        tasds.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();



    function fetch_order_detail(id) {
        var tasd = $('#handover_detail_noplantTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                /*   {
                      targets: 6,
                      className: 'dt-body-right'
                  },
                  {
                      targets: 8,
                      render: function (data, type, row) {
                          var color = 'black';
                          if (data == "ยกเลิก") {
                              color = "red";
                          } else if (data == "เสร็จสิ้น") {
                              color = "green";
                          } else {
                              color = "black";
                          }
                          return '<span style="color:' + color + '">' + data + '</span>';
                      }
                  }, */
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
                url: "./pages/handover/fetch_order_detail_noplant.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }

            }
        });
        tasd.on('order.dt search.dt', function () {
            tasd.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }
    var tasdss = $('#handover_noplant_detailTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            /*  {
                targets: 2,
                className: 'dt-body-right'
            } */
            /* {
                 targets: 6,
                 render: function (data, type, row) {
                     var color = 'black';
                     if (data == "ยกเลิก") {
                         color = "red";
                     } else if (data == "เสร็จสิ้น") {
                         color = "green";
                     } else {
                         color = "black";
                     }
                     return '<span style="color:' + color + '">' + data + '</span>';
                 }
             }, */
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
    tasdss.on('order.dt search.dt', function () {
        tasdss.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    function fetch_handover_noplant_detail(id) {
        var tassdss = $('#handover_noplant_detailTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 2,
                    className: 'dt-body-right'
                }
                /*{
                    targets: 8,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ยกเลิก") {
                            color = "red";
                        } else if (data == "เสร็จสิ้น") {
                            color = "green";
                        } else {
                            color = "black";
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                }, */
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
                url: "./pages/handover/fetch_handover_notplant_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }

            }
        });
        tassdss.on('order.dt search.dt', function () {
            tassdss.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }


    $(document).on("change", "#in_handover_noplant_order", function (event) {

        var id = $(this).val()
        console.log(id)

        if (id == 0) {
            $('#in_handover_noplant_amount').val("");
            var table = $("#handover_detail_noplantTable").DataTable()
            table.clear().draw()
        } else {
            $("#in_handover_noplant_order_detail").attr("disabled", false)
            $.ajax({
                type: 'POST',
                url: './pages/handover/get_order_detail2.php',
                data: {
                    id: id
                },
                success: function (html) {
                    /*  console.log(html) */
                    $('#in_handover_noplant_order_detail').html(html);


                }
            });
        }
    });



    $(document).on("change", "#in_handover_noplant_order_detail", function (event) {
        var id = $(this).val()
        console.log(id)

        if (id == 0) {
            $('#in_handover_noplant_amount').val("");
            var table = $("#handover_detail_noplantTable").DataTable()
            table.clear().draw()
        } else {
            var table = $("#handover_detail_noplantTable").DataTable()
            table.destroy()

            fetch_order_detail(id)

            $.ajax({
                type: 'POST',
                url: './pages/handover/get_order_amount.php',
                data: {
                    id: id
                },
                success: function (data) {
                    /*  console.log(html) */
                    $('#in_handover_noplant_amount').val(data);


                }
            });
        }
    });

    $(document).on("change", ".in_handover_noplant_grade_id", function (event) {
        var id = $(this).val()
        var order_detail_id = $("#in_handover_noplant_order_detail").val()

        if (this.checked) {

            $("#in_handover_noplant_grade_amount" + id).prop("disabled", false)
            $('#show_stock_amount' + id).prop("hidden", false)
            $.ajax({
                type: 'POST',
                url: './pages/handover/get_stock_noplant.php',
                data: {
                    id: id,
                    order_detail_id: order_detail_id
                },
                success: function (data) {

                    $('#show_stock_amount' + id).html("คงเหลือในสต็อก : " + data + ' ต้น');
                    $('.show_stock_amount').css('color', 'red');

                }
            });

        } else {
            $("#in_handover_noplant_grade_amount" + id).prop("disabled", true)
            $('#show_stock_amount' + id).prop("hidden", true)
        }
    });
    var sum_total
    $(document).on("change", ".in_handover_noplant_grade_amount", function (event) {
        var id = $(this).val()
        var grade_id = $(this).attr("data-grade")
        var grade = $('#in_handover_noplant_grade_id' + grade_id).val()
        var order_amount = $("#in_handover_noplant_amount").val()
        var order_detail_id = $("#in_handover_noplant_order_detail").val()
        var sum_amount = 0;
        var sumval2 = 0;

        order_amount = parseInt(order_amount)
        sum_amount = parseInt(sum_amount)

        if (!id.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        } else if (id <= 0) {
            swal({
                text: "กรุณากรอกจำนวนให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();

        } else {

            $.ajax({
                type: 'POST',
                url: './pages/handover/check_amount.php',
                data: {
                    elem: id,
                    order_detail_id: order_detail_id,
                    grade: grade
                },
                success: function (html) {
                    console.log(html)
                    if (html == 1) {
                        swal({
                            title: "แจ้งเตือน",
                            text: "จำนวนต้นไม้ในสต็อกไม่เพียงพอ",
                            icon: "warning",
                            buttons: "ปิด",
                        })
                        $(this).val("");
                        $(this).focus();
                        $("#in_handover_noplant_grade_amount" + grade_id).val("")

                    }

                    $('.in_handover_noplant_grade_amount').each(function (i) {
                        sumval = parseInt($(this).val())
                        if ($(this).val() != "") {
                            sum_amount = sum_amount + sumval

                        }
                    });

                    if (sum_amount > order_amount) {
                        swal({
                            title: "แจ้งเตือน",
                            text: "จำนวนรวมต้นไม้ของแต่ละเกรด ต้องไม่มากกว่า" + " " + order_amount + " " + "ต้น",
                            icon: "warning",
                            buttons: "ปิด",
                        })
                        $("#in_handover_noplant_grade_amount" + grade_id).val("")
                        $(this).val("");
                        $(this).focus();

                    } else {
                        sum_total = sum_amount
                        console.log(sum_total)

                    }
                }
            });
        }
    });

    $(document).on("click", "#btn_add_stock_handover_noplant", function (event) {
        var in_handover_noplant_id = $("#in_handover_noplant_id").val()
        var in_handover_noplant_order = $("#in_handover_noplant_order").val()
        var in_handover_noplant_order_detail = $("#in_handover_noplant_order_detail").val()
        var in_handover_noplant_amount = $("#in_handover_noplant_amount").val()

        var grade_use_amount = []
        var amount_use = []
        $('.in_handover_noplant_grade_id:checked').each(function (i) {

            grade_use_amount[i] = $(this).val()
        });
        $('.in_handover_noplant_grade_amount').each(function (i) {

            if ($(this).val() != "") {
                amount_use[i] = $(this).val()
            }
        });

        var amount_uses = amount_use.filter(function (el) {
            return el != "empty";
        });

        console.log(grade_use_amount)
        console.log(amount_uses)

        if (in_handover_noplant_order == "0") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกรายการสั่งซื้อ",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_handover_noplant_order_detail == "0") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกพันธุ์ไม้",
                icon: "warning",
                buttons: "ปิด",
            })
            /*  } else if (in_handover_noplant_amount == 0) {
                 swal({
                     title: "แจ้งเตือน",
                     text: "กรุณากรอกจำนวนส่งมอบ",
                     icon: "warning",
                     buttons: "ปิด",
                 }) */
        } else if (grade_use_amount.length != amount_uses.length) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนต้นไม้ของแต่ละเกรด",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (grade_use_amount.length == 0 && amount_uses.length == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกเกรดพันธุ์ไม้",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_handover_noplant_amount - sum_total != 0) {
            var sumtotal = in_handover_noplant_amount - sum_total

            swal({
                title: "แจ้งเตือน",
                text: "จำนวนต้นไม้ยังขาดอีก " + sumtotal + " " + "ต้น" + " " + "ต้องการส่งมอบหรือไม่ ?",
                icon: "warning",
                buttons: ["ยกเลิก", "ตกลง"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        url: "./pages/handover/insert_handover_noplant.php",
                        method: "POST",
                        data: {

                            in_handover_noplant_id: in_handover_noplant_id,
                            in_handover_noplant_order: in_handover_noplant_order,
                            in_handover_noplant_order_detail: in_handover_noplant_order_detail,
                            in_handover_noplant_amount: in_handover_noplant_amount,
                            amounts: amount_uses,
                            grade: grade_use_amount

                        },
                        success: function (data) {
                            console.log(data)
                            swal({

                                text: "บันทึกข้อมูลเรียบร้อย",
                                icon: "success",
                                button: false,
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        }
                    });
                } else {

                }
            });
        } else {
            $.ajax({
                url: "./pages/handover/insert_handover_noplant.php",
                method: "POST",
                data: {

                    in_handover_noplant_id: in_handover_noplant_id,
                    in_handover_noplant_order: in_handover_noplant_order,
                    in_handover_noplant_order_detail: in_handover_noplant_order_detail,
                    in_handover_noplant_amount: in_handover_noplant_amount,
                    amounts: amount_uses,
                    grade: grade_use_amount

                },
                success: function (data) {
                    console.log(data)
                    swal({

                        text: "บันทึกข้อมูลเรียบร้อย",
                        icon: "success",
                        button: false,
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            });
        }
    });

    $(document).on("click", "#btn_handover_noplant_detail", function (event) {
        var id = $(this).attr("data")
        var plant_names = $(this).attr("data-name")
        var order_ids = $(this).attr("data-order")
        console.log(id)

        $("#order_ids").text(order_ids)
        $("#plant_names").text(plant_names)

        var table = $("#handover_noplant_detailTable").DataTable()
        table.destroy()

        fetch_handover_noplant_detail(id)

    });

    $(document).on("click", "#btn_remove_hanover_noplant", function (event) {
        var id = $(this).attr("data")
        var status = $(this).attr("data-status")
        var name = $(this).attr("data-name")
        var ordername = $(this).attr("order-name")

        if (status == 'เสร็จสิ้น') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลการส่งมอบ : " + ordername + " " + "(" + id + ")",
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/handover/remove_handover_noplant.php",
                            method: "POST",
                            data: {
                                id: id,
                                status: status
                            },
                            success: function (data) {
                                console.log(data)
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
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
        } else {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกการระงับข้อมูลการส่งมอบ : " + ordername + " " + "(" + id + ")",
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/handover/remove_handover_noplant.php",
                            method: "POST",
                            data: {
                                id: id,
                                status: status
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

    //----------------------------------------ขายหน้าร้าน---------------------------------------

    tb_sale()
    function tb_sale() {
        var tb_sale = $('#tb_sale').DataTable({
            "responsive": true,
            "lengthChange": false,
            "info": false,
            "paginate": false,
            "columnDefs": [

                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 2,
                    className: 'dt-body-right'
                },
                {
                    targets: 3,
                    className: 'dt-body-right'
                },
                {
                    targets: 6,
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
                url: "./pages/handover/fetch_sale.php",
                type: "post",

            }
        });
        tb_sale.on('order.dt search.dt', function () {
            tb_sale.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    }

    var tbl_sale = $('#tbl_sale_list').DataTable({
        "responsive": true,
        "lengthChange": false,
        "info": false,
        "paginate": false,
        "columnDefs": [

            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            {
                targets: 4,
                className: 'dt-body-right'
            },
            {
                targets: 5,
                className: 'dt-body-right'
            },
            {
                targets: 6,
                className: 'dt-body-right'
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
    });
    tbl_sale.on('order.dt search.dt', function () {
        tbl_sale.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $('#sale_grade').attr("disabled", true);
    $("#sale_type_plant").on("change", function (event) {
        var id = $(this).val()

        if (id == 0) {
            $('#sale_picture').attr('src', "image/plant.PNG");
            $('#sale_grade').attr("disabled", true);
            $('#sale_plant').attr("disabled", true);
            $('#sale_amount').attr("disabled", true);
            $('.stock_amount').hide()

            $('#sale_price').val("")
            $('#sale_amount').val("")

            $("#sale_grade option[value='0']").prop('selected', true);
            $("#sale_plant option[value='0']").prop('selected', true);
            $("#stock_amount option[value='0']").prop('selected', true);
        } else {
            $('#sale_picture').attr('src', "image/plant.PNG");
            $('#sale_grade').attr("disabled", false);
            $("#sale_grade option[value='0']").prop('selected', true);
            $("#sale_plant option[value='0']").prop('selected', true);
            $('#sale_price').val("")
            $('#sale_amount').attr("disabled", true);
            $('.stock_amount').hide()
            $('#sale_plant').attr("disabled", true);
        }

    });

    $("#sale_grade").on("change", function (event) {

        var grade = $(this).val();
        var type = $('#sale_type_plant').val()
        if (grade == 0) {
            $('#sale_picture').attr('src', "image/plant.PNG");
            $('#sale_plant').attr("disabled", true);
            $('#sale_amount').attr("disabled", true);
            $('.stock_amount').hide()

            $('#sale_price').val("")
            $('#sale_amount').val("")

            $("#sale_plant option[value='0']").prop('selected', true);

        } else {
            $('#sale_picture').attr('src', "image/plant.PNG");
            $('#sale_price').val("")
            $('#sale_amount').val("")
            $('.stock_amount').hide()
            $('#sale_amount').attr("disabled", true);
            $.ajax({
                type: 'POST',
                url: './pages/handover/get_grade.php',
                data: {
                    type: type,
                    grade: grade
                },
                success: function (html) {
                    $('#sale_plant').attr("disabled", false);
                    $('#sale_plant').html(html)
                }
            });
        }

    });

    $("#sale_plant").on("change", function (event) {
        var id = $(this).val()

        if (id == 0) {

            $('#sale_picture').attr('src', "image/plant.PNG");
            $('#sale_amount').attr("disabled", true);
            $('.stock_amount').hide()

            $('#sale_price').val("")
            $('#sale_amount').val("")

            $("#stock_amount option[value='0']").prop('selected', true);

        } else {
            $('#sale_amount').val("")
            $.ajax({
                type: 'POST',
                url: './pages/handover/get_image.php',
                data: 'id_plant=' + id,
                success: function (html) {
                    $('#sale_picture').attr('src', "image/plant/" + html);

                }
            });
        }

    });


    $("#sale_amount").attr("disabled", true);
    $('.stock_amount').hide()
    $(document).on("change", "#sale_plant", function (event) {

        var plant_id = $(this).val();
        var grade_id = $("#sale_grade").val();

        console.log(plant_id)
        console.log(grade_id)

        if (plant_id == 0) {
            swal({
                text: "กรุณาเลือกพันธ์ไม้",
                icon: "warning",
                button: "ปิด"
            })
            $("#sale_price").val("")
            $("#sale_amount").val("")
            $('.stock_amount').hide()
            $("#sale_amount").attr("disabled", true);


        } else {

            $('.stock_amount').show()
            $("#sale_amount").attr("disabled", false);

            $.ajax({
                type: 'POST',
                url: './pages/handover/get_stock_sale.php',
                data: {
                    plant_id: plant_id,
                    grade_id: grade_id
                },
                success: function (html) {
                    console.log(html)
                    $('.stock_amount').html("คงเหลือในสต็อก : " + html + ' ต้น');
                    $('.stock_amount').css('color', 'red');

                }
            });

            $.ajax({
                type: 'POST',
                url: './pages/handover/get_price_plant.php',
                data: {
                    plant_id: plant_id,
                    grade_id: grade_id
                },
                success: function (html) {
                    $('#sale_price').val(html)
                }
            });



        }

    });

    $("#sale_amount").on("change", function (event) {

        var amount = $(this).val();
        var plant_id = $("#sale_plant").val();
        var grade_id = $("#sale_grade").val();

        console.log(amount);
        console.log(stock_amount);

        if (!amount.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $("#sale_amount").val("");
            $(this).focus();
            return false;
        }
        else if (amount <= 0) {
            swal({
                text: "กรุณากรอกจำนวนให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            })
            $("#sale_amount").val("")
            $(this).focus();
        } else {

            $.ajax({
                type: 'POST',
                url: './pages/handover/check_amount_sale.php',
                data: {
                    amount: amount,
                    plant_id: plant_id,
                    grade_id: grade_id
                },
                success: function (html) {
                    //console.log(html)
                    if (html == 1) {
                        swal({
                            title: "แจ้งเตือน",
                            text: "จำนวนต้นไม้ในสต็อกไม่เพียงพอ",
                            icon: "warning",
                            buttons: "ปิด",
                        })
                        $("#sale_amount").val("");
                        $(this).focus();

                    }
                }
            });
        }
    });

    $("#sale_money").attr("disabled", true);
    var i = 0;
    var arr_id = [], arr_amount = [], arr_total = [], arr_grade = []
    $(document).on("click", "#btn_add_list", function (event) {
        var id = $('#sale_plant').val()
        var type = $('#sale_type_plant').val()
        var name_plant = $('#sale_plant :selected').text()
        var price = $('#sale_price').val()
        var amount = $('#sale_amount').val()
        var grade = $('#sale_grade').val()
        var name_grade = $('#sale_grade :selected').text()
        var number = "<span class='i'></span>";
        var button = "<button id='re' class='btn btn-danger btn-xs my-xs-btn' type='button'data-i='" + i + "'><i class='fas fa-trash-alt'></i></button>"
        var l1 = $('#tbl_sale_list td:nth-child(2)').map(function () {
            /*'#list_make td:nth-child(2)' จับแถวที่ 2 */
            return $(this).text();
        }).get();


        if ($.inArray(id, l1) >= 0 && $.inArray(grade, arr_grade) >= 0) {
            swal({
                text: "คุณได้เลือกพันธ์ไม้นี้ไปแล้ว",
                icon: "warning",
                button: "ปิด"
            })
            $("#sale_plant option[value='0']").prop('selected', true);
            $("#sale_price").val("")
            $("#sale_amount").val("")

        } else if (type == 0) {
            swal({
                text: "กรุณาเลือกประเภทพันธุ์ไม้",
                icon: "warning",
                button: "ปิด"
            })
        } else if (grade == 0) {
            swal({
                text: "กรุณาเลือกเกรด",
                icon: "warning",
                button: "ปิด"
            })
        } else if (id == 0) {
            swal({
                text: "กรุณาเลือกพันธ์ไม้",
                icon: "warning",
                button: "ปิด"
            })
        } else if (amount <= 0) {
            swal({
                text: "กรุณากรอกจำนวนมากกว่า 0 ",
                icon: "warning",
                button: "ปิด"
            })
        } else {
            var total = price * amount
            tbl_sale.row.add([
                number,
                id,
                name_plant,
                name_grade,
                price,
                amount,
                total,
                button,

            ]).draw(false);
            sum_table()
            arr_id.push(id)
            arr_amount.push(amount)
            arr_total.push(total)
            arr_grade.push(grade)
            console.log(arr_id)
            console.log(arr_amount)
            console.log(arr_total)
            console.log(arr_grade)
            i++

            //คำสั่งนับลำดับ
            $(".i").each(function (i) {
                $(this).text(++i);
            });
            $("#sale_money").attr("disabled", false);
            $("#sale_type_plant option[value='0']").prop('selected', true);
            $("#sale_grade option[value='0']").prop('selected', true);
            $("#sale_plant option[value='0']").prop('selected', true);
            $("#sale_price").val("")
            $("#sale_amount").val("")
            $("#sale_money").val("")
            $("#sale_change").val("")
            $("#sale_amount").attr("disabled", true);
            $("#sale_plant").attr("disabled", true);
            $("#sale_grade").attr("disabled", true);
            $('.stock_amount').hide()
        }


    });
    var sum = 0

    function sum_table() {
        var table = document.getElementById("tbl_sale_list")
        sum = 0
        for (var x = 1; x < table.rows.length; x++) {
            sum = sum + parseFloat(table.rows[x].cells[6].innerHTML.replace(/,/g, ''));
        }
        $(".i").each(function (i) {
            $(this).text(++i);
        });
        $('#sale_total').val(numberWithCommas(sum.toFixed(2)));

    }

    function numberWithCommas(x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }
    $("#sale_money").on("change", function (event) {

        var money = $(this).val();
        var total = $("#sale_total").val()
        var change = 0;
        var ptotal_pay = parseFloat(total.replace(/,/g, ''));
        var pmoney = parseFloat(money);
        var pchange = parseFloat(change);
        if (pmoney < ptotal_pay) {
            swal({
                text: "จำนวนเงินไม่เพียงพอ",
                icon: "warning",
                button: "ปิด"
            })
            $(this).val("")
            $("#sale_change").val("")
            $(this).focus()
        } else if (!money.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกช่องรับเงิน เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#sale_change").val("");
        } else {
            pchange = pmoney - ptotal_pay
            $('#sale_money').val(numberWithCommas(pmoney.toFixed(2)));
            $('#sale_change').val(numberWithCommas(pchange.toFixed(2)));
            $("#btn_save_order").attr("disabled", false);
        }

    });

    $("#btn_save_order").on("click", function (event) {
        var sale_type_plant = $("#sale_type_plant").val()
        var sale_grade = $("#sale_grade").val()
        var sale_plant = $("#sale_plant").val()
        var sale_amount = $("#sale_amount").val()
        var sale_money = $("#sale_money").val()

        if (sale_money == "") {
            swal({
                text: "กรุณากรอกจำนวนรับเงิน",
                icon: "warning",
                button: "ปิด",
            })
            $(this).val("")
            $(this).focus()
        } else {
            $.ajax({
                type: 'POST',
                url: './pages/handover/insert_payment.php',
                data: {
                    id: arr_id,
                    sale_money: sale_money,
                    amount: arr_amount,
                    total: arr_total,
                    grade: arr_grade
                },
                success: function (data) {
                    console.log(data)
                    swal({
                        title: "พิมพ์ใบเสร็จรับเงิน",
                        text: "คุณต้องการพิมพ์ใบเสร็จหรือไม่ ?",
                        icon: "warning",
                        buttons: ["ยกเลิก", "ยืนยัน"],
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                setTimeout(function () {
                                    $("#fm_total").submit();
                                    location.reload();
                                }, 2000);
                            } else {
                                location.reload();
                            }
                        });
                }
            });
        }
    });



    $(document).on("click", "#re", function (event) {
        var rowCount = $('#tbl_sale_list tr').length;
        var index = $(this).attr('data-i')
        rowCount = rowCount - 1;
        console.log(index)
        tbl_sale
            .row($(this).parents('tr'))
            .remove()
            .draw();

        $(".i").each(function (i) {
            $(this).text(++i);
        });
        if (index != 0) {
            index
        } else {
            index = 0;
        }
        if (arr_id.length == 1 && arr_amount.length == 1) {
            index = 0
        }
        delete arr_id[index];
        delete arr_amount[index];
        delete arr_total[index];
        delete arr_grade[index]
        arr_id = arr_id.filter(function (el) {
            return el != "empty";
        });
        arr_amount = arr_amount.filter(function (el) {
            return el != "empty";
        });
        arr_total = arr_total.filter(function (el) {
            return el != "empty";
        });
        arr_grade = arr_grade.filter(function (el) {
            return el != "empty";
        });
        console.log(arr_id)
        console.log(arr_amount)
        console.log(arr_total)
        console.log(arr_grade)
        if (rowCount != 1) {
            sum_table()
        } else {
            $("#btn_save_order").attr("disabled", true);
            $('#sale_total').val("");
            $('#sale_money').val("");
            $('#sale_change').val("");
        }

    });

    $(document).on("click", "#modal_sale", function (event) {

        $("#fm_total")[0].reset()
        var table = $('#tbl_sale_list').DataTable();
        table
            .clear()
            .draw();

        arr_id = [], arr_amount = [], arr_total = [], arr_grade = []

    });



    function fetch_payment_detail(id) {
        var ta = $('#payment_detailTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
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
                url: "./pages/handover/fetch_payment_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }
            }

        });
        ta.on('order.dt search.dt', function () {
            ta.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }



    $(document).on("click", "#btn_payment_detail", function (event) {

        var id = $(this).attr("data");

        var table = $("#payment_detailTable").DataTable()
        table.destroy();

        fetch_payment_detail(id)

    });


    $(document).on("click", "#btn_remove_payment", function (event) {
        var payment_id = $(this).attr('data')
        var payment_status = $(this).attr('data-status')
        if (payment_status == 'เสร็จสิ้น') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลการขาย: " + payment_id,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "pages/handover/remove_payment.php",
                            method: "POST",
                            data: {
                                payment_id: payment_id,
                                payment_status: payment_status
                            },
                            success: function (data) {
                                $("#remove_payment_id").val(payment_id)
                                console.log(data)
                                swal({
                                    title: "ยกเลิกใบเสร็จรับเงิน",
                                    text: "คุณต้องการยกเลิกใบเสร็จหรือไม่ ?",
                                    icon: "warning",
                                    buttons: ["ยกเลิก", "ยืนยัน"],
                                })
                                    .then((willDelete) => {
                                        if (willDelete) {
                                            setTimeout(function () {
                                                $("#remove_payment").submit();
                                                location.reload();
                                            }, 2000);
                                        } else {
                                            location.reload();
                                        }
                                    });
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        } else {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกการระงับข้อมูลการขาย : " + payment_id,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "pages/handover/remove_payment.php",
                            method: "POST",
                            data: {
                                payment_id: payment_id,
                                payment_status: payment_status
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

    $(document).on("click", "#btn_remove_payment_detail", function (event) {
        var payment_detail_id = $(this).attr('data')
        var plant_name = $(this).attr('data-plant')
        var grade_name = $(this).attr('data-grade')
        var payment_detail_status = $(this).attr('data-status')
        if (payment_detail_status == 'เสร็จสิ้น') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลรายละเอียดการขาย: " + plant_name + " " + "(" + "เกรด" + " " + grade_name + ")",
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "pages/handover/remove_payment_detail.php",
                            method: "POST",
                            data: {
                                payment_detail_id: payment_detail_id,
                                payment_detail_status: payment_detail_status
                            },
                            success: function (data) {
                                $("#remove_payment_id").val(payment_detail_id)
                                console.log(data)
                                swal({
                                    title: "ยกเลิกใบเสร็จรับเงิน",
                                    text: "คุณต้องการยกเลิกใบเสร็จหรือไม่ ?",
                                    icon: "warning",
                                    buttons: ["ยกเลิก", "ยืนยัน"],
                                })
                                    .then((willDelete) => {
                                        if (willDelete) {
                                            setTimeout(function () {
                                                $("#remove_payment").submit();
                                                location.reload();
                                            }, 2000);
                                        } else {
                                            location.reload();
                                        }
                                    });
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        } else {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกการระงับข้อมูลรายละเอียดการขาย : " + plant_name + " " + "(" + เกรด + " " + grade_name + ")",
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "pages/handover/remove_payment_detail.php",
                            method: "POST",
                            data: {
                                payment_detail_id: payment_detail_id,
                                payment_detail_status: payment_detail_status
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


    $(document).on("click", "#print_sale", function (event) {
        var sale_id = $("#sale_list").val()

        if (sale_id == 0) {
            swal({

                text: "กรุณาเลือกรายการขาย",
                icon: "warning",
                button: "ปิด",
            });
        } else {


            swal({

                text: "พิมพ์ใบเสร็จเรียบร้อย",
                icon: "success",
                button: false,
            });
            setTimeout(function () {

                $("#print_salelist").submit();
                location.reload();
            }, 1500);



        }

    });


});
$(function () {
    $('a[data-toggle="tab"]').on('click', function (e) {
        window.localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = window.localStorage.getItem('activeTab');
    if (activeTab) {
        $('#tabs-icons-text a[href="' + activeTab + '"]').tab('show');
        // window.localStorage.removeItem("activeTab");
    }
});