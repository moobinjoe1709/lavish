@extends('../template')

@section('content')
<!-- Main content -->
<style>
	.datepicker-dates{
		z-index: 2051 !important;
	}
</style>
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
				<li class="active">การขาย</li>
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
					<form id="multiprint" method="post" target="_blank" action="{{url('export_multiprint')}}">
					{{ csrf_field() }}
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">รายการ</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
						</div>
						
						<div class="panel-body">
							<div class="pull-left">
								<!--<button type="button" id="import" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal"><i class="icon-import"></i> นำเข้ามูลเข้า Kerry</button>
								<button type="button" id="import" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModalDHL"><i class="icon-import"></i> นำเข้ามูลเข้า DHL</button>-->
								<button type="button" id="export" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModalDHL"><i class="icon-import"></i> Excel DHL</button>
								
								<div id="printmultiple" style="display:none;">
									<br>
									<input type="hidden" name="status" id="status">
									<button type="button" id="mutiprintinv" class="btn btn-primary btn-lg"><i class="icon-printer2"></i> ปริ้นใบกำกับ</button> <button type="button" id="mutiprintcover" class="btn btn-primary btn-lg"><i class="icon-printer2"></i> ปริ้นใบปะหน้า</button> 
								</div>
							</div>
							
							<div class="pull-right">
								<a href="{{url('export/create')}}"><button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
							</div>
						</div> 
							
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table" id="datatables">
									<thead>
										<tr>
											<th class="text-center">เลือก</th>
											<th class="text-center">เลขที่อินวอยซ์</th>
											<th class="text-center">เลขที่ออเดอร์</th>
											<th class="text-center">วันที่</th>
											<th class="text-center">ลูกค้า</th>
											<th class="text-center">สถานะ</th>
											<th class="text-center">มูลค่า</th>
											<th class="text-center">หมายเหตุ</th>
											<th class="text-center">#</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					</form>
			</div>
		</div> 
		
		<form method="post" action="{{url('kerry_create')}}" enctype="multipart/form-data">
		{{ csrf_field() }}
			<!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">นำเข้ามูลเข้า Kerry</h4>
				  </div>
				  <div class="modal-body">
					<div class="form-group">
						<label>ไฟล์ :</label>
						<div class="input-control">
							<input type="file" class="file-input" name="uploadfile" required>
						</div>
					</div>
				  </div>
				  <div class="modal-footer">
					<div class="pull-left"><a href="{{url('master_platform/kerry')}}" target="_blank"><i class="icon-file-excel"></i>  Master Platform</a></div> 
					
					<button type="submit" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button>
				  </div>
				</div>

			  </div>
			</div>
		</form>
		
		
			<!-- Modal -->
			<div id="myModalDHL" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="false">
			  <div class="modal-dialog">
				<form method="post" action="{{url('dhl_create')}}">
				{{ csrf_field() }}
				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">นำเข้ามูลเข้า DHL</h4>
				  </div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-4">
								<label>ตั้งแต่วันที่ :</label>
								<div class="input-group" id="ButtonCreationDemoButton">
									<span class="input-group-btn">
										<button type="button" class="btn btn-default btn-icon"><i class="icon-calendar3"></i></button>
									</span>
									<input type="text" class="form-control datepicker-dates" name="datestart" id="datestart" onkeydown="return false;" placeholder="ตั้งแต่วันที่" autocomplete="off">
								</div>
							</div>
							<div class="col-md-4">
								<label>ถึงวันที่ :</label>
								<div class="input-group" id="ButtonCreationDemoButton1">
									<span class="input-group-btn">
										<button type="button" class="btn btn-default btn-icon"><i class="icon-calendar3"></i></button>
									</span>
									<input type="text" class="form-control datepicker-dates" name="dateend" id="dateend" onkeydown="return false;" placeholder="ถึงวันที่" autocomplete="off">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<!--<div class="pull-left"><a href="{{url('master_platform/dhl')}}" target="_blank"><i class="icon-file-excel"></i>  Master Platform</a></div>--> 

						<button type="submit" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button>
					</div>
				</div>
				</form>
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

<script>
	$(document).ready(function(){
		var oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('exportdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'export_id', name: 'export_id' },
				{ 'className': "text-center", data: 'export_order', name: 'export_order' },
				{ 'className': "text-center", data: 'export_inv', name: 'export_inv' },
				{ 'className': "text-center", data: 'export_date', name: 'export_date' },
				{ 'className': "text-left", data: 'export_customername', name: 'export_customername' },
				{ 'className': "text-left", data: 'export_status', name: 'export_status' },
				{ 'className': "text-right", data: 'export_totalpayment', name: 'export_totalpayment' },
				{ 'className': "text-left", data: 'export_comment', name: 'export_comment' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
			],
			order: [[0, 'desc']],
		
			rowCallback: function(row,data,index ){
				if(data['export_delstatus'] == 0){
					var urld = 'https://th.kerryexpress.com/th/track/?track='+data.export_inv;
				}else{
					//var urld = 'https://www.logistics.dhl/th-th/home/tracking.html?tracking-id=THCSX';
					var urld = 'https://ecommerceportal.dhl.com/track/'+data.export_inv;
					var urld = 'https://www.logistics.dhl/th-th/home/tracking.html?tracking-id='+data.export_inv;
				}
				
				var print 		= '';
				var tracking 	= '';
				var approve 	= '';
				var cover 		= '';
				var btnadmin 	= '';
				var status 		= '<span class="label bg-danger">ค้างชำระ</span>';
				
				if(data['export_status_print'] == 1){
					print = '<span class="label bg-success">ปริ้น</span>';
				}
				
				if(data['export_status'] == 1){
					approve		= '<i class="icon-file-check" onclick="approve('+data['export_id']+')"></i>';
					status 		= '<span class="label bg-success">จ่ายแล้ว</span>';
				}else if(data['export_status'] == 2){
					cover		= '<a href="cover/'+data['export_id']+'" target="_blank"><i class="icon-price-tags2 position-left text-success" data-popup="tooltip" title="ใบปะหน้า"></i></a>';
					status 		= '<span class="label bg-success">ส่งสินค้าแล้ว</span>';
					tracking 	= '<a href="'+urld+'" target="_blank"><i class="icon-truck position-left text-success" data-popup="tooltip" title="Tracking"></i></a>';
				}else if(data['export_status'] == 3){
					cover		= '<a href="cover/'+data['export_id']+'" target="_blank"><i class="icon-price-tags2 position-left text-success" data-popup="tooltip" title="ใบปะหน้า"></i></a>';
					status 		= '<span class="label bg-success">ส่งสินค้าแล้ว</span>';
					tracking 	= '<a href="'+urld+'" target="_blank"><i class="icon-truck position-left text-success" data-popup="tooltip" title="Tracking"></i></a>';
				}else if(data['export_status'] == 4){
					status 		= '<span class="label bg-success">เก็บเงินปลายทาง</span>';
					tracking 	= '<a href="'+urld+'" target="_blank"><i class="icon-truck position-left text-success" data-popup="tooltip" title="Tracking"></i></a>';
				}
				
				if({{Auth::user()->status}} == 1){
					btnadmin = '<i class="icon-pencil7 position-left text-success" data-popup="tooltip" title="แก้ไข"></i></a>  <i class="icon-trash text-danger" onclick="del('+data['export_id']+');" data-popup="tooltip" title="ลบรายการ"></i>';
				}
				$('td:eq(0)', row).html('<input type="checkbox" class="styled" id="idrow" onclick="checkedid('+data['export_id']+')" name="idrow[]" value="'+data['export_id']+'">');
				$('td:eq(5)', row).html(status+' '+print);  
				$('td:eq(8)', row).html( tracking+'  '+approve+'  '+cover+'  <a href="invoice/'+data['export_id']+'" target="_blank"><i class="icon-stack4 position-left text-success" data-popup="tooltip" title="ใบกำกับภาษี"></i></a> <a href="export/update/'+data['export_id']+'"> '+btnadmin );
				
			},fnDrawCallback:function (oSettings) {
				$(".styled").uniform({ radioClass: 'choice' });
			},columnDefs: [
				{ "width": "20%", "targets": 8 },
			  ]
		});
		
		/* oTable.on( 'order.dt search.dt', function(){
			oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw(); */
	});
	
	function checkedid(id){ 
		var num = 0;
		$('input[type=checkbox]:checked').each(function(){
			console.log(num);
			num++;
		});
		if(num != 0){
			$('#printmultiple').show();
		}else{
			$('#printmultiple').hide();
		}
	}
	
	$('#mutiprintinv').click(function(){
		$('#status').val(1);
		$('#multiprint').submit();
	});
	
	$('#mutiprintcover').click(function(){
		$('#status').val(2);
		$('#multiprint').submit();
	});
		
	function approve(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการเปลี่ยนสถานะรายการนี้เป็นกำลังส่งสินค้า หรือไม่?",
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
					window.location.href="export/approve/"+id+"";
				}
			}
		});
	}
	
	function del(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการลบรายการนี้ หรือไม่?",
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
					window.location.href="export/delete/"+id+"";
				}
			}
		});
	}
</script>
</body>
</html>
@stop