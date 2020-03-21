@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">ลูกค้า</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li class="active">ลูกค้า</li>
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
							<div class="pull-left">
								<a href="{{url('/exportdatacus')}}"<button type="button" class="btn btn-success btn-lg"><i class="fa fa-file-text" aria-hidden="true"></i> Export</button></a>
								<a href="{{url('customer/numberphone')}}"><button type="button" class="btn btn-success btn-lg"><i class="icon-phone2"></i> เบอร์โทรลูกค้า</button></a>
							</div>
							<div class="pull-right">
								<a href="{{url('customer/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
							</div>
						</div>
							
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table" id="datatables">
									<thead>
										<tr>
											<th class="text-center" width="10%">ลำดับที่</th>
											<th class="text-center" width="10%">รูปโปรไฟล์</th>
											<th class="text-center" width="10%">รหัสลูกค้า</th>
											<th class="text-center" width="20%">ชื่อลูกค้า</th>
											<th class="text-center" width="20%">รายละเอียด</th>
											<th class="text-center" width="15%">เบอร์ติดต่อ</th>
											<th class="text-center" width="15%">กล่อง</th>
											<th class="text-center" width="10%">#</th>
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
								<li><a class="nav-link active" data-toggle="tab" href="#tab-2"> คืนสินค้า</a></li>
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
								
								<div role="tabpanel" id="tab-2" class="tab-pane">
									<div class="panel-body table-responsive">
									   <table class="table" id="returndata">
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
			lengthChange: true,
			ajax:{  
				url : "{{url('customerdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'customer_id', name: 'customer_id' },
				{ 'className': "text-center", data: 'customer_img', name: 'customer_img' },
				{ data: 'customer_code', name: 'customer_code' },
				{ data: 'customer_name', name: 'customer_name' },
				{ data: 'customer_detail', name: 'customer_detail' },
				{ 'className': "text-center", data: 'customer_tel', name: 'customer_tel' },
				{ 'className': "text-center", data: 'customer_point', name: 'customer_point' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
			],
			order: [[0, 'desc']],
			rowCallback: function(row,data,index ){
				var img = '';
				if(data['customer_img'] != ''){
					img = '<img src="{{asset("assets/images/customer")}}/'+data['customer_img']+'" class="img-responsive img-thumbnail" width="100px">';
				}else{
					
				}
				
				$('td:eq(1)', row).html(img);
				$('td:eq(7)', row).html( '<a href="javascript:;" onclick="showhistory('+data['customer_id']+')" title="รายการขาย"><i class="icon-history text-danger"></i></a> <a href="customer/update/'+data['customer_id']+'"><i class="icon-pencil7 text-warning"  data-popup="tooltip" title="Update"></i></a> <i class="icon-trash text-danger" onclick="del('+data['customer_id']+');" data-popup="tooltip" title="Delete"></i>' );
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
				{ 'className': "text-center", data: 'DT_Row_Index', name: 'order_id' },
				{ data: 'export_date', name: 'export_date' },
				{ data: 'export_inv', name: 'export_inv' },
				{ data: 'product_name', name: 'product_name' },
				{ 'className': "text-center", data: 'TOTALQTY', name: 'TOTALQTY' },
				{ 'className': "text-right", data: 'order_price', name: 'order_price' },
				{ 'className': "text-right", data: 'TOTAL', name: 'TOTAL' },
			],
			order: [[0, 'desc']],
		});
		
		var returndata = $('#returndata').DataTable();
		returndata.destroy();
		var oTablereturn = $('#returndata').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('customerreturndata')}}",
				type: "POST",
				data : { 
					'id' : id,
					'_token': "{{ csrf_token() }}"
				}
			},
			columns: [
				{ 'className': "text-center", data: 'DT_Row_Index', name: 'order_id' },
				{ data: 'export_date', name: 'export_date' },
				{ data: 'export_inv', name: 'export_inv' },
				{ data: 'product_name', name: 'product_name' },
				{ 'className': "text-center", data: 'TOTALQTY', name: 'TOTALQTY' },
				{ 'className': "text-right", data: 'order_price', name: 'order_price' },
				{ 'className': "text-right", data: 'TOTAL', name: 'TOTAL' },
			],
			order: [[0, 'desc']],
		});
		
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
					window.location.href="customer/delete/"+id+"";
				}
			}
		});
	}
</script>
</body>
</html>
@stop