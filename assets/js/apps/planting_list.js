$(document).ready(function () {

    fetch_table1();

    function fetch_table1() {

        var planting = $('#plantingTable').DataTable({

            "responsive": true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 8,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ระงับ") {
                            color = 'red';
                        } else if (data == "เสร็จสิ้น") {
                            color = 'green';
                        } else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 6,
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
                url: "./pages/planting/fetch_planting.php",
                type: "post",

            }
        })
        planting.on('order.dt search.dt', function () {
            planting.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }


    planting_details();

    function planting_details() {
        var td = $('#plantings_detailTable').DataTable({
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
        td.on('order.dt search.dt', function () {
            td.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }



    function planting_detail(id) {

        //---- ตารางรายการ-----//
        $('#plantings_detailTable').DataTable({
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
                url: "./pages/planting/fetch_add_planting_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }
            }
        });
    }

    $(document).on("click", "#search_modal", function (event) {

        $("#serach_id")[0].reset()
    });

    $(document).on("click", "#btn_search", function (event) {


        var status = $("#search_status").val()
        console.log(status)

        var table = $("#plantingTable").DataTable()
        table.destroy()

        $("#modal_search").modal("toggle")
        var plantings = $('#plantingTable').DataTable({

            "responsive": true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 8,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ระงับ") {
                            color = 'red';
                        } else if (data == "เสร็จสิ้น") {
                            color = 'green';
                        } else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 6,
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
                url: "./pages/planting/fetch_planting_search.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = status
                }
            }
        })
        plantings.on('order.dt search.dt', function () {
            plantings.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });


    //-- รีเซ็ตค่า --//
    $(document).on("click", "#btn_add_modal", function (event) {

        $("#in_planting")[0].reset();
        var table = $('#plantings_detailTable').DataTable();
        table
            .clear()
            .draw();

    });


    $(document).on("change", "#in_planting_ordername", function (event) {
        var id = $(this).val()
        console.log(id)
        if (id == "0") {
            var table = $('#plantings_detailTable').DataTable();
            table
                .clear()
                .draw();
        } else {
            var table = $('#plantings_detailTable').DataTable();
            table.destroy();
            planting_detail(id)
        }
    });

    $(document).on('click', '#select_all', function () {
        if (this.checked) {
            $('.checkbox').each(function () {
                this.checked = true;
            });
        } else {
            $('.checkbox').each(function () {
                this.checked = false;
            });
        }
    });
    $(document).on('click', '.checkbox', function () {
        if ($('.checkbox:checked').length == $('.checkbox').length) {
            $('#select_all').prop('checked', true);
        } else {
            $('#select_all').prop('checked', false);
        }
    });

    $(document).on("click", "#btn_add_planting", function (event) {

        var in_planting_id = $("#in_planting_id").val()
        var ref_order_id = $("#in_planting_ordername").val()

        var check = []
        $('.checkbox:checked').each(function (i) {

            check[i] = $(this).val()
        });
        console.log(check)
        if (ref_order_id == 0) {
            swal({
                text: "กรุณาเลือกรายการสั่งซื้อ",
                icon: "warning",
                button: "ปิด"
            });
        } else if (check == "") {
            swal({
                text: "กรุณาเลือกรายการที่จะปลูก",
                icon: "warning",
                button: "ปิด"
            });
        } else {

            $.ajax({
                method: "POST",
                url: "./pages/planting/insert_planting.php",
                data: {
                    in_planting_id: in_planting_id,
                    ref_order_id: ref_order_id,
                    check: check

                },
                success: function (data) {
                    swal({
                        text: "บันทึกข้อมูลเรียบร้อย",
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

    //---- Remove planting-----//
    $(document).on("click", "#btn_remove_planting", function (event) {
        var planting_id = $(this).attr('data')
        var planting_status = $(this).attr('data-status')
        var order_name = $(this).attr("data-name")
        var order_detail_id = $(this).attr("data-order")
        if (planting_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลรายการ : " + order_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "pages/planting/remove_planting.php",
                            method: "POST",
                            data: {
                                planting_id: planting_id,
                                planting_status: planting_status,
                                order_detail_id: order_detail_id
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    /*  var table = $('#plantingTable').DataTable();
                                     table.destroy();
                                     fetch_table1()
                                     swal.close() */
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
                            url: "pages/planting/remove_planting.php",
                            method: "POST",
                            data: {
                                planting_id: planting_id,
                                planting_status: planting_status,
                                order_detail_id: order_detail_id
                            },
                            success: function (data) {
                                console.log(data)
                                swal({

                                    text: "ยกเลิกการระงับข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    var table = $('#plantingTable').DataTable();
                                    table.destroy();
                                    fetch_table1()
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

    function fetch_modal2(id) {
        var a = $('#planting_detailTable').DataTable({
            retrieve: true,
            paging: true,

            "responsive": true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 10,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "เสร็จสิ้น") {
                            color = "green";
                        } else if (data == "ระงับ") {
                            color = "red";
                        } else if (data == "รอคัดเกรด") {
                            color = "#FF6600";
                        } else {
                            color = "black";
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 9,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "สิ้นสุด") {
                            color = "red";
                        } else {
                            color = "black";
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 7,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "12/12") {
                            color = "green";
                        } else {
                            color = "blue";
                        }
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
                {
                    targets: 3,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'blue';

                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },

                {
                    targets: 4,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'red';

                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },

                {
                    targets: 5,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'green';

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
                url: "./pages/planting/fetch_planting_detail.php",
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
        var table = $('#planting_detailTable').DataTable();
        table.destroy(); //ลบตารางทิ้ง

        var id = $(this).attr('data')
        var order_id = $(this).attr('data-order-id')
        var order_name = $(this).attr('data-order')
        var firstname = $(this).attr('data-name')
        var lastname = $(this).attr('data-lastname')
        $("#plant_id").text(id)
        $("#order_id").text(order_id)
        $("#view_order_name").text(order_name)
        $("#view_customer_name").text(firstname + " " + lastname)

        order_names = order_name
        customer_name = firstname + " " + lastname
        modal_2_dt_id = id;
        fetch_modal2(id) //เรียกใช้ข้อมูลในตาราง



    });
    var customer_name
    var order_names
    var modal_2_dt_id; //ตัวแปรสาธรณะ
    //---- Remove planting-----//
    $(document).on("click", "#btn_remove_planting_detail", function (event) {
        var planting_detail_id = $(this).attr('data')
        var planting_detail_status = $(this).attr('data-status')
        var plant_name = $(this).attr("data-name")

        if (planting_detail_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลรายการ : " + plant_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/planting/remove_planting_detail.php",
                            method: "POST",
                            data: {
                                planting_detail_id: planting_detail_id,
                                planting_detail_status: planting_detail_status,

                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    swal.close() // ปิดแจ้งเตือนเอง
                                }, 1500);
                                var table = $('#planting_detailTable').DataTable();
                                table.destroy();
                                fetch_modal2(modal_2_dt_id)
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
                            url: "./pages/planting/remove_planting_detail.php",
                            method: "POST",
                            data: {
                                planting_detail_id: planting_detail_id,
                                planting_detail_status: planting_detail_status,

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
                                var table = $('#planting_detailTable').DataTable();
                                table.destroy();
                                fetch_modal2(modal_2_dt_id)

                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        }

    });

    function fetch_planting_detail(id) {

        var a = $('#planting_listTable').DataTable({


            "pageLength": 5,
            "responsive": true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 5,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "เสร็จสิ้น") {
                            color = "green";
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
                    targets: 2,
                    className: 'dt-body-right'
                },




            ],

            "language": {
                "search": "ค้นหา:",

                "lengthMenu": "",
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
                url: "./pages/planting/fetch_planting_list.php",
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
    $(document).on("click", "#btn_view_planting_list", function (event) {
        var table = $('#planting_listTable').DataTable();
        table.destroy();
        var id = $(this).attr('data')
        var name = $(this).attr('data-name')

        $("#week_order_id").text(id)
        $("#week_plant_name").text(name)

        $("#view_order_name2").text(id)
        $("#view_customer_name2").text(customer_name)

        dt_id = id;
        plant_name = name;

        $(".edit2_planting_week_name_plant").val(name)

        console.log(id)

        $("#in_planting_week_id").val(id)

        $(".edit2_planting_week_id").val(id)

        fetch_planting_detail(id)


        $.ajax({
            url: "pages/planting/cal_week.php",
            method: "POST",
            data: {
                id: id

            },
            success: function (data) {
                if (data == 1) {

                    $("#modal_detail").attr("disabled", false);
                    $("#modal_detail2").attr("disabled", false);
                    swal({
                        text: "คุณปลูกครบจำนวนอาทิตแล้ว",
                        icon: "success",
                        button: "ปิด"
                    });

                } else {

                    $("#modal_detail").attr("disabled", false);
                    $("#modal_detail2").attr("disabled", false);
                }

            }
        });

    });


    var dt_id; //ตัวแปรสาธรณะ
    //---- Remove planting-----//
    $(document).on("click", "#btn_remove_week", function (event) {
        var planting_week_id = $(this).attr('data')
        var planting_week_status = $(this).attr('data-status')
        var planting_week_count = $(this).attr("data-name")
        if (planting_week_status == 'เสร็จสิ้น') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลสัปดาห์ที่ : " + planting_week_count,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/planting/remove_planting_week.php",
                            method: "POST",
                            data: {
                                planting_week_id: planting_week_id,
                                planting_week_status: planting_week_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    swal.close() // ปิดแจ้งเตือนเอง
                                }, 1500);
                                var table = $('#planting_listTable').DataTable();
                                table.destroy();
                                fetch_planting_detail(dt_id)

                                var table = $('#planting_detailTable').DataTable();
                                table.destroy(); //ลบตารางทิ้ง
                                fetch_modal2(modal_2_dt_id)
                            }
                        });
                        $.ajax({
                            url: "pages/planting/cal_week.php",
                            method: "POST",
                            data: {
                                id: planting_week_id

                            },
                            success: function (data) {
                                if (data == 1) {

                                    $("#modal_detail").attr("disabled", false);
                                    $("#modal_detail2").attr("disabled", false);
                                    swal({
                                        text: "ท่านปลูกครบจำนวนอาทิตแล้ว",
                                        icon: "success",
                                        button: "ปิด"
                                    });

                                } else {
                                    $("#modal_detail").attr("disabled", false);
                                    $("#modal_detail2").attr("disabled", false);
                                }

                            }
                        });


                    } else {
                        swal.close()
                    }
                });
        } else {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกการระงับข้อมูลสัปดาห์ที่ : " + planting_week_count,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/planting/remove_planting_week.php",
                            method: "POST",
                            data: {
                                planting_week_id: planting_week_id,
                                planting_week_status: planting_week_status
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
                                var table = $('#planting_listTable').DataTable();
                                table.destroy();
                                fetch_planting_detail(dt_id)
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        }

    });

    $("#in_planting_week_amount_drug").attr("disabled", true)
    $("#in_planting_week_drug_formula").on("change", function (event) {

        var in_planting_week_drug_formula = $(this).val()

        if (in_planting_week_drug_formula == "0") {

            $("#in_planting_week_amount_drug").attr("disabled", true)
            $("#in_planting_week_formula_price").val("");
            $("#in_planting_week_amount_drug").val("");
            $("#in_planting_week_formula_per_amount").val("");
            $("#in_planting_week_amount_formula").val("");

            $("#hidden_formula1").prop("hidden", true);
            $("#hidden_formula2").prop("hidden", true);
            $("#hidden_formula3").prop("hidden", true);
            $("#hidden_formula4").prop("hidden", true);

        } else {

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_formula_amount.php",
                data: {

                    id: in_planting_week_drug_formula

                },
                success: function (html) {
                    console.log(html)
                    $("#in_planting_week_formula_per_amount").val(html);

                },
            });

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_sum_formula_price.php",
                data: {

                    drug_formula_id: in_planting_week_drug_formula

                },
                success: function (data) {
                    console.log(data)
                    $("#in_planting_week_amount_formula").val(data);

                },
            });

            $("#in_planting_week_amount_drug").attr("disabled", false)
            $("#in_planting_week_formula_price").val("");
            $("#in_planting_week_amount_drug").val("");
            $("#hidden_formula1").prop("hidden", false);
            $("#hidden_formula2").prop("hidden", false);
            $("#hidden_formula3").prop("hidden", false);
            $("#hidden_formula4").prop("hidden", false);
        }

    });

    //คำนวณราคาสูตรยา
    $("#in_planting_week_amount_drug").on("change", function (event) {

        var drug_formula_id = $("#in_planting_week_drug_formula").val();

        var amount_drug_formula = $(this).val();

        $.ajax({
            method: "POST",
            url: "./pages/planting/get_formula_price.php",
            data: {

                drug_formula_id: drug_formula_id,
                amount_drug_formula: amount_drug_formula

            },
            success: function (html) {
                console.log(html)
                $("#in_planting_week_formula_price").val(html);

            },
        });

    });

    //เรียก หน่วย
    $("#in_planting_week_material").on("change", function (event) {

        var id_material = $(this).val();

        $.ajax({
            method: "POST",
            url: "./pages/planting/get_sm_unit.php",
            data: {

                id_material: id_material

            },
            success: function (html) {

                $("#in_planting_week_material_unit").text(html);

            },
        });

        $.ajax({
            method: "POST",
            url: "./pages/planting/get_per_amount.php",
            data: {

                id_material: id_material

            },
            success: function (html) {
                console.log(html)
                if (html != "") {
                    $("#in_planting_week_material_per_amount").val(html);

                    cal_gram = html * 1000
                    $("#in_planting_week_material_per_amount_gram").val(cal_gram);
                } else {
                    $("#in_planting_week_material_per_amount").val("");
                    $("#in_planting_week_material_per_amount_gram").val("");
                }

            },
        });

        $.ajax({
            method: "POST",
            url: "./pages/planting/get_price.php",
            data: {

                id_material: id_material

            },
            success: function (html) {
                console.log(html)
                $("#in_planting_week_material_price").val(html);

            },
        });


    });

    $("#in_planting_week_amount_material").on("change", function (event) {
        var material_per_amount = $("#in_planting_week_material_per_amount").val()
        var material_amount = $(this).val()
        if (material_amount == "") {
            $("#in_planting_week_material_total_amount").val("")
            $("#in_planting_week_material_total_amount_gram").val("")
        } else {
            total = material_per_amount * material_amount
            $("#in_planting_week_material_total_amount").val(total)

            totals = total * 1000
            $("#in_planting_week_material_total_amount_gram").val(totals)
        }
    });

    //เคลียค่าว่าง
    $("#in_planting_week_amount_material").attr("disabled", true)
    $("#in_planting_week_material_price").attr("disabled", true)
    $("#hidden1").prop("hidden", true);
    $("#hidden2").prop("hidden", true);
    $("#hidden3").prop("hidden", true);
    $("#hidden4").prop("hidden", true);
    $("#hidden5").prop("hidden", true);

    $("#show_text_amount").prop("hidden", true);
    $("#in_planting_week_material").on("change", function (event) {

        var in_planting_week_material = $(this).val()

        if (in_planting_week_material == "0") {
            $("#in_planting_week_amount_material").attr("disabled", true)
            $("#in_planting_week_material_price").attr("disabled", true)

            $("#hidden1").prop("hidden", true);
            $("#hidden2").prop("hidden", true);
            $("#hidden3").prop("hidden", true);
            $("#hidden4").prop("hidden", true);
            $("#hidden5").prop("hidden", true);

            $("#show_text_amount").prop("hidden", true);
            $("#in_planting_week_amount_material").val("")
            $("#in_planting_week_material_price").val("")
            $("#in_planting_week_material_total_amount").val("")
            $("#in_planting_week_material_total_amount_gram").val("")
            $("#in_planting_week_material_price_total").val("")



        } else {

            $("#in_planting_week_amount_material").attr("disabled", false)
            $("#in_planting_week_material_price").attr("disabled", false)

            $("#hidden1").prop("hidden", false);
            $("#hidden2").prop("hidden", false);
            $("#hidden3").prop("hidden", false);
            $("#hidden4").prop("hidden", false);
            $("#hidden5").prop("hidden", false);

            $("#show_text_amount").prop("hidden", false);
            $("#in_planting_week_amount_material").val("")
            $("#in_planting_week_material_price").val("")
            $("#in_planting_week_material_price").val("")
            $("#in_planting_week_material_total_amount").val("")
            $("#in_planting_week_material_total_amount_gram").val("")
            $("#in_planting_week_material_price_total").val("")
        }

    });



    $(".in_planting_week_material_price").on("change", function (event) {

        var price = $(this).val()
        var amount = $("#in_planting_week_amount_material").val()
        var per_gram = $("#in_planting_week_material_per_amount_gram").val()
        var total_gram = $("#in_planting_week_material_total_amount_gram").val()

        prices = parseInt(price)
        per_grams = parseInt(per_gram)
        total_grams = parseInt(total_gram)
        if (amount == "") {
            $("#in_planting_week_material_price_total").val(0)
        } else {
            cal_price = price / per_gram
            total_price = cal_price * total_gram

            console.log(cal_price)
            console.log(total_price)

            $("#in_planting_week_material_price_total").val(total_price.toFixed(2))
        }
    });

    $("#in_planting_week_amount_material").on("change", function (event) {
        var amount = $(this).val()
        var total_gram = $("#in_planting_week_material_total_amount_gram").val()
        var price = $("#in_planting_week_material_price").val()
        var per_gram = $("#in_planting_week_material_per_amount_gram").val()

        if (price == "") {
            $("#in_planting_week_material_price_total").val("")
        }
        else if (amount == 0) {
            swal({
                text: "กรุณากรอกปริมาณวัสดุปลูกให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#in_planting_week_material_total_amount").val("")
            $("#in_planting_week_material_total_amount_gram").val("")

        } else {
            cal_price = price / per_gram
            total_price = cal_price * total_gram

            console.log(cal_price)
            console.log(total_price)


            $("#in_planting_week_material_price_total").val(total_price.toFixed(2))
        }
    });



    //เช็คเลือกวันที่เกิน ในเพิ่มข้อมูลแต่ละ week
    $(document).on("change", "#in_planting_week_date", function (event) {

        var in_planting_week_date = $(this).val()
        var in_planting_week_datenow = $("#in_planting_week_datenow").val()

        if (in_planting_week_date > in_planting_week_datenow) {
            swal({
                text: "กรุณาเลือกวันที่ ที่ไม่มากกว่าปัจจุบัน",
                icon: "warning",
                button: "ปิด"
            });

            $("#in_planting_week_date").val("");
        }

    });

    $("#in_planting_week_material_price").on("keyup", function (event) {
        var id = $(this).val()
        if (!id.match(/^([0-9 /.])+$/i)) {
            swal({
                text: "กรุณากรอก ราคา/หน่วย เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            $("#in_planting_week_material_price_total").val("")
            return false;
        } else if (id == 0) {
            swal({
                text: "กรุณากรอก ราคา/หน่วย ให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#in_planting_week_material_price_total").val("")
        }
    });

    $(".in_planting_week_amount_material").keyup(function () {
        var id = $(this).val()
        if (!id.match(/^([0-9 .])+$/i)) {
            swal({
                text: "กรุณากรอกปริมาณวัสดุปลูกเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            $("#in_planting_week_material_total_amount").val("")
            $("#in_planting_week_material_total_amount_gram").val("")
            $("#in_planting_week_material_price_total").val("")
            return false;
        }

    });

    $("#in_planting_week_amount_drug").keyup(function () {
        var id = $(this).val()
        if (!id.match(/^([0-9 / .])+$/i)) {
            swal({
                text: "กรุณากรอกปริมาณสูตรยาเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();

            $("#in_planting_week_formula_price").val("")
            return false;


        }

    });


    $("#in_planting_week_dead").keyup(function () {
        var id = $(this).val()
        if (!id.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนต้นไม้ที่ตายเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }

    });



    //บันทึกแต่ละอาทิตย์
    $(document).on("click", "#btn_add_planting_week", function (event) {


        var in_planting_week_id = $("#in_planting_week_id").val()
        var in_planting_week_amount = $("#in_planting_week_amount").val()

        var in_planting_week_drug_formula = $("#in_planting_week_drug_formula").val()
        var in_planting_week_amount_drug = $("#in_planting_week_amount_drug").val()
        var in_planting_week_formula_price = $("#in_planting_week_formula_price").val()

        var in_planting_week_material = $("#in_planting_week_material").val()
        var in_planting_week_amount_material = $("#in_planting_week_amount_material").val()
        var in_planting_week_material_price = $("#in_planting_week_material_price").val()

        var in_planting_week_dead = $("#in_planting_week_dead").val()
        var in_planting_week_date = $("#in_planting_week_date").val()



        if (in_planting_week_drug_formula == "0" && in_planting_week_material == "0") {
            swal({
                text: "กรุณาเลือกสูตรยาหรือวัสดุปลูก",
                icon: "warning",
                button: "ปิด"
            });
        } else if (in_planting_week_drug_formula != "0") {

            if (in_planting_week_amount_drug == "") {
                swal({
                    text: "กรุณากรอกปริมาณการใช้สูตรยา",
                    icon: "warning",
                    button: "ปิด"
                });
            } else if (in_planting_week_dead == "") {
                swal({
                    text: "กรุณากรอกจำนวนต้นไม้ที่ตาย",
                    icon: "warning",
                    button: "ปิด"
                });
            } else {
                $.ajax({
                    method: "POST",
                    url: "./pages/planting/insert_planting_week.php",
                    data: {

                        in_planting_week_id: in_planting_week_id,
                        in_planting_week_amount: in_planting_week_amount,

                        in_planting_week_drug_formula: in_planting_week_drug_formula,
                        in_planting_week_formula_price: in_planting_week_formula_price,
                        in_planting_week_amount_drug: in_planting_week_amount_drug,

                        in_planting_week_material: in_planting_week_material,
                        in_planting_week_amount_material: in_planting_week_amount_material,
                        in_planting_week_material_price: in_planting_week_material_price,

                        in_planting_week_dead: in_planting_week_dead,
                        in_planting_week_date: in_planting_week_date

                    },
                    success: function (data) {
                        console.log(data)
                        swal({
                            text: "บันทึกข้อมูลเรียบร้อย",
                            icon: "success",
                            button: false
                        })
                        $('#add_planting_week').modal('toggle');

                        setTimeout(function () {
                            swal.close()
                        }, 1500);

                        var table = $('#plantingTable').DataTable();
                        table.destroy(); //ลบตารางทิ้ง
                        fetch_table1()

                        var table = $('#planting_detailTable').DataTable();
                        table.destroy(); //ลบตารางทิ้ง
                        fetch_modal2(modal_2_dt_id)

                        var table = $('#planting_listTable').DataTable();
                        table.destroy();
                        fetch_planting_detail(in_planting_week_id)

                        $('.viewlist').modal('toggle');


                        console.log(data)

                    }
                });

            }

        } else if (in_planting_week_material != "0") {

            if (in_planting_week_amount_material == "") {
                swal({
                    text: "กรุณากรอกปริมาณการใช้วัสดุปลูก",
                    icon: "warning",
                    button: "ปิด"
                });

            } else if (in_planting_week_dead == "") {
                swal({
                    text: "กรุณากรอกจำนวนต้นไม้ที่ตาย",
                    icon: "warning",
                    button: "ปิด"
                });
            } else {
                $.ajax({
                    method: "POST",
                    url: "./pages/planting/insert_planting_week.php",
                    data: {

                        in_planting_week_id: in_planting_week_id,
                        in_planting_week_amount: in_planting_week_amount,

                        in_planting_week_drug_formula: in_planting_week_drug_formula,
                        in_planting_week_formula_price: in_planting_week_formula_price,
                        in_planting_week_amount_drug: in_planting_week_amount_drug,

                        in_planting_week_material: in_planting_week_material,
                        in_planting_week_amount_material: in_planting_week_amount_material,
                        in_planting_week_material_price: in_planting_week_material_price,

                        in_planting_week_dead: in_planting_week_dead,
                        in_planting_week_date: in_planting_week_date

                    },
                    success: function (data) {
                        console.log(data)
                        swal({
                            text: "บันทึกข้อมูลเรียบร้อย",
                            icon: "success",
                            button: false
                        })
                        $('#add_planting_week').modal('toggle');

                        setTimeout(function () {
                            swal.close()
                        }, 1500);

                        var table = $('#plantingTable').DataTable();
                        table.destroy(); //ลบตารางทิ้ง
                        fetch_table1()

                        var table = $('#planting_detailTable').DataTable();
                        table.destroy(); //ลบตารางทิ้ง
                        fetch_modal2(modal_2_dt_id)

                        var table = $('#planting_listTable').DataTable();
                        table.destroy();
                        fetch_planting_detail(in_planting_week_id)

                        $('.viewlist').modal('toggle');


                        console.log(data)

                    }
                });

            }

        }
    });

    $(document).on("click", "#modal_detail", function (event) {
        console.log(dt_id)
        $.ajax({
            url: "pages/planting/get_maxid_week.php",
            method: "POST",
            data: {
                id: dt_id,

            },
            success: function (data) {

                $("#in_planting_week_amount").val(data)

            }
        });
    });


    function fetch_week_detail(id) {

        var a = $('#planting_week_detailTable').DataTable({
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
                    targets: 2,
                    className: 'dt-body-right'
                },
                {
                    targets: 5,
                    className: 'dt-body-right'
                },
                {
                    targets: 7,
                    className: 'dt-body-right'
                },
                {
                    targets: 6,
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
                url: "./pages/planting/fetch_planting_week_detail.php",
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

    $(document).on("click", "#view_week_detail", function (event) {

        var table = $('#planting_week_detailTable').DataTable();
        table.destroy(); //ลบตารางทิ้ง

        var id = $(this).attr('data');
        var plant_name = $(this).attr('data-plant');
        var week_count = $(this).attr('data-count');
        var planting_detail_id = $(this).attr('data-planting_detail_id');

        $("#view_order_name3").text(planting_detail_id);
        $("#view_customer_name3").text(customer_name);
        $("#week_plant_name3").text(plant_name);
        $("#week_name3").text(week_count);

        console.log(id)
        week_detail_ids = id;

        fetch_week_detail(week_detail_ids);

    });

    var week_detail_ids;


    $(document).on("click", "#btn_add_week_detail", function (event) {

        var week_id = $(this).attr('data');
        var week_count = $(this).attr('data-count');
        var plant_name = $(this).attr('data-plant');
        var planting_detail_id = $(this).attr('data-planting_detail_id');

        console.log(week_id)
        console.log(planting_detail_id)
        console.log(plant_name)
        console.log(week_count)


        week_ids = week_id


        $.ajax({
            url: "./pages/planting/fetch_modal_add_week_detail.php",
            method: "POST",
            data: {
                id: week_id
            },
            success: function (data) {
                /*  console.log(data) */
                $("#show_modal_add").html(data)
                $("#add_week_detail" + week_id).modal("show")
                $(".in2_planting_week_amount_drug").attr("disabled", true)
                $(".in2_planting_week_amount_material").attr("disabled", true)
                $("#in2_planting_week_id").val(planting_detail_id)
                $("#in2_planting_week_name_plant").val(plant_name)
                $("#in2_planting_week_amount").val(week_count)
                $(".in2_planting_week_amount_formula").attr("disabled", true)

                /*     $("#in_planting_week_detail2" + week_id)[0].reset(); */
            }
        });


    });

    var week_ids;

    $(".in2_planting_week_amount_formula").attr("disabled", true)

    $(document).on("change", ".in2_planting_week_drug_formula", function (event) {

        var formula_id = $(this).val()
        var formula_use_amount = $("#in2_planting_week_amount_formula").val()
        /*   console.log(formula_id)
    */
        if (formula_id == "0") {

            $(".in2_planting_week_amount_formula").attr("disabled", true)
            $("#in2_planting_week_formula_amount").val("");
            $(".in2_planting_week_formula_price").val("");
            $(".in2_planting_week_formula_total_price").val("");

            $("#hidden_formula5").prop("hidden", true)
            $("#hidden_formula6").prop("hidden", true)
            $("#hidden_formula7").prop("hidden", true)
            $("#hidden_formula8").prop("hidden", true)



        } else {

            $("#hidden_formula5").prop("hidden", false)
            $("#hidden_formula6").prop("hidden", false)
            $("#hidden_formula7").prop("hidden", false)
            $("#hidden_formula8").prop("hidden", false)




            $(".in2_planting_week_amount_formula").attr("disabled", false)

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_formula_amount.php",
                data: {

                    id: formula_id

                },
                success: function (html) {

                    $("#in2_planting_week_formula_amount").val(html);

                },
            });

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_sum_formula_price.php",
                data: {

                    drug_formula_id: formula_id

                },
                success: function (html) {

                    $("#in2_planting_week_formula_price").val(html);

                },
            });

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_formula_price.php",
                data: {

                    drug_formula_id: formula_id,
                    amount_drug_formula: formula_use_amount

                },
                success: function (html) {

                    $("#in2_planting_week_formula_total_price").val(html);

                },
            });

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_formula_price.php",
                data: {

                    drug_formula_id: formula_id,
                    amount_drug_formula: formula_use_amount

                },
                success: function (html) {

                    $("#in2_planting_week_formula_total_price").val(html);

                },
            });

        }

    });

    $(document).on("change", ".in2_planting_week_amount_formula", function (event) {

        var formula_use_amount = $(this).val()
        var formula_id = $("#in2_planting_week_drug_formula").val()

        if (formula_use_amount == 0) {
            swal({
                text: "กรุณากรอกปริมาณการใช้ยา ให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#in2_planting_week_formula_total_price").val("");

        } else if (formula_use_amount == ".") {
            swal({
                text: "กรุณากรอกปริมาณการใช้ยา เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#in2_planting_week_formula_total_price").val("");

        } else if (!formula_use_amount.match(/^([0-9 .])+$/i)) {
            swal({
                text: "กรุณากรอกปริมาณการใช้ยา เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#in2_planting_week_formula_total_price").val("");
            return false;

        } else {
            $.ajax({
                method: "POST",
                url: "./pages/planting/get_formula_price.php",
                data: {

                    drug_formula_id: formula_id,
                    amount_drug_formula: formula_use_amount

                },
                success: function (html) {

                    $("#in2_planting_week_formula_total_price").val(html);

                },
            });
        }
    });



    $(".in2_planting_week_amount_material").attr("disabled", true)
    $(document).on("change", ".in2_planting_week_material", function (event) {

        var material_id = $(this).val()
        var material_use_amount = $("#in2_planting_week_amount_material").val()

        if (material_id == "0") {
            $(".in2_planting_week_amount_material").attr("disabled", true)
            $("#in2_planting_week_amount_material").val("")
            $("#in2_planting_week_material_price").val("")
            $("#in2_planting_week_material_per_amount").val("")
            $("#in2_planting_week_material_per_price").val("")
            $("#in2_planting_week_material_use_amount_sm").val("")

            $("#hidden_material10").prop("hidden", true)
            $("#hidden_material11").prop("hidden", true)
            $("#hidden_material12").prop("hidden", true)
            $("#hidden_material13").prop("hidden", true)
            $("#hidden_material14").prop("hidden", true)

        } else {
            $(".in2_planting_week_amount_material").attr("disabled", false)
            $("#in2_planting_week_material_price").val("")


            $("#hidden_material10").prop("hidden", false)
            $("#hidden_material11").prop("hidden", false)
            $("#hidden_material12").prop("hidden", false)
            $("#hidden_material13").prop("hidden", false)
            $("#hidden_material14").prop("hidden", false)

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_per_amount.php",
                data: {

                    id_material: material_id

                },
                success: function (html) {

                    cal_amount = material_use_amount * html
                    $("#in2_planting_week_material_use_amount_sm").val(cal_amount);

                    $("#in2_planting_week_material_per_amount").val(html);

                },
            });

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_price.php",
                data: {

                    id_material: material_id

                },
                success: function (html) {

                    $("#in2_planting_week_material_per_price").val(html);

                },
            });

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_sm_unit.php",
                data: {

                    id_material: material_id

                },
                success: function (html) {

                    $("#show_unit_add").text(html);

                },
            });



            $.ajax({
                method: "POST",
                url: "./pages/planting/get_material_price.php",
                data: {

                    material_id: material_id,
                    amount_material: material_use_amount

                },
                success: function (html) {

                    $("#in2_planting_week_material_price").val(html);

                },
            });

        }
    });
    $(document).on("change", ".in2_planting_week_amount_material", function (event) {

        var material_use_amount = $(this).val()
        var material_id = $("#in2_planting_week_material").val()
        var material_per_amount = $("#in2_planting_week_material_per_amount").val()

        if (material_use_amount == 0) {
            swal({
                text: "กรุณากรอกปริมาณการใช้วัสดุปลูก ให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#in2_planting_week_material_use_amount_sm").val("");
            $("#in2_planting_week_material_price").val("");

        }
    });

    $(document).on("keyup", ".in2_planting_week_amount_material", function (event) {

        var material_use_amount = $(this).val()
        var material_id = $("#in2_planting_week_material").val()
        var material_per_amount = $("#in2_planting_week_material_per_amount").val()

        if (material_use_amount == ".") {
            swal({
                text: "กรุณากรอกปริมาณการใช้วัสดุปลูก เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#in2_planting_week_material_use_amount_sm").val("");
            $("#in2_planting_week_material_price").val("");

        } else if (!material_use_amount.match(/^([0-9 .])+$/i)) {
            swal({
                text: "กรุณากรอกปริมาณการใช้วัสดุปลูก เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $("#in2_planting_week_material_use_amount_sm").val("");
            $("#in2_planting_week_material_price").val("");
            return false;

        } else {

            cal_amount = material_use_amount * material_per_amount
            $("#in2_planting_week_material_use_amount_sm").val(cal_amount);

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_material_price.php",
                data: {

                    material_id: material_id,
                    amount_material: material_use_amount

                },
                success: function (html) {

                    $("#in2_planting_week_material_price").val(html);

                },
            });
        }

    });


    //เช็คเลือกวันที่เกิน ในเพิ่มข้อมูลแต่ละ week
    $(document).on("change", ".in2_planting_week_date", function (event) {

        var in_planting_week_date = $(this).val()
        var in_planting_week_datenow = $("#in2_planting_week_datenow").val()

        if (in_planting_week_date > in_planting_week_datenow) {
            swal({
                text: "กรุณาเลือกวันที่ ที่ไม่มากกว่าปัจจุบัน",
                icon: "warning",
                button: "ปิด"
            });

            $("#in2_planting_week_date").val(in_planting_week_datenow);
        }

    });

    $(document).on("keyup", ".in2_planting_week_dead", function () {
        var id = $(this).val()
        if (!id.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนต้นไม้ที่ตาย เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }

    });


    //บันทึกแต่ละอาทิตย์
    $(document).on("click", "#btn_add2_planting_week", function (event) {
        var id = $(this).attr("data-id");
        var in2_week_id = $("#in2_planting_week_amount").val()

        var in2_planting_week_drug_formula = $("#in2_planting_week_drug_formula").val()
        var in2_planting_week_amount_drug = $("#in2_planting_week_amount_formula").val()
        var in2_planting_week_formula_price = $("#in2_planting_week_formula_price").val()

        var in2_planting_week_material = $("#in2_planting_week_material").val()
        var in2_planting_week_amount_material = $("#in2_planting_week_amount_material").val()
        var in2_planting_week_material_price = $("#in2_planting_week_material_price").val()

        var in2_planting_week_dead = $("#in2_planting_week_dead").val()
        var in2_planting_week_date = $("#in2_planting_week_date").val()


        if (in2_planting_week_drug_formula == "0" && in2_planting_week_material == "0") {
            swal({
                text: "กรุณาเลือกสูตรยาหรือวัสดุปลูก",
                icon: "warning",
                button: "ปิด"
            });

        } else {
            if (in2_planting_week_drug_formula != 0) {

                if (in2_planting_week_amount_drug == "") {
                    swal({
                        text: "กรุณากรอกปริมาณการใช้สูตรยา",
                        icon: "warning",
                        button: "ปิด"
                    });
                } else if (in2_planting_week_dead == "") {
                    swal({
                        text: "กรุณากรอกจำนวนต้นไม้ที่ตาย",
                        icon: "warning",
                        button: "ปิด"
                    });

                } else {

                    $.ajax({
                        method: "POST",
                        url: "./pages/planting/insert_week_detail.php",
                        data: {

                            in2_week_id: id,


                            in2_planting_week_drug_formula: in2_planting_week_drug_formula,
                            in2_planting_week_formula_price: in2_planting_week_formula_price,
                            in2_planting_week_amount_drug: in2_planting_week_amount_drug,

                            in2_planting_week_material: in2_planting_week_material,
                            in2_planting_week_amount_material: in2_planting_week_amount_material,
                            in2_planting_week_material_price: in2_planting_week_material_price,

                            in2_planting_week_dead: in2_planting_week_dead,
                            in2_planting_week_date: in2_planting_week_date

                        },
                        success: function (data) {
                            console.log(data)
                            swal({
                                text: "บันทึกข้อมูลเรียบร้อย",
                                icon: "success",
                                button: false
                            })
                            $('#add_week_detail' + week_ids).modal('toggle');

                            setTimeout(function () {
                                swal.close()
                            }, 1500);
                            console.log(data)

                            var table = $('#plantingTable').DataTable();
                            table.destroy(); //ลบตารางทิ้ง
                            fetch_table1()

                            var table = $('#planting_listTable').DataTable();
                            table.destroy();
                            fetch_planting_detail(dt_id)

                            var table = $('#planting_detailTable').DataTable();
                            table.destroy(); //ลบตารางทิ้ง
                            fetch_modal2(modal_2_dt_id)

                            $('.viewlist').modal('toggle');
                        }
                    });
                }
            } else if (in2_planting_week_material != 0) {

                if (in2_planting_week_amount_material == "") {
                    swal({
                        text: "กรุณากรอกปริมาณการใช้วัสดุปลูก",
                        icon: "warning",
                        button: "ปิด"
                    });

                } else if (in2_planting_week_dead == "") {
                    swal({
                        text: "กรุณากรอกจำนวนต้นไม้ที่ตาย",
                        icon: "warning",
                        button: "ปิด"
                    });

                } else {
                    $.ajax({
                        method: "POST",
                        url: "./pages/planting/insert_week_detail.php",
                        data: {

                            in2_week_id: id,


                            in2_planting_week_drug_formula: in2_planting_week_drug_formula,
                            in2_planting_week_formula_price: in2_planting_week_formula_price,
                            in2_planting_week_amount_drug: in2_planting_week_amount_drug,

                            in2_planting_week_material: in2_planting_week_material,
                            in2_planting_week_amount_material: in2_planting_week_amount_material,
                            in2_planting_week_material_price: in2_planting_week_material_price,

                            in2_planting_week_dead: in2_planting_week_dead,
                            in2_planting_week_date: in2_planting_week_date

                        },
                        success: function (data) {
                            console.log(data)
                            swal({
                                text: "บันทึกข้อมูลเรียบร้อย",
                                icon: "success",
                                button: false
                            })
                            $('#add_week_detail' + week_ids).modal('toggle');

                            setTimeout(function () {
                                swal.close()
                            }, 1500);
                            console.log(data)

                            var table = $('#plantingTable').DataTable();
                            table.destroy(); //ลบตารางทิ้ง
                            fetch_table1()

                            var table = $('#planting_listTable').DataTable();
                            table.destroy();
                            fetch_planting_detail(dt_id)

                            var table = $('#planting_detailTable').DataTable();
                            table.destroy(); //ลบตารางทิ้ง
                            fetch_modal2(modal_2_dt_id)

                            $('.viewlist').modal('toggle');
                        }
                    });
                }
            }
        }
    });

    //---- Remove planting-----//
    $(document).on("click", "#btn_remove_week_detail", function (event) {
        var week_detail_id = $(this).attr('data')
        var i = $(this).attr('data-id')
        var week_detail_status = $(this).attr('data-status')
        var drug_formula_name = $(this).attr("data-name")
        if (week_detail_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลรายการ : " + "ลำดับที่ " + i + " (" + drug_formula_name + ")",
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/planting/remove_planting_week_detail.php",
                            method: "POST",
                            data: {
                                week_detail_id: week_detail_id,
                                week_detail_status: week_detail_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    swal.close() // ปิดแจ้งเตือนเอง
                                }, 1500);


                                var table = $('#plantingTable').DataTable();
                                table.destroy(); //ลบตารางทิ้ง
                                fetch_table1()

                                var table = $('#planting_listTable').DataTable();
                                table.destroy();
                                fetch_planting_detail(dt_id)

                                var table = $('#planting_detailTable').DataTable();
                                table.destroy(); //ลบตารางทิ้ง
                                fetch_modal2(modal_2_dt_id)

                                var table = $('#planting_week_detailTable').DataTable();
                                table.destroy(); //ลบตารางทิ้ง

                                fetch_week_detail(week_detail_ids)
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        } else {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกการระงับข้อมูลรายการ : " + "ลำดับที่ " + i + " (" + drug_formula_name + ")",
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/planting/remove_planting_week_detail.php",
                            method: "POST",
                            data: {
                                week_detail_id: week_detail_id,
                                week_detail_status: week_detail_status
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

                                var table = $('#plantingTable').DataTable();
                                table.destroy(); //ลบตารางทิ้ง
                                fetch_table1()

                                var table = $('#planting_listTable').DataTable();
                                table.destroy();
                                fetch_planting_detail(dt_id)

                                var table = $('#planting_detailTable').DataTable();
                                table.destroy(); //ลบตารางทิ้ง
                                fetch_modal2(modal_2_dt_id)

                                var table = $('#planting_week_detailTable').DataTable();
                                table.destroy(); //ลบตารางทิ้ง
                                fetch_week_detail(week_detail_ids)
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
        }

    });

    //-- ปุ่มแก้ไข รายละเอียดแต่ละสัปดาห์ --//

    $(document).on("click", "#edit_week_detail", function (event) {


        var id = $(this).attr('data');
        var week = $(this).attr('week');

        $(".edit_week_detail")[0].reset();

        $(".edit2_week_id").val(id)
        console.log(id)

        $("#edit2_planting_week_id" + id).val(dt_id)
        $("#edit2_planting_week_amount" + id).val(week)
        $("#edit2_planting_week_name_plant" + id).val(plant_name)

        idss = id

    });
    var idss

    $(document).on("change", ".edit2_planting_week_drug_formula", function (event) {


        var formula_name = $(this).val()
        var formula_amount = $("#edit2_planting_week_amount_drug").val()

        console.log(formula_name)

        if (formula_name == "0") {

            $(".edit2_planting_week_amount_drug").attr("disabled", true)
            $(".edit2_planting_week_formula_price").val("");
            $(".edit2_planting_week_amount_drug").val("");
            $(".edit2_planting_week_formula_per_amount").val("");
            $(".edit2_planting_week_formula_per_price").val("")
            $("#hidden_formula5").prop("hidden", true)
            $("#hidden_formula6").prop("hidden", true)
            $("#hidden_formula7").prop("hidden", true)
            $("#hidden_formula8").prop("hidden", true)
        } else {
            $(".edit2_planting_week_amount_drug").attr("disabled", false)
            $("#hidden_formula5").prop("hidden", false)
            $("#hidden_formula6").prop("hidden", false)
            $("#hidden_formula7").prop("hidden", false)
            $("#hidden_formula8").prop("hidden", false)

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_formula_amount.php",
                data: {

                    id: formula_name

                },
                success: function (data) {

                    console.log(data)
                    $(".edit2_planting_week_formula_per_amount").val(data);

                },
            });

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_formula_price.php",
                data: {

                    drug_formula_id: formula_name,
                    amount_drug_formula: formula_amount

                },
                success: function (data) {
                    console.log(data)
                    $(".edit2_planting_week_formula_price").val(data);

                },
            });

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_sum_formula_price.php",
                data: {

                    drug_formula_id: formula_name,
                    amount_drug_formula: formula_amount

                },
                success: function (data) {
                    console.log(data)
                    $(".edit2_planting_week_formula_per_price").val(data);

                },
            });

            /* $(".edit2_planting_week_formula_price").val("");
            $(".edit2_planting_week_amount_drug").val(""); */

        }

    });

    $(document).on("change", ".edit2_planting_week_amount_drug", function (event) {


        var formula_use_amount = $(this).val()
        var formula_id = $("#edit2_planting_week_drug_formula").val()
        if (formula_use_amount == 0) {
            swal({
                text: "กรุณากรอกปริมาณการใช้สูตรยา ให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(".edit2_planting_week_formula_price").val("");

        } else if (!formula_use_amount.match(/^([0-9 .])+$/i)) {
            swal({
                text: "กรุณากรอกปริมาณการใช้สูตรยา เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(".edit2_planting_week_formula_price").val("");

            $(this).focus();
            return false;
        } else if (formula_use_amount == ".") {
            swal({
                text: "กรุณากรอกปริมาณการใช้สูตรยา เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(".edit2_planting_week_formula_price").val("");

        } else {

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_formula_price.php",
                data: {

                    drug_formula_id: formula_id,
                    amount_drug_formula: formula_use_amount

                },
                success: function (data) {
                    console.log(data)
                    $(".edit2_planting_week_formula_price").val(data);

                },
            });

        }


    });


    $(document).on("change", ".edit2_planting_week_material", function (event) {
        var material_id = $(this).val()
        var material_use_amount = $("#edit2_planting_week_amount_material").val()

        if (material_id == "0") {

            $(".edit2_planting_week_amount_material").attr("disabled", true)
            $(".edit2_planting_week_amount_material").val("");
            $(".edit2_planting_week_per_amount").val("");
            $(".edit2_planting_week_per_price").val("");
            $(".edit2_planting_week_use_amount").val("");
            $(".edit2_planting_week_material_price").val("");
            $("#hide_materail1").prop("hidden", true)
            $("#hide_materail2").prop("hidden", true)
            $("#hide_materail3").prop("hidden", true)
            $("#hide_materail4").prop("hidden", true)
            $("#hide_materail5").prop("hidden", true)
        } else {
            $(".edit2_planting_week_amount_material").attr("disabled", false)
            $(".edit2_planting_week_use_amount").val("");
            $(".edit2_planting_week_material_price").val("");
            $("#hide_materail1").prop("hidden", false)
            $("#hide_materail2").prop("hidden", false)
            $("#hide_materail3").prop("hidden", false)
            $("#hide_materail4").prop("hidden", false)
            $("#hide_materail5").prop("hidden", false)

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_per_amount.php",
                data: {

                    id_material: material_id

                },
                success: function (data) {

                    console.log(data)
                    $(".edit2_planting_week_per_amount").val(data);

                    cal_use_sm = material_use_amount * data
                    $(".edit2_planting_week_use_amount").val(cal_use_sm);
                },
            });

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_price.php",
                data: {

                    id_material: material_id

                },
                success: function (data) {

                    console.log(data)
                    $(".edit2_planting_week_per_price").val(data);

                },
            });

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_sm_unit.php",
                data: {

                    id_material: material_id

                },
                success: function (data) {

                    console.log(data)
                    $(".show_unit").text(data);

                },
            });

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_material_price.php",
                data: {

                    material_id: material_id,
                    amount_material: material_use_amount

                },
                success: function (data) {

                    console.log(data)
                    $(".edit2_planting_week_material_price").val(data);

                },
            });
        }
    });

    $(document).on("change", ".edit2_planting_week_amount_material", function (event) {
        var material_use_amount = $(this).val()
        var material_id = $("#edit2_planting_week_material").val()
        var material_per_amount = $("#edit2_planting_week_per_amount").val()

        if (material_use_amount == 0) {
            swal({
                text: "กรุณากรอกปริมาณการใช้วัสดุปลูก ให้มากกว่า 0",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(".edit2_planting_week_use_amount").val("");
            $(".edit2_planting_week_material_price").val("");

        } else if (!material_use_amount.match(/^([0-9 .])+$/i)) {
            swal({
                text: "กรุณากรอกปริมาณการใช้วัสดุปลูก เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(".edit2_planting_week_use_amount").val("");
            $(".edit2_planting_week_material_price").val("");

            $(this).focus();
            return false;
        } else if (material_use_amount == ".") {
            swal({
                text: "กรุณากรอกปริมาณการใช้วัสดุปลูก เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(".edit2_planting_week_use_amount").val("");
            $(".edit2_planting_week_material_price").val("");

        } else {

            cal_use_sm = material_use_amount * material_per_amount
            $(".edit2_planting_week_use_amount").val(cal_use_sm);

            $.ajax({
                method: "POST",
                url: "./pages/planting/get_material_price.php",
                data: {

                    material_id: material_id,
                    amount_material: material_use_amount

                },
                success: function (data) {

                    console.log(data)
                    $(".edit2_planting_week_material_price").val(data);

                },
            });

        }

    });
    //เรียก หน่วย
    $(".edit2_planting_week_material").on("change", function (event) {

        var id_material = $(this).val();

        $.ajax({
            method: "POST",
            url: "./pages/planting/get_sm_unit.php",
            data: {

                id_material: id_material

            },
            success: function (html) {

                $(".edit2_planting_week_material_unit").val(html);

                $.ajax({
                    method: "POST",
                    url: "./pages/planting/get_formula_amount.php",
                    data: {

                        id: formula_name

                    },
                    success: function (data) {

                        console.log(data)
                        $(".edit2_planting_week_formula_per_amount").val(data);

                    },
                });
            },
        });
    });

    //เคลียค่าว่าง

    $(".edit2_planting_week_material").on("change", function (event) {

        var in_planting_week_material = $(this).val()

        if (in_planting_week_material == "0") {
            $(".edit2_planting_week_amount_material").attr("disabled", true)
            $(".edit2_planting_week_amount_material").val("")
            $(".edit2_planting_week_material_price").val("")
        } else {
            $(".edit2_planting_week_amount_material").attr("disabled", false)
            $(".edit2_planting_week_amount_material").val("")
            $(".edit2_planting_week_material_price").val("")
        }
    });


    //คำนวณราคาวัสดุปลูก
    $(".edit2_planting_week_amount_material").keyup("change", function (event) {

        var material_id = $(".edit2_planting_week_material").val();

        var amount_material = $(this).val();

        $.ajax({
            method: "POST",
            url: "./pages/planting/get_material_price.php",
            data: {

                material_id: material_id,
                amount_material: amount_material

            },
            success: function (html) {
                console.log(html)
                $(".edit2_planting_week_material_price").val(html);

            },
        });
    });

    //เช็คเลือกวันที่เกิน ในเพิ่มข้อมูลแต่ละ week
    $(document).on("change", ".edit2_planting_week_date", function (event) {

        var in_planting_week_date = $(this).val()
        var in_planting_week_datenow = $(".edit2_planting_week_datenow").val()

        if (in_planting_week_date > in_planting_week_datenow) {
            swal({
                text: "กรุณาเลือกวันที่ ที่ไม่มากกว่าปัจจุบัน",
                icon: "warning",
                button: "ปิด"
            });

            $(".edit2_planting_week_date").val("");
        }

    });

    $(document).on("change", ".edit2_planting_week_dead", function (event) {
        var id = $(this).val()
        if (!id.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนต้นไม้ที่ตาย เป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }

    });

    $(document).on("click", "#btn_edit2_planting_week", function (event) {

        var id = $(this).attr("data-id");

        var edit2_week_id = $("#edit2_week_id").val()
        var edit2_planting_week_amount = $("#edit2_planting_week_amount").val()

        var edit2_planting_week_drug_formula = $("#edit2_planting_week_drug_formula").val()
        var edit2_planting_week_amount_drug = $("#edit2_planting_week_amount_drug").val()
        var edit2_planting_week_formula_price = $("#edit2_planting_week_formula_price").val()

        var edit2_planting_week_material = $("#edit2_planting_week_material").val()
        var edit2_planting_week_amount_material = $("#edit2_planting_week_amount_material").val()
        var edit2_planting_week_material_price = $("#edit2_planting_week_material_price").val()

        var edit2_planting_week_dead = $("#edit2_planting_week_dead").val()
        var edit2_planting_week_date = $("#edit2_planting_week_date").val()


        if (edit2_planting_week_drug_formula == "0" && edit2_planting_week_material == "0") {
            swal({
                text: "กรุณาเลือกสูตรยาหรือวัสดุปลูก",
                icon: "warning",
                button: "ปิด"
            });
        } else if (edit2_planting_week_drug_formula != "0") {

            if (edit2_planting_week_amount_drug == "") {
                swal({
                    text: "กรุณากรอกปริมาณการใช้สูตรยา",
                    icon: "warning",
                    button: "ปิด"
                });
            } else if (edit2_planting_week_dead == "") {
                swal({
                    text: "กรุณากรอกจำนวนต้นไม้ที่ตาย",
                    icon: "warning",
                    button: "ปิด"
                });
            } else {

                $.ajax({
                    method: "POST",
                    url: "./pages/planting/update_week_detail.php",
                    data: {

                        edit2_week_id: edit2_week_id,
                        edit2_planting_week_amount: edit2_planting_week_amount,

                        edit2_planting_week_drug_formula: edit2_planting_week_drug_formula,
                        edit2_planting_week_amount_drug: edit2_planting_week_amount_drug,
                        edit2_planting_week_formula_price: edit2_planting_week_formula_price,

                        edit2_planting_week_material: edit2_planting_week_material,
                        edit2_planting_week_amount_material: edit2_planting_week_amount_material,
                        edit2_planting_week_material_price: edit2_planting_week_material_price,

                        edit2_planting_week_dead: edit2_planting_week_dead,
                        edit2_planting_week_date: edit2_planting_week_date

                    },
                    success: function (data) {
                        console.log(data)
                        swal({
                            text: "แก้ไขข้อมูลเรียบร้อย",
                            icon: "success",
                            button: false
                        })
                        $('#edit_planting_week' + id).modal('toggle');

                        setTimeout(function () {
                            swal.close()
                        }, 1500);
                        console.log(data)


                        var table = $('#plantingTable').DataTable();
                        table.destroy(); //ลบตารางทิ้ง
                        fetch_table1()


                        var table = $('#planting_detailTable').DataTable();
                        table.destroy(); //ลบตารางทิ้ง
                        fetch_modal2(modal_2_dt_id)

                        var table = $('#planting_listTable').DataTable();
                        table.destroy();
                        fetch_planting_detail(dt_id)

                        var table = $('#planting_week_detailTable').DataTable();
                        table.destroy(); //ลบตารางทิ้ง
                        fetch_week_detail(week_detail_ids)

                    }
                });
            }

        } else if (edit2_planting_week_material != "0") {

            if (edit2_planting_week_amount_material == "") {
                swal({
                    text: "กรุณากรอกปริมาณการใช้วัสดุปลูก",
                    icon: "warning",
                    button: "ปิด"
                });

            } else if (edit2_planting_week_dead == "") {
                swal({
                    text: "กรุณากรอกจำนวนต้นไม้ที่ตาย",
                    icon: "warning",
                    button: "ปิด"
                });
            } else {

                $.ajax({
                    method: "POST",
                    url: "./pages/planting/update_week_detail.php",
                    data: {

                        edit2_week_id: edit2_week_id,
                        edit2_planting_week_amount: edit2_planting_week_amount,

                        edit2_planting_week_drug_formula: edit2_planting_week_drug_formula,
                        edit2_planting_week_amount_drug: edit2_planting_week_amount_drug,
                        edit2_planting_week_formula_price: edit2_planting_week_formula_price,

                        edit2_planting_week_material: edit2_planting_week_material,
                        edit2_planting_week_amount_material: edit2_planting_week_amount_material,
                        edit2_planting_week_material_price: edit2_planting_week_material_price,

                        edit2_planting_week_dead: edit2_planting_week_dead,
                        edit2_planting_week_date: edit2_planting_week_date

                    },
                    success: function (data) {
                        console.log(data)
                         swal({
                             text: "แก้ไขข้อมูลเรียบร้อย",
                             icon: "success",
                             button: false
                         })
                         $('#edit_planting_week' + id).modal('toggle');
     
                         setTimeout(function () {
                             swal.close()
                         }, 1500);
                         console.log(data)
     
     
                         var table = $('#plantingTable').DataTable();
                         table.destroy(); //ลบตารางทิ้ง
                         fetch_table1()
     
     
                         var table = $('#planting_detailTable').DataTable();
                         table.destroy(); //ลบตารางทิ้ง
                         fetch_modal2(modal_2_dt_id)
     
                         var table = $('#planting_listTable').DataTable();
                         table.destroy();
                         fetch_planting_detail(dt_id)
     
                         var table = $('#planting_week_detailTable').DataTable();
                         table.destroy(); //ลบตารางทิ้ง
                         fetch_week_detail(week_detail_ids)

                    }
                });
            }
        }
    });

    add_plantings_detailTable()
    function add_plantings_detailTable() {
        var ts = $('#add_plantings_detailTable' + planting_id).DataTable({
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
        ts.on('order.dt search.dt', function () {
            ts.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    function add_plantings_detailTables(id) {
        var ts = $('#add_plantings_detailTable' + planting_id).DataTable({
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
                url: "./pages/planting/fetch_add_planting_detail2.php",
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


    //-- รีเซ็ตค่า ปุ่ม หน้า สัปดาห์--//

    $(document).on("click", "#modal_detail", function (event) {

        $("#in_planting_week_detail")[0].reset();

        $("#in_planting_week_id").val(dt_id)
        $("#in_planting_week_name_plant").val(plant_name)
        $("#in_planting_week_amount_material").attr("disabled", true)
        $("#in_planting_week_material_price").attr("disabled", true)
        $("#hidden1").prop("hidden", true);
        $("#hidden2").prop("hidden", true);
        $("#hidden3").prop("hidden", true);
        $("#hidden4").prop("hidden", true);
        $("#hidden5").prop("hidden", true);

        $("#hidden_formula1").prop("hidden", true);
        $("#hidden_formula2").prop("hidden", true);
        $("#hidden_formula3").prop("hidden", true);
        $("#hidden_formula4").prop("hidden", true);

    });



    $(document).on("click", "#btn_add_planting_details", function (event) {
        var id = $(this).attr("data");
        var order_id = $(this).attr("data-order");

        console.log(id)
        console.log(order_id)

        order_ids = order_id
        planting_id = id

        $("#in_planting2")[0].reset();

        var table = $('#add_plantings_detailTable' + planting_id).DataTable();
        table.destroy();
        add_plantings_detailTable()

    });
    var planting_id;
    var order_ids;


    $(document).on("change", ".in_planting_ordername_detail", function (event) {
        var order_detail_id = $(this).val()
        console.log(order_detail_id)

        if (order_detail_id == "0") {

            $("#in_planting_id_detail" + planting_id).val("")

            var table = $('#add_plantings_detailTable' + planting_id).DataTable();
            table
                .clear()
                .draw();

        } else {
            $.ajax({
                method: "POST",
                url: "./pages/planting/get_planting_id.php",
                data: {

                    id: order_ids,

                },
                success: function (data) {
                    console.log(data)

                    if (data == '') {

                        var sub_data = data.substr(0, 12)
                        var t_id = sub_data + '-' + '01'
                        $('#in_planting_id_detail' + planting_id).val(t_id)
                    } else {

                        var sub_data = data.substr(0, 12)
                        var num = data.substr(13, 2)
                        num = parseInt(num) + 1
                        console.log(sub_data)
                        var t_id = sub_data + '-' + checknumid2(num)
                        $('#in_planting_id_detail' + planting_id).val(t_id)
                    }

                },
            });

            var table = $('#add_plantings_detailTable' + planting_id).DataTable();
            table.destroy();

            add_plantings_detailTables(order_detail_id)
        }

    });

    // เพิ่่ม รหัสยา ให้เป็น -01 //
    function checknumid2(i) {
        if (i < 10) {
            i = "0" + i
        } else {
            i = i
        }
        return i
    }
    $(document).on("click", "#btn_add_planting_detail", function (event) {
        var id = $(this).attr("data-id");
        var order_detail_id = $("#in_planting_ordername_detail" + id).val()
        var planting_detail_id = $("#in_planting_id_detail" + id).val()



        console.log(order_ids);
        console.log(order_detail_id);
        console.log(id)
        console.log(planting_detail_id);

        if (order_detail_id == "0") {
            swal({
                text: "กรุณาเลือกรายการสั่งซื้อ",
                icon: "warning",
                button: "ปิด"
            });
        } else {

            $.ajax({
                method: "POST",
                url: "./pages/planting/insert_planting_detail.php",
                data: {

                    id: id,
                    order_ids: order_ids,
                    order_detail_id: order_detail_id,
                    planting_detail_id: planting_detail_id,

                },
                success: function (data) {
                    swal({
                        text: "บันทึกข้อมูลเรียบร้อย",
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

    $(document).on("click", "#close_modal_add_week_detail", function (event) {
        $("#add_planting_week").modal("toggle");


    });
    var week_detail_id;
    $(document).on("click", "#btn_edit_planting_week", function (event) {
        var id = $(this).attr("data") // week_detail_id
        var week = $(this).attr("week")
        var plant_name = $(this).attr("plant")
        var ref_planting_detail_id = $(this).attr("planting-id")


        week_detail_id = id
        console.log(id)


        $.ajax({
            url: "./pages/planting/fetch_modal_edit_week_detail.php",
            method: "POST",
            data: {
                id: id
            },
            success: function (data) {
                /*   console.log(data) */
                $("#show_modal").html(data)
                $("#edit_planting_week_detail" + id).modal("show")
                $("#edit2_planting_week_id").val(ref_planting_detail_id)
                $("#edit2_week_id").val(id)
                $("#edit2_planting_week_amount").val(week)
                $("#edit2_planting_week_name_plant").val(plant_name)

            }
        });


    });





});