<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use PDF;
use Excel;

class ReportController extends Controller
{
    public function daily(){
		return view('report/daily');
	}
	
	public function reportdatadaily(Request $request){
		$start 			= $request->input('start');
		$enddate 		= $request->input('end');
		
		$sale 			= DB::table('export')->whereBetween('export_date',[$start,$enddate])->get();

		$results 		= [];
		$sumsale 		= 0;
		$totals 		= 0;
		$totalscash 	= 0;
		$totalscredit 	= 0;
		$totalsbank 	= 0;
		
		
		if($sale){
			foreach($sale as $rs){
				$cash 			= DB::table('payment')->where('payment_ref',$rs->export_id)->where('payment_type',1)->sum('payment_amount');
				$credit 		= DB::table('payment')->where('payment_ref',$rs->export_id)->where('payment_type',2)->sum('payment_amount');
				$bank 			= DB::table('payment')->where('payment_ref',$rs->export_id)->where('payment_type',3)->sum('payment_amount');
				$totalscash		+= $cash;
				$totalscredit	+= $credit;
				$totalsbank		+= $bank;
				$sumsale 		+= $rs->export_totalpayment;
				$totals 		+= $rs->export_totalpayment;
				
		
				$orders = DB::table('orders')->join('product','product.product_id','=','orders.order_productid')->where('order_ref',$rs->export_id)->get();
				if($orders){
					foreach($orders as $ar){
						$results[$rs->export_id][] = [
							'inv'			=> $rs->export_inv,
							'bill'			=> $rs->export_order,
							'date'			=> date('d/m/Y',strtotime($rs->export_date)),
							'customername'	=> $rs->export_customername,
							'customertax'	=> $rs->export_customertax,
							'product'		=> $ar->product_name,
							'discountsum'	=> $rs->export_discountsum,
							'vatsum'		=> $rs->export_vatsum,
							'qty'			=> number_format($ar->order_qty),
							'price'			=> number_format($ar->order_price,2),
							'total'			=> number_format($ar->order_total,2),
							'totalpay'		=> number_format($rs->export_totalpayment,2),
						];
					}
				}
			}
		}
		$totalall = number_format($totalscash+$totalscredit+$totalsbank,2);
		$total[] = ['totalall' => $totalall,'sumsale' => number_format($sumsale,2),'totals' => number_format($totals,2),'totalscash' => number_format($totalscash,2),'totalscredit' => number_format($totalscredit,2),'totalsbank' => number_format($totalsbank,2)];
		
		return Response::json(['results' => $results,'total' => $total]);
	}
	
	public function dailypdf(Request $request){
		$start 			= $request->input('datestart');
		$enddate 		= $request->input('dateend');
		$sale 			= DB::table('export')->whereBetween('export_date',[$start,$enddate])->get();
		
		$results 		= [];
		$sumsale 		= 0;
		$totals 		= 0;
		$totalscash 	= 0;
		$totalscredit 	= 0;
		$totalsbank 	= 0;
		
		if($sale){
			foreach($sale as $rs){
				$cash 			= DB::table('payment')->where('payment_ref',$rs->export_id)->where('payment_type',1)->sum('payment_amount');
				$credit 		= DB::table('payment')->where('payment_ref',$rs->export_id)->where('payment_type',2)->sum('payment_amount');
				$bank 			= DB::table('payment')->where('payment_ref',$rs->export_id)->where('payment_type',3)->sum('payment_amount');
				$totalscash		+= $cash;
				$totalscredit	+= $credit;
				$totalsbank		+= $bank;
				$sumsale 		+= $rs->export_totalpayment;
				$totals 		+= $rs->export_totalpayment;
				
		
				$orders = DB::table('orders')->join('product','product.product_id','=','orders.order_productid')->where('order_ref',$rs->export_id)->get();
				if($orders){
					foreach($orders as $ar){
						$results[$rs->export_id][] = [
							'inv'			=> $rs->export_inv,
							'bill'			=> $rs->export_order,
							'date'			=> date('d/m/Y',strtotime($rs->export_date)),
							'customername'	=> $rs->export_customername,
							'customertax'	=> $rs->export_customertax,
							'product'		=> $ar->product_name,
							'discountsum'	=> $rs->export_discountsum,
							'vatsum'		=> $rs->export_vatsum,
							'qty'			=> number_format($ar->order_qty),
							'price'			=> number_format($ar->order_price,2),
							'total'			=> number_format($ar->order_total,2),
							'totalpay'		=> number_format($rs->export_totalpayment,2),
						];
					}
				}
				
			}
		}
	
		$date = [
			'start'		=> $request->input('datestart'),
			'end'		=> $request->input('dateend'),
		];
		
		$totalall = number_format($totalscash+$totalscredit+$totalsbank,2);
		$total = [
			'sumsale' 		=> number_format($sumsale,2),
			'totals' 		=> number_format($totals,2),
			'totalscash' 	=> number_format($totalscash,2),
			'totalscredit' 	=> number_format($totalscredit,2),
			'totalsbank' 	=> number_format($totalsbank,2),
			'totalall' 		=> $totalall,
		];
			
		$pdf = PDF::loadView('report.reportdaily',['results' => $results,'date' => $date,'total' => $total],[],['title' => 'รายงานการขาย','format'=>'A4-L']);
	    return $pdf->stream();
	}
	
	public function dailyexcel($start,$end){
		$sale 			= DB::table('export')->whereBetween('export_date',[$start,$end])->get();
		
		$results 		= [];
		$sumsale 		= 0;
		$totals 		= 0;
		$totalscash 	= 0;
		$totalscredit 	= 0;
		$totalsbank 	= 0;
		
		if($sale){
			foreach($sale as $rs){
				$cash 			= DB::table('payment')->where('payment_ref',$rs->export_id)->where('payment_type',1)->sum('payment_amount');
				$credit 		= DB::table('payment')->where('payment_ref',$rs->export_id)->where('payment_type',2)->sum('payment_amount');
				$bank 			= DB::table('payment')->where('payment_ref',$rs->export_id)->where('payment_type',3)->sum('payment_amount');
				$totalscash		+= $cash;
				$totalscredit	+= $credit;
				$totalsbank		+= $bank;
				$sumsale 		+= $rs->export_totalpayment;
				$totals 		+= $rs->export_totalpayment;
				
		
				$orders = DB::table('orders')->join('product','product.product_id','=','orders.order_productid')->where('order_ref',$rs->export_id)->get();
				if($orders){
					foreach($orders as $ar){
						$payment = DB::table('payment')->where('payment_ref',$ar->order_ref)->first();
						if($payment != null){
							$export_status  = $payment->payment_status;
							if($rs->export_status  == 2){
								$export_status = 'เก็บเงินปลายทาง';
							}else if($rs->export_status == 1){
	
								if($payment->payment_type  == 1){
									$export_status = 'เงินสด';
								}else if($payment->payment_type == 2){
									$export_status = 'บัตรเครดิต/เดบิต  '.$payment->payment_refcredit;
								}else{
									if($payment->payment_status == 1){
										$payment_status = 'KBANK';
									}else if($payment->payment_status == 2){
										$payment_status = 'SCB';
									}else if($payment->payment_status == 3){
										$payment_status = 'BBL';
									}else if($payment->payment_status == 4){
										$payment_status ='KTC'; 
									}else if($payment->payment_status == 5){
										$payment_status ='BAY'; 
									}else{
										$payment_status = $payment->payment_status;
									}
									$export_status = 'โอนบัญชี มายังบัญชี '.$payment_status.'  ชำระเงินวันที่ '.$payment->payment_datebank.' เวลา : '.$payment->payment_datetimebank;
								}
	
							}else if($rs->export_status == 0){
								$export_status = 'ยังไม่ชำระเงิน';
							}
						}else{
							$export_status = 'ยังไม่ชำระเงิน';
						}
					
						$results[$rs->export_id][] = [
							'inv'			=> substr($rs->export_inv,5,15),
							'bill'			=> $rs->export_order,
							'date'			=> date('d/m/Y',strtotime($rs->export_date)),
							'customername'	=> $rs->export_customername,
							'customertax'	=> $rs->export_customertax,
							'product'		=> $ar->product_name,
							'discountsum'	=> $rs->export_discountsum,
							'vatsum'		=> $rs->export_vatsum,
							'qty'			=> number_format($ar->order_qty),
							'price'			=> number_format($ar->order_price,2),
							'total'			=> number_format($ar->order_total,2),
							'totalpay'		=> number_format($rs->export_totalpayment,2),
							'status'		=> $export_status,
						];
					}
				}
			}
		}
	
		$date = [
			'start'		=> $start,
			'end'		=> $end,
		];
		
		$totalall = number_format($totalscash+$totalscredit+$totalsbank,2);
		$total = [
			'sumsale' 		=> number_format($sumsale,2),
			'totals' 		=> number_format($totals,2),
			'totalscash' 	=> number_format($totalscash,2),
			'totalscredit' 	=> number_format($totalscredit,2),
			'totalsbank' 	=> number_format($totalsbank,2),
			'totalall' 		=> $totalall,
		];
		$file = storage_path('template/daily.xlsx');
		
		Excel::load($file, function($doc) use($results,$date,$total) {
		$sheet = $doc->setActiveSheetIndex(0);
		$row = 5;
		$sheet->setCellValue('A2','วันที่ '.date('d/m/Y H:i:s',strtotime($date['start'])).' ถึงวันที่ '.date('d/m/Y H:i:s',strtotime($date['end'])).' เวลาที่พิมพ์ '.date('d/m/Y H:i:s'));
		
	
		$i = 1; 
		if(count($results) > 0){
			foreach($results as $key => $rs){
				if(count($results[$key]) == 0){
					$sheet->setCellValue('A'.$row.'',$i);
					$sheet->setCellValue('B'.$row.'',$results[$key][0]['inv']);
					$sheet->setCellValue('C'.$row.'',$results[$key][0]['bill']);
					$sheet->setCellValue('D'.$row.'',$results[$key][0]['date']);
					$sheet->setCellValue('E'.$row.'',$results[$key][0]['customername']);
					$sheet->setCellValue('F'.$row.'',$results[$key][0]['status']);
					$sheet->setCellValue('G'.$row.'',$results[$key][0]['product']);
					$sheet->setCellValue('H'.$row.'',$results[$key][0]['price']);
					$sheet->setCellValue('I'.$row.'',$results[$key][0]['qty']);
					$sheet->setCellValue('J'.$row.'',$results[$key][0]['total']);
					
					if($results[$key][0]['discountsum'] > 0){
						$row++;
						$sheet->setCellValue('D'.$row.'','ส่วนลด');
						$sheet->setCellValue('J'.$row.'',$results[$key][0]['discountsum']);
					}
					
					if($results[$key][0]['vatsum'] > 0){
						$row++;
						$sheet->setCellValue('D'.$row.'','ภาษีมูลค่าเพิ่ม');
						$sheet->setCellValue('J'.$row.'',$results[$key][0]['vatsum']);
					}
					
					$row++;
					$sheet->setCellValue('D'.$row.'','รวม');
					$sheet->setCellValue('J'.$row.'',$results[$key][0]['totalpay']);
					
					$i++;
					$row++;
				}else{
					$sheet->setCellValue('A'.$row.'',$i);
					$sheet->setCellValue('B'.$row.'',$results[$key][0]['inv']);
					$sheet->setCellValue('C'.$row.'',$results[$key][0]['bill']);
					$sheet->setCellValue('D'.$row.'',$results[$key][0]['date']);
					$sheet->setCellValue('E'.$row.'',$results[$key][0]['customername']);
					$sheet->setCellValue('F'.$row.'',$results[$key][0]['status']);
					$sheet->setCellValue('G'.$row.'',$results[$key][0]['product']);
					$sheet->setCellValue('H'.$row.'',$results[$key][0]['price']);
					$sheet->setCellValue('I'.$row.'',$results[$key][0]['qty']);
					$sheet->setCellValue('J'.$row.'',$results[$key][0]['total']);
					
					
					for($x=1;$x<count($results[$key]);$x++){
						$i++;
						$row++;
						
						$sheet->setCellValue('A'.$row.'',$i);
						$sheet->setCellValue('B'.$row.'','');
						$sheet->setCellValue('C'.$row.'','');
						$sheet->setCellValue('D'.$row.'','');
						$sheet->setCellValue('E'.$row.'','');
						$sheet->setCellValue('F'.$row.'','');
						$sheet->setCellValue('G'.$row.'',$results[$key][$x]['product']);
						$sheet->setCellValue('H'.$row.'',$results[$key][$x]['price']);
						$sheet->setCellValue('I'.$row.'',$results[$key][$x]['qty']);
						$sheet->setCellValue('J'.$row.'',$results[$key][$x]['total']);
					}
					
					if($results[$key][0]['discountsum'] > 0){
						$row++;
						$sheet->setCellValue('D'.$row.'','ส่วนลด');
						$sheet->setCellValue('J'.$row.'',$results[$key][0]['discountsum']);
					}
					
					if($results[$key][0]['vatsum'] > 0){
						$row++;
						$sheet->setCellValue('D'.$row.'','ภาษีมูลค่าเพิ่ม');
						$sheet->setCellValue('J'.$row.'',$results[$key][0]['vatsum']);
					}
					
					$row++;
					$sheet->setCellValue('D'.$row.'','รวม');
					$sheet->setCellValue('J'.$row.'',$results[$key][0]['totalpay']);
					
					$i++;
					$row++;
				}
				
			}
			
			$n1 = $row+(1);
			$n2 = $row+(2);
			$n3 = $row+(3);
			$n4 = $row+(4);
			
			$sheet->setCellValue('D'.$n1.'','ยอดชำระเงินสด');
			$sheet->setCellValue('G'.$n1.'',$total['totalscash']);
			$sheet->setCellValue('D'.$n2.'','ยอดชำระบัตรเครดิต');
			$sheet->setCellValue('G'.$n2.'',$total['totalscredit']);
			$sheet->setCellValue('D'.$n3.'','ยอดชำระผ่านบัญชี');
			$sheet->setCellValue('G'.$n3.'',$total['totalsbank']);
			$sheet->setCellValue('D'.$n4.'','ยอดรวมทั้งสิ้น');
			$sheet->setCellValue('G'.$n4.'',$total['totalall']);
		}
			
		})->download('xlsx');
	}
	
	public function saler(){
		$saler = DB::table('users')->where('status',0)->get();
		return view('report/saler',['saler' => $saler]);
	}
	
	public function reportdatasaler(Request $request){
		$start 			= $request->input('start');
		$enddate 		= $request->input('end');
		$saler 			= $request->input('saler');
		
		if($saler == 'all'){
			$sale 	= DB::table('export')
			->Leftjoin('users','users.id','=','export.export_empid')
			->whereBetween('export.created_at',[$start,$enddate])->get();
		}else{
			$sale 	= DB::table('export')
			->Leftjoin('users','users.id','=','export.export_empid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('export.export_empid',$saler)->get();
		}
		
		return Response::json($sale);
	}
	
	public function salerpdf(Request $request){
		$start 			= $request->input('datestart');
		$enddate 		= $request->input('dateend');
		$saler 			= $request->input('saler');
		
		if($saler == 'all'){
			$sale 	= DB::table('export')
			->Leftjoin('users','users.id','=','export.export_empid')
			->whereBetween('export.created_at',[$start,$enddate])->get();
		}else{
			$sale 	= DB::table('export')
			->Leftjoin('users','users.id','=','export.export_empid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('export.export_empid',$saler)->get();
		}
		
		$date = [
			'start'		=> $request->input('datestart'),
			'end'		=> $request->input('dateend'),
		];
		
		$pdf = PDF::loadView('report.reportsaler',['sale' => $sale,'date' => $date],[],['title' => 'รายงานเซลล์','format'=>'A4']);
	    return $pdf->stream();
	}
	
	public function salerexcel($start,$end,$salers){
		if($salers == 'all'){
			$sale 	= DB::table('export')
			->Leftjoin('users','users.id','=','export.export_empid')
			->whereBetween('export.created_at',[$start,$end])->get();
		}else{
			$sale 	= DB::table('export')
			->Leftjoin('users','users.id','=','export.export_empid')
			->whereBetween('export.created_at',[$start,$end])
			->where('export.export_empid',$salers)->get();
		}
	
		$date = [
			'start'		=> $start,
			'end'		=> $end,
		];
		
		$file = storage_path('template/saler.xlsx');
		
		Excel::load($file, function($doc) use($sale,$date) {
		$sheet = $doc->setActiveSheetIndex(0);
		$row = 5;
		$sheet->setCellValue('A2','วันที่ '.date('d/m/Y H:i:s',strtotime($date['start'])).' ถึงวันที่ '.date('d/m/Y H:i:s',strtotime($date['end'])).' เวลาที่พิมพ์ '.date('d/m/Y H:i:s'));
		
	
		$i 		= 1; 
		$total 	= 0; 
		if(count($sale) > 0){
			
			foreach($sale as $rs){
				$total += $rs->export_totalpayment;
				$sheet->setCellValue('A'.$row.'',$i);
				$sheet->setCellValue('B'.$row.'',$rs->export_inv);
				$sheet->setCellValue('C'.$row.'',$rs->export_date);
				$sheet->setCellValue('D'.$row.'',$rs->name);
				$sheet->setCellValue('E'.$row.'',$rs->export_customername);
				$sheet->setCellValue('F'.$row.'',number_format($rs->export_totalpayment,2));
				
				$i++;
				$row++;
			}
			
			
			$sheet->setCellValue('D'.$row.'','รวม');
			$sheet->setCellValue('F'.$row.'',number_format($total,2));
		}
			
		})->download('xlsx');
	}
	
	public function product(){
		$product = DB::table('product')->get();
		return view('report/product',['product' => $product]);
	}
	
	public function reportdataproduct(Request $request){
		$start 			= $request->input('start');
		$enddate 		= $request->input('end');
		$product 		= $request->input('product');
		
		if($product == 'all'){
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])->get();
		}else{
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('orders.order_productid',$product)->get();
		}
		
		return Response::json($product);
	}
	
	public function productpdf(Request $request){
		$start 			= $request->input('datestart');
		$enddate 		= $request->input('dateend');
		$product 		= $request->input('product');
		
		if($product == 'all'){
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])->get();
		}else{
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('orders.order_productid',$product)->get();
		}
		
		$date = [
			'start'		=> $request->input('datestart'),
			'end'		=> $request->input('dateend'),
		];
		
		$pdf = PDF::loadView('report.reportproduct',['product' => $product,'date' => $date],[],['title' => 'รายงานสินค้า','format'=>'A4']);
	    return $pdf->stream();
	}
	
	public function productexcel($start,$end,$product){
		if($product == 'all_blank'){
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$end])->get();
		}else{
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$end])
			->where('orders.order_productid',$product)->get();
		}
	
		$date = [
			'start'		=> $start,
			'end'		=> $end,
		];
		
		$file = storage_path('template/product.xlsx');
		
		Excel::load($file, function($doc) use($product,$date) {
		$sheet = $doc->setActiveSheetIndex(0);
		$row = 5;
		$sheet->setCellValue('A2','วันที่ '.date('d/m/Y H:i:s',strtotime($date['start'])).' ถึงวันที่ '.date('d/m/Y H:i:s',strtotime($date['end'])).' เวลาที่พิมพ์ '.date('d/m/Y H:i:s'));
		
	
		$i 		= 1; 
		$total 	= 0; 
		if(count($product) > 0){
			
			foreach($product as $rs){
				$total += $rs->order_total;
				$sheet->setCellValue('A'.$row.'',$i);
				$sheet->setCellValue('B'.$row.'',$rs->export_inv);
				$sheet->setCellValue('C'.$row.'',$rs->export_date);
				$sheet->setCellValue('D'.$row.'',$rs->product_code);
				$sheet->setCellValue('E'.$row.'',$rs->product_name);
				$sheet->setCellValue('F'.$row.'',$rs->order_qty);
				$sheet->setCellValue('G'.$row.'',number_format($rs->order_total,2));
				
				$i++;
				$row++;
			}
			
			
			$sheet->setCellValue('E'.$row.'','รวม');
			$sheet->setCellValue('G'.$row.'',number_format($total,2));
		}
			
		})->download('xlsx');
	}
	
	
	public function supplier(){
		$customer = DB::table('customer')->where('customer_status',1)->get();
		return view('report/supplier',['customer' => $customer]);
	}
	
	public function reportdatasupplier(Request $request){
		$start 			= $request->input('start');
		$enddate 		= $request->input('end');
		$customer 		= $request->input('customer');
		
		if($customer == 'all'){
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])->get();
		}else{
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('export.export_customerid',$customer)->get();
		}
		
		return Response::json($product);
	}
	
	public function supplierpdf(Request $request){
		$start 			= $request->input('datestart');
		$enddate 		= $request->input('dateend');
		$customer 		= $request->input('customer');
		
		if($customer == 'all'){
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])->get();
		}else{
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('export.export_customerid',$customer)->get();
		}
		
		$date = [
			'start'		=> $request->input('datestart'),
			'end'		=> $request->input('dateend'),
		];
		
		$pdf = PDF::loadView('report.reportsupplier',['product' => $product,'date' => $date],[],['title' => 'รายงานสินค้า','format'=>'A4']);
	    return $pdf->stream();
	}
	
	public function supplierexcel($start,$end,$customer){
		if($customer == 'all'){
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$end])->get();
		}else{
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$end])
			->where('export.export_customerid',$customer)->get();
		}
	
		$date = [
			'start'		=> $start,
			'end'		=> $end,
		];
		
		$file = storage_path('template/supplier.xlsx');
		
		Excel::load($file, function($doc) use($product,$date) {
		$sheet = $doc->setActiveSheetIndex(0);
		$row = 5;
		$sheet->setCellValue('A2','วันที่ '.date('d/m/Y H:i:s',strtotime($date['start'])).' ถึงวันที่ '.date('d/m/Y H:i:s',strtotime($date['end'])).' เวลาที่พิมพ์ '.date('d/m/Y H:i:s'));
		
	
		$i 		= 1; 
		$total 	= 0; 
		if(count($product) > 0){
			
			foreach($product as $rs){
				$total += $rs->order_total;
				$sheet->setCellValue('A'.$row.'',$i);
				$sheet->setCellValue('B'.$row.'',$rs->export_inv);
				$sheet->setCellValue('C'.$row.'',$rs->export_date);
				$sheet->setCellValue('D'.$row.'',$rs->product_code);
				$sheet->setCellValue('E'.$row.'',$rs->product_name);
				$sheet->setCellValue('F'.$row.'',$rs->order_qty);
				$sheet->setCellValue('G'.$row.'',number_format($rs->order_total,2));
				
				$i++;
				$row++;
			}
			
			
			$sheet->setCellValue('E'.$row.'','รวม');
			$sheet->setCellValue('G'.$row.'',number_format($total,2));
		}
			
		})->download('xlsx');
	}
	
	public function customer(){
		$customer = DB::table('customer')->get();
		return view('report/customer',['customer' => $customer]);
	}
	
	public function reportdatacustomer(Request $request){
		$start 			= $request->input('start');
		$enddate 		= $request->input('end');
		$customer 		= $request->input('customer');
		
		if($customer == 'all'){
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])->get();
		}else{
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('export.export_customerid',$customer)->get();
		}
		
		return Response::json($product);
	}
	
	public function customerpdf(Request $request){
		$start 			= $request->input('datestart');
		$enddate 		= $request->input('dateend');
		$customer 		= $request->input('customer');
		
		if($customer == 'all'){
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])->get();
		}else{
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('export.export_customerid',$customer)->get();
		}
		
		$date = [
			'start'		=> $request->input('datestart'),
			'end'		=> $request->input('dateend'),
		];
		
		$pdf = PDF::loadView('report.reportcustomer',['product' => $product,'date' => $date],[],['title' => 'รายงานลูกค้า','format'=>'A4']);
	    return $pdf->stream();
	}
	
	public function customerexcel($start,$end,$customer){
		if($customer == 'all_blank'){
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$end])->get();
		}else{
			$product = DB::table('orders')->select('orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','orders.created_at','export.export_order','export.export_inv','export.export_date','export.export_empname','export.export_customerid','export.export_customername','export.created_at','product.product_name','product.product_code')
			->join('export','export.export_id','=','orders.order_ref')
			->join('product','product.product_id','=','orders.order_productid')
			->whereBetween('export.created_at',[$start,$end])
			->where('export.export_customerid',$customer)->get();
		}
	
		$date = [
			'start'		=> $start,
			'end'		=> $end,
		];
		
		
		$file = storage_path('template/customer.xlsx');
		
		Excel::load($file, function($doc) use($product,$date) {
		$sheet = $doc->setActiveSheetIndex(0);
		$row = 5;
		$sheet->setCellValue('A2','วันที่ '.date('d/m/Y H:i:s',strtotime($date['start'])).' ถึงวันที่ '.date('d/m/Y H:i:s',strtotime($date['end'])).' เวลาที่พิมพ์ '.date('d/m/Y H:i:s'));
		
	
		$i 		= 1; 
		$total 	= 0; 
		if(count($product) > 0){
			
			foreach($product as $rs){
				$total += $rs->order_total;
				$sheet->setCellValue('A'.$row.'',$i);
				$sheet->setCellValue('B'.$row.'',$rs->export_inv);
				$sheet->setCellValue('C'.$row.'',$rs->export_date);
				$sheet->setCellValue('D'.$row.'',$rs->export_customername);
				$sheet->setCellValue('E'.$row.'',$rs->product_name);
				$sheet->setCellValue('F'.$row.'',$rs->order_qty);
				$sheet->setCellValue('G'.$row.'',number_format($rs->order_total,2));
				
				$i++;
				$row++;
			}
			
			
			$sheet->setCellValue('E'.$row.'','รวม');
			$sheet->setCellValue('G'.$row.'',number_format($total,2));
		}
			
		})->download('xlsx');
	}
	
	public function statement(){
		$bank = DB::table('bank')->get();
		return view('report/statement',['bank' => $bank]);
	}
	
	public function reportdatastate(Request $request){
		$start 			= $request->input('start');
		$enddate 		= $request->input('end');
		$status 		= $request->input('status');
		
		if(is_numeric($status) == false){
			$statement = DB::table('payment')
			->select('payment.payment_id','payment.payment_ref','payment.payment_type','payment.payment_refcredit','payment.payment_status','payment.payment_datebank','payment.payment_datetimebank','payment.payment_amount','payment.created_at','export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.created_at','export.updated_at','customer.customer_id','customer.customer_name')
			->join('export','export.export_id','=','payment.payment_ref')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('payment.payment_status',$status)
			->where('export.export_delstatus',1)
			->get();
		}else if($status == 5){
			$statement = DB::table('payment')
			->select('payment.payment_id','payment.payment_ref','payment.payment_type','payment.payment_refcredit','payment.payment_status','payment.payment_datebank','payment.payment_datetimebank','payment.payment_amount','payment.created_at','export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.created_at','export.updated_at','customer.customer_id','customer.customer_name','transaction.tran_ordernumber','transaction.tran_statuscredit')
			->join('export','export.export_id','=','payment.payment_ref')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->Leftjoin('transaction','transaction.tran_ordernumber','=','payment.payment_refcredit')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('payment.payment_type',2)
			->where('export.export_delstatus',1)
			->get();
		}else if($status == 6){
			$statement = DB::table('payment')
			->select('payment.payment_id','payment.payment_ref','payment.payment_type','payment.payment_refcredit','payment.payment_status','payment.payment_datebank','payment.payment_datetimebank','payment.payment_amount','payment.created_at','export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.created_at','export.updated_at','customer.customer_id','customer.customer_name')
			->join('export','export.export_id','=','payment.payment_ref')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('payment.payment_type',1)
			->where('export.export_delstatus',1)
			->get();
		}else if($status == 7){
			$statement = DB::table('export')
			->select('export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.updated_at','export.created_at','customer.customer_id','customer.customer_name')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('export.export_status',4)
			->where('export.export_delstatus',1)
			->get();
		}
		
		return Response::json($statement);
	}
	
	public function statementpdf(Request $request){
		$start 			= $request->input('datestart');
		$enddate 		= $request->input('dateend');
		$status 		= $request->input('status');
		
		if(is_numeric($status) == false){
			$statement = DB::table('payment')
			->select('payment.payment_id','payment.payment_ref','payment.payment_type','payment.payment_refcredit','payment.payment_status','payment.payment_datebank','payment.payment_datetimebank','payment.payment_amount','payment.created_at','export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.created_at','export.updated_at','customer.customer_id','customer.customer_name')
			->join('export','export.export_id','=','payment.payment_ref')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('payment.payment_status',$status)
			->where('export.export_delstatus',1)
			->get();
		}else if($status == 5){
			$statement = DB::table('payment')
			->select('payment.payment_id','payment.payment_ref','payment.payment_type','payment.payment_refcredit','payment.payment_status','payment.payment_datebank','payment.payment_datetimebank','payment.payment_amount','payment.created_at','export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.created_at','export.updated_at','customer.customer_id','customer.customer_name','transaction.tran_ordernumber','transaction.tran_statuscredit')
			->join('export','export.export_id','=','payment.payment_ref')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->Leftjoin('transaction','transaction.tran_ordernumber','=','payment.payment_refcredit')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('payment.payment_type',2)
			->where('export.export_delstatus',1)
			->get();
		}else if($status == 6){
			$statement = DB::table('payment')
			->select('payment.payment_id','payment.payment_ref','payment.payment_type','payment.payment_refcredit','payment.payment_status','payment.payment_datebank','payment.payment_datetimebank','payment.payment_amount','payment.created_at','export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.created_at','export.updated_at','customer.customer_id','customer.customer_name')
			->join('export','export.export_id','=','payment.payment_ref')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('payment.payment_type',1)
			->where('export.export_delstatus',1)
			->get();
		}else if($status == 7){
			$statement = DB::table('export')
			->select('export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.created_at','export.updated_at','export.created_at','customer.customer_id','customer.customer_name')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('export.export_status',4)
			->where('export.export_delstatus',1)
			->get();
		}
		
		$date = [
			'start'		=> $request->input('datestart'),
			'end'		=> $request->input('dateend'),
		];
		$pdf = PDF::loadView('report.reportstatement',['status' => $status,'statement' => $statement,'date' => $date],[],['title' => 'รายงานการเงิน','format'=>'A4']);
	    return $pdf->stream();
	}
	
	public function statementexcel($start,$enddate,$status){
		if(is_numeric($status) == false){
			$statement = DB::table('payment')
			->select('payment.payment_id','payment.payment_ref','payment.payment_type','payment.payment_refcredit','payment.payment_status','payment.payment_datebank','payment.payment_datetimebank','payment.payment_amount','payment.created_at','export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.created_at','export.updated_at','customer.customer_id','customer.customer_name')
			->join('export','export.export_id','=','payment.payment_ref')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('payment.payment_status',$status)
			->where('export.export_delstatus',1)
			->get();
		}else if($status == 5){
			$statement = DB::table('payment')
			->select('payment.payment_id','payment.payment_ref','payment.payment_type','payment.payment_refcredit','payment.payment_status','payment.payment_datebank','payment.payment_datetimebank','payment.payment_amount','payment.created_at','export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.created_at','export.updated_at','customer.customer_id','customer.customer_name','transaction.tran_ordernumber','transaction.tran_statuscredit')
			->join('export','export.export_id','=','payment.payment_ref')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->Leftjoin('transaction','transaction.tran_ordernumber','=','payment.payment_refcredit')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('payment.payment_type',2)
			->where('export.export_delstatus',1)
			->get();
		}else if($status == 6){
			$statement = DB::table('payment')
			->select('payment.payment_id','payment.payment_ref','payment.payment_type','payment.payment_refcredit','payment.payment_status','payment.payment_datebank','payment.payment_datetimebank','payment.payment_amount','payment.created_at','export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.created_at','export.updated_at','customer.customer_id','customer.customer_name')
			->join('export','export.export_id','=','payment.payment_ref')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('payment.payment_type',1)
			->where('export.export_delstatus',1)
			->get();
		}else if($status == 7){
			$statement = DB::table('export')
			->select('export.export_id','export.export_date','export.export_customerid','export.export_order','export.export_inv','export.export_totalpayment','export.export_status','export.export_delstatus','export.created_at','export.updated_at','export.created_at','customer.customer_id','customer.customer_name')
			->join('customer','customer.customer_id','=','export.export_customerid')
			->whereBetween('export.created_at',[$start,$enddate])
			->where('export.export_status',4)
			->where('export.export_delstatus',1)
			->get();
		}
	
		$date = [
			'start'		=> $start,
			'end'		=> $enddate,
		];
		
		
		$file = storage_path('template/statements.xlsx');
		
		Excel::load($file, function($doc) use($statement,$date,$status) {
			if(is_numeric($status) == false){
				$statusrep = $status;
			}else if($status == 5){
				$statusrep = 'ชำระด้วยบัตรเครดิต';
			}else if($status == 6){
				$statusrep = 'เงินสด';
			}else if($status == 7){
				$statusrep = 'เก็บเงินปลายทาง';
			}
				
		$sheet = $doc->setActiveSheetIndex(0);
		$row = 6;
		$sheet->setCellValue('A2','วันที่ '.date('d/m/Y H:i:s',strtotime($date['start'])).' ถึงวันที่ '.date('d/m/Y H:i:s',strtotime($date['end'])).' เวลาที่พิมพ์ '.date('d/m/Y H:i:s'));
		$sheet->setCellValue('A3','สถานะจ่ายเงิน : '.$statusrep.'');
		
		$i 		= 1; 
		$total 	= 0; 
		
		
		foreach($statement as $rs){
			$inv 		= '';
			$invref 	= '';
			$ref 		= '';
			$stat 		= '';
			$datetime 	= '';
			$statuscre 	= '';
			$amount 	= 0;
			
			if($rs->export_status != 4){
				$total 		+= $rs->payment_amount;
				$amount 	= $rs->payment_amount;
			}else{
				$total		+= $rs->export_totalpayment;
				$amount		= $rs->export_totalpayment;
			}

			if(!empty($rs->tran_statuscredit)){
				$statuscre = $rs->tran_statuscredit;
			}
			if($rs->export_inv != null){
				$inv = $rs->export_inv;
			}
			if($rs->export_inv != null){
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
			
			$sheet->setCellValue('A'.$row.'',$i);
			$sheet->setCellValue('B'.$row.'',$rs->export_date);
			$sheet->setCellValue('C'.$row.'',$inv);
			$sheet->setCellValue('D'.$row.'',$ref);
			$sheet->setCellValue('E'.$row.'',$rs->customer_name);
			$sheet->setCellValue('F'.$row.'',$datetime);
			$sheet->setCellValue('G'.$row.'',$stat);
			$sheet->setCellValue('H'.$row.'',$invref);
			$sheet->setCellValue('I'.$row.'',$statuscre);
			$sheet->setCellValue('J'.$row.'',number_format($amount,2));
			
			$i++;
			$row++;
		}
		
		$sheet->setCellValue('E'.$row.'','รวม');
		$sheet->setCellValue('J'.$row.'',number_format($total,2));
		
			
		})->download('xlsx');
	}
	
	public function stock(){
		$product = DB::table('product')->get();
		return view('report/stock',['product' => $product]);
	}
	
	public function reportdatastock(Request $request){
		$start 			= $request->input('start');
		$enddate 		= $request->input('end');
		$product		= $request->input('product');
		$qty			= DB::table('product')->where('product_id',$product)->first();
		
		$oldimp 		= DB::table('sub_import')->where('sub_product')->whereBetween('sub_import.created_at',['2019-01-01',$start])->sum('sub_qty');
		$oldorderex 	= DB::table('orders')->whereNotIn('order_status',[5])->where('created_at')->whereBetween('created_at',['2019-01-01',$start])->sum('order_qty');
		$oldorderim 	= DB::table('orders')->where('order_status',5)->where('created_at')->whereBetween('created_at',['2019-01-01',$start])->sum('order_qty');
		$productpast	= ($oldimp+$oldorderim) - $oldorderex;
		
		$query = DB::table('sub_import')
		->select('sub_import.sub_ref','sub_import.sub_product','sub_import.sub_qty','sub_import.created_at','product.product_id','product.product_code','product.product_name')
		->join('product','product.product_id','=','sub_import.sub_product')
		->whereBetween('sub_import.created_at',[$start,$enddate])
		->where('sub_import.sub_product',$product)
		->get();
		
		$dataimp = [];
		if($query){
			foreach($query as $rs){
				$dataimp[] = [
					'datetime'		=> $rs->created_at,
					'productcode'	=> $rs->product_code,
					'productname'	=> $rs->product_name,
					'qty'			=> $rs->sub_qty,
					'status'		=> 1,
				];
			}
		}
		
		$exp = DB::table('orders')
		->select('orders.order_productid','orders.order_qty','orders.order_status','orders.created_at','product.product_id','product.product_code','product.product_name')
		->join('product','product.product_id','=','orders.order_productid')
		->whereBetween('orders.created_at',[$start,$enddate])
		->where('orders.order_productid',$product)
		->get();
		
		$dataexp = [];
		if($exp){
			foreach($exp as $ar){
				$stat = 2;
				if($ar->order_status == 5){
					$stat = 1;
				}
				$dataexp[] = [
					'datetime'		=> $ar->created_at,
					'productcode'	=> $ar->product_code,
					'productname'	=> $ar->product_name,
					'qty'			=> $ar->order_qty,
					'status'		=> $stat,
				];
			}
		}
		
		$result = array_merge($dataimp,$dataexp);
		foreach($result as $key => $row){
			$datarsort[$key] = $row['datetime'];
		}
		array_multisort($datarsort, SORT_ASC, $result);		
		return Response::json(['productpast' => $productpast,'result' => $result,'qtycurr' => $qty->product_qty]);
	}
	
	public function stockpdf(Request $request){
		$start 			= $request->input('datestart');
		$enddate 		= $request->input('dateend');
		$product		= $request->input('product');
		$qty			= DB::table('product')->where('product_id',$product)->first();
		
		$oldimp 		= DB::table('sub_import')->where('sub_product')->whereBetween('sub_import.created_at',['2019-01-01',$start])->sum('sub_qty');
		$oldorderex 	= DB::table('orders')->whereNotIn('order_status',[5])->where('created_at')->whereBetween('created_at',['2019-01-01',$start])->sum('order_qty');
		$oldorderim 	= DB::table('orders')->where('order_status',5)->where('created_at')->whereBetween('created_at',['2019-01-01',$start])->sum('order_qty');
		$productpast	= ($oldimp+$oldorderim) - $oldorderex;
		
		$query = DB::table('sub_import')
		->select('sub_import.sub_ref','sub_import.sub_product','sub_import.sub_qty','sub_import.created_at','product.product_id','product.product_code','product.product_name')
		->join('product','product.product_id','=','sub_import.sub_product')
		->whereBetween('sub_import.created_at',[$start,$enddate])
		->where('sub_import.sub_product',$product)
		->get();
		
		$dataimp = [];
		if($query){
			foreach($query as $rs){
				$dataimp[] = [
					'datetime'		=> $rs->created_at,
					'productcode'	=> $rs->product_code,
					'productname'	=> $rs->product_name,
					'qty'			=> $rs->sub_qty,
					'status'		=> 1,
				];
			}
		}
		
		$exp = DB::table('orders')
		->select('orders.order_productid','orders.order_qty','orders.order_status','orders.created_at','product.product_id','product.product_code','product.product_name')
		->join('product','product.product_id','=','orders.order_productid')
		->whereBetween('orders.created_at',[$start,$enddate])
		->where('orders.order_productid',$product)
		->get();
		
		$dataexp = [];
		if($exp){
			foreach($exp as $ar){
				$stat = 2;
				if($ar->order_status == 5){
					$stat = 1;
				}
				$dataexp[] = [
					'datetime'		=> $ar->created_at,
					'productcode'	=> $ar->product_code,
					'productname'	=> $ar->product_name,
					'qty'			=> $ar->order_qty,
					'status'		=> $stat,
				];
			}
		}
		
		$result = array_merge($dataimp,$dataexp);
		foreach($result as $key => $row){
			$datarsort[$key] = $row['datetime'];
		}
		array_multisort($datarsort, SORT_ASC, $result);		
		
		$date = [
			'start'		=> $request->input('datestart'),
			'end'		=> $request->input('dateend'),
		];
		
		$pdf = PDF::loadView('report.reportstock',['productpast' => $productpast,'result' => $result,'qtycurr' => $qty->product_qty,'date' => $date],[],['title' => 'รายงานสต๊อก','format'=>'A4']);
	    return $pdf->stream();
	}
	
	public function returns(){
		return view('report/return');
	}
	
	public function reportdatareturn(Request $request){
		$start 			= $request->input('start');
		$enddate 		= $request->input('end');
		
		$export 		= DB::table('export')->where('export_status',5)->whereBetween('created_at',[$start,$enddate])->get();
		$data = [];
		if($export){
			foreach($export as $rs){
				$orders = DB::table('orders')->join('product','product.product_id','=','orders.order_productid')->where('orders.order_ref',$rs->export_id)->get();
				if($orders){
					foreach($orders as $ar){
						$data[] = [
							'inv'		=> $rs->export_inv,
							'date'		=> date('d/m/Y',strtotime($rs->export_date)),
							'code'		=> $ar->product_code,
							'product'	=> $ar->product_name,
							'qty'		=> $ar->order_qty,
							'price'		=> $ar->order_price,
							'total'		=> $ar->order_total,
						];
					}
				}
			}
		}
		return Response::json($data);
	}
	
	public function returnpdf(Request $request){
		$start 			= $request->input('datestart');
		$enddate 		= $request->input('dateend');
		
		$export 		= DB::table('export')->where('export_status',5)->whereBetween('created_at',[$start,$enddate])->get();
		$data = [];
		if($export){
			foreach($export as $rs){
				$orders = DB::table('orders')->join('product','product.product_id','=','orders.order_productid')->where('orders.order_ref',$rs->export_id)->get();
				if($orders){
					foreach($orders as $ar){
						$data[] = [
							'inv'		=> $rs->export_inv,
							'date'		=> date('d/m/Y',strtotime($rs->export_date)),
							'code'		=> $ar->product_code,
							'product'	=> $ar->product_name,
							'qty'		=> $ar->order_qty,
							'price'		=> $ar->order_price,
							'total'		=> $ar->order_total,
						];
					}
				}
			}
		}
		
		$date = [
			'start'		=> $request->input('datestart'),
			'end'		=> $request->input('dateend'),
		];
		
		$pdf = PDF::loadView('report.reportreturn',['data' => $data,'date' => $date],[],['title' => 'รายงานคืนสินค้า','format'=>'A4']);
	    return $pdf->stream();
	}
	
	public function returnexcel($start,$end){
		$start 			= $start;
		$enddate 		= $end;
		
		$export 		= DB::table('export')->where('export_status',5)->whereBetween('created_at',[$start,$enddate])->get();
		$data = [];
		if($export){
			foreach($export as $rs){
				$orders = DB::table('orders')->join('product','product.product_id','=','orders.order_productid')->where('orders.order_ref',$rs->export_id)->get();
				if($orders){
					foreach($orders as $ar){
						$data[] = [
							'inv'		=> $rs->export_inv,
							'date'		=> date('d/m/Y',strtotime($rs->export_date)),
							'code'		=> $ar->product_code,
							'product'	=> $ar->product_name,
							'qty'		=> $ar->order_qty,
							'price'		=> $ar->order_price,
							'total'		=> $ar->order_total,
						];
					}
				}
			}
		}
		
		$date = [
			'start'		=> $start,
			'end'		=> $end,
		];
		
		
		$file = storage_path('template/return.xlsx');
		
		Excel::load($file, function($doc) use($data,$date) {
		$sheet = $doc->setActiveSheetIndex(0);
		$row = 5;
		$sheet->setCellValue('A2','วันที่ '.date('d/m/Y H:i:s',strtotime($date['start'])).' ถึงวันที่ '.date('d/m/Y H:i:s',strtotime($date['end'])).' เวลาที่พิมพ์ '.date('d/m/Y H:i:s'));
		
	
		$i 		= 1; 
		$total 	= 0; 
		if(count($data) > 0){
			
			foreach($data as $rs){
				$total += $rs['total'];
				$sheet->setCellValue('A'.$row.'',$i);
				$sheet->setCellValue('B'.$row.'',$rs['inv']);
				$sheet->setCellValue('C'.$row.'',$rs['date']);
				$sheet->setCellValue('D'.$row.'',$rs['code']);
				$sheet->setCellValue('E'.$row.'',$rs['product']);
				$sheet->setCellValue('F'.$row.'',number_format($rs['qty']));
				$sheet->setCellValue('G'.$row.'',number_format($rs['price'],2));
				$sheet->setCellValue('H'.$row.'',number_format($rs['total'],2));
				
				$i++;
				$row++;
			}
			
			
			$sheet->setCellValue('E'.$row.'','รวม');
			$sheet->setCellValue('H'.$row.'',number_format($total,2));
		}
			
		})->download('xlsx');
	}
	
	
	public function withdraw(){
		return view('report/withdraw');
	}
	
	public function reportdatawithdraw(Request $request){
		$start 			= $request->input('start');
		$enddate 		= $request->input('end');
		
		$export 		= DB::table('export')->where('export_status',6)->whereBetween('created_at',[$start,$enddate])->get();
		$data = [];
		if($export){
			foreach($export as $rs){
				$orders = DB::table('orders')->join('product','product.product_id','=','orders.order_productid')->where('orders.order_ref',$rs->export_id)->get();
				if($orders){
					foreach($orders as $ar){
						$data[] = [
							'inv'		=> $rs->export_inv,
							'date'		=> date('d/m/Y',strtotime($rs->export_date)),
							'code'		=> $ar->product_code,
							'product'	=> $ar->product_name,
							'qty'		=> $ar->order_qty,
							'price'		=> $ar->order_price,
							'total'		=> $ar->order_total,
						];
					}
				}
			}
		}
		return Response::json($data);
	}
	
	public function withdrawpdf(Request $request){
		$start 			= $request->input('datestart');
		$enddate 		= $request->input('dateend');
		
		$export 		= DB::table('export')->where('export_status',6)->whereBetween('created_at',[$start,$enddate])->get();
		$data = [];
		if($export){
			foreach($export as $rs){
				$orders = DB::table('orders')->join('product','product.product_id','=','orders.order_productid')->where('orders.order_ref',$rs->export_id)->get();
				if($orders){
					foreach($orders as $ar){
						$data[] = [
							'inv'		=> $rs->export_inv,
							'date'		=> date('d/m/Y',strtotime($rs->export_date)),
							'code'		=> $ar->product_code,
							'product'	=> $ar->product_name,
							'qty'		=> $ar->order_qty,
							'price'		=> $ar->order_price,
							'total'		=> $ar->order_total,
						];
					}
				}
			}
		}
		
		$date = [
			'start'		=> $request->input('datestart'),
			'end'		=> $request->input('dateend'),
		];
		
		$pdf = PDF::loadView('report.reportwithdraw',['data' => $data,'date' => $date],[],['title' => 'รายงานคืนสินค้า','format'=>'A4']);
	    return $pdf->stream();
	}
	
	public function withdrawexcel($start,$end){
		$start 			= $start;
		$enddate 		= $end;
		
		$export 		= DB::table('export')->where('export_status',6)->whereBetween('created_at',[$start,$enddate])->get();
		$data = [];
		if($export){
			foreach($export as $rs){
				$orders = DB::table('orders')->join('product','product.product_id','=','orders.order_productid')->where('orders.order_ref',$rs->export_id)->get();
				if($orders){
					foreach($orders as $ar){
						$data[] = [
							'inv'		=> $rs->export_inv,
							'date'		=> date('d/m/Y',strtotime($rs->export_date)),
							'code'		=> $ar->product_code,
							'product'	=> $ar->product_name,
							'qty'		=> $ar->order_qty,
							'price'		=> $ar->order_price,
							'total'		=> $ar->order_total,
						];
					}
				}
			}
		}
		
		$date = [
			'start'		=> $start,
			'end'		=> $end,
		];
		
		
		$file = storage_path('template/withdraw.xlsx');
		
		Excel::load($file, function($doc) use($data,$date) {
		$sheet = $doc->setActiveSheetIndex(0);
		$row = 5;
		$sheet->setCellValue('A2','วันที่ '.date('d/m/Y H:i:s',strtotime($date['start'])).' ถึงวันที่ '.date('d/m/Y H:i:s',strtotime($date['end'])).' เวลาที่พิมพ์ '.date('d/m/Y H:i:s'));
		
	
		$i 		= 1; 
		$total 	= 0; 
		if(count($data) > 0){
			
			foreach($data as $rs){
				$total += $rs['total'];
				$sheet->setCellValue('A'.$row.'',$i);
				$sheet->setCellValue('B'.$row.'',$rs['inv']);
				$sheet->setCellValue('C'.$row.'',$rs['date']);
				$sheet->setCellValue('D'.$row.'',$rs['code']);
				$sheet->setCellValue('E'.$row.'',$rs['product']);
				$sheet->setCellValue('F'.$row.'',number_format($rs['qty']));
				$sheet->setCellValue('G'.$row.'',number_format($rs['price'],2));
				$sheet->setCellValue('H'.$row.'',number_format($rs['total'],2));
				
				$i++;
				$row++;
			}
			
			
			$sheet->setCellValue('E'.$row.'','รวม');
			$sheet->setCellValue('H'.$row.'',number_format($total,2));
		}
			
		})->download('xlsx');
	}
}
