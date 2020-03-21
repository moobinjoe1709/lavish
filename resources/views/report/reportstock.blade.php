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
                        <h2>รายงานสต๊อก</h2>
						<span>วันที่ {{date('d/m/Y H:i',strtotime($date['start']))}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ถึงวันที่&nbsp;{{date('d/m/Y H:i',strtotime($date['end']))}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เวลาที่พิมพ์&nbsp;{{date('d/m/Y H:i:s')}}</span>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:1%">
                <div class="col-xs-12">
					<p>ยอดยกมา : {{number_format($productpast)}}<p>
                    <table style="width:100%;border-collapse: collapse;border:1px solid;">
                        <thead>
                            <tr>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="40px">ลำดับ</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="150px">วันที่</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">รหัสสินค้า</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="200px">สินค้า</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="90px" width="100px">จำนวนนำเข้า</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="90px" width="100px">จำนวนขายออก</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="90px" width="100px">คงเหลือ</th>
                            </tr>
                        </thead>
                        <tbody>
							@php
								if($result){
									$num 			= 1;
									$totalimp 		= 0;
									$totalexp 		= 0;
									$productp 		= $productpast;
									foreach($result as $key => $rs){
										$qtyimp = '';
										$qtyexp = '';
										if($rs['status'] == 1){
											$qtyimp = number_format($rs['qty']);
											$totalimp += $rs['qty'];
											$productp = $productp + $rs['qty'];
										}else{
											$qtyexp = number_format($rs['qty']);
											$totalexp += $rs['qty'];
											$productp = $productp - $rs['qty'];
										}
										@endphp
										<tr>
											<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$num}}</td>
											<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$rs['datetime']}}</td>
											<td class="text-center" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$rs['productcode']}}</td>
											<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$rs['productname']}}</td>
											<td class="text-center" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$qtyimp}}</td>
											<td class="text-center" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$qtyexp}}</td>
											<td class="text-center" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{number_format($productp)}}</td>
										</tr>
										@php
										$num++;
									}
								}
							@endphp
                        </tbody>
						<tfoot>
							<tr>
								<td align="center" style="border-right:1px solid;border-top:1px solid;border-top:1px solid;border-top:1px solid;" colspan="4">รวม</td>
								<td align="center" style="border-right:1px solid;border-top:1px solid;border-top:1px solid;border-top:1px solid;">{{number_format($totalimp)}}</td>
								<td align="center" style="border-right:1px solid;border-top:1px solid;border-top:1px solid;border-top:1px solid;">{{number_format($totalexp)}}</td>
								<td align="center" style="border-top:1px solid;border-top:1px solid;padding:3px"></td>
							</tr>
						</tfoot> 
                    </table>
					<br>
					<div class="pull-right">
						<span>ยอดคงเหลือปัจจุบัน : <span id="qtycurrent">{{number_format($qtycurr)}}</span></span>
					</div>
                </div>
            </div>
            
        </div>
    </body>
</html>