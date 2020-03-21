@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">สินค้า</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li><a href="{{url('product')}}">สินค้า</a></li>
				<li class="active">เพิ่มสินค้า</li>
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

				<form method="post" action="{{url('product_create')}}">
				{{ csrf_field() }}
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6 col-md-6 col-md-offset-3">
							<fieldset>
								<legend class="text-semibold">ข้อมูลสินค้า</legend>
								<div class="form-group">
									<label>รหัสสินค้า  :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="productcode" id="productcode" placeholder="รหัสสินค้า" required>
									</div>
								</div>
								<div class="form-group">
									<label>ชื่อสินค้า  :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="productname" id="productname" placeholder="ชื่อสินค้า" required>
									</div>
								</div>
								<div class="form-group">
									<label>หมวดหมู่สินค้า :</label>
									<select class="select" name="category" id="category" required style="width:250px;">
										<option value="">เลือก</option>
										@php
											if($category){
												foreach($category as $cate){
													@endphp
														<option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
													@php
												}
											}
										@endphp
									</select>
								</div>
								<div class="form-group">
									<label>หน่วยสินค้า  :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="productunit" id="productunit" placeholder="หน่วยสินค้า" required>
									</div>
								</div>
								<div class="form-group">
									<label>ราคาต้นทุน  :</label>
									<div class="input-control">
										<input type="text" class="form-control" name="productbuy" id="productbuy" placeholder="ราคาต้นทุน"  required>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<table class="table">
											<thead>
												<tr>
													<th>ราคา</th>
													<th>จำนวนกล่อง</th>
													<th>โปรโมชั่น</th>
													<th style="min-width:120px"></th>
												</tr>
											</thead>
											<tbody id="rowprice">
												<tr id="trrow1">
													<td><input type="type" class="form-control number" name="price[]" id="price1" onkeyup="pricekey(1);" style="width:150px;"></td>
													<td><input type="type" class="form-control number" name="priceqty[]" id="priceqty1" style="width:70px;"></td>
													<td><input type="type" class="form-control" name="promotion[]" id="promotion1" style="width:150px;"></td>
													<td><button type="button" class="btn btn-success btn-icon addrow"><i class="icon-plus-circle2"></i></button></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<input type="hidden" id="countrow" value="1">
								<br><br>
								<div class="text-right">
									<a href="{{url('product')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
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
	function pricekey(id){
		$('#price'+id).val(function(index, value) {
			return value
			.replace(/\D/g, "")
			.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		});
	}
	
	$('#productbuy').keyup(function(){
		$(this).val(function(index, value) {
			return value
			.replace(/\D/g, "")
			.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		});
	});
	
	$('.addrow').click(function(){
		var countrow 	= $('#countrow').val()||0;
		var sumrow		= parseInt(countrow) + (1);
		$('#countrow').val(sumrow);
		$('#rowprice').append('<tr id="trrow'+sumrow+'">'
			+'<td><input type="type" class="form-control number" name="price[]" id="price'+sumrow+'" onkeyup="pricekey('+sumrow+');" style="width:150px;" onkeypress="return isNumberKey(event);"></td>'
			+'<td><input type="type" class="form-control number" name="priceqty[]" id="priceqty'+sumrow+'" style="width:70px;" onkeypress="return isNumberKey(event);"></td>'
			+'<td><input type="type" class="form-control" name="promotion[]" id="promotion'+sumrow+'" style="width:150px;"></td>'
			+'<td><button type="button" class="btn btn-success btn-icon" onclick="addrow();"><i class="icon-plus-circle2"></i></button> <button type="button" class="btn btn-danger btn-icon minus" onclick="del('+sumrow+')"><i class="icon-minus-circle2"></i></button></td>'
		+'</tr>');
	});
	
	function addrow(){
		var countrow 	= $('#countrow').val()||0;
		var sumrow		= parseInt(countrow) + (1);
		$('#countrow').val(sumrow);
		$('#rowprice').append('<tr id="trrow'+sumrow+'">'
			+'<td><input type="type" class="form-control number" name="price[]" id="price'+sumrow+'" onkeyup="pricekey('+sumrow+');" style="width:150px;" onkeypress="return isNumberKey(event);"></td>'
			+'<td><input type="type" class="form-control number" name="priceqty[]" id="priceqty'+sumrow+'" style="width:70px;" onkeypress="return isNumberKey(event);"></td>'
			+'<td><input type="type" class="form-control" name="promotion[]" id="promotion'+sumrow+'" style="width:150px;"></td>'
			+'<td><button type="button" class="btn btn-success btn-icon" onclick="addrow();"><i class="icon-plus-circle2"></i></button> <button type="button" class="btn btn-danger btn-icon minus" onclick="del('+sumrow+')"><i class="icon-minus-circle2"></i></button></td>'
		+'</tr>');
	}
	
	function del(id){
		$('#trrow'+id).closest("tr").remove();
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