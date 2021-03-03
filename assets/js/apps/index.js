$(document).ready(function () {

    var t = $('#tb_order_all').DataTable({
        "responsive": true,
        "lengthChange": false,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            {
                targets: 4,
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
            url: "./pages/index/fetch_order.php",
            type: "post",

        }
    });
    t.on('order.dt search.dt', function () {
        t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    function fetch_order_detail(id) {
        var ta = $('#tb_view_order_all').DataTable({
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
                    targets: 9,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ระงับ") {
                            color = 'red';
                        } else if (data == "รอส่งมอบ") {
                            color = "#CC00FF"
                        } else if (data == "เสร็จสิ้น") {
                            color = "green"
                        } else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 8,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "เสร็จสิ้น") {
                            color = 'green';
                        } else if (data == "กำลังทำการปลูก") {
                            color = 'blue';
                        }
                        else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 7,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "สิ้นสุด") {
                            color = 'red';
                        } else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 8,
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
                    targets: 6,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'green';
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
                {
                    targets: 4,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'red';
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
                url: "./pages/index/fetch_order_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }

            }
        });
        ta.on('order.dt search.dt', function () {
            ta.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    }

    var y = $('#tb_order_not_planting').DataTable({
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
                targets: 8,
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
                targets: 6,
                className: 'dt-body-right',
                render: function (data, type, row) {
                    var color = 'green';
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
            {
                targets: 4,
                className: 'dt-body-right',
                render: function (data, type, row) {
                    var color = 'red';
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
            url: "./pages/index/fetch_order_not_planting.php",
            type: "post",

        }

    });
    y.on('order.dt search.dt', function () {
        y.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    function fetch_order_not_planting(id) {
        var ya = $('#tb_order_not_planting_detail').DataTable({
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
                    targets: 9,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ระงับ") {
                            color = 'red';
                        } else if (data == "รอส่งมอบ") {
                            color = "blue"
                        } else if (data == "เสร็จสิ้น") {
                            color = "green"
                        } else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 8,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "เสร็จสิ้น") {
                            color = 'green';
                        } else if (data == "กำลังทำการปลูก") {
                            color = 'blue';
                        }
                        else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 7,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "สิ้นสุด") {
                            color = 'red';
                        } else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 8,
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
                    targets: 6,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'green';
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
                {
                    targets: 4,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'red';
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
                url: "./pages/index/fetch_order_not_planting_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }

            }

        });
        ya.on('order.dt search.dt', function () {
            ya.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    var p = $('#tb_order_planting').DataTable({
        "responsive": true,
        "lengthChange": false,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            {
                targets: 4,
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
            url: "./pages/index/fetch_order_planting.php",
            type: "post",

        }

    });
    p.on('order.dt search.dt', function () {
        p.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    function fetch_order_planting_detail(id) {
        var pa = $('#tb_order_planting_detail').DataTable({
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
                    targets: 9,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ระงับ") {
                            color = 'red';
                        } else if (data == "รอส่งมอบ") {
                            color = "blue"
                        } else if (data == "เสร็จสิ้น") {
                            color = "green"
                        } else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 8,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "เสร็จสิ้น") {
                            color = 'green';
                        } else if (data == "กำลังทำการปลูก") {
                            color = 'blue';
                        }
                        else {
                            color = "black"
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 7,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "สิ้นสุด") {
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
                url: "./pages/index/fetch_order_planting_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }

            }

        });
        pa.on('order.dt search.dt', function () {
            pa.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    var planting = $('#tb_planting').DataTable({
        retrieve: true,
        paging: true,

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

                    } else {
                        color = "black"
                    }
                    return '<span style="color:' + color + '">' + data + '</span>';
                }
            },
            {
                targets: 5,
                className: 'dt-body-right',
                render: function (data, type, row) {
                    var color = 'red';
                    return '<span style="color:' + color + '">' + data + '</span>';
                }
            }, {
                targets: 6,
                className: 'dt-body-right'
                ,
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
            url: "./pages/index/fetch_planting.php",
            type: "post",

        }
    })
    planting.on('order.dt search.dt', function () {
        planting.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    function fetch_planting_detail(id) {
        var a = $('#tb_planting_detail').DataTable({
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
                url: "./pages/index/fetch_planting_detail.php",
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

    function fetch_planting_list(id) {

        var a = $('#tb_planting_list').DataTable({
            retrieve: true,
            paging: true,

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
                url: "./pages/index/fetch_planting_list.php",
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



    function fetch_planting_list_detail(id) {

        var a = $('#tb_planting_list_detail').DataTable({
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
                url: "./pages/index/fetch_planting_list_detail.php",
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



    var stock = $('#tb_recieve').DataTable({
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
                        color = "red";
                    } else if (data == "เสร็จสิ้น") {
                        color = "green";
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
            url: "./pages/index/fetch_recieve.php",
            type: "post",

        }

    });
    stock.on('order.dt search.dt', function () {
        stock.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();


    function fetch_recieve_detail(id) {
        var a = $('#tb_recieve_detail').DataTable({
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
                    targets: 8,
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
                    targets: 6,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'green';
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
                {
                    targets: 4,
                    className: 'dt-body-right',
                    render: function (data, type, row) {
                        var color = 'red';
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
                url: "./pages/index/fetch_recieve_detail.php",
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


    var handover = $('#tb_handover').DataTable({
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
                        color = "red";
                    } else if (data == "เสร็จสิ้น") {
                        color = "green";
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
            url: "./pages/index/fetch_handover.php",
            type: "post",

        }

    });
    handover.on('order.dt search.dt', function () {
        handover.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    function fetch_handover_detail(id) {
        var handoverd = $('#tb_handover_detail').DataTable({
            "responsive": true,
            "lengthChange": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                {
                    targets: 9,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "ระงับ") {
                            color = "red";
                        } else if (data == "รอส่งมอบ") {
                            color = "#CC00FF";
                        } else {
                            color = "black";
                        }
                        return '<span style="color:' + color + '">' + data + '</span>';
                    }
                },
                {
                    targets: 8,
                    render: function (data, type, row) {
                        var color = 'black';
                        if (data == "กำลังทำการปลูก") {
                            color = 'blue';
                        }
                        else {
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
                url: "./pages/index/fetch_handover_detail.php",
                type: "post",
                "data": function (d) {
                    d.extra_search = id
                }
            }

        });
        handoverd.on('order.dt search.dt', function () {
            handoverd.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    }
    $(document).on("click", "#btn_view_order_all", function (event) {
        var id = $(this).attr("data-id");
        console.log(id)

        var table = $('#tb_view_order_all').DataTable();
        table.destroy();
        fetch_order_detail(id);

    });

    $(document).on("click", "#btn_order_not_planting", function (event) {
        var id = $(this).attr("data-id");
        console.log(id)

        var table = $('#tb_order_not_planting_detail').DataTable();
        table.destroy();

        fetch_order_not_planting(id);

    });

    $(document).on("click", "#btn_order_planting_detail", function (event) {
        var id = $(this).attr("data-id");
        console.log(id)

        var table = $('#tb_order_planting_detail').DataTable();
        table.destroy();

        fetch_order_planting_detail(id);

    });

    $(document).on("click", "#btn_view_planting", function (event) {
        var id = $(this).attr("data-id");
        console.log(id)

        var table = $('#tb_planting_detail').DataTable();
        table.destroy();

        fetch_planting_detail(id);

    });

    $(document).on("click", "#btn_view_planting_list", function (event) {
        var id = $(this).attr("data-id");
        console.log(id)

        var table = $('#tb_planting_list').DataTable();
        table.destroy();

        fetch_planting_list(id);

    });

    $(document).on("click", "#btn_planting_week_detail", function (event) {
        var id = $(this).attr("data-id");
        console.log(id)

        var table = $('#tb_planting_list_detail').DataTable();
        table.destroy();

        fetch_planting_list_detail(id);

    });

    $(document).on("click", "#btn_view_recieve_detail", function (event) {
        var id = $(this).attr("data-id");
        console.log(id)

        var table = $('#tb_recieve_detail').DataTable();
        table.destroy();

        fetch_recieve_detail(id);

    });

    $(document).on("click", "#btn_handover_detail", function (event) {
        var id = $(this).attr("data-id");
        console.log(id)

        var table = $('#tb_handover_detail').DataTable();
        table.destroy();

        fetch_handover_detail(id);

    });



});