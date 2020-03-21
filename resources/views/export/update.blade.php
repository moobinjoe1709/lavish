@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">การขาย</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li><a href="{{url('export')}}">การขาย</a></li>
				<li class="active">แก้ไขการขาย</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
	<form id="myForm" method="post" action="{{url('export_update')}}">
		{{ csrf_field() }}
		<input type="hidden" name="exportid" id="exportid" value="{{$export->export_id}}">
		<!-- 2 columns form -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">แก้ไขการขาย </h5>
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
												<input type="text" name="docdate" id="docdate" placeholder="วันที่" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" value="{{date('d/m/Y',strtotime($export->export_date))}}">
											</div>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label>พนักงานขาย :</label>
											<div class="input-group">
												<input type="text" name="empsalename" id="empsalename" class="form-control" onkeydown="return false;" autocomplete="off" value="<?php echo Auth::user()->name;?>" readonly>
												<input type="hidden" name="empsaleid" id="empsaleid" class="form-control" onkeydown="return false;" autocomplete="off" value="<?php echo Auth::user()->id;?>" readonly>
											</div>
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
											<input type="text" class="form-control" name="customername" id="customername" placeholder="ชื่อลูกค้า" autocomplete="new-password" value="{{$export->export_customername}}">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>เลขประจำตัวผู้เสียภาษีอากร :</label>
											<input type="text" class="form-control" name="customertax" id="customertax" placeholder="เลขประจำตัวผู้เสียภาษีอากร" autocomplete="off" value="{{$export->export_customertax}}">
										</div>
										<input type="hidden" name="customerid" id="customerid" value="{{$export->export_customerid}}">
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>ที่อยู่ :</label>
											<textarea name="customeraddr" id="customeraddr" rows="2" class="form-control" placeholder="ที่อยู่">{{$export->export_customeraddr}}</textarea>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>ใช้ที่อยู่เดียวกัน :</label>
											<input type="checkbox" class="styled" id="addrsame" name="addrsame">
											<br>
											<label>ที่อยู่ส่งของ :</label>
											<textarea name="customeraddrdoc" id="customeraddrdoc" rows="2" class="form-control" placeholder="ที่อยู่ส่งของ"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>เขต/อำเภอ :</label>
											<input type="text" class="form-control" name="distric" id="distric" placeholder="เขต/อำเภอ" value="{{$export->export_distric}}" required>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>จังหวัด :</label>
											<input type="text" class="form-control" name="province" id="province" placeholder="จังหวัด" value="{{$export->export_province}}">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>รหัสไปรษณีย์ :</label>
											<input type="text" class="form-control number" name="customerzipcode" id="customerzipcode" value="{{$export->export_customerzipcode}}" placeholder="รหัสไปรษณีย์">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>เบอร์โทรศัพท์ :</label>
											<input type="text" class="form-control number" name="customercontel" id="customercontel" value="{{$export->export_customertel}}" placeholder="เบอร์โทรศัพท์">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>หมายเหตุ :</label>
											<textarea name="note" id="note" rows="2" class="form-control" placeholder="หมายเหตุ">{{$export->export_customernote}}</textarea>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label>ช่องทางรับออเดอร์ :</label>
											<select class="select" name="channel" id="channel">
												<option value="Line" <?php if($export->export_channel == 'Line'){ ?> selected <?php } ?> >Line</option>
												<option value="Line@"  <?php if($export->export_channel == 'Line@'){ ?> selected  <?php } ?> >Line@</option>
												<option value="เฟสบุ๊ค"  <?php if($export->export_channel == 'เฟสบุ๊ค'){  ?> selected  <?php } ?> >เฟสบุ๊ค</option>
												<option value="เว็ปไซด์"  <?php if($export->export_channel == 'เว็ปไซด์'){ ?> selected  <?php } ?> >เว็ปไซด์</option>
												<option value="ช็อปปี้"  <?php if($export->export_channel == 'ช็อปปี้'){  ?> selected  <?php } ?> >ช็อปปี้</option>
												<option value="ลาซาด้า"  <?php if($export->export_channel == 'ลาซาด้า'){  ?> selected  <?php } ?> >ลาซาด้า</option>
												<option value="หน้าร้าน"  <?php if($export->export_channel == 'หน้าร้าน'){  ?> selected  <?php } ?> >หน้าร้าน</option>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>ช่องทางขนส่ง :</label>
											<select class="select" name="delstatus" id="delstatus">
												<option value="0" <?php if($export->export_delstatus == 0){ ?> selected <?php } ?> >Kerry</option>
												<option value="1" <?php if($export->export_delstatus == 1){ ?> selected <?php } ?> >DHL</option>
											</select>
										</div>
									</div>
								</div>
								
							</fieldset>
						</div>
			
					</div>
				</div>
			<!-- /vertical form -->
			
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
															<input type="text" id="searchbarcode" class="form-control input-xlg" placeholder="รหัสสินค้า">
															<div class="form-control-feedback">
																<i class="icon-barcode2"></i>
															</div>
														</div>
													</div>

													<div class="col-md-2">
														<div class="form-group has-feedback has-feedback-left">
															<input type="text" id="searchproduct" class="form-control input-xlg" placeholder="ชื่อสินค้า">
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
													<th class="text-center" style="width:100px;">ราคาขาย</th>
													<th class="text-center">จำนวน</th>
													<th class="text-center">รวม</th>
													<th class="text-center">#</th>
												</tr>
											</thead>
											<tbody id="rowdata">
												@php
													if($orders){
														foreach($orders as $key => $rs){
															$code = $rs->order_productid;
															@endphp
															<tr class="rowproduct" id="row{{$key}}"><td align="center">{{$rs->product_code}} </td>
																<td>{{$rs->product_name}}<input type="hidden" name="productid[]" value="{{$rs->order_productid}}"></td>
																<td align="right"><input type="text" class="form-control" name="productprice[]" id="price{{$key}}" onkeyup="changeprice({{$code}},$key)" style="width:70px" value="{{$rs->order_price}}"></td>
																<td align="center"><input type="text" class="form-control number" name="productqty[]" id="qty{{$key}}" onkeyup="qtypush({{$code}},$key)" value="{{$rs->order_qty}}" style="width:70px"></td>
																<td align="right"><span id="totalprosp{{$key}}">{{number_format($rs->order_total,2)}}</span><input type="hidden" name="totalpro[]" id="totalpro{{$key}}" value="{{$rs->order_total}}"></td>
																<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow({{$code}},{{$key}})"><i class="icon-cancel-square position-left"></i> Delete</button></td>
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
													<input type="text" id="sumtotalsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{number_format($export->export_total,2)}}" autocomplete="off">
													<input type="hidden" class="form-control" name="sumtotal" id="sumtotal" value="{{$export->export_total}}" readonly>
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
													<label class="control-label col-md-4">ส่วนลด</label>
													<div class="col-md-8">
														<?php 
															$discount = array(5,10,15,20,25,30);
														?>
														<select name="discount" id="discount" class="form-control">
															<option value="0">ไม่มีส่วนลด</option>
															<?php
																foreach($discount as $dis){
																	if($export->export_discount == $dis){
																		echo '<option value="'.$dis.'" selected>'.$dis.' %</option>';
																	}else{
																		echo '<option value="'.$dis.'">'.$dis.' %</option>';
																	}
																}
															?>
														</select>
													</div>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label col-md-4"><span id="fontdis"></span></label>
													<div class="col-md-8">
														<input type="text" id="sumdiscountsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{number_format($export->export_discountsum,2)}}" autocomplete="off">
														<input type="hidden" class="form-control" name="sumdiscount" id="sumdiscount" value="{{$export->export_discountsum}}" readonly>
													</div>
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
															<input type="radio" class="control-success vat" name="vat" id="vat1" value="0" {{ $export->export_vat == 0 ? 'checked' : '' }}  >No Vat
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="control-success vat" name="vat" id="vat2" value="1" {{ $export->export_vat == 1 ? 'checked' : '' }} >Exclude Vat
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="control-success vat" name="vat" id="vat3" value="2" {{ $export->export_vat == 2 ? 'checked' : '' }}>Include Vat
														</label>
													</div>
												</div>
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label col-md-4"><span id="fontvat"><strong>ภาษีมูลค่าเพิ่ม</strong></span></label>
												<div class="col-md-8">
													<input type="text" id="sumvatsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{number_format($export->export_vatsum,2)}}" autocomplete="off">
													<input type="hidden" class="form-control" name="sumvat" id="sumvat" value="{{$export->export_vatsum}}" readonly>
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
													<label class="control-label col-md-4">ส่วนลดท้ายบิล</label>
													<div class="col-md-8">
														<input type="text" class="form-control number" name="discountlastbill" id="discountlastbill" value="{{$export->export_lastbill}}">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label col-md-4"><span><strong>รวมทั้งสิ้น</strong></span></label>
													<div class="col-md-8">
														<input type="text" id="sumpaymentsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{number_format($export->export_totalpayment,2)}}" autocomplete="off">
														<input type="hidden" class="form-control" name="sumpayment" id="sumpayment" value="{{$export->export_totalpayment}}" readonly>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							<!-- Modal -->
							  <div class="modal fade" id="mypromotion" role="dialog">
								<div class="modal-dialog">
								
								  <!-- Modal content-->
								  <div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal">&times;</button>
									  <h4 class="modal-title">เลือกโปรโมชั่น</h4>
									</div>
									<div class="modal-body" id="promotionlist">
									  
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
									</div>
								  </div>
								  
								</div>
							  </div>
							  
							  <div class="modal fade" id="myshipping" role="dialog">
								<div class="modal-dialog">
								
								  <!-- Modal content-->
								  <div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal">&times;</button>
									  <h4 class="modal-title">เลือกชื่ออื่นๆ</h4>
									</div>
									<div class="modal-body" id="shippinglist">
									  
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
									</div>
								  </div>
								  
								</div>
							  </div>
  
								<!-- Modal -->
								<div class="modal fade" id="mypayment" role="dialog">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">ประเภทการชำระ</h4>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-12 text-center">
														<button type="button" class="btn btn-primary btn-float" id="creditpay"><i class="icon-credit-card"></i> <span>&nbsp;&nbsp;เครดิต&nbsp;&nbsp;</span></button>
														<button type="button" class="btn btn-danger btn-float btn-float-lg" id="cashpay"><i class="icon-cash3"></i> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เงินสด&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></button>
														<button type="button" class="btn btn-success btn-float" id="bankpay"><i class="icon-credit-card2"></i> <span>โอนบัญชี</span></button>
													</div>
												</div>
												<br></br>
												<div class="row">
													<input type="hidden" id="countcash" value="{{$ccash}}">
													<div id="rowcash">
														@php
															if($payment){
																$cash = 0;
																foreach($payment as $key => $ar){
																	if($ar->payment_type == 1){
																		$cash += $ar->payment_amount;
																		@endphp
																		<div class="col-md-12" id="cashrow{{$key+1}}">
																			<div class="col-md-2">
																				<label for="email" style="margin-top:8px;">เงินสด </label>
																			</div>
																			<div class="col-md-2">
																				<input type="text"  class="form-control amountcash" name="amountcash[]" id="amountcash{{$key+1}}" placeholder="เงินสด" onkeypress="return isNumberKey(event);" value="{{number_format($ar->payment_amount)}}">
																			</div>
																			<div class="col-md-1">
																				<label for="email" style="margin-top:8px;">บาท </label>
																			</div>
																			<div class="col-md-5"></div>
																			<div class="col-md-1">
																				<button type="button" class="btn btn-danger btn-icon" onclick="delcash({{$key+1}})"><i class="icon-minus-circle2"></i></button>
																			</div><br><br>
																		</div>
																		@php
																	}
																}
															}
														@endphp
													</div>
												</div>
												<br>
												<div class="row">
													<input type="hidden" id="countcredit" value="{{$ccredit}}">
													<div id="rowcredit">
														@php
															if($payment){
																$credit = 0;
																foreach($payment as $k => $a){
																	if($a->payment_type == 2){
																		$credit += $a->payment_amount;
																		@endphp
																		<div class="col-md-12" id="creditrow{{$k+1}}">
																			<div class="col-md-2">
																				<label for="email" style="margin-top:8px;">บัตรเครดิต </label>
																			</div>
																			<div class="col-md-2">
																				<select class="form-control" name="typecredit[]" id="typecredit{{$k+1}}">
																					<option value="visa" @php if($a->payment_status == 'visa'){ @endphp selected @php } @endphp>Visa</option>
																					<option value="mastercard" @php if($a->payment_status == 'mastercard'){ @endphp selected @php } @endphp>Master card</option>
																					<option value="amex" @php if($a->payment_status == 'amex'){ @endphp selected @php } @endphp>Amex</option>
																					<option value="otherc" @php if($a->payment_status == 'otherc'){ @endphp selected @php } @endphp>Other</option>
																				</select>
																			</div>
																			<div class="col-md-2 ">
																				<input type="text"  class="form-control refcredit" name="refcredit[]" id="refcredit{{$k+1}}" value="{{$a->payment_refcredit}}" placeholder="เลขอ้างอิงเครดิต" onkeypress="return isNumberKey(event);">
																			</div>
																			<div class="col-md-2">
																				<input type="text"  class="form-control amountcredit" name="amountcredit[]" id="amountcredit{{$k+1}}" placeholder="บัตรเครดิต" onkeypress="return isNumberKey(event);" value="{{number_format($a->payment_amount)}}">
																			</div>
																			<div class="col-md-1">
																				<label for="email" style="margin-top:8px;">บาท </label>
																			</div>
																			<div class="col-md-3"></div>
																			<div class="col-md-1">
																				<button type="button" class="btn btn-danger btn-icon" onclick="delcredit({{$k+1}})"><i class="icon-minus-circle2"></i></button>
																			</div><br><br>
																		</div>
																		@php
																	}
																}
															}
														@endphp
													</div>
												</div>
												<br>
												<div class="row">
													<input type="hidden" id="countbank" value="{{$cbank}}">
													<div id="rowbank">
														@php
															if($payment){
																$bank = 0;
																foreach($payment as $r => $v){
																	if($v->payment_type == 3){
																		$bank += $v->payment_amount;
																		@endphp
																		<div class="col-md-12" id="bankrow{{$r+1}}">
																			<div class="col-md-1">
																				<label for="email" style="margin-top:8px;">โอนผ่านบัญชี </label>
																			</div>
																			<div class="col-md-2">
																				<select class="form-control" name="bank[]" id="bank{{$r+1}}">
																					@php
																						if($banks){
																							foreach($banks as $bk){
																								if($v->payment_status == $bk->title){
																									@endphp
																									<option value="{{$bk->title}}" selected>{{$bk->name}}</option>
																									@php
																								}else{
																									@endphp
																									<option value="{{$bk->title}}">{{$bk->name}}</option>
																									@php
																								}
																							}
																						}
																					@endphp
																				</select>
																			</div>
																			<div class="col-md-2">
																				<input type="text" name="bankdate[]" id="bankdate{{$r+1}}" placeholder="วันที่" class="form-control datepicker-dates" value="{{date('d/m/Y',strtotime($v->payment_datebank))}}" onkeydown="return false;" autocomplete="off">
																			</div>
																			<div class="col-md-2">
																				<input type="text" class="form-control " name="banktime[]" id="banktime{{$r+1}}" value="{{$v->payment_datetimebank}}" placeholder="เวลา">
																			</div>
																			<div class="col-md-2">
																				<input type="text"  class="form-control amountbank" name="amountbank[]" id="amountbank{{$r+1}}" value="{{number_format($v->payment_amount)}}" placeholder="จำนวนเงิน" onkeypress="return isNumberKey(event);">
																			</div>
																			<div class="col-md-1">
																				<label for="email" style="margin-top:8px;">บาท </label>
																			</div>
																			<div class="col-md-1">
																				<button type="button" class="btn btn-danger btn-icon" onclick="delbank({{$r+1}})"><i class="icon-minus-circle2"></i></button>
																			</div><br><br>
																		</div>
																		@php
																	}
																}
															}
														@endphp
													</div>
												</div>
												<br>
												<div class="row">
													<div class="pull-right">
														<table width="100%">
															<tr>
																<td></td>
																<td></td>
																<td width="250px;"><font size="3" color="green">มูลค่า  :</font></td>
																<td><font size="3" color="green"><span id="txttotal">{{number_format($export->export_totalpayment,2)}}</span></font></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td width="250px;"><font size="3">เงินสด  :</font></td>
																<td><font size="3"><span id="txtcash">{{$cash}}</span></font></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td width="250px;"><font size="3">บัตรเครดิต  :</font></td>
																<td><font size="3"><span id="txtcredit">{{$credit}}</span></font></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td width="250px;"><font size="3">โอนผ่านบัญชี  :</font></td>
																<td><font size="3"><span id="txtbank">{{$bank}}</span></font></td>
															</tr>
															<tr>
																<td width="250px;" valign="top"><textarea class="form-control" name="comment" id="comment" rows="3" placeholder="หมายเหตุ">{{$export->export_comment}}</textarea></td>
																<td width="250px;" valign="top"><input type="checkbox" class="styled" id="castofdel" name="castofdel"> เก็บเงินปลายทาง</td>
																<td width="250px;"><font size="3" color="blue">ยอดชำระทั้งหมด  :</font></td>
																<td><font size="3" color="blue"><span id="txtallpayment">{{number_format($export->export_totalpayment,2)}}</span></font> <input type="hidden" name="cashallpayment" id="cashallpayment" value="0"></td>
															</tr>
														</table>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button>
												<button type="button" id="save" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
											</div>
										</div>
									</div>
								</div>
								
								<br>

								<div class="text-right">
									<a href="{{url('export')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
									<button type="button" id="submitform" class="btn btn-primary"><i class="icon-floppy-disk"></i>  ชำระ</button>
								</div>
							</div>
						</div>
					<!-- /basic layout -->
				</div>
			</div>
			<!-- /vertical form options -->
			</form>	
		<!-- /2 columns form -->
	
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
</body>
<script>
	var html = '';
	$(document).ready(function(){
		$('.number').keypress(function(event) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});
		
		$.ajax({
		'dataType': 'json',
		'type': 'post',
		'url': "{{url('bankselect')}}",
		'data': {
			'_token': "{{ csrf_token() }}"
		},
			'success': function(data){
				$.each(data,function(k,v){
					html += '<option value="'+v.id+'">'+v.name+'</option>';
				});
			}
		});
	});
	
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
			'url': "{{url('enterproduct')}}",
			'data': {
				'productid': id,
				'_token': "{{ csrf_token() }}"
			},
				'success': function(data){
					$.each(data.results,function(key,item){
						var find = 0;
						// $('#rowdata tr').each(function(k,v){
						// 	if($(this).is('#row'+item.id) == true){
						// 		find = 1;
						// 	}                 
						// });
						var n = $(".rowproduct" ).length;
						console.log(find);	
						console.log(n);			
						if(find == 0){
							$('#myserial').modal('show');
							$('#rowdata').append('<tr class="rowproduct" id="row'+n+'"><td align="center">'+item.code+'</td>'
								+'<td>'+item.name+'<input type="hidden" name="productid[]" value="'+item.id+'"></td>'
								+'<td align="right"><input type="text" class="form-control" name="productprice[]" id="price'+n+'" onkeyup="changeprice(\''+item.id+'\'\,\''+n+'\')" style="width:70px" value="'+item.price+'">'
								+'<td align="center"><input type="text" class="form-control number" name="productqty[]" id="qty'+n+'" onkeyup="qtypush(\''+item.id+'\'\,\''+n+'\')" value="1" style="width:70px"></td>'
								+'<td align="right"><span id="totalprosp'+n+'"></span><input type="hidden" name="totalpro[]" id="totalpro'+n+'"></td>'
								+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow(\''+item.id+'\'\,\''+n+'\')"><i class="icon-cancel-square position-left"></i> Delete</button></td>'
							+'</tr>');
							var price = $('#price'+n).val()||0;
							var total = parseFloat(price*1);
							$('#totalprosp'+n).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+n).val(total);
						}else{
							var qty = $('#qty'+item.id).val();
							var sum = parseInt(qty)+1;
							var price = $('#price'+item.id).val()||0;
							var total = parseFloat(price*sum);
							
							$.ajax({
							'dataType': 'json',
							'type': 'post',
							'url': "{{url('querypromotion')}}",
							'data': {
								'product': item.id,
								'qty': sum,
								'_token': "{{ csrf_token() }}"
							},
								'success': function(data){
									$('.productradio').remove();
									if(data.count > 0){
										$.each(data.result,function(k,v){
											$('#promotionlist').append('<div class="productradio">'
											  +'<label><input type="radio" name="optradiopro" onclick="changpromotion('+v.product_id+','+v.price_price+','+n+')">  '+v.product_name+'  ราคา : '+formatNumber(v.price_price)+'  '+v.price_promotion+'</label>'
											+'</div>');
										});
										$('#mypromotion').modal('show');
									}
								}
							});
							
							$('#qty'+item.id).val(sum);
							$('#totalprosp'+item.id).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+item.id).val(total);
						}
						
						$('#searchproduct').val('');
						$('#searchproduct').trigger("focus");

					});
					
					<!-- คำนวณ ยอด -->
					var total = 0;
					$("input[name = 'totalpro[]']").each(function(){
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
			}); 
		
		$('#myproductdata').modal('hide');
	}
	
	$('#customername').keyup(function(){
		$(this).autocomplete({
			source: "{{url('searchcustomername/autocomplete')}}",
			minLength: 1,
			select: function(event, ui){
				$('#customerid').val(ui.item.idcus);
				$('#customeraddr').val(ui.item.addr);
				$('#customeraddrdoc').val(ui.item.addrdoc);
				$('#customercontel').val(ui.item.tel);
				$('#customerzipcode').val(ui.item.zipcode);
				$('#note').val(ui.item.note);
				
				$.ajax({
				'dataType': 'json',
				'type': 'post',
				'url': "{{url('customerref')}}",
				'data': {
					'id' : ui.item.idcus,
					'_token': "{{ csrf_token() }}"
				},
					'success': function(data){
						$('.customerradio').remove();
						if(data.count > 0){
							$.each(data.result,function(k,v){
								$('#shippinglist').append('<div class="customerradio">'
								  +'<label><input type="radio" name="optradiopro" onclick="changshipping(\''+v.shipping_name+'\',\''+v.shipping_tax+'\',\''+v.shipping_addr+'\',\''+v.shipping_tel+'\',\''+v.zipcode+'\',\''+v.shipping_note+'\')">  '+v.shipping_name+'  '+v.shipping_addr+'  '+v.shipping_tel+'</label>'
								+'</div>');
							});
							$('#myshipping').modal('show');
						}
					}
				});
			}
		})
		.autocomplete("instance")._renderItem = function(ul, item) {
			return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attr + '</span>').appendTo(ul);
		};
	});
	
	$('#customercontel').keyup(function(){
		$(this).autocomplete({
			source: "{{url('searchcustomertel/autocomplete')}}",
			minLength: 1,
			select: function(event, ui){
				$('#customername').val(ui.item.name);
				$('#customerid').val(ui.item.idcus);
				$('#customeraddr').val(ui.item.addr);
				$('#customeraddrdoc').val(ui.item.addrdoc);
				$('#customercontel').val(ui.item.tel);
				$('#customerzipcode').val(ui.item.zipcode);
				$('#note').val(ui.item.note);
				
				$.ajax({
				'dataType': 'json',
				'type': 'post',
				'url': "{{url('customerref')}}",
				'data': {
					'id' : ui.item.idcus,
					'_token': "{{ csrf_token() }}"
				},
					'success': function(data){
						$('.customerradio').remove();
						if(data.count > 0){
							$.each(data.result,function(k,v){
								$('#shippinglist').append('<div class="customerradio">'
								  +'<label><input type="radio" name="optradiopro" onclick="changshipping(\''+v.shipping_name+'\',\''+v.shipping_tax+'\',\''+v.shipping_addr+'\',\''+v.shipping_tel+'\',\''+v.zipcode+'\',\''+v.shipping_note+'\')">  '+v.shipping_name+'  '+v.shipping_addr+'  '+v.shipping_tel+'</label>'
								+'</div>');
							});
							$('#myshipping').modal('show');
						}
					}
				});
			}
		})
		.autocomplete("instance")._renderItem = function(ul, item) {
			return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attr + '</span>').appendTo(ul);
		};
	});
	
	function changshipping(name,tax,addr,tel,zipcode,note){
		$('#customername').val(name);
		$('#customertax').val(tax);
		$('#customeraddr').val(addr);
		$('#customeraddrdoc').val(addr);
		$('#customercontel').val(tel);
		$('#customerzipcode').val(zipcode);
		$('#note').val(note);
		$('#myshipping').modal('hide');
	}
	
	$('#customertax').keyup(function(){
		$(this).autocomplete({
			source: "{{url('searchcustomertax/autocomplete')}}",
			minLength: 1,
			select: function(event, ui){
				$('#customerid').val(ui.item.idcus);
				$('#customertax').val(ui.item.idtax);
				$('#customeraddr').val(ui.item.addr);
				$('#customeraddrdoc').val(ui.item.addrdoc);
				$('#customercontel').val(ui.item.tel);
				$('#customerzipcode').val(ui.item.zipcode);
				$('#note').val(ui.item.note);
			}
		})
		.autocomplete("instance")._renderItem = function(ul, item) {
			return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attr + '</span>').appendTo(ul);
		};
	});
	
	$('#searchbarcode').keyup(function(e){
		if(e.which == 13){
			$.ajax({
			'dataType': 'json',
			'type': 'post',
			'url': "{{url('enterbarcode')}}",
			'data': {
				'barcode': $('#searchbarcode').val(),
				'_token': "{{ csrf_token() }}"
			},
				'success': function(data){
					$.each(data.results,function(key,item){
						var find = 0;
						// $('#rowdata tr').each(function(k,v){
						// 	if($(this).is('#row'+item.id) == true){
						// 		find = 1;
						// 	}                 
						// });
						var n = $(".rowproduct" ).length;
						console.log(n);			
						console.log(find);				
						if(find == 0){
							$('#myserial').modal('show');
							$('#rowdata').append('<tr class="rowproduct" id="row'+n+'"><td align="center">'+item.code+'</td>'
								+'<td>'+item.name+'<input type="hidden" name="productid[]" value="'+item.id+'"></td>'
								+'<td align="right"><input type="text" class="form-control" name="productprice[]" id="price'+n+'" onkeyup="changeprice(\''+item.id+'\'\,\''+n+'\')" style="width:70px" value="'+item.price+'">'
								+'<td align="center"><input type="text" class="form-control number" name="productqty[]" id="qty'+n+'" onkeyup="qtypush(\''+item.id+'\'\,\''+n+'\')" value="1" style="width:70px"></td>'
								+'<td align="right"><span id="totalprosp'+n+'"></span><input type="hidden" name="totalpro[]" id="totalpro'+n+'"></td>'
								+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow(\''+item.id+'\'\,\''+n+'\')"><i class="icon-cancel-square position-left"></i> Delete</button></td>'
							+'</tr>');
							var price = $('#price'+n).val()||0;
							var total = parseFloat(price*1);
							$('#totalprosp'+n).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+n).val(total);
						}else{
							var qty = $('#qty'+item.id).val();
							var sum = parseInt(qty)+1;
							var price = $('#price'+item.id).val()||0;
							var total = parseFloat(price*sum);
							
							$.ajax({
							'dataType': 'json',
							'type': 'post',
							'url': "{{url('querypromotion')}}",
							'data': {
								'product': item.id,
								'qty': sum,
								'_token': "{{ csrf_token() }}"
							},
								'success': function(data){
									$('.productradio').remove();
									if(data.count > 0){
										$.each(data.result,function(k,v){
											$('#promotionlist').append('<div class="productradio">'
											  +'<label><input type="radio" name="optradiopro" onclick="changpromotion('+v.product_id+','+v.price_price+','+n+')">  '+v.product_name+'  ราคา : '+formatNumber(v.price_price)+'  '+v.price_promotion+'</label>'
											+'</div>');
										});
										$('#mypromotion').modal('show');
									}
								}
							});
					
							$('#qty'+item.id).val(sum);
							$('#totalprosp'+item.id).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+item.id).val(total);
						}
						
						$('#searchbarcode').val('');
						$('#searchbarcode').trigger("focus");

					});
					
					<!-- คำนวณ ยอด -->
					var total = 0;
					$("input[name = 'totalpro[]']").each(function(){
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
						$('#txttotal').text(formatNumber((totalpay-lastbill).toFixed(2)));
					}else if(vat == 1){
						var sumvat 		= parseFloat(totalpay * 7)/(100);
						var payment 	= parseFloat(totalpay+sumvat) - lastbill;
						//Vat
						$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
						$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
						//Totolpayment
						$('#sumpaymentsp').val(formatNumber(payment.toFixed(2)));
						$('#sumpayment').val(payment.toFixed(2));
						//Payment
						$('#txttotal').text(formatNumber(payment.toFixed(2)));
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
				}
			}); 
		}
	});
	
	$("#searchproduct").autocomplete({
		source: "{{url('searchproductname/autocomplete')}}",
		minLength: 1,
		select: function(event, ui){
			$('#nameid').val(ui.item.id);
			$.ajax({
			'dataType': 'json',
			'type': 'post',
			'url': "{{url('enterproduct')}}",
			'data': {
				'productid': ui.item.id,
				'_token': "{{ csrf_token() }}"
			},
				'success': function(data){
					$.each(data.results,function(key,item){
						var find = 0;
						$('#rowdata tr').each(function(k,v){
							if($(this).is('#row'+item.id) == true){
								find = 1;
							}                 
						});
						
						var n = $(".rowproduct" ).length;
						console.log(n);				
						if(find == 0){
							$('#myserial').modal('show');
							$('#rowdata').append('<tr class="rowproduct" id="row'+n+'"><td align="center">'+item.code+'</td>'
								+'<td>'+item.name+'<input type="hidden" name="productid[]" value="'+item.id+'"></td>'
								+'<td align="right"><input type="text" class="form-control" name="productprice[]" id="price'+n+'" onkeyup="changeprice(\''+item.id+'\'\,\''+n+'\')" style="width:70px" value="'+item.price+'">'
								+'<td align="center"><input type="text" class="form-control number" name="productqty[]" id="qty'+n+'" onkeyup="qtypush(\''+item.id+'\'\,\''+n+'\')" value="1" style="width:70px"></td>'
								+'<td align="right"><span id="totalprosp'+n+'"></span><input type="hidden" name="totalpro[]" id="totalpro'+n+'"></td>'
								+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow(\''+item.id+'\'\,\''+n+'\')"><i class="icon-cancel-square position-left"></i> Delete</button></td>'
							+'</tr>');
							var price = $('#price'+item.id).val()||0;
							var total = parseFloat(price*1);
							$('#totalprosp'+item.id).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+item.id).val(total);
						}else{
							var qty = $('#qty'+item.id).val();
							var sum = parseInt(qty)+1;
							var price = $('#price'+item.id).val()||0;
							var total = parseFloat(price*sum);
							
							$.ajax({
							'dataType': 'json',
							'type': 'post',
							'url': "{{url('querypromotion')}}",
							'data': {
								'product': item.id,
								'qty': sum,
								'_token': "{{ csrf_token() }}"
							},
								'success': function(data){
									$('.productradio').remove();
									if(data.count > 0){
										$.each(data.result,function(k,v){
											$('#promotionlist').append('<div class="productradio">'
											  +'<label><input type="radio" name="optradiopro" onclick="changpromotion('+v.product_id+','+v.price_price+','+n+')">  '+v.product_name+'  ราคา : '+formatNumber(v.price_price)+'  '+v.price_promotion+'</label>'
											+'</div>');
										});
										$('#mypromotion').modal('show');
									}
								}
							});
							
							$('#qty'+item.id).val(sum);
							$('#totalprosp'+item.id).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+item.id).val(total);
						}
						
						$('#searchproduct').val('');
						$('#searchproduct').trigger("focus");

					});
					
					<!-- คำนวณ ยอด -->
					var total = 0;
					$("input[name = 'totalpro[]']").each(function(){
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
			}); 
		}
	})
	.autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attrs + '</span>').appendTo(ul);
	};
	
	function qtypush(id,n){
		var total 		= 0;
		var qty 		= $('#qty'+n).val()||0;
		var price 		= $('#price'+n).val()||0;
		var totalpro 	= qty*price;
		
		$.ajax({
		'dataType': 'json',
		'type': 'post',
		'url': "{{url('querypromotion')}}",
		'data': {
			'product': id,
			'qty': qty,
			'_token': "{{ csrf_token() }}"
		},
			'success': function(data){
				$('.productradio').remove();
				if(data.count > 0){
					$.each(data.result,function(k,v){
						$('#promotionlist').append('<div class="productradio">'
						  +'<label><input type="radio" name="optradiopro" onclick="changpromotion('+v.product_id+','+v.price_price+','+n+')">  '+v.product_name+'  ราคา : '+formatNumber(v.price_price)+'  '+v.price_promotion+'</label>'
						+'</div>');
					});
					$('#mypromotion').modal('show');
				}
			}
		});
							
		$('#totalprosp'+n).text(formatNumber(totalpro.toFixed(2)));
		$('#totalpro'+n).val(totalpro.toFixed(2));
		
		<!-- คำนวณ ยอด -->
		$("input[name = 'totalpro[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var vat 		= $('.vat:checked').val();
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
	}
	
	function changeprice(id,n){
		var total 		= 0;
		var qty 		= $('#qty'+n).val()||0;
		var price 		= $('#price'+n).val()||0;
		var totalpro 	= qty*price;
		
		$('#totalprosp'+n).text(formatNumber(totalpro.toFixed(2)));
		$('#totalpro'+n).val(totalpro.toFixed(2));
		
		<!-- คำนวณ ยอด -->
		$("input[name = 'totalpro[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var vat 		= $('.vat:checked').val();
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
	}
	
	<!-- Discount Process -->
	$('#discount').change(function(){
		<!-- คำนวณ ยอด -->
		var total = 0;
		$("input[name = 'totalpro[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $(this).val()||0;
		var vat 		= $('.vat:checked').val();
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
	<!-- /Discount Process -->
	
	<!-- Vat Process -->
	$('input.vat').on('change', function() {
		<!-- คำนวณ ยอด -->
		var total = 0;
		$("input[name = 'totalpro[]']").each(function(){
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
	
	function changpromotion(id,price,n){
		var total 		= 0;
		$('#totalprosp'+n).text(formatNumber(price.toFixed(2)));
		$('#totalpro'+n).val(price.toFixed(2));
		
		<!-- คำนวณ ยอด -->
		$("input[name = 'totalpro[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var vat 		= $('.vat:checked').val();
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
		$('#mypromotion').modal('hide');
	}
	
	function delrow(id,n){
		var total = 0;
		$('#row'+n).closest('tr').remove();
		
		<!-- คำนวณ ยอด -->
		$("input[name = 'totalpro[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var vat 		= $('.vat:checked').val();
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
	}
	
	<!-- Discountlastbill Process -->
	$('#discountlastbill').keyup(function(){
		var lastbill = $(this).val()||0;
		var total = 0;
		
		<!-- คำนวณ ยอด -->
		$("input[name = 'totalpro[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var vat 		= $('.vat:checked').val();
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
	<!-- /Discountlastbill Process -->
	
	$('#submitform').click(function(){
		$('#mypayment').modal('show');
		
		var sumcash 	= 0;
		var sumcredit 	= 0;
		var sumbank 	= 0;
		var sumcash 	= 0;
		
		$('input[name="amountcash[]"]').each(function() {
			var cashvalue 		= $(this).val();
			var newcash 		= cashvalue.replace(/,/g,'')||0;
			sumcash				+= parseFloat(newcash);
		});
		
		$('input[name="amountcredit[]"]').each(function() {
			var creditvalue 	= $(this).val();
			var newcredit 		= creditvalue.replace(/,/g,'')||0;
			sumcredit			+= parseFloat(newcredit);
		});
		
		$('input[name="amountbank[]"]').each(function() {
			var bankvalue 		= $(this).val();
			var newbank 		= bankvalue.replace(/,/g,'')||0;
			sumbank				+= parseFloat(newbank);
		});
		
		// console.log(sumcash);
		// console.log(sumcredit);
		// console.log(sumbank);
		var sumamount			= parseFloat(sumcash)+parseFloat(sumcredit)+parseFloat(sumbank);
		var sumtotalall			= $('#sumtotalall').val()||0;
		
		
		$('#txtcash').text(formatNumber(sumcash.toFixed(2)));
		$('#txtcredit').text(formatNumber(sumcredit.toFixed(2)));
		$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
		$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
		$('#txtallpayment').text(formatNumber(sumamount.toFixed(2)));
		$('#cashallpayment').val(sumamount.toFixed(2));

		
	});
	
	$('#cashpay').click(function(){
		var countrow 	= $('#countcash').val()||0;
		var sum 		= parseInt(countrow)+(1);
		$('#countcash').val(sum);
		$('#rowcash').append('<div class="col-md-12" id="cashrow'+sum+'">'
			+'<div class="col-md-2">'
				+'<label for="email" style="margin-top:8px;">เงินสด </label>'
			+'</div>'
			+'<div class="col-md-3 ">'
				+'<input type="text"  class="form-control amountcash" name="amountcash[]" id="amountcash'+sum+'" placeholder="เงินสด" onkeypress="return isNumberKey(event);">'
			+'</div>'
			+'<div class="col-md-1">'
				 +'<label for="email" style="margin-top:8px;">บาท </label>'
			+'</div>'
			+'<div class="col-md-5"></div>'
			+'<div class="col-md-1">'
				 +'<button type="button" class="btn btn-danger btn-icon" onclick="delcash('+sum+')"><i class="icon-minus-circle2"></i></button>'
			+'</div><br><br>'
		+'</div>');
		
		
	});
	
	$('.amountcash').keyup(function(){
			$(this).val(function(index, value) {
				return value
				.replace(/(?!-)[^0-9.]/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			});
			
			var sumcash 	= 0;
			var sumcredit 	= 0;
			var sumbank 	= 0;
			var sumcash 	= 0;
			
			$('input[name="amountcash[]"]').each(function() {
				var cashvalue 		= $(this).val();
				var newcash 		= cashvalue.replace(/,/g,'')||0;
				sumcash				+= parseFloat(newcash);
			});
			
			$('input[name="amountcredit[]"]').each(function() {
				var creditvalue 	= $(this).val();
				var newcredit 		= creditvalue.replace(/,/g,'')||0;
				sumcredit			+= parseFloat(newcredit);
			});
			
			$('input[name="amountbank[]"]').each(function() {
				var bankvalue 		= $(this).val();
				var newbank 		= bankvalue.replace(/,/g,'')||0;
				sumbank				+= parseFloat(newbank);
			});
			
			// console.log(sumcash);
			// console.log(sumcredit);
			// console.log(sumbank);

			var sumamount			= parseFloat(sumcash)+parseFloat(sumcredit)+parseFloat(sumbank);
			var sumtotalall			= $('#sumtotalall').val()||0;
			
			$('#txtcash').text(formatNumber(sumcash.toFixed(2)));
			$('#txtcredit').text(formatNumber(sumcredit.toFixed(2)));
			$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
			$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
			$('#txtallpayment').text(formatNumber(sumamount.toFixed(2)));
			$('#cashallpayment').val(sumamount.toFixed(2));
			
			//Check cash
			var totalpay = $('#cashallpayment').val()||0;
			var txttotal = $('#txttotal').text().replace(/,/g,'')||0;
			if(parseFloat(txttotal) < parseFloat(totalpay)){
				bootbox.alert("ไม่สามารถจ่ายชำระเกินจากราคาที่กำหนด...");
			}
		});

	function delcash(id){
		$('#cashrow'+id).closest('div').remove();
		
		var sumcash 	= 0;
		var sumcredit 	= 0;
		var sumbank 	= 0;
		var sumcash 	= 0;
		
		$('input[name="amountcash[]"]').each(function() {
			var cashvalue 		= $(this).val();
			var newcash 		= cashvalue.replace(/,/g,'')||0;
			sumcash				+= parseFloat(newcash);
		});
		
		$('input[name="amountcredit[]"]').each(function() {
			var creditvalue 	= $(this).val();
			var newcredit 		= creditvalue.replace(/,/g,'')||0;
			sumcredit			+= parseFloat(newcredit);
		});
		
		$('input[name="amountbank[]"]').each(function() {
			var bankvalue 		= $(this).val();
			var newbank 		= bankvalue.replace(/,/g,'')||0;
			sumbank				+= parseFloat(newbank);
		});
		
		var sumamount			= parseFloat(sumcash)+parseFloat(sumcredit)+parseFloat(sumbank);
		var sumtotalall			= $('#sumtotalall').val()||0;
		
		$('#txtcash').text(formatNumber(sumcash.toFixed(2)));
		$('#txtcredit').text(formatNumber(sumcredit.toFixed(2)));
		$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
		$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
		$('#txtallpayment').text(formatNumber(sumamount.toFixed(2)));
		$('#cashallpayment').val(sumamount.toFixed(2));
	}
	
	$('#creditpay').click(function(){
		var countrow 	= $('#countcredit').val()||0;
		var sum 		= parseInt(countrow)+(1);
		$('#countcredit').val(sum);
		$('#rowcredit').append('<div class="col-md-12" id="creditrow'+sum+'">'
			+'<div class="col-md-2">'
				+'<label for="email" style="margin-top:8px;">บัตรเครดิต </label>'
			+'</div>'
			+'<div class="col-md-2">'
				+'<select class="form-control" name="typecredit[]" id="typecredit'+sum+'">'
					+'<option value="visa">Visa</option>'
					+'<option value="mastercard">Master card</option>'
					+'<option value="amex">Amex</option>'
					+'<option value="otherc">Other</option>'
				+'</select>'
			+'</div>'
			+'<div class="col-md-2 ">'
				+'<input type="text"  class="form-control refcredit" name="refcredit[]" id="refcredit'+sum+'" value="" placeholder="เลขอ้างอิงเครดิต" onkeypress="return isNumberKey(event);">'
			+'</div>'
			+'<div class="col-md-2 ">'
				+'<input type="text"  class="form-control amountcredit" name="amountcredit[]" id="amountcredit'+sum+'" value="" placeholder="จำนวนเงิน" onkeypress="return isNumberKey(event);">'
			+'</div>'
			+'<div class="col-md-1">'
				+'<label for="email" style="margin-top:8px;">บาท </label>'
			+'</div>'
			+'<div class="col-md-3"></div>'
			+'<div class="col-md-1">'
				 +'<button type="button" class="btn btn-danger btn-icon" onclick="delcredit('+sum+')"><i class="icon-minus-circle2"></i></button>'
			+'</div><br><br>'
		+'</div>');
		
		$('.amountcredit').keyup(function(){
			$(this).val(function(index, value) {
				return value
				.replace(/(?!-)[^0-9.]/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			});
			
			var sumcash 	= 0;
			var sumcredit 	= 0;
			var sumbank 	= 0;
			var sumcash 	= 0;
			
			$('input[name="amountcash[]"]').each(function() {
				var cashvalue 		= $(this).val();
				var newcash 		= cashvalue.replace(/,/g,'')||0;
				sumcash				+= parseFloat(newcash);
			});
			
			$('input[name="amountcredit[]"]').each(function() {
				var creditvalue 	= $(this).val();
				var newcredit 		= creditvalue.replace(/,/g,'')||0;
				sumcredit			+= parseFloat(newcredit);
			});
			
			$('input[name="amountbank[]"]').each(function() {
				var bankvalue 		= $(this).val();
				var newbank 		= bankvalue.replace(/,/g,'')||0;
				sumbank				+= parseFloat(newbank);
			});
			
			var sumamount			= parseFloat(sumcash)+parseFloat(sumcredit)+parseFloat(sumbank);
			var sumtotalall			= $('#sumtotalall').val()||0;
			
			$('#txtcash').text(formatNumber(sumcash.toFixed(2)));
			$('#txtcredit').text(formatNumber(sumcredit.toFixed(2)));
			$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
			$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
			$('#txtallpayment').text(formatNumber(sumamount.toFixed(2)));
			$('#cashallpayment').val(sumamount.toFixed(2));
			
			//Check cash
			var totalpay = $('#cashallpayment').val()||0;
			var txttotal = $('#txttotal').text().replace(/,/g,'')||0;
			if(parseFloat(txttotal) < parseFloat(totalpay)){
				bootbox.alert("ไม่สามารถจ่ายชำระเกินจากราคาที่กำหนด...");
			}
		});
	});
	
	function delcredit(id){
		$('#creditrow'+id).closest('div').remove();
		
		var sumcash 	= 0;
		var sumcredit 	= 0;
		var sumbank 	= 0;
		var sumcash 	= 0;
		
		$('input[name="amountcash[]"]').each(function() {
			var cashvalue 		= $(this).val();
			var newcash 		= cashvalue.replace(/,/g,'')||0;
			sumcash				+= parseFloat(newcash);
		});
		
		$('input[name="amountcredit[]"]').each(function() {
			var creditvalue 	= $(this).val();
			var newcredit 		= creditvalue.replace(/,/g,'')||0;
			sumcredit			+= parseFloat(newcredit);
		});
		
		$('input[name="amountbank[]"]').each(function() {
			var bankvalue 		= $(this).val();
			var newbank 		= bankvalue.replace(/,/g,'')||0;
			sumbank				+= parseFloat(newbank);
		});
		
		var sumamount			= parseFloat(sumcash)+parseFloat(sumcredit)+parseFloat(sumbank);
		var sumtotalall			= $('#sumtotalall').val()||0;
		
		$('#txtcash').text(formatNumber(sumcash.toFixed(2)));
		$('#txtcredit').text(formatNumber(sumcredit.toFixed(2)));
		$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
		$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
		$('#txtallpayment').text(formatNumber(sumamount.toFixed(2)));
		$('#cashallpayment').val(sumamount.toFixed(2));
	}
	
	$('#bankpay').click(function(){
		var countrow 	= $('#countbank').val()||0;
		var sum 		= parseInt(countrow)+(1);
		$('#countbank').val(sum);
		$('#rowbank').append('<div class="col-md-12" id="bankrow'+sum+'">'
			+'<div class="col-md-1">'
				+' <label for="email" style="margin-top:8px;">โอนบัญชี </label>'
			+'</div>'
			+'<div class="col-md-2 ">'
				+'<select class="form-control" name="bank[]" id="bank'+sum+'">'
					+html
				+'</select>'
			+'</div>'
			+'<div class="col-md-2">'
				+'<input type="text" name="bankdate[]" id="bankdate'+sum+'" placeholder="วันที่" class="form-control" value="{{date("d/m/Y")}}" onkeydown="return false;" autocomplete="off">'
			+'</div>'
			+'<div class="col-md-2">'
				+'<input type="text" class="form-control" name="banktime[]" id="banktime'+sum+'" placeholder="เวลา">'
			+'</div>'
			+'<div class="col-md-2">'
				+'<input type="text"  class="form-control amountbank" name="amountbank[]" id="amountbank'+sum+'" value="" placeholder="จำนวนเงิน" onkeypress="return isNumberKey(event);">'
			+'</div>'
			+'<div class="col-md-1">'
				+'<label for="email" style="margin-top:8px;">บาท </label>'
			+'</div>'
			+'<div class="col-md-1">'
				+'<button type="button" class="btn btn-danger btn-icon" onclick="delbank('+sum+')"><i class="icon-minus-circle2"></i></button>'
			+'</div><br><br>'
		+'</div>');
		$("#bankdate"+sum).datepicker({ dateFormat: 'dd/mm/yy' });  
		$('.pickatime').pickatime();
		
		$('.amountbank').keyup(function(){
			$(this).val(function(index, value) {
				return value
				.replace(/(?!-)[^0-9.]/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			});
			
			var sumcash 	= 0;
			var sumcredit 	= 0;
			var sumbank 	= 0;
			var sumcash 	= 0;
			
			$('input[name="amountcash[]"]').each(function() {
				var cashvalue 		= $(this).val();
				var newcash 		= cashvalue.replace(/,/g,'')||0;
				sumcash				+= parseFloat(newcash);
			});
			
			$('input[name="amountcredit[]"]').each(function() {
				var creditvalue 	= $(this).val();
				var newcredit 		= creditvalue.replace(/,/g,'')||0;
				sumcredit			+= parseFloat(newcredit);
			});
			
			$('input[name="amountbank[]"]').each(function() {
				var bankvalue 		= $(this).val();
				var newbank 		= bankvalue.replace(/,/g,'')||0;
				sumbank				+= parseFloat(newbank);
			});
			
			var sumamount			= parseFloat(sumcash)+parseFloat(sumcredit)+parseFloat(sumbank);
			var sumtotalall			= $('#sumtotalall').val()||0;
			
			
			$('#txtcash').text(formatNumber(sumcash.toFixed(2)));
			$('#txtcredit').text(formatNumber(sumcredit.toFixed(2)));
			$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
			$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
			$('#txtallpayment').text(formatNumber(sumamount.toFixed(2)));
			$('#cashallpayment').val(sumamount.toFixed(2));
			
			//Check cash
			var totalpay = $('#cashallpayment').val()||0;
			var txttotal = $('#txttotal').text().replace(/,/g,'')||0;
			if(parseFloat(txttotal) < parseFloat(totalpay)){
				bootbox.alert("ไม่สามารถจ่ายชำระเกินจากราคาที่กำหนด...");
			}
		});
		
	});
	
	
	function delbank(id){
		$('#bankrow'+id).closest('div').remove();
		
		var sumcash 	= 0;
		var sumcredit 	= 0;
		var sumbank 	= 0;
		var sumcash 	= 0;
		
		$('input[name="amountcash[]"]').each(function() {
			var cashvalue 		= $(this).val();
			var newcash 		= cashvalue.replace(/,/g,'')||0;
			sumcash				+= parseFloat(newcash);
		});
		
		$('input[name="amountcredit[]"]').each(function() {
			var creditvalue 	= $(this).val();
			var newcredit 		= creditvalue.replace(/,/g,'')||0;
			sumcredit			+= parseFloat(newcredit);
		});
		
		$('input[name="amountbank[]"]').each(function() {
			var bankvalue 		= $(this).val();
			var newbank 		= bankvalue.replace(/,/g,'')||0;
			sumbank				+= parseFloat(newbank);
		});
		
		var sumamount			= parseFloat(sumcash)+parseFloat(sumcredit)+parseFloat(sumbank);
		var sumtotalall			= $('#sumtotalall').val()||0;
		
		$('#txtcash').text(formatNumber(sumcash.toFixed(2)));
		$('#txtcredit').text(formatNumber(sumcredit.toFixed(2)));
		$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
		$('#txtbank').text(formatNumber(sumbank.toFixed(2)));
		$('#txtallpayment').text(formatNumber(sumamount.toFixed(2)));
		$('#cashallpayment').val(sumamount.toFixed(2));
	}
	
	$('#save').click(function(){
		//Check cash
		var totalpay = $('#cashallpayment').val()||0;
		var txttotal = $('#txttotal').text().replace(/,/g,'')||0;
		if(parseFloat(txttotal) < parseFloat(totalpay)){
			bootbox.alert("ไม่สามารถจ่ายชำระเกินจากราคาที่กำหนด...");
		}else{
			$('#myForm').submit();
		}
		
	});
	
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	
	$('#addrsame').change(function(){
		if($(this).is(':checked')){
			var addr = $('#customeraddr').val();
			$('#customeraddrdoc').val(addr);
		}else{
			$('#customeraddrdoc').val('');
		}
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
	}
</script>
</html>
@stop