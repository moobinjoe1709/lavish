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
use Auth;

class ProductController extends Controller
{
    public function index(){
		return view('product/index');
	}
	
	public function sortable(Request $request){
		DB::table('product')->where('product_sortable',$request->input('sortable'))->update(['product_sortable' => $request->input('sortable')+1,'updated_at' => new DateTime()]);
		DB::table('product')->where('product_code',$request->input('code'))->update(['product_sortable' => $request->input('sortable'),'updated_at' => new DateTime()]);
		
		if($request->input('sortable')){  
			$less = DB::table('product')->where('product_sortable','>',$request->input('sortable'))->get();
			if($less){
				$num = $request->input('sortable');
				foreach($less as $key => $rs){
					$num++;
					$data 	= [
						'product_sortable'	=> $num,
						'updated_at' 		=> new DateTime()
					];
					DB::table('product')->where('product_id',$rs->product_id)->update($data);
				}
			}
		}
		
		$zero = DB::table('product')->where('product_sortable',0)->get();
		$last = DB::table('product')->orderBy('product_sortable','desc')->first();
		if($zero){
			$numz = 1;
			foreach($zero as $ar){
				$dataz 	= [
					'product_sortable'	=> $last->product_sortable+$numz,
					'updated_at' 		=> new DateTime()
				];
				DB::table('product')->where('product_id',$ar->product_id)->update($dataz);
				$numz++;
			}
		} 
		
		return Response::json(111);
	}
	
	public function datatable(){
		$product = DB::table('product')->select('product.product_id','product.product_code','product.product_category','product.product_name','product.product_qty','product.product_price','product.updated_at','product.product_sortable','category.category_id','category.category_name')->leftjoin('category','product.product_category','=','category.category_id')->orderBy('product.product_sortable','asc');
		$sQuery	= Datatables::of($product)
		->addIndexColumn()
		->editColumn('product_category',function($data){
			return $data->product_category == 0 ?'-': $data->category_name;
		})
		->editColumn('product_price',function($data){
			return empty($data->product_price)?'-':number_format($data->product_price,2);
		})
		->editColumn('updated_at',function($data){
			return date('d/m/Y',strtotime($data->updated_at));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function create(){
		$category = DB::table('category')->get();
		return view('product/create',['category' => $category]);
	}
	
	public function store(Request $request){
		$pricebuy = str_replace(',', '', $request->input('productbuy'));
		$data = [
			'product_category'	=> $request->input('category'),
			'product_code'		=> $request->input('productcode'),
			'product_name'		=> $request->input('productname'),
			'product_unit'		=> $request->input('productunit'),
			'product_price'		=> 0,
			'product_qty'		=> 0,
			'product_buy'		=> $pricebuy,
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('product')->insert($data);
		
		$logs = [
			'logs_method' 	=> 'Insert',
			'logs_list' 	=> $request->input('productcode').' '.Auth::user()->name.' '.$request->input('productname').' '.$request->input('productunit'),
			'logs_detail' 	=> '',
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		DB::table('logs')->insert($logs);
		
		$lastid = DB::table('product')->latest()->first();
		if($request->input('price')){
			foreach($request->input('price') as $key => $rs){
				if(!empty($rs)){
					$price = str_replace(',', '', $rs);
					if($key == 0){
						DB::table('product')->where('product_id',$lastid->product_id)->update(['product_price' => $price]);
					}
					
					$arr = [
						'price_ref'			=> $lastid->product_id,
						'price_price'		=> $price,
						'price_qty'			=> !empty($request->input('priceqty')[$key])?$request->input('priceqty')[$key]:0,
						'price_promotion'	=> !empty($request->input('promotion')[$key])?$request->input('promotion')[$key]:'',
						'created_at'		=> new DateTime(),
						'updated_at'		=> new DateTime(),
					];
					DB::table('price')->insert($arr);
				}
			}
		}
		
		Session::flash('alert-insert','insert');
		return redirect('product');
	}
	
	public function edit($id){
		$category = DB::table('category')->get();
		$product = DB::table('product')->where('product_id',$id)->first();
		$price = DB::table('price')->where('price_ref',$id)->get();
		return view('product/update',['category' => $category,'data' => $product,'sub' => $price]);
	}
	
	public function update(Request $request){
		$res = DB::table('product')->where('product_id',$request->input('updateid'))->first();
		$logs = [
			'logs_method' 	=> 'Update',
			'logs_list' 	=> $res->product_code.' '.$res->product_name.' '.$res->product_unit,
			'logs_detail' 	=> $request->input('productcode').' '.Auth::user()->name.' '.$request->input('productname').' '.$request->input('productunit'),
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		DB::table('logs')->insert($logs);
		
		$pricebuy = str_replace(',', '', $request->input('productbuy'));
		$data = [
			'product_category'	=> $request->input('category'),
			'product_code'		=> $request->input('productcode'),
			'product_name'		=> $request->input('productname'),
			'product_unit'		=> $request->input('productunit'),
			'product_buy'		=> $pricebuy,
			'updated_at'		=> new DateTime(),
		];
		DB::table('product')->where('product_id',$request->input('updateid'))->update($data);
		
		if($request->input('priceupid')){
			foreach($request->input('priceupid') as $k => $ar){
				if(!empty($ar)){
					$price = str_replace(',', '', $request->input('priceup')[$k]);
					$arz = [
						'price_ref'			=> $request->input('updateid'),
						'price_price'		=> $price,
						'price_qty'			=> !empty($request->input('priceupqty')[$k])?$request->input('priceupqty')[$k]:0,
						'price_promotion'	=> !empty($request->input('promotionup')[$k])?$request->input('promotionup')[$k]:'',
						'created_at'		=> new DateTime(),
						'updated_at'		=> new DateTime(),
					];
					DB::table('price')->where('price_id',$ar)->update($arz);
				}
			}
		}
		
		if($request->input('price')){
			foreach($request->input('price') as $key => $rs){
				if(!empty($rs)){
					$price = str_replace(',', '', $rs);
					$arr = [
						'price_ref'			=> $request->input('updateid'),
						'price_price'		=> $price,
						'price_qty'			=> !empty($request->input('priceqty')[$key])?$request->input('priceqty')[$key]:0,
						'price_promotion'	=> !empty($request->input('promotion')[$key])?$request->input('promotion')[$key]:'',
						'created_at'		=> new DateTime(),
						'updated_at'		=> new DateTime(),
					];
					DB::table('price')->insert($arr);
				}
			}
		}
		
		Session::flash('alert-update','update');
		return redirect('product');
	}
	
	public function delpricepro(Request $request){
		DB::table('price')->where('price_id',$request->input('id'))->delete();
		return Response::json(11);
	}
	
	public function import(Request $request){
		$lastdata = DB::table('import')->orderBy('import_id','desc')->first();
        if(!empty($lastdata)){
            $cut 	= substr($lastdata->import_inv,3,7);
            $ordno 	= 'IMP'.sprintf("%07d",$cut);
        }else{
            $ordno 	= 'IMP'.sprintf("%07d",1);
        }
		
		$data = [
			'import_inv'		=> $ordno,
			'import_date'		=> date('Y-m-d'),
			'import_emp'		=> Auth::user()->id,
			'import_status'		=> 1,
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		
		DB::table('import')->insert($data);
		$lastid = DB::table('import')->latest()->first();
		
		$sub = [
			'sub_ref'		=> $lastid->import_id,
			'sub_product'	=> $request->input('proid'),
			'sub_qty'		=> $request->input('qty'),
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		DB::table('sub_import')->insert($sub);
		$product 	= DB::table('product')->where('product_id',$request->input('proid'))->first();
		$sumqty 	= $product->product_qty + $request->input('qty');
		DB::table('product')->where('product_id',$request->input('proid'))->update(['product_qty' => $sumqty,'updated_at'	=> new DateTime()]);
		
		Session::flash('alert-update','update');
		return redirect('product');
	}
	
	public function productimportdata(Request $request){
		$product = DB::table('sub_import')->select('sub_import.sub_id','sub_import.sub_ref','sub_import.sub_product','sub_import.sub_qty','sub_import.created_at','import.import_inv','import.import_date','product.product_id','product.product_name')->join('import','import.import_id','=','sub_import.sub_ref')->join('product','product.product_id','=','sub_import.sub_product')->where('sub_product',$request->input('id'))->get();
		$sQuery	= Datatables::of($product)
		->editColumn('sub_qty',function($data){
			return number_format($data->sub_qty);
		})
		->editColumn('import_date',function($data){
			return date('d/m/Y',strtotime($data->import_date));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function productsaledata(Request $request){
		$product = DB::table('orders')->select('orders.order_id','orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','export.export_id','export.export_inv','export.export_date','product.product_id','product.product_name')->join('export','export.export_id','=','orders.order_ref')->join('product','product.product_id','=','orders.order_productid')->where('order_productid',$request->input('id'))->get();
		
		$sQuery	= Datatables::of($product)
		->editColumn('order_qty',function($data){
			return number_format($data->order_qty);
		})
		->editColumn('order_price',function($data){
			return number_format($data->order_price,2);
		})
		->editColumn('order_total',function($data){
			return number_format($data->order_total,2);
		})
		->editColumn('export_date',function($data){
			return date('d/m/Y',strtotime($data->export_date));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function destroy($id){
		$res = DB::table('product')->where('product_id',$id)->first();
		$logs = [
			'logs_method' 	=> 'Delete',
			'logs_list' 	=> $res->product_code.' '.Auth::user()->name.' '.$res->product_name.' '.$res->product_unit,
			'logs_detail' 	=> '',
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		DB::table('logs')->insert($logs);
		
		DB::table('product')->where('product_id',$id)->delete();
		DB::table('price')->where('price_ref',$id)->delete();
		Session::flash('alert-delete','delete');
		return redirect('product');
	}
}
