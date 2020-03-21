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

class SupplierController extends Controller
{
    public function index(){
		return view('supplier/index');
	}
	
	public function datatable(){
		$customer = DB::table('customer')->where('customer_status',1);
		$sQuery	= Datatables::of($customer)
		->editColumn('updated_at',function($data){
			return date('d/m/Y',strtotime($data->updated_at));
		});
		return $sQuery->escapeColumns([])->make(true);
	} 
	
	public function create(){
		return view('supplier/create');
	}
	
	public function store(Request $request){
		$data = [
			'customer_img'			=> '',
			'customer_code'			=> '',
			'customer_name'			=> $request->input('name'),
			'customer_nameEN'		=> '',
			'customer_detail'		=> !empty($request->input('address'))?$request->input('address'):'',
			'customer_detailhome'	=> !empty($request->input('addresshome'))?$request->input('addresshome'):'',
			'customer_detaildoc'	=> !empty($request->input('addressdoc'))?$request->input('addressdoc'):'',
			'customer_tel'			=> !empty($request->input('tel'))?$request->input('tel'):'',
			'customer_email'		=> !empty($request->input('email'))?$request->input('email'):'',
			'customer_birth'		=> '',
			'customer_note'			=> !empty($request->input('note'))?$request->input('note'):'',
			'customer_point'		=> 0,
			'customer_vat'			=> !empty($request->input('tax'))?$request->input('tax'):'',
			'customer_fax'			=> !empty($request->input('fax'))?$request->input('fax'):'',
			'customer_credit'		=> !empty($request->input('credit'))?$request->input('credit'):'',
			'customer_status'		=> 1,
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

		if($request->has('subbranch')){
			$subname = $request->input('subbranch');
			foreach($subname as $key => $rs){
				if(!empty($rs)){
					$subbranch 	= $request->input('subbranch')[$key];
					$subaddress 	= $request->input('subaddress')[$key];
					$data = [
						'sa_cus_id'		=> $lastid->customer_id,
						'sa_branch'		=> $subbranch,
						'sa_address'	=> $subaddress,
						'created_at'	=> new DateTime(),
						'updated_at'	=> new DateTime(),
					];
					DB::table('sub_address')->insert($data);
				}
			}
		}

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
		
		Session::flash('alert-insert','insert');
		return redirect('supplier');
	}
	
	public function edit($id){
		$customer 	= DB::table('customer')->where('customer_id',$id)->first();
		$contact	= DB::table('sub_customer')->where('sub_refid',$id)->get();
		$address	= DB::table('sub_address')->where('sa_cus_id',$id)->get();
		return view('supplier/update',['customer' => $customer,'contact' => $contact,'address' => $address]);
	}
	
	public function supconupdate(Request $request){
		$contact = DB::table('sub_customer')->where('sub_id',$request->input('id'))->update(['sub_name' => $request->input('name'),'sub_tel' => $request->input('tel'),'updated_at' => new DateTime()]);
		return Response::json(1);
	}
	
	public function supcondelete(Request $request){
		DB::table('sub_customer')->where('sub_id',$request->input('id'))->delete();
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
		
		$data = [
			'customer_name'			=> $request->input('name'),
			'customer_nameEN'		=> '',
			'customer_detail'		=> !empty($request->input('address'))?$request->input('address'):'',
			'customer_detailhome'	=> !empty($request->input('addresshome'))?$request->input('addresshome'):'',
			'customer_detaildoc'	=> !empty($request->input('addressdoc'))?$request->input('addressdoc'):'',
			'customer_tel'			=> $request->input('tel'),
			'customer_email'		=> $request->input('email'),
			'customer_note'			=> !empty($request->input('note'))?$request->input('note'):'',
			'customer_vat'			=> !empty($request->input('tax'))?$request->input('tax'):'',
			'customer_fax'			=> !empty($request->input('fax'))?$request->input('fax'):'',
			'customer_credit'		=> !empty($request->input('credit'))?$request->input('credit'):'',
			'updated_at'			=> new DateTime(),
		];
		DB::table('customer')->where('customer_id',$request->input('updateid'))->update($data);
	
		if($request->has('subbranch')){
			$subname = $request->input('subbranch');
			foreach($subname as $key => $rs){
				if(!empty($rs)){
					$subbranch 	= $request->input('subbranch')[$key];
					$subaddress 	= $request->input('subaddress')[$key];
					$data = [
						'sa_cus_id'		=> $request->input('updateid'),
						'sa_branch'		=> $subbranch,
						'sa_address'	=> $subaddress,
						'created_at'	=> new DateTime(),
						'updated_at'	=> new DateTime(),
					];
					DB::table('sub_address')->insert($data);
				}
			}
		}

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
		
		Session::flash('alert-update','update');
		return redirect('supplier');
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
		return redirect('supplier');
	}
	
	public function numberphone(){
		Excel::create('Export data', function($excel){
			$excel->sheet('Sheet 1', function($sheet){
				$customer =  DB::table('customer')->groupBy('customer_tel')->get();
				$data = [];
				if($customer){
					foreach($customer as $rs){
						if(!empty($rs->customer_tel)){
							$data[] = [
								'tel'		=> str_replace(str_split('- \\/:*?"<>|.()'),'',$rs->customer_tel),
							];
						}
					}
				}
				$sheet->fromArray($data);
			});
		})->export('xlsx');
	}
	
	public function import(){
		ini_set('max_execution_time', 3000); //300 seconds = 5 minutes
		 $path = storage_path('customer2.xlsx');
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
			}
		dd('success');
	}
}
