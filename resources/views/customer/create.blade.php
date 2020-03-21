@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">ลูกค้า</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li><a href="{{url('customer')}}">ลูกค้า</a></li>
				<li class="active">เพิ่มลูกค้า</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		<!-- 2 columns form -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">เพิ่มสินค้า </h5>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
							<li><a data-action="reload"></a></li>
							<li><a data-action="close"></a></li>
						</ul>
					</div>
				</div>

				<form id="myForm" method="post" action="{{url('customer_create')}}" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6 col-md-6 col-md-offset-3">
							<fieldset>
								<legend class="text-semibold">ข้อมูลลูกค้า</legend>
								<div class="form-group">
									<label>รูปโปรไฟล์ :</label>
									<div class="input-control">
										<input type="file" class="file-input" name="uploadcover">
									</div>
								</div>
								<div class="form-group">
									<label>รหัสลูกค้า :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="code" id="code" required>
									</div>
								</div>
								<div class="form-group">
									<label>ชื่อลูกค้า :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="name" id="name" required>
									</div>
								</div>
								<div class="form-group">
									<label>ชื่อลูกค้าภาษาอังกฤษ :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="nameen" id="nameen">
									</div>
								</div>
								<div class="form-group">
									<label>เบอร์ติดต่อ :</label>
									<div class="input-control">
										<input type="text" class="form-control number" name="tel" id="tel" maxlength="10">
									</div>
								</div>
								<div class="form-group">
									<label>อีเมล์ :</label>
									<div class="input-control">
										<input type="email" class="form-control" name="email" id="email">
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<label>วันเกิด :</label>
									</div>
									<div class="col-md-4">
										<label>เดือนเกิด :</label>
									</div>
									<div class="col-md-4">
										<label>ปีเกิด :</label>
									</div>
									<div class="col-md-2">
										<div class="input-control">
											<select class="form-control" name="birthday">
												<option value="">วันที่</option>
												@php
													for($x=1;$x<=31;$x++){
														@endphp 
														<option value="{{$x}}">{{$x}}</option>
														@php
													}
												@endphp
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="input-control">
											<select class="form-control" name="birthdmonth">
												<option value="">เดือนเกิด</option>
												@php
													$month = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
													foreach($month as $key => $m){
														@endphp 
														<option value="{{$key+1}}">{{$m}}</option>
														@php
													}
												@endphp
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="input-control">
											<select class="form-control" name="birthyear">
												<option value="">ปีเกิด</option>
												@php
													for($i=1;$i<=100;$i++){
														@endphp
														<option value="{{date('Y')+(543)-($i)}}">{{date('Y')+(543)-($i)}}</opton>
														@php
													}
												@endphp
											</select>
										</div>
									</div>
								</div>
								<br>
								<div class="form-group">
									<label>ที่อยู่ปัจจุบัน :</label>
									<div class="input-control">
										<textarea name="address" class="form-control" style="resize: vertical;" rows="3"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label>ที่อยู่ตามทะเบียนบ้าน :</label>
									<div class="input-control">
										<textarea name="addresshome" class="form-control" style="resize: vertical;" rows="3"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label>ที่อยู่ส่งเอกสาร :</label>
									<div class="input-control">
										<textarea name="addressdoc" class="form-control" style="resize: vertical;" rows="3"></textarea>
									</div>
								</div>
								<hr>
								<div class="row">
									<input type="hidden" id="countrowother" value="1">
									<table width="100%">
										<tbody id="otherrow">
											<tr class="trrowother1">
												<td>ชื่ออื่นๆ  <input type="text" class="form-control" name="othername[]" id="othername1"></td>
												<td>&nbsp;</td>
												<td>เบอร์ติดต่อ  <input type="text" class="form-control" name="othertel[]" id="othertel1"></td>
												<td align="center" rowspan="4"><button type="button" class="btn btn-success btn-icon addrowother"><i class="icon-plus-circle2"></i></button></td>
											</tr>
											<tr class="trrowother1">
												<td colspan="3">&nbsp;</td>
											</tr>
											<tr class="trrowother1">
												<td valign="top">เลขประจำตัวผู้เสียภาษี  <input type="text" class="form-control" name="othertax[]" id="othertax1"></td>
												<td>&nbsp;</td>
												<td>ที่อยู่  <textarea class="form-control" name="otheraddr[]" id="otheraddr1"></textarea></td>
											</tr>
											<tr class="trrowother1">
												<td colspan="3">หมายเหตุ  <textarea class="form-control" name="othernote[]" id="othernote1"></textarea></td>
											</tr>
										</tbody>
									</table>
								</div>
								<br>
								<div class="row">
									<div class="col-md-5">
										<label>ผู้ติดต่อ :</label>
									</div>
									<div class="col-md-5">
										<label>เบอร์ติดต่อ :</label>
									</div>
									<input type="hidden" id="countrow" value="1">
									<div id="rowcontact">
										<div class="col-md-5">
											<div class="input-control">
												<input type="text" class="form-control" name="supconname[]" id="supconname1">
											</div>
										</div>
										<div class="col-md-5">
											<div class="input-control">
												<input type="text" class="form-control number" name="subcontel[]" id="subcontel1">
											</div>
										</div>
										<div class="col-md-2">
											<div class="input-control">
												<button type="button" class="btn btn-success btn-icon addrow"><i class="icon-plus-circle2"></i></button><br><br>
											</div>
										</div>
										
									</div>
								</div>
								<div class="form-group">
									<label>หมายเหตุ :</label>
									<div class="input-control">
										<textarea name="note" class="form-control" style="resize: vertical;" rows="3"></textarea>
									</div>
								</div>
								<br>
								<div class="text-right">
									<a href="{{url('customer')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
									<button type="button" id="save" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
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
	$('#save').click(function(){
		$.ajax({
		'dataType': 'json',
		'type': 'post',
		'url': "{{url('checkcodecust')}}",
		'data': {
			'code': $('#code').val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data) {
				if(data >= 1){
					bootbox.alert({
						message: "มีรหัสนี้มีในระบบแล้ว กรุณาตรวจสอบอีกครั้ง!!",
						className: 'rubberBand animated'
					});
				}else{
					$('#myForm').submit(); 
				}
			}
		});
	});
	
	$('.addrow').click(function(){
		var countrow = $('#countrow').val();
		var sumrow = countrow+1; 
		$('#countrow').val(sumrow);
		
		$('#rowcontact').append('<div id="rowcontacts'+sumrow+'"><div class="col-md-5">'
			+'<div class="input-control">'
				+'<input type="text" class="form-control" name="supconname[]" id="supconname'+sumrow+'" required>'
			+'</div>'
		+'</div>'
		+'<div class="col-md-5">'
			+'<div class="input-control">'
				+'<input type="text" class="form-control number" name="subcontel[]" id="subcontel'+sumrow+'" onkeypress="return isNumberKey(event);">'
			+'</div>'
		+'</div>'
		+'<div class="col-md-2">'
			+'<div class="input-control">'
				+'<button type="button" class="btn btn-success btn-icon" onclick="addrow()"><i class="icon-plus-circle2"></i></button> <button type="button" class="btn btn-danger btn-icon minus" onclick="del('+sumrow+')"><i class="icon-minus-circle2"></i></button><br><br>'
			+'</div>'
		+'</div></div>');
	});
	
	function addrow(id){
		var countrow = $('#countrow').val();
		var sumrow = countrow+1; 
		$('#countrow').val(sumrow);
		
		$('#rowcontact').append('<div id="rowcontacts'+sumrow+'"><div class="col-md-5">'
			+'<div class="input-control">'
				+'<input type="text" class="form-control" name="supconname[]" id="supconname'+sumrow+'" required>'
			+'</div>'
		+'</div>'
		+'<div class="col-md-5">'
			+'<div class="input-control">'
				+'<input type="text" class="form-control number" name="subcontel[]" id="subcontel'+sumrow+'" onkeypress="return isNumberKey(event);">'
			+'</div>'
		+'</div>'
		+'<div class="col-md-2">'
			+'<div class="input-control">'
				+'<button type="button" class="btn btn-success btn-icon" onclick="addrow('+sumrow+')"><i class="icon-plus-circle2"></i></button> <button type="button" class="btn btn-danger btn-icon minus" onclick="del('+sumrow+')"><i class="icon-minus-circle2"></i></button><br><br>'
			+'</div>'
		+'</div></div>');
	}
	
	function del(id){
		var countrow = $('#countrow').val();
		var sumrow = countrow-1; 
		$('#countrow').val(sumrow);
		$('#rowcontacts'+id).remove();
	}
	
	$('.addrowother').click(function(){
		var countrow = $('#countrowother').val();
		var sumrow = countrow+1; 
		$('#countrowother').val(sumrow);
		
		$('#otherrow').append('<tr class="trrowother'+sumrow+'">'
			+'<td>ชื่ออื่นๆ  <input type="text" class="form-control" name="othername[]" id="othername'+sumrow+'"></td>'
			+'<td>&nbsp;</td>'
			+'<td>เบอร์ติดต่อ  <input type="text" class="form-control" name="othertel[]" id="othertel'+sumrow+'" onkeypress="return isNumberKey(event);"></td>'
			+'<td align="center" rowspan="4"><button type="button" class="btn btn-success btn-icon" onclick="addrow_other('+sumrow+')"><i class="icon-plus-circle2"></i></button> <button type="button" class="btn btn-danger btn-icon minus" onclick="delother('+sumrow+')"><i class="icon-minus-circle2"></i></button></td>'
		+'</tr>'
		+'<tr class="trrowother'+sumrow+'">'
			+'<td colspan="3">&nbsp;</td>'
		+'</tr>'
		+'<tr class="trrowother'+sumrow+'">'
			+'<td valign="top">เลขประจำตัวผู้เสียภาษี  <input type="text" class="form-control" name="othertax[]" id="othertax'+sumrow+'"></td>'
			+'<td>&nbsp;</td>'
			+'<td>ที่อยู่  <textarea class="form-control" name="otheraddr[]" id="otheraddr'+sumrow+'"></textarea></td>'
		+'</tr>'
		+'<tr class="trrowother'+sumrow+'">'
			+'<td colspan="3">หมายเหตุ  <textarea class="form-control" name="othernote[]" id="othernote'+sumrow+'"></textarea></td>'
		+'</tr>');
	});
	
	function addrow_other(id){
		var countrow = $('#countrowother').val();
		var sumrow = countrow+1; 
		$('#countrowother').val(sumrow);
		
		$('#otherrow').append('<tr class="trrowother'+sumrow+'">'
			+'<td>ชื่ออื่นๆ  <input type="text" class="form-control" name="othername[]" id="othername'+sumrow+'"></td>'
			+'<td>&nbsp;</td>'
			+'<td>เบอร์ติดต่อ  <input type="text" class="form-control" name="othertel[]" id="othertel'+sumrow+'" onkeypress="return isNumberKey(event);"></td>'
			+'<td align="center" rowspan="4"><button type="button" class="btn btn-success btn-icon" onclick="addrowother('+sumrow+')"><i class="icon-plus-circle2"></i></button> <button type="button" class="btn btn-danger btn-icon minus" onclick="delother('+sumrow+')"><i class="icon-minus-circle2"></i></button></td>'
		+'</tr>'
		+'<tr class="trrowother'+sumrow+'">'
			+'<td colspan="3">&nbsp;</td>'
		+'</tr>'
		+'<tr class="trrowother'+sumrow+'">'
			+'<td valign="top">เลขประจำตัวผู้เสียภาษี  <input type="text" class="form-control" name="othertax[]" id="othertax'+sumrow+'"></td>'
			+'<td>&nbsp;</td>'
			+'<td>ที่อยู่  <textarea class="form-control" name="otheraddr[]" id="otheraddr'+sumrow+'"></textarea></td>'
		+'</tr>'
		+'<tr class="trrowother'+sumrow+'">'
			+'<td colspan="3">หมายเหตุ  <textarea class="form-control" name="othernote[]" id="othernote'+sumrow+'"></textarea></td>'
		+'</tr>');
	}
	
	function delother(id){
		var countrow = $('#countrowother').val();
		var sumrow = countrow-1; 
		$('#countrowother').val(sumrow);
		$('.trrowother'+id).closest('tr').remove();
	}
	
	function isNumberKey(event){
		var key = window.event ? event.keyCode : event.which;
		if (event.keyCode === 8 || event.keyCode === 46){
			return true;
		}else if ( key < 48 || key > 57 ){
			return false;
		}else{
			return true;
		}
	};
</script>
</html>
@stop