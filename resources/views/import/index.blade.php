@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">สต๊อกเข้า</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li class="active">สต๊อกเข้า</li>
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
								<a href="{{url('import/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
							</div>
						</div>
							
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table" id="datatables">
									<thead>
										<tr>
											<th class="text-center">#</th>
											<th class="text-center">เลขที่ออเดอร์</th>
											<th class="text-center">เลขที่อ้างอิงเอกสาร</th>
											<th class="text-center">วันที่</th>
											<th class="text-center">ซัพพลายเออร์</th>
											<th class="text-center">ผู้ทำรายการ</th>
											<th class="text-center">#</th>
										</tr>
									</thead>
									<tbody></tbody>
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

<script>
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	
	$(document).ready(function(){
		var oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('importdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'import_id', name: 'import.import_id' },
				{ 'className': "text-center", data: 'import_inv', name: 'import.import_inv' },
				{ 'className': "text-center", data: 'import_ref', name: 'import.import_ref' },
				{ 'className': "text-center", data: 'import_date', name: 'import.import_date' },
				{ 'className': "text-left", data: 'import_suppliername', name: 'import.import_suppliername' },
				{ 'className': "text-left", data: 'name', name: 'users.name' },
				{ 'className': "text-center", data: 'updated_at', name: 'import.updated_at' },
			],
			order: [[0, 'asc']],
			pageLength: 100,
			rowCallback: function(row,data,index ){
				$('td:eq(6)', row).html( '<a href="import/update/'+data['import_id']+'"><i class="icon-pencil7 text-warning" data-popup="tooltip" title="Update"></i></a> <i class="icon-trash text-danger" onclick="del('+data['import_id']+');" data-popup="tooltip" title="Delete"></i>' );
			}
		});
		
		oTable.on( 'order.dt search.dt', function(){
			oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();
	});

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
					window.location.href="delimp/"+id+"";
				}
			}
		});
	}
</script>
</body>
</html>
@stop