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
        </style>
    </head>
    <body>
        <div class="row">
            <div class="row" name="page-header">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h2>รายการยอดขายรายวัน</h2>
						<span>วันที่ {{date('d/m/Y H:i',strtotime($date['start']))}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ถึงวันที่&nbsp;{{date('d/m/Y H:i',strtotime($date['end']))}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เวลาที่พิมพ์&nbsp;{{date('d/m/Y H:i:s')}}</span>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:1%">
                <div class="col-xs-12">
                    <table style="width:100%;border-collapse: collapse;border:1px solid;">
                        <thead>
                            <tr>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="40px">ลำดับ</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">เลขที่ออเดอร์</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">เลขที่บิล</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">วันที่</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;">ลูกค้า</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;">เลขที่ผู้เสียภาษี</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="200px">รายการ</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">ราคา</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">จำนวน</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="90px" width="100px">ยอดขาย</th>
                            </tr>
                        </thead>
                        <tbody>
							@php
								if($results){
									$num 		= 1;
									$colspan 	= 9;
									foreach($results as $key => $rs){
										if(count($results[$key]) == 0){
											@endphp
											<tr>
												<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$num}}</td>
												<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['inv']}}</td>
												<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['bill']}}</td>
												<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['date']}}</td>
												<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['customername']}}</td>
												<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['customertax']}}</td>
												<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['product']}}</td>
												<td class="text-right" style="border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['price']}}</td>
												<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['qty']}}</td>
												<td class="text-right" style="border-right:1px solid;border-top:1px solid;padding:3px">{{$results[$key][0]['total']}}</td>
											</tr>
											@php
												if($results[$key][0]['discountsum'] != 0){
													@endphp
													<tr>
														<td align="right" colspan="{{$colspan}}" style="border-right:1px solid;border-top:1px solid;padding:3px">ส่วนลด</td>
														<td align="right" style="border-right:1px solid;border-top:1px solid;padding:3px"><span style="color:green">+{{$results[$key][0]['discountsum']}}</span></td>
													</tr>
													@php
												}
												if($results[$key][0]['vatsum'] != 0){
													@endphp
													<tr>
														<td align="right" colspan="{{$colspan}}" style="border-right:1px solid;border-top:1px solid;padding:3px">ภาษีมูลค่าเพิ่ม</td>
														<td align="right" style="border-right:1px solid;border-top:1px solid;padding:3px"><span style="color:green">+{{$results[$key][0]['vatsum']}}</span></td>
													</tr>
													@php
												}
										}else{
											@endphp
											<tr>
												<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$num}}</td>
												<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['inv']}}</td>
												<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['bill']}}</td>
												<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['date']}}</td>
												<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['customername']}}</td>
												<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['customertax']}}</td>
												<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['product']}}</td>
												<td class="text-right" style="border-right:1px solid;border-top:1px solid;padding:3px">{{$results[$key][0]['price']}}</td>
												<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$results[$key][0]['qty']}}</td>
												<td class="text-right" style="border-right:1px solid;border-top:1px solid;padding:3px">{{$results[$key][0]['total']}}</td>
											</tr>
											@php
												for($i=1;$i<count($results[$key]);$i++){
													$num++;
													@endphp
													<tr>
														<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$num}}</td>
														<td class="text-center" style="border-right:1px solid;border-top:1px solid;"></td>
														<td class="text-center" style="border-right:1px solid;border-top:1px solid;"></td>
														<td class="text-center" style="border-right:1px solid;border-top:1px solid;"></td>
														<td class="text-center" style="border-right:1px solid;border-top:1px solid;"></td>
														<td class="text-center" style="border-right:1px solid;border-top:1px solid;"></td>
														<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$results[$key][$i]['product']}}</td>
														<td class="text-right" style="border-right:1px solid;border-top:1px solid;padding:3px">{{$results[$key][$i]['price']}}</td>
														<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$results[$key][$i]['qty']}}</td>
														<td class="text-right" style="border-right:1px solid;border-top:1px solid;padding:3px">{{$results[$key][$i]['total']}}</td>
													</tr>
												@php
													}
											
											if($results[$key][0]['discountsum'] != 0){
												@endphp
												<tr>
													<td align="right" colspan="{{$colspan}}" style="border-right:1px solid;border-top:1px solid;padding:3px">ส่วนลด</td>
													<td align="right" style="border-right:1px solid;border-top:1px solid;padding:3px"><span style="color:green">+{{$results[$key][0]['discountsum']}}</span></td>
												</tr>
												@php
											}
											
											if($results[$key][0]['vatsum'] != 0){
												@endphp
												<tr>
													<td align="right" colspan="{{$colspan}}" style="border-right:1px solid;border-top:1px solid;padding:3px">ภาษีมูลค่าเพิ่ม</td>
													<td align="right" style="border-right:1px solid;border-top:1px solid;padding:3px"><span style="color:green">+{{$results[$key][0]['vatsum']}}</span></td>
												</tr>
												@php
											}
											
											@endphp
											<tr>
												<td align="right" colspan="{{$colspan}}" style="border-right:1px solid;border-top:1px solid;padding:3px">รวม</td>
												<td align="right" style="border-right:1px solid;border-top:1px solid;padding:3px"><span style="color:blue">{{$results[$key][0]['totalpay']}}</span></td>
											</tr>
											@php
										}
										$num++;
									}
								}
							@endphp
                        </tbody>
						<tfoot>
							<tr>
								<td align="center" style="border-right:1px solid;border-top:1px solid;border-top:1px solid;border-top:1px solid;" colspan="{{$colspan}}">รวม</td>
								<td align="right" style="border-top:1px solid;border-top:1px solid;padding:3px">{{$total['sumsale']}}</td>
							</tr>
						</tfoot>
                    </table>
					<br>
					<div style="text-align: right;">
						<table width="100%">
							<tr>
								<td align="left" width="750px"><span></span></td>
								<td align="left" width="150px"><span>ยอดชำระเงินสด </span></td>
								<td align="right"><span id="cashtxt">{{$total['totalscash']}}</span></td>
							</tr>
							<tr>
								<td align="left" width="750px"><span></span></td>
								<td align="left"><span>ยอดชำระบัตรเครดิต </span></td>
								<td align="right"><span id="credittxt">{{$total['totalscredit']}}</span></td>
							</tr>
							<tr>
								<td align="left" width="750px"><span></span></td>
								<td align="left"><span>ยอดชำระผ่านบัญชี </span></td>
								<td align="right"><span id="banktxt">{{$total['totalsbank']}}</span></td>
							</tr>
							<tr>
								<td align="left" width="750px"><span></span></td>
								<td align="left"><span>ยอดรวมทั้งสิ้น </span></td>
								<td align="right"><span id="banktxt">{{$total['totalall']}}</span></td>
							</tr>
						</table>
					</div>
                </div>
            </div>
            
        </div>
    </body>
</html>