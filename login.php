<?php
include('connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>NTK Nursery</title>
	<meta charset="UTF-8">
	<!-- Favicon -->
	<link rel="icon" href="assets/img/brand/NTK.png" type="image/png">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor1/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor1/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor1/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor1/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css1/main.css">
	<link rel="stylesheet" type="text/css" href="assets/css1/util.css">

	<!--===============================================================================================-->

</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

				<form action="login.php" method="post" class="login100-form validate-form">

					<div class="login100-pic js-tilt" data-tilt>
						<img src="image/akalogo.png" alt="IMG" type="image/png" width="300px" height="200px">
					</div><br>
					<span class="login100-form-title">
						ยินดีต้อนรับ
					</span>

					<div class="wrap-input100 validate-input" data-validate="กรุณากรอก Username: ton123">
						<input class="input100" type="text" id="username" name="username" placeholder="ชื่อผู้ใช้งาน">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" id="password" name="password" placeholder="รหัสผ่าน" id="password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button type="button" class="login100-form-btn" name="login_user" id="login_user">
							เข้าสู่ระบบ
						</button>
					</div>

					<div class="text-right p-t-25">
						<strong><a href="#reset_password" data-toggle="modal">ลืมรหัสผ่าน?</a></strong>
					</div>

				</form>
			</div>
		</div>
	</div>

	<!--- เริ่ม modal รายการปลูก --->
	<div class="modal fade reset_password" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="reset_password">
		<div class="modal-dialog modal-lg">
			<div class="modal-content" style="width: auto;">
				<div class="modal-header">
					<h5 class="modal-title card-title"><i class="fa fa-lock"></i> ลืมรหัสผ่าน</h5>
					<button type="button" class="close" data-dismiss="modal" style="width:50px;">
						<h3>&times;</h3>
					</button>
				</div>

				<div class="modal-body">
					<form role="form" method="post" action="" id="in_planting">
						<div class="row">
							<div class="col-sm-12"><br><br>
								<div class="row">
									<div class="col-4" align="right">
										<label>รหัสพนักงาน : </label>
									</div>
									<div class="col-5">
										<div class="wrap-input100">
											<input type="text" class="input100" id="in_reset_id" name="in_reset_id">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-4" align="right">
										<label>รหัสบัตรประชาชน : </label>
									</div>
									<div class="col-5">
										<div class="wrap-input100">
											<input type="text" class="input100" id="in_reset_cid" name="in_reset_cid">
										</div>
									</div>
								</div>
							</div>
						</div><br>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="form-group" align="right">
							<button type="button" class="btn btn-outline-success" name="btn_reset_password" id="btn_reset_password">บันทึก</button>
						</div>
					</div>
					<div class="col-6" align="left">
						<div class="form-group">
							<button type="button" class="btn btn-outline-danger" id="cancel" data-dismiss="modal">ยกเลิก</button>
						</div>
					</div>
				</div><br>
			</div>
		</div>
		</form>
	</div>

	<!--===============================================================================================-->
	<script src="assets/vendor1/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="assets/vendor1/bootstrap/js/popper.js"></script>
	<script src="assets/vendor1/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="assets/vendor1/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="assets/vendor1/tilt/tilt.jquery.min.js"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<!--===============================================================================================-->
	<script src="assets/js/main.js"></script>

</body>

</html>

<script>
	$("#password").keypress(function(event) {
		if (event.keyCode === 13) {
			$("#login_user").click();
		}
	});
	$('#login_user').click(function() {

		var username = $('#username').val()
		var password = $('#password').val()

		if (username == "") {
			swal({
				text: "กรุณากรอก username",
				icon: "warning",
				button: "ปิด",
			});
		} else if (password == "") {
			swal({
				text: "กรุณากรอก password",
				icon: "warning",
				button: "ปิด",
			});
		} else {
			$.ajax({
				url: "check_login.php",
				method: "POST",
				data: {
					username: username,
					password: password
				},
				success: function(data) {
					// console.log(data)
					console.log(data)
					var str = data.split(',')
					if (str[1] == 2) {
						window.location.href = "admin.php"
						update_status_week()
					} else if (str[1] == 3) {
						window.location.href = "admin.php"
						update_status_week()
					} else if (str[0] == 1) {
						swal({
							text: "username  ไม่ถูกต้อง",
							icon: "warning",
							button: "ปิด",
						});
					} else {
						swal({
							text: "password ไม่ถูกต้อง",
							icon: "warning",
							button: "ปิด",
						});
					}
					if (str[0] == 4) {
						$.ajax({
							url: "notify_line.php",
							method: "POST",
							success: function(data) {}
						});
					}

				}
			});
		}
	});

	$("#in_reset_id").change(function(event) {
		var emp_id = $(this).val()
		$.ajax({
			url: "check_emp_id_reset.php",
			method: "POST",
			data: {
				emp_id: emp_id
			},
			success: function(data) {
				console.log(data)
				if (data == 0) {
					swal({

						text: "รหัสพนักงานของคุณไม่ถูกต้อง",
						icon: "warning",
						button: "ปิด",
					});
					$("#in_reset_id").val("")
				}
			}
		});
	});

	$("#in_reset_cid").change(function(event) {
		var idcard = $(this).val()
		var emp_id = $('#in_reset_id').val()
		$.ajax({
			url: "check_idcard_reset.php",
			method: "POST",
			data: {
				idcard: idcard,
				emp_id: emp_id
			},
			success: function(data) {
				console.log(data)
				if (data == 0) {
					swal({

						text: "เลขบัตรประชานของคุณไม่ถูกต้อง",
						icon: "warning",
						button: "ปิด",
					});
					$("#in_reset_cid").val("")
				}
			}
		});
	});

	$(document).on("click", "#btn_reset_password", function(event) {

		var in_reset_id = $("#in_reset_id").val()
		var in_reset_cid = $("#in_reset_cid").val()

		if (in_reset_id == "") {
			swal({
				text: "กรุณากรอกรหัสพนักงาน",
				icon: "warning",
				button: "ปิด"
			});
		} else if (in_reset_cid == "") {
			swal({
				text: "กรุณากรอกเลขบัตรประชาชน",
				icon: "warning",
				button: "ปิด"
			});
		} else {

			$.ajax({
				url: "reset_password.php",
				method: "POST",
				data: {
					in_reset_id: in_reset_id,
					in_reset_cid: in_reset_cid
				},
				success: function(data) {
					if (data == 1) {
						swal({
							text: "รีเซ็ตรหัสผ่านเรียบร้อยแล้ว",
							icon: "success",
							button: false,
						});
						setTimeout(function() {
							location.reload();
						}, 2000);

					} else {
						swal({

							text: "รีเซ็ตรหัสผ่านไม่สำเร็จ",
							icon: "warning",
							button: false,
						});
						setTimeout(function() {
							location.reload();
						}, 2000);

					}
				}
			});
		}
	});

	function update_status_week() {

		$.ajax({
			url: "update_status_week.php",
			method: "POST",
			success: function(data) {

			}
		});
	}
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>