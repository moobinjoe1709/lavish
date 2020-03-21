@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">เบิกสินค้า</span></h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> หน้าแรก</a></li>
				<li class="active">เบิกสินค้า</li>
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
							<h5 class="panel-title">เบิกสินค้า</h5>
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
								<a href="{{url('withdraw/create')}}"><button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
							</div>
						</div>
							
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table" id="datatables">
									<thead>
										<tr>
											<th class="text-center" width="10%">ลำดับ</th>
											<th class="text-center" width="20%">เลขที่ออเดอร์</th>
											<th class="text-center" width="20%">เอกสารอ้างอิง</th>
											<th class="text-center" width="20%">ลูกค้า</th>
											<th class="text-center" width="20%">วันที่</th>
											<th class="text-center" width="20%">สถานะ</th>
											<th class="text-center" width="15%">รวม</th>
											<th class="text-center" width="10%">#</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
			</div>
		</div>
		
		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">รายละเอียด</h4>
			  </div>
			  <div class="modal-body">
				<table class="table">
					<thead>
						<tr>
							<th class="text-center">ลำดับ</th>
							<th class="text-center">รายการ</th>
							<th class="text-center">ราคา</th>
							<th class="text-center">จำนวน</th>
							<th class="text-center">รวม</th>
						</tr>
					</thead>
					<tbody id="resorders">
					</tbody>
				</table>
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
				url : "{{url('withdrawdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'export_id', name: 'export.export_id' },
				{ 'className': "text-center", data: 'export_inv', name: 'export.export_inv' },
				{ 'className': "text-center", data: 'export_ref', name: 'export.export_ref' },
				{ 'className': "text-left", data: 'customer_name', name: 'customer.customer_name' },
				{ 'className': "text-center", data: 'export_date', name: 'export.export_date' },
				{ 'className': "text-center", data: 'export_status', name: 'export.export_status' },
				{ 'className': "text-center", data: 'export_totalpayment', name: 'export.export_totalpayment' },
				{ 'className': "text-center", data: 'updated_at', name: 'export.updated_at' },
			],
			order: [[0, 'desc']],
			pageLength: 100,
			rowCallback: function(row,data,index ){
				var status = '<span class="label bg-danger">เบิกสินค้า</span>';
				$('td:eq(5)', row).html(status);
				$('td:eq(7)', row).html( '<i class="icon-trash" onclick="del('+data['export_id']+');" data-popup="tooltip" title="ลบรายการ"></i>' );
				
				$('td:eq(0)', row).addClass('controlid');
				$('td:eq(1)', row).addClass('controlid');
				$('td:eq(2)', row).addClass('controlid');
				$('td:eq(3)', row).addClass('controlid');
				$('td:eq(4)', row).addClass('controlid');
				$('td:eq(5)', row).addClass('controlid');
				$('td:eq(6)', row).addClass('controlid');
			}
		});
		
		oTable.on( 'order.dt search.dt', function(){
			oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();
		
		$('#datatables tbody').on('click', 'td.controlid',function(){
			var tr 	= $(this).closest('tr');
			var row = oTable.row(tr);
			format(row.data());
		});
		
		function format(d){
			$('.rowdata').closest('tr').remove();
			$.ajax({
			'type': 'post',
			'url': "{{url('queryorder')}}",
			'dataType': 'json',
			'data': {
				'exportid': d.export_id,
				'_token': "{{ csrf_token() }}"
			},
				'success': function (data){
					var num = 1;
					$.each(data.orders,function(key,item){
						$('#resorders').append('<tr class="rowdata">'
							+'<td align="center">'+num+'</td>'
							+'<td align="left">'+item.product_name+'</td>'
							+'<td align="right">'+formatNumber(item.order_price.toFixed(2))+'</td>'
							+'<td align="center">'+formatNumber(item.order_qty)+'</td>'
							+'<td align="right">'+formatNumber(item.order_total.toFixed(2))+'</td>'
						+'</tr>');
						num++;
					});
					$('#myModal').modal('show');
				}
			});
		}
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
					window.location.href="withdraw/delete/"+id+"";
				}
			}
		});
	}
</script>
</body>
</html>
@stop