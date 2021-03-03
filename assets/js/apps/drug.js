$(document).ready(function () {

    //---- ตาราง-----//
    var t = $('#drugTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
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

    //---- ตาราง detail-----//

    var b = $('#detailTable').DataTable({
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

        }
    });
    b.on('order.dt search.dt', function () {
        b.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    $("#drugamount").on("change", function (event) {

        var drug_type = $("#typedrug").val();
        var drug_group = $("#drugunit").val();
        var drug_name = $("#drugname").val();
        var unit = $("#unit").val();
        var drugamount = $("#drugamount").val();

        console.log(drug_type)
        console.log(drug_group)
        console.log(drug_name)
        console.log(unit)
        console.log(drugamount)


        drugamount = drugamount.replace(/^\s+|\s+$/gm, '');
        $(this).val(drugamount)

        $.ajax({
            url: "./pages/drug/check_insert_drug.php",
            method: "POST",
            data: {
                drug_name: drug_name,
                drug_type: drug_type,
                drug_group: drug_group,
                unit: unit,
                drugamount: drugamount



            },
            success: function (data) {
                console.log(data)
                if (data == 0) {
                    swal({
                        text: "ยานี้มี ปริมาตร/หน่วย นี้อยู่แล้วกรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด"
                    });
                    $("#drugamount").val("");
                    $(this).focus();
                }
            }
        });

    });

    $("#unit").on("change", function (event) {

        var drug_type = $("#typedrug").val();
        var drug_group = $("#drugunit").val();
        var drug_name = $("#drugname").val();
        var unit = $("#unit").val();
        var drugamount = $("#drugamount").val();

        console.log(drug_type)
        console.log(drug_group)
        console.log(drug_name)
        console.log(unit)
        console.log(drugamount)


        drugamount = drugamount.replace(/^\s+|\s+$/gm, '');
        $("#drugamount").val(drugamount)

        $.ajax({
            url: "./pages/drug/check_insert_drug.php",
            method: "POST",
            data: {
                drug_name: drug_name,
                drug_type: drug_type,
                drug_group: drug_group,
                unit: unit,
                drugamount: drugamount



            },
            success: function (data) {
                console.log(data)
                if (data == 0) {
                    swal({
                        text: "ยานี้มี ปริมาตร/หน่วย นี้อยู่แล้วกรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด"
                    });
                    $("#drugamount").val("");
                    $(this).focus();
                }
            }
        });

    });

    $("#drugname").on("change", function (event) {

        var drug_type = $("#typedrug").val();
        var drug_group = $("#drugunit").val();
        var drug_name = $("#drugname").val();
        var unit = $("#unit").val();
        var drugamount = $("#drugamount").val();

        console.log(drug_type)
        console.log(drug_group)
        console.log(drug_name)
        console.log(unit)
        console.log(drugamount)


        drugamount = drugamount.replace(/^\s+|\s+$/gm, '');
        $("#drugamount").val(drugamount)

        $.ajax({
            url: "./pages/drug/check_insert_drug.php",
            method: "POST",
            data: {
                drug_name: drug_name,
                drug_type: drug_type,
                drug_group: drug_group,
                unit: unit,
                drugamount: drugamount



            },
            success: function (data) {
                console.log(data)
                if (data == 0) {
                    swal({
                        text: "ยานี้มี ปริมาตร/หน่วย นี้อยู่แล้วกรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด"
                    });
                    $("#drugamount").val("");

                    $(this).focus();
                }
            }
        });

    });

    $("#drugunit").on("change", function (event) {

        var drug_type = $("#typedrug").val();
        var drug_group = $("#drugunit").val();
        var drug_name = $("#drugname").val();
        var unit = $("#unit").val();
        var drugamount = $("#drugamount").val();

        console.log(drug_type)
        console.log(drug_group)
        console.log(drug_name)
        console.log(unit)
        console.log(drugamount)


        drugamount = drugamount.replace(/^\s+|\s+$/gm, '');
        $("#drugamount").val(drugamount)

        $.ajax({
            url: "./pages/drug/check_insert_drug.php",
            method: "POST",
            data: {
                drug_name: drug_name,
                drug_type: drug_type,
                drug_group: drug_group,
                unit: unit,
                drugamount: drugamount



            },
            success: function (data) {
                console.log(data)
                if (data == 0) {
                    swal({
                        text: "ยานี้มี ปริมาตร/หน่วย นี้อยู่แล้วกรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด"
                    });
                    $("#drugamount").val("");

                    $(this).focus();
                }
            }
        });

    });


    //--- ตรวจสอบ insert drug --- //

    /*  $(".drugamount").on("change", function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
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
     }); */

    /*   $(".drugprice").on("change", function () { //เช็คราคาเป็นตัวเลขเท่านั้น
          var elem = $(this).val();
          if (!elem.match(/^([0-9 / .])+$/i)) {
              swal({
                  text: "กรุณากรอกราคาเป็นตัวเลข",
                  icon: "warning",
                  button: false
              });
              $(this).val("");
              $(this).focus();
              return false;
          }
      }); */

    /* $("#show_amount_unit").text("")
    $("#unit").on("change" , function(event){
        var id = $(this).val()

        $.ajax({
            url: "./pages/drug/get_smunit.php",
            method: "POST",
            data: {
                id: id

            },
            success: function (data) {
                
                $("#show_amount_unit").text(data)
            }
        });

    }); */



    // ----- insert drug ----  //
    $(".insert").on("submit", function (event) {
        event.preventDefault();
        var druggroup = $("#drugunit").val()
        var typedrug = $("#typedrug").val()
        var drugunit = $("#drugunit").val()
        var drugname = $("#drugname").val()
        var unit = $("#unit").val()
        var drugamount = $("#drugamount").val()
        var drug_price = $("#drug_price").val()
        var drugdetail = $("#drugdetail").val()


        if (typedrug == "0") {

            swal({
                text: "กรุณาเลือกประเภทยา",
                icon: "warning",
                button: "ปิด"
            });

        } else if (drugunit == "0") {

            swal({
                text: "กรุณาเลือกกลุ่มยา",
                icon: "warning",
                button: "ปิด"
            });

        } else if (drugname == "") {

            swal({
                text: "กรุณากรอกชื่อยา",
                icon: "warning",
                button: "ปิด"
            });
        } else if (unit == "0") {

            swal({
                text: "กรุณาเลือกหน่วย",
                icon: "warning",
                button: "ปิด"
            });

        } else if (drugamount == "") {

            swal({
                text: "กรุณากรอกปริมาตร/หน่วย",
                icon: "warning",
                button: "ปิด"
            });

        } else if (drug_price == "") {

            swal({
                text: "กรุณากรอกราคา/หน่วย",
                icon: "warning",
                button: "ปิด"
            });

      /*   } else if (add_picture_img == "") {

            swal({
                text: "กรุณาเลือกไฟล์รูปภาพ",
                icon: "warning",
                button: "ปิด"
            }); */

        } else {



            $.ajax({
                url: "insert_drug.php",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (data) {

                    swal({
                        text: "บันทึกเรียบร้อย",
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



    //-- รีเซ็ตค่า --//
    $(document).on("click", ".edit_drug", function (event) {

        var id = $(this).attr('data');

        $("#edit_drugs" + id)[0].reset();


    });

    //--- เช็คชื่อยาซ้ำ ปุ่มเพิ่มยา ---//
    $(".edit_drugname").on("change", function (event) {
        var id = $(this).attr('data-id');
        var drug_name = $(this).val();
        var drug_type = $("#edit_typedrug" + id).val();
        var drug_group = $("#edit_drugunit" + id).val();


        $.ajax({
            url: "./pages/drug/check_insert_drug.php",
            method: "POST",
            data: {
                drug_name: drug_name,
                drug_type: drug_type,
                drug_group: drug_group


            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "ชื่อยามีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: false
                    });
                    $("#edit_drugname" + id).val("");
                    $(this).focus();
                }
            }
        });

    });

    //--- update drug ---// 
    $(".Update").on("submit", function (event) {

        event.preventDefault();

        var id = $(this).attr('data-id');
        var edit_typedrug = $('#edit_typedrug' + id).val();
        var edit_drugunit = $('#edit_drugunit' + id).val();
        var edit_drugname = $('#edit_drugname' + id).val();
        var edit_drugsmunit = $('#edit_drugsmunit' + id).val();
        var edit_drugamount = $('#edit_drugamount' + id).val();
        var edit_drugprice = $('#edit_drugprice' + id).val();
        var edit_detail = $("#edit_detail" + id).val();

        
        if (edit_typedrug == "0") {

            swal({
                text: "กรุณาเลือกประเภทยา",
                icon: "warning",
                button: "ปิด"
            });

        } else if (edit_drugunit == "0") {

            swal({
                text: "กรุณาเลือกกลุ่มยา",
                icon: "warning",
                button: "ปิด"
            });

        } else if (edit_drugsmunit == "0") {

            swal({
                text: "กรุณาเลือกหน่วย",
                icon: "warning",
                button: "ปิด"
            });
        } else if (edit_drugname == "") {

            swal({
                text: "กรุณากรอกชื่อยา",
                icon: "warning",
                button: "ปิด"
            });
        } else if (edit_drugamount == "") {

            swal({
                text: "กรุณากรอกปริมาตร/หน่วย",
                icon: "warning",
                button: "ปิด"
            });
        } else if (edit_drugprice == "") {

            swal({
                text: "กรุณากรอกราคา/หน่วย",
                icon: "warning",
                button: "ปิด"
            });

        } else if (edit_detail == "") {

            swal({
                text: "กรุณากรอกรายละเอียด",
                icon: "warning",
                button: "ปิด"
            });

        } else {


            $.ajax({
                url: "update_drug.php",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
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

/*     $(document).on("change", ".edit_typedrug", function (event) {

        var id_type = $(this).val();
        var id = $(this).attr("data-id")
        $.ajax({
            type: 'POST',
            url: './pages/drug/get_group.php',
            data: 'type_id=' + id_type,
            success: function (html) {
                $('#edit_drugunit' + id).html(html);
            }
        });

    }); */

 /*    $(document).on("change", ".edit_drugunit", function (event) {

        var id_unit = $(this).val();
        var id = $(this).attr("data-id")
        $.ajax({
            type: 'POST',
            url: './pages/drug/get_smunit.php',
            data: 'unit_id=' + id_unit,
            success: function (html) {
                $('#edit_drugsmunit' + id).val(html);
            }
        });

    });
 */
    //---- Remove drug-----//
    $(document).on("click", "#btn_remove_drug", function (event) {
        var drug_id = $(this).attr('data-id')
        var drug_status = $(this).attr('data-status')
        var name = $(this).attr("data-name")
        if (drug_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลยา : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "pages/drug/remove_drug.php",
                            method: "POST",
                            data: {
                                drug_id: drug_id,
                                drug_status: drug_status
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
                text: " ยกเลิกการระงับข้อมูลยา : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/drug/remove_drug.php",
                            method: "POST",
                            data: {
                                drug_id: drug_id,
                                drug_status: drug_status
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


    $(document).on("change", "#typedrug", function (event) {

        var id_type = $(this).val();

        $.ajax({
            type: 'POST',
            url: './pages/drug/get_group.php',
            data: 'type_id=' + id_type,
            success: function (html) {
                $('#drugunit').html(html);
            }
        });

        /*  $.ajax({
             type: 'POST',
             url: './pages/drug/get_smunit.php',
             data: 'unit_id=' + id_unit,
             success: function (html) {
                
                 $("#show_unit").text(html)
             }
         }); */
    });

    /* $(document).on("change", "#drugunit", function (event) {

        var id_unit = $(this).val();

        $.ajax({
            type: 'POST',
            url: './pages/drug/get_smunit.php',
            data: 'unit_id=' + id_unit,
            success: function (html) {
           
                $("#show_unit").text(html)
            }
        });

    }); */

    $(document).on("change", "#add_detail_typedrug", function (event) {

        var id_type = $(this).val();

        $.ajax({
            type: 'POST',
            url: './pages/drug/get_group.php',
            data: 'type_id=' + id_type,
            success: function (html) {
                $('#add_detail_drugunit').html(html);
            }
        });

    });


    /* $(document).on("change", "#add_detail_drugunit", function (event) {

        var id_unit = $(this).val();

        $.ajax({
            type: 'POST',
            url: './pages/drug/get_smunit.php',
            data: 'unit_id=' + id_unit,
            success: function (html) {
                $('#add_detail_drugsmunit').val(html);
            }
        });

    }); */


    $(document).on("change", "#add_detail_drugunit", function (event) {

        var id_drug = $(this).val();

        $.ajax({
            type: 'POST',
            url: './pages/drug/get_drug.php',
            data: 'drug_id=' + id_drug,
            success: function (html) {
                $('#add_detail_drug').html(html);
            }
        });

    });



    //----- insert drug detail ----//

    $(document).on("click", "#btn_add_drug_detail", function (event) {

        var add_detail_drug = $("#add_detail_drug").val()
        var add_detail_drugamount = $("#add_detail_drugamount").val()
        var id = $('#add_detail_drugid').val()


        if (add_detail_drug == "0" || add_detail_drugamount == "") {

            swal({
                text: "กรุณากรอกข้อมูล",
                icon: "warning",
                button: "ตกลง"
            });

        } else {

            $.ajax({
                url: "./pages/drug/insert_drug_detail.php",
                method: "POST",
                data: {
                    id: id,
                    add_detail_drug: add_detail_drug,
                    add_detail_drugamount: add_detail_drugamount
                },
                success: function (data) {

                    swal({
                        text: "บันทึกเรียบร้อย",
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

    //-- เพิ่มรหัส ยา ใหม่ ให้เป็น EMP63001-1 --//
    $(document).on("change", "#add_detail_drug", function (event) {

        var id = $(this).val()

        $.ajax({
            type: 'POST',
            url: './pages/drug/get_maxid_one.php',
            data: 'id=' + id,
            success: function (data) {
                console.log(data)
                if (data == '') {
                    var char = id.substr(0, 3)
                    var sub_data = id.substr(8, 2)
                    var year = id.substr(3, 2)
                    var type = id.substr(5, 1)
                    var group = id.substr(6, 2)

                    var t_id = id + '-' + '01'
                    $('#add_detail_drugid').val(t_id)
                } else {

                    var num = data.substr(9, 2)

                    sub_data = parseInt(num) + 1
                    console.log(sub_data)
                    var t_id = id + '-' + checknumid2(sub_data)

                    $('#add_detail_drugid').val(t_id)
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

    //---  ตารางย่อยใน detail --//
    $(document).on("click", "#btn_man", function (event) {
        var table = $('#tbl_detail_equ').DataTable();
        table.destroy();
        var id = $(this).attr('data-id')

        console.log(id)
        var a = $('#tbl_detail_equ').DataTable({
            retrieve: true,
            paging: true,

            "responsive": true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 }
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
                url: "./pages/drug/fetch_drug_detail.php",
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
    });

    //---- Remove detail-----//
    $(document).on("click", "#btn_re_equ", function (event) {
        var detailid = $(this).attr('data')
        var detailstatus = $(this).attr('data-status')
        var detailname = $(this).attr("data-name")
        var detailsize = $(this).attr("data-name2")
        if (detailstatus == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลยา : " + detailname + " (" + detailsize + ")",
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/drug/remove_drug_detail.php",
                            method: "POST",
                            data: {
                                detailid: detailid,
                                detailstatus: detailstatus,


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
                text: " ยกเลิกการระงับข้อมูลยา : " + detailname + " (" + detailsize + ")",
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/drug/remove_drug_detail.php",
                            method: "POST",
                            data: {
                                detailid: detailid,
                                detailstatus: detailstatus,


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

    $(document).on("change", ".edit_detail_type", function (event) {

        var id_type = $(this).val();
        var id = $(this).attr("data-id")
        $.ajax({
            type: 'POST',
            url: './pages/drug/get_group.php',
            data: 'type_id=' + id_type,
            success: function (html) {
                $('#edit_detail_group' + id).html(html);
            }
        });

    });

    $(document).on("change", ".edit_detail_group", function (event) {

        var drug_id = $(this).val();
        var id = $(this).attr("data-id")
        $.ajax({
            type: 'POST',
            url: './pages/drug/get_drug.php',
            data: 'drug_id=' + drug_id,
            success: function (html) {
                $('#edit_detail_drug' + id).html(html);
            }
        });

    });

    /*    $(document).on("change", ".edit_detail_group", function (event) {
   
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
   
       }); */

    /* $(document).on("change", "#edit_detail_drug", function (event) {
    
        var id = $(this).val()
    
        $.ajax({
            type: 'POST',
            url: './pages/drug/get_maxid_one.php',
            data: 'id=' + id,
            success: function (data) {
                console.log(data)
                if (data == '') {
                    var char = id.substr(0, 3)
                    var sub_data = id.substr(8, 2)
                    var year = id.substr(3, 2)
                    var type = id.substr(5, 1)
                    var group = id.substr(6, 2)
    
                    var t_id = id + '-' + '01'
                    $('#edit_detail_id').val(t_id)
                } else {
    
                    var num = data.substr(9, 2)
    
                    sub_data = parseInt(num) 
                    console.log(sub_data)
                    var t_id = id + '-' + checknumid(sub_data)
    
                    $('#edit_detail_id').val(t_id)
                }
    
            }
        });
    
    })
    
    // เพิ่่ม รหัสยา ให้เป็น - 01 //
    function checknumid(i) {
        if (i < 10) {
            i = "0" + i
        } else {
            i = i
        }
        return i
    } */

    //-- edit detail --//
    $(document).on("click", "#btn_detail_drug", function (event) {

        var id = $(this).attr('drug_id');
        var edit_detail_drug = $('#edit_detail_drug' + id).val();
        var edit_detail_amount = $('#edit_detail_amount' + id).val();
        var edit_detail_size = $('#edit_detail_size' + id).val();

        if (edit_detail_amount == '') {
            swal({
                text: "กรุณากรอกข้อมูล",
                icon: "warning",
                button: false
            })
        } else {

            $.ajax({
                url: "./pages/drug/update_drug_detail.php",
                method: "POST",
                data: {
                    id: id,
                    edit_detail_drug: edit_detail_drug,
                    edit_detail_amount: edit_detail_amount,
                    edit_detail_size: edit_detail_size

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
});

$(".edit_drugamount").on("change", function (event) {

    var id = $(this).attr("data-id");
    var drug_type = $("#edit_typedrug"+ id).val();
    var drug_group = $("#edit_drugunit"+ id).val();
    var drug_name = $("#edit_drugname"+ id).val();
    var unit = $("#edit_drugsmunit"+ id).val();
    var drugamount = $("#edit_drugamount"+ id).val();

    console.log(drug_type)
    console.log(drug_group)
    console.log(drug_name)
    console.log(unit)
    console.log(drugamount)


    drugamount = drugamount.replace(/^\s+|\s+$/gm, '');
    $("#edit_drugamount"+ id).val(drugamount)

    $.ajax({
        url: "./pages/drug/check_edit_drug.php",
        method: "POST",
        data: {
            id : id ,
            drug_name: drug_name,
            drug_type: drug_type,
            drug_group: drug_group,
            unit: unit,
            drugamount: drugamount
        },
        success: function (data) {
            console.log(data)
            if (data == 0) {
                swal({
                    text: "ยานี้มี ปริมาตร/หน่วย นี้อยู่แล้วกรุณากรอกใหม่",
                    icon: "warning",
                    button: "ปิด"
                });
                $("#edit_drugamount"+ id).val("");
                $(this).focus();
            }
        }
    });

});

$(".edit_drugunit").on("change", function (event) {

    var id = $(this).attr("data-id");
    var drug_type = $("#edit_typedrug"+ id).val();
    var drug_group = $("#edit_drugunit"+ id).val();
    var drug_name = $("#edit_drugname"+ id).val();
    var unit = $("#edit_drugsmunit"+ id).val();
    var drugamount = $("#edit_drugamount"+ id).val();

    console.log(drug_type)
    console.log(drug_group)
    console.log(drug_name)
    console.log(unit)
    console.log(drugamount)


    drugamount = drugamount.replace(/^\s+|\s+$/gm, '');
    $("#edit_drugamount"+ id).val(drugamount)

    $.ajax({
        url: "./pages/drug/check_edit_drug.php",
        method: "POST",
        data: {
            id : id ,
            drug_name: drug_name,
            drug_type: drug_type,
            drug_group: drug_group,
            unit: unit,
            drugamount: drugamount
        },
        success: function (data) {
            console.log(data)
            if (data == 0) {
                swal({
                    text: "ยานี้มี ปริมาตร/หน่วย นี้อยู่แล้วกรุณากรอกใหม่",
                    icon: "warning",
                    button: "ปิด"
                });
                $("#edit_drugamount"+ id).val("");
                $(this).focus();
            }
        }
    });

});
$(".edit_drugname").on("change", function (event) {

    var id = $(this).attr("data-id");
    var drug_type = $("#edit_typedrug"+ id).val();
    var drug_group = $("#edit_drugunit"+ id).val();
    var drug_name = $("#edit_drugname"+ id).val();
    var unit = $("#edit_drugsmunit"+ id).val();
    var drugamount = $("#edit_drugamount"+ id).val();

    console.log(drug_type)
    console.log(drug_group)
    console.log(drug_name)
    console.log(unit)
    console.log(drugamount)


    drugamount = drugamount.replace(/^\s+|\s+$/gm, '');
    $("#edit_drugamount"+ id).val(drugamount)

    $.ajax({
        url: "./pages/drug/check_edit_drug.php",
        method: "POST",
        data: {
            id : id ,
            drug_name: drug_name,
            drug_type: drug_type,
            drug_group: drug_group,
            unit: unit,
            drugamount: drugamount
        },
        success: function (data) {
            console.log(data)
            if (data == 0) {
                swal({
                    text: "ยานี้มี ปริมาตร/หน่วย นี้อยู่แล้วกรุณากรอกใหม่",
                    icon: "warning",
                    button: "ปิด"
                });
                $("#edit_drugamount"+ id).val("");
                $(this).focus();
            }
        }
    });

});

$(".edit_drugsmunit").on("change", function (event) {

    var id = $(this).attr("data-id");
    var drug_type = $("#edit_typedrug"+ id).val();
    var drug_group = $("#edit_drugunit"+ id).val();
    var drug_name = $("#edit_drugname"+ id).val();
    var unit = $("#edit_drugsmunit"+ id).val();
    var drugamount = $("#edit_drugamount"+ id).val();

    console.log(drug_type)
    console.log(drug_group)
    console.log(drug_name)
    console.log(unit)
    console.log(drugamount)


    drugamount = drugamount.replace(/^\s+|\s+$/gm, '');
    $("#edit_drugamount"+ id).val(drugamount)

    $.ajax({
        url: "./pages/drug/check_edit_drug.php",
        method: "POST",
        data: {
            id : id ,
            drug_name: drug_name,
            drug_type: drug_type,
            drug_group: drug_group,
            unit: unit,
            drugamount: drugamount
        },
        success: function (data) {
            console.log(data)
            if (data == 0) {
                swal({
                    text: "ยานี้มี ปริมาตร/หน่วย นี้อยู่แล้วกรุณากรอกใหม่",
                    icon: "warning",
                    button: "ปิด"
                });
                $("#edit_drugamount"+ id).val("");
               
            }
        }
    });

});

$("#unit").on("change", function (event) {
    var id = $(this).val()

    $.ajax({
        url: "./pages/drug/get_sm_unit.php",
        method: "POST",
        data: {
            id: id

        },
        success: function (data) {
            console.log(data)
            $("#show_formula_small_unit").text(data)

        }
    });


});


$(".drugamounts").keyup("change", function (event) {

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


$(".edit_drugamount").keyup("change", function (event) {

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

$(".edit_drugprice").keyup("change", function (event) {

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
    } else{
        id = id.replace(/^\s+|\s+$/gm, '');
        $(this).val(id)
    }
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

$(".drugname").on("change", function (event) {

    var id = $(this).val();
    if (!id.match(/^([ก-๐ A-z 0-9])+$/i)) {
        swal({
            text: "กรุณากรอกชื่อยาเป็นตัวอักษร",
            icon: "warning",
            button: "ปิด"
        });
        $(this).val("");
        $(this).focus();
        return false;
    } else{
        id = id.replace(/^\s+|\s+$/gm, '');
        $(this).val(id)
    }
});

$(".edit_drugname").on("change", function (event) {

    var id = $(this).val();
    if (!id.match(/^([ก-๐ A-z 0-9])+$/i)) {
        swal({
            text: "กรุณากรอกชื่อยาเป็นตัวอักษร",
            icon: "warning",
            button: "ปิด"
        });
        $(this).val("");
        $(this).focus();
        return false;
    } else{
        id = id.replace(/^\s+|\s+$/gm, '');
        $(this).val(id)
    }
});



$(".drug_price").keyup("change", function (event) {

    var price = $(this).val();
    /*   var amount_gram = $("#formula_small_unit").val(); */

    price = price.replace(/^\s+|\s+$/gm, '');
    $(this).val(price)
    if (!price.match(/^([0-9 .])+$/i)) {
        swal({
            text: "กรุณากรอก ราคา/หน่วย เป็นตัวเลข",
            icon: "warning",
            button: "ปิด"
        });
        $(this).val("");
        $(this).focus();
        return false;
    }/*  else {

        cal_price = price / amount_gram

        $("#total_price").val(cal_price.toFixed(3))
    } */
});

$(".views").on("click",function(event){
    var drug_id = $(this).attr("data-id");
    var id = $(this).attr("data");

    $.ajax({
        url: "./pages/drug/get_sm_unit.php",
        method: "POST",
        data: {
            id: id

        },
        success: function (data) {
            console.log(data)
            $("#show_unit"+ drug_id).text(data)

        }
    });

});


// เช็คประเภท file ว่าเป็นไฟล์รูปภาพหรือไม่ 
(function ($) {
    $.fn.checkFileType = function (options) {
        var defaults = {
            allowedExtensions: [],
            success: function () { },
            error: function () { }
        };
        options = $.extend(defaults, options);

        return this.each(function () {

            $(this).on('change', function () {
                var value = $(this).val(),
                    file = value.toLowerCase(),
                    extension = file.substring(file.lastIndexOf('.') + 1);

                if ($.inArray(extension, options.allowedExtensions) == -1) {
                    options.error();
                    $(this).focus();
                } else {
                    options.success();

                }

            });

        });
    };

})(jQuery);
$(function () {
    $('#add_picture').checkFileType({
        allowedExtensions: ['png', 'jpg', 'jpeg', 'gif'],
        success: function () {

        },
        error: function () {
            swal({
                text: "กรุณาเลือกไฟล์รูปภาพ",
                icon: "warning",
                button: "ปิด"
            })
            $('#add_picture').val("");
        }
    });

});



//คลิกรูปภาพแล้ว เลือกรูปได้เลย
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#add_picture_img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
$(function () {
    var fileupload = $("#add_picture");
    var image = $("#add_picture_img");
    image.click(function () {
        fileupload.click();
    });
    fileupload.change(function () {
        var fileName = $(this).val().split('\\')[$(this).val().split('\\').length - 1];
        readURL(this);

    });
});




var id_img
$(document).on("click", ".edit_drug", function (event) {
    id_img = $(this).attr('data')
    console.log(id_img)
    var unit = $("#edit_drugsmunit"+ id_img).val()
    $.ajax({
        url: "./pages/drug/get_sm_unit.php",
        method: "POST",
        data: {
            id: unit

        },
        success: function (data) {
            console.log(data)
            $("#show_edit_formula_small_unit"+ id_img).text(data)

        }
    });
});



$(function () {
    $('.edit_file').checkFileType({
        allowedExtensions: ['png', 'jpg', 'jpeg', 'gif'],
        success: function () {


        },
        error: function () {
            swal({
                text: "กรุณาเลือกไฟล์รูปภาพ (png, jpg, jpeg)",
                icon: "warning",
                button: "ปิด"
            })
            $('.edit_file').val("");
        }
    });
});


function readURL2(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#edit_picture' + id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }

}


$(document).on("click", ".edit_picture", function (event) {

    $("#picture" + id_img).click();
    $('#picture' + id_img).change(function () {
        /*     var fileName = $(this).val().split('\')[$(this).val().split('\').length - 1]; */
        readURL2(this, id_img);

    });
});