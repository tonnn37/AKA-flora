$(document).ready(function () {

    //---- ตาราง-----//
    var t = $('#permissionsTable').DataTable({
        "responsive": true,
        "lengthChange": false,


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


    //-- insert ชื่อ นามสกุล ---//
    $(document).on("click", "#btn_save_insert", function (event) {

        var insert_testname = $("#insert_testname").val();
        var insert_testlastname = $("#insert_testlastname").val();

        if (insert_testname =="" || insert_testlastname == "") {

            swal({
                text: "กรุณากรอกข้อมูล",
                icon: "warning",
                button: false
            })

        }
        //-- ส่งข้อมูลไป insert ---//
        $.ajax({
            url: "./pages/set/insert_data.php",
            method: "POST",
            data: {
                insert_testname: insert_testname,
                insert_testlastname: insert_testlastname
            },
            success: function (data) {

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
    });


    $(document).on("click", "#btn_remove_set", function (event) {

        var set_id = $(this).attr('data-id')
        var set_status = $(this).attr('data-status')
        var set_name = $(this).attr('data-name')


        if (set_status == 'ปกติ') {
            swal({
                title: "แจ้งเตือน",
                text: " ยกเลิกสิทธิ์ของ : " + set_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //alert(emp_id)
                        $.ajax({
                            url: "./pages/set/remove_set.php",
                            method: "POST",
                            data: {
                                set_id: set_id,
                                set_status: set_status
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
                text: " ยกเลิกการระงับสิทธิ์ของ : " + set_name,
                icon: "warning",
                buttons: ["ยกเลิก", "ยืนยัน"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: "./pages/set/remove_set.php",
                            method: "POST",
                            data: {
                                set_id: set_id,
                                set_status: set_status
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

    $(document).on("click","#btn_save_edit_emp",function(event){

        var id =$(this).attr('data-id');
        var edit_name =$("#edit_testname" + id).val();
        var edit_lastname =$("#edit_testlastname" + id).val();


        if(edit_name =="" || edit_lastname ==""){
            swal({
                text: "กรุณากรอกข้อมูล",
                icon: "warning",
                button: false
            })
        }else{

            $.ajax({
                url: "./pages/set/edit_set.php",
                method: "POST",
                data: {
                    id : id,
                    edit_name: edit_name,
                    edit_lastname: edit_lastname
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
 
                   /*  console.log(data) */
     
             
    
                }
            });





        }
















    });















































});