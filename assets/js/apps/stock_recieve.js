$(document).ready(function () {

    fetch_stockTable()

    function fetch_stockTable() {
        var stock = $('#stock_recieveTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
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
                {
                    targets: 4,
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
                url: "./pages/stock_recieve/fetch_stock_recieve.php",
                type: "post",

            }


        });
        stock.on('order.dt search.dt', function () {
            stock.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    fetch_add_stock_recieveTable()

    function fetch_add_stock_recieveTable() {
        var add_stock = $('#add_stock_recieveTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 }
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
        add_stock.on('order.dt search.dt', function () {
            add_stock.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }


    function fetch_add_stock_recieveTables(id) {
        var ta = $('#add_stock_recieveTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 4,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'blue';

                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 5,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'red';

                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 6,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'green';

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
                url: "./pages/stock_recieve/fetch_planting_detail.php",
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

    function fetch_stock_recieve_detailTables(id) {

        var ta = $('#stock_recieve_detailTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 2,
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
                url: "./pages/stock_recieve/fetch_recieve_detail.php",
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

    $(document).on("click", "#search_modal", function (event) {

        $("#serach_id")[0].reset()
    });

    $(document).on("click", "#btn_search", function (event) {


        var status = $("#search_status").val()
        console.log(status)
        var table = $("#stock_recieveTable").DataTable()
        table.destroy()

        $("#modal_search").modal("toggle")
        var stocks = $('#stock_recieveTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
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
                {
                    targets: 4,
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
                url: "./pages/stock_recieve/fetch_stock_recieve_search.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = status
                }
            }


        });
        stocks.on('order.dt search.dt', function () {
            stocks.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    });

    //-- รีเซ็ตค่า --//
    $(document).on("click", "#modal_stock_recieve", function (event) {

        $("#in_stock_recieve")[0].reset();
        var table = $('#add_stock_recieveTable').DataTable();
        table
            .clear()
            .draw();

    });
    $("#in_stock_recieve_amount").attr("disabled", true);
    $("#in_stock_planting_detail").attr("disabled", true);

    $("#in_stock_recieve_planting").on("change", function (event) {

        var id = $(this).val();
        console.log(id)
        if (id == "0") {

            var table = $('#add_stock_recieveTable').DataTable();
            table
                .clear()
                .draw();

            $("#in_stock_planting_detail").attr("disabled", true);
            $("#in_stock_planting_detail option[value='0']").prop('selected', true);
            $("#in_stock_recieve_amount").attr("disabled", true);
            $('.in_stock_grade_id').prop('checked', false);
            $(".in_stock_grade_amount").attr("disabled", true);
            $(".in_stock_grade_amount").val("");
            $("#in_stock_recieve_amount").val("");
        } else {

            $("#in_stock_planting_detail").attr("disabled", false);

            $.ajax({
                type: 'POST',
                url: './pages/stock_recieve/get_planting_detail.php',
                data: 'id=' + id,
                success: function (html) {

                    $('#in_stock_planting_detail').html(html);

                }
            });
        }

    });
    $("#in_stock_planting_detail").on("change", function (event) {
        var id = $(this).val();
        console.log(id)

        if (id == "0") {

            var table = $('#add_stock_recieveTable').DataTable();
            table
                .clear()
                .draw();

            $("#in_stock_recieve_amount").attr("disabled", true);
            $('.in_stock_grade_id').prop('checked', false);
            $(".in_stock_grade_amount").attr("disabled", true);
            $(".in_stock_grade_amount").val("");
            $("#in_stock_recieve_amount").val("");

        } else {

            $("#in_stock_recieve_amount").attr("disabled", false);
            var table = $('#add_stock_recieveTable').DataTable();
            table.destroy();

            fetch_add_stock_recieveTables(id);
            $.ajax({
                type: 'POST',
                url: './pages/stock_recieve/get_planting_amount2.php',
                data: 'id=' + id,
                success: function (html) {


                    amount_planting = html

                    $("#in_stock_recieve_amount").val(amount_planting);
                }
            });
        }
    });

    var amount_planting;

    //เช็คตัวเลข 
    $("#in_stock_recieve_amount").keyup(function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        if (!elem.match(/^([0-9])+$/i)) {
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

    //เช็คตัวเลข 
    $(".in_stock_grade_amount").keyup(function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        if (!elem.match(/^([0-9])+$/i)) {
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

    $("#in_stock_recieve_amount").on("change", function (event) {

        var amount_total = $(this).val();

        if (parseInt(amount_total) > parseInt(amount_planting)) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนปลูกไม่เกิน" + " " + amount_planting + " " + "ต้น",
                icon: "warning",
                buttons: "ปิด",
            })
        }


        $(".in_stock_grade_amount").val("")
        $("#in_stock_recieve_amount_sum").val("")
    });

    $(".in_stock_grade_id").on("change", function (event) {

        var id = $(this).val();
        console.log(id)
        if (this.checked) {

            $("#in_stock_grade_amount" + id).attr("disabled", false);
        } else {

            $("#in_stock_grade_amount" + id).attr("disabled", true);
            $("#in_stock_grade_amount" + id).val("");
            $("#in_stock_recieve_amount_sum").val("");
        }
    });

    $(".in_stock_grade_amount").change(function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        var in_stock_recieve_amount = $("#in_stock_recieve_amount").val()
        in_stock_recieve_amount = parseInt(in_stock_recieve_amount)
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
            $("#in_stock_recieve_amount_sum").val("")
            return false;
        } else if (elem <= 0) {
            swal({
                text: "กรุณากรอกจำนวนให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            $("#in_stock_recieve_amount_sum").val("")
        } else {

            $('.in_stock_grade_amount').each(function (i) {
                sumval = parseInt($(this).val())
                if ($(this).val() != "") {
                    sum = sum + sumval

                }
            });

            if (sum > in_stock_recieve_amount) {
                swal({
                    title: "แจ้งเตือน",
                    text: "จำนวนรวมแต่ละเกรด ต้องไม่มากกว่า" + " " + in_stock_recieve_amount + " " + "ต้น",
                    icon: "warning",
                    buttons: "ปิด",
                })
                $(this).val("");
                in_stock_recieve_amount = 0
                $(this).focus();
            } else {
                sumtotal = in_stock_recieve_amount - sum
                $("#in_stock_recieve_amount_sum").val(sumtotal)
            }

        }
        checksum = sum


    });

    var checksum;


    $("#btn_add_handover").on("click", function (event) {

        var in_stock_recieve_id = $("#in_stock_recieve_id").val();
        var in_stock_recieve_planting = $("#in_stock_recieve_planting").val();
        var in_stock_planting_detail = $("#in_stock_planting_detail").val();
        var in_stock_recieve_amount = $("#in_stock_recieve_amount").val();

        var grade = []
        var amount = []
        $('.in_stock_grade_id:checked').each(function (i) {

            grade[i] = $(this).val()
        });
        $('.in_stock_grade_amount').each(function (i) {

            if ($(this).val() != "") {
                amount[i] = $(this).val()
            }
        });

        var amounts = amount.filter(function (el) {
            return el != "empty";
        });


        console.log(grade)
        console.log(amounts)

        if (in_stock_recieve_planting == "0") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกรายการปลูก",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_stock_planting_detail == "0") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกพันธุ์ไม้",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_stock_recieve_amount == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนปลูกทั้งหมด",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (grade.length != amount.length) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนต้นไม้ของแต่ละเกรด",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (grade.length == 0 && amount.length == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกเกรดพันธุ์ไม้",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_stock_recieve_amount - checksum != 0) {
            var sumtotal = in_stock_recieve_amount - checksum
            swal({
                title: "แจ้งเตือน",
                text: "จำนวนต้นไม้ยังขาดอีก " + sumtotal + " " + "ต้น" + " " + "จากจำนวนปลูกทั้งหมด",
                icon: "warning",
                buttons: "ปิด",
            })
        } else {

            $.ajax({
                url: "./pages/stock_recieve/insert_stock_recieve.php",
                method: "POST",
                data: {
                    in_stock_recieve_id: in_stock_recieve_id,
                    in_stock_recieve_planting: in_stock_recieve_planting,
                    in_stock_planting_detail: in_stock_planting_detail,
                    in_stock_recieve_amount: in_stock_recieve_amount,
                    amounts: amounts,
                    grade: grade,

                },
                success: function (data) {
                    console.log(data)
                    swal({
                        text: "บันทึกข้อมูลเรียบร้อย",
                        icon: "success",
                        button: false
                    })
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                    $.ajax({

                        url: './notify_line_planting.php'

                    });
                }
            });
        }
    });


    $(document).on("click", "#btn_remove_recieve", function (event) {
        var recieve_id = $(this).attr('data')
        var recieve_status = $(this).attr('data-status')
        var plant_name = $(this).attr("data-name")
        if (recieve_status == 'เสร็จสิ้น') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลคัดเกรด : " + plant_name + " " + "(" + recieve_id + ")",
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "pages/stock_recieve/remove_recieve.php",
                            method: "POST",
                            data: {
                                recieve_id: recieve_id,
                                recieve_status: recieve_status
                            },
                            success: function (data) {
                                console.log(data)
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    var table = $('#stock_recieveTable').DataTable();
                                    table.destroy();
                                    fetch_stockTable()

                                    swal.close()
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
                text: " ยกเลิกการระงับข้อมูลคัดเกรด : " + plant_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "pages/stock_recieve/remove_recieve.php",
                            method: "POST",
                            data: {
                                recieve_id: recieve_id,
                                recieve_status: recieve_status
                            },
                            success: function (data) {
                                console.log(data)
                                swal({

                                    text: "ยกเลิกการระงับข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    var table = $('#stock_recieveTable').DataTable();
                                    table.destroy();
                                    fetch_stockTable()


                                    swal.close()
                                }, 1500);
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        }
    });

    $(document).on("click", "#btn_viewstock_detail", function (event) {

        var id = $(this).attr("data")
        var plant_name = $(this).attr("data-name")
        var planting_id = $(this).attr("planting-id")
        $("#recieve_id").text(id);
        $("#planting_id").text(planting_id);
        $("#plant_name").text(plant_name);
        console.log(plant_name)
        var table = $('#stock_recieve_detailTable').DataTable();
        table.destroy();
        fetch_stock_recieve_detailTables(id)

        recieve_detail_ids = id

    });

    var recieve_detail_ids
    $(document).on("click", "#btn_remove_recieve_detail", function (event) {
        var recieve_detail_id = $(this).attr('data')
        var recieve_detail_status = $(this).attr('data-status')
        var grade_name = $(this).attr("data-name")
        if (recieve_detail_status == 'เสร็จสิ้น') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลคัดเกรด : " + grade_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "pages/stock_recieve/remove_recieve_detail.php",
                            method: "POST",
                            data: {
                                recieve_detail_id: recieve_detail_id,
                                recieve_detail_status: recieve_detail_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    var table = $('#stock_recieve_detailTable').DataTable();
                                    table.destroy();

                                    fetch_stock_recieve_detailTables(recieve_detail_ids)

                                    swal.close()
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
                text: " ยกเลิกการระงับข้อมูลคัดเกรด : " + grade_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "pages/stock_recieve/remove_recieve_detail.php",
                            method: "POST",
                            data: {
                                recieve_detail_id: recieve_detail_id,
                                recieve_detail_status: recieve_detail_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกการระงับข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    var table = $('#stock_recieve_detailTable').DataTable();
                                    table.destroy();

                                    fetch_stock_recieve_detailTables(recieve_detail_ids)

                                    swal.close()
                                }, 1500);
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        }
    });

    $(document).on("click", "#btn_edit_recieve_detail", function (event) {
        var id = $(this).attr("data");
        console.log(id)


    });


    $(".edit_detail_amount").change(function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();

        if (!elem.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนต้นไม้เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }
    });

    $(document).on("click", "#btn_edit_detail", function (event) {
        var id = $(this).attr("data-id");
        /* var grade_id = $("#edit_detail_grade"+id).val(); */
        /* var grade_amount = $("#edit_detail_amount"+grade_id+id).val(); */
        var edit_detail_sum = $("#edit_detail_sum" + id).val();

        var grade = []
        var amount = []
        $('.edit_detail_grade' + id).each(function (i) {

            grade[i] = $(this).val()
        });
        $('.edit_detail_amount' + id).each(function (i) {
            amount[i] = $(this).val()
        });
        console.log(grade)
        console.log(amount)

        if (amount == "") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนต้นไม้",
                icon: "warning",
                buttons: "ปิด",
            })
        } else {
            $.ajax({
                url: "./pages/stock_recieve/edit_stock_recieve.php",
                method: "POST",
                data: {
                    id: id,
                    grade: grade,
                    amount: amount,


                },
                success: function (data) {
                    console.log(data)
                    /*   swal({
                          text: "บันทึกข้อมูลเรียบร้อย",
                          icon: "success",
                          button: false
                      })
                      setTimeout(function () {
                          location.reload();
                      }, 1500); */
                }
            });

        }

    });
});