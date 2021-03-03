$(document).ready(function () {

    //---- ตารางรายการ-----//
    stock_table();

    function stock_table() {

        var ta = $('#stockTable').DataTable({
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
                url: "./pages/stock/fetch_stock.php",
                type: "post",

            }
        });
        ta.on('order.dt search.dt', function () {
            ta.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }


    function stock_detailtable(id) {

        var detail = $('#stock_detailTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 3,
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
                url: "./pages/stock/fetch_stock_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }
            }

        });
        detail.on('order.dt search.dt', function () {
            detail.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }
    $(document).on("click", "#btn_viewstock_detail", function (event) {

        var table = $('#stock_detailTable').DataTable();
        table.destroy();
        var id = $(this).attr("data")
        var name = $(this).attr("data-name")

        console.log(id)
        console.log(name)
        /*     var status = $(this).attr("data-status")
           
     */
        $("#detail_name").text(name)
        stock_detail_id = id
        stock_detailtable(id)


    });

    var stock_detail_id;

    $(document).on("click", "#btn_remove_stock", function (event) {
        var stock_id = $(this).attr('data')
        var stock_status = $(this).attr('data-status')
        var grade_name = $(this).attr("data-name")
        if (stock_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลเกรด : " + grade_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "pages/stock/remove_stock_detail.php",
                            method: "POST",
                            data: {
                                stock_id: stock_id,
                                stock_status: stock_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    var table = $('#stockTable').DataTable();
                                    table.destroy();
                                    stock_table();

                                    var table = $('#stock_detailTable').DataTable();
                                    table.destroy();
                                    stock_detailtable(stock_detail_id);

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
                text: " ยกเลิกการระงับข้อมูลเกรด : " + grade_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "pages/stock/remove_stock_detail.php",
                            method: "POST",
                            data: {
                                stock_id: stock_id,
                                stock_status: stock_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกการระงับข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                    var table = $('#stockTable').DataTable();
                                    table.destroy();
                                    stock_table();

                                    var table = $('#stock_detailTable').DataTable();
                                    table.destroy();
                                    stock_detailtable(stock_detail_id);

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

    $(document).on("change", "#in_stock_plant_id", function (event) {
        var id = $(this).val()

        console.log(id)
        $.ajax({
            type: 'POST',
            url: './pages/stock/get_stock.php',
            data: 'id=' + id,
            success: function (data) {
                console.log(data)
                $("#in_stock_grade_amount").val(data)
            }
        });

    });

 
    $(document).on("click", "#btn_editstock_detail", function (event) {
        var id = $(this).attr("data");
        var amount = $(this).attr("data-amount");
        var grade = $(this).attr("data-grade");
        console.log(id)
        console.log(amount)
        console.log(grade)
        $(".edit_details")[0].reset();

        $("#edit_detail_amount"+ grade +id).val(amount)

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

        var id = $(this).attr("data-id")

        var edit_detail_grade = $("#edit_detail_grade" + id).val()
        var edit_detail_amount = $("#edit_detail_amount" + edit_detail_grade + id).val()

        if(edit_detail_amount == ""){
            swal({
                text: "กรุณากรอกจำนวนต้นไม้",
                icon: "warning",
                button: "ปิด"

            });

        }else{

            $.ajax({
                url: "./pages/stock/edit_plant_amount.php",
                method: "POST",
                data: {
                    id: id,
                    edit_detail_grade: edit_detail_grade,
                    edit_detail_amount: edit_detail_amount

                },
                success: function (data) {
                    console.log(data)
                    swal({
                        text: "แก้ไขข้อมูลเรียบร้อย",
                        icon: "success",
                        button: false
                    })
                    setTimeout(function () {
                        swal.close()
                    }, 1500);

                    $("#edit_stock_detail" + id).modal("toggle");
                    var table = $("#stock_detailTable").DataTable()
                    table.destroy()
                    stock_detailtable(stock_detail_id)

                }
            });

        }

    });

});