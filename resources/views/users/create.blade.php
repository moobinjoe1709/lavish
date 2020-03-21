@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">ผู้ใช้งาน</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li><a href="{{url('users')}}">ผู้ใช้งาน</a></li>
				<li class="active">เพิ่มผู้ใช้งาน</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		<!-- 2 columns form -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">เพิ่มผู้ใช้งาน </h5>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
							<li><a data-action="reload"></a></li>
							<li><a data-action="close"></a></li>
						</ul>
					</div>
				</div>

				<form method="post" action="{{url('users_create')}}" onsubmit="return check();">
				{{ csrf_field() }}
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6 col-md-6 col-md-offset-3">
							<fieldset>
								<legend class="text-semibold">ข้อมูลผู้ใช้งาน</legend>
								<div class="form-group">
									<label>ชื่อ  :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="name" id="name" required>
									</div>
								</div>
								<div class="form-group">
									<label>เบอร์ติดต่อ :</label>
									<div class="input-control">
										<input type="text" class="form-control number" name="tel" id="tel" maxlength="10" required>
									</div>
								</div>
								<div class="form-group">
									<label>สถานะ :</label>
									<div class="input-control">
										<select class="form-control" name="status">
											<option value="0">พนักงาน</option>
											<option value="2">บัญชี</option>
											<option value="1">ผู้ดูแลระบบ</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label>อีเมล :</label>
									<div class="input-control">
										<input type="email" class="form-control" name="email" id="email" required>
									</div>
								</div>
								<div class="form-group">
									<label>รหัสผ่าน :</label>
									<div class="input-control">
										<input type="password" class="form-control" name="password" id="password">
									</div>
								</div>
								<div class="form-group">
									<label>ยืนยันรหัสผ่าน :</label>
									<div class="input-control">
										<input type="password" class="form-control" name="cpassword" id="cpassword">
									</div>
								</div>
								<br>
								<div class="text-right">
									<a href="{{url('customer')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
									<button type="submit" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
				</form>
			</div>
		<!-- /2 columns form -->
	


		<!-- Footer -->
		<div class="footer text-muted">
			&copy; 2016-2017. <a href="https://www.orange-thailand.com">Orange Technology Solution</a>
		</div>
		<!-- /footer -->

	</div>
	<!-- /content area -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->

</div>
<!-- /page container -->

</body>
<script>
	$(document).ready(function(){
        
        $(".onlynumber").keydown(function(e){
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                 // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
            else{
            }
        });
    });
	
	function check(){
		var isValid 	= true;
		var password 	= $('#password').val();
		var cpassword 	= $('#cpassword').val();
		if(password != cpassword){
			isValid = false;
			bootbox.alert("รหัสผ่านผิดพลาด กรุณาตรวจสอบอีกครั้ง!!", function(){ console.log('รหัสผ่านผิดพลาด กรุณาตรวจสอบอีกครั้ง!!'); });
		}
		return isValid;
	}
</script>
</html>
@stop