$(document).ready(function () {

    //---- ตาราง-----//
    var t = $('#permissionsTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            {
                targets: 4,
                render: function (data, type, row) {
                    var color = 'black';
                    if (data == "ระงับ") {
                        color = 'red';

                    } else {
                        color = "green"
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
    t.on('order.dt search.dt', function () {
        t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    //---- เพิ่มสิทธิ์ -----//
    $(document).on("click", "#btn_save", function (event) {
        var userlevel = $('#type').val();
        var emp_id = $('#employee').val();

        if (userlevel == 0 || emp_id == 0) {
            swal({
                text: "กรุณาเลือกข้อมูลให้ครบ",
                icon: "warning",
                button: false
            })
        } else /{

            $.ajax({
                url: "./pages/permissions/insert_permission.php",
                method: "POST",
                data: {
                    emp_id: emp_id,
                    userlevel: userlevel
                },
                success: function (data) {
                    swal({
                        text: "เพิ่มข้อมูลเรียบร้อย",
                        icon: "success",
                        button: false
                    })
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            });
        }
    });

    //---- resetpassword emp-----//
    $(document).on("click", "#btn_reset_password", function (event) {
        var empid = $(this).attr('data-id')
        var cardid = $(this).attr('data')
        var status = $(this).attr('data-status')
        var name = $(this).attr("data-name")
        if (status == 'ใช้งาน') {
            swal({
                title: "แจ้งเตือน",
                text: " รีเซ็ตรหัสผ่าน : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/permissions/reset_password.php",
                            method: "POST",
                            data: {
                                empid: empid,
                                status: status,
                                cardid: cardid
                            },
                            success: function (data) {
                                swal({

                                    text: "รีเซ็ตข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);

                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        } else {

        }

    });

    //---- Remove emp-----//
    $(document).on("click", "#btn_remove_permission", function (event) {
        var empid = $(this).attr('data-id')
        var status = $(this).attr('data-status')
        var name = $(this).attr("data-name")
        if (status == 'ใช้งาน') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกสิทธิ์ของ : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/permissions/remove_permission.php",
                            method: "POST",
                            data: {
                                empid: empid,
                                status: status
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
                text: " ยกเลิกการระงับสิทธิ์ของ : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/permissions/remove_permission.php",
                            method: "POST",
                            data: {
                                empid: empid,
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
                                }, 2000);
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        }

    });



    //---ปุ่มแก้ไข ตำแหน่ง ---//

    $(document).on("click", "#btn_edit_permission", function (event) {

        var id = $(this).attr('re_username');
        var userlevel = $('#select_level' + id).val();

        if (userlevel == 0) {
            swal({
                text: "กรุณาเลือกข้อมูล",
                icon: "warning",
                button: false
            })

        } else {
            $.ajax({
                url: "./pages/permissions/edit_permission.php",
                method: "POST",
                data: {
                    empid: id,
                    userlevel: userlevel
                },
                success: function (data) {

                    swal({
                        text: "แก้ไขข้อมูลเรียบร้อย",
                        icon: "success",
                        button: false
                    })
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            });

        }

    });
});
