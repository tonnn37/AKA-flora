$(document).ready(function () {

    fetch_customerTable()

    function fetch_customerTable() {
        var t = $('#customerTable').DataTable({
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
                url: "./pages/customer/fetch_customer.php",
                type: "post",

            }

        });
        t.on('order.dt search.dt', function () {
            t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    $(document).on("click", "#modal_customer", function (event) {

        $("#add_customerForm")[0].reset();

    });


    $("#customer_firstname").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",

            });
            $('#customer_firstname').focus();
            $(this).val("")

        } else {
            $('#customer_lastname').focus();
        }
    });

    $("#customer_lastname").on("change", function () {
        var lastname = $(this).val();
        var firstname = $('.customer_firstname').val();
        lastname = lastname.replace(/ /g, '');
        firstname = firstname.replace(/ /g, '');

        $(this).val(lastname)
        if (!lastname.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else

            $.ajax({
                url: "./pages/customer/check_customer_name.php",
                method: "POST",
                data: {
                    firstname: firstname,
                    lastname: lastname
                },
                success: function (data) {
                    //alert(data)
                    if (data == 0) {
                        swal({
                            text: "ชื่อและนามสกุลถูกใช้ไปแล้ว",
                            icon: "warning",
                            button: "ปิด",
                        });
                        $("#customer_lastname").val("")
                        $("#customer_firstname").val("")
                    }
                }
            });
    });

    $("#customer_firstname").on("change", function () {
        var lastname = $('.customer_lastname').val();
        var firstname = $(this).val();

        if (!firstname.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else

            $.ajax({
                url: "./pages/customer/check_customer_name.php",
                method: "POST",
                data: {
                    firstname: firstname,
                    lastname: lastname
                },
                success: function (data) {
                    //alert(data)
                    if (data == 0) {
                        swal({
                            text: "ชื่อและนามสกุลถูกใช้ไปแล้ว",
                            icon: "warning",
                            button: "ปิด",
                        });
                        $("#customer_lastname").val("")
                        $("#customer_firstname").val("")
                    }
                }
            });
    });

    $("#customer_email").on("change", function () {
        var email = $(this).val();
        email = email.replace(/ /g, '');


        $(this).val(email)
        $.ajax({
            url: "./pages/customer/check_customer_email.php",
            method: "POST",
            data: {
                email: email
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "อีเมลนี้ถูกใช้ไปแล้ว",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#customer_email").val("")

                }
            }
        });
    });

    $(document).on("click", "#btn_add_customer", function (event) {

        var customer_id = $("#customer_id").val();
        var customer_firstname = $("#customer_firstname").val(); //ประกาศตัวแปร//
        var customer_lastname = $("#customer_lastname").val();
        var customer_email = $("#customer_email").val();
        var customer_detail = $("#customer_detail").val();

        if ($('#M').is(':checked')) {
            var gender = "ชาย"
        } else if ($('#W').is(':checked')) {
            var gender = "หญิง"
        } else {
            var gender = ""
        }

        if ($('#in').is(':checked')) {
            var type_hand = "ในประเทศ"
        } else if ($('#out').is(':checked')) {
            var type_hand = "นอกประเทศ"
        } else {
            var type_hand = ""
        }

        if (customer_firstname == "0") {    //ดักข้อมูล ค่าว่าง//

            swal({
                text: "กรุณากรอกชื่อ",
                icon: "warning",
                button: "ปิด"

            });

        } else if (customer_lastname == "") {

            swal({
                text: "กรุณากรอกนามสกุล",
                icon: "warning",
                button: "ปิด"
            });
        } else if (gender == "") {

            swal({
                text: "กรุณาเลือกเพศ",
                icon: "warning",
                button: "ปิด"
            });
        } else if (type_hand == "") {

            swal({
                text: "กรุณาเลือกประเภทลูกค้า",
                icon: "warning",
                button: "ปิด"
            });

        } else if (customer_email == "") {

            swal({
                text: "กรุณากรอกอีเมล",
                icon: "warning",
                button: "ปิด"
            });
        } else {
            $.ajax({
                url: "./pages/customer/insert_customer.php",
                method: "POST",
                data: {
                    customer_id: customer_id,
                    customer_firstname: customer_firstname,
                    customer_lastname: customer_lastname,
                    gender: gender,
                    type_hand : type_hand,
                    customer_email: customer_email,
                    customer_detail: customer_detail
                },
                success: function (data) {
                    swal({
                        text: "บันทึกข้อมูลเรียบร้อยแล้ว",
                        icon: "success",
                        button: false
                    })

                 /*    $("#modal_add_customer").modal("toggle") */

                    setTimeout(function () {
                        location.reload();
                    }, 1500);

/* 
                    var table = $('#customerTable').DataTable();
                    table.destroy();

                    fetch_customerTable() */

                }
            });


        }

    });

    $(document).on("click", "#btn_remove_customer", function (event) {
        var customer_id = $(this).attr('data')
        var customer_status = $(this).attr('data-status')
        var customer_firstname = $(this).attr("data-firstname")
        var customer_lastname = $(this).attr("data-lastname")
        if (customer_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกข้อมูลลูกค้า : " + customer_firstname + " " + customer_lastname,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "./pages/customer/remove_customer.php",
                            method: "POST",
                            data: {
                                customer_id: customer_id,
                                customer_status: customer_status
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
                text: " ยกเลิกการระงับข้อมูลของ : " + customer_firstname + " " + customer_lastname,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/customer/remove_customer.php",
                            method: "POST",
                            data: {
                                customer_id: customer_id,
                                customer_status: customer_status
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

    $(document).on("click","#btn_edit_customers", function(event){

        var  id = $(this).attr("data")
        $("#edit_customerForm"+id)[0].reset();

    });


    $("#customer_firstname").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",

            });
            $('#customer_firstname').focus();
            $(this).val("")

        } else {
            $('#customer_lastname').focus();
        }
    });

    $("#customer_lastname").on("change", function () {
        var lastname = $(this).val();
        var firstname = $('.customer_firstname').val();
        lastname = lastname.replace(/ /g, '');
        firstname = firstname.replace(/ /g, '');

        $(this).val(lastname)
        if (!lastname.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else

            $.ajax({
                url: "./pages/customer/check_customer_name.php",
                method: "POST",
                data: {
                    firstname: firstname,
                    lastname: lastname
                },
                success: function (data) {
                    //alert(data)
                    if (data == 0) {
                        swal({
                            text: "ชื่อและนามสกุลถูกใช้ไปแล้ว",
                            icon: "warning",
                            button: "ปิด",
                        });
                        $("#customer_lastname").val("")
                        $("#customer_firstname").val("")
                    }
                }
            });
    });

    $("#customer_firstname").on("change", function () {
        var lastname = $('.customer_lastname').val();
        var firstname = $(this).val();

        if (!firstname.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else

            $.ajax({
                url: "./pages/customer/check_customer_name.php",
                method: "POST",
                data: {
                    firstname: firstname,
                    lastname: lastname
                },
                success: function (data) {
                    //alert(data)
                    if (data == 0) {
                        swal({
                            text: "ชื่อและนามสกุลถูกใช้ไปแล้ว",
                            icon: "warning",
                            button: "ปิด",
                        });
                        $("#customer_lastname").val("")
                        $("#customer_firstname").val("")
                    }
                }
            });
    });

    $("#customer_email").on("change", function () {
        var email = $(this).val();
        email = email.replace(/ /g, '');


        $(this).val(email)
        $.ajax({
            url: "./pages/customer/check_customer_email.php",
            method: "POST",
            data: {
                email: email
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "อีเมลนี้ถูกใช้ไปแล้ว",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#customer_email").val("")

                }
            }
        });
    });
 
    $(document).on("click", "#btn_edit_customer", function (event) {

        var id = $(this).attr("data-id");
        var edit_customer_firstname = $("#edit_customer_firstname" + id).val();
        var editcustomer_lastname = $("#edit_customer_lastname" + id).val();
        var edit_customer_email = $("#edit_customer_email" + id).val();
        var edit_customer_detail = $("#edit_customer_detail" + id).val();

        if ($('#edit_M' + id).is(':checked')) {
            var edit_gender = "ชาย"
        } else if ($('#edit_W' + id).is(':checked')) {
            var edit_gender = "หญิง"
        } else {
            var edit_gender = ""
        }

        if ($('#edit_in' + id).is(':checked')) {
            var type_hands = "ในประเทศ"
        } else if ($('#edit_out' + id).is(':checked')) {
            var type_hands = "นอกประเทศ"
        } else {
            var type_hands = ""
        }

        if (edit_customer_firstname == "") {    //ดักข้อมูล ค่าว่าง//

            swal({
                text: "กรุณากรอกชื่อ",
                icon: "warning",
                button: "ปิด"

            });

        } else if (editcustomer_lastname == "") {

            swal({
                text: "กรุณากรอกนามสกุล",
                icon: "warning",
                button: "ปิด"
            });

        } else if (edit_customer_email == "") {

            swal({
                text: "กรุณากรอกอีเมล",
                icon: "warning",
                button: "ปิด"
            });
        } else {
            $.ajax({
                url: "./pages/customer/edit_customer.php",
                method: "POST",
                data: {
                    id: id,
                    edit_customer_firstname: edit_customer_firstname,
                    editcustomer_lastname: editcustomer_lastname,
                    edit_gender: edit_gender,
                    type_hand : type_hands,
                    edit_customer_email: edit_customer_email,
                    edit_customer_detail: edit_customer_detail
                },
                success: function (data) {
                    swal({
                        text: "แก้ไขข้อมูลเรียบร้อยแล้ว",
                        icon: "success",
                        button: false
                    })
                    console.log(data)
                /*     $("#modal_edit_customer" + id).modal("toggle") */

                    setTimeout(function () {
                        location.reload();
                    }, 1500);


                }
            });

        }

    });

    $(".edit_customer_firstname").on("change", function () {
        var id = $(this).attr("data-id")
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",

            });
            $('#edit_customer_firstname'+id).focus();
            $(this).val("")

        } else {
            $('#edit_customer_firstname'+id).focus();
        }
    });

    $(".edit_customer_lastname").on("change", function () {
        var id = $(this).attr("data-id")
        var lastname = $(this).val();
        var firstname = $('#edit_customer_firstname'+id).val();
        lastname = lastname.replace(/ /g, '');
        firstname = firstname.replace(/ /g, '');
       

        $(this).val(lastname)
        if (!lastname.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else

            $.ajax({
                url: "./pages/customer/check_customer_name.php",
                method: "POST",
                data: {
                    id : id,
                    firstname: firstname,
                    lastname: lastname
                },
                success: function (data) {
                    //alert(data)
                    if (data == 0) {
                        swal({
                            text: "ชื่อและนามสกุลถูกใช้ไปแล้ว",
                            icon: "warning",
                            button: "ปิด",
                        });
                        $("#edit_customer_lastname"+id).val("")
                        $("#edit_customer_firstname"+id).val("")
                    }
                }
            });
    });

    
    $(".edit_customer_email").on("change", function () {
        var id = $(this).attr("data-id")
        var email = $(this).val();
        email = email.replace(/ /g, '');


        $(this).val(email)
        $.ajax({
            url: "./pages/customer/check_customer_email.php",
            method: "POST",
            data: {
                id : id,
                email: email
            },
            success: function (data) {
                //alert(data)
                if (data == 0) {
                    swal({
                        text: "อีเมลนี้ถูกใช้ไปแล้ว",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $("#edit_customer_email"+id).val("")

                }
            }
        });
    });


});