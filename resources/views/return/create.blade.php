@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">คืนสินค้า</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li class="active">คืนสินค้า / เพิ่ม </li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		<!-- Vertical form options -->
		<form id="myForm" method="post" action="{{url('return_create')}}">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-12">
					<!-- Vertical form -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<div class="heading-elements">
								<ul class="icons-list">
									<li><a data-action="collapse"></a></li>
									<li><a data-action="reload"></a></li>
									<li><a data-action="close"></a></li>
								</ul>
							</div>
						</div>
						
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<fieldset>
										<legend class="text-semibold"><i class="icon-stack2"></i> ข้อมูลหลัก</legend>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>วันที่ :</label>
													<div class="input-group">
														<input type="text" name="docdate" id="docdate" placeholder="วันที่" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" value="<?php echo date('d/m/Y');?>">
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
												
											</div>
											
											
										</div>
										
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>เลขที่อ้างอิง :</label>
													<input type="text" class="form-control" name="docref" id="docref" placeholder="เลขที่อ้างอิง">
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
													<button type="button" id="search" class="btn btn-success" style="bottom: -27px;"><i class="icon-folder-search"></i>  ค้นหา</button>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>สถานะ :</label>
													<select class="select" name="status" id="status">
														<option value="1">สินค้าชำรุด</option>
														<option value="2">สินค้าตีกลับ</option>
													</select>
												</div>
											</div>
										</div>
									</fieldset>
								</div>
								
								<div class="col-md-6">
									<fieldset>
										<legend class="text-semibold"><i class="icon-info22"></i> รายละเอียด ลูกค้า</legend>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>ชื่อลูกค้า :</label>
													<input type="text" class="form-control" name="customername" id="customername" placeholder="ชื่อลูกค้า" autocomplete="off" value="">
												</div>
											</div>

											<div class="col-md-6">
												<input type="hidden" name="customerid" id="customerid" value="">
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>หมายเหตุ :</label>
													<textarea name="note" id="note" rows="2" class="form-control" placeholder="หมายเหตุ"></textarea>
												</div>
											</div>
										</div>
									</fieldset>
								</div>
					
							</div>
						</div>
					<!-- /vertical form -->
					
				</div>
			</div>
		</div>
		
		<!-- Vertical form options -->
		<div class="row">
			<div class="col-md-12">
				<!-- Basic layout-->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">รายการออเดอร์</h5>
							<div class="heading-elements">
								<ul class="icons-list">
									<li><a data-action="collapse"></a></li>
									<li><a data-action="reload"></a></li>
									<li><a data-action="close"></a></li>
								</ul>
							</div>
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-2">
										<div class="form-group has-feedback has-feedback-left">
											<input type="text" id="searchbarcode" class="form-control input-xlg" placeholder="บาร์โค๊ด">
											<div class="form-control-feedback">
												<i class="icon-barcode2"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<input type="hidden" name="countrow" id="countrow" value="0">
									<table id="myTable" class="table table-framed">
										<thead>
											<tr>
												<th class="text-center">รหัสสินค้า</th>
												<th class="text-center">รายการสินค้า</th>
												<th class="text-center" style="width:100px;">ราคาขาย</th>
												<th class="text-center">จำนวน</th>
												<th class="text-center">รวม</th>
												<th class="text-center">#</th>
											</tr>
										</thead>
										<tbody id="rowdata"></tbody>
									</table>
								</div>
							</div>
							<br><br>
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-8"></div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label col-md-4" style="top:8px;"><b>มูลค่า</b></label>
											<div class="col-md-8">
												<input type="text" id="sumtotalsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
												<input type="hidden" class="form-control" name="sumtotal" id="sumtotal" readonly>
											</div>
										</div>
									</div>
								</div>
							</div>
							<br><br>
							<div class="text-right">
								<a href="{{url('return')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
								<button type="button" id="save" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
							</div>
						</div>
					</div>
				<!-- /basic layout -->
			</div>
		</div>
		<!-- /vertical form options -->
		</form>	
		
		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">รายละเอียด</h4>
			  </div>
			  <div class="modal-body">
				<table class="table">
					<thead>
						<tr>
							<th class="text-center">ลำดับ</th>
							<th class="text-center">รายการ</th>
							<th class="text-center">ราคา</th>
							<th class="text-center">จำนวน</th>
							<th class="text-center">รวม</th>
						</tr>
					</thead>
					<tbody id="resorders">
					</tbody>
				</table>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
	
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
<style>
	.textshow{
		font-size:18px;
		border: none;
		text-align: right;
		margin-bottom: 8px;
	}
</style>
<script>
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	
	$('#customername').keyup(function(){
		$(this).autocomplete({
			source: "{{url('searchcustomername/autocomplete')}}",
			minLength: 1,
			select: function(event, ui){
				$('#customerid').val(ui.item.idcus);
				$('#customertax').val(ui.item.idtax);
				$('#customeraddr').val(ui.item.addr);
				$('#customercontel').val(ui.item.tel);
				$('#note').val(ui.item.note);
			}
		})
		.autocomplete("instance")._renderItem = function(ul, item) {
			return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attr + '</span>').appendTo(ul);
		};
	});
	
	$('#search').click(function(){
		$.ajax({
		'dataType': 'json',
		'type': 'post',
		'url': "{{url('returninv')}}",
		'data': {
			'inv' : $('#docref').val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data) {
				$('#customerid').val(data.export.export_customerid);
				$('#customername').val(data.export.export_customername);
				var num = 0;
				$.each(data.orders,function(key,item){
					num++;
					var find = 0;
					$('#rowdata tr').each(function(k,v){
						if($(this).is('#added_item'+item.id) == true){
							find = 1;
						}                 
					});
					
					if(find == 0){
						$('#rowdata').append('<tr class="rowbody" id="added_item'+item.order_productid+'">'
							+'<td align="center">'+item.product_code+'<input type="hidden" class="form-control" name="productid[]" id="productid'+item.order_productid+'" value="'+item.order_productid+'"></td>'
							+'<td align="left">'+item.product_name+'</td>'
							+'<td align="right"><input type="text" class="form-control" name="price[]" id="price'+item.order_productid+'" value="'+item.order_price+'" onkeyup="changeprice('+item.order_productid+')" style="width:120px;" onkeypress="return isNumberKey(event);"></td>'
							+'<td align="center"><input type="text" class="form-control" name="qty[]" id="qty'+item.order_productid+'" value="'+item.order_qty+'" onkeyup="changeqty('+item.order_productid+')" style="width:120px;" onkeypress="return isNumberKey(event);"></td>'
							+'<td align="right"><span id="totalprosp'+item.order_productid+'">'+formatNumber(item.order_total.toFixed(2))+'</span><input type="hidden" class="form-control" name="total[]" id="total'+item.order_productid+'" value="'+parseFloat(item.order_total)+'"></td>'
							+'<td align="center"><button type="button" class="btn btn-danger btn-icon" onclick="delrow('+item.order_productid+')"><i class="icon-minus-circle2"></i></button></td>'
						+'</tr>');
					}else{
						var qty = $('#qty'+item.order_productid).val();
						var sum = parseInt(qty)+1;
						var price = $('#price'+item.order_productid).val()||0;
						var totalpro = parseFloat(price*sum);
						
						$('#qty'+item.order_productid).val(sum);
						$('#totalprosp'+item.order_productid).text(formatNumber(totalpro.toFixed(2)));
						$('#total'+item.order_productid).val(totalpro);
					}
				});
				$('#countrow').val(num);
				var total = 0; 
				$("input[name = 'total[]']").each(function(){
					var totals = $(this).val()||0;
					total += parseFloat(totals);
				});
				
				$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
				$('#sumtotal').val(total);
			}
		});
	});
	
	$('#searchbarcode').keypress(function(e){
		if(e.which == 13){
			$.ajax({
			'dataType': 'json',
			'type': 'post',
			'url': "{{url('returnbarcode')}}",
			'data': {
				'barcode' : $(this).val(),
				'_token': "{{ csrf_token() }}"
			},
				'success': function (data) {
					$.each(data,function(key,item){
						var find = 0;
						$('#rowdata tr').each(function(k,v){
							if($(this).is('#added_item'+item.id) == true){
								find = 1;
							}                 
						});
						
						if(find == 0){
							$('#rowdata').append('<tr class="rowbody" id="added_item'+item.id+'">'
								+'<td align="center">'+item.code+'<input type="hidden" class="form-control" name="productid[]" id="productid'+item.id+'" value="'+item.productid+'"></td>'
								+'<td align="left">'+item.name+'</td>'
								+'<td align="right"><input type="text" class="form-control" name="price[]" id="price'+item.id+'" value="'+item.price+'" onkeyup="changeprice('+item.id+')" style="width:120px;" onkeypress="return isNumberKey(event);"></td>'
								+'<td align="center"><input type="text" class="form-control" name="qty[]" id="qty'+item.id+'" value="1" onkeyup="changeqty('+item.id+')" style="width:120px;" onkeypress="return isNumberKey(event);"></td>'
								+'<td align="right"><span id="totalprosp'+item.id+'">'+formatNumber(parseFloat(item.price*1).toFixed(2))+'</span><input type="hidden" class="form-control" name="total[]" id="total'+item.id+'" value="'+parseFloat(item.price*1)+'"></td>'
								+'<td align="center"><button type="button" class="btn btn-danger btn-icon" onclick="delrow('+item.id+')"><i class="icon-minus-circle2"></i></button></td>'
							+'</tr>');
						}else{
							var qty = $('#qty'+item.id).val();
							var sum = parseInt(qty)+1;
							var price = $('#price'+item.id).val()||0;
							var totalpro = parseFloat(price*sum);
							
							$('#qty'+item.id).val(sum);
							$('#totalprosp'+item.id).text(formatNumber(totalpro.toFixed(2)));
							$('#total'+item.id).val(totalpro);
						}
					});
					
					var total = 0; 
					$("input[name = 'total[]']").each(function(){
						var totals = $(this).val()||0;
						total += parseFloat(totals);
					});
					
					$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
					$('#sumtotal').val(total);
				}
			});
			$('#searchbarcode').val(' ');
			$('#searchbarcode').focus();
		}
	});
	
	function changeprice(id){
		var qty = $('#qty'+id).val();
		var price = $('#price'+id).val()||0;
		var totalpro = parseFloat(price*qty);
		
		$('#totalprosp'+id).text(formatNumber(totalpro.toFixed(2)));
		$('#total'+id).val(totalpro);
		
		var total = 0; 
		$("input[name = 'total[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total);
	}
	
	function changeqty(id){
		var qty = $('#qty'+id).val();
		var price = $('#price'+id).val()||0;
		var totalpro = parseFloat(price*qty);
		
		$('#totalprosp'+id).text(formatNumber(totalpro.toFixed(2)));
		$('#total'+id).val(totalpro);
		
		var total = 0; 
		$("input[name = 'total[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total);
	}
	
	function delrow(id){
		$('#added_item'+id).closest('tr').remove();
		var total = 0; 
		$("input[name = 'total[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total);
	}
	
	$('#save').click(function(){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการบันทึกรายการนี้ หรือไม่?",
			buttons:{
				cancel: {
					label: '<i class="fa fa-times"></i> ยกเลิก',
					className: 'btn-danger'
				},
				confirm:{
					label: '<i class="fa fa-check"></i> ยืนยัน',
					className: 'btn-success'
				}
			},
			callback: function (result){
				if(result == true){
					var row = $('#countrow').val();
					if(row == 0){
						bootbox.alert("คุณยังไม่มีรายการคืนสินค้า กรุณาตรวจสอบอีกครั้ง!!");
					}else{
						$('#myForm').submit();
					}
				}
			}
		});
	});
	
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
</body>
</html>
@stop