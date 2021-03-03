$(document).ready(function () {



    fetch_plantTable()
    //---- ตาราง-----//
    function fetch_plantTable() {
        var plant = $('#plantTable').DataTable({
            "responsive": true,
            "lengthChange": false,

            "columnDefs": [


                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 5,
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
                url: "./pages/plant/fetch_plant.php",
                type: "post",

            }
        });
        plant.on('order.dt search.dt', function () {
            plant.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    function fetch_plant_detailTable(id) {
        var plants = $('#plant_detailTable').DataTable({
            "responsive": true,
            "lengthChange": false,

            "columnDefs": [


                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 2,
                    className: 'dt-body-right'
                },
                {
                    targets: 3,
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
                url: "./pages/plant/fetch_plant_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }
            }
        });
        plants.on('order.dt search.dt', function () {
            plants.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    }


    //--- เช็คชื่อพันธุ์ไม้ซ้ำ ปุ่มเพิ่มข้อมูลพันธุ์ไม้ ---//
    $(".plantname").on("change", function (event) {

        var insert_plant_name = $(this).val();
        var insert_plant_typename = $("#insert_plant_typename").val();
        insert_plant_name = insert_plant_name.replace(/ /g, '');
        $(this).val(insert_plant_name)
        $.ajax({
            url: "./pages/plant/check_insert_plant.php",
            method: "POST",
            data: {

                insert_plant_name: insert_plant_name,
                insert_plant_typename: insert_plant_typename

            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "ชื่อพันธุ์ไม้นี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด"
                    });
                    $("#insert_plant_name").val("");
                    $(this).focus();
                }
            }
        });

    });

    $("#insert_plant_typename").on("change", function (event) {

        $("#insert_plant_name").val("")

    });


    $(".add_plant_grade").on("change", function (event) {

        var plant_id = $(this).attr("data");
        var id = $(this).val();
        console.log(id)

        if (this.checked) {

            $("#add_plant_grade_price" + id + plant_id).attr("disabled", false);
        } else {

            $("#add_plant_grade_price" + id + plant_id).attr("disabled", true);
            $("#add_plant_grade_price" + id + plant_id).val("");
        }
    });



    $(".add_plant_grade_price").change(function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();

        if (!elem.match(/^([0-9 /.])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนราคาเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }
    });

    //-- รีเซ็ตค่า --//
 $(document).on("click", "#btn_plant", function (event) {

   

    $("#insert_plant" )[0].reset();
    $('#add_picture_img').attr('src', "image/upload.PNG");

});


    //--- ตรวจสอบ insert plant --- //
    $(".plantname").on("change", function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        if (!elem.match(/^([ก-๐ a-z])+$/i)) {
            swal({
                text: "กรุณากรอกข้อมูลเป็นตัวอักษร",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }
    });


    $(".planttime").on("change", function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
       
        if (!elem.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกข้อมุลเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("")
            $(this).focus();
            return false;
           
    }
    });
  
    $(document).on("click", "#add_plant2", function (event) {
        var id = $(this).attr("data");
        console.log(id)

        $.ajax({
            url: "./pages/plant/fetch_grade.php",
            method: "POST",
            data: {

                id: id

            },
            success: function (html) {
                console.log(html)
                if (html == 0) {
                    $("#show" + id).html("คุณเพิ่มเกรดและราคาครบแล้ว");
                    $("#show" + id).css('color', 'red');

                    $(".btn_add_plant").attr("disabled", true);

                }else{
                    $(".btn_add_plant").attr("disabled", false);
                }
              
            }
        });


    });

    $(document).on("click", "#btn_add_plant", function (event) {
        var id = $(this).attr("data-id");

        var grade = []
        var price = []
        $('.add_plant_grade:checked').each(function (i) {

            grade[i] = $(this).val()
        });
        $('.add_plant_grade_price').each(function (i) {

            if ($(this).val() != "") {
                price[i] = $(this).val()
            }
        });
        var grades = grade.filter(function (el) {
            return el != "empty";
        });

        var prices = price.filter(function (el) {
            return el != "empty";
        });
        console.log(id)
        console.log(grade)
        console.log(prices)

        if (grades.length != prices.length) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณากรอกราคาต้นไม้ของเกรดที่เลือก",
                icon: "warning",
                buttons: "ปิด",
            })
        } else if (grades.length == 0 && prices.length == 0) {
            swal({
                title: "แจ้งเตือน",
                text: "กรุณาเลือกเกรดพันธุ์ไม้และกรอกราคา",
                icon: "warning",
                buttons: "ปิด",
            })
        } else {

            $.ajax({
                url: "./pages/plant/insert_plant_price.php",
                method: "POST",
                data: {
                    plant_id: id,
                    grade: grades,
                    price: prices

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


    //--- insert plant ---//
    $('.insert').on('submit', function (event) {
        event.preventDefault();

        var insert_plant_typename = $("#insert_plant_typename").val(); //ประกาศตัวแปร//
        var insert_plant_name = $("#insert_plant_name").val();
        var insert_plant_time = $("#insert_plant_time").val();
        var insert_plant_detail = $("#insert_plant_detail").val();


        if (insert_plant_typename == "0") {    //ดักข้อมูล ค่าว่าง//

            swal({
                text: "กรุณาเลือกประเภทพันธุ์ไม้",
                icon: "warning",
                button: "ปิด"

            });

        } else if (insert_plant_name == "") {

            swal({
                text: "กรุณากรอกชื่อพันธุ์ไม้",
                icon: "warning",
                button: "ปิด"
            });
        } else if (insert_plant_time == "") {

            swal({
                text: "กรุณากรอกระยะเวลาการปลูก",
                icon: "warning",
                button: "ปิด"
            });

        } else if (insert_plant_detail == "") {

            swal({
                text: "กรุณากรอกคุณลักษณะพันธุ์ไม้",
                icon: "warning",
                button: "ปิด"
            });

        } else {

            $.ajax({
                url: "insert_plant.php",
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

                    console.log(data)
                }
            })

        }
    });

 


    //ยกเลิกข้อมูลพันธุ์ไม้//
    $(document).on("click", "#btn_remove_plant", function (event) {
        var plant_id = $(this).attr('data')
        var plant_status = $(this).attr('data-status')
        var plant_name = $(this).attr('data-name')

        if (plant_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: "ยกเลิกข้อมูล : " + plant_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/plant/remove_plant.php",
                            method: "POST",
                            data: {
                                plant_id: plant_id,
                                plant_status: plant_status
                            },
                            success: function (data) {
                                console.log(data)
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
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
                text: " ยกเลิกการระงับข้อมูล: " + plant_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/plant/remove_plant.php",
                            method: "POST",
                            data: {
                                plant_id: plant_id,
                                plant_status: plant_status
                            },
                            success: function (data) {
                                console.log(data)
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


//-- รีเซ็ตค่า --//
$(document).on("click", "#edit_plant", function (event) {

    var id = $(this).attr('data');

    $("#edit_plant" + id)[0].reset();


});

    //--- เช็คชื่อข้อมูลพันธุ์ไม้ ปุ่มแก้ไขข้อมูลพันธุ์ไม้ ---//
    $(".edit_plant_name").on("change", function (event) {
        var id = $(this).attr('data-id');
        var edit_plant_name = $("#edit_plant_name" + id).val();
        var edit_plant_typename = $("#edit_plant_typename" + id).val();


        $.ajax({
            url: "./pages/plant/check_edit_plant.php",
            method: "POST",
            data: {
                id : id,
                edit_plant_name: edit_plant_name,
                edit_plant_typename: edit_plant_typename

            },
            success: function (data) {
                if (data == 1) {
                    swal({
                        text: "ชื่อพันธุ์ไม้นี้มีอยู่แล้ว กรุณากรอกใหม่",
                        icon: "warning",
                        button: "ปิด"
                    });
                    $("#edit_plant_name" + id).val("");
                    $(this).focus();
                }
            }
        });

    });

    //--- ตรวจสอบ update plant --- //

    $(".edit_plant_time").on("change", function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();
        if (!elem.match(/^([0-9 / .])+$/i)) {
            swal({
                text: "กรุณากรอกข้อมูลเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }
    });


    //--- update plant ---// 
    $(".Update").on("submit", function (event) {
        event.preventDefault();

        var id = $(this).attr('data-id');
        var edit_plant_typename = $("#edit_plant_typename" + id).val();
        var edit_plant_name = $("#edit_plant_name" + id).val();
        var edit_plant_time = $("#edit_plant_time" + id).val();
        var edit_plant_detail = $("#edit_plant_detail" + id).val();



        if (edit_plant_typename == "0") {    //ดักข้อมูล ค่าว่าง//

            swal({
                text: "กรุณาเลือกประเภทพันธุ์ไม้",
                icon: "warning",
                button: "ปิด"

            });

        } else if (edit_plant_name == "") {

            swal({
                text: "กรุณากรอกชื่อพันธุ์ไม้",
                icon: "warning",
                button: "ปิด"
            });

        } else if (edit_plant_time == "") {

            swal({
                text: "กรุณากรอกระยะเวลาการปลูก",
                icon: "warning",
                button: "ปิด"
            });

        } else if (edit_plant_detail == "") {

            swal({
                text: "กรุณากรอกคุณลักษณะพันธุ์ไม้",
                icon: "warning",
                button: "ปิด"
            });

        } else {

            $.ajax({
                url: "update_plant.php",
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
                    console.log(data)

                }
            });
        }
    });

    $(document).on("click", "#detail_plant", function (event) {
        var id = $(this).attr("data");
        var name = $(this).attr("data-name");
        console.log(id)
        console.log(name)
        $("#detail_name2").text(name)
        var table = $("#plant_detailTable").DataTable()
        table.destroy()
        fetch_plant_detailTable(id)

        plant_detail_id = id
    });

    var plant_detail_id;

    $(".edit_detail_price").change(function () { //เช็คจำนวนเป็นตัวเลขเท่านั้น
        var elem = $(this).val();

        if (!elem.match(/^([0-9 /.])+$/i)) {
            swal({
                text: "กรุณากรอกจำนวนราคาเป็นตัวเลข",
                icon: "warning",
                button: "ปิด"
            });
            $(this).val("");
            $(this).focus();
            return false;
        }
    });

    $(document).on("click", "#reset_edit_detail", function (event) {
        var id = $(this).attr("data");
        console.log(id)


        $(".edit_details")[0].reset();

    });
    

    $(document).on("click", "#btn_edit_detail", function (event) {
        var id = $(this).attr("data-id");
        var grade_id = $("#edit_detail_grade" + id).val();

        var edit_grade_price = $("#edit_detail_price" + grade_id + id).val();
        console.log(id);
        console.log(grade_id);
        console.log(edit_grade_price);

        if (edit_grade_price == "") {
            swal({
                text: "กรุณากรอกจำนวนราคา",
                icon: "warning",
                button: "ปิด"
            });
        } else {
            $.ajax({
                url: "./pages/plant/edit_plant_price.php",
                method: "POST",
                data: {
                    id: id,
                    grade_id: grade_id,
                    edit_grade_price: edit_grade_price

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

                    $("#edit_detail" + id).modal("toggle");
                    var table = $("#plant_detailTable").DataTable()
                    table.destroy()
                    fetch_plant_detailTable(plant_detail_id)

                }
            });
        }
    });

    $(document).on("click", "#btn_remove_plant_detail", function (event) {
        var plant_detail_ids = $(this).attr('data')
        var plant_detail_status = $(this).attr('data-status')
        var grade_name = $(this).attr('data-name')

        if (plant_detail_status == 'ปกติ') {
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
                            url: "./pages/plant/remove_plant_detail.php",
                            method: "POST",
                            data: {
                                plant_detail_ids: plant_detail_ids,
                                plant_detail_status: plant_detail_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                  
                                    var table = $("#plant_detailTable").DataTable()
                                    table.destroy()
                                    fetch_plant_detailTable(plant_detail_id)
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
                            url: "./pages/plant/remove_plant_detail.php",
                            method: "POST",
                            data: {
                                plant_detail_ids: plant_detail_ids,
                                plant_detail_status: plant_detail_status
                            },
                            success: function (data) {
                                swal({

                                    text: "ยกเลิกการระงับข้อมูลเรียบร้อย",
                                    icon: "success",
                                    button: false,
                                });
                                setTimeout(function () {
                                   
                                    var table = $("#plant_detailTable").DataTable()
                                    table.destroy()
                                    fetch_plant_detailTable(plant_detail_id)
                                    swal.close()
                                    console.log(data)
                                }, 1500);
                            }
                        });
                    } else {
                        swal.close()
                    }
                });
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
                text: "กรุณาเลือกไฟล์รูปภาพ (png, jpg, jpeg)",
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
$(document).on("click", "#edit_plant", function (event) {
    id_img = $(this).attr('data')
    console.log(id_img)
});



$(function () {
    $('.picture').checkFileType({
        allowedExtensions: ['png', 'jpg', 'jpeg', 'gif'],
        success: function () {


        },
        error: function () {
            swal({
                text: "กรุณาเลือกไฟล์รูปภาพ (png, jpg, jpeg)",
                icon: "warning",
                button: "ปิด"
            })
            $('.picture').val("");
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