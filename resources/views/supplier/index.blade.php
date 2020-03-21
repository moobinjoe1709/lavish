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
				<li class="active">ซัพพลายเออร์</li>
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
							<div class="pull-right">
								<a href="{{url('supplier/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
							</div>
						</div>
							
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table" id="datatables">
									<thead>
										<tr>
											<th class="text-center">ลำดับที่</th>
											<th class="text-center">เลขประจำตัวผู้เสียภาษีอากร</th>
											<th class="text-center">ซัพพลายเออร์</th>
											<th class="text-center">รายละเอียด</th>
											<th class="text-center">อีเมล</th>
											<th class="text-center">เบอร์ติดต่อ</th>
											<th class="text-center">#</th>
										</tr>
									</thead>
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
		
		<div class="modal inmodal" id="history" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog" style="width:70%">
				<div class="modal-content animated fadeIn">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title text-center">ประวัติการซื้อขาย</h4>
					</div>
					<div class="modal-body">
						<div class="tabs-container">
							<ul class="nav nav-tabs" role="tablist">
								<li><a class="nav-link active" data-toggle="tab" href="#tab-1"> การขายสินค้า</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" id="tab-1" class="tab-pane active">
									<div class="panel-body table-responsive">
									   <table class="table" id="saledata">
											<thead>
												<tr>
													<th class="text-center" width="10%">ลำดับ</th>
													<th class="text-center" width="10%">วันที่</th>
													<th class="text-center" width="20%">เลขที่</th>
													<th class="text-center" width="15%">รายการ</th>
													<th class="text-center" width="15%">จำนวน</th>
													<th class="text-center" width="15%">ราคาขาย</th>
													<th class="text-center" width="15%">รวม</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer" style="margin-top:3%">
						<button type="button" class="btn btn-white" data-dismiss="modal" >ปิด</button>
					</div>
				</div>
			</div>
		</div>
		
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
				url : "{{url('supplierdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'customer_id', name: 'customer_id' },
				{ data: 'customer_vat', name: 'customer_vat' },
				{ data: 'customer_name', name: 'customer_name' },
				{ data: 'customer_detail', name: 'customer_detail' },
				{ 'className': "text-center", data: 'customer_email', name: 'customer_email' },
				{ 'className': "text-center", data: 'customer_tel', name: 'customer_tel' },
				{ 'className': "text-center", data: 'customer_tel', name: 'customer_tel' },
			],
			order: [[0, 'desc']],
			rowCallback: function(row,data,index ){
				$('td:eq(6)', row).html( '<a href="javascript:;" onclick="showhistory('+data['customer_id']+')" title="รายการขาย"><i class="icon-history text-danger"></i></a> <a href="supplier/update/'+data['customer_id']+'"><i class="icon-pencil7 text-warning"  data-popup="tooltip" title="Update"></i></a> <i class="icon-trash text-danger" onclick="del('+data['customer_id']+');" data-popup="tooltip" title="Delete"></i>' );
			}
		});
		
		oTable.on( 'order.dt search.dt', function(){
			oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();
	});
	
	function showhistory(id){
		var tablesale = $('#saledata').DataTable();
		tablesale.destroy();
		var oTablesale = $('#saledata').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('customersaledata')}}",
				type: "POST",
				data : { 
					'id' : id,
					'_token': "{{ csrf_token() }}"
				}
			},
			columns: [
				{ 'className': "text-center", data: 'order_id', name: 'order_id' },
				{ data: 'export_date', name: 'export_date' },
				{ data: 'export_inv', name: 'export_inv' },
				{ data: 'product_name', name: 'product_name' },
				{ 'className': "text-center", data: 'order_qty', name: 'order_qty' },
				{ 'className': "text-right", data: 'order_price', name: 'order_price' },
				{ 'className': "text-right", data: 'order_total', name: 'order_total' },
			],
			order: [[0, 'desc']],
		});
		
		oTablesale.on( 'order.dt search.dt', function(){
			oTablesale.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();
        $('#history').modal('show');
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
					window.location.href="supplier/delete/"+id+"";
				}
			}
		});
	}
</script>
</body>
</html>
@stop