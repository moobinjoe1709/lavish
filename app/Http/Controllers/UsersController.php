<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use Hash;
use Auth;
use Excel;
class UsersController extends Controller
{
    public function index(){
		return view('users/index');
	}
	
	public function logs(){
		return view('logs/index');
	}
	
	public function create(){
		return view('users/create');
	}
	
	public function datatable(){
		$users 		= DB::table('users'); 
		$sQuery		= Datatables::of($users)
		->editColumn('created_at',function($data){
			return date('d/m/Y H:i',strtotime($data->created_at));
		})
		->editColumn('updated_at',function($data){
			return date('d/m/Y H:i',strtotime($data->updated_at));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function logsdatatables(){
		$logs 		= DB::table('logs'); 
		$sQuery		= Datatables::of($logs)
		->editColumn('created_at',function($data){
			return date('d/m/Y H:i',strtotime($data->created_at));
		})
		->editColumn('updated_at',function($data){
			return date('d/m/Y H:i',strtotime($data->updated_at));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function store(Request $request){
		$data = [
			'name'				=> $request->input('name'),
			'email'				=> $request->input('email'),
			'status'			=> $request->input('status'),
			'phone'				=> $request->input('tel'),
			'password'			=> Hash::make($request->input('password')),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('users')->insert($data);
		
		$logs = [
			'logs_method' 	=> 'Insert',
			'logs_list' 	=> $request->input('name').' '.Auth::user()->name.' '.$request->input('email').' '.$request->input('tel'),
			'logs_detail' 	=> '',
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		DB::table('logs')->insert($logs);
		
		Session::flash('alert-insert','insert');
		return redirect('users');
	}
	
	public function edit($id){
		$users = DB::table('users')->where('id',$id)->first();
		return view('users/update',['users' => $users]);
	}
	
	public function update(Request $request){
		$res = DB::table('users')->where('id',$request->input('updateid'))->first();
		$logs = [
			'logs_method' 	=> 'Update',
			'logs_list' 	=> $res->name.' '.$res->email.' '.$res->phone,
			'logs_detail' 	=> $request->input('name').' '.Auth::user()->name.' '.$request->input('email').' '.$request->input('tel'),
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		DB::table('logs')->insert($logs);
		
		if(!empty($request->input('password'))){
			$data = [
				'name'				=> $request->input('name'),
				'email'				=> $request->input('email'),
				'status'			=> $request->input('status'),
				'phone'				=> $request->input('tel'),
				'password'			=> Hash::make($request->input('password')),
				'updated_at'		=> new DateTime(),
			];
		}else{
			$data = [
				'name'				=> $request->input('name'),
				'email'				=> $request->input('email'),
				'status'			=> $request->input('status'),
				'phone'				=> $request->input('tel'),
				'updated_at'		=> new DateTime(),
			];
		}
		
		DB::table('users')->where('id',$request->input('updateid'))->update($data);
		Session::flash('alert-update','update');
		return redirect('users');
	}
	
	public function destroy($id){
		$res = DB::table('users')->where('id',$id)->first();
		$logs = [
			'logs_method' 	=> 'Delete',
			'logs_list' 	=> $res->name.' '.Auth::user()->name.' '.$res->email.' '.$res->phone,
			'logs_detail' 	=> '',
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		DB::table('logs')->insert($logs);
		
		DB::table('users')->where('id',$id)->delete();
		Session::flash('alert-delete','delete');
		return redirect('users');
	}

	public function exportdata(){
		Excel::create('Export User Data', function($excel){
			$excel->sheet('Sheet 1', function($sheet){
				$users =  DB::table('users')->get();
				$data = [];
				if($users){
					foreach($users as $rs){
							$data[] = [
								'name'				=> $rs->name,
								'email'				=> $rs->email,
								'tel'				=> str_replace(str_split('- \\/:*?"<>|.()'),'',$rs->phone),
							];
					}
				}
				$sheet->fromArray($data);
			});
		})->export('xlsx');
	}
}
