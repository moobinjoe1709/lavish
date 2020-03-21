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
                        <h2>รายการการเงิน</h2>
						<span>วันที่ {{date('d/m/Y H:i',strtotime($date['start']))}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ถึงวันที่&nbsp;{{date('d/m/Y H:i',strtotime($date['end']))}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เวลาที่พิมพ์&nbsp;{{date('d/m/Y H:i:s')}}</span>
                    </div>
                </div>
            </div>
			@php
				if(is_numeric($status) == false){
					$statusrep = $status;
				}else if($status == 5){
					$statusrep = 'ชำระด้วยบัตรเครดิต';
				}else if($status == 6){
					$statusrep = 'เงินสด';
				}else if($status == 7){
					$statusrep = 'เก็บเงินปลายทาง';
				}
			@endphp
            <div class="row" style="margin-top:1%">
                <div class="col-xs-12">
					<h5>สถานะจ่ายเงิน : {{$statusrep}}</h5>
                    <table style="width:100%;border-collapse: collapse;border:1px solid;">
                        <thead>
                            <tr>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="40px">ลำดับ</th>
								<th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">วันที่ส่งของ</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">เลขที่ออเดอร์</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">เลขที่ใบสำคัญ</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="200px">รายละเอียดลูกค้า</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">วันที่เงินเข้าธนาคาร</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">รายการ</th>
								<th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">เลขที่อ้างอิงบัตรเครดิต</th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="90px">ยอดเงิน</th>
                            </tr>
                        </thead>
                        <tbody>
							@php
								$total	= 0; 
								if($statement){
									$num 	= 1;
									foreach($statement as $key => $rs){
										$inv 		= '';
										$invref		= '';
										$ref 		= '';
										$stat 		= '';
										$amount 	= 0;
										$datetime 	= '';
										$statcre 	= '';
										
										if($rs->export_status != 4){
											$total 		+= $rs->payment_amount;
											$amount 	= $rs->payment_amount;
										}else{
											$total		+= $rs->export_totalpayment;
											$amount		= $rs->export_totalpayment;
										}
										
										if(!empty($rs->tran_statuscredit)){
											$statcre = $rs->tran_statuscredit;
										}
										if($rs->export_inv != null){
											$inv = $rs->export_inv;
										}
										if($rs->payment_refcredit != null){
											$invref = $rs->payment_refcredit;
										}
										if(!empty($rs->export_order)){
											$ref = $rs->export_order;
										}
										if(!empty($rs->payment_status)){
											$stat = $rs->payment_status;
										}
										if(!empty($rs->payment_datebank)){
											$datetime = $rs->payment_datebank.' '.$rs->payment_datetimebank;
										}
										
										@endphp
										<tr>
											<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$num}}</td>
											<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$rs->export_date}}</td>
											<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$inv}}</td>
											<td class="text-center" style="border-right:1px solid;border-top:1px solid;">{{$ref}}</td>
											<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$rs->customer_name}}</td>
											<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$datetime}}</td>
											<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$stat}}</td>
											<td class="text-left" style="padding-left:7px;border-right:1px solid;border-top:1px solid;">{{$invref}}</td>
											<td class="text-right" style="border-right:1px solid;border-top:1px solid;padding-right:7px">{{number_format($amount,2)}}</td>
										</tr>
										@php
										$num++;
									}
								}
							@endphp
                        </tbody>
						<tfoot>
							<tr>
								<td align="center" style="border-right:1px solid;border-top:1px solid;border-top:1px solid;border-top:1px solid;" colspan="8">รวม</td>
								<td align="right" style="border-top:1px solid;border-top:1px solid;padding:3px">{{number_format($total,2)}}</td>
							</tr>
						</tfoot>
                    </table>
                </div>
            </div>
            
        </div>
    </body>
</html>