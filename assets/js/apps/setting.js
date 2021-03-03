$(document).ready(function () {

    //------ tab1------- //
    //---- ตาราง-----//
    var type = $('#drugtypeTable').DataTable({
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
    type.on('order.dt search.dt', function () {
        type.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // ---- check error insert ----//

    //---เช็คชิ้อประเภทซ้ำ --//
    $("#drug_typename").on("change", function () {
        var id = $("#drug_typeid").val();
        var type = $("#drug_typename").val();
        
        type = type.replace(/ /g, '');
        $("#drug_typename").val(type)

        $.ajax({
            url: "./pages/setting/check_add_drugtype.php",
            method: "POST",
            data: {
                id : id,
                type: type
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "ประเภทยานี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#drug_typename").val("")
                 /*    $("#drug_typeunit option[value='0']").prop('selected', true); */
                }
            }
        });
    });


    //---- บันทึกข้อมูล ประเภทยา ----//
    $(document).on("click", "#btn_drugtype_save", function (event) {

        var drug_typeid = $('#drug_typeid').val();
        var drug_typename = $('#drug_typename').val();
     /*    var drug_typeunit = $('#drug_typeunit').val(); */
        var drug_sm_unit = $("#drug_sm_unit").val();

        if (drug_typename == '') {
            swal({
                text: "กรุณากรอกชื่อประเภทยา",
                icon: "warning",
                button: "ปิด",
            })

      /*   } else if (drug_typeunit == 0) {
            swal({
                text: "กรุณาเลือกประเภทหน่วย",
                icon: "warning",
                button: "ปิด",
            }) */
        } else if (drug_sm_unit == 0) {
            swal({
                text: "กรุณาเลือกหน่วย",
                icon: "warning",
                button: "ปิด",
            })
        } else {
            $.ajax({
                url: "./pages/setting/insert_drugtype.php",
                method: "POST",
                data: {
                    drug_typeid: drug_typeid,
                    drug_typename: drug_typename,
                /*     drug_typeunit: drug_typeunit, */
                    drug_sm_unit: drug_sm_unit

                },
                success: function (data) {
                    console.log(data)
                    swal({
                        text: "เพิ่มข้อมูลประเภทยาเรียบร้อย",
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
    $(document).on("click", "#edit_drugtype", function (event) {

        var id = $(this).attr('data-id');

        $("#myedit_drugtype" + id)[0].reset();


    });

    // ---- check error update ----//

    //---เช็คชิ้อประเภทซ้ำ --//
    $(".edit_drug_typename").on("change", function () {

        var id = $(this).attr('data-id');
       /*  var typeunit = $("#edit_drug_typeunit" + id).val(); */

        var type = $("#edit_drug_typename" + id).val();

        type = type.replace(/ /g, '');
        $("#edit_drug_typename" + id).val(type)

        $.ajax({
            url: "./pages/setting/check_add_drugtype.php",
            method: "POST",
            data: {
                id: id,
                type: type
            /*     typeunit: typeunit */
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "ประเภทยานี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#edit_drug_typename" + id).val("")
                   /*  $(".edit_drug_typeunit option[value='0']").prop('selected', true); */
                }
            }
        });
    });

    //---- แก้ไขข้อมูล ประเภทยา ----//
    $(document).on("click", "#btn_edit_drugtype_save", function (event) {
        var id = $(this).attr('re_drug_typeid');
        var edit_drug_typename = $('#edit_drug_typename' + id).val();
      /*   var edit_drug_typeunit = $('#edit_drug_typeunit' + id).val(); */

        if (edit_drug_typename == '') {
            swal({
                text: "กรุณากรอกชื่อประเภทยา",
                icon: "warning",
                button: "ปิด",
            })

     /*    } else if (edit_drug_typeunit == 0) {
            swal({
                text: "กรุณาเลือกหน่วย",
                icon: "warning",
                button: "ปิด",
            }) */
        } else {
            $.ajax({
                url: "./pages/setting/edit_drugtype.php",
                method: "POST",
                data: {
                    edit_drug_typeid: id,
                    edit_drug_typename: edit_drug_typename
                   /*  edit_drug_typeunit: edit_drug_typeunit */
                },
                success: function (data) {

                    swal({
                        text: "แก้ไขข้อมูลประเภทยาเรียบร้อย",
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


    //---- ยกเลิกข้อมูล ประเภทยา-----//
    $(document).on("click", "#btn_remove_drugtype", function (event) {
        var drug_typeid = $(this).attr('data-id')
        var drug_typestatus = $(this).attr('data-status')
        var name = $(this).attr("data-name")
        if (drug_typestatus == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลประเภทยา : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/setting/remove_drugtype.php",
                            method: "POST",
                            data: {
                                drug_typeid: drug_typeid,
                                drug_typestatus: drug_typestatus
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
                text: " ยกเลิกการระงับข้อมูลประเภทยา : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/setting/remove_drugtype.php",
                            method: "POST",
                            data: {
                                drug_typeid: drug_typeid,
                                drug_typestatus: drug_typestatus
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
    //------ end tab1------- //

    //------  tab2------- //
    //---- ตาราง-----//
    var group = $('#drugkindTable').DataTable({
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
    group.on('order.dt search.dt', function () {
        group.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    // ---- check error insert ----//

    //---เช็คชื่อกลุ่มยาซ้ำ --//
    $("#group_drugname").on("change", function () {
        var id = $("#group_drugid").val()
        var typename = $("#add_drug_typeid").val();
        var group_drugname = $(this).val();

        group_drugname = group_drugname.replace(/ /g, '');
        $("#group_drugname").val(group_drugname)

        $.ajax({
            url: "./pages/setting/check_add_groupdrug.php",
            method: "POST",
            data: {
                id: id,
                typename: typename,
                group_drugname: group_drugname
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "กลุ่มยานี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#group_drugname").val("")
                    $("#add_drug_typeid option[value='0']").prop('selected', true);
                }
            }
        });
    });

    $("#add_drug_typeid").on("change", function () {
        var id = $("#group_drugid").val()
        var group_drugname = $("#group_drugname").val();
        var typename = $(this).val();

        $.ajax({
            url: "./pages/setting/check_add_groupdrug.php",
            method: "POST",
            data: {
                id: id,
                typename: typename,
                group_drugname: group_drugname
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "กลุ่มยานี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#group_drugname").val("")
                    $("#add_drug_typeid option[value='0']").prop('selected', true);
                }
            }
        });
    });


    //---- insert group ----//
    $(document).on("click", "#btn_group_save", function (event) {

        var add_drug_typeid = $('#add_drug_typeid').val();
        var group_drugname = $('#group_drugname').val();
      /*   var add_drug_suunit = $('#add_drug_suunit').val(); */

        if (add_drug_typeid == '0') {
            swal({
                text: "กรุณาเลือกประเภทยา",
                icon: "warning",
                button: "ปิด",
            })
        } else if (group_drugname == '') {
            swal({
                text: "กรุณากรอกชื่อกลุ่มยา",
                icon: "warning",
                button: "ปิด",
            })
      /*   } else if (add_drug_suunit == '0') {
            swal({
                text: "กรุณาเลือกหน่วย",
                icon: "warning",
                button: "ปิด",
            })
 */
        } else {
            $.ajax({
                url: "./pages/setting/insert_groupdrug.php",
                method: "POST",
                data: {
                    add_drug_typeid: add_drug_typeid,
                    group_drugname: group_drugname
                  /*   add_drug_suunit: add_drug_suunit */
                },
                success: function (data) {
                    console.log(data)
                  /*   swal({
                        text: "เพิ่มข้อมูลกลุ่มยาเรียบร้อย",
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


    // ---- check error update ----//

    //-- รีเซ็ตค่า --//
    $(document).on("click", "#edit_groupdrug", function (event) {

        var id = $(this).attr('data-id');

        $("#myedit_groupdrug" + id)[0].reset();


    });


    //---เช็คชื่อกลุ่มยาซ้ำ --//
    $(".edit_group_drugname").on("change", function () {

        var id = $(this).attr('data-id');
        var typename = $("#edit_drug_typeid" + id).val();
        var group_drugname = $("#edit_group_drugname" + id).val();

        group_drugname = group_drugname.replace(/ /g, '');
        $("#edit_group_drugname" + id).val(group_drugname)

        $.ajax({
            url: "./pages/setting/check_add_groupdrug.php",
            method: "POST",
            data: {
                id: id,
                typename: typename,
                group_drugname: group_drugname
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "กลุ่มยานี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#edit_group_drugname" + id).val("")
                   /*  $(".edit_drug_typeid option[value='0']").prop('selected', true); */
                   /*  $(".edit_drug_sunit_id option[value='0']").prop('selected', true); */
                }
            }
        });
    });

    $(".edit_drug_typeid").on("change", function () {

        var id = $(this).attr('data-id');
        var typename = $("#edit_drug_typeid" + id).val();
        var group_drugname = $("#edit_group_drugname" + id).val();

        $.ajax({
            url: "./pages/setting/check_add_groupdrug.php",
            method: "POST",
            data: {
                id: id,
                typename: typename,
                group_drugname: group_drugname
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "กลุ่มยานี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#edit_group_drugname" + id).val("")
                    /* $(".edit_drug_typeid option[value='0']").prop('selected', true); */

                }
            }
        });
    });


    $(document).on("click", "#btn_edit_groupdrug", function (event) {
        var id = $(this).attr('re_groupdrug');
        var edit_drug_typeid = $('#edit_drug_typeid' + id).val();
        var edit_group_drugname = $('#edit_group_drugname' + id).val();
      /*   var edit_drug_sunit_id = $('#edit_drug_sunit_id' + id).val(); */

        if (edit_drug_typeid == '0') {
            swal({
                text: "กรุณาเลือกประเภทยา",
                icon: "warning",
                button: "ปิด",
            })
        } else if (edit_group_drugname == '') {
            swal({
                text: "กรุณากรอกชื่อกลุ่มยา",
                icon: "warning",
                button: "ปิด",
            })
    /*     } else if (edit_drug_sunit_id == '0') {
            swal({
                text: "กรุณาเลือกหน่วย",
                icon: "warning",
                button: "ปิด",
            }) */

        } else {
            $.ajax({
                url: "./pages/setting/edit_groupdrug.php",
                method: "POST",
                data: {
                    edit_group_drug_id: id,
                    edit_drug_typeid: edit_drug_typeid,
                    edit_group_drugname: edit_group_drugname
                  /*   edit_drug_sunit_id: edit_drug_sunit_id */
                },
                success: function (data) {
                    swal({
                        text: "แก้ไขข้อมูลกลุ่มยาเรียบร้อย",
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

    //---- ยกเลิกข้อมูล กลุ่มยา-----//
    $(document).on("click", "#btn_remove_groupdrug", function (event) {
        var group_drug_id = $(this).attr('data-id')
        var group_drug_status = $(this).attr('data-status')
        var name = $(this).attr("data-name")
        if (group_drug_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลกลุ่มยา : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/setting/remove_groupdrug.php",
                            method: "POST",
                            data: {
                                group_drug_id: group_drug_id,
                                group_drug_status: group_drug_status
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
                text: " ยกเลิกการระงับข้อมูลกลุ่มยา : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/setting/remove_groupdrug.php",
                            method: "POST",
                            data: {
                                group_drug_id: group_drug_id,
                                group_drug_status: group_drug_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกการระงับข้อมูลกลุ่มยาเรียบร้อย",
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
    //------ end tab2------- //

    //------  tab3------- //
    //---- ตาราง-----//
    var unit = $('#drugunitTable').DataTable({
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
    unit.on('order.dt search.dt', function () {
        unit.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    //---เช็คชื่อประเภทหน่วยซ้ำ --//
    $("#add_drug_unit_name").on("change", function () {

        var unitname = $(this).val();

        unitname = unitname.replace(/ /g, '');
        $("#add_drug_unit_name").val(unitname)

        $.ajax({
            url: "./pages/setting/check_add_drug_unit.php",
            method: "POST",
            data: {
                unitname: unitname
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "ชื่อประเภทหน่วยนี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#add_drug_unit_name").val("")
                }
            }
        });
    });

    //---- insert unit ----//
    $(document).on("click", "#btn_unit_save", function (event) {

        var add_drug_unit_id = $('#add_drug_unit_id').val();
        var add_drug_unit_name = $('#add_drug_unit_name').val();

        if (add_drug_unit_name == '') {
            swal({
                text: "กรุณากรอกประเภทหน่วย",
                icon: "warning",
                button: "ปิด",
            })
        } else {
            $.ajax({
                url: "./pages/setting/insert_drugunit.php",
                method: "POST",
                data: {
                    add_drug_unit_id: add_drug_unit_id,
                    add_drug_unit_name: add_drug_unit_name
                },
                success: function (data) {

                    swal({
                        text: "เพิ่มข้อมูลประเภทหน่วยเรียบร้อย",
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
    $(document).on("click", "#edit_drugunit", function (event) {

        var id = $(this).attr('data-id');

        $("#myedit_drugunit" + id)[0].reset();


    });

    //---เช็คชื่อหน่วยซ้ำ --//
    $(".edit_drug_unitname").on("change", function () {

        var id = $(this).attr('data-id');
        var unitname = $(this).val();

        unitname = unitname.replace(/ /g, '');
        $("#edit_drug_unitname" + id).val(unitname)

        $.ajax({
            url: "./pages/setting/check_add_drug_unit.php",
            method: "POST",
            data: {
                unitname: unitname
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "ชื่อประเภทหน่วยนี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#edit_drug_unitname" + id).val("")
                }
            }
        });
    });

    // edit unit //
    $(document).on("click", "#btn_edit_drugunit", function (event) {
        var id = $(this).attr('re_drug_unit');
        var edit_drug_unitname = $('#edit_drug_unitname' + id).val();


        if (edit_drug_unitname == '') {
            swal({
                text: "กรุณากรอกชื่อประเภทหน่วย",
                icon: "warning",
                button: "ปิด",
            })
        } else {

            $.ajax({
                url: "./pages/setting/edit_drugunit.php",
                method: "POST",
                data: {
                    edit_drug_unitid: id,
                    edit_drug_unitname: edit_drug_unitname

                },
                success: function (data) {

                    swal({
                        text: "แก้ไขข้อมูลประเภทหน่วยเรียบร้อย",
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

    //---- ยกเลิกข้อมูล ประเภทหน่วย-----//
    $(document).on("click", "#btn_remove_drugunit", function (event) {
        var drug_unit_id = $(this).attr('data-id')
        var drug_unit_status = $(this).attr('data-status')
        var name = $(this).attr("data-name")
        if (drug_unit_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลประเภทหน่วย : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/setting/remove_drugunit.php",
                            method: "POST",
                            data: {
                                drug_unit_id: drug_unit_id,
                                drug_unit_status: drug_unit_status
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
                text: " ยกเลิกการระงับข้อมูลประเภทหน่วย : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/setting/remove_drugunit.php",
                            method: "POST",
                            data: {
                                drug_unit_id: drug_unit_id,
                                drug_unit_status: drug_unit_status
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




    //------ end tab3------- //


    //------  tab4------- //
    //---- ตาราง-----//
    var smunit = $('#smallunitTable').DataTable({
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
    smunit.on('order.dt search.dt', function () {
        smunit.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    //---เช็คชื่อประเภทหน่วยซ้ำ --//
    $("#drug_smunit_name").on("change", function () {

        var smunitname = $(this).val();

        smunitname = smunitname.replace(/ /g, '');
        $("#drug_smunit_name").val(smunitname)

        $.ajax({
            url: "./pages/setting/check_add_drug_smunit.php",
            method: "POST",
            data: {
                smunitname: smunitname
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "ชื่อหน่วยนี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#drug_smunit_name").val("")
                }
            }
        });
    });

    //---- insert unit ----//
    $(document).on("click", "#btn_smunit_save", function (event) {


        var add_drug_unit = $('#add_drug_unit').val();
        var drug_smunit_name = $('#drug_smunit_name').val();

        if (drug_smunit_name == '' || add_drug_unit == '0') {
            swal({
                text: "กรุณากรอกข้อมูล",
                icon: "warning",
                button: "ปิด",
            })
        } else {
            $.ajax({
                url: "./pages/setting/insert_drugsmunit.php",
                method: "POST",
                data: {

                    add_drug_unit: add_drug_unit,
                    drug_smunit_name: drug_smunit_name
                },
                success: function (data) {

                    swal({
                        text: "เพิ่มข้อมูลประเภทหน่วยเรียบร้อย",
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
    $(document).on("click", "#edit_drugsmunit", function (event) {

        var id = $(this).attr('data-id');

        $("#myedit_drugsmunit" + id)[0].reset();


    });


    //---เช็คชื่อประเภทหน่วยซ้ำ --//
    $(".edit_drug_smunit_name").on("change", function () {
        var id = $(this).attr('data-id');
        var smunitname = $(this).val();

        smunitname = smunitname.replace(/ /g, '');
        $("#edit_drug_smunit_name" + id).val(smunitname)

        $.ajax({
            url: "./pages/setting/check_add_drug_smunit.php",
            method: "POST",
            data: {
                smunitname: smunitname
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "ชื่อหน่วยนี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#edit_drug_smunit_name" + id).val("")
                }
            }
        });
    });

    // edit sm unit //
    $(document).on("click", "#btn_edit_drugsmunit_save", function (event) {
        var id = $(this).attr('re_drug_smunit');
        var add_refdrugsmunit = $('#add_refdrugsmunit' + id).val();
        var edit_drug_smunit_name = $('#edit_drug_smunit_name' + id).val();


        if (edit_drug_smunit_name == '') {
            swal({
                text: "กรุณากรอกข้อมูล",
                icon: "warning",
                button: "ปิด",
            })
        } else {

            $.ajax({
                url: "./pages/setting/edit_drugsmunit.php",
                method: "POST",
                data: {
                    edit_drug_smunit_id: id,
                    add_refdrugsmunit: add_refdrugsmunit,
                    edit_drug_smunit_name: edit_drug_smunit_name

                },
                success: function (data) {

                    swal({
                        text: "แก้ไขข้อมูลประเภทหน่วยเรียบร้อย",
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

    //---- ยกเลิกข้อมูล หน่วยย่อย-----//
    $(document).on("click", "#btn_remove_drugsmunit", function (event) {
        var drug_sm_unit_id = $(this).attr('data-id')
        var drug_sm_unit_status = $(this).attr('data-status')
        var name = $(this).attr("data-name")
        if (drug_sm_unit_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลประเภทหน่วย : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/setting/remove_drugsmunit.php",
                            method: "POST",
                            data: {
                                drug_sm_unit_id: drug_sm_unit_id,
                                drug_sm_unit_status: drug_sm_unit_status
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
                text: " ยกเลิกการระงับข้อมูลประเภทหน่วย : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/setting/remove_drugsmunit.php",
                            method: "POST",
                            data: {
                                drug_sm_unit_id: drug_sm_unit_id,
                                drug_sm_unit_status: drug_sm_unit_status
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

    //------ end tab4------- //

    //------  tab5------- //
    //---- ตาราง-----//
    var typeplant = $('#typeplantTable').DataTable({
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
    typeplant.on('order.dt search.dt', function () {
        typeplant.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    //--- เช็คชื่อประเภทพันธุ์ไม้ซ้ำ ปุ่มเพิ่มข้อมูลประเภทพันธุ์ไม้ ---//
    $(".typeplantname").on("change", function (event) {

        var insert_type_plant_name = $("#insert_type_plant_name").val();


        $.ajax({
            url: "./pages/setting/check_insert_typeplant.php",
            method: "POST",
            data: {

                insert_type_plant_name: insert_type_plant_name

            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "ชื่อประเภทพันธุ์ไม้นี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#insert_type_plant_name").val("");
                    $(this).focus();
                }
            }
        });

    });

 


    //insert ข้อมูลประเภทพันธุ์ไม้//
    $(document).on("click", "#btn_save_typeplant", function (event) {

        var insert_type_plant_name = $("#insert_type_plant_name").val(); //ประกาศตัวแปร//
    


        if (insert_type_plant_name == "") {    //ดักข้อมูล ค่าว่าง//

            swal({
                text: "กรุณากรอกชื่อประเภทพันธุ์ไม้",
                icon: "warning",
                button: "ปิด",

            })
   
        } else {
            //ส่งข้อมูลไป insert//
            $.ajax({
                url: "./pages/setting/insert_typeplant.php",
                method: "POST",
                data: {
                    insert_type_plant_name: insert_type_plant_name
              


                },
                success: function (data) {

                    swal({
                        text: "เพิ่มข้อมูลเรียบร้อยแล้ว",
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
    $(document).on("click", "#btn_add_typeplant", function (event) {



        $("#add_typeplant")[0].reset();


    });

    //ยกเลิกข้อมูลประเภทพันธุ์ไม้//
    $(document).on("click", "#btn_remove_typeplant", function (event) {
        var typeplant_id = $(this).attr('data-id')
        var typeplant_status = $(this).attr('data-status')
        var typeplant_name = $(this).attr('data-name')


        if (typeplant_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: "ยกเลิกข้อมูล : " + typeplant_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/setting/remove_typeplant.php",
                            method: "POST",
                            data: {
                                typeplant_id: typeplant_id,
                                typeplant_status: typeplant_status
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
                text: " ยกเลิกการระงับข้อมูล : " + typeplant_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/setting/remove_typeplant.php",
                            method: "POST",
                            data: {
                                typeplant_id: typeplant_id,
                                typeplant_status: typeplant_status
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

    //--- เช็คชื่อประเภทพันธุ์ไม้ ปุ่มแก้ไขประเภทพันธุ์ไม้ ---//
    $(".edittypeplantname").on("change", function (event) {
        var id = $(this).attr('data-id');
        var edit_typeplant_name = $(this).val();


        $.ajax({
            url: "./pages/setting/check_edit_typeplant.php",
            method: "POST",
            data: {
                edit_typeplant_name: edit_typeplant_name



            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "ชื่อประเภทพันธุ์ไม้นี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: false
                    });
                    $("#edit_typeplant_name" + id).val("");
                    $(this).focus();
                }
            }
        });

    });


    $(".editsciname").on("change", function (event) {

        var edit_typeplant_sciencename = $(this).val();

        $.ajax({
            url: "./pages/setting/check_edit_sciname.php",
            method: "POST",
            data: {

                edit_typeplant_sciencename: edit_typeplant_sciencename

            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "ชื่อวิทยาศาสตร์นี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#edit_typeplant_sciencename").val("");
                    $(this).focus();
                }
            }
        });

    });




    //แก้ไขข้อมูลพันธุ์ไม้//
    $(document).on("click", "#btn_save_edit_typeplant", function (event) {

        var id = $(this).attr('data-id');
        var edit_typeplant_name = $("#edit_typeplant_name" + id).val();
        var edit_typeplant_sciencename = $("#edit_typeplant_sciencename" + id).val();


        if (edit_typeplant_name == "") {
            swal({
                text: "กรุณากรอกชื่อประเภทพันธุ์ไม้",
                icon: "warning",
                button: "ปิด",
            });
        } else if (edit_typeplant_sciencename == "") {
            swal({
                text: "กรุณากรอกชื่อวิทยาศาสตร์",
                icon: "warning",
                button: "ปิด",

            });
        } else {

            $.ajax({
                url: "./pages/setting/edit_typeplant.php",
                method: "POST",
                data: {
                    id: id,
                    edit_typeplant_name: edit_typeplant_name,
                    edit_typeplant_sciencename: edit_typeplant_sciencename

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

    //-- รีเซ็ตค่า --//
    $(document).on("click", "#modal_edit_typeplant", function (event) {
        
        var id = $(this).attr('data');
        console.log(id)
        $("#edit_typeplant" + id)[0].reset();


    });
    //------ end tab5------- //



    //------  tab6------- //
    //---- ตาราง-----//
    var typematerial = $('#typematerialTable').DataTable({
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
    typematerial.on('order.dt search.dt', function () {
        typematerial.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    //--- เช็คชื่อประเภทวัสดุปลูกซ้ำ ปุ่มเพิ่มข้อมูลประเภทวัสดุปลูก ---//
    $(document).on("change","#insert_type_material_name", function (event) {
      
        var insert_type_material_name = $("#insert_type_material_name").val();


        $.ajax({
            url: "./pages/setting/check_insert_type_material.php",
            method: "POST",
            data: {

                insert_type_material_name: insert_type_material_name

            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "ชื่อประเภทวัสดุปลูกนี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: false
                    });
                    $("#insert_type_material_name").val("");
                    $(this).focus();
                }
            }
        });

    });



    //insert ข้อมูลประเภทวัสดุปลูก//
    $(document).on("click", "#btn_save_type_material", function (event) {

        var insert_type_material_name = $("#insert_type_material_name").val(); //ประกาศตัวแปร//
        var insert_type_material_smunit = $("#insert_type_material_smunit").val();

        if (insert_type_material_name == "") {    //ดักข้อมูล ค่าว่าง//

            swal({
                text: "กรุณากรอกชื่อประเภทวัสดุปลูก",
                icon: "warning",
                button: false

            })
        } else  if (insert_type_material_smunit == 0) {    //ดักข้อมูล ค่าว่าง//

            swal({
                text: "กรุณาเลือกหน่วย",
                icon: "warning",
                button: false

            })
        } else {
            //ส่งข้อมูลไป insert//
            $.ajax({
                url: "./pages/setting/insert_typematerial.php",
                method: "POST",
                data: {
                    insert_type_material_name: insert_type_material_name,
                    insert_type_material_smunit: insert_type_material_smunit


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

    //-- รีเซ็ตค่า --//
    $(document).on("click", "#btn_add_type_material", function (event) {



        $("#add_type_material")[0].reset();


    });

    //ยกเลิกข้อมูลประเภทวัสดุปลูก//
    $(document).on("click", "#btn_remove_type_material", function (event) {
        var typematerial_id = $(this).attr('data-id')
        var typematerial_status = $(this).attr('data-status')
        var typematerial_name = $(this).attr('data-name')


        if (typematerial_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: "ยกเลิกข้อมูล : " + typematerial_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/setting/remove_typematerial.php",
                            method: "POST",
                            data: {
                                typematerial_id: typematerial_id,
                                typematerial_status: typematerial_status
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
                text: " ยกเลิกการระงับข้อมูล : " + typematerial_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/setting/remove_typematerial.php",
                            method: "POST",
                            data: {
                                typematerial_id: typematerial_id,
                                typematerial_status: typematerial_status
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

    //--- เช็คชื่อประเภทวัสดุปลูก ปุ่มแก้ไขประเภทวัสดุปลูก ---//
    $(".edittypematerialname").on("change", function (event) {
        var id = $(this).attr('data-id');
        var edit_type_material_name = $(this).val();


        $.ajax({
            url: "./pages/setting/check_edit_type_material.php",
            method: "POST",
            data: {
                id : id,
                edit_type_material_name: edit_type_material_name



            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "ชื่อประเภทวัสดุปลูกนี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: false
                    });
                    $("#edit_type_material_name" + id).val("");
                    $(this).focus();
                }
            }
        });

    });



    //แก้ไขข้อมูลวัสดุปลูก//
    $(document).on("click", "#btn_save_edit_material", function (event) {

        var id = $(this).attr('data-id');
        var edit_type_material_name = $("#edit_type_material_name" + id).val();



        if (edit_type_material_name == "") {
            swal({
                text: "กรุณากรอกชื่อประเภทวัสดุปลูก",
                icon: "warning",
                button: false
            });
        } else {

            $.ajax({
                url: "./pages/setting/edit_typematerial.php",
                method: "POST",
                data: {
                    id: id,
                    edit_type_material_name: edit_type_material_name


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

    //-- รีเซ็ตค่า --//
 $(document).on("click", "#edit_typematerial", function (event) {

   

    $("#edit_typematerial" )[0].reset();
   

});


    //------ end tab6------- //

    //----- start tab7 ------//
    var grade = $('#gradeTable').DataTable({
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
    grade.on('order.dt search.dt', function () {
        grade.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $(document).on("change", "#in_grade_name", function (event) {

        var id = $("#in_grade_id").val();
        var name = $(this).val();

        $.ajax({
            url: "./pages/setting/check_add_grade.php",
            method: "POST",
            data: {
                id: id,
                name: name
            },
            success: function (data) {
                if (data == 0) {
                    swal({
                        text: "ชื่อเกรดนี้มีอยู่แล้ว",
                        icon: "warning",
                        button: "ปิด"
                    })
                    $("#in_grade_name").val("")
                }
            }
        });

    });

    $(document).on("change", ".edit_grade_name", function (event) {
        var id = $(this).attr("data-id")
        var name = $(this).val();

        $.ajax({
            url: "./pages/setting/check_add_grade.php",
            method: "POST",
            data: {
                id: id,
                name: name
            },
            success: function (data) {
                if (data == 0) {
                    swal({
                        text: "ชื่อเกรดนี้มีอยู่แล้ว",
                        icon: "warning",
                        button: "ปิด"
                    })
                    $("#edit_grade_name" + id).val("")
                }
            }
        });

    });

    $(document).on("click", "#btn_save_in_grade", function (event) {

        var in_grade_id = $('#in_grade_id').val();
        var in_grade_name = $('#in_grade_name').val();

        if (in_grade_name == "") {
            swal({
                text: "กรุณากรอกชื่อเกรด",
                icon: "warning",
                button: "ปิด",
            })
        } else {
            $.ajax({
                url: "./pages/setting/insert_grade.php",
                method: "POST",
                data: {

                    in_grade_id: in_grade_id,
                    in_grade_name: in_grade_name
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

                }
            });
        }

    });

    $(document).on("click", "#edit_grades", function (event) {

        var id = $(this).attr('data-id');

        $("#edit_gradeForm" + id)[0].reset();

    });

    $(document).on("click", "#btn_save_edit_grade", function (event) {
        var id = $(this).attr("data-id");
        var edit_grade_name = $('#edit_grade_name' + id).val();

        if (edit_grade_name == "") {
            swal({
                text: "กรุณากรอกชื่อเกรด",
                icon: "warning",
                button: "ปิด",
            })
        } else {
            $.ajax({
                url: "./pages/setting/edit_grade.php",
                method: "POST",
                data: {

                    id: id,
                    edit_grade_name: edit_grade_name
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

    $(document).on("click", "#btn_remove_grade", function (event) {
        var grade_id = $(this).attr('data-id')
        var grade_status = $(this).attr('data-status')
        var grade_name = $(this).attr('data-name')

        if (grade_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: "ยกเลิกข้อมูลเกรด : " + grade_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/setting/remove_grade.php",
                            method: "POST",
                            data: {
                                grade_id: grade_id,
                                grade_status: grade_status
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
                text: " ยกเลิกการระงับข้อมูลเกรด : " + grade_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/setting/remove_grade.php",
                            method: "POST",
                            data: {
                                grade_id: grade_id,
                                grade_status: grade_status
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