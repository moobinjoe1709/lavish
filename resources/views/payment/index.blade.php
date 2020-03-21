@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">การเงิน</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li class="active">การเงิน</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		<!-- Vertical form options -->
		<div class="row">
			<div class="col-md-6">
				
				<!-- Double border styling -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">การเงินและบัญชี</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
						</div>
						
						<div class="panel-body">
							<div class="pull-right">
								<button type="button" id="import" class="btn btn-success btn-lg"><i class="icon-import"></i> นำเข้ามูลเข้า</button>
							</div>
						</div>
							
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table" id="trandata">
									<thead>
										<tr>
											<th class="text-center">วันที่</th>
											<th class="text-center">เลขอ้างอิง</th>
											<th class="text-center">ประเภทการชำระ</th>
											<th class="text-center">สถานะ</th>
											<th class="text-center">ยอดชำระ</th>
											<th class="text-center">#</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
			</div>
			
			<div class="col-md-6">
				
				<!-- Double border styling -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">รายการขาย</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
						</div>
						
						<div class="panel-body">
							<div class="pull-right">
								<br><br>
							</div>
						</div>
							
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table" id="exportdata">
									<thead>
										<tr>
											<th class="text-center">ลำดับ</th>
											<th class="text-center">วันที่</th>
											<th class="text-center">เลขที่ออเดอร์</th>
											<th class="text-center">ลูกค้า</th>
											<th class="text-center">ยอดชำระ</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
			</div>
		</div>
		
		<form method="post" action="{{url('transection_create')}}" enctype="multipart/form-data">
		{{ csrf_field() }}
			<!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">นำเข้ามูลเข้า</h4>
				  </div>
				  <div class="modal-body">
					<div class="form-group">
						<label>ประเภทการชำระ :</label>
						<div class="input-control">
							<select class="form-control" name="typetransec">
								<option value="1">โอนผ่านบัญชี</option>
								<option value="2">ชำระด้วยบัตรเครดิต</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label>ไฟล์ :</label>
						<div class="input-control">
							<input type="file" class="file-input" name="uploadfile" required>
						</div>
					</div>
				  </div>
				  <div class="modal-footer">
					<div class="pull-left"><a href="{{url('master_platform/payment')}}" target="_blank"><i class="icon-file-excel"></i>  Master Platform Statement</a>  <a href="{{url('master_platform/credit')}}" target="_blank"><i class="icon-file-excel"></i>  Master Platform Credit</a></div> 
					
					<button type="submit" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button>
				  </div>
				</div>

			  </div>
			</div>
		</form>
		
		
		<!-- Modal -->
		<div id="mytransec" class="modal fade" role="dialog">
		  <div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Transection</h4>
			  </div>
			  <div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" id="export_id">
						<table class="table" id="mytransecdata">
							<thead>
								<tr>
									<th class="text-center">วันที่</th>
									<th class="text-center">เลขอ้างอิง</th>
									<th class="text-center">ประเภทการชำระ</th>
									<th class="text-center">สถานะ</th>
									<th class="text-center">ยอดชำระ</th>
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

<script>
	$('#import').click(function(){
		$('#myModal').modal('show');
	});
	$(document).ready(function(){
		var oTabletran = $('#trandata').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				'type' : 'post',
				'url' : "{{url('trandatatables')}}",
				'data': {
					'_token': "{{ csrf_token() }}"
				},
			},
			columns: [
				{ 'className': "text-center", data: 'tran_date', name: 'tran_date' },
				{ 'className': "text-center", data: 'tran_ordernumber', name: 'tran_ordernumber' },
				{ 'className': "text-left", data: 'tran_type', name: 'tran_type' },
				{ 'className': "text-left", data: 'tran_statuscredit', name: 'tran_statuscredit' },
				{ 'className': "text-right", data: 'tran_amount', name: 'tran_amount' },
			],
			order: [[0, 'desc']],
			rowCallback: function(row,data,index ){
				if(data['tran_status'] == 1){
					$('td:eq(3)', row).html('-');
					$('td:eq(1)', row).html('-');
				}
				
				if(data['tran_status'] == 0){
					$('td:eq(0)', row).addClass('bg-success');
					$('td:eq(1)', row).addClass('bg-success');
					$('td:eq(2)', row).addClass('bg-success');
					$('td:eq(3)', row).addClass('bg-success');
					$('td:eq(4)', row).addClass('bg-success');
				}
			}
		});
		
		var oTabletrandata = $('#mytransecdata').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				'type' : 'post',
				'url' : "{{url('trandataquery')}}",
				'data': {
					'_token': "{{ csrf_token() }}"
				},
			},
			columns: [
				{ 'className': "text-center", data: 'tran_date', name: 'tran_date' },
				{ 'className': "text-center", data: 'tran_ordernumber', name: 'tran_ordernumber' },
				{ 'className': "text-left", data: 'tran_type', name: 'tran_type' },
				{ 'className': "text-left", data: 'tran_statuscredit', name: 'tran_statuscredit' },
				{ 'className': "text-right", data: 'tran_amount', name: 'tran_amount' },
				{ 'className': "text-right", data: 'updated_at', name: 'updated_at' },
			],
			order: [[0, 'desc']],
			rowCallback: function(row,data,index ){
				if(data['tran_status'] == 1){
					$('td:eq(3)', row).html('-');
					$('td:eq(1)', row).html('-');
				}
				
				$('td:eq(5)', row).html('<i class="icon-stack4 position-left text-success" onclick="connectpayment('+data['tran_id']+')" data-popup="tooltip" title="เลือก Payment"></i>');
			}
		});
		
			
		var oTableexp = $('#exportdata').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				'type' : 'post',
				'url' : "{{url('exportdatatables')}}",
				'data': {
					'_token': "{{ csrf_token() }}"
				},
			},
			columns: [
				{ 'className': "text-center", data: 'export_id', name: 'export_id' },
				{ 'className': "text-center", data: 'export_date', name: 'export_date' },
				{ 'className': "text-center", data: 'export_inv', name: 'export_inv' },
				{ 'className': "text-left", data: 'export_customername', name: 'export_customername' },
				{ 'className': "text-right", data: 'export_totalpayment', name: 'export_totalpayment' },
			],
			order: [[0, 'desc']],
			rowCallback: function(row,data,index ){
				if(data['export_status'] == 1 || data['export_status'] == 2 || data['export_status'] == 3){
					$('td:eq(0)', row).addClass('bg-success');
					$('td:eq(1)', row).addClass('bg-success');
					$('td:eq(2)', row).addClass('bg-success');
					$('td:eq(3)', row).addClass('bg-success');
					$('td:eq(4)', row).addClass('bg-success');
				}else{
					$('td:eq(0)', row).addClass('controlid');
					$('td:eq(1)', row).addClass('controlid');
					$('td:eq(2)', row).addClass('controlid');
					$('td:eq(3)', row).addClass('controlid');
					$('td:eq(4)', row).addClass('controlid');
				}
			}
		});
		
		oTableexp.on( 'order.dt search.dt', function(){
			oTableexp.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();
		
		$('#exportdata tbody').on('click', 'td.controlid',function(){
			var tr 	= $(this).closest('tr');
			var row = oTableexp.row(tr);
			format(row.data());
		});
		
		function format(d){
			$('#export_id').val(d.export_id);
			$('#mytransec').modal('show');
		}
	}); 
	
	function connectpayment(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการเปลี่ยนสถานะรายการนี้เป็นชำระสินค้าเรียบร้อย หรือไม่?",
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
					$.ajax({
					'type': 'post',
					'url': "{{url('connectpayment')}}",
					'dataType': 'json',
					'data': {
						'paymentid': id,
						'exportid': $('#export_id').val(),
						'_token': "{{ csrf_token() }}"
					},
						'success': function (data){
							location.reload();
						}
					});
				}
			}
		});
	}

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