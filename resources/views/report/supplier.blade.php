@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">รายงานซัพพลายเออร์</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li class="active">รายงานซัพพลายเออร์</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		<!-- Vertical form options -->
		<div class="row">
			<div class="col-md-12">
				
				<!-- Double border styling -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title"></h5>
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
									<fieldset>
										<legend class="text-semibold"><i class="icon-stack2"></i> รายงานซัพพลายเออร์</legend>
										<form id="myForm" method="post" action="{{url('supplierpdf')}}" target="_blank">
										{{ csrf_field() }}
										<div class="row">
											<div class="col-md-2">
												<label>ซัพพลายเออร์ :</label>
												<select class="form-control" name="customer" id="customer">
													<option value="all">ทั้งหมด</option>
													@php
														if($customer){
															foreach($customer as $rs){
																@endphp
																<option value="{{$rs->customer_id}}">{{$rs->customer_name}}</option>
																@php
															}
														}
													@endphp
												</select>
											</div>
											<div class="col-md-2">
												<label>ตั้งแต่วันที่ :</label>
												<div class="input-group" id="ButtonCreationDemoButton">
													<span class="input-group-btn">
														<button type="button" class="btn btn-default btn-icon"><i class="icon-calendar3"></i></button>
													</span>
													<input type="text" class="form-control" name="datestart" id="ButtonCreationDemoInput" placeholder="ตั้งแต่วันที่" autocomplete="off" value="{{date('Y-m-d 00:00:00')}}">
												</div>
											</div>
											<div class="col-md-2">
												<label>ถึงวันที่ :</label>
												<div class="input-group" id="ButtonCreationDemoButton1">
													<span class="input-group-btn">
														<button type="button" class="btn btn-default btn-icon"><i class="icon-calendar3"></i></button>
													</span>
													<input type="text" class="form-control" name="dateend" id="ButtonCreationDemoInput1" placeholder="ถึงวันที่" autocomplete="off" value="{{date('Y-m-d 00:00:00')}}">
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label>&nbsp;</label><br>
													<button type="button" id="searchdata" class="btn btn-success"><i class="icon-folder-search position-left"></i>  ค้นหา</button>
												</div>
											</div>
											
											<div class="col-md-2 pull-right">
												<div class="form-group">
													<label>&nbsp;</label><br>
													<button type="submit" id="printer" class="btn btn-primary btn-lg"><i class="icon-printer2"></i> พิมพ์</button>
													<button type="button" id="excel" class="btn btn-primary btn-lg"><i class="icon-file-excel"></i> Excel</button>
												</div>
											</div>
										</div>
										</form>
										
									</fieldset>
								</div>
							</div>
								
							<div class="table-responsive">
								<table id="myTable" class="table table-bordered">
									<thead>
										<tr>
											<th class="text-center">ลำดับ</th>
											<th class="text-center">เลขที่ออเดอร์</th>
											<th class="text-center">วันที่</th>
											<th class="text-center">รหัสสินค้า</th>
											<th class="text-center">สินค้า</th>
											<th class="text-center">จำนวน</th>
											<th class="text-center">ยอดขาย</th>
										</tr>
									</thead>
									<tbody id="rowdata"></tbody>
									<tfoot id="rowfoot"></tfoot>
								</table>
							</div>
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
</body>
<script>
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	
	$('#searchdata').click(function(){
		$.ajax({
		'type': 'post',
		'url': "{{url('reportdatasupplier')}}",
		'dataType': 'json',
		'data': {
			'start': $('#ButtonCreationDemoInput').val(),
			'end': $('#ButtonCreationDemoInput1').val(),
			'customer': $('#customer').val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data){
				var text 	= '';
				var num 	= 1;
				var total 	= 0;
				$('.rowbody').closest( 'tr').remove();
				$('.rowfoot').closest( 'tr').remove();
				$.each(data,function(key,item){
					total += item.order_total;
					text += '<tr class="rowbody">'
						+'<td align="center">'+num+'</td>'
						+'<td align="left">'+item.export_inv+'</td>'
						+'<td align="center">'+item.export_date+'</td>'
						+'<td align="center">'+item.product_code+'</td>'
						+'<td align="left">'+item.product_name+'</td>'
						+'<td align="center">'+formatNumber(item.order_qty)+'</td>'
						+'<td align="right">'+formatNumber(item.order_total.toFixed(2))+'</td>'
					+'</tr>';
					num++;
				});
				
				$('#rowdata').append(text);
				$('#rowfoot').append('<tr class="rowfoot"><td colspan="6" align="center">รวม</td><td align="right">'+formatNumber(total.toFixed(2))+'</td></tr>');
				
			}
		});
	});
	
	$('#excel').click(function(){
		var starts 	= $('#ButtonCreationDemoInput').val();
		var ends 	= $('#ButtonCreationDemoInput1').val();
		var customer = $('#customer').val();
		window.open('{{url("supplierexcel")}}/'+starts+'/'+ends+'/'+customer);
	});
</script>
</html>
@stop