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
                        <h2>รายงานคืนสินค้า</h2>
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
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">วันที่</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">รหัสสินค้า</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="200px">สินค้า</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="90px" width="100px">จำนวน</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="90px" width="100px">ราคา</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="90px" width="100px">ยอดขาย</th>
                            </tr>
                        </thead>
                        <tbody>
							@php
								$num 		= 1;
								$total 		= 0;
								if($data){
									foreach($data as $rs){
										$total	+= $rs['total'];
										@endphp
										<tr>
											<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$num}}</td>
											<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$rs['inv']}}</td>
											<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$rs['date']}}</td>
											<td class="text-center" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$rs['code']}}</td>
											<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$rs['product']}}</td>
											<td class="text-center" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{number_format($rs['qty'])}}</td>
											<td class="text-center" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{number_format($rs['price'],2)}}</td>
											<td class="text-right" style="border-right:1px solid;border-top:1px solid;padding-right:3px">{{number_format($rs['total'],2)}}</td>
										</tr>
										@php
										$num++;
									}
								}
							@endphp
                        </tbody>
						<tfoot>
							<tr>
								<td align="center" style="border-right:1px solid;border-top:1px solid;border-top:1px solid;border-top:1px solid;" colspan="7">รวม</td>
								<td align="right" style="border-top:1px solid;border-top:1px solid;padding:3px">{{number_format($total,2)}}</td>
							</tr>
						</tfoot>
                    </table>
                </div>
            </div>
            
        </div>
    </body>
</html>