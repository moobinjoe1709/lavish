<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use Excel;
use Auth;

class PaymentController extends Controller
{
    public function index(){
		return view('payment/index');
	}
	
	public function trandatatables(Request $request){
		$transec = DB::table('transaction');
		
		$sQuery	= Datatables::of($transec)
		->editColumn('tran_amount',function($data){
			return empty($data->tran_amount)?'-':number_format($data->tran_amount,2);
		})
		->editColumn('tran_date',function($data){
			return date('d/m/Y H:i:s',strtotime($data->tran_date));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function trandataquery(Request $request){
		$transec = DB::table('transaction')->where('tran_status','!=',0);
		
		$sQuery	= Datatables::of($transec)
		->editColumn('tran_amount',function($data){
			return empty($data->tran_amount)?'-':number_format($data->tran_amount,2);
		})
		->editColumn('tran_date',function($data){
			return date('d/m/Y H:i:s',strtotime($data->tran_date));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function exportdatatables(Request $request){
		$export = DB::table('export');
		
		$sQuery	= Datatables::of($export)
		->editColumn('export_totalpayment',function($data){
			return empty($data->export_totalpayment)?'-':number_format($data->export_totalpayment,2);
		})
		->editColumn('export_date',function($data){
			return date('d/m/Y',strtotime($data->export_date));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function store(Request $request){
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
		
		if($request->input('typetransec') == 1){
			if(!empty($data) && $data->count()){
				foreach($data as $key => $value){
					if(!empty($value->date)){
						$data = [
							'tran_date'			=> $value->date,
							'tran_type'			=> !empty($value->transaction_type)?$value->transaction_type:'',
							'tran_amount'		=> !empty($value->deposit)?$value->deposit:0,
							'tran_status'		=> $request->input('typetransec'),
							'tran_note'			=> !empty($value->note)?$value->note:'',
							'created_at'		=> new DateTime(),
							'updated_at'		=> new DateTime(),
						];
						DB::table('transaction')->insert($data);
					}
				}
			}
		}else{
			if(!empty($data) && $data->count()){
				foreach($data as $key => $value){
					if(!empty($value->order_number)){

						if(!empty($value->amount)){
							$amount = str_replace(',', '', $value->amount);
						}else{
							$amount = 0;
						}
						
						$datestr = '';
						if(!empty($value->transaction_time)){
							$date 		= explode('|',$value->transaction_time);
							$datestr 	= date('Y-m-d',strtotime($date[0])).' '.$date[1];
						}
						
						$data = [
							'tran_qwikreference'	=> $value->qwik_reference,
							'tran_ordernumber'		=> $value->order_number,
							'tran_date'				=> $datestr,
							'tran_type'				=> !empty($value->source_of_fund)?$value->source_of_fund:'',
							'tran_buyername'		=> !empty($value->buyer_name)?$value->buyer_name:'',
							'tran_buyeremail'		=> !empty($value->buyer_email)?$value->buyer_email:'',
							'tran_statuscredit'		=> !empty($value->status)?$value->status:'',
							'tran_pageid'			=> !empty($value->page_id)?$value->page_id:'',
							'tran_amount'			=> !empty($amount)?$amount:0,
							'tran_status'			=> $request->input('typetransec'),
							'tran_note'				=> !empty($value->note)?$value->note:'',
							'created_at'			=> new DateTime(),
							'updated_at'			=> new DateTime(),
						];
						DB::table('transaction')->insert($data);
					}
				}
			}
		}
		
		
		Session::flash('alert-insert','insert');
		return redirect('payment');
	}
	
	public function connectpayment(Request $request){
		$res = DB::table('export')->where('export_id',$request->input('exportid'))->first();
		$logs = [
			'logs_method' 	=> 'Update',
			'logs_list' 	=> $res->export_inv.' '.Auth::user()->name.' '.$res->export_customername.' '.$res->export_totalpayment.'  ค้างจ่าย',
			'logs_detail' 	=> 'จ่ายแล้ว',
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		];
		DB::table('logs')->insert($logs);
		
		DB::table('export')->where('export_id',$request->input('exportid'))->update(['export_status' => 1,'updated_at' => new DateTime()]);
		DB::table('transaction')->where('tran_id',$request->input('paymentid'))->update(['tran_status' => 0,'updated_at' => new DateTime()]);
		return Response::json(111);
	}
	
	public function masterplatformpayment(){
		$file = storage_path('template/statement.xlsx');
		Excel::load($file, function($doc){})->download('xlsx');
	}
	
	public function masterplatformcredit(){
		$file = storage_path('template/credit.xls');
		Excel::load($file, function($doc){})->download('xlsx');
	}
	
	public function masterplatformkerry(){
		$file = storage_path('template/kerry.xlsx');
		Excel::load($file, function($doc){})->download('xlsx');
	}
	
	public function masterplatformdhl(){
		$file = storage_path('template/DHL.xlsx');
		Excel::load($file, function($doc){})->download('xlsx');
	}
}
