$(document).ready(function () {

    //---- ตาราง-----//

    var t = $('#formulaTable').DataTable({
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

                    } else {
                        color = "black";
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
            url: "./pages/drugformula/fetch_drug_formula.php",
            type: "post",

        }
    });
    t.on('order.dt search.dt', function () {
        t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    function fetch_drug_formula() {
        var ta = $('#formulaTable').DataTable({
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

                        } else {
                            color = "black";
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
                url: "./pages/drugformula/fetch_drug_formula.php",
                type: "post",

            }
        });
        ta.on('order.dt search.dt', function () {
            ta.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    $(document).on("change", "#add_formula_typedrug", function (event) {

        var id_type = $(this).val();

        $.ajax({
            type: 'POST',
            url: './pages/drug/get_group.php',
            data: 'type_id=' + id_type,
            success: function (html) {
                $('#add_formula_groupdrug').html(html);
            }
        });

        $("#add_formula_drug option[value='0']").prop('selected', true);
        $("#show1").prop("hidden", true)
        $("#show2").prop("hidden", true)

    });


    $(document).on("change", "#add_formula_groupdrug", function (event) {

        var id_drug = $(this).val();

        $.ajax({
            type: 'POST',
            url: './pages/drugformula/get_drug.php',
            data: 'drug_id=' + id_drug,
            success: function (html) {
                $('#add_formula_drug').html(html);
            }
        });


        $("#add_formula_drug option[value='0']").prop('selected', true);
        $("#show1").prop("hidden", true)
        $("#show2").prop("hidden", true)

        /*  $.ajax({
             type: 'POST',
             url: './pages/drug/get_smunit.php',
             data: 'unit_id=' + id_drug,
             success: function (html) {
                 $('#add_formula_drugsmunit').val(html);
             }
         }); */

    });

    var td = $('#add_formulaTable').DataTable({
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
                targets: 7,
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

        }
    });
    td.on('order.dt search.dt', function () {
        td.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();




    $("#drugamount").on("change", function (event) {

        var id = $(this).val()


        cal_unit = id * 1000
        console.log(cal_unit)
        $("#formula_small_unit").val(cal_unit)

    });

    $("#unit").on("change", function (event) {

        var id = $("#unit").val();
        var txt_unit = $("#unit option:selected").text();

        if (id == "0") {
            $("#show_formula_unit").text("")

        } else {
            $("#show_formula_unit").text(txt_unit)

        }
    });

    $("#formula_amount").on("change", function (event) {

        var use_amount = $(this).val()

        var drugamount = $("#drugamount").val()
        var drugprice = $("#add_formula_price").val()


        if (use_amount == 0) {

            swal({
                text: "กรุณากรอกปริมาณการใช้ยา ให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#formula_use_amount").val("");
            $("#add_formula_total_price").val("");
        } else {
            cal_drug_mil = drugamount * 1000
            cal_price_per_mil = drugprice / cal_drug_mil


            cal_use_lite = use_amount * drugamount
            cal_use_mil = cal_use_lite
            total_lite = parseFloat(cal_use_mil.toFixed(2))
            $("#formula_use_amount").val(total_lite)

            price_total = cal_use_mil * cal_price_per_mil

            total = price_total * 1000
            total_price = total.toFixed(2)
            $("#add_formula_total_price").val(total_price)
        }
        /*   cal_use_unit = amount * drugamount
          cal_use_smunit = cal_use_unit * 1000
          formula_use_amount
          $("#formula_use_unit").val(cal_use_unit)
          $("#formula_use_smunit").val(cal_use_smunit)
     
     
          cal_price = price / amount_smunit
          console.log(cal_price)
          total_price = cal_price * cal_use_smunit
          console.log(total_price)
          $("#add_formula_total_price").val(total_price)
    */

    });

    $("#show1").prop("hidden", true)
    $("#show2").prop("hidden", true)
    $(document).on("change", "#add_formula_drug", function (event) {

        var id_type = $(this).val();
        var txt_drug = $("#add_formula_drug option:selected").text();
        var l1 = $('#add_formulaTable td:nth-child(4)').map(function () {
            return $(this).text();
        }).get();
        //l1.shift()
        if ($.inArray(txt_drug, l1) >= 0) {
            swal({
                title: "แจ้งเตือน",
                text: "คุณได้เพิ่มยานี้ไปแล้ว กรุณาเลือกใหม่อีกครั้ง",
                icon: "warning",
                buttons: "ปิด",
            })
            $("#add_formula_drug option[value='0']").prop('selected', true);
            /*   $("#add_formula_typedrug option[value='0']").prop('selected', true);
              $("#add_formula_groupdrug option[value='0']").prop('selected', true); */

        } else if (id_type == "0") {

            $("#show1").prop("hidden", true)
            $("#show2").prop("hidden", true)

        } else {

            $.ajax({
                url: "./pages/drugformula/get_amount.php",
                method: "POST",
                data: {
                    id: id_type,
                },
                success: function (data) {
                    console.log(data)
                    $("#drugamount").val(data)
                }
            });

            $.ajax({
                url: "./pages/drugformula/get_smunit.php",
                method: "POST",
                data: {
                    id: id_type,
                },
                success: function (data) {
                    console.log(data)
                    $("#show_amount_unit").text(data)
                }
            });

            $.ajax({
                url: "./pages/drugformula/get_price.php",
                method: "POST",
                data: {
                    id: id_type,
                },
                success: function (data) {
                    console.log(data)
                    $("#add_formula_price").val(data)
                }
            });

            $.ajax({
                url: "./pages/drugformula/get_unit.php",
                method: "POST",
                data: {
                    id: id_type,
                },
                success: function (data) {
                    console.log(data)
                    $("#show_formula_unit").text(data)
                }
            });

            $.ajax({
                url: "./pages/drugformula/get_smunit.php",
                method: "POST",
                data: {
                    id: id_type,
                },
                success: function (data) {
                    console.log(data)
                    $("#show_formula_smunit").text(data)
                }
            });

            $("#show1").prop("hidden", false)
            $("#show2").prop("hidden", false)



        }

    });

    //--- เช็คชื่อสูตรยาซ้ำ ปุ่มเพิ่มข้อมูลสูตรยา ---//
    $(".formula_name").on("change", function (event) {
        var formula_name = $(this).val();



        $.ajax({
            url: "./pages/drugformula/check_insert_formula.php",
            method: "POST",
            data: {
                formula_name: formula_name
            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "ชื่อสูตรยานี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: false
                    });
                    $(".formula_name").val("");
                    $(this).focus();
                }
            }
        });

    });


    $(".drugamount").keyup(function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        if (!elem.match(/^([0-9 / . /''])+$/i)) {
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


    $("#drugamount").attr("disabled", true);
    $("#add_formula_drug").change(function () {
        $("#drugamount").attr("disabled", false);
    });

    $(document).on("change", "#formula_name", function (event) {

        var name = $(this).val()
        name = name.replace(/^\s+|\s+$/gm, '');
        $(this).val(name)
    });

    function formatCurrency(number) {
        number = parseFloat(number);
        return number.toFixed(0).replace(/./g, function (c, i, a) {
            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
        });
    }
    function formatCurrency2(number) {
        number = parseFloat(number);
        return number.toFixed(2).replace(/./g, function (c, i, a) {
            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
        });
    }

    // ปุ่มเพิ่มข้อมูลสูตรยา  // 
    var arr_id = [], arr_amount = [], arr_amount_sm = [], arr_price = []
    $(document).on("click", "#btn_add_formulalist", function (event) {

        var add_formula_typedrug = $("#add_formula_typedrug").val();
        var txt_drugtype = $("#add_formula_typedrug option:selected").text();
        var add_formula_groupdrug = $("#add_formula_groupdrug").val();
        var txt_druggroup = $("#add_formula_groupdrug option:selected").text();
        var drug_id = $("#add_formula_drug").val();
        var txt_drug = $("#add_formula_drug option:selected").text();
        var add_formula_price = $("#add_formula_price").val();
        var drug_amount = $("#drugamount").val();
        var formula_amount = $("#formula_amount").val()
        var show_formula_unit = $("#show_formula_unit").text()
        var add_formula_total_price = $("#add_formula_total_price").val()
        var show_formula_smunit = $("#show_formula_smunit").text()
        price = parseFloat(add_formula_price).toFixed(2)
        total = parseFloat(add_formula_total_price).toFixed(2)
        var formula_use_amount = $("#formula_use_amount").val();

        var button = '<button id="re" class="btn btn-danger btn-xs my-xs-btn" data-toggle="tooltip"  title="ลบข้อมูล" type="button"><i class="fas fa-trash-alt" style="color:white;"></i></button>';

        if (add_formula_typedrug == "0") {  //เช็คจำนวนห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกประเภทยา",
                icon: "warning",
                buttons: "ปิด",
            })

        } else if (add_formula_groupdrug == "0") {  //เช็คจำนวนห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกกลุ่มยา",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (drug_id == "0") {  // เช็คยาห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกชื่อยา",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (formula_amount == "") {  //เช็คจำนวนห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกประมาณการใช้ยา",
                icon: "warning",
                buttons: "ปิด",
            })

        } else {
            td.row.add([  // ส่งข้อมูลเข้าไปแสดงที่ตาราง 
                "",
                txt_drugtype,
                txt_druggroup,
                txt_drug,
                price,
                formula_amount + " " + "(" + show_formula_unit + ")",
                formula_use_amount + " " + "(" + show_formula_smunit + ")",
                total,
                button

            ]).draw(false);
            arr_id.push(drug_id)
            arr_amount.push(formula_amount)
            arr_amount_sm.push(formula_use_amount)
            arr_price.push(add_formula_total_price)

            console.log(arr_id)
            console.log(arr_amount)
            console.log(arr_amount_sm)
            console.log(arr_price)

            $("#add_formula_typedrug option[value='0']").prop('selected', true); //รีเซ็ตค่าให้กลับไปเป็น 0 หรือ ""
            $("#add_formula_groupdrug option[value='0']").prop('selected', true);
            $("#add_formula_drug option[value='0']").prop('selected', true);
            $("#unit option[value='0']").prop('selected', true);
            $('#drugamount').val("")
            $('#add_formula_price').val("")
            $('#add_formula_drugsmunit').val("")
            $('#show_amount_unit').text("")
            $('#formula_small_unit').val("")
            $('#show_formula_small_unit').text("")
            $('#formula_amount').val("")
            $('#show_formula_unit').text("")

            $('#formula_use_unit').val("")
            $('#show_formula_amount_unit').text("")
            $('#formula_use_smunit').val("")
            $('#show_formula_amount_smunit').text("")

            $('#add_formula_total_price').val("")
            $('#formula_use_amount').val("")
            $("#show1").prop("hidden", true)
            $("#show2").prop("hidden", true)
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

    $(document).on("click", "#modal_add", function () {

        td.clear().draw();
        arr_id = [], arr_amount = [], arr_amount_sm = [], arr_price = []

    });

    //--- ปุ่มบันทึกสูตรยา  ---//
    $(document).on("click", "#btn_add_formula", function (event) {
        var formula_name = $('#formula_name').val();
        var formula_total = $('#formula_total').val();

        if (arr_id.length == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกข้อมูลยา",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (formula_name == "") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกชื่อสูตรยา",
                icon: "warning",
                buttons: false,
            })
        } else if (formula_total == "") {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกสูตรยา/จำนวนต้น",
                icon: "warning",
                buttons: false,
            })
        } else {

            $.ajax({
                url: "./pages/drugformula/insert_formula.php",
                method: "POST",
                data: {
                    formula_name: formula_name,
                    formula_total: formula_total,
                    arr_id: arr_id,
                    arr_amount: arr_amount,
                    arr_amount_sm: arr_amount_sm,
                    arr_price: arr_price
                },
                success: function (data) {
                    console.log(data)
                    swal({
                        text: "เพิ่มข้อมูลเรียบร้อย",
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

    /*   //-- รีเซ็ตค่า --//
      $(document).on("click", "#tbl_edit_eq", function (event) {
     
          var id = $(this).attr('data');
     
          $("#edit_detaildrug" + id)[0].reset();
     
     
      });
       */
    $(document).on("change", ".edit_detail_type", function (event) {

        var id_type = $(this).val();
        $.ajax({
            type: 'POST',
            url: './pages/drug/get_group.php',
            data: 'type_id=' + id_type,
            success: function (html) {
                $('#edit_detail_group').html(html);
            }
        });

    });

    $(document).on("change", ".edit_detail_group", function (event) {

        var drug_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: './pages/drugformula/get_drug.php',
            data: 'drug_id=' + drug_id,
            success: function (html) {
                $('#edit_detail_drug').html(html);
            }
        });

    });

    var drugformula_detail_id
    var drugformula_id
    $(document).on("click", "#btn_edit_formula_detail", function (event) {

        var id = $(this).attr('data');
        drugformula_detail_id = id
        var unitname = $(this).attr('data-unit');
        var smunitname = $(this).attr('data-smunit');
        var formulaid = $(this).attr('data-formulaid');
        drugformula_id = formulaid
        console.log(formulaid)
        console.log(id)
        console.log(unitname)
        console.log(smunitname)
        $.ajax({
            url: "./pages/drugformula/fetch_modal_edit_detail.php",
            method: "POST",
            data: {
                id: id
            },
            success: function (data) {
                /*  console.log(data) */
                $("#show_modal").html(data)
                $("#edit_formula_detail" + id).modal("show")
                $("#show_edit_unit1").text(smunitname)
                $("#show_edit_unit2").text(unitname)
                $("#show_edit_unit3").text(smunitname)
            }
        });



    });



    $(document).on("change", ".edit_formula_name", function (event) {

        var formula_name = $(this).val()
        var id = $(this).attr("data-id")
        $.ajax({
            url: "./pages/drugformula/check_edit_drugformula.php",
            method: "POST",
            data: {
                id: id,
                formula_name: formula_name

            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "ชื่อสูตรยานี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด"
                    })

                    $("#edit_formula_name" + id).val("")
                }

            }
        });

    });



    //-- แก้ไข สูตรยา formula --//
    $(document).on("click", "#btn_edit_formula", function (event) {

        var id = $(this).attr('data-id');
        var edit_formula_name = $('#edit_formula_name' + id).val();
        var edit_formula_amount = $('#edit_formula_amount' + id).val();

        if (edit_formula_name == "") {  // เช็คยาห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกชื่อสูตรยา",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (edit_formula_amount == "") {  // เช็คยาห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกสูตรยา/จำนวน",
                icon: "warning",
                buttons: "ปิด",
            })
        } else {

            $.ajax({
                url: "./pages/drugformula/update_formula.php",
                method: "POST",
                data: {
                    id: id,
                    edit_formula_name: edit_formula_name,
                    edit_formula_amount: edit_formula_amount

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


                }
            });
        }

    });

    //---- Remove formula -----//
    $(document).on("click", "#btn_remove_formula", function (event) {
        var drug_formula_id = $(this).attr('data-id')
        var drug_formula_status = $(this).attr('data-status')
        var drug_formula_name = $(this).attr("data-name")

        if (drug_formula_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลสูตรยา : " + drug_formula_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/drugformula/remove_formula.php",
                            method: "POST",
                            data: {
                                drug_formula_id: drug_formula_id,
                                drug_formula_status: drug_formula_status,

                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
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
                text: " ยกเลิกการระงับข้อมูลสูตรยา : " + drug_formula_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/drugformula/remove_formula.php",
                            method: "POST",
                            data: {
                                drug_formula_id: drug_formula_id,
                                drug_formula_status: drug_formula_status,

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

    function fetch_drug_formula_detail(id) {
        var a = $('#tb_drug_formula_detail').DataTable({
            retrieve: true,
            paging: true,

            "responsive": true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 7,
                    className: 'dt-body-right'
                },
                {
                    targets: 8,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ระงับ") {
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
                url: "./pages/drugformula/fetch_drug_formula_detail.php",
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

    //---  ตารางรายละเอียดสูตรยา ในปุ่ม formula detail --//
    $(document).on("click", "#btn_viewdialog", function (event) {

        var table = $('#tb_drug_formula_detail').DataTable();
        table.destroy();

        var id = $(this).attr('data-id')
        var formula_name = $(this).attr('data-name')
        formula_detail_id = id
        console.log(id)


        $("#show_formula_id").text(id)
        $("#show_formula_name").text(formula_name)
        fetch_drug_formula_detail(id)

    });

    var formula_detail_id
    //---- Remove formula detail-----//
    $(document).on("click", "#btn_remove_detail", function (event) {
        var detail_id = $(this).attr('data')
        var status = $(this).attr('data-status')
        var drug_name = $(this).attr("data-name")

        if (status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลยา : " + drug_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/drugformula/remove_formula_detail.php",
                            method: "POST",
                            data: {
                                detail_id: detail_id,
                                status: status,

                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    swal.close();
                                }, 1500);

                                var table = $('#formulaTable').DataTable();
                                table.destroy(); //ลบตารางทิ้ง

                                fetch_drug_formula();

                                var table = $('#tb_drug_formula_detail').DataTable();
                                table.destroy(); //ลบตารางทิ้ง

                                fetch_drug_formula_detail(formula_detail_id)
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        } else {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกการระงับข้อมูลยา : " + drug_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/drugformula/remove_formula_detail.php",
                            method: "POST",
                            data: {
                                detail_id: detail_id,
                                status: status,

                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกการระงับข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    swal.close();
                                }, 1500);

                                var table = $('#formulaTable').DataTable();
                                table.destroy(); //ลบตารางทิ้ง

                                fetch_drug_formula();


                                var table = $('#tb_drug_formula_detail').DataTable();
                                table.destroy(); //ลบตารางทิ้ง

                                fetch_drug_formula_detail(formula_detail_id)
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        }

    });

    $(document).on("click", "#modal_add", function (event) {

        $("#myDrug")[0].reset();

    });



    //-- รีเซ็ตค่า --//
    $(document).on("click", "#btn_edit_formula_detail", function (event) {

        $("#edit_formula_detail")[0].reset();


    });


    var drug_type
    //--- ปุ่มแก้ไข เช็คแก้ไขชื่อยาแล้วซ้ำกัน ---//
    $(document).on("change", ".edit_detail_drug", function (event) {

        var ref_drug_formula = $("#edit_drug_formula_id").val();
        var drug_id = $(this).val();
        var drug_group = $("#edit_detail_group").val();
        var drug_type = $("#edit_detail_type").val();
        var edit_detail_amount = $("#edit_detail_amount").val();

        console.log(drugformula_detail_id)
        console.log(drug_id)
        console.log(drug_group)
        console.log(drug_type)

        /*  $("#edit_detail_amount").val(""); */
        /*         $(".edit_detail_type option[value='0']").prop('selected', true);
                $(".edit_detail_group option[value='0']").prop('selected', true); */
        $("#edit_formula_price").val("");
        $(".edit_peramount").val("")
        $(".edit_perprice").val("")
        $.ajax({
            url: "./pages/drugformula/check_edit_formula.php",
            method: "POST",
            data: {
                drugformula_detail_id: drugformula_detail_id,
                ref_drug_formula: ref_drug_formula,
                drug_id: drug_id,
                drug_type: drug_type,
                drug_group: drug_group


            },
            success: function (data) {
                console.log(data)
                if (data == 1) {
                    swal({
                        text: "ชื่อยานี้มีอยู่ในรายการแล้ว กรุณาเลือกใหม่",
                        icon: "warning",
                        button: false
                    });

                    /*  $(".edit_detail_type option[value='0']").prop('selected', true);
                     $(".edit_detail_group option[value='0']").prop('selected', true); */
                    $(".edit_detail_drug option[value='0']").prop('selected', true);
                    $(".edit_peramount").val("")
                    $(".edit_perprice").val("")
                    $(".edit_formula_price").val("")
                    $('#show_edit_unit2').text("");
                    $('#show_edit_unit1').text("");
                    $("#edit_use_amount").val("");
                } else {

                    $.ajax({
                        type: 'POST',
                        url: './pages/drugformula/get_smunit.php',
                        data: {

                            id: drug_id

                        },
                        success: function (data) {
                            console.log(data)
                            $('#show_edit_unit1').text(data);
                        }

                    });

                    $.ajax({
                        type: 'POST',
                        url: './pages/drugformula/get_unit.php',
                        data: {

                            id: drug_id

                        },
                        success: function (data) {
                            console.log(data)
                            $('#show_edit_unit2').text(data);
                        }

                    });


                    $.ajax({
                        type: 'POST',
                        url: './pages/drugformula/get_amount.php',
                        data: {

                            id: drug_id

                        },
                        success: function (data) {
                            $('#edit_peramount').val(data);
                        }

                    });

                    $.ajax({
                        type: 'POST',
                        url: './pages/drugformula/get_price.php',
                        data: {

                            id: drug_id

                        },
                        success: function (data) {
                            $('#edit_perprice').val(data);
                        }

                    });

                    $.ajax({
                        type: 'POST',
                        url: './pages/drugformula/calculate_smunit.php',
                        data: {

                            id_drug: drug_id,
                            id_drugamount: edit_detail_amount

                        },
                        success: function (data) {
                            $('#edit_use_amount').val(data);
                        }

                    });
                    $.ajax({
                        type: 'POST',
                        url: './pages/drugformula/calculate_price.php',
                        data: {

                            id_drug: drug_id,
                            id_drugamount: edit_detail_amount
                        },
                        success: function (data) {
                            $('#edit_formula_price').val(data);
                        }

                    });
                    $.ajax({
                        type: 'POST',
                        url: './pages/drugformula/get_drug_group.php',
                        data: {

                            drug_id: drug_id
                        },
                        success: function (html) {
                            console.log(html)

                            drug_type = html
                            $('.edit_detail_group').val(html);
                            $.ajax({
                                type: 'POST',
                                url: './pages/drugformula/get_drug_type.php',
                                data: {

                                    drug_type: drug_type
                                },
                                success: function (html) {
                                    console.log(html)


                                    $('.edit_detail_type').val(html);

                                }

                            });
                        }

                    });


                }
            }
        });

    });

    $(document).on("change", ".edit_detail_amount", function (event) {



        var drug_group = $("#edit_detail_group").val();
        var drug_type = $("#edit_detail_type").val();
        var ref_drug_formula = $("#edit_drug_formula_id").val();
        var drug_id = $("#edit_detail_drug").val();
        var use_amount = $("#edit_detail_amount").val();

        if (!use_amount.match(/^([0-9 .])+$/i)) {
            swal({
                text: "กรุณากรอกปริมาณการใช้ยา เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#edit_use_amount").val("");
            $("#edit_formula_price").val("");
            return false;
        } else if (drug_type == 0) {
            swal({
                text: "กรุณาเลือกประเภทยา",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
        } else if (drug_group == 0) {
            swal({
                text: "กรุณาเลือกกลุ่มยา",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
        } else if (drug_id == 0) {
            swal({
                text: "กรุณาเลือกยา",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
        } else if (use_amount == 0) {
            swal({
                text: "กรุณากรอกปริมาณการใช้ยา ให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#edit_use_amount").val("");
            $("#edit_formula_price").val("");
        } else if (use_amount == ".") {
            swal({
                text: "กรุณาปริมาณการใช้ยา เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#edit_use_amount").val("");
            $("#edit_formula_price").val("");


        } else {
            $.ajax({
                type: 'POST',
                url: './pages/drugformula/calculate_price.php',
                data: {
                    id_drugamount: use_amount,
                    id_drug: drug_id
                },
                success: function (html) {
                    $('#edit_formula_price').val(html);
                }

            });

            $.ajax({
                type: 'POST',
                url: './pages/drugformula/calculate_smunit.php',
                data: {
                    id_drugamount: use_amount,
                    id_drug: drug_id
                },
                success: function (html) {
                    $('#edit_use_amount').val(html);
                }

            });
        }
    });

    //--- ปุ่มแก้ไข คำนวนราคา ต่อปริมาณยา ---//

    /* 
        $(".edit_drugamount").keyup(function (event) {
            var id_drugamount = $(this).val();
            var id_drug = $("#edit_detail_drug").val();
     
            if (!id_drugamount.match(/^([0-9 / . ])+$/i)) {
                swal({
                    text: "กรุณากรอกจำนวนเป็นตัวเลข",
                    icon: "warning",
                    button: "ปิด"
                });
                $(this).val("");
                $(this).focus();
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: './pages/drugformula/calculate_price.php',
                    data: {
                        id_drugamount: id_drugamount,
                        id_drug: id_drug
                    },
                    success: function (html) {
                        $('#edit_formula_price').val(html);
                    }
     
                });
            }
        }); */



    //-- edit formula detail --//
    $(document).on("click", "#btn_detail_formula", function (event) {


        var edit_detail_drug = $('#edit_detail_drug').val();
        var edit_detail_amount = $('#edit_detail_amount').val();
        var edit_use_amount = $('#edit_use_amount').val();
        var edit_formula_price = $('#edit_formula_price').val();

        var edit_detail_type = $('#edit_detail_type').val();
        var edit_detail_group = $('#edit_detail_group').val();

        if (edit_detail_type == "0") {  //เช็คจำนวนห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกประเภทยา",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (edit_detail_group == "0") {  //เช็คจำนวนห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกกลุ่มยา",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (edit_detail_drug == "0") {  // เช็คยาห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกยา",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (edit_detail_amount == "") {  //เช็คจำนวนห้ามว่าง
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกปริมาณการใช้ยา",
                icon: "warning",
                buttons: "ปิด",
            })

        } else {

            $.ajax({
                url: "./pages/drugformula/update_formula_detail.php",
                method: "POST",
                data: {
                    id: drugformula_detail_id,
                    edit_detail_drug: edit_detail_drug,
                    edit_detail_amount: edit_detail_amount,
                    edit_formula_price: edit_formula_price,
                    edit_use_amount: edit_use_amount


                },
                success: function (data) {
                    console.log(data)
                    swal({
                        text: "แก้ไขข้อมูลเรียบร้อย",
                        icon: "success",
                        button: false
                    })
                    $('#edit_formula_detail' + drugformula_detail_id).modal('toggle');
                    setTimeout(function () {
                        swal.close();
                    }, 1500);

                    var table = $('#formulaTable').DataTable();
                    table.destroy(); //ลบตารางทิ้ง

                    fetch_drug_formula()

                    var table = $('#tb_drug_formula_detail').DataTable();
                    table.destroy(); //ลบตารางทิ้ง

                    fetch_drug_formula_detail(formula_detail_id)
                }

            });


        }

    });




    /*  $(document).on("change", ".edit_detail_group", function (event) {
     
         var id_unit = $(this).val();
         var id = $(this).attr("data-id")
         $.ajax({
             type: 'POST',
             url: './pages/drug/get_smunit.php',
             data: 'unit_id=' + id_unit,
             success: function (html) {
                 $('#edit_detail_smunit' + id).val(html);
             }
         });
     
     });
    */
    //--- คำนวนราคา ต่อปริมาณยา่ ---//
    /*  $(".drugamount").keyup(function (event) {
     
         var id_drugamount = $(this).val();
         var id_drug = $("#add_formula_drug").val();
     
     
         $.ajax({
             type: 'POST',
             url: './pages/drugformula/calculate_price.php',
             data: {
                 id_drugamount: id_drugamount,
                 id_drug: id_drug
             },
             success: function (html) {
                 $('#add_formula_price').val(html);
             }
     
     
         });
     
     }); */

    $("#formula_total").keyup("change", function () {

        var id = $(this).val()
        if (!id.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอก สูตรยา/จำนวน เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        } else if (id == 0) {
            swal({
                text: "กรุณากรอก สูตรยา/จำนวน ให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");

        }
    });

    $("#formula_amount").keyup("change", function () {

        var id = $(this).val()
        var type = $("#add_formula_typedrug").val()
        var group = $("#add_formula_groupdrug").val()
        var drug = $("#add_formula_drug").val()
        if (type == "0") {
            swal({
                text: "กรุณาเลือกประเภทยา",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#formula_use_amount").val("");
            $("#add_formula_total_price").val("");
        } else if (group == "0") {
            swal({
                text: "กรุณาเลือกกลุ่มยา",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#formula_use_amount").val("");
            $("#add_formula_total_price").val("");
        } else if (drug == "0") {
            swal({
                text: "กรุณาเลือกยา",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#formula_use_amount").val("");
            $("#add_formula_total_price").val("");
        } else if (!id.match(/^([0-9 .])+$/i)) {
            swal({
                text: "กรุณากรอกปริมาณการใช้ยา เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#formula_use_amount").val("");
            $("#add_formula_total_price").val("");
            return false;
        } else if (id == ".") {
            swal({
                text: "กรุณากรอกปริมาณการใช้ยา เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#formula_use_amount").val("");
            $("#add_formula_total_price").val("");
        }
    });



    var formula_id
    $(document).on("click", ".edit_formula", function (event) {

        var id = $(this).attr("data-id")
        formula_id = id
        $("#edit_drugformula" + id)[0].reset();


    });

    $(document).on("change", ".edit_formula_name", function (event) {
        var id = $(this).val()
        id = id.replace(/^\s+|\s+$/gm, '');
        $("#edit_formula_name" + formula_id).val(id)

    });


    $(".edit_formula_amount").keyup("change", function () {

        var id = $(this).val()
        if (!id.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกสูตรยา/จำนวน เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $("#edit_formula_amount" + formula_id).val("");

            return false;
        } else if (id == 0) {
            swal({
                text: "กรุณากรอกสูตรยา/จำนวน ให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $("#edit_formula_amount" + formula_id).val("");

        }
    });





});
