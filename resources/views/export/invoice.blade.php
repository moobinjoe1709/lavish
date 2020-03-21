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
		@php
			function DateThai($strDate){
				$strYear = date("Y",strtotime($strDate))+543;
				$strMonth= date("n",strtotime($strDate));
				$strDay= date("j",strtotime($strDate));
				$strHour= date("H",strtotime($strDate));
				$strMinute= date("i",strtotime($strDate));
				$strSeconds= date("s",strtotime($strDate));
				$strMonthCut = Array("","มกราคม","กุมภาพันธ์
","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
				$strMonthThai=$strMonthCut[$strMonth];
				return "$strDay $strMonthThai $strYear";
			}
		@endphp
					
        <div class="row">
            <div class="row" name="page-header">
                <div class="row">
					<div class="col-xs-3">
						<img src="{{asset('assets/images/logo.jpeg')}}">
					</div>
                    <div class="col-xs-8">
						<div><span style="font-size:20px;font-weight: bold;">บริษัท ลาวิช (ไทยแลนด์) จำกัด</span><br></div>
						<div style="margin-top:-10px;"><span style="font-size:20px;font-weight: bold;">LAVISH (THAILAND) CO., LTD.</span><br></div>
						<span>บริษัท ลาวิช (ไทยแลนด์) จำกัด 408/2 ซอยลาดพร้าว 94</span><br>
						<div style="margin-top:-10px;"><span>(ปัญจมิตร) ถนนศรีวรา แขวงพลับพลา เขตวังทองหลาง</span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สาขาที่ออกใบกำกับภาษี : สำนักงานใหญ่</span><br></div>
						<div style="margin-top:-10px;"><span>กรุงเทพฯ 10310 02-530-9941 , 082-1936656</span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เลขประจำตัวผู้เสียอากร : 0105559132895</span><br></div>
                    </div>
                </div>
            </div>
			<div class="row">
				<div class="col-xs-12">
				<div style="border-bottom: 1px solid #aaa;"></div>
					<div class="col-xs-7">
						<div class="text-center" style="margin-top:-2px;"><span style="font-size:38px;font-weight: bold;">ต้นฉบับ (Original)</span><br></div>
						<div class="text-center" style="margin-top:-7;"><span style="font-size:24px;">ใบเสร็จรับเงิน / ใบส่งสินค้า / ใบกำกับภาษี</span><br></div>
						<div class="text-center" style="margin-top:-7;"><span style="font-size:24px;">Receipt / Delivery Order / Tax Invoice</span><br></div>
					</div>
					<div class="col-xs-4">
						<div id="tbmember" class="text-center" style="margin-top:5px;">
							<span style="font-size:28px;font-weight: bold;">MEMBER</span>
						</div>
						
						<div style="border:1px solid #000; border-radius: 3px; width:100%; display:block; margin-bottom:15px;margin-top:7;">
							<div style="border-bottom:1px solid #000;">
								<div class="row">
									<div class="col-xs-2 text-center" style="line-height:12px; font-size:12px; font-weight: bold; border-right:1px solid #000; padding-top:3px; padding-bottom:3px;">เลขที่<br>Ref.No</div>
									<div class="col-xs-8">{{$exp->export_inv}}</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-2 text-center" style="line-height:12px; font-size:12px; font-weight: bold; border-right:1px solid #000; padding-top:3px; padding-bottom:3px;">เลขที่<br>Ref.No</div>
								<div class="col-xs-8">{{date('d/m/Y',strtotime($exp->export_date))}}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12">
					<div class="col-xs-5">
						<div id="tbmember" style="height: 80px;">
							<div style="padding-left:5px;line-height:20px;">
								<span style="font-size:18px;font-weight: bold;line-height:30px;">รหัสสมาชิก / Member Code :</span>
								<span style="font-size:16px;">{{$exp->export_customername}}</span>
								<br>
								<span style="font-size:18px;font-weight: bold;">ที่อยู่ / Address</span>
								<span style="font-size:16px;">&nbsp;&nbsp;{{$exp->export_customeraddr}}</span>
							</div>
						</div>
					</div>	
					
					<div class="col-xs-5 pull-right">
						<div id="tbmember" style="height: 80px;">
							<div style="padding-left:5px;line-height:20px;">
								<span style="font-size:18px;font-weight: bold;">สถานที่จัดส่ง / Ship To : บิลปกติ</span>
								<br>
								<span style="font-size:16px;">{{$exp->export_customeraddr}}</span>
							</div>
						</div>
					</div>	
				</div>	
			</div>	
			
			<div class="row">
				<div class="col-xs-12">
					<div style="border:1px solid #000; border-radius: 3px; width:100%; display:block; margin-bottom:15px;margin-top:7;">
						<div style="border-bottom:1px solid #000;">
							<div class="row">
								<div class="col-xs-1 text-center" style="line-height:18px; font-size:14px; font-weight: bold; border-right:1px solid #000; padding-top:3px; padding-bottom:3px;">ผู้แนะนำ<br>Sponsor<br></div>
								<div class="col-xs-2 text-center" style="line-height:18px; font-size:14px; font-weight: bold; border-right:1px solid #000; padding-top:3px; padding-bottom:3px;">วิธีการชำระเงิน<br>Term of payment<br></div>
								<div class="col-xs-1 text-center" style="line-height:18px; font-size:14px; font-weight: bold; border-right:1px solid #000; padding-top:3px; padding-bottom:3px;">โทรศัพท์<br>Telephone<br></div>
								<div class="col-xs-2 text-center" style="line-height:18px; font-size:14px; font-weight: bold; border-right:1px solid #000; padding-top:3px; padding-bottom:3px;">โทรศัพท์มือถือ<br>Mobile Phone<br></div>
								<div class="col-xs-2 text-center" style="line-height:18px; font-size:14px; font-weight: bold; border-right:1px solid #000; padding-top:3px; padding-bottom:3px;">วิธีรับสินค้า<br>Term of delivery<br></div>
								<div class="col-xs-1 text-center" style="line-height:18px; font-size:14px; font-weight: bold; padding-top:3px; padding-bottom:3px;">คลังสินค้า<br>Stock<br></div>
							</div>
						</div>
					</div>
				</div>
			</div>	
			
            <div class="row">
                <div class="col-xs-12">
                    <table style="width:100%;border: 1px solid black;">
                        <thead>
							<tr>
								<td class="text-center linetable" width="20px">ลำดับ<br>Item</td>
								<td class="text-center linetable" width="100px">รหัสสินค้า<br>Product Code</td>
								<td class="text-center linetable" width="200px">รายการ<br>Description</td>
								<td class="text-center linetable">จำนวน<br>Quantity</td>
								<td class="text-center linetable" width="40px">หน่วย<br>Unit</td>
								<td class="text-center linetable" width="80px">ราคาต่อหน่วย<br>Unit Price</td>
								<td class="text-center linetable" width="80px">ราคาสมาชิก<br>Member Price</td>
								<td class="text-center linetable">PV</td>
								<td class="text-center linetable" width="80px">จำนวนเงิน<br>Amount</td>
							</tr>
                        </thead>
                        <tbody>
                            @php
								$num 		= 1;
								$totalpro 	= 0;
								if($data){
									foreach($data as $rs){
										$totalpro += $rs['totalint'];
										@endphp
										<tr>
											<td class="linedata" align="center">{{$num}}</td>
											<td class="linedata">{{$rs['code']}}</td>
											<td class="linedata">{{$rs['name']}}</td>
											<td class="linedata" align="center">{{$rs['qty']}}</td>
											<td class="linedata" align="center">{{$rs['unit']}}</td>
											<td class="linedata" align="right">{{$rs['price']}}</td>
											<td class="linedata" align="right"></td>
											<td class="linedata" align="right"></td>
											<td class="linedata" align="right">{{$rs['total']}}</td>
										</tr>
										@php
										$num++;
									}
								}
								
								$count 		= count($data);
								$totalrow 	= 9;
								$res 		= $totalrow - $count;
								
								for($x=0;$x < $res;$x++){
									@endphp
										<tr>
											<td class="linedata">&nbsp;</td>
											<td class="linedata">&nbsp;</td>
											<td class="linedata">&nbsp;</td>
											<td class="linedata">&nbsp;</td>
											<td class="linedata">&nbsp;</td>
											<td class="linedata">&nbsp;</td>
											<td class="linedata">&nbsp;</td>
											<td class="linedata">&nbsp;</td>
											<td class="linedata">&nbsp;</td>
										</tr>
									@php
								}
							@endphp
							<tr>
								<td style="border-top: 1px solid black;"></td>
								<td style="border-top: 1px solid black;"></td>
								<td style="border-top: 1px solid black;"></td>
								<td style="border-top: 1px solid black;"></td>
								<td style="border-top: 1px solid black;"></td>
								<td style="border-top: 1px solid black;"></td>
								<td style="border-top: 1px solid black;"></td>
								<td style="border-top: 1px solid black;"></td>
								<td style="border-top: 1px solid black;"></td>
							</tr> 
                        </tbody>
						<tfoot>
							<tr>
								<td align="left" style="padding-left:5px;border-right: 1px solid black;border-bottom: 1px solid black;" colspan="4"><span style="font-size:14px;">ตัวอักษร   :  {{$total['totalfont']}}บาทถ้วน</span></td>
								<td align="right" style="padding-right:5px;border-right: 1px solid black;" colspan="4"><span style="font-size:14px;">รวม</span></td>
								<td height="20" align="right" style="padding-right:3px;border-right: 1px solid black;border-bottom: 1px solid black;">{{number_format($exp->export_total,2)}}</td>
							</tr>
							<tr>
								<td  align="left" style="padding-left:5px;line-height:15px;" colspan="5" rowspan="3"><div style="margin-top:10px;"><span style="font-size:12px;margin-top:10px;"><br>1. ได้รับสินค้าตามรายการข้างต้นในสภาพสมบูรณ์พร้อมต้นฉบับใบเสร็จรับเงินถูกต้องเรียบร้อยแล้ว<br>Received the above mentioned merchandise in goods order and condition with original receipt.<br>2.สินค้า/บริการตามใบส่งสินค้านี้ หากมีการชำรุดเสียหายหรือขาดตกบกพร่องประการใด โปรดแจ้งให้บริษัทฯ ทราบภายใน 7 วัน<br>และโปรดนำใบเสร็จรับเงินมาด้วยทุกครั้งหากไม่มีใบเสร็จรับเงินทางบริษัทฯขอสงวนสิทธิ์ในการเปลี่ยนสินค้า<br>Any Discrepancy reaiating to goods on this delivery order must be notified with in 7 days from date of purchase with the original receipt only. Otherwise claims will not be honored.</span></div></td>
								<td align="right" style="padding-right:5px;border-right: 1px solid black;" colspan="3">ราคาสินค้ารวม</td>
								<td height="20" align="right" style="padding-right:3px;border-right: 1px solid black;border-bottom: 1px solid black;">{{number_format($totalpro,2)}}</td>
							</tr>
							<tr>
								<td align="right" style="padding-right:5px;border-right: 1px solid black;" colspan="3">ส่วนลด</td>
								<td height="20" align="right" style="padding-right:3px;border-right: 1px solid black;border-bottom: 1px solid black;">{{number_format($exp->export_discountsum+$exp->export_lastbill,2)}}</td>
							</tr>
							<tr>
								<td align="right" style="padding-right:5px;border-right: 1px solid black;" colspan="3">รวมทั้งสิ้น</td>
								<td height="20" align="right" style="padding-right:3px;border-right: 1px solid black;border-bottom: 1px solid black;">{{number_format($totalpro-($exp->export_discountsum+$exp->export_lastbill),2)}}</td>
							</tr>
							<tr>
								<td align="left" style="padding-left:5px" colspan="5" rowspan="2"></td>
								<td align="right" style="padding-right:5px;border-right: 1px solid black;" colspan="3">ภาษีมูลค่าเพิ่ม</td>
								<td height="20" align="right" style="padding-right:3px;border-right: 1px solid black;border-bottom: 1px solid black;">{{number_format($exp->export_vatsum,2)}}</td>
							</tr>
							<tr>
								<td align="right" style="padding-right:5px;border-right: 1px solid black;" colspan="3">มูลค่าสินค้า</td>
								<td height="20" align="right" style="padding-right:3px;border-right: 1px solid black;border-bottom: 1px solid black;">{{number_format($exp->export_totalpayment,2)}}</td>
							</tr>
						</tfoot>
                    </table>
					<div class="row">
						<div class="col-xs-12">
							<div style="border:1px solid #000; border-radius: 3px; width:100%; display:block; margin-bottom:15px;margin-top:7;">
								<div style="border-bottom:1px solid #000;">
									<div class="row">
										<div class="col-xs-2 text-center" style="line-height:18px; font-size:14px; font-weight: bold; border-right:1px solid #000; padding-top:3px; padding-bottom:3px;"><br><br><br>ผู้รับเงิน/Prepared by<br>วันที่ Date...../....../.........<br></div>
										<div class="col-xs-2 text-center" style="line-height:18px; font-size:14px; font-weight: bold; border-right:1px solid #000; padding-top:3px; padding-bottom:3px;"><br><br><br>ผู้จ่าย/Stock<br>วันที่ Date...../....../.........<br></div>
										<div class="col-xs-2 text-center" style="line-height:18px; font-size:14px; font-weight: bold; border-right:1px solid #000; padding-top:3px; padding-bottom:3px;"><br><br><br>ผู้ส่งสินค้า/Delivery by<br>วันที่ Date...../....../.........<br></div>
										<div class="col-xs-2 text-center" style="line-height:18px; font-size:14px; font-weight: bold; border-right:1px solid #000; padding-top:3px; padding-bottom:3px;"><span style="font-size:10px;">ในนามบริษัท ลาวิช (ไทยแลนด์) จำกัด<br><span style="margin-bottom:10;">For LAVISH (THAILAND) CO., LTD.</span><br><br>ผู้รับสินค้า/Received by<br>วันที่ Date...../....../.........<br></div>
										<div class="col-xs-2 text-center" style="line-height:18px; font-size:14px; font-weight: bold; padding-top:3px; padding-bottom:3px;"><span style="font-size:10px;">ในนามบริษัท ลาวิช (ไทยแลนด์) จำกัด<br><span style="margin-bottom:10;">For LAVISH (THAILAND) CO., LTD.</span></span><br><br>ผู้รับมอบอำนาจ/Authorized Signature</div>
									</div>
								</div>
							</div>
						</div>
					</div>	
                </div>
            </div>
           
        </div>
    </body>
</html>