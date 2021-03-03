$(document).ready(function () {

    //---- ตารางรายการ-----//
    handover_table();

    function handover_table() {

        var ta = $('#handoverTable').DataTable({
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
                url: "./pages/handover/fetch_planting_detail.php",
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

    $("#in_handover_amount").keyup(function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        if (!elem.match(/^([0-9 / .])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนเป็นตัวเลข",
                icon: "warning",
                button: false
            });
            $(this).val("");
            $(this).focus();
            return false;
        }
    });


    $(".in_handover_grade_amount").change(function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        var in_handover_total = $("#in_handover_total").val()
        in_handover_total = parseInt(in_handover_total)
        var sum = 0;

        sum = parseInt(sum)
        var sumval;

        if (!elem.match(/^([0-9 / .])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนเป็นตัวเลข",
                icon: "warning",
                button: false
            });
            $(this).val("");
            $(this).focus();
            return false;
        } else if (elem <= 0) {
            swal({
                text: "กรุณากรอกจำนวนให้มากกว่า 0",
                icon: "warning",
                button: false
            });
            $(this).val("");
            $(this).focus();

        } else {

            $('.in_handover_grade_amount').each(function (i) {
                sumval = parseInt($(this).val())
                if ($(this).val() != "") {
                    sum = sum + sumval

                }
            });

            if (sum > in_handover_total) {
                swal({
                    title: "แจ้งเตือน",
                    text: "จำนวนต้นไม้ของแต่ละเกรด ต้องไม่มากกว่าจำนวนคงเหลือ",
                    icon: "warning",
                    buttons: "ปิด",
                })
                $(this).val("");
                $(this).focus();
            }

        }
        checksum = sum

    });

    var checksum;
    //-- รีเซ็ตค่า --//
    $(document).on("click", "#modal_handover", function (event) {

        $("#in_handover")[0].reset();
        var table = $('#handover_detailTable').DataTable();
        table
            .clear()
            .draw();

    });



    $("#in_handover_planting").on("change", function (event) {

        var id = $(this).val();
        console.log(id)
        if (id == "0") {

            var table = $('#handover_detailTable').DataTable();
            table
                .clear()
                .draw();

            $("#in_handover_planting_detail option[value='0']").prop('selected', true);
            $("#in_handover_planting_detail").attr("disabled", true);
            $("#in_handover_amount").attr("disabled", true);
            $("#in_handover_amount").val("");
            $("#in_handover_planting_amount").val("");
            $("#in_handover_total").val("");
        } else {
            $("#in_handover_planting_detail").attr("disabled", false);
            $.ajax({
                type: 'POST',
                url: './pages/handover/get_planting_detail.php',
                data: 'id=' + id,
                success: function (html) {

                    $('#in_handover_planting_detail').html(html);

                }
            });
        }

    });

    $("#in_handover_amount").attr("disabled", true);
    
    $("#in_handover_planting_detail").on("change", function (event) {
        var id = $(this).val();
        console.log(id)

        if (id == "0") {
            var table = $('#handover_detailTable').DataTable();
            table
                .clear()
                .draw();
            $("#in_handover_amount").attr("disabled", true);
            $("#in_handover_amount").val("");
            $("#in_handover_planting_amount").val("");
            $("#in_handover_total").val("");

        } else {


            var table = $('#handover_detailTable').DataTable();
            table.destroy();

            handover_detail(id);
            $("#in_handover_amount").attr("disabled", false);
            $.ajax({
                type: 'POST',
                url: './pages/handover/get_planting_amount.php',
                data: 'id=' + id,
                success: function (html) {

                    $('#in_handover_planting_amount').val(html);

                }
            });

            $.ajax({
                type: 'POST',
                url: './pages/handover/get_planting_amount2.php',
                data: 'id=' + id,
                success: function (html) {

                    amount_planting = html
                }
            });



        }
    });

    var amount_planting;


    $("#in_handover_amount").keyup(function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        if (!elem.match(/^([0-9 / .])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนเป็นตัวเลข",
                icon: "warning",
                button: false
            });
            $(this).val("");
            $("#in_handover_total").val("")
            $(this).focus();
            return false;
        }
    });

    $("#in_handover_amount").on("change", function (event) {

        var planting_amount = $("#in_handover_planting_amount").val();
        var amount_total = $(this).val();

        if (parseInt(amount_total) > parseInt(amount_planting)) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนไม่เกิน" + " " + amount_planting + " " + "ต้น",
                icon: "warning",
                buttons: "ปิด",
            })

            $("#in_handover_amount").val("")
            $("#in_handover_total").val("")

        } else if (planting_amount > amount_total) {
            total = 0
            $(".in_handover_grade_id").attr("disabled", true);
        } else {
            var total = parseInt(amount_total) - parseInt(planting_amount)
            if (total <= 0) {

                $(".in_handover_grade_id").attr("disabled", true);

            } else {
                $(".in_handover_grade_id").attr("disabled", false);
            }

        }
        $("#in_handover_total").val(total);
    });

    $(".in_handover_grade_id").on("change", function (event) {

        var id = $(this).val();

        if (this.checked) {

            $("#in_handover_grade_amount" + id).attr("disabled", false);
        } else {

            $("#in_handover_grade_amount" + id).attr("disabled", true);
            $("#in_handover_grade_amount" + id).val("");
        }
    });

    $("#btn_add_handover").on("click", function (event) {

        var in_handover_id = $("#in_handover_id").val();
        var in_handover_planting = $("#in_handover_planting").val();
        var in_handover_planting_detail = $("#in_handover_planting_detail").val();
        var in_handover_total = $("#in_handover_total").val();
        var in_handover_planting_amount = $("#in_handover_planting_amount").val();

        var grade = []
        var amount = []
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


        console.log(grade)
        console.log(amounts)

        if (in_handover_planting == "0") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกรายการปลูก",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_handover_planting_detail == "0") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกพันธุ์ไม้",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_handover_amount == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนปลูกทั้งหมด",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (grade.length != amount.length) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนต้นไม้ของแต่ละเกรด*",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (grade.length == 0 && amount.length == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกจำนวนต้นไม้ของแต่ละเกรด2",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (in_handover_total - checksum != 0) {
            var sumtotal = in_handover_total - checksum
            swal({
                title: "แจ้งเตือน",
                text: "จำนวนต้นไม้ยังขาดอีก " + sumtotal + " " + "ต้น",
                icon: "warning",
                buttons: "ปิด",
            })
        } else {

            $.ajax({
                url: "./pages/handover/insert_handover.php",
                method: "POST",
                data: {
                    in_handover_id: in_handover_id,
                    in_handover_planting: in_handover_planting,
                    in_handover_planting_detail: in_handover_planting_detail,
                    in_handover_total: in_handover_total,
                    amounts: amounts,
                    grade: grade,
                    in_handover_planting_amount: in_handover_planting_amount
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
                }
            });
        }
    });


});