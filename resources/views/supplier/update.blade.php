@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">ซัพพลายเออร์</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li><a href="{{url('supplier')}}">ซัพพลายเออร์</a></li>
				<li class="active">แก้ไขซัพพลายเออร์</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		<!-- 2 columns form -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">แก้ไขซัพพลายเออร์</h5>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
							<li><a data-action="reload"></a></li>
							<li><a data-action="close"></a></li>
						</ul>
					</div>
				</div>

				<form id="myForm" method="post" action="{{url('supplier_update')}}" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="updateid" value="{{$customer->customer_id}}">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6 col-md-6 col-md-offset-3">
							<fieldset>
								<legend class="text-semibold">ข้อมูลซัพพลายเออร์</legend>
								<div class="form-group">
									<label>เลขประจำตัวผู้เสียภาษีอากร :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="tax" id="tax" value="{{$customer->customer_vat}}" required>
									</div>
								</div>
								<div class="form-group">
									<label>ชื่อซัพพลายเออร์ :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="name" id="name" value="{{$customer->customer_name}}" required>
									</div>
								</div>
								<div class="form-group">
									<label>เบอร์ติดต่อ :</label>
									<div class="input-control">
										<input type="text" class="form-control number" name="tel" id="tel" value="{{$customer->customer_tel}}" maxlength="10" required>
									</div>
								</div>
								<div class="form-group">
									<label>แฟกซ์ :</label>
									<div class="input-control">
										<input type="text" class="form-control number" name="fax" id="fax" maxlength="9" value="{{$customer->customer_fax}}">
									</div>
								</div>
								<div class="form-group">
									<label>อีเมล์ :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="email" id="email" value="{{$customer->customer_email}}" required>
									</div>
								</div>
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
								<div class="row">
									<div class="col-md-5">
										<label>สาขา :</label>
									</div>
									<div class="col-md-5">
										<label>ที่อยู่ :</label>
									</div>
									<input type="hidden" id="countrow2" value="1">
									@php
										if($address){
											foreach($address as $rs){
												@endphp
												<div id="rowupdates{{$rs->sa_id}}">
													<div class="col-md-5">
														<div class="input-control">
															<span class="txts{{$rs->sa_id}}" id="supbranchtxt{{$rs->sa_id}}">{{$rs->sa_branch}}</span>
															<input type="text" class="form-control inputrows{{$rs->sa_id}}" name="supbranch[]" id="supbranch{{$rs->sa_id}}" style="display:none" value="{{$rs->sa_branch}}">
														</div>
													</div>
													<div class="col-md-5">
														<div class="input-control">
															<span class="txts{{$rs->sa_id}}" id="subconaddresstxt{{$rs->sa_id}}">{{$rs->sa_address}}</span>
															<input type="text" class="form-control number inputrows{{$rs->sa_id}}" name="subconaddress[]" id="subconaddress{{$rs->sa_id}}" style="display:none" value="{{$rs->sa_address}}">
														</div>
													</div>
													<div class="col-md-2">
														<div class="input-control">
															<span id="actionrows{{$rs->sa_id}}"><button type="button" class="btn btn-success btn-icon edit" onclick="editrows({{$rs->sa_id}})"><i class="icon-pencil6"></i></button></span>
															<button type="button" class="btn btn-danger btn-icon" onclick="delrows({{$rs->sa_id}})"><i class="icon-trash"></i></button><br><br>
														</div>
													</div>
												</div>
												@php
											}
										}
									@endphp
									<div id="rowcontactes">
										<div class="col-md-5">
											<div class="input-control">
												<input type="text" class="form-control" name="subbranch[]" id="subbranch1">
											</div>
										</div>
										<div class="col-md-5">
											<div class="input-control">
												<input type="text" class="form-control number" name="subaddress[]" id="subaddress1">
											</div>
										</div>
										<div class="col-md-2">
											<div class="input-control">
												<button type="button" class="btn btn-success btn-icon addrow2"><i class="icon-plus-circle2"></i></button><br><br>
											</div>
										</div>
										
									</div>
								</div>
								<div class="form-group">
									<label>เครดิต :</label>
									<div class="input-control">
										<select name="credit" id="credit" class="form-control">
											<option value="">---- เลือกเครดิต ----</option>
											<option value="เครดิต 30 วัน" {{$customer->customer_credit ==  'เครดิต 30 วัน' ? 'selected' : ''}}>เครดิต 30 วัน</option>
											<option value="เครดิต 45 วัน" {{$customer->customer_credit ==  'เครดิต 45 วัน' ? 'selected' : ''}}>เครดิต 45 วัน</option>
											<option value="เครดิต 90 วัน" {{$customer->customer_credit ==  'เครดิต 90 วัน' ? 'selected' : ''}}>เครดิต 90 วัน</option>
											<option value="เครดิต 100 วัน" {{$customer->customer_credit ==  'เครดิต 100 วัน' ?  'selected' : ''}}>เครดิต 100 วัน</option>
											<option value="เครดิต 120 วัน" {{$customer->customer_credit ==  'เครดิต 120 วัน' ? 'selected'  : ''}}>เครดิต 120 วัน</option>
										</select>
									</div>
								</div>
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
									<a href="{{url('supplier')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
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

	$('.addrow2').click(function(){
		var countrow = $('#countrow2').val();
		var sumrow = countrow+1; 
		$('#countrow2').val(sumrow);
		
		$('#rowcontactes').append('<div id="rowcontactss'+sumrow+'"><div class="col-md-5">'
			+'<div class="input-control">'
				+'<input type="text" class="form-control" name="subbranch[]" id="subbranch'+sumrow+'" required>'
			+'</div>'
		+'</div>'
		+'<div class="col-md-5">'
			+'<div class="input-control">'
				+'<input type="text" class="form-control number" name="subaddress[]" id="subaddress'+sumrow+'" >'
			+'</div>'
		+'</div>'
		+'<div class="col-md-2">'
			+'<div class="input-control">'
				+'<button type="button" class="btn btn-success btn-icon" onclick="addrow2()"><i class="icon-plus-circle2"></i></button> <button type="button" class="btn btn-danger btn-icon minus" onclick="del2('+sumrow+')"><i class="icon-minus-circle2"></i></button><br><br>'
			+'</div>'
		+'</div></div>');
	});

	function addrow2(id){
		var countrow = $('#countrow').val();
		var sumrow = countrow+1; 
		$('#countrow').val(sumrow);
		
		$('#rowcontactes').append('<div id="rowcontactss'+sumrow+'"><div class="col-md-5">'
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
				+'<button type="button" class="btn btn-success btn-icon" onclick="addrow('+sumrow+')"><i class="icon-plus-circle2"></i></button> <button type="button" class="btn btn-danger btn-icon minus" onclick="del2('+sumrow+')"><i class="icon-minus-circle2"></i></button><br><br>'
			+'</div>'
		+'</div></div>');
	}

	function del2(id){
		var countrow = $('#countrow2').val();
		var sumrow = countrow-1; 
		$('#countrow2').val(sumrow);
		$('#rowcontactss'+id).remove();
	}

	function editrows(id){
		$('#actionrows'+id).html('<button type="button" class="btn btn-success btn-icon edit" onclick="updaterows('+id+')"><i class="icon-floppy-disk"></i></button>');
		$('.inputrows'+id).show();
		$('.txts'+id).hide();
	}

	function updaterows(id){
		$.ajax({
		'dataType': 'json',
		'type': 'post',
		'url': "{{url('supaddressupdate')}}",
		'data': {
			'id':id,
			'branch': $('#supbranch'+id).val(),
			'address': $('#subconaddress'+id).val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data) {
				console.log(data);
				$('#actionrows'+id).html('<button type="button" class="btn btn-success btn-icon edit" onclick="editrows('+id+')"><i class="icon-pencil6"></i></button>');
				$('#supbranch'+id).val($('#supbranch'+id).val());
				$('#subconaddress'+id).val($('#subconaddress'+id).val());
				$('#supbranchtxt'+id).text($('#supbranch'+id).val());
				$('#subconaddresstxt'+id).text($('#subconaddress'+id).val());
				$('.inputrows'+id).hide();
				$('.txts'+id).show();
			}
		});
	}

	function delrows(id){
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
					'url': "{{url('addressdelete')}}",
					'data': {
						'id':id,
						'_token': "{{ csrf_token() }}"
					},
						'success': function (data) {
							$('#rowupdates'+id).remove();
						}
					});
				}
			}
		});
	}
</script>
</html>
@stop