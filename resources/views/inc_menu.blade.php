<!-- Main navbar -->
<div class="navbar navbar-inverse navbar-fixed-top">
<div class="navbar-header">
<a class="navbar-brand" href="{{url('/')}}"><font size="4">Backoffice</font></a>

<ul class="nav navbar-nav visible-xs-block">
	<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
	<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
</ul>
</div>

<div class="navbar-collapse collapse" id="navbar-mobile">
<ul class="nav navbar-nav">
	<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
</ul>

<p class="navbar-text"><span class="label bg-success">Online</span></p>

<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<i class="icon-alarm-add"></i>
			<span class="visible-xs-inline-block position-right">Messages</span>
			@php
				$datec 		= date('m',  strtotime("+1 month")); 
				// dd($datec,date('m'),date('d'));
				$countbirth = DB::table('customer')->whereMonth('customer_birth',date('m',  strtotime("+1 month")))->whereDay('customer_birth',date('d',  strtotime("+1 month")))->where('customer_status_dob','!=',$datec)->count();
			@endphp
			<span class="badge bg-warning-400">{{$countbirth}}</span>
		</a>
		
		<div class="dropdown-menu dropdown-content width-350">
			<div class="dropdown-content-heading">
				Birth Day
			</div>

			<ul class="media-list dropdown-content-body">
				@php
					$resultbirth = DB::table('customer')->whereMonth('customer_birth',date('m',  strtotime("+1 month")))->whereDay('customer_birth',date('d',  strtotime("+1 month")))->where('customer_status_dob','!=',$datec)->get();
					
					if($resultbirth){
						foreach($resultbirth as $bd){
							@endphp
							<li class="media">
								<div class="media-left"><img src="assets/images/customer/{{$bd->customer_img}}" class="img-circle img-sm" alt=""></div>
								<div class="media-body">
									<a href="{{url('export/gift/create')}}/{{$bd->customer_id}}" class="media-heading">
										<span class="text-semibold">{{$bd->customer_name}}</span>
										<span class="media-annotation pull-right">{{$bd->customer_tel}}</span>
									</a>

									<span class="text-muted">{{$bd->customer_detail}}</span>
								</div>
							</li>
							@php
						}
					}
				@endphp
				
			</ul>

			<div class="dropdown-content-footer">
				<a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
			</div>
		</div>
	</li>
	
	<li class="dropdown dropdown-user">
		<a class="dropdown-toggle" data-toggle="dropdown">
			<img src="{{asset('assets/images/placeholder.jpg')}}" alt="">
			<span>{{Auth::user()->name}}</span>
			<i class="caret"></i>
		</a>

		<ul class="dropdown-menu dropdown-menu-right">
			<li><a href="{{url('logout')}}"><i class="icon-switch2"></i> Logout</a></li>
		</ul>
	</li>
</ul>
</div>
</div>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

<!-- Page content -->
<div class="page-content">

<!-- Main sidebar -->
<div class="sidebar sidebar-main sidebar-fixed">
	<div class="sidebar-content">

		<!-- User menu -->
		<div class="sidebar-user">
			<div class="category-content">
				<div class="media">
					<a href="#" class="media-left"><img src="{{asset('assets/images/placeholder.jpg')}}" class="img-circle img-sm" alt=""></a>
					<div class="media-body">
						<span class="media-heading text-semibold">{{Auth::user()->name}}</span>
					</div>

					<div class="media-right media-middle">
						<ul class="icons-list">
							<li>
								<a href="#"><i class="icon-cog3"></i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- /user menu -->


		<!-- Main navigation -->
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">
					<!-- Main -->
					<li class="navigation-header"><span></span> <i class="icon-menu" title="Main pages"></i></li>
					<li><a href="{{url('export')}}"><i class="icon-cart5"></i> <span>การขาย</span></a></li>
					<li><a href="{{url('dashboard')}}"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
					<li><a href="{{url('users')}}"><i class="icon-user"></i> <span>ผู้ใช้งาน</span></a></li>
					<li><a href="{{url('customer')}}"><i class="icon-users4"></i> <span>ลูกค้า</span></a></li>
					<li><a href="{{url('supplier')}}"><i class="icon-users4"></i> <span>ซัพพลายเออร์</span></a></li>
					<li><a href="{{url('category')}}"><i class="icon-stack"></i> <span>หมวดสินค้า</span></a></li>
					<li><a href="{{url('bank')}}"><i class="icon-credit-card"></i> <span>บัญชีธนาคาร</span></a></li>
					<li><a href="{{url('product')}}"><i class="icon-stack"></i> <span>สินค้า</span></a></li>
				
					@if(Auth::user()->status == 1)
						<li><a href="{{url('import')}}"><i class="icon-box-add position-left"></i> ซื้อสินค้า</a></li>
					@endif
					<li>
						<a href="#"><i class="icon-cart position-left"></i> <span>คืนสินค้า</span></a>
						<ul>
							<li><a href="{{url('return')}}">สินค้าตีกลับ (Lavish กับ ลูกค้า)</a></li>
							<li><a href="{{url('return/supplier')}}">ส่งคืนสินค้า (Lavish กับ Supplier)</a></li>
						</ul>
					</li>
					<li><a href="{{url('withdraw')}}"><i class="icon-cart position-left"></i> เบิกสินค้า</a></li>
					<li><a href="{{url('payment')}}"><i class="icon-cash4"></i> <span>การเงิน</span></a></li>
					<li>
						<a href="#"><i class="icon-stats-bars2"></i> <span>รายงาน</span></a>
						<ul>
							<li><a href="{{url('report/daily')}}">รายวัน</a></li>
							<li><a href="#">รายงานแลกของรางวัล</a></li>
							<li><a href="{{url('report/saler')}}">รายงานเซลล์</a></li>
							<li><a href="{{url('report/product')}}">รายงานสินค้า</a></li>
							<li><a href="{{url('report/customer')}}">รายงานลูกค้า</a></li>
							<li><a href="{{url('report/statement')}}">รายงานการเงิน</a></li>
							<li><a href="{{url('report/stock')}}">รายงานสต๊อก</a></li>
							<li><a href="{{url('report/return')}}">รายงานคืนสินค้า</a></li>
							<li><a href="{{url('report/withdraw')}}">รายงานเบิกสินค้า</a></li>
							<li><a href="{{url('report/supplier')}}">รายงานซัพพลายเออร์</a></li>
						</ul>
					</li>
					<li><a href="{{url('logs')}}"><i class="icon-stack"></i> <span>LOGS</span></a></li>
				</ul>
			</div>
		</div>
		<!-- /main navigation -->

	</div>
</div>
<!-- /main sidebar -->
