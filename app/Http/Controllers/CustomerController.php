<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use Excel;
use File;
use Auth;
use Folklore\Image\Facades\Image;

class CustomerController extends Controller
{
    public function index(){
		return view('customer/index');
	}
	
	public function checkcodecust(Request $request){
		$count = DB::table('customer')->where('customer_code',$request->input('code'))->count();
		return Response::json($count);
	}
	
	public function datatable(){
		$customer = DB::table('customer');
		$sQuery	= Datatables::of($customer)
		->editColumn('customer_point',function($data){
			return number_format($data->customer_point);
		})
		->editColumn('updated_at',function($data){
			return date('d/m/Y',strtotime($data->updated_at));
		});
		return $sQuery->escapeColumns([])->make(true);
	} 
	
	public function customersaledata(Request $request){
		$export = DB::table('orders')->select('orders.order_id','orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','export.export_id','export.export_inv','export.export_date','export.export_customerid','export.export_status','product.product_id','product.product_name',DB::raw('sum(orders.order_qty) as TOTALQTY'),DB::raw('sum(orders.order_total) as TOTAL'))
		->join('export','export.export_id','=','orders.order_ref')
		->join('product','product.product_id','=','orders.order_productid')
		->whereIn('export.export_status',[0,1,2])
		->where('export.export_customerid',$request->input('id'))
		->groupBy('orders.order_productid','orders.order_price');
		
		$sQuery	= Datatables::of($export)
		->addIndexColumn()
		->editColumn('order_qty',function($data){
			return number_format($data->order_qty);
		})
		->editColumn('TOTALQTY',function($data){
			return number_format($data->TOTALQTY);
		})
		->editColumn('TOTAL',function($data){
			return number_format($data->TOTAL);
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
	
	public function customerreturndata(Request $request){
		$export = DB::table('orders')->select('orders.order_id','orders.order_ref','orders.order_productid','orders.order_price','orders.order_qty','orders.order_total','export.export_id','export.export_inv','export.export_date','export.export_customerid','export.export_status','product.product_id','product.product_name',DB::raw('sum(orders.order_qty) as TOTALQTY'),DB::raw('sum(orders.order_total) as TOTAL'))
		->join('export','export.export_id','=','orders.order_ref')
		->join('product','product.product_id','=','orders.order_productid')
		->where('export.export_status',5)
		->where('export.export_customerid',$request->input('id'))
		->groupBy('orders.order_productid','orders.order_price');
		
		$sQuery	= Datatables::of($export)
		->addIndexColumn()
		->editColumn('order_qty',function($data){
			return number_format($data->order_qty);
		})
		->editColumn('TOTALQTY',function($data){
			return number_format($data->TOTALQTY);
		})
		->editColumn('TOTAL',function($data){
			return number_format($data->TOTAL);
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
	
	public function create(){
		return view('customer/create');
	}
	
	public function store(Request $request){
		$imgcover 	= '';
		if($request->hasFile('uploadcover')){
			$files 			= $request->file('uploadcover');
			$filename 		= $files->getClientOriginalName();
			$extension 		= $files->getClientOriginalExtension();
			$size			= $files->getSize();
			$imgcover 		.= date('His').$filename;
			$destinationPath = base_path()."/assets/images/customer/";
			$files->move($destinationPath, $imgcover);
			
		}
		
		$data = [
			'customer_img'			=> $imgcover,
			'customer_code'			=> $request->input('code'),
			'customer_name'			=> $request->input('name'),
			'customer_nameEN'		=> !empty($request->input('nameen'))?$request->input('nameen'):'',
			'customer_detail'		=> !empty($request->input('address'))?$request->input('address'):'',
			'customer_detailhome'	=> !empty($request->input('addresshome'))?$request->input('addresshome'):'',
			'customer_detaildoc'	=> !empty($request->input('addressdoc'))?$request->input('addressdoc'):'',
			'customer_tel'			=> !empty($request->input('tel'))?$request->input('tel'):'',
			'customer_email'		=> !empty($request->input('email'))?$request->input('email'):'',
			'customer_birth'		=> $request->input('birthyear').'-'.sprintf("%02d",$request->input('birthdmonth')).'-'.sprintf("%02d",$request->input('birthday')),
			'customer_note'			=> !empty($request->input('note'))?$request->input('note'):'',
			'customer_point'		=> 0,
			'customer_status'		=> 0,
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		
		$logs = [
			'logs_method' 	=> 'Insert',
			'logs_list' 	=> '',
			'logs_detail' 	=> $request->input('code').' '.Auth::user()->name.' '.$request->input('name').' '.$request->input('address').' '.$request->input('addressdoc').' '.$request->input('tel').' '.$request->input('email'),
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		
		DB::table('customer')->insert($data);
		DB::table('logs')->insert($logs);
		
		$lastid = DB::table('customer')->latest()->first();
		if($request->has('supconname')){
			$subname = $request->input('supconname');
			foreach($subname as $key => $rs){
				if(!empty($rs)){
					$_subname 	= $request->input('supconname')[$key];
					$_subtel 	= $request->input('subcontel')[$key];
					$datasub = [
						'sub_refid'		=> $lastid->customer_id,
						'sub_name'		=> $_subname,
						'sub_tel'		=> $_subtel,
						'created_at'	=> new DateTime(),
						'updated_at'	=> new DateTime(),
					];
					
					DB::table('sub_customer')->insert($datasub);
				}
			}
		}
		
		if($request->has('othername')){
			foreach($request->input('othername') as $k => $ar){
				if(!empty($ar)){
					$dataother = [
						'shipping_ref'		=> $lastid->customer_id,
						'shipping_name'		=> $ar,
						'shipping_tax'		=> $request->input('othertel')[$k],
						'shipping_addr'		=> $request->input('otheraddr')[$k],
						'shipping_tel'		=> $request->input('othertel')[$k],
						'shipping_note'		=> $request->input('othernote')[$k],
						'created_at'		=> new DateTime(),
						'updated_at'		=> new DateTime(),
					];
					DB::table('shipping')->insert($dataother);
				}
			}
		}
			

		Session::flash('alert-insert','insert');
		return redirect('customer');
	}
	
	public function edit($id){
		$customer 	= DB::table('customer')->where('customer_id',$id)->first();
		$contact	= DB::table('sub_customer')->where('sub_refid',$id)->get();
		$shipping	= DB::table('shipping')->where('shipping_ref',$id)->get();
		return view('customer/update',['customer' => $customer,'contact' => $contact,'shipping' => $shipping]);
	}
	
	public function supconupdate(Request $request){
		$contact = DB::table('sub_customer')->where('sub_id',$request->input('id'))->update(['sub_name' => $request->input('name'),'sub_tel' => $request->input('tel'),'updated_at' => new DateTime()]);
		return Response::json(1);
	}

	public function supaddressupdate(Request $request){
		$contact = DB::table('sub_address')->where('sa_id',$request->input('id'))->update(['sa_branch' => $request->input('branch'),'sa_address' => $request->input('address'),'updated_at' => new DateTime()]);
		return Response::json(1);
	}
	
	public function supcondelete(Request $request){
		DB::table('sub_customer')->where('sub_id',$request->input('id'))->delete();
		return Response::json(1);
	}

	public function addressdelete(Request $request){
		DB::table('sub_address')->where('sa_id',$request->input('id'))->delete();
		return Response::json(1);
	}
	
	public function update(Request $request){
		$res = DB::table('customer')->where('customer_id',$request->input('updateid'))->first();
		$logs = [
			'logs_method' 	=> 'Update',
			'logs_list' 	=> $res->customer_code.' '.$res->customer_name.' '.$res->customer_detail.' '.$res->customer_detaildoc.' '.$res->customer_tel.' '.$res->customer_email,
			'logs_detail' 	=> $request->input('code').' '.Auth::user()->name.' '.$request->input('name').' '.$request->input('address').' '.$request->input('addressdoc').' '.$request->input('tel').' '.$request->input('email'),
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		DB::table('logs')->insert($logs);
		
		$imgcover 	= $res->customer_img;
		if($request->hasFile('uploadcover')){
			$files 			= $request->file('uploadcover');
			$filename 		= $files->getClientOriginalName();
			$extension 		= $files->getClientOriginalExtension();
			$size			= $files->getSize();
			$imgcover 		.= date('His').$filename;
			$destinationPath = base_path()."/assets/images/customer/";
			$files->move($destinationPath, $imgcover);
			
		}
		
		$data = [
			'customer_img'			=> $imgcover,
			'customer_code'			=> $request->input('code'),
			'customer_name'			=> $request->input('name'),
			'customer_nameEN'		=> !empty($request->input('nameen'))?$request->input('nameen'):'',
			'customer_detail'		=> !empty($request->input('address'))?$request->input('address'):'',
			'customer_detailhome'	=> !empty($request->input('addresshome'))?$request->input('addresshome'):'',
			'customer_detaildoc'	=> !empty($request->input('addressdoc'))?$request->input('addressdoc'):'',
			'customer_tel'			=> $request->input('tel'),
			'customer_email'		=> $request->input('email'),
			'customer_point'		=> $request->input('point'),
			'customer_birth'		=> $request->input('birthyear').'-'.sprintf("%02d",$request->input('birthdmonth')).'-'.sprintf("%02d",$request->input('birthday')),
			'customer_note'			=> !empty($request->input('note'))?$request->input('note'):'',
			'updated_at'			=> new DateTime(),
		];
		DB::table('customer')->where('customer_id',$request->input('updateid'))->update($data);
	
		if($request->has('supconname')){
			$subname = $request->input('supconname');
			foreach($subname as $key => $rs){
				if(!empty($rs)){
					$_subname 	= $request->input('supconname')[$key];
					$_subtel 	= $request->input('subcontel')[$key];
					$data = [
						'sub_refid'		=> $request->input('updateid'),
						'sub_name'		=> $_subname,
						'sub_tel'		=> $_subtel,
						'created_at'	=> new DateTime(),
						'updated_at'	=> new DateTime(),
					];
					DB::table('sub_customer')->insert($data);
				}
			}
		}
		
		if($request->has('otheridup')){
			foreach($request->input('otheridup') as $kk => $arr){
				if(!empty($arr)){
					$dataotherup = [
						'shipping_name'		=> $request->input('othernameup')[$kk],
						'shipping_tax'		=> $request->input('othertaxup')[$kk],
						'shipping_addr'		=> $request->input('otheraddrup')[$kk],
						'shipping_tel'		=> $request->input('othertelup')[$kk],
						'shipping_note'		=> $request->input('othernoteup')[$kk],
						'updated_at'		=> new DateTime(),
					];
					DB::table('shipping')->where('shipping_id',$arr)->update($dataotherup);
				}
			}
		}
		
		if($request->has('othername')){
			foreach($request->input('othername') as $k => $ar){
				if(!empty($ar)){
					$dataother = [
						'shipping_ref'		=> $request->input('updateid'),
						'shipping_name'		=> $ar,
						'shipping_tax'		=> $request->input('othertel')[$k],
						'shipping_addr'		=> $request->input('otheraddr')[$k],
						'shipping_tel'		=> $request->input('othertel')[$k],
						'shipping_note'		=> $request->input('othernote')[$k],
						'created_at'		=> new DateTime(),
						'updated_at'		=> new DateTime(),
					];
					DB::table('shipping')->insert($dataother);
				}
			}
		}
		
		Session::flash('alert-update','update');
		return redirect('customer');
	}
	
	
	public function destroy($id){
		$res = DB::table('customer')->where('customer_id',$id)->first();
		$logs = [
			'logs_method' 	=> 'Delete',
			'logs_list' 	=> $res->customer_code.' '.Auth::user()->name.' '.$res->customer_name.' '.$res->customer_detail.' '.$res->customer_tel.' '.$res->customer_email,
			'logs_detail' 	=> '',
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		DB::table('logs')->insert($logs);
		
		DB::table('customer')->where('customer_id',$id)->delete();
		DB::table('sub_customer')->where('sub_refid',$id)->delete();
		
		Session::flash('alert-delete','delete');
		return redirect('customer');
	}
	
	public function numberphone(){
		Excel::create('Export data', function($excel){
			$excel->sheet('Sheet 1', function($sheet){
				$customer =  DB::table('customer')->groupBy('customer_tel')->get();
				$data = [];
				if($customer){
					foreach($customer as $rs){
						if(!empty($rs->customer_tel) && strlen($rs->customer_tel) == 10){
							$data[] = [
								'customer name'		=> $rs->customer_name,
								'tel'				=> str_replace(str_split('- \\/:*?"<>|.()'),'',$rs->customer_tel),
							];
						}
					}
				}
				$sheet->fromArray($data);
			});
		})->export('xlsx');
	}

	public function exportdata(){
		Excel::create('Export Customer Data', function($excel){
			$excel->sheet('Sheet 1', function($sheet){
				$users =  DB::table('customer')->get();
				$data = [];
				if($users){
					foreach($users as $rs){
							$data[] = [
								
								'customer code'				=> $rs->customer_code,
								'customer_name'				=> $rs->customer_name,
								'customer_nameEN'			=> $rs->customer_nameEN,
								'customer_detail'			=> $rs->customer_detail,
								'customer_detailhome'		=> $rs->customer_detailhome,
								'customer_detaildoc'		=> $rs->customer_detaildoc,
								'tel'						=> str_replace(str_split('- \\/:*?"<>|.()'),'',$rs->customer_tel),
								'customer_email'			=> $rs->customer_email,
								'customer_birth'			=> $rs->customer_birth,
								'customer_point'			=> $rs->customer_point,
								'customer_note'				=> $rs->customer_note,
								'customer_fax'				=> str_replace(str_split('- \\/:*?"<>|.()'),'',$rs->customer_fax),
								'customer_credit'			=> $rs->customer_credit,
							];
					}
				}
				$sheet->fromArray($data);
			});
		})->export('xlsx');
	}
	
	public function import(){
		ini_set('max_execution_time', 3000); //300 seconds = 5 minutes
		/*  $path = storage_path('customer2.xlsx');
		 $data = Excel::load($path, function($reader){})->get();
			if(!empty($data) && $data->count()){
				foreach($data as $key => $value){
					$count = DB::table('customer')->where('customer_name',$value->name)->count();
					if($count > 0){
						$res = DB::table('customer')->where('customer_name',$value->name)->first();
						$sumpoint = $res->customer_point + $value->score;
						
						$data = [
							'customer_point'			=> $sumpoint,
							'updated_at'				=> new DateTime(),
						];
						
						DB::table('customer')->where('customer_id',$res->customer_id)->update($data);
					}else{
						$data = [
							'customer_img'				=> '',
							'customer_name'				=> $value->name,
							'customer_detail'			=> $value->addr,
							'customer_detailhome'		=> '',
							'customer_detaildoc'		=> '',
							'customer_tel'				=> str_replace('-','',$value->tel),
							'customer_email'			=> '',
							'customer_birth'			=> '',
							'customer_point'			=> !empty($value->score)?$value->score:0,
							'customer_note'				=> '',
							'created_at'				=> new DateTime(),
							'updated_at'				=> new DateTime(),
						];
						
						DB::table('customer')->insert($data);
					}
					
				}
			} */
		/* $customer = DB::table('customer')->get();
		if($customer){
			foreach($customer as $rs){
				$strcus = str_replace(str_split('- \\/:*?"<>|.()'),'',$rs->customer_tel);
				DB::table('customer')->where('customer_id',$rs->customer_id)->update(['customer_tel' => $strcus]); 
			}
		} */
		dd('success');
	}
}
