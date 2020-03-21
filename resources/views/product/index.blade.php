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
				<li class="active">สินค้า</li>
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
								<a href="{{url('product/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
								<div style="margin-top:17px;"><span style="font-size:16px;">เรียงลำดับ</span>
								<label class="checkbox-inline checkbox-switchery checkbox-right switchery-xs" style="margin-top:-30px;">
									<input type="checkbox" class="switch" value="on">
								</label>
								</div>
							</div>
						</div>
							
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table" id="datatables">
									<thead>
										<tr>
											<th class="text-center">ลำดับ</th>
											<th class="text-center">รหัสสินค้า</th>
											<th class="text-center">หมวดหมู่</th>
											<th class="text-center">รายการ</th>
											<th class="text-center">จำนวน</th>
											<th class="text-center">ราคาขาย</th>
											<th class="text-center">#</th>
										</tr>
									</thead> 
									<tbody id="rowproduct"></tbody>
								</table>
							</div>
						</div>
					</div>
			</div>
		</div>
		
		<div class="modal inmodal" id="import" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content animated fadeIn">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title text-center">นำเข้าสินค้า</h4>
					</div>
					<form id="myForm" method="post" action="{{url('importscreate')}}">
						<div class="modal-body">
							{{ csrf_field() }}
							<input type="hidden" name="proid">
							<input type="hidden" name="userid" value="{{Auth::user()->id}}">
							<div class="row" style="margin-top:1%">
								<label class="control-label col-sm-2 col-xs-3">จำนวนนำเข้า :</label>
								<div class="col-sm-3 col-xs-3">
									<input type="number" class="form-control" name="qty" required>
								</div>
							</div>
						</div>
						<div class="modal-footer" style="margin-top:3%">
							<button type="submit" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<div class="modal inmodal" id="history" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog" style="width:70%">
				<div class="modal-content animated fadeIn">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title text-center">ประวัติสต๊อกสินค้า</h4>
					</div>
					<div class="modal-body">
						<div class="tabs-container">
							<ul class="nav nav-tabs" role="tablist">
								<li><a class="nav-link active" data-toggle="tab" href="#tab-1"> การนำเข้าสินค้า</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#tab-2"> การขายสินค้า</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#tab-3"> การนำออกสินค้า</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" id="tab-1" class="tab-pane active">
									<div class="panel-body table-responsive">
										<table class="table" id="importdata">
											<thead>
												<tr>
													<th class="text-center" width="10%">ลำดับ</th>
													<th class="text-center" width="10%">วันที่</th>
													<th class="text-center" width="20%">เลขที่</th>
													<th class="text-center" width="15%">รายการ</th>
													<th class="text-center" width="15%">จำนวน</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
								<div role="tabpanel" id="tab-2" class="tab-pane">
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
								<div role="tabpanel" id="tab-3" class="tab-pane">
									<div class="panel-body table-responsive" id="exportdata">
										
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
	$(document).on('click','.switchery',function(){
		var check = $(this).parent().find('input').val();
		if(check == 'on'){
			$("#rowproduct").sortable({
				update: function(event, ui){
					$.ajax({
					'dataType': 'json',
					'type': 'post',
					'url': "{{url('productsortable')}}",
					'data': {
						'sortable' : ui.item.context.rowIndex,
						'code' : $(ui.item.context.innerHTML).find('#productid').prevObject[1].outerText,
						'_token': "{{ csrf_token() }}"
					},
						'success': function (data) {
							
						}
					});
				}
			});
			$(this).parent().find('input').val("off");
		}else{
			$("#rowproduct").sortable("disable");
			$(this).parent().find('input').val("on");
		}
	});
	
	$(document).ready(function(){
		var switches = Array.prototype.slice.call(document.querySelectorAll('.switch'));
		switches.forEach(function(html) {
			var switchery = new Switchery(html, {color: '#4CAF50'});
		});
		
		var oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: true,
			ajax:{ 
				url : "{{url('productdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'DT_Row_Index', name: 'product_id' },
				{ 'className': "text-left", data: 'product_code', name: 'product_code' },
				{ 'className': "text-left", data: 'product_category', name: 'product_category' },
				{ data: 'product_name', name: 'product_name' },
				{ 'className': "text-center", data: 'product_qty', name: 'product_qty' },
				{ 'className': "text-right", data: 'product_price', name: 'product_price' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
			],
			rowCallback: function(row,data,index ){
				$('td:eq(6)', row).html( '<input type="hidden" class="form-control" id="productid" name="productid[]" value="'+data['product_id']+'"> <a href="javascript:;" onclick="showaddstock('+data['product_id']+')" title="นำเข้าสินค้า"><i class="icon-box-add text-success"></i></a>  <a href="javascript:;" onclick="showhistory('+data['product_id']+')" title="รายการขาย"><i class="icon-history text-danger"></i></a>  <a href="product/update/'+data['product_id']+'"><i class="icon-pencil7 text-warning"  data-popup="tooltip" title="Update"></i></a> <i class="icon-trash text-danger" onclick="del('+data['product_id']+');" data-popup="tooltip" title="Delete"></i>' );
			}
		});
	});
	
	function showaddstock(id){
        $('input[name="proid"]').val(id);
		$('#import').modal('show');
    }
	
	function showhistory(id){
		var table = $('#importdata').DataTable();
		table.destroy();
		var oTableimport = $('#importdata').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('productimportdata')}}",
				type: "POST",
				data : {
					'id' : id,
					'_token': "{{ csrf_token() }}"
				}
			},
			columns: [
				{ 'className': "text-center", data: 'sub_id', name: 'sub_id' },
				{ data: 'import_date', name: 'import_date' },
				{ data: 'import_inv', name: 'import_inv' },
				{ data: 'product_name', name: 'product_name' },
				{ 'className': "text-center", data: 'sub_qty', name: 'sub_qty' },
			],
			order: [[0, 'desc']],
		});
		
		oTableimport.on( 'order.dt search.dt', function(){
			oTableimport.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();	
		
		var tablesale = $('#saledata').DataTable();
		tablesale.destroy();
		var oTablesale = $('#saledata').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('productsaledata')}}",
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
					window.location.href="product/delete/"+id+"";
				}
			}
		});
	}
</script>
</body>
</html>
@stop