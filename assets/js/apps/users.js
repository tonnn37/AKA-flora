$(document).ready(function () {

    var t = $('#userTable').DataTable({
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

        }
    });
    t.on('order.dt search.dt', function () {
        t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $.Thailand({
        database: './jquery.Thailand.js/database/db.json',
        $district: $('#address_subdistrict'), // input ของตำบล
        $amphoe: $('#address_district'), // input ของอำเภอ
        $province: $('#address_province'), // input ของจังหวัด
        $zipcode: $('#address_zipcode'), // input ของรหัสไปรษณีย์
    });


        $.Thailand({
            database: './jquery.Thailand.js/database/db.json',
            $district: $('.com_district'), // input ของตำบล
            $amphoe: $('.com_amphoe'), // input ของอำเภอ
            $province: $('.com_province'), // input ของจังหวัด
            $zipcode: $('.edit_address_zipcode'), // input ของรหัสไปรษณีย์
        });



    $("#modal_add_emp").on("click", function (event) {

        $("#myForm")[0].reset();
        $("#address_subdistrict").val("")
        $("#address_district").val("")
        $("#address_province").val("")
        $("#address_zipcode").val("")

    });
    // ---- check error insert ----//

    //---เช็คชื่อ ให้กรอกเฉพาะตัวอักษร + เอาเว้นวรรคออก --//
    $("#firstname").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")

        } else {
            $('#lastname').focus();
        }
    });


    $(document).on("click", "#edit", function (event) {

        var id = $(this).attr('data');

        $("#edit_emp" + id)[0].reset();


    });



    //---เช็คชื่อและนามสกุล ที่ซ้ำในดาต้าเบส --//
    $("#lastname").on("change", function () {
        var lastname = $(this).val();
        var firstname = $('.firstname').val();
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
                url: "./pages/user/check_name_emp.php",
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
                        $("#lastname").val("")
                        $("#firstname").val("")
                    } else {
                        $('#cardid').focus();
                    }
                }
            });
    });


    //-- เช็คเลขบัตรประชาชน --//

    function checkID(id) {
        if (id.length != 13) return false;
        for (i = 0, sum = 0; i < 12; i++)
            sum += parseFloat(id.charAt(i)) * (13 - i); if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
            return false; return true;
    }

    $("#cardid").on("change", function () {
        var cardid = $(this).val();
        cardid = cardid.replace(/ /g, '');
        cardid = cardid.replace(/-/g, '');

        if (cardid.length < 13) {
            swal({
                text: "กรุณากรอกเลขบัตรประชาชน 13 หลัก",
                icon: "warning",
                button: "ปิด",
            });

            $(this).val("")
        } else if (!checkID(cardid)) {
            swal({
                text: "เลขบัตรประชาชนไม่ถูกต้อง",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else {
            $.ajax({
                url: "./pages/user/check_cardid_emp.php",
                method: "POST",
                data: {
                    cardid: cardid
                },
                success: function (data) {
                    //alert(data)
                    if (data == 0) {
                        swal({
                            text: "เลขบัตรประชาชนถูกใช้ไปแล้ว",
                            icon: "warning",
                            button: "ปิด",
                        });
                        $(".cardid").val("")
                    } else {
                        $('#telephone').focus();
                    }
                }
            });
        }
    });

    //-- เช็คเบอร์โทรศัพท์ --//

    function CheckMobileNumber(data) {
        var patt = /^[0]{1}[8,9,6]{1}[0-9]{7,}/
        if (data.match(patt)) {
            return true
        }
        else {
            return false
        }
    }

    $(".tel").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');

        $(this).val(elem)
        if (!elem.match(/^([0-9-])+$/i)) {
            swal({
                text: "กรอกได้เฉพาะตัวเลขเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else {
            if (elem.length > 10) {

                swal({
                    text: "กรุณากรอกเบอร์โทรศัพท์ไม่เกิน 10 หลัก",
                    icon: "warning",
                    button: "ปิด",
                });
                $(this).val("")
            } else if (elem.length < 10) {
                swal({
                    text: "กรุณากรอกเบอร์โทรศัพท์ 10 หลัก",
                    icon: "warning",
                    button: "ปิด",
                });
                $(this).val("")
            } else {
                if (!CheckMobileNumber(elem)) {
                    swal({
                        text: "เบอร์โทรศัพท์ไม่ถูกต้อง",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $(this).val("")
                } else {
                    $.ajax({
                        url: "./pages/user/check_tel_emp.php",
                        method: "POST",
                        data: {
                            elem: elem
                        },
                        success: function (data) {
                            //alert(data)
                            if (data == 0) {
                                swal({
                                    text: "เบอร์โทรศัพท์ถูกใช้งานไปแล้ว",
                                    icon: "warning",
                                    button: "ปิด",
                                });
                                $("#telephone").val("")
                            } else {
                                $('#address_home').focus();
                            }
                        }
                    });

                }
            }

        }
    });


    //-- เช็คบ้านเลขที่ --//
    $("#address_home").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([0-9/-])+$/i)) {
            swal({
                text: "กรอกเฉพาะตัวเลขเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else {
            $('#address_swine').focus();
        }
    });

    //--เช็คหมู่ --//
    $("#address_swine").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([0-9/-])+$/i)) {
            swal({
                text: "กรอกได้เฉพาะ (0-9, / , - ) เท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")

        } else {
            $('#address_alley').focus();
        }
    });

    //-- เช็คซอย --//
    $("#address_alley").on("change", function () {

        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        $('#address_road').focus();

    });

    //-- เช็ค ถนน --//
    $("#address_road").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        $('#address_subdistrict').focus();
    });
    //--เช็ค แขวง--//
    $("#address_subdistrict").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([A-Z a-z ก-๐])+$/i)) {
            swal({
                text: "กรอกได้เฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else {
            $('#address_district').focus();
        }
    });
    //-- เช็ค เขต --//
    $("#address_district").on("change", function () {

        $('#address_province').focus();
    });
    //-- เช็คจังหวัด --//
    $("#address_province").on("change", function () {

        $('#address_zipcode').focus();
    });
    //-- เช็ครหัสไปรษณีย์ --//
    $("#address_zipcode").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([0-9])+$/i)) {
            swal({
                text: "กรอกเฉพาะตัวเลขเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $('#address_zipcode').val("")
        }
    });

    //--- insert emp ---//
    $('.insert').on('submit', function (event) {
        event.preventDefault();

        var firstname = $("#firstname").val()
        var lastname = $("#lastname").val()
        var cardid = $("#cardid").val()

        if ($('#M').is(':checked')) {
            var gender = "ชาย"
        } else if ($('#W').is(':checked')) {
            var gender = "หญิง"
        } else {
            var gender = ""
        }
        var telephone = $("#telephone").val()

        var address_home = $("#address_home").val()
        var address_subdistrict = $("#address_subdistrict").val()
        var address_district = $("#address_district").val()
        var address_province = $("#address_province").val()
        var address_zipcode = $("#address_zipcode").val()
        var pic = $("#pictures").val()
        console.log(pic)
        $('#subdistrict').val(address_subdistrict)
        $('#district').val(address_district)
        $('#province').val(address_province)
        $('#zipcode').val(address_zipcode)
    
        

      /*   if (firstname == "") {
            swal({
                text: "กรุณากรอกชื่อ",
                icon: "warning",
                button: "ปิด",

            })
        } else if (lastname == "") {
            swal({
                text: "กรุณากรอกนามสกุล",
                icon: "warning",
                button: "ปิด",
            })
        } else if (cardid == "") {
            swal({
                text: "กรุณากรอกเลขบัตรประชาชน",
                icon: "warning",
                button: "ปิด",
            })
        } else if (gender == "") {
            swal({
                text: "กรุณาเลือกเพศ",
                icon: "warning",
                button: "ปิด",
            })
        } else if (telephone == "") {
            swal({
                text: "กรุณากรอกเบอร์โทรศัพท์",
                icon: "warning",
                button: "ปิด",
            })
        } else if (address_home == "") {
            swal({
                text: "กรุณากรอกบ้านเลขที่",
                icon: "warning",
                button: "ปิด",
            })
        } else if (address_subdistrict == "") {
            swal({
                text: "กรุณากรอกแขวง/ตำบล",
                icon: "warning",
                button: "ปิด",
            })
        } else if (address_district == "") {
            swal({
                text: "กรุณากรอกเขต/อำเภอ",
                icon: "warning",
                button: "ปิด",
            })
        } else if (address_province == "") {
            swal({
                text: "กรุณากรอกจังหวัด",
                icon: "warning",
                button: "ปิด",
            })
        } else if (address_zipcode == "") {
            swal({
                text: "กรุณากรอกรหัสไปรษณีย์",
                icon: "warning",
                button: "ปิด",
            })

        } else {

            $.ajax({
                url: "insert_emp.php",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (data) {

                    swal({
                        text: "บันทึกเรียบร้อย",
                        icon: "success",
                        button: false,
                    })
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            })
        }
 */
    })

    // ---- check error update ----//

    $(".edits").on("click", function (event) {
        var id = $(this).attr("data")

        $("#edit_emps" + id)[0].reset();
        $.ajax({
            url: "./pages/user/check_name_emp.php",
            method: "POST",
            data: {
                firstname: firstname,
                lastname: lastname
            },
            success: function (data) {
                //alert(data)

                $("#edit_address_subdistrict" + id).val("")
                $("#edit_address_district" + id).val("")
                $("#edit_address_province" + id).val("")
                $("#edit_address_zipcode" + id).val("")
            }
        });



    });

    //---เช็คชื่อ ให้กรอกเฉพาะตัวอักษร + เอาเว้นวรรคออก --//
    $(".edit_firstname").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([A-Za-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        }
    });

    //---เช็คชื่อและนามสกุล ที่ซ้ำในดาต้าเบส --//
    $(".edit_lastname").on("change", function () {
        var id = $(this).attr('data-id');
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([A-Z a-z ก-๐])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else
            var lastname = $(this).val();
        var firstname = $('#edit_firstname' + id).val();
        lastname = lastname.replace(/ /g, '');
        firstname = firstname.replace(/ /g, '');
        $(this).val(elem)
        $(this).val(elem)
        $.ajax({
            url: "./pages/user/check_name_emp.php",
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
                    $("#edit_lastname" + id).val("")
                    $("#edit_firstname" + id).val("")

                }
            }
        });
    });


    //-- เช็คเลขบัตรประชาชน --//

    function checkID(id) {
        if (id.length != 13) return false;
        for (i = 0, sum = 0; i < 12; i++)
            sum += parseFloat(id.charAt(i)) * (13 - i); if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
            return false; return true;
    }

    $(".edit_cardid").on("change", function () {

        var id = $(this).attr('data-id');
        var cardid = $(this).val();
        cardid = cardid.replace(/ /g, '');
        cardid = cardid.replace(/-/g, '');

        if (!cardid.match(/^([0-9])+$/i)) {
            swal({
                text: "กรุณากรอกเฉพาะตัวเลขเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        }
        else if (cardid.length < 13) {
            swal({
                text: "กรุณากรอกเลขบัตรประชาชน 13 หลัก",
                icon: "warning",
                button: "ปิด",
            });

            $(this).val("")
        } else if (!checkID(cardid)) {
            swal({
                text: "เลขบัตรประชาชนไม่ถูกต้อง",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else {
            $.ajax({
                url: "./pages/user/check_cardid_emp.php",
                method: "POST",
                data: {
                    cardid: cardid
                },
                success: function (data) {
                    //alert(data)
                    if (data == 0) {
                        swal({
                            text: "เลขบัตรประชาชนถูกใช้ไปแล้ว",
                            icon: "warning",
                            button: "ปิด",
                        });
                        $("#a" + id).val("")
                    }
                }
            });
        }
    });

    //-- เช็คเบอร์โทรศัพท์ --//

    function CheckMobileNumber(data) {
        var patt = /^[0]{1}[8,9,6]{1}[0-9]{7,}/
        if (data.match(patt)) {
            return true
        }
        else {
            return false
        }
    }

    $(".edit_telephone").on("change", function () {
        var id = $(this).attr('data-id');
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');

        $(this).val(elem)
        if (!elem.match(/^([0-9-])+$/i)) {
            swal({
                text: "กรอกได้เฉพาะตัวเลขเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        } else {
            if (elem.length > 10) {

                swal({
                    text: "กรุณากรอกเบอร์โทรศัพท์ไม่เกิน 10 หลัก",
                    icon: "warning",
                    button: "ปิด",
                });
                $(this).val("")
            } else if (elem.length < 10) {
                swal({
                    text: "กรุณากรอกเบอร์โทรศัพท์ 10 หลัก",
                    icon: "warning",
                    button: "ปิด",
                });
                $(this).val("")
            } else {
                if (!CheckMobileNumber(elem)) {
                    swal({
                        text: "เบอร์โทรศัพท์ไม่ถูกต้อง",
                        icon: "warning",
                        button: "ปิด",
                    });
                    $(this).val("")
                } else {
                    $.ajax({
                        url: "./pages/user/check_tel_emp.php",
                        method: "POST",
                        data: {
                            elem: elem
                        },
                        success: function (data) {
                            //alert(data)
                            if (data == 0) {
                                swal({
                                    text: "เบอร์โทรศัพท์ถูกใช้งานไปแล้ว",
                                    icon: "warning",
                                    button: "ปิด",
                                });
                                $("#edit_telephone" + id).val("")
                            }
                        }
                    });

                }
            }

        }
    });


    //-- เช็คบ้านเลขที่ --//
    $(".edit_address_home").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([0-9/-])+$/i)) {
            swal({
                text: "กรอกเฉพาะตัวเลขเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        }
    });

    //--เช็คหมู่ --//
    $(".edit_address_swine").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([0-9/-])+$/i)) {
            swal({
                text: "กรอกได้เฉพาะ (0-9, / , - ) เท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")

        }
    });

    //-- เช็คซอย --//
    $(".edit_address_alley").on("change", function () {

        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)


    });

    //-- เช็ค ถนน --//
    $(".edit_address_road").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
    });
    //--เช็ค แขวง--//
    $(".edit_address_subdistrict").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([A-Z a-z ก-๐])+$/i)) {
            swal({
                text: "กรอกได้เฉพาะตัวอักษรเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        }
    });
    //-- เช็ค เขต --//
    $(".edit_address_district").on("change", function () {

    });
    //-- เช็คจังหวัด --//
    $(".edit_address_province").on("change", function () {


    });
    //-- เช็ครหัสไปรษณีย์ --//
    $(".edit_address_zipcode").on("change", function () {
        var elem = $(this).val();
        elem = elem.replace(/ /g, '');
        $(this).val(elem)
        if (!elem.match(/^([0-9])+$/i)) {
            swal({
                text: "กรอกเฉพาะตัวเลขเท่านั้น",
                icon: "warning",
                button: "ปิด",
            });
            $(this).val("")
        }
    });
    //--- update emp ---//

    $('.Update').on('submit', function (event) {

        event.preventDefault();

        var id = $(this).attr('data');
        var firstname = $('#edit_firstname' + id).val();
        var lastname = $('#edit_lastname' + id).val();
        var cardid = $('#a' + id).val();
        var telephone = $('#edit_telephone' + id).val();


        var address_home = $('#edit_address_home' + id).val();
        var address_subdistrict = $('#edit_address_subdistrict' + id).val();
        var address_district = $('#edit_address_district' + id).val();
        var address_province = $('#edit_address_province' + id).val();
        var address_zipcode = $('#edit_address_zipcode' + id).val();



        var gender;

        if ($('#edit_M' + id).is(':checked')) {
            gender = "ชาย";
        } else if ($('#edit_F' + id).is(':checked')) {
            gender = "หญิง";
        }
        cardid = cardid.replace(/-/g, "");

        if (firstname == "") {
            swal({
                text: "กรุณากรอกชื่อ",
                icon: "warning",
                button: "ปิด",

            })
        } else if (lastname == "") {
            swal({
                text: "กรุณากรอกนามสกุล",
                icon: "warning",
                button: "ปิด",
            })
        } else if (cardid == "") {
            swal({
                text: "กรุณากรอกเลขบัตรประชาชน",
                icon: "warning",
                button: "ปิด",
            })
        } else if (gender == "") {
            swal({
                text: "กรุณาเลือกเพศ",
                icon: "warning",
                button: "ปิด",
            })
        } else if (telephone == "") {
            swal({
                text: "กรุณากรอกเบอร์โทรศัพท์",
                icon: "warning",
                button: "ปิด",
            })
        } else if (address_home == "") {
            swal({
                text: "กรุณากรอกบ้านเลขที่",
                icon: "warning",
                button: "ปิด",
            })
        } else if (address_subdistrict == "") {
            swal({
                text: "กรุณากรอกแขวง/ตำบล",
                icon: "warning",
                button: "ปิด",
            })
        } else if (address_district == "") {
            swal({
                text: "กรุณากรอกเขต/อำเภอ",
                icon: "warning",
                button: "ปิด",
            })
        } else if (address_province == "") {
            swal({
                text: "กรุณากรอกจังหวัด",
                icon: "warning",
                button: "ปิด",
            })
        } else if (address_zipcode == "") {
            swal({
                text: "กรุณากรอกรหัสไปรษณีย์",
                icon: "warning",
                button: "ปิด",
            })

        } else {
              $('#hd_subdistrict' + id).val(address_district)
              $('#hd_district' + id).val(address_subdistrict)
              $('#hd_province' + id).val(address_province)
              $('#hd_zipcode' + id).val(address_zipcode)


            $.ajax({
                url: "update_emp.php",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (data) {

                    swal({
                        text: "แก้ไขข้อมูลเรียบร้อย",
                        icon: "success",
                        button: false,
                    })
                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                }
            });

        }

    });


    //---- Remove emp-----//
    $(document).on("click", "#btn_remove_emp", function (event) {
        var empid = $(this).attr('data-id')
        var empstatus = $(this).attr('data-status')
        var name = $(this).attr("data-name")
        if (empstatus == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกข้อมูลพนักงาน : " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "pages/user/remove_emp.php",
                            method: "POST",
                            data: {
                                empid: empid,
                                empstatus: empstatus
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
                text: " ยกเลิกการระงับข้อมูลพนักงาน " + name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/user/remove_emp.php",
                            method: "POST",
                            data: {
                                empid: empid,
                                empstatus: empstatus
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
    $('#pictures').checkFileType({
        allowedExtensions: ['png', 'jpg', 'jpeg', 'gif'],
        success: function () {

        },
        error: function () {
            swal({
                text: "กรุณาเลือกไฟล์รูปภาพ (png, jpg, jpeg)",
                icon: "warning",
                button: "ปิด"
            })
            $('#pictures').val("");
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
    var fileupload = $("#pictures");
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
$(document).on("click", "#edits", function (event) {
    id_img = $(this).attr('data')
    console.log(id_img)
});



$(function () {
    $('.fileUpload').checkFileType({
        allowedExtensions: ['png', 'jpg', 'jpeg', 'gif'],
        success: function () {


        },
        error: function () {
            swal({
                text: "กรุณาเลือกไฟล์รูปภาพ (png, jpg, jpeg)",
                icon: "warning",
                button: "ปิด"
            })
            $('.fileUpload').val("");
        }
    });
});





 function readURL2(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#edit_img' + id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
  
}


$(document).on("click", ".edit_img", function (event) {

    $("#fileUpload" + id_img).click();
    $('#fileUpload' + id_img).change(function () {
    /*     var fileName = $(this).val().split('\')[$(this).val().split('\').length - 1]; */
        readURL2(this, id_img);

    });
});
/* 
//แก้ไขรูป
$(function () {
    var filePath = $("#showspan" + id_img);
    var image = $(".edit_img");
    image.click(function () {
        $("#fileUpload" + id_img).click();

    });

});  */

