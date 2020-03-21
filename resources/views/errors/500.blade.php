<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Thaisteward</title>

	@include('inc_script')

</head>

<body class="login-container">
	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Error title -->
					<div class="text-center content-group">
						<h1 class="error-title">500</h1>
						<h5>Oops, an error has occurred. Page not found!</h5>
					</div>
					<!-- /error title -->


					<!-- Error content -->
					<div class="row">
						<div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
							<form action="#" class="main-search">
								<div class="input-group content-group"></div>

								<div class="row">
									<div class="col-sm-12">
										<a href="{{url('/')}}" class="btn btn-primary btn-block content-group"><i class="icon-circle-left2 position-left"></i> กลับไปหน้าแรก</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- /error wrapper -->


					<!-- Footer -->
					<div class="footer text-muted text-center">
						&copy; 2018-2019. <a href="https://www.orange-thailand.com" target="_blank">Orange Technology Solution</a>
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

</body>
</html>
