@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">บัญชีธนาคาร</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li class="active">บัญชีธนาคาร</li>
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
							<form class="form-horizontal" action="#">
								<div class="form-group">
									<div class="col-lg-12">
										<div class="row">
											<div class="pull-right">
												<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModaladd"><i class="icon-plus-circle2"></i> เพิ่ม</button>
											</div>
										</div>
									</div>
								</div>
	                        </form>
							
							<div class="table-responsive">
								<table class="table datatable-basic">
									<thead>
										<tr>
											<th class="text-center">ลำดับ</th>
											<th class="text-center">รายการ</th>
											<th class="text-center">#</th>
										</tr>
									</thead>
									<tbody>
										@php
											if($bank){
												$num = 1;
												foreach($bank as $rs){
													@endphp
													<tr>
														<td align="center">{{$num}}</td>
														<td align="left">{{$rs->name}}</td>
														<td align="center">
															<button type="button" class="btn border-warning text-warning-600 btn-flat btn-icon" onclick="up({{$rs->id}})"><i class="icon-pencil6"></i></button>  <button type="button" class="btn border-danger text-warning-600 btn-flat btn-icon" onclick="del({{$rs->id}})"><i class="icon-trash"></i></button>
															</td>
													</tr>
													@php
													$num++;
												}
											}
										@endphp
									</tbody>
								</table>
							</div>
						</div>
					</div>
			</div>
		</div>
		
		<!-- Modal Add -->
		<div id="myModaladd" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">เพิ่มบัญชีธนาคาร</h4>
			  </div>
			  <form id="myForm" method="post" action="{{url('bankcreate')}}">
				<div class="modal-body">
					{{ csrf_field() }}
					<div class="row">
						<label class="control-label col-sm-2 col-xs-12">บัญชีธนาคาร :</label>
						<div class="col-sm-10 col-xs-12">
							<input type="text" class="form-control" name="name" required>
						</div>
					</div>
					<br>
					<div class="row">
						<label class="control-label col-sm-2 col-xs-12">ชื่อย่อธนาคาร :</label>
						<div class="col-sm-10 col-xs-12">
							<input type="text" class="form-control" name="title" id="title" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success"><i class="icon-floppy-disk"></i>  บันทึก</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" ><i class="icon-rotate-ccw3"></i>  ปิด</button>
				</div>
			</form>
			</div>

		  </div>
		</div>
		
		<!-- Modal Edit -->
		<div id="myModaledit" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">แก้ไขบัญชีธนาคาร</h4>
			  </div>
			  <form id="myForm" method="post" action="{{url('bankupdate')}}">
				<input type="hidden" name="updateid" id="updateid">
				<div class="modal-body">
					{{ csrf_field() }}
					<div class="row">
						<label class="control-label col-sm-2 col-xs-12">บัญชีธนาคาร :</label>
						<div class="col-sm-10 col-xs-12">
							<input type="text" class="form-control" name="nameup" id="nameup" required>
						</div>
					</div>
					<br>
					<div class="row">
						<label class="control-label col-sm-2 col-xs-12">ชื่อย่อธนาคาร :</label>
						<div class="col-sm-10 col-xs-12">
							<input type="text" class="form-control" name="titleup" id="titleup" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success"><i class="icon-floppy-disk"></i>  บันทึก</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" ><i class="icon-rotate-ccw3"></i>  ปิด</button>
				</div>
			</form>
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
	function up(id){
		$.ajax({
		'type': 'post',
		'url': "{{url('querybank')}}",
		'dataType': 'json',
		'data': {
			'id': id,
			'_token': "{{ csrf_token() }}"
		},
			'success':function(data){
				$('#updateid').val(data.id);
				$('#nameup').val(data.name);
				$('#titleup').val(data.title);
				$('#myModaledit').modal('show');
			}
		});
	}
	
	$('#title').keyup(function(){
		var str = $(this).val().toUpperCase();
		$('#title').val(str);
	});
	
	$('#titleup').keyup(function(){
		var str = $(this).val().toUpperCase();
		$('#titleup').val(str);
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
					window.location.href="{{url('bank/delete')}}/"+id+"";
				}
			}
		});
	}
</script>
</body>
</html>
@stop