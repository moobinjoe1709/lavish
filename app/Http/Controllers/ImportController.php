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
use App\supplier;
use App\product;
use App\imports;
use App\subimports;
use App\processingunit;
use App\stock;
use Excel;

class ImportController extends Controller
{
    public function index(){
		return view('import/index');
	}
    
    public function datatable(){
		$import = DB::table('import')
		->select('import.import_id','import.import_inv','import.import_ref','import.import_date','import.import_emp','import.import_suppliername','import.updated_at','users.id','users.name')
		->join('users','users.id','=','import.import_emp')
		->orderBy('import_id','desc');
		
		$sQuery	= Datatables::of($import)
		->editColumn('updated_at',function($data){
			return date('d/m/Y',strtotime($data->updated_at));
		})
		->editColumn('import_date',function($data){
			return date('d/m/Y',strtotime($data->import_date));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function create(){
		return view('import/create');
	}
    
    public function store(Request $request){

		$resinv = DB::table('import')->orderBy('import_id','desc')->first();
		// dd($request);
		if(!empty($resinv)){
			$str = $resinv->import_inv;
			$sub = substr($str,6,3)+1;
			$cut = substr($str,0,6);
			$inv = $cut.sprintf("%03d",$sub);
		}else{
			dd(2);
			$dateY = date('Y');
			$dateM = date('m');
			$dateD = date('d');
			$cutdate = substr($dateY,2,2);
			$strdate = $cutdate.$dateM.$dateD.sprintf("%03d",1);
			$inv = $strdate;
		}
		$create_date = date("Y/m/d");
		// $date = explode('/',$request->input('docdate'));
		$date 		= explode('/',$create_date);
		$dateimp 	= explode('/',$request->input('docdateimp'));
		
		/* if($request->check_address != null){
			$sub_address = DB::table('sub_address')->where('sa_id','=',$request->sub_address)->first();	
			if($sub_address){
				$supplier_address = $sub_address->sa_address;
				$import_cus = $sub_address->sa_cus_id;
			}else{
				$supplier_address = $request->input('supplier_address');
			}
		
		}else{
			$supplier_address 	= $request->input('supplier_address');
			$import_cus 		= $request->input('check_address');
		} */
		$data = [
			'import_ref'			=> $request->input('impno'),
			'import_inv'			=> $inv,
			'import_date'			=> $date[2].'-'.$date[1].'-'.$date[0],
			'import_dateimport'		=> $dateimp[2].'-'.$dateimp[1].'-'.$dateimp[0],
			'import_emp'			=> $request->input('empsaleid'),
			'import_supplierid'		=> $request->input('supplier_id'),
			'import_suppliername'	=> $request->input('suppliername'),
			'import_suppliername'	=> $request->input('suppliername'),
			'import_suppliertax'	=> $request->input('supplier_tax'),
			'import_supplieraddr'	=> $request->input('supplier_address'),
			'import_suppliertel'	=> $request->input('supplier_tel'),
			'import_total'			=> $request->input('sumtotal'),
			'import_vat'			=> $request->input('vat'),
			'import_vatsum'			=> $request->input('sumvat'),
			'import_totalpayment'	=> $request->input('sumpayment'),
			'import_note'			=> $request->input('note'),
			'import_status'			=> 1,
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		DB::table('import')->insert($data);
		$lastid = DB::table('import')->latest()->first();	
		
		if($request->input('productid')){
			foreach($request->input('productid') as $key => $rs){
				if(!empty($rs)){
					$datasub = [
						'sub_ref'			=> $lastid->import_id,
						'sub_product'		=> $rs,
						'sub_qty'			=> $request->input('qty')[$key],
						'sub_price'			=> $request->input('price')[$key],
						'sub_total'			=> $request->input('total')[$key],
						'created_at'		=> new DateTime(),
						'updated_at'		=> new DateTime(),
					];
					
					DB::table('sub_import')->insert($datasub);
					
					$resproduct = DB::table('product')->where('product_id',$rs)->first();
					if($resproduct){
						$sumqty = $resproduct->product_qty + $request->input('qty')[$key];
						DB::table('product')->where('product_id',$rs)->update(['product_qty' => $sumqty,'updated_at' => new DateTime()]);
					}
				}
			}
		}
		
        Session::flash('alert-insert','insert');
		return redirect('import');
    }
	
	public function edit($id){
		$import 	= DB::table('import')->where('import_id',$id)->first();
		$customer 	= DB::table('customer')->where('customer_id',$import->import_cus)->first();
		$sub		= DB::table('sub_import')->where('sub_ref',$id)
		->join('product','product.product_id','=','sub_import.sub_product')
		->get();
		return view('import/update',['import' => $import,'sub' => $sub,'customer' => $customer]);
	}
	
	public function update(Request $request){
		if($request->check_address != null){
			$sub_address = DB::table('sub_address')->where('sa_id','=',$request->sub_address)->first();	
			if($sub_address){
				$supplier_address = $sub_address->sa_address;
			}else{
				$supplier_address = $request->input('supplier_address');
			}
		
		}else{
			$supplier_address = $request->input('supplier_address');
		}


		$sub		= DB::table('sub_import')->where('sub_ref',$request->input('updateid'))
		->join('product','product.product_id','=','sub_import.sub_product')
		->get();
		
		if($sub){
			foreach($sub as $rs){
				$sum = $rs->product_qty - $rs->sub_qty;
				DB::table('product')->where('product_id',$rs->product_id)->update(['product_qty' => $sum,'updated_at' => new DateTime()]);
			}
		}
		DB::table('sub_import')->where('sub_ref',$request->input('updateid'))->delete();
		
		
	
		$date = explode('/',$request->input('docdate'));
		$dateimp 	= explode('/',$request->input('docdateimp'));
		$data = [
			'import_ref'			=> $request->input('impno'),
			'import_date'			=> $date[2].'-'.$date[1].'-'.$date[0],
			'import_dateimport'		=> $dateimp[2].'-'.$dateimp[1].'-'.$dateimp[0],
			'import_emp'			=> $request->input('empsaleid'),
			'import_suppliername'	=> $request->input('suppliername'),
			'import_suppliertax'	=> $request->input('supplier_tax'),
			'import_supplieraddr'	=> $supplier_address,
			'import_suppliertel'	=> $request->input('supplier_tel'),
			'import_total'			=> $request->input('sumtotal'),
			'import_vat'			=> $request->input('vat'),
			'import_vatsum'			=> $request->input('sumvat'),
			'import_totalpayment'	=> $request->input('sumpayment'),
			'import_note'			=> $request->input('note'),
			'updated_at'			=> new DateTime(),
		];
		DB::table('import')->where('import_id',$request->input('updateid'))->update($data);
		
		if($request->input('productid')){
			foreach($request->input('productid') as $key => $rs){
				if(!empty($rs)){
					$datasub = [
						'sub_ref'			=> $request->input('updateid'),
						'sub_product'		=> $rs,
						'sub_qty'			=> $request->input('qty')[$key],
						'sub_price'			=> $request->input('price')[$key],
						'sub_total'			=> $request->input('total')[$key],
						'created_at'		=> new DateTime(),
						'updated_at'		=> new DateTime(),
					];
					DB::table('sub_import')->insert($datasub);
					
					$resproduct = DB::table('product')->where('product_id',$rs)->first();
					if($resproduct){
						$sumqty = $resproduct->product_qty + $request->input('qty')[$key];
						DB::table('product')->where('product_id',$rs)->update(['product_qty' => $sumqty,'updated_at' => new DateTime()]);
					}
				}
			}
		}
		
		Session::flash('alert-update','update');
		return redirect('import');
	}
	
	public function destroy($id){
		DB::table('import')->where('import_id',$id)->delete();
		$res = DB::table('sub_import')->where('sub_ref',$id)->get();
		if($res){
			foreach($res as $rs){
				$product 	= DB::table('product')->where('product_id',$rs->sub_product)->first();
				$sum		= $product->product_qty - $rs->sub_qty;
				DB::table('product')->where('product_id',$rs->sub_product)->update(['product_qty' => $sum,'updated_at' => new DateTime()]);
			}
		}
		
		DB::table('sub_import')->where('sub_ref',$id)->delete();
		return redirect('import');
	}
	

	public function search_suplier($id){
		// echo $id;
		$customer = DB::table('customer')->where('customer_name',$id)->first();
		return response()->json($customer) ;
	}

	public function search_address($id){
		// echo $id;
		$sub_address = DB::table('sub_address')->where('sa_cus_id',$id)->get();
		return response()->json($sub_address) ;
	}

	
}
