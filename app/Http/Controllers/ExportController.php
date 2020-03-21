<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use File;
use Folklore\Image\Facades\Image;
use PDF;
use Excel;
use Auth;

class ExportController extends Controller
{
    public function index(){
		$inv 	= DB::table('export')->orderBy('export_id','desc')->first();
		return view('export/index');
	}
	
	public function datatable(){
		$export = DB::table('export')->WhereIn('export_status',[0,1,2,4]);
		
		$sQuery	= Datatables::of($export)
		->editColumn('export_inv',function($data){
			return substr($data->export_inv,5,15);
		})
		->editColumn('export_totalpayment',function($data){
			return empty($data->export_totalpayment)?'-':number_format($data->export_totalpayment,2);
		})
		->editColumn('updated_at',function($data){
			return date('d/m/Y',strtotime($data->updated_at));
		})
		->editColumn('export_date',function($data){
			return date('d/m/Y',strtotime($data->export_date));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function create(){
		$inv 		= 'LAV';
		$invoice	= DB::table('export')->where('export_inv','like',$inv."%")->orderBy('export_id','desc')->first();
		return view('export/create',['invoice' => $invoice]);
	}
	
	public function creategift($id){
		$inv 		= 'LAV';
		$customer = DB::table('customer')->where('customer_id',$id)->first();
		$invoice	= DB::table('export')->where('export_inv','like',$inv."%")->orderBy('export_id','desc')->first();
		return view('export/create',['invoice' => $invoice,'customer' => $customer]);
	}
	
	public function store(Request $request){
		if($request->input('customerid') == 0){
			$customer = [
				'customer_img'			=> '',
				'customer_code'			=> '',
				'customer_name'			=> $request->input('customername'),
				'customer_detail'		=> !empty($request->input('customeraddr'))?$request->input('customeraddr'):'',
				'customer_detailhome'	=> '',
				'customer_detaildoc'	=> !empty($request->input('customeraddrdoc'))?$request->input('customeraddrdoc'):'',
				'customer_tel'			=> !empty($request->input('customercontel'))?$request->input('customercontel'):'',
				'customer_email'		=> '',
				'customer_birth'		=> '',
				'customer_point'		=> 0,
				'customer_note'			=> !empty($request->input('note'))?$request->input('note'):'',
				'created_at'			=> new DateTime(),
				'updated_at'			=> new DateTime(),
			];
			DB::table('customer')->insert($customer);
			$lastcus 	= DB::table('customer')->orderBy('customer_id','desc')->first();
			$customerid = $lastcus->customer_id; 
			
			$logs = [
				'logs_method' 	=> 'Insert',
				'logs_list' 	=> '',
				'logs_detail' 	=> $request->input('customername').' '.$request->input('customeraddr').' '.$request->input('customeraddrdoc').' '.$request->input('customercontel').' '.$request->input('note'),
				'created_at'	=> new DateTime(),
				'updated_at'	=> new DateTime(),
			];
			
			DB::table('logs')->insert($logs);
		
		}else{
			$customerid = $request->input('customerid');
		} 
		
		if(!empty($request->input('dateofbirth'))){
			DB::table('customer')->where('customer_id',$request->input('dateofbirth'))->update(['customer_status_dob' => date('Y-m-d'),'updated_at'	=> new DateTime()]);
		}
		
		$date 	= explode('/',$request->input('docdate'));
		$dateorder = 'IV'.substr($date[2],2).$date[1];
		$res	= DB::table('export')->where('export_order','like',$dateorder.'%')->orderBy('export_id','desc')->first();
		$inv 	= DB::table('export')->orderBy('export_id','desc')->first();
		
	

		$stat 	= 0;
		if($request->input('cashallpayment') == $request->input('sumpayment')){
			$stat = 1;
		}

		if($request->input('castofdel') == 'on'){
			$stat = 4;
		} 
		// dd($stat,$request->input('cashallpayment'),$request->input('sumpayment'));
		if($res){
			$str 	= substr($res->export_order,6);
			$sum	= $str+1;
			$order 	= substr($res->export_order,0,6).sprintf('%04d',$sum);
		}else{
			$order 	= 'IV'.date('ym').sprintf('%04d',1);
		}
		
		if($inv){
			$invstr		= substr($inv->export_inv,8);
			$strinvf 	= $invstr+1;
			$invf 		= 'THCSXLAV'.sprintf('%07d',$strinvf);
		}else{
			$invf 		= 'THCSXLAV0000001';
		}


		$data = [
			'export_order'			=> $order,
			'export_inv'			=> $invf,
			'export_date'			=> $date[2].'-'.$date[1].'-'.$date[0],
			'export_empid'			=> $request->input('empsaleid'),
			'export_empname'		=> $request->input('empsalename'),
			'export_customerid'		=> $customerid,
			'export_customername'	=> $request->input('customername'),
			'export_customertax'	=> !empty($request->input('customertax'))?$request->input('customertax'):'',
			'export_customeraddr'	=> !empty($request->input('customeraddr'))?$request->input('customeraddr'):'',
			'export_customeraddrdel'=> !empty($request->input('customeraddrdoc'))?$request->input('customeraddrdoc'):'',
			'export_distric'		=> !empty($request->input('distric'))?$request->input('distric'):'',
			'export_province'		=> !empty($request->input('province'))?$request->input('province'):'',
			'export_customerzipcode'=> !empty($request->input('customerzipcode'))?$request->input('customerzipcode'):'',
			'export_customertel'	=> !empty($request->input('customercontel'))?$request->input('customercontel'):'',
			'export_customernote'	=> !empty($request->input('note'))?$request->input('note'):'',
			'export_total'			=> $request->input('sumtotal'),
			'export_discount'		=> $request->input('discount'),
			'export_discountsum'	=> $request->input('sumdiscount'),
			'export_vat'			=> $request->input('vat'),
			'export_vatsum'			=> $request->input('sumvat'),
			'export_lastbill'		=> !empty($request->input('discountlastbill'))?$request->input('discountlastbill'):0,
			'export_totalpayment'	=> $request->input('sumpayment'),
			'export_status'			=> $stat,
			'export_channel'		=> $request->input('channel'),
			'export_delstatus'		=> $request->input('delstatus'),
			'export_comment'		=> $request->input('comment'),
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		DB::table('export')->insert($data);
		$lastid = DB::table('export')->latest()->first();	
		
		$logexp = [
			'logs_method' 	=> 'Insert',
			'logs_list' 	=> '',
			'logs_detail' 	=> $invf.' '.$order.' '.$date[2].'-'.$date[1].'-'.$date[0].' '.$request->input('empsalename').' '.$request->input('customername').' '.$request->input('sumpayment'),
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		
		DB::table('logs')->insert($logexp);
		
		$sumqty = 0;
		if($request->input('productid')){
			foreach($request->input('productid') as $key => $row){
				$sumqty += $request->input('productqty')[$key];
				$product = DB::table('product')->where('product_id',$request->input('productid')[$key])->first();

				$unitsum = $product->product_qty - $request->input('productqty')[$key];
				$datapro = ['product_qty' => $unitsum,'updated_at' => new DateTime()];
				//Update stock
				DB::table('product')->where('product_id',$product->product_id)->update($datapro);
				
				$detail = array(
					'order_ref'				=>$lastid->export_id,
					'order_productid'		=>$request->input('productid')[$key],
					'order_price'			=>!empty($request->input('productprice')[$key])?$request->input('productprice')[$key]:0,
					'order_qty'				=>$request->input('productqty')[$key],
					'order_total'			=>$request->input('totalpro')[$key],
					'order_status'			=>1,
					'created_at'			=>new DateTime(),
					'updated_at'			=>new DateTime()
				);
				
				DB::table('orders')->insert($detail);
			}
		}

		if($request->input('amountcash')){
			foreach($request->input('amountcash') as $kk => $vv){
				if(!empty($request->input('amountcash')[$kk])){
					$datacash = [
						'payment_ref'			=> $lastid->export_id,
						'payment_type'			=> 1,
						'payment_amount'		=> str_replace(',', '', $request->input('amountcash')[$kk]),
						'payment_status'		=> '',
						'payment_datebank'		=> '',
						'payment_datetimebank'	=> '',
						'created_at'			=> new DateTime(),
						'updated_at'			=> new DateTime(),
					];
					DB::table('payment')->insert($datacash);
				}
			}
		}
		
		if($request->input('amountcredit')){
			foreach($request->input('amountcredit') as $a => $b){
				if(!empty($request->input('amountcredit')[$a])){
					$datacredit = [
						'payment_ref'			=> $lastid->export_id,
						'payment_type'			=> 2,
						'payment_refcredit'		=> $request->input('refcredit')[$a],
						'payment_amount'		=> str_replace(',', '', $request->input('amountcredit')[$a]),
						'payment_status'		=> $request->input('typecredit')[$a],
						'payment_datebank'		=> '',
						'payment_datetimebank'	=> '',
						'created_at'			=> new DateTime(),
						'updated_at'			=> new DateTime(),
					];
					DB::table('payment')->insert($datacredit);
					
					$counttran = DB::table('transaction')->where('tran_ordernumber',$request->input('refcredit')[$a])->where('tran_status',2)->count();
					if($counttran != 0){
						DB::table('export')->where('export_id',$lastid->export_id)->update(['export_status' => 1,'updated_at' => new DateTime()]);
						DB::table('transaction')->where('tran_ordernumber',$request->input('refcredit')[$a])->update(['tran_status' => 0,'updated_at' => new DateTime()]);
					}
				}
			}
		}
		
				
		if($request->input('amountbank')){
			foreach($request->input('amountbank') as $c => $d){
				if(!empty($request->input('amountbank')[$c])){
					$date = explode('/',$request->input('bankdate')[$c]);
					$databank = [
						'payment_ref'			=> $lastid->export_id,
						'payment_type'			=> 3,
						'payment_amount'		=> str_replace(',', '', $request->input('amountbank')[$c]),
						'payment_status'		=> $request->input('bank')[$c],
						'payment_datebank'		=> $date[2].'-'.$date[1].'-'.$date[0],
						'payment_datetimebank'	=> $request->input('banktime')[$c],
						'created_at'			=> new DateTime(),
						'updated_at'			=> new DateTime(),
					];
					DB::table('payment')->insert($databank);
				}
			}
		}
		
		$respoint = DB::table('customer')->where('customer_id',$customerid)->first();
		if($respoint){
			$sumpoint = $respoint->customer_point + $sumqty;
			DB::table('customer')->where('customer_id',$customerid)->update(['customer_point' => $sumpoint,'updated_at' => new DateTime()]);
		}
		
		Session::flash('alert-insert','insert');
		return redirect('export');
	}
	
	public function edit($id){
		$bank		 = DB::table('bank')->get();
		$export 	= DB::table('export')->where('export_id',$id)->first();
		$orders 	= DB::table('orders')->where('order_ref',$id)->join('product','product.product_id','=','orders.order_productid')->get();
		$payment 	= DB::table('payment')->where('payment_ref',$id)->get(); 
		$ccash		= DB::table('payment')->where('payment_ref',$id)->where('payment_type',1)->count();
		$ccredit	= DB::table('payment')->where('payment_ref',$id)->where('payment_type',2)->count();
		$cbank		= DB::table('payment')->where('payment_ref',$id)->where('payment_type',3)->count();
		return view('export/update',['export' => $export,'orders' => $orders,'payment' => $payment,'ccash' => $ccash,'ccredit' => $ccredit,'cbank' => $cbank,'banks' => $bank]);
	}
	
	public function update(Request $request){
		$customerid = $request->input('customerid');
		$res 		= DB::table('orders')->where('order_ref',$request->input('exportid'))->get();
		$sum_qty	= 0;
		if($res){
			foreach($res as $xx){
				$sum_qty		+= $xx->order_qty;
				$productres 	= DB::table('product')->where('product_id',$xx->order_productid)->first();
				if($productres){
					$unitsumres		= $productres->product_qty + $xx->order_qty;
					$dataprores 	= ['product_qty' => $unitsumres,'updated_at' => new DateTime()];
					//Update stock
					DB::table('product')->where('product_id',$productres->product_id)->update($dataprores);
				}
			}
		}
		
		$res_point = DB::table('customer')->where('customer_id',$customerid)->first();
		if($res_point){
			$sum_point = $res_point->customer_point - $sum_qty;
			DB::table('customer')->where('customer_id',$customerid)->update(['customer_point' => $sum_point,'updated_at' => new DateTime()]);
		}
		
		DB::table('orders')->where('order_ref',$request->input('exportid'))->delete();
		DB::table('payment')->where('payment_ref',$request->input('exportid'))->delete();
		$date 		= explode('/',$request->input('docdate'));
		
		$stat 	= 0;
		if($request->input('cashallpayment') == number_format($request->input('sumpayment'),2,'.','')){
			$stat = 1;
		}
		if($request->input('castofdel') == 'on'){
			$stat = 4;
		} 
		// dd($request->input('cashallpayment') ."==". number_format($request->input('sumpayment'),2,'.',''));
		$data = [
			'export_date'			=> $date[2].'-'.$date[1].'-'.$date[0],
			'export_empid'			=> $request->input('empsaleid'),
			'export_empname'		=> $request->input('empsalename'),
			'export_customerid'		=> $customerid,
			'export_customername'	=> $request->input('customername'),
			'export_customertax'	=> !empty($request->input('customertax'))?$request->input('customertax'):'',
			'export_customeraddr'	=> !empty($request->input('customeraddr'))?$request->input('customeraddr'):'',
			'export_distric'		=> !empty($request->input('distric'))?$request->input('distric'):'',
			'export_province'		=> !empty($request->input('province'))?$request->input('province'):'',
			'export_customerzipcode'	=> !empty($request->input('customerzipcode'))?$request->input('customerzipcode'):'',
			'export_customertel'	=> !empty($request->input('customercontel'))?$request->input('customercontel'):'',
			'export_customernote'	=> !empty($request->input('note'))?$request->input('note'):'',
			'export_total'			=> $request->input('sumtotal'),
			'export_discount'		=> $request->input('discount'),
			'export_discountsum'	=> $request->input('sumdiscount'),
			'export_vat'			=> $request->input('vat'),
			'export_vatsum'			=> $request->input('sumvat'),
			'export_lastbill'		=> !empty($request->input('discountlastbill'))?$request->input('discountlastbill'):0,
			'export_status'			=> $stat,
			'export_totalpayment'	=> $request->input('sumpayment'),
			'export_delstatus'		=> $request->input('delstatus'),
			'export_comment'		=> $request->input('comment'),
			'updated_at'			=> new DateTime(),
		];
		DB::table('export')->where('export_id',$request->input('exportid'))->update($data);
		
		
		$sumqty = 0;
		if($request->input('productid')){
			foreach($request->input('productid') as $key => $row){
				$sumqty 	+= $request->input('productqty')[$key];
				$product 	= DB::table('product')->where('product_id',$request->input('productid')[$key])->first();

				$unitsum	= $product->product_qty - $request->input('productqty')[$key];
				$datapro 	= ['product_qty' => $unitsum,'updated_at' => new DateTime()];
				//Update stock
				DB::table('product')->where('product_id',$product->product_id)->update($datapro);
				
				$detail = array(
					'order_ref'				=>$request->input('exportid'),
					'order_productid'		=>$request->input('productid')[$key],
					'order_price'			=>$request->input('productprice')[$key],
					'order_qty'				=>$request->input('productqty')[$key],
					'order_total'			=>$request->input('totalpro')[$key],
					'order_status'			=>1,
					'created_at'			=>new DateTime(),
					'updated_at'			=>new DateTime()
				);
				
				DB::table('orders')->insert($detail);
			}
		}
		
		if($request->input('amountcash')){
			foreach($request->input('amountcash') as $kk => $vv){
				if(!empty($request->input('amountcash')[$kk])){
					$datacash = [
						'payment_ref'			=> $request->input('exportid'),
						'payment_type'			=> 1,
						'payment_amount'		=> str_replace(',', '', $request->input('amountcash')[$kk]),
						'payment_status'		=> '',
						'payment_datebank'		=> '',
						'payment_datetimebank'	=> '',
						'created_at'			=> new DateTime(),
						'updated_at'			=> new DateTime(),
					];
					DB::table('payment')->insert($datacash);
				}
			}
		}
		
		if($request->input('amountcredit')){
			foreach($request->input('amountcredit') as $a => $b){
				if(!empty($request->input('amountcredit')[$a])){
					$datacredit = [
						'payment_ref'			=> $request->input('exportid'),
						'payment_type'			=> 2,
						'payment_refcredit'		=> $request->input('refcredit')[$a],
						'payment_amount'		=> str_replace(',', '', $request->input('amountcredit')[$a]),
						'payment_status'		=> $request->input('typecredit')[$a],
						'payment_datebank'		=> '',
						'payment_datetimebank'	=> '',
						'created_at'			=> new DateTime(),
						'updated_at'			=> new DateTime(),
					];
					DB::table('payment')->insert($datacredit);
					
					$counttran = DB::table('transaction')->where('tran_ordernumber',$request->input('refcredit')[$a])->where('tran_status',2)->count();
					if($counttran != 0){
						DB::table('export')->where('export_id',$request->input('exportid'))->update(['export_status' => 1,'updated_at' => new DateTime()]);
						DB::table('transaction')->where('tran_ordernumber',$request->input('refcredit')[$a])->update(['tran_status' => 0,'updated_at' => new DateTime()]);
					}
				}
			}
		}
		
				
		if($request->input('amountbank')){
			foreach($request->input('amountbank') as $c => $d){
				if(!empty($request->input('amountbank')[$c])){
					$date = explode('/',$request->input('bankdate')[$c]);
					$databank = [
						'payment_ref'			=> $request->input('exportid'),
						'payment_type'			=> 3,
						'payment_amount'		=> str_replace(',', '', $request->input('amountbank')[$c]),
						'payment_status'		=> $request->input('bank')[$c],
						'payment_datebank'		=> $date[2].'-'.$date[1].'-'.$date[0],
						'payment_datetimebank'	=> $request->input('banktime')[$c],
						'created_at'			=> new DateTime(),
						'updated_at'			=> new DateTime(),
					];
					DB::table('payment')->insert($databank);
				}
			}
		}
		
		$respoint = DB::table('customer')->where('customer_id',$customerid)->first();
		if($respoint){
			$sumpoint = $respoint->customer_point + $sumqty;
			DB::table('customer')->where('customer_id',$customerid)->update(['customer_point' => $sumpoint,'updated_at' => new DateTime()]);
		}
		
		Session::flash('alert-update','update');
		return redirect('export');
	}
	
	public function approve($id){
		$res = DB::table('export')->where('export_id',$id)->first();
		$logs = [
			'logs_method' 	=> 'Update',
			'logs_list' 	=> $res->export_inv.' '.Auth::user()->name.' '.$res->export_customername.' '.$res->export_totalpayment.'  ค้างจ่าย',
			'logs_detail' 	=> 'จ่ายแล้ว',
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		DB::table('logs')->insert($logs);
		
		DB::table('export')->where('export_id',$id)->update(['export_status' => 2,'updated_at' => new DateTime()]);
		Session::flash('alert-update','update');
		return redirect('export');
	}
	
	public function invoice($id){
		$exp 		= DB::table('export')->where('export_id',$id)->first();
		$data = [];
		if($exp){
			$subexp = DB::table('orders')->join('product','product.product_id','=','orders.order_productid')->where('order_ref',$id)->get();
			if($subexp){
				foreach($subexp as $ar){
					
					$product 	= DB::table('product')->where('product_id',$ar->order_productid)->first();
					
					$data[] = [
						'inv'		=> $exp->export_inv,
						'date'		=> date('d/m/Y',strtotime($exp->export_date)),
						'code'		=> $ar->product_code,
						'name'		=> $ar->product_name,
						'unit'		=> $ar->product_unit,
						'price'		=> number_format($ar->order_price,2),
						'qty'		=> number_format($ar->order_qty),
						'total'		=> number_format($ar->order_total,2),
						'totalint'	=> $ar->order_total,
					];
				}
			}
			
			
		}
		
		function num2wordsThai($num){   
			$num=str_replace(",","",$num);
			$num_decimal=explode(".",$num);
			$num=$num_decimal[0];
			$returnNumWord = '';   
			$lenNumber=strlen($num);   
			$lenNumber2=$lenNumber-1;   
			$kaGroup=array("","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน");   
			$kaDigit=array("","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ต","แปด","เก้า");   
			$kaDigitDecimal=array("ศูนย์","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ต","แปด","เก้า");   
			$ii=0;   
			for($i=$lenNumber2;$i>=0;$i--){   
				$kaNumWord[$i]=substr($num,$ii,1);   
				$ii++;   
			}   
			$ii=0;   
			for($i=$lenNumber2;$i>=0;$i--){   
				if(($kaNumWord[$i]==2 && $i==1) || ($kaNumWord[$i]==2 && $i==7)){   
					$kaDigit[$kaNumWord[$i]]="ยี่";   
				}else{   
					if($kaNumWord[$i]==2){   
						$kaDigit[$kaNumWord[$i]]="สอง";        
					}   
					if(($kaNumWord[$i]==1 && $i<=2 && $i==0) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==6)){   
						if($kaNumWord[$i+1]==0){   
							$kaDigit[$kaNumWord[$i]]="หนึ่ง";      
						}else{   
							$kaDigit[$kaNumWord[$i]]="เอ็ด";       
						}   
					}elseif(($kaNumWord[$i]==1 && $i<=2 && $i==1) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==7)){   
						$kaDigit[$kaNumWord[$i]]="";   
					}else{   
						if($kaNumWord[$i]==1){   
							$kaDigit[$kaNumWord[$i]]="หนึ่ง";   
						}   
					}   
				}   
				if($kaNumWord[$i]==0){   
					if($i!=6){
						$kaGroup[$i]="";   
					}
				}   
				$kaNumWord[$i]=substr($num,$ii,1);   
				$ii++;   
				$returnNumWord.=$kaDigit[$kaNumWord[$i]].$kaGroup[$i];   
			}      
			if(isset($num_decimal[1])){
				$returnNumWord.="จุด";
				for($i=0;$i<strlen($num_decimal[1]);$i++){
						$returnNumWord.=$kaDigitDecimal[substr($num_decimal[1],$i,1)];  
				}
			}       
			return $returnNumWord;   
		}
				
		$total = [
			'total'			=> $exp->export_total,
			'totalpayment'	=> $exp->export_totalpayment,
			'totalfont'		=> num2wordsThai($exp->export_totalpayment)
		];
		
		$pdf = PDF::loadView('export.invoice',['exp' => $exp,'data' => $data,'total' => $total],[],['title' => 'สลิป','format'=>'A4']);
	    return $pdf->stream();
	}
	
	public function cover($id){
		$exp 		= DB::table('export')->where('export_id',$id)->Leftjoin('customer','customer.customer_id','=','export.export_customerid')->first();
		$pdf = PDF::loadView('export.cover',['exp' => $exp],[],['title' => 'สลิป','format'=>'A4-L']);
	    return $pdf->stream();
	}
	
	
	public function destroy($id){		
		DB::table('export')->where('export_id',$id)->delete();
		DB::table('orders')->where('order_ref',$id)->delete();
		
		Session::flash('alert-delete','delete');
		return redirect('export');
	}
	
	public function querypromotion(Request $request){
		$promotion = DB::table('price')->join('product','product.product_id','=','price.price_ref')->where('price_ref',$request->input('product'))->where('price_qty',$request->input('qty'))->get();
		return Response::json(['result' => $promotion,'count' => count($promotion)]);
	}
	
	public function kerryimport(Request $request){
		ini_set('max_execution_time', 3000); //300 seconds = 5 minutes
		
		$fileupload 	= '';
		if($request->hasFile('uploadfile')){
			$files 			= $request->file('uploadfile');
			$filename 		= $files->getClientOriginalName();
			$extension 		= $files->getClientOriginalExtension();
			$size			= $files->getSize();
			$fileupload 	.= date('YmdHis').'.'.$extension;
			$destinationPath = base_path()."/assets/file/";
			$files->move($destinationPath, $fileupload);
		}
		
		$path = base_path()."/assets/file/".$fileupload;
		$data = Excel::load($path, function($reader){})->get();
		
		if(!empty($data) && $data->count()){
			foreach($data as $key => $value){
				if(!empty($value->consignment_no)){
					$data = [
						'booking_no'				=> !empty($value->booking_no)?$value->booking_no:'',
						'consignment_no'			=> !empty($value->consignment_no)?$value->consignment_no:'',
						'ref_no'					=> !empty($value->ref_no)?$value->ref_no:'',
						'payerid'					=> !empty($value->payerid)?$value->payerid:'',
						'recipient_name'			=> !empty($value->recipient_name)?$value->recipient_name:'',
						'recipient_address1'		=> !empty($value->recipient_address1)?$value->recipient_address1:'',
						'recipient_address2'		=> !empty($value->recipient_address2)?$value->recipient_address2:'',
						'recipient_zipcode'			=> !empty($value->recipient_zipcode)?$value->recipient_zipcode:'',
						'recipient_telephone'		=> !empty($value->recipient_telephone)?$value->recipient_telephone:'',
						'recipient_fax'				=> !empty($value->recipient_fax)?$value->recipient_fax:'',
						'recipient_contact_person'	=> !empty($value->recipient_contact_person)?$value->recipient_contact_person:'',
						'service_code'				=> !empty($value->service_code)?$value->service_code:'',
						'declare_value'				=> !empty($value->declare_value)?$value->declare_value:0,
						'remark'					=> !empty($value->remark)?$value->remark:'',
						'cod_amount'				=> !empty($value->cod_amount)?$value->cod_amount:0,
						'return_pod_hc'				=> !empty($value->return_pod_hc)?$value->return_pod_hc:'',
						'return_invoice_hc'			=> !empty($value->return_invoice_hc)?$value->return_invoice_hc:'',
						'Box'						=> !empty($value->Box)?$value->Box:0,
						'typestatus'				=> 1,
						'status'					=> 1,
						'created_at'				=> new DateTime(),
						'updated_at'				=> new DateTime(),
					];
					DB::table('delivery')->insert($data);
				}
			}
		} 
		
		$exp = DB::table('export')->where('export_status',2)->get();
		if($exp){
			foreach($exp as $rs){
				$rescount = DB::table('delivery')->where('consignment_no',$rs->export_inv)->where('status',1)->count();
				if($rescount != 0){
					$res = DB::table('delivery')->where('consignment_no',$rs->export_inv)->where('status',1)->first();
					DB::table('delivery')->where('id',$res->id)->update(['status' => 0,'updated_at' => new DateTime()]);
					DB::table('export')->where('export_id',$rs->export_id)->update(['export_status' => 3,'updated_at' => new DateTime()]);
				}
			}
		}
		
		Session::flash('alert-insert','insert');
		return redirect('export');
	}
	
	public function dhl_create(Request $request){
		$start 			= explode('/',$request->input('datestart'));
		$strstart 		= $start[2]."-".$start[1]."-".$start[0];
		$end 			= explode('/',$request->input('dateend'));
		$strend 		= $end[2]."-".$end[1]."-".$end[0];
		
		$export = DB::table('export')->whereIn('export_status',[0,1,2,3,4])->whereBetween('export_date',[$strstart,$strend])->get();
		// $product_name = [];
		// foreach($export as $key => $rs){
				
			
		// }

		// dd($product_name);
		// exit();
		$file = storage_path('template/DHL.xlsx');
		
		Excel::load($file, function($doc) use($export) {
		$sheet = $doc->setActiveSheetIndex(0);
		$row = 2;
	
		$i 		= 1; 
		$total 	= 0; 
		if(count($export) > 0){
			foreach($export as  $key => $rs){
				
				$status = '';
				$total	= '';
				if($rs->export_status == 4){
					$status = 'Y';
					$total 	= $rs->export_totalpayment;
				}
				// $orders = DB::table('orders')->leftjoin('product','product.product_id','=','orders.order_productid')->where('order_ref',$rs->export_id)->get();
				// if(count($orders->toArray()) != 0 ){
				// 	foreach($orders as $key2 => $value){
				// 		$product_name[$key][$key2] = $value->product_name;
				// 	}
				// }else{
				// 	$product_name[$key][0] = "";
				// }
				
				// $im_plode = implode($product_name[$key],',');

				// if($rs->export_customerzipcode == ""){
				// 	$zipcode = mb_substr($rs->export_customeraddrdel, -5 ,5,"UTF-8");
				// }else{
				// 	$zipcode = $rs->export_customerzipcode;
				// }

				$str_cut = preg_replace("/[^0-9]/", "",$rs->export_customertel);
				$str_re = substr_replace($str_cut, '-', 3, 0);


				$sheet->setCellValue('A'.$row.'','5265524044');
				$sheet->setCellValue('C'.$row.'',$rs->export_inv);
				$sheet->setCellValue('D'.$row.'','PDO');
				$sheet->setCellValue('F'.$row.'',$rs->export_customername);
				$sheet->setCellValue('G'.$row.'',$rs->export_customeraddrdel);
				$sheet->setCellValue('H'.$row.'','');
				$sheet->setCellValue('I'.$row.'','');
				$sheet->setCellValue('J'.$row.'',$rs->export_distric);
				$sheet->setCellValue('K'.$row.'',$rs->export_province);
				// $sheet->setCellValue('L'.$row.'',preg_replace("/[^0-9]/", "",$zipcode) );
				$sheet->setCellValue('L'.$row.'',$rs->export_customerzipcode);
				$sheet->setCellValue('M'.$row.'','TH');
				$sheet->setCellValue('N'.$row.'',$str_re);
				$sheet->setCellValue('P'.$row.'',100);
				$sheet->setCellValue('T'.$row.'','THB');
				$sheet->setCellValue('X'.$row.'',$status);
				$sheet->setCellValue('Y'.$row.'',$total);
				
				$i++;
				$row++;
			}
		}
			
		})->download('xlsx');
	}
	
	public function multiprint(Request $request){
		if($request->input('status') == 1){
			$pdf = PDF::loadView('export.invoicemulti',['data' => $request->input('idrow')],[],['title' => 'สลิป','format'=>'A4']);
			return $pdf->stream();
		}else{
			$pdf = PDF::loadView('export.covermulti',['data' => $request->input('idrow')],[],['title' => 'สลิป','format'=>'A4-L']);
			return $pdf->stream();
		}
	}
	
	public function customerref(Request $request){
		$refcus = DB::table('shipping')->where('shipping_ref',$request->input('id'))->get();
		$data	= [];
		if($refcus){
			foreach($refcus as $rs){
				$str 		= explode(' ',$rs->shipping_addr);
				$zipcode 	= '';
				if($str){
					foreach($str as $ar){
						if(is_numeric($ar) && strlen($ar) == 5){
							$zipcode = $ar;
						}
					}
				}
				$data[] = [
					'shipping_name'		=> $rs->shipping_name,
					'shipping_tax'		=> $rs->shipping_tax,
					'shipping_addr'		=> $rs->shipping_addr,
					'shipping_tel'		=> $rs->shipping_tel,
					'zipcode'			=> $zipcode,
					'shipping_note'		=> $rs->shipping_note,
				];
			}
		}
		return Response::json(['result' => $data,'count' => count($refcus)]);
	}
	
	public function queryorder(Request $request){
		$export 	= DB::table('export')->where('export_id',$request->input('exportid'))->first();
		$orders 	= DB::table('orders')
		->join('product','product.product_id','=','orders.order_productid')
		->where('order_ref',$request->input('exportid'))
		->get();
		return Response::json(['export' => $export,'orders' => $orders]);
	}
}
