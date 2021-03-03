$(document).ready(function () {



    //---- ตาราง-----//
    var t = $('#materialTable').DataTable({
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

        }
    });
    t.on('order.dt search.dt', function () {
        t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $("#insert_type_material_name").on("change", function (event) {
        var id = $(this).val()

     
            $("#insert_unit_name option[value='0']").prop('selected', true);
            $("#insert_material_name").val("")
            $("#insert_material_amount").val("")
            $("#insert_material_amount_gram").val("")
            $("#insert_material_price").val("")

    });

    $("#insert_unit_name").on("change", function (event) {
        var id = $(this).val()


            $("#insert_material_amount").val("")
            $("#insert_material_amount_gram").val("")

    });

    $("#insert_material_name").on("change", function (event) {
        var id = $(this).val()

        ids = id.replace(/ /g, "");
        $(this).val(ids)

        if (!ids.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")

        } else {
            $('#insert_material_name').focus();
        }
    });

    /* //--- เช็คชื่อวัสดุปลูกซ้ำ ปุ่มเพิ่มข้อมูลวัสดุปลูก ---//
    $("#insert_material_amount").on("change", function (event) {

        var insert_material_name = $("#insert_material_name").val();
        var insert_type_material_name = $("#insert_type_material_name").val();
        var insert_unit_name = $("#insert_unit_name").val();
        var insert_material_amount = $(this).val();

        if (!insert_material_amount.match(/^([0-9 / .])+$/i)) {
            swal({
                text: "กรุณากรอก ปริมาตร/หน่วย เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;

        } else {
            $.ajax({
                url: "./pages/material/check_insert_material.php",
                method: "POST",
                data: {

                    insert_material_name: insert_material_name,
                    insert_type_material_name: insert_type_material_name,
                    insert_unit_name: insert_unit_name,
                    insert_material_amount: insert_material_amount

                },
                success: function (data) {
                    console.log(data)
                    if (data == 1) {
                        swal({
                            text: "ชื่อวัสดุปลูกนี้มีปริมาตรนี้อยู่แล้ว กรุณากรอกใหม่",
                            icon: "warning",
                            button: "ปิด"
                        });
                        $("#insert_material_amount").val("");
                        $("#insert_material_amount_gram").val("");
                        $(this).focus();
                    }
                }
            });
        }
    }); */



    $("#insert_type_material_name").on("change", function () {

        var insert_type_material_name = $(this).val();

        $.ajax({
            url: "./pages/material/get_smunit.php",
            method: "POST",
            data: {
                id: insert_type_material_name
            },
            success: function (html) {

                $("#insert_material_unit").val(html)

            }
        });

    });

   


    //insert ข้อมูลวัสดุปลูก//
    $(document).on("click", "#btn_save_material", function (event) {

        var insert_type_material_name = $("#insert_type_material_name").val();
        var insert_material_name = $("#insert_material_name").val();
        var insert_unit_name = $("#insert_unit_name").val();
        var insert_material_price = $("#insert_material_price").val();
        var insert_material_amount = $("#insert_material_amount").val();

        if (insert_type_material_name == "0") {    //ดักข้อมูล ค่าว่าง//

            swal({
                text: "กรุณาเลือกประเภทวัสดุปลูก",
                icon: "warning",
                button: "ปิด"

            });
        } else if (insert_unit_name == 0) {

            swal({
                text: "กรุณาเลือกหน่วย",
                icon: "warning",
                button: "ปิด"
            });


        } else if (insert_material_name == "") {

            swal({
                text: "กรุณากรอกชื่อวัสดุปลูก",
                icon: "warning",
                button: "ปิด"
            });
        } else if (insert_material_amount == "") {
            swal({
                text: "กรุณากรอกปริมาตร/หน่วย",
                icon: "warning",
                button: "ปิด"
            });
        } else if (insert_material_price == "") {
            swal({
                text: "กรุณากรอกราคา/หน่วย",
                icon: "warning",
                button: "ปิด"
            });


        } else {
            console.log(insert_material_name)
            console.log(insert_type_material_name)
            console.log(insert_unit_name)
            console.log(insert_material_amount)

            //ส่งข้อมูลไป insert//
            $.ajax({
                url: "./pages/material/insert_material.php",
                method: "POST",
                data: {
                    insert_type_material_name: insert_type_material_name,
                    insert_material_name: insert_material_name,
                    insert_unit_name: insert_unit_name,
                    insert_material_price: insert_material_price,
                    insert_material_amount: insert_material_amount
                },
                success: function (data) {
                    console.log(data)
                    swal({
                        text: "บันทึกข้อมูลเรียบร้อยแล้ว",
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

    //ยกเลิกข้อมูลวัสดุปลูก//
    $(document).on("click", "#btn_remove_material", function (event) {
        var material_id = $(this).attr('data-id')
        var material_status = $(this).attr('data-status')
        var material_name = $(this).attr('data-name')


        if (material_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: "ยกเลิกข้อมูล : " + material_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/material/remove_material.php",
                            method: "POST",
                            data: {
                                material_id: material_id,
                                material_status: material_status
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
                text: " ยกเลิกการระงับข้อมูล : " + material_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/material/remove_material.php",
                            method: "POST",
                            data: {
                                material_id: material_id,
                                material_status: material_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกการระงับข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        }

    });

    //-- รีเซ็ตค่า --//
    $(document).on("click", "#edit_material", function (event) {

        var id = $(this).attr('material');

        $("#edit_material_form" + id)[0].reset();


    });

    //--- เช็คชื่อข้อมูลวัสดุปลูก ปุ่มแก้ไขข้อมูลวัสดุปลูก ---//
    $(".edit_material_amount").keyup("change", function (event) {
        var id = $(this).attr('data-id');
        var edit_material_amount = $(this).val()
        var edit_material_name = $("#edit_material_name" + id).val();
        var edit_type_material_name = $("#edit_type_material_name" + id).val();
        var edit_material_unit = $("#edit_unit_name" + id).val();

        $.ajax({
            url: "./pages/material/check_edit_material.php",
            method: "POST",
            data: {
                id: id,
                edit_material_unit: edit_material_unit,
                edit_type_material_name: edit_type_material_name,
                edit_material_name: edit_material_name,
                edit_material_amount: edit_material_amount

            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "วัสดุปลูกนี้มี ปริมาตร/หน่วย นี้อยู่แล้วกรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด"
                    });
                    $("#edit_material_amount" + id).val("");
                    $(this).focus();
                }
            }
        });

    });

    $(".edit_type_material_name").on("change", function () {
        var id = $(this).attr('data-id');
        var idtype = $("#edit_type_material_name" + id).val();
        
        $(".edit_unit_name option[value='0']").prop('selected', true);
        $("#edit_material_name" + id).val("")
        $("#edit_material_amount" + id).val("")
        $("#edit_material_price" + id).val("")

   

    });

    $(".edit_unit_name").on("change", function () {
        var id = $(this).attr('data-id');
        var id_unit = $(this).val();


        $("#edit_material_amount" + id).val("")
 

   

    });



    //แก้ไขข้อมูลวัสดุปลูก//
    $(document).on("click", "#btn_save_edit_material", function (event) {

        var id = $(this).attr('data-id');
        var edit_type_material_name = $("#edit_type_material_name" + id).val();
        var edit_unit_name = $("#edit_unit_name" + id).val();
        var edit_material_name = $("#edit_material_name" + id).val();
        var edit_material_price = $("#edit_material_price" + id).val();
        var edit_material_amount = $("#edit_material_amount" + id).val();

        if (edit_type_material_name == "0") {    //ดักข้อมูล ค่าว่าง//

            swal({
                text: "กรุณาเลือกประเภทวัสดุปลูก",
                icon: "warning",
                button: "ปิด"

            });
        } else if (edit_unit_name == "0") {

            swal({
                text: "กรุณาเลือกหน่วย",
                icon: "warning",
                button: "ปิด"

            });


        } else if (edit_material_name == "") {

            swal({
                text: "กรุณากรอกชื่อวัสดุปลูก",
                icon: "warning",
                button: "ปิด"

            });


        } else if (edit_material_price == "") {

            swal({
                text: "กรุณากรอกราคาวัสดุปลูก",
                icon: "warning",
                button: "ปิด"
            });
        } else if (edit_material_amount == "") {

            swal({
                text: "กรุณากรอกจำนวน",
                icon: "warning",
                button: "ปิด"
            });
        } else {

            $.ajax({
                url: "./pages/material/edit_material.php",
                method: "POST",
                data: {
                    id: id,
                    edit_type_material_name: edit_type_material_name,
                    edit_unit_name: edit_unit_name,
                    edit_material_name: edit_material_name,
                    edit_material_price: edit_material_price,
                    edit_material_amount: edit_material_amount
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


    $(".insert_material_amount").keyup(function () {
        var id = $(this).val()
        if (!id.match(/^([0-9 .])+$/i)) {
            swal({
                text: "กรุณากรอก ปริมาตร/หน่วย เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();

            return false;


        }

    });

    $(".materialprice").keyup(function () {
        var id = $(this).val()
        if (!id.match(/^([0-9 .])+$/i)) {
            swal({
                text: "กรุณากรอก ราคา/หน่วย เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();

            return false;


        }

    });

    $(document).on("change", "#insert_material_amount", function (event) {

        var insert_material_name = $("#insert_material_name").val();
        var insert_type_material_name = $("#insert_type_material_name").val();
        var insert_unit_name = $("#insert_unit_name").val();
        var material_amount = $(this).val()
        var material_price = $("#insert_material_price").val()
        material_prices = parseInt(material_price)
        console.log(insert_material_name)
        console.log(insert_type_material_name)
        console.log(insert_unit_name)
        console.log(material_amount)

        if (material_amount == 0) {
            swal({
                text: "กรุณากรอก ปริมาตร/หน่วย ให้มากกว่า 0 ",
                icon: "warning",
                button: "ปิด"
            });
            $("#insert_material_amount").val("")
        }
        else {
            if (material_price == "") {
                $("#insert_material_cost").val(0)
                material_amounts = material_amount * 1000

                $("#insert_material_amount_gram").val(material_amounts)
            }
            $.ajax({
                url: "./pages/material/check_insert_material.php",
                method: "POST",
                data: {

                    insert_material_name: insert_material_name,
                    insert_type_material_name: insert_type_material_name,
                    insert_unit_name: insert_unit_name,
                    insert_material_amount: material_amount

                },
                success: function (data) {
                    console.log(data)
                    if (data == 1) {
                        swal({
                            text: "วัสดุปลูกนี้มี ปริมาตร/หน่วย นี้อยู่แล้วกรุณากรอกใหม่",
                            icon: "warning",
                            button: "ปิด"
                        });
                        $("#insert_material_amount").val("");
                        $("#insert_material_amount_gram").val("");
                        $("#insert_material_cost").val(0)
                        $(this).focus();
                    }
                }
            });

            material_amounts = material_amount * 1000

            $("#insert_material_amount_gram").val(material_amounts)

            sum_cost = material_prices / material_amounts
            $("#insert_material_cost").val(sum_cost.toFixed(4))



        }

    });

    $(document).on("change", "#insert_material_price", function (event) {

        var material_amount = $("#insert_material_amount").val()
        var material_price = $(this).val()
        material_prices = parseInt(material_price)

        if (material_price == 0) {
            swal({
                text: "กรุณากรอก ราคา/หน่วย ให้มากกว่า 0 ",
                icon: "warning",
                button: "ปิด"
            });
            $("#insert_material_price").val("")
        }
        else if (material_amount == "") {
            $("#insert_material_cost").val(0)
            /*         material_amounts = material_amount * 1000
        
                    $("#insert_material_amount_gram").val(material_amounts) */
        }
        else {
            material_amounts = material_amount * 1000

            $("#insert_material_amount_gram").val(material_amounts)

            sum_cost = material_prices / material_amounts
            $("#insert_material_cost").val(sum_cost.toFixed(4))
        }

    });

    $(".edit_material_name").keyup("change", function (event) {
        var id = $(this).val()

        ids = id.replace(/ /g, "");
        $(this).val(ids)

        if (!ids.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")

        } else {
            $(this).focus();
        }
    });

    $(".edit_material_amount").keyup("change", function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        if (!elem.match(/^([0-9 .])+$/i)) {
            swal({
                text: "กรุณากรอก ปริมาตร/หน่วย เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;

        } else if (elem == 0) {
            swal({
                text: "กรุณากรอก ปริมาตร/หน่วย ให้มากกว่า 0 ",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("")
        }
    });


    $(".edit_material_price").keyup("change", function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        if (!elem.match(/^([0-9 .])+$/i)) {
            swal({
                text: "กรุณากรอก ราคา/หน่วย เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        } else if (elem == 0) {
            swal({
                text: "กรุณากรอก ราคา/หน่วย ให้มากกว่า 0 ",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("")
        }
    });








});