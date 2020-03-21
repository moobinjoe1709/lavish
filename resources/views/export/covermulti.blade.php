<html>
    <head>
        <meta charset="utf-8" />
        
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/colors.css')}}" rel="stylesheet" type="text/css">
	
	    <link href="{{asset('assets/css/lobibox.min.css')}}" rel="stylesheet">
	    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
        <script type="text/javascript" src="{{asset('assets/js/plugins/loaders/pace.min.js')}}"></script>
	    <script type="text/javascript" src="{{asset('assets/js/core/libraries/jquery.min.js')}}"></script>
	    <script type="text/javascript" src="{{asset('assets/js/core/libraries/bootstrap.min.js')}}"></script>
        <style>
            body{
                font-family: 'thaisarabun' !important;
                background-color: white !important;
                margin-top: 0 !important;
                margin-left: 1cm !important;
                margin-right: 1cm !important;
                margin-bottom: 0 !important;
                font-size: 16px !important;
                font-weight: bold !important;
            }
            @page {
                header: page-header;
                footer: page-footer;
            }
			
			.rowtd{
				padding-left:5px;
				height:25px;
				border-right:1px solid;
			}
			
			.linetable{
				border: 1px solid black;
				padding:3px
			}
			.linetables{
				border-right: none;
				border-bottom: 1px solid black;
				padding:3px
			}
			.linedata{
				border-right: 1px solid black;
				padding:3px
			}
			
			#tbmember{
				border: 1px solid black;
				border-radius: 5px;
			}
			
			#tbdate{
				border: 1px solid black;
				border-radius: 2px;
			}
        </style>
    </head>
    <body>
		<div class="row">
		@php
			if($data){
				foreach($data as $rs){
					$exp = DB::table('export')->where('export_id',$rs)->Leftjoin('customer','customer.customer_id','=','export.export_customerid')->first();
					DB::table('export')->where('export_id',$rs)->update(['export_status_print' => 1]);
					@endphp
							<div class="col-xs-5">
								<div class="text-center">
									<img src="{{asset('assets/images/logo.jpeg')}}" width="300px">
								</div>
								<table width="100%">
									<tr>
										<td><span style="font-size:20px;">เลขที่ใบสั่งซื้อ &nbsp;&nbsp;</span></td>
										<td style="border:1px solid black;padding:3px;"><span style="font-size:20px;">{{$exp->export_order}}</span></td>
										<td><span style="font-size:20px;">&nbsp;&nbsp;DHL&nbsp;&nbsp;</span></td>
										<td style="border:1px solid black;padding:3px;"><span style="font-size:20px;">{{$exp->export_inv}}</span></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td><span style="font-size:20px;">ผู้รับ &nbsp;&nbsp;</span></td>
										<td style="border:1px solid black;padding:3px;" colspan="3"><span style="font-size:20px;">{{$exp->export_customername}}</span></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td><span style="font-size:20px;">รหัสสมาชิก &nbsp;&nbsp;</span></td>
										<td style="border:1px solid black;padding:3px;" colspan="2"><span style="font-size:20px;">{{$exp->customer_code}}</span></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td><span style="font-size:20px;">ที่อยู่ &nbsp;&nbsp;</span></td>
										<td style="border:1px solid black;padding:3px;" colspan="3">
											<span style="font-size:20px;">
											@if(!empty($exp->export_customeraddrdel))
												{{$exp->export_customeraddrdel}}
											@else
												{{$exp->export_customeraddr}}
											@endif
											</span>
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td><span style="font-size:20px;">รหัสไปรษณีย์ &nbsp;&nbsp;</span></td>
										<td style="border:1px solid black;padding:3px;" colspan="2"><span style="font-size:20px;">{{$exp->export_customerzipcode}}</span></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td><span style="font-size:20px;">โทรศัพท์ &nbsp;&nbsp;</span></td>
										<td style="border:1px solid black;padding:3px;" colspan="3"><span style="font-size:20px;">{{$exp->export_customertel}}</span></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td valign="top"><span style="font-size:20px;">รายละเอียด &nbsp;&nbsp;</span></td>
										<td valign="top" height="150" style="border:1px solid black;padding:3px;" colspan="3"><span style="font-size:20px;">{{$exp->export_customernote}}</span></td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</div>
							
							<div class="col-xs-1 text-center" style="border-left: 1px solid black;height: 1000px;margin-left:20px;"></div>
							
							
						
					
					<!--<div style="page-break-before:always"></div>-->
					@php
				}
			}
		@endphp
		</div>
    </body>
</html>