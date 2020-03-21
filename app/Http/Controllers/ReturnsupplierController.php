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
use mPDF;
use Auth;

class ReturnsupplierController extends Controller
{
    public function index(){
		return view('return-supplier/index');
	}
	
	public function create(){
		return view('return-supplier/create');
	}
	
	public function datatable(){
		$export = DB::table('export')->Leftjoin('customer','customer.customer_id','=','export.export_customerid')->where('export_status',7);
		
		$sQuery	= Datatables::of($export)
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
	
	public function returnbarcode(Request $request){ 
		$product 	= DB::table('product')->where('product_code',$request->input('barcode'))->first();
		$results[] = [
			'id'			=>$product->product_id,
			'productid'		=>$product->product_id,
			'code'			=>$product->product_code,
			'name'			=>$product->product_name,
			'price'			=>$product->product_price,
			'unit'			=>$product->product_unit,
		];
		
		return Response::json($results);
	}
	
	public function store(Request $request){
		$dateY	 	= date('Y')+543;
		$dateM 		= date('m');
		$dateD 		= date('d');
		$cutdate 	= substr($dateY,2,2);
		$strdate 	= 'LVRTC'.$cutdate.$dateM.$dateD;
		$invoice	= DB::table('export')->where('export_inv','like',$strdate."%")->orderBy('export_id','desc')->first();
		
		if(!empty($invoice)){
			$str = $invoice->export_inv;
			$sub = substr($str,11,3)+1;
			$cut = substr($str,0,11);
			$inv = $cut.sprintf("%03d",$sub);
		}else{
			$dateY = date('Y')+543;
			$dateM = date('m');
			$dateD = date('d');
			$cutdate = substr($dateY,2,2);
			$strdate = 'LVRTC'.$cutdate.$dateM.$dateD.sprintf("%03d",1);
			$inv = $strdate;
		}
		
		$data = [
			'export_order'			=> '',
			'export_inv'			=> $inv,
			'export_ref'			=> $request->input('docref'),
			'export_date'			=> date('Y-m-d'),
			'export_empid'			=> Auth::user()->id,
			'export_empname'		=> Auth::user()->name,
			'export_customerid'		=> $request->input('customerid'),
			'export_customername'	=> !empty($request->input('customername'))?$request->input('customername'):'ลูกค้าเงินสด',
			'export_customertax'	=> '',
			'export_customeraddr'	=> '',
			'export_customeraddrdel'=> '',
			'export_customerzipcode'=> '',
			'export_customertel'	=> '',
			'export_customernote'	=> '',
			'export_total'			=> !empty($request->input('sumtotal'))?$request->input('sumtotal'):0,
			'export_discount'		=> '0',
			'export_discountsum'	=> 0,
			'export_lastbill'		=> 0,
			'export_vat'			=> 0,
			'export_vatsum'			=> 0,
			'export_lastbill'		=> 0,
			'export_totalpayment'	=> !empty($request->input('sumtotal'))?$request->input('sumtotal'):0,
			'export_status'			=> 7,
			'export_delstatus'		=> 0,
			'export_comment'		=> !empty($request->input('note'))?$request->input('note'):'',
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		DB::table('export')->insert($data);
		$lastid = DB::table('export')->latest()->first();	
		
		if($request->input('productid')){
			foreach($request->input('productid') as $key => $row){
				//สินค้า
				$product = DB::table('product')->where('product_id',$request->input('productid')[$key])->first();
				
				$unitsum			= $product->product_qty - $request->input('qty')[$key];			
				//Update stock
				DB::table('product')->where('product_id',$product->product_id)->update(['product_qty' => $unitsum,'updated_at' => new DateTime()]);
				
				$detail = array(
					'order_ref'				=>$lastid->export_id,
					'order_productid'		=>$request->input('productid')[$key],
					'order_price'			=>$request->input('price')[$key],
					'order_qty'				=>$request->input('qty')[$key],
					'order_total'			=>$request->input('total')[$key],
					'order_status'			=>7,
					'created_at'			=>new DateTime(),
					'updated_at'			=>new DateTime()
				);
				
				DB::table('orders')->insert($detail);
			}
		}
		Session::flash('alert-insert',$lastid->export_id);
		return redirect('return/supplier');				
	}
	
	public function returnsupplierinv(Request $request){
		$import = DB::table('import')->where('import_inv',$request->input('inv'))->first();
		$orders = DB::table('sub_import')->join('product','product.product_id','=','sub_import.sub_product')->where('sub_ref',$import->import_id)->get();
		return Response::json(['import' => $import,'orders' => $orders]);
	}
	
	public function return_destroy($id){
		$res = DB::table('orders')->join('product','product_id','=','orders.order_productid')->where('orders.order_ref',$id)->get();
		if($res){
			foreach($res as $rs){
				$sum = $rs->product_qty + $rs->order_qty;
				DB::table('product')->where('product_id',$rs->product_id)->update(['product_qty' => $sum,'updated_at' => new DateTime()]);
			}
		}
		DB::table('export')->where('export_id',$id)->delete();
		DB::table('orders')->where('order_ref',$id)->delete();
		Session::flash('alert-delete','delete');
		return redirect('return');	
	}
}
