@extends('../template')

@section('content')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header page-header-default">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Dashboard</h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> Home</a></li>
					<li class="active">Dashboard</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">

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
<script type="text/javascript" src="{{asset('assets/js/pages/dashboard.js')}}"></script>
</body>
</html>

@stop