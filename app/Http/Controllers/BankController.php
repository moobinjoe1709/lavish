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

class BankController extends Controller
{
	//Category
    public function index(){
		$bank = DB::table('bank')->get();
		return view('bank/index',['bank' => $bank]);
	}
	
	public function bankselect(Request $req){
		$bank = DB::table('bank')->get();
		return Response::json($bank);
	}
	
	public function store(Request $req){
		$data = [
			'name'				=> $req->input('name'),
			'title'				=> $req->input('title'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		
		DB::table('bank')->insert($data);
		Session::flash('alert-insert','insert');
		return redirect('bank');
	}
	
	public function edit(Request $req){
		$res = DB::table('bank')->where('id',$req->input('id'))->first();
		return Response::json($res);
	}
	
	public function update(Request $req){
		$data = [
			'name'				=> $req->input('nameup'),
			'title'				=> $req->input('titleup'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('bank')->where('id',$req->input('updateid'))->update($data);
		Session::flash('alert-update','update');
		return redirect('bank');
	}
	
	public function destroy($id){
		DB::table('bank')->where('id',$id)->delete();
		Session::flash('alert-delete','delete');
		return redirect('bank');
	}
}
