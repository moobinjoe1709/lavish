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
				<li><a href="{{url('customer')}}">ลูกค้า</a></li>
				<li class="active">แก้ไขลูกค้า</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		<!-- 2 columns form -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">แก้ไขลูกค้า</h5>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
							<li><a data-action="reload"></a></li>
							<li><a data-action="close"></a></li>
						</ul>
					</div>
				</div>

				<form id="myForm" method="post" action="{{url('customer_update')}}" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="updateid" value="{{$customer->customer_id}}">
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
									@php
										if(!empty($customer->customer_img)){
											@endphp
											<br>
											<img src="{{asset('assets/images/customer')}}/{{$customer->customer_img}}" class="img-responsive img-thumbnail" width="300px">
											@php
										}
									@endphp
									<br>
									
								</div>
								<div class="form-group">
									<label>รหัสลูกค้า :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="code" id="code" value="{{$customer->customer_code}}" required>
									</div>
								</div>
								<div class="form-group" id="boxscroll" style="display:none;">
									<label>จำนวนกล่อง :</label>
									<div class="input-control">
										<input type="text" class="form-control number" name="point" id="point" value="{{$customer->customer_point}}" required>
									</div>
								</div>
								<div class="form-group">
									<label>ชื่อลูกค้า :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="name" id="name" value="{{$customer->customer_name}}" required>
									</div>
								</div>
								<div class="form-group">
									<label>ชื่อลูกค้าภาษาอังกฤษ :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="nameen" id="nameen" value="{{$customer->customer_nameEN}}">
									</div>
								</div>
								<div class="form-group">
									<label>เบอร์ติดต่อ :</label>
									<div class="input-control">
										<input type="text" class="form-control number" name="tel" id="tel" value="{{$customer->customer_tel}}" maxlength="10" required>
									</div>
								</div>
								<div class="form-group">
									<label>อีเมล์ :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="email" id="email" value="{{$customer->customer_email}}" required>
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
													$day = substr($customer->customer_birth,8,2);
													for($x=1;$x<=31;$x++){
														if(intval($day) == $x){
															@endphp 
															<option value="{{$x}}" selected>{{$x}}</option>
															@php
														}else{
															@endphp 
															<option value="{{$x}}">{{$x}}</option>
															@php
														}
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
													$months = substr($customer->customer_birth,5,2);
													foreach($month as $key => $m){
														if(intval($months) == $key+1){
															@endphp 
															<option value="{{$key+1}}" selected>{{$m}}</option>
															@php
														}else{
															@endphp 
															<option value="{{$key+1}}">{{$m}}</option>
															@php
														}
														
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
													$yearb = substr($customer->customer_birth,0,4);
													for($i=1;$i<=100;$i++){
														if($yearb == (date('Y')+(543)-($i))){
															@endphp
															<option value="{{date('Y')+(543)-($i)}}" selected>{{date('Y')+(543)-($i)}}</opton>
															@php
														}else{
															@endphp
															<option value="{{date('Y')+(543)-($i)}}">{{date('Y')+(543)-($i)}}</opton>
															@php
														}
														
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
										<textarea name="address" class="form-control" style="resize: vertical;" rows="3">{{$customer->customer_detail}}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label>ที่อยู่ตามทะเบียนบ้าน :</label>
									<div class="input-control">
										<textarea name="addresshome" class="form-control" style="resize: vertical;" rows="3">{{$customer->customer_detailhome}}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label>ที่อยู่ส่งเอกสาร :</label>
									<div class="input-control">
										<textarea name="addressdoc" class="form-control" style="resize: vertical;" rows="3">{{$customer->customer_detaildoc}}</textarea>
									</div>
								</div>
								<hr>
								<div class="row">
									<input type="hidden" id="countrowother" value="1">
									<table width="100%">
										<tbody id="otherrow">
											@php
												if($shipping){
													foreach($shipping as $ar){
														@endphp
														<tr class="trrowotherup{{$ar->shipping_id}}">
															<td>ชื่ออื่นๆ  <input type="hidden" class="form-control" name="otheridup[]" id="otheridup{{$ar->shipping_id}}" value="{{$ar->shipping_id}}"><input type="text" class="form-control" name="othernameup[]" id="othernameup{{$ar->shipping_id}}" value="{{$ar->shipping_name}}"></td>
															<td>&nbsp;</td>
															<td>เบอร์ติดต่อ  <input type="text" class="form-control" name="othertelup[]" id="othertelup{{$ar->shipping_id}}" value="{{$ar->shipping_tel}}"></td>
															<td align="center" rowspan="4"><button type="button" class="btn btn-success btn-icon"><i class="icon-minus-circle2"></i></button></td>
														</tr>
														<tr class="trrowotherup{{$ar->shipping_id}}">
															<td colspan="3">&nbsp;</td>
														</tr>
														<tr class="trrowotherup{{$ar->shipping_id}}">
															<td valign="top">เลขประจำตัวผู้เสียภาษี  <input type="text" class="form-control" name="othertaxup[]" id="othertaxup{{$ar->shipping_id}}" value="{{$ar->shipping_tax}}"></td>
															<td>&nbsp;</td>
															<td>ที่อยู่  <textarea class="form-control" name="otheraddrup[]" id="otheraddrup{{$ar->shipping_id}}">{{$ar->shipping_addr}}</textarea></td>
														</tr>
														<tr class="trrowotherup{{$ar->shipping_id}}">
															<td colspan="3">หมายเหตุ  <textarea class="form-control" name="othernoteup[]" id="othernoteup{{$ar->shipping_id}}">{{$ar->shipping_note}}</textarea></td>
														</tr>
														@php
													}
												}
											@endphp
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
									@php
										if($contact){
											foreach($contact as $rs){
												@endphp
												<div id="rowupdate{{$rs->sub_id}}">
													<div class="col-md-5">
														<div class="input-control">
															<span class="txt{{$rs->sub_id}}" id="supconnameuptxt{{$rs->sub_id}}">{{$rs->sub_name}}</span>
															<input type="text" class="form-control inputrow{{$rs->sub_id}}" name="supconnameup[]" id="supconnameup{{$rs->sub_id}}" style="display:none" value="{{$rs->sub_name}}">
														</div>
													</div>
													<div class="col-md-5">
														<div class="input-control">
															<span class="txt{{$rs->sub_id}}" id="supconteluptxt{{$rs->sub_id}}">{{$rs->sub_tel}}</span>
															<input type="text" class="form-control number inputrow{{$rs->sub_id}}" name="subcontelup[]" id="subcontelup{{$rs->sub_id}}" style="display:none" value="{{$rs->sub_tel}}">
														</div>
													</div>
													<div class="col-md-2">
														<div class="input-control">
															<span id="actionrow{{$rs->sub_id}}"><button type="button" class="btn btn-success btn-icon edit" onclick="editrow({{$rs->sub_id}})"><i class="icon-pencil6"></i></button></span>
															<button type="button" class="btn btn-danger btn-icon" onclick="delrow({{$rs->sub_id}})"><i class="icon-trash"></i></button><br><br>
														</div>
													</div>
												</div>
												@php
											}
										}
									@endphp
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
										<textarea name="note" class="form-control" style="resize: vertical;" rows="3">{{$customer->customer_note}}</textarea>
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
					</form>
				</div>
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
		if({{Auth::user()->status}} == 1){
			$('#boxscroll').show();
		}
	});
	
	$('#save').click(function(){
		$('#myForm').submit(); 
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
	
	function editrow(id){
		$('#actionrow'+id).html('<button type="button" class="btn btn-success btn-icon edit" onclick="updaterow('+id+')"><i class="icon-floppy-disk"></i></button>');
		$('.inputrow'+id).show();
		$('.txt'+id).hide();
	}
	
	function delrow(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการลบรายการนี้ หรือไม่?",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times"></i> Cancel',
					className: 'btn-danger'
				},
				confirm: {
					label: '<i class="fa fa-check"></i> Confirm',
					className: 'btn-success'
				}
			},
			callback: function (result) {
				if(result == true){
					$.ajax({
					'dataType': 'json',
					'type': 'post',
					'url': "{{url('supcondelete')}}",
					'data': {
						'id':id,
						'_token': "{{ csrf_token() }}"
					},
						'success': function (data) {
							$('#rowupdate'+id).remove();
						}
					});
				}
			}
		});
	}
	
	function updaterow(id){
		$.ajax({
		'dataType': 'json',
		'type': 'post',
		'url': "{{url('supconupdate')}}",
		'data': {
			'id':id,
			'name': $('#supconnameup'+id).val(),
			'tel': $('#subcontelup'+id).val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data) {
				$('#actionrow'+id).html('<button type="button" class="btn btn-success btn-icon edit" onclick="editrow('+id+')"><i class="icon-pencil6"></i></button>');
				
				$('#supconnameup'+id).val($('#supconnameup'+id).val());
				$('#subcontelup'+id).val($('#subcontelup'+id).val());
				$('#supconnameuptxt'+id).text($('#supconnameup'+id).val());
				$('#supconteluptxt'+id).text($('#subcontelup'+id).val());
				$('.inputrow'+id).hide();
				$('.txt'+id).show();
			}
		});
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
	}
</script>
</html>
@stop