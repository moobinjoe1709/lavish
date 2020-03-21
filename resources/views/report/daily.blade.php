@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">รายงานรายวัน</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li class="active">รายงานรายวัน</li>
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
										<legend class="text-semibold"><i class="icon-stack2"></i> รายงานรายวัน</legend>
										<form id="myForm" method="post" action="{{url('dailypdf')}}" target="_blank">
										{{ csrf_field() }}
										<div class="row">
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
											<th class="text-center" width="10%">ลำดับ</th>
											<th class="text-center">เลขที่ออเดอร์</th>
											<th class="text-center">เลขที่บิล</th>
											<th class="text-center">วันที่</th>
											<th class="text-center" width="20%">ลูกค้า</th>
											<th class="text-center" width="20%">เลขที่ผู้เสียภาษี</th>
											<th class="text-center" width="20%">รายการ</th>
											<th class="text-center">ราคา</th>
											<th class="text-center">จำนวน</th>
											<th class="text-center" width="10%">ยอดขาย</th>
										</tr>
									</thead>
									<tbody id="rowdata"></tbody>
									<tfoot id="rowfoot"></tfoot>
								</table>
								<br>
								<div class="pull-right">
									<table>
										<tr>
											<td align="left" width="150px"><span>ยอดชำระเงินสด </span></td>
											<td align="right"><span id="cashtxt"></span></td>
										</tr>
										<tr>
											<td align="left"><span>ยอดชำระบัตรเครดิต </span></td>
											<td align="right"><span id="credittxt"></span></td>
										</tr>
										<tr>
											<td align="left"><span>ยอดชำระผ่านบัญชี </span></td>
											<td align="right"><span id="banktxt"></span></td>
										</tr>
										<tr>
											<td align="left"><span>ยอดรวมทั้งสิ้น</span></td>
											<td align="right"><span id="totalalltxt"></span></td>
										</tr>
									</table>
								</div>
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
	$('#searchdata').click(function(){
		$.ajax({
		'type': 'post',
		'url': "{{url('reportdatadaily')}}",
		'dataType': 'json',
		'data': {
			'start': $('#ButtonCreationDemoInput').val(),
			'end': $('#ButtonCreationDemoInput1').val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data){
				var text 	= '';
				var num 	= 1;
				$('#firstauto').closest( 'tr').remove();
				$('.rowbody').closest( 'tr').remove();
				$('.rowfoot').closest( 'tr').remove();
				$.each(data.results,function(key,item){
					var countrow = data.results[key].length;
					text += '<tr class="rowbody">'
						+'<td align="center">'+num+'</td>'
						+'<td align="left">'+data.results[key][0]['inv']+'</td>'
						+'<td align="left">'+data.results[key][0]['bill']+'</td>'
						+'<td align="center">'+data.results[key][0]['date']+'</td>'
						+'<td align="left">'+data.results[key][0]['customername']+'</td>'
						+'<td align="left">'+data.results[key][0]['customertax']+'</td>'
						+'<td align="left">'+data.results[key][0]['product']+'</td>'
						+'<td align="right">'+data.results[key][0]['price']+'</td>'
						+'<td align="center">'+data.results[key][0]['qty']+'</td>'
						+'<td align="right">'+data.results[key][0]['total']+'</td>'
					+'</tr>';
					if(countrow > 1){
						for(var i=1;i<countrow;i++){
							num++;
							text += '<tr class="rowbody">'
								+'<td align="center">'+num+'</td>'
								+'<td align="left"></td>'
								+'<td align="left"></td>'
								+'<td align="left"></td>'
								+'<td align="left"></td>'
								+'<td align="center"></td>'
								+'<td align="left">'+data.results[key][i]['product']+'</td>'
								+'<td align="right">'+data.results[key][i]['price']+'</td>'
								+'<td align="center">'+data.results[key][i]['qty']+'</td>'
								+'<td align="right">'+data.results[key][i]['total']+'</td>'
							+'</tr>';
						}
					}
					if(data.results[key][0]['discountsum'] != 0){
						text += '<tr class="rowbody">'
							+'<td align="right" colspan="9">ส่วนลด</td>'
							+'<td align="right"><span style="color:green">+'+data.results[key][0]['discountsum']+'</span></td>'
						+'</tr>';
					}
					if(data.results[key][0]['vatsum'] != 0){
						text += '<tr class="rowbody">'
							+'<td align="right" colspan="9">ภาษีมูลค่าเพิ่ม</td>'
							+'<td align="right"><span style="color:green">+'+data.results[key][0]['vatsum']+'</span></td>'
						+'</tr>';
					}
					text += '<tr class="rowbody">'
						+'<td align="right" colspan="9">รวม</td>'
						+'<td align="right"><span style="color:blue">'+data.results[key][0]['totalpay']+'</span></td>'
					+'</tr>';
					num++;
				});
				
				$('#cashtxt').text(data.total[0]['totalscash']);
				$('#credittxt').text(data.total[0]['totalscredit']);
				$('#banktxt').text(data.total[0]['totalsbank']);
				$('#totalalltxt').text(data.total[0]['totalall']);
				$('#rowdata').append(text);
				$('#rowfoot').append('<tr class="rowfoot"><td colspan="9" align="center">รวม</td><td align="right">'+data.total[0]['totals']+'</td></tr>');
				
			}
		});
	});
	
	$('#excel').click(function(){
		var starts 	= $('#ButtonCreationDemoInput').val();
		var ends 	= $('#ButtonCreationDemoInput1').val();
		window.open('{{url("dailyexcel")}}/'+starts+'/'+ends);
	});
</script>
</html>
@stop