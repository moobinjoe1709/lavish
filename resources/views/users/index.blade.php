@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">ผู้ใช้งาน</span></h4>
			</div>
		</div>
		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li class="active">ผู้ใช้งาน</li>
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
								<a href="{{url('/exportdata')}}"<button type="button" class="btn btn-success btn-lg"><i class="fa fa-file-text" aria-hidden="true"></i> Export</button></a>
							</div>
							<div class="pull-right">
								<a href="{{url('users/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
							</div>
						</div>
							
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table" id="datatables">
									<thead>
										<tr>
											<th class="text-center" width="10%">ลำดับที่</th>
											<th class="text-center" width="20%">ชื่อ</th>
											<th class="text-center" width="15%">เบอร์ติดต่อ</th>
											<th class="text-center" width="15%">อีเมล</th>
											<th class="text-center" width="15%">สถานะ</th>
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
				url : "{{url('usersdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'id', name: 'id' },
				{ data: 'name', name: 'name' },
				{ 'className': "text-center", data: 'phone', name: 'phone' },
				{ data: 'email', name: 'email' },
				{ data: 'status', name: 'status' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
			],
			order: [[4, 'desc']],
			rowCallback: function(row,data,index ){
				var text = '';
				if(data['status'] == 1){
					text = 'ผู้ดูแลระบบ';
				}else{
					text = 'พนักงาน';
				}
				$('td:eq(4)', row).html(text);
				$('td:eq(5)', row).html( '<a href="users/update/'+data['id']+'"><i class="icon-pencil7 text-warning"  data-popup="tooltip" title="Update"></i></a> <i class="icon-trash text-danger" onclick="del('+data['id']+');" data-popup="tooltip" title="Delete"></i>' );
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
					window.location.href="users-delete/"+id+"";
				}
			}
		});
	}
</script>
</body>
</html>
@stop