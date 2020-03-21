@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">ซื้อสินค้า / เพิ่ม</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li><a href="{{url('import')}}">ซื้อสินค้า</a></li>
				<li class="active"> / แก้ไข</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		<!-- 2 columns form -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">แก้ไขสินค้า </h5>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
							<li><a data-action="reload"></a></li>
							<li><a data-action="close"></a></li>
						</ul>
					</div>
				</div>

				<form id="myForm" method="post" action="{{url('imports_update')}}">
					{{ csrf_field() }}
					<input type="hidden" name="updateid" value="{{$import->import_id}}">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<fieldset>
									<legend class="text-semibold"><i class="icon-stack2"></i> ข้อมูลหลัก</legend>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>เลขที่เอกสาร :</label>
												<input type="text" class="form-control" name="impno" id="impno" placeholder="เลขที่เอกสาร" value="{{$import->import_ref}}">
											</div>
										</div>

										<div class="col-md-6"></div>
									</div>
								
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>วันที่ :</label>
												<div class="input-group">
													<input type="text" name="docdate" id="docdate" placeholder="วันที่" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" value="<?php echo date('d/m/Y',strtotime($import->import_date));?>">
												</div>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
												<label>พนักงานขาย :</label>
												<div class="input-group">
													<input type="text" name="empsalename" id="empsalename" class="form-control" onkeydown="return false;" autocomplete="off" value="{{Auth::user()->name}}" readonly>
													<input type="hidden" name="empsaleid" id="empsaleid" class="form-control" onkeydown="return false;" autocomplete="off" value="{{Auth::user()->id}}" readonly>
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>วันที่นำเข้า :</label>
												<div class="input-group">
													<input type="text" name="docdateimp" id="docdateimp" placeholder="วันที่" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" value="<?php echo date('d/m/Y',strtotime($import->import_dateimport));?>">
												</div>   
											</div>
										</div>
										
										<div class="col-md-6">
											
										</div>
									</div>
								</fieldset>
							</div>
							
							<div class="col-md-6">
								<fieldset>
									<legend class="text-semibold"><i class="icon-info22"></i> รายละเอียด ผู้ผลิต</legend>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>ชื่อซัพพลายเออร์ :</label>
												<input type="text" class="form-control" name="suppliername" id="suppliername" placeholder="ชื่อผู้ผลิต" autocomplete="off" value="{{$import->import_suppliername}}">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label>เลขประจำตัวผู้เสียภาษีอากร :</label>
												<input type="text" class="form-control" name="supplier_tax" id="supplier_tax" placeholder="เลขประจำตัวผู้เสียภาษีอากร" autocomplete="off" value="{{$import->import_suppliertax}}">
											</div>
											<input type="hidden" name="supplier_id" id="supplier_id" value="">
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>ที่อยู่ :</label>
												<textarea name="supplier_address" id="supplier_address" rows="2" class="form-control" placeholder="ที่อยู่" {{$import->import_cus != null ? 'disabled' : '' }}>{{$customer->customer_detail}}</textarea>
												<input type="checkbox" name="check_address" id="check_address" value="{{$import->import_cus}}" {{$import->import_cus != null ? 'checked' : '' }}> เลือกที่อยู่
											</div>
											
										</div>
									</div>
									<div class="row" id="show_address" style="display:none;">
										<div class="col-md-12">
											<div class="form-group">
												<label>เลือกที่อยู่ :</label>
												<select class="form-control" name="sub_address" id="sub_address"></select>
											</div>
											
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>เบอร์โทรศัพท์ :</label>
												<input type="text" class="form-control number" name="supplier_tel" id="supplier_tel" placeholder="เบอร์โทรศัพท์" value="{{$import->import_suppliertel}}">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>หมายเหตุ :</label>
												<textarea name="note" id="note" rows="2" class="form-control" placeholder="หมายเหตุ">{{$import->import_note}}</textarea>
											</div>
										</div>
									</div>
								</fieldset>
							</div>
				
						</div>
					</div>
				<!-- /vertical form -->
				
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
								</div>

								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-1">รายละเอียดสินค้า</label>
												<div class="col-md-11">
													<div class="row">
														<div class="col-md-2">
															<div class="form-group has-feedback has-feedback-left">
																<input type="text" id="searchbarcode" class="form-control input-xlg" placeholder="รหัสสินค้า / Barcode">
																<div class="form-control-feedback">
																	<i class="icon-barcode2"></i>
																</div>
															</div>
														</div>

														<div class="col-md-2">
															<div class="form-group has-feedback has-feedback-left">
																<input type="text" id="searchproduct" class="form-control input-xlg" placeholder="ชื่อสินค้า / Product">
																<div class="form-control-feedback">
																	<i class="icon-cart-add"></i>
																</div>
															</div>
														</div>
														
														<div class="col-md-2">
															<div class="form-group has-feedback has-feedback-left">
																<button type="button" id="productdata" class="btn btn-success"><i class="icon-cart"></i>  เลือกสินค้า</button>
															</div>
														</div>
														
													</div>
												</div>
											</div>
											<br><br>
											<table id="myTable" class="table table-framed">
												<thead>
													<tr>
														<th class="text-center">รหัสสินค้า</th>
														<th class="text-center">รายการสินค้า</th>
														<th class="text-center" style="width:150px;">จำนวน</th>
														<th class="text-center" style="width:150px;">ราคาซื้อ</th>
														<th class="text-center" style="width:150px;">รวม</th>
														<th class="text-center" style="width:150px;">#</th>
													</tr>
												</thead>
												<tbody id="rowdata">
													@php
														if($sub){
															foreach($sub as $rs){
																@endphp
																<tr class="rowproduct" id="row{{$rs->sub_product}}">
																	<td align="center">{{$rs->product_code}}</td>
																	<td>{{$rs->product_name}}
																		<input type="hidden" name="productid[]" value="{{$rs->product_id}}">
																	</td>
																	<td align="center">
																		<input type="text" class="form-control" name="qty[]" id="qty{{$rs->sub_product}}" value="{{$rs->sub_qty}}" onkeyup="qtychange({{$rs->product_id}})">
																	</td>
																	<td align="center">
																		<input type="text" class="form-control" name="price[]" id="price{{$rs->sub_product}}" value="{{$rs->sub_price}}" onkeyup="pricechange({{$rs->product_id}})">
																	</td>
																	<td align="center">
																		<input type="text" class="form-control" name="total[]" id="total{{$rs->sub_product}}" value="{{$rs->sub_total}}" readonly>
																	</td>
																	<td  align="center">
																		<button type="button" class="btn btn-danger btn-xs" onclick="delrow({{$rs->sub_product}})"><i class="icon-cancel-square"></i></button>
																	</td>
																</tr>
																@php
															}
														}
													@endphp
												</tbody>
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
														<input type="text" id="sumtotalsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{number_format($import->import_total,2)}}" autocomplete="off">
														<input type="hidden" class="form-control" name="sumtotal" id="sumtotal" value="{{$import->import_total}}" readonly>
													</div>
												</div>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-4"></div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label col-md-4">ภาษี</label>
													<div class="col-md-8">
														<div class="radio">
															<label>
																<input type="radio" class="control-success vat" name="vat" id="vat1" value="0" @if($import->import_vat == 0)  checked="checked" @endif >No Vat
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="control-success vat" name="vat" id="vat2" value="1" @if($import->import_vat == 1)  checked="checked" @endif >Exclude Vat
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="control-success vat" name="vat" id="vat3" value="2" @if($import->import_vat == 2)  checked="checked" @endif >Include Vat
															</label>
														</div>
													</div>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label col-md-4"><span id="fontvat"><strong>ภาษีมูลค่าเพิ่ม</strong></span></label>
													<div class="col-md-8">
														<input type="text" id="sumvatsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{number_format($import->import_vatsum),2}}" autocomplete="off">
														<input type="hidden" class="form-control" name="sumvat" id="sumvat" value="{{$import->import_vatsum}}" readonly>
													</div>
												</div>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="">
											<div class="col-md-12">
												<div class="col-md-4"></div>
												<div class="col-md-4">
													<div class="form-group">
														
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label col-md-4"><span><strong>รวมทั้งสิ้น</strong></span></label>
														<div class="col-md-8">
															<input type="text" id="sumpaymentsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{number_format($import->import_totalpayment),2}}" autocomplete="off">
															<input type="hidden" class="form-control" name="sumpayment" id="sumpayment" value="{{$import->import_totalpayment}}" readonly>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<br>
									<div class="text-right">
										<a href="{{url('import')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
										<button type="button" id="submitform" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
									</div>
								</div>
							</div>
						<!-- /basic layout -->
					</div>
				</div>
				<!-- /vertical form options -->
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

<!-- Modal -->
<div id="myproductdata" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Product</h4>
	  </div>
	  <div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<input type="hidden" id="export_id">
				<table class="table" id="datatables">
					<thead>
						<tr>
							<th class="text-center">รหัสสินค้า</th>
							<th class="text-center">รายการ</th>
							<th class="text-center">จำนวน</th>
							<th class="text-center">ราคาขาย</th>
							<th class="text-center">#</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>

  </div>
</div>
		
</body>
<script>
	$(document).ready(function(){
		var oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('productdatatables')}}",
			},
			columns: [
				{ 'className': "text-left", data: 'product_code', name: 'product_code' },
				{ data: 'product_name', name: 'product_name' },
				{ 'className': "text-center", data: 'product_qty', name: 'product_qty' },
				{ 'className': "text-right", data: 'product_price', name: 'product_price' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
			],
			rowCallback: function(row,data,index ){
				$('td:eq(4)', row).html('<i class="icon-paperplane position-left text-success" onclick="chooseproduct('+data['product_id']+')" data-popup="tooltip" title="เลือก Payment"></i>');
			}
		});
	});
	
	$('#productdata').click(function(){
		$('#myproductdata').modal('show');
	});
	
	function chooseproduct(id){
		$.ajax({
			'dataType': 'json',
			'type': 'post',
			'url': "{{url('enterimportproduct')}}",
			'data': {
				'productid': id,
				'_token': "{{ csrf_token() }}"
			},
			'success': function (data) {
				$.each(data.results,function(key,item){
					var find = 0;
					$('#rowdata tr').each(function(){
						if($(this).is('#row'+item.id) == true){
							find = 1;
						}                 
					});
					if(find == 0){
						$('#rowdata').append('<tr class="rowproduct" id="row'+item.id+'"><td align="center">'+item.code+'</td>'
							+'<td>'+item.name+'<input type="hidden" name="productid[]" value="'+item.id+'"></td>'
							+'<td align="center"><input type="text" class="form-control" name="qty[]" id="qty'+item.id+'" value="1" onkeyup="qtychange('+item.id+')"></td>'
							+'<td align="center"><input type="text" class="form-control" name="price[]" id="price'+item.id+'" value="0" onkeyup="pricechange('+item.id+')"></td>'
							+'<td align="center"><input type="text" class="form-control" name="total[]" id="total'+item.id+'" value="0" readonly></td>'
							+'<td  align="center"><button type="button" class="btn btn-danger btn-xs" onclick="delrow(\''+item.id+'\')"><i class="icon-cancel-square"></i></button></td>'
						+'</tr>');
					}
				});
				$('#searchproduct').val('');
				$('#searchproduct').trigger("focus");
			}
		});
		
		$('#myproductdata').modal('hide');
	}
	
	$(document).keypress(function(e){
		if(e.which == 13){
			$.ajax({
			'dataType': 'json',
			'type': 'post',
			'url': "{{url('enteimportsrbarcode')}}",
			'data': {
				'barcode': $('#searchbarcode').val(),
				'_token': "{{ csrf_token() }}"
			},
				'success': function(data){
					//$('.rowproduct').closest( 'tr').remove();
					$.each(data.results,function(key,item){
						var find = 0;
                        $('#rowdata tr').each(function(){
                            if($(this).is('#row'+item.id) == true){
                                find = 1;
                            }                 
                        });
                        if(find == 0){
                            $('#rowdata').append('<tr class="rowproduct" id="row'+item.id+'"><td align="center">'+item.code+'</td>'
                               +'<td>'+item.name+'<input type="hidden" name="productid[]" value="'+item.id+'"></td>'
								+'<td align="center"><input type="text" class="form-control" name="qty[]" id="qty'+item.id+'" value="1" onkeyup="qtychange('+item.id+')"></td>'
								+'<td align="center"><input type="text" class="form-control" name="price[]" id="price'+item.id+'" value="0" onkeyup="pricechange('+item.id+')"></td>'
								+'<td align="center"><input type="text" class="form-control" name="total[]" id="total'+item.id+'" value="0" readonly></td>'
                                +'<td  align="center"><button type="button" class="btn btn-danger btn-xs" onclick="delrow(\''+item.id+'\')"><i class="icon-cancel-square"></i></button></td>'
                            +'</tr>');
                        }
					});
					
					$('#searchbarcode').val('');
					$('#searchbarcode').trigger("focus");
				}
			});
		}
	});
	
	$("#searchproduct").autocomplete({
		source: "{{url('searchproductname/autocomplete')}}",
		minLength: 1,
		select: function(event, ui){
			$.ajax({
			'dataType': 'json',
			'type': 'post',
			'url': "{{url('enterimportproduct')}}",
			'data': {
				'productid': ui.item.id,
				'_token': "{{ csrf_token() }}"
			},
				'success': function (data) {
					$.each(data.results,function(key,item){
						var find = 0;
                        $('#rowdata tr').each(function(){
                            if($(this).is('#row'+item.id) == true){
                                find = 1;
                            }                 
                        });
                        if(find == 0){
                            $('#rowdata').append('<tr class="rowproduct" id="row'+item.id+'"><td align="center">'+item.code+'</td>'
                               +'<td>'+item.name+'<input type="hidden" name="productid[]" value="'+item.id+'"></td>'
								+'<td align="center"><input type="text" class="form-control" name="qty[]" id="qty'+item.id+'" value="1" onkeyup="qtychange('+item.id+')"></td>'
								+'<td align="center"><input type="text" class="form-control" name="price[]" id="price'+item.id+'" value="0" onkeyup="pricechange('+item.id+')"></td>'
								+'<td align="center"><input type="text" class="form-control" name="total[]" id="total'+item.id+'" value="0" readonly></td>'
                                +'<td  align="center"><button type="button" class="btn btn-danger btn-xs" onclick="delrow(\''+item.id+'\')"><i class="icon-cancel-square"></i></button></td>'
                            +'</tr>');
                        }
					});
					$('#searchproduct').val('');
					$('#searchproduct').trigger("focus");
				}
			});
		}
	})
	.autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attrs + '</span>').appendTo(ul);
	};
	
	function qtychange(id){
		var qty 		= $('#qty'+id).val()||0;
		var price 		= $('#price'+id).val()||0;
		var sumtotal 	= parseFloat(qty * price);
		$('#total'+id).val(sumtotal.toFixed(2));

		<!-- คำนวณ ยอด -->
		var total = 0;
		$("input[name = 'total[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var vat 		= $('.vat:checked').val();
		var lastbill 	= $('#discountlastbill').val()||0;
		var sumdiscount	= parseFloat(sumtotal*discount)/100;
		var summary 	= parseFloat(total);
		var totalpay	= parseFloat(summary) - parseFloat(sumdiscount);
		
		//Totol
		$('#sumtotalsp').val(formatNumber(sumtotal));
		$('#sumtotal').val(sumtotal);
		//Discount
		$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
		$('#sumdiscount').val(sumdiscount.toFixed(2));
		//Totolpayment
		$('#sumpaymentsp').val(formatNumber((totalpay-lastbill).toFixed(2)));
		$('#sumpayment').val((totalpay-lastbill).toFixed(2));
		
		if(vat == 0){
			//Vat
			$('#sumvatsp').val((0).toFixed(2));
			$('#sumvat').val(0.00);
			//Totolpayment
			$('#sumpaymentsp').val(formatNumber((totalpay-lastbill).toFixed(2)));
			$('#sumpayment').val((totalpay-lastbill).toFixed(2));
			//Payment
			$('#txttotal').text(formatNumber((totalpay-lastbill).toFixed(2)));
		}else if(vat == 1){
			var sumvat 		= parseFloat(totalpay * 7)/(100);
			var payment 	= parseFloat(totalpay+sumvat);
			//Vat
			$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
			$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
			//Totolpayment
			$('#sumpaymentsp').val(formatNumber((payment-lastbill).toFixed(2)));
			$('#sumpayment').val((payment-lastbill).toFixed(2));
			//Payment
			$('#txttotal').text(formatNumber((payment-lastbill).toFixed(2)));
		}else if(vat == 2){
			var sumvat 		= parseFloat(sumtotal * 100)/(107);
			var sumvats 	= parseFloat(sumtotal - sumvat);
			
			var sumdiscount	= parseFloat(sumvat * discount)/100;
			console.log(sumdiscount);
			
			//Totolpayment
			$('#sumtotalsp').val(formatNumber(parseFloat(sumvat-sumdiscount).toFixed(2)));
			$('#sumtotal').val(parseFloat(sumvat-sumdiscount).toFixed(2));
			//Vat
			$('#sumvatsp').val(formatNumber(sumvats.toFixed(2)));
			$('#sumvat').val(sumvats.toFixed(2));
			//Discount
			$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
			$('#sumdiscount').val(sumdiscount.toFixed(2));
			//Totolpayment
			$('#sumpaymentsp').val(formatNumber(sumtotal-lastbill));
			$('#sumpayment').val(sumtotal-lastbill);
			//Payment
			$('#txttotal').text(formatNumber(sumtotal-lastbill));
		}
		<!-- /คำนวณ ยอด -->
	}
	
	function pricechange(id){
		var qty 		= $('#qty'+id).val()||0;
		var price 		= $('#price'+id).val()||0;
		var sumtotal 	= parseFloat(qty * price);
		$('#total'+id).val(sumtotal.toFixed(2));
		
		<!-- คำนวณ ยอด -->
		var total = 0;
		$("input[name = 'total[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var vat 		= $('.vat:checked').val();
		var lastbill 	= $('#discountlastbill').val()||0;
		var sumdiscount	= parseFloat(sumtotal*discount)/100;
		var summary 	= parseFloat(total);
		var totalpay	= parseFloat(summary) - parseFloat(sumdiscount);
		
		//Totol
		$('#sumtotalsp').val(formatNumber(sumtotal));
		$('#sumtotal').val(sumtotal);
		//Discount
		$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
		$('#sumdiscount').val(sumdiscount.toFixed(2));
		//Totolpayment
		$('#sumpaymentsp').val(formatNumber((totalpay-lastbill).toFixed(2)));
		$('#sumpayment').val((totalpay-lastbill).toFixed(2));
		
		if(vat == 0){
			//Vat
			$('#sumvatsp').val((0).toFixed(2));
			$('#sumvat').val(0.00);
			//Totolpayment
			$('#sumpaymentsp').val(formatNumber((totalpay-lastbill).toFixed(2)));
			$('#sumpayment').val((totalpay-lastbill).toFixed(2));
			//Payment
			$('#txttotal').text(formatNumber((totalpay-lastbill).toFixed(2)));
		}else if(vat == 1){
			var sumvat 		= parseFloat(totalpay * 7)/(100);
			var payment 	= parseFloat(totalpay+sumvat);
			//Vat
			$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
			$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
			//Totolpayment
			$('#sumpaymentsp').val(formatNumber((payment-lastbill).toFixed(2)));
			$('#sumpayment').val((payment-lastbill).toFixed(2));
			//Payment
			$('#txttotal').text(formatNumber((payment-lastbill).toFixed(2)));
		}else if(vat == 2){
			var sumvat 		= parseFloat(sumtotal * 100)/(107);
			var sumvats 	= parseFloat(sumtotal - sumvat);
			
			var sumdiscount	= parseFloat(sumvat * discount)/100;
			console.log(sumdiscount);
			
			//Totolpayment
			$('#sumtotalsp').val(formatNumber(parseFloat(sumvat-sumdiscount).toFixed(2)));
			$('#sumtotal').val(parseFloat(sumvat-sumdiscount).toFixed(2));
			//Vat
			$('#sumvatsp').val(formatNumber(sumvats.toFixed(2)));
			$('#sumvat').val(sumvats.toFixed(2));
			//Discount
			$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
			$('#sumdiscount').val(sumdiscount.toFixed(2));
			//Totolpayment
			$('#sumpaymentsp').val(formatNumber(sumtotal-lastbill));
			$('#sumpayment').val(sumtotal-lastbill);
			//Payment
			$('#txttotal').text(formatNumber(sumtotal-lastbill));
		}
		<!-- /คำนวณ ยอด -->
	}
	
	<!-- Vat Process -->
	$('input.vat').on('change', function() {
		<!-- คำนวณ ยอด -->
		var total = 0;
		$("input[name = 'total[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var vat 		= $(this).val()||0;
		var sumdiscount	= parseFloat(sumtotal*discount)/100;
		var lastbill 	= $('#discountlastbill').val()||0;
		var summary 	= parseFloat(total);
		var totalpay	= parseFloat(summary) - parseFloat(sumdiscount);
		
		//Totol
		$('#sumtotalsp').val(formatNumber(sumtotal));
		$('#sumtotal').val(sumtotal);
		//Discount
		$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
		$('#sumdiscount').val(sumdiscount.toFixed(2));
		//Totolpayment
		$('#sumpaymentsp').val(formatNumber((totalpay-lastbill).toFixed(2)));
		$('#sumpayment').val((totalpay-lastbill).toFixed(2));
		
		if(vat == 0){
			//Vat
			$('#sumvatsp').val((0).toFixed(2));
			$('#sumvat').val(0.00);
			//Totolpayment
			$('#sumpaymentsp').val(formatNumber((totalpay-lastbill).toFixed(2)));
			$('#sumpayment').val((totalpay-lastbill).toFixed(2));
			//Payment
			$('#txttotal').text(formatNumber((totalpay-lastbill).toFixed(2)));
		}else if(vat == 1){
			var sumvat 		= parseFloat(totalpay * 7)/(100);
			var payment 	= parseFloat(totalpay+sumvat);
			//Vat
			$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
			$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
			//Totolpayment
			$('#sumpaymentsp').val(formatNumber((payment-lastbill).toFixed(2)));
			$('#sumpayment').val((payment-lastbill).toFixed(2));
			//Payment
			$('#txttotal').text(formatNumber((payment-lastbill).toFixed(2)));
		}else if(vat == 2){
			var sumvat 		= parseFloat(sumtotal * 100)/(107);
			var sumvats 	= parseFloat(sumtotal - sumvat);
			var sumdiscount	= parseFloat(sumvat * discount)/100;
			
			//Totolpayment
			$('#sumtotalsp').val(formatNumber(parseFloat(sumvat-sumdiscount).toFixed(2)));
			$('#sumtotal').val(parseFloat(sumvat-sumdiscount).toFixed(2));
			//Vat
			$('#sumvatsp').val(formatNumber(sumvats.toFixed(2)));
			$('#sumvat').val(sumvats.toFixed(2));
			//Discount
			$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
			$('#sumdiscount').val(sumdiscount.toFixed(2));
			//Totolpayment
			$('#sumpaymentsp').val(formatNumber(sumtotal-lastbill));
			$('#sumpayment').val(sumtotal-lastbill);
			//Payment
			$('#txttotal').text(formatNumber(sumtotal-lastbill));
		}
		<!-- /คำนวณ ยอด -->
	});
	<!-- /Vat Process -->
	
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	
	$('#submitform').click(function(){
		$('#myForm').submit();
	});
    
    function delrow(id){
        $('#row'+id).remove();
    }

	$('#suppliername').keyup(function(){
		/* var id = $(this).val();
		$.ajax({
			url:"{{url('search_suplier')}}/"+id,
			type:"get",
		}).done(function(data){
			
			$("#supplier_address").val(data.customer_detail);
			$("#supplier_tel").val(data.customer_tel);
			$("#supplier_fax").val(data.customer_fax);
			$("#supplier_email").val(data.customer_email);
			$("#supplier_credit").val(data.customer_credit);
			$("#check_address").val(data.customer_id);
		}); */
		$(this).autocomplete({
			source: "{{url('searchcustomername/autocomplete')}}",
			minLength: 1,
			select: function(event, ui){
				$('#check_address').val(ui.item.idcus);
				$('#supplier_address').val(ui.item.addr);
				$('#supplier_tel').val(ui.item.tel);
				$('#supplier_fax').val(ui.item.fax);
				$('#supplier_email').val(ui.item.email);
				$('#supplier_credit').val(ui.item.credit);
			}
		})
		.autocomplete("instance")._renderItem = function(ul, item) {
			return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attr + '</span>').appendTo(ul);
		};
	});

	$(document).ready(function(){
	var checkBox = document.getElementById("check_address");
		if (checkBox.checked == true){
			$('#supplier_address').prop('disabled', true);
			$('#show_address').css("display",'block');
			var id = $('#check_address').val();
			$.ajax({
				url:"{{url('search_address')}}/"+id,
				type:"get",
			}).done(function(data){
				$.each(data,function(key,item){
					if(id == item.sa_cus_id){
						var $selectd = 'selected';
					}else{
						var $selectd = '';
					}
                    $('#sub_address').append('<option value="'+item.sa_id+'" '+$selectd+'>'+item.sa_address+'</option>');
				});
			});
		} else {
			$('#show_address').css("display",'none');
			$('#supplier_address').prop('disabled', false);
		}

	});
	$('#check_address').click(function(){
		var checkBox = document.getElementById("check_address");
		if (checkBox.checked == true){
			$('#supplier_address').prop('disabled', true);
			$('#show_address').css("display",'block');
			var id = $('#check_address').val();
			$.ajax({
				url:"{{url('search_address')}}/"+id,
				type:"get",
			}).done(function(data){
				$.each(data,function(key,item){
                    $('#sub_address').append('<option value="'+item.sa_id+'">'+item.sa_address+'</option>');
				});
			});
		} else {
			$('#show_address').css("display",'none');
			$('#supplier_address').prop('disabled', false);
		}
		
	});
</script>
</html>
@stop