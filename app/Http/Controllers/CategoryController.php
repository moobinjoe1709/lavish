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

class CategoryController extends Controller
{
	//Category
    public function category(){
		$category = DB::table('category')->get();
		return view('category/index',['category' => $category]);
	}
	
	public function cate_store(Request $req){
		$data = [
			'category_name'		=> $req->input('categoryname'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		
		DB::table('category')->insert($data);
		Session::flash('alert-insert','insert');
		return redirect('category');
	}
	
	public function cate_edit(Request $req){
		$res = DB::table('category')->where('category_id',$req->input('id'))->first();
		return Response::json($res);
	}
	
	public function cate_update(Request $req){
		$data = [
			'category_name'		=> $req->input('categorynameup'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('category')->where('category_id',$req->input('updateid'))->update($data);
		Session::flash('alert-update','update');
		return redirect('category');
	}
	
	public function cate_destroy($id){
		DB::table('category')->where('category_id',$id)->delete();
		Session::flash('alert-delete','delete');
		return redirect('category');
	}
	
	//Grade
	public function grade(){
		$grade = DB::table('grade')->get();
		return view('grade/index',['grade' => $grade]);
	}
	
	public function grade_store(Request $req){
		$data = [
			'grade_name'		=> $req->input('gradename'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('grade')->insert($data);
		Session::flash('alert-insert','insert');
		return redirect('grade');
	}
	
	public function grade_update(Request $req){
		$data = [
			'grade_name'		=> $req->input('gradenameup'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('grade')->where('grade_id',$req->input('updateid'))->update($data);
		Session::flash('alert-update','update');
		return redirect('grade');
	}
	
	public function grade_edit(Request $req){
		$res = DB::table('grade')->where('grade_id',$req->input('id'))->first();
		return Response::json($res);
	}
	
	public function grade_destroy($id){
		DB::table('grade')->where('grade_id',$id)->delete();
		Session::flash('alert-delete','delete');
		return redirect('grade');
	}
	
	//Size
	public function size(){
		$size = DB::table('size')->get();
		return view('size/index',['size' => $size]);
	}
	
	public function size_store(Request $req){
		$data = [
			'size_name'			=> $req->input('sizename'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('size')->insert($data);
		Session::flash('alert-insert','insert');
		return redirect('size');
	}
	
	public function size_update(Request $req){
		$data = [
			'size_name'			=> $req->input('sizenameup'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('size')->where('size_id',$req->input('updateid'))->update($data);
		Session::flash('alert-update','update');
		return redirect('size');
	}
	
	public function size_edit(Request $req){
		$res = DB::table('size')->where('size_id',$req->input('id'))->first();
		return Response::json($res);
	}
	
	public function size_destroy($id){
		DB::table('size')->where('size_id',$id)->delete();
		Session::flash('alert-delete','delete');
		return redirect('size');
	}
	
	//Color
	public function color(){
		$color = DB::table('color')->get();
		return view('color/index',['color' => $color]);
	}
	
	public function color_store(Request $req){
		$data = [
			'color_name'			=> $req->input('colorname'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('color')->insert($data);
		Session::flash('alert-insert','insert');
		return redirect('color');
	}
	
	public function color_update(Request $req){
		$data = [
			'color_name'		=> $req->input('colornameup'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('color')->where('color_id',$req->input('updateid'))->update($data);
		Session::flash('alert-update','update');
		return redirect('color');
	}
	
	public function color_edit(Request $req){
		$res = DB::table('color')->where('color_id',$req->input('id'))->first();
		return Response::json($res);
	}
	
	public function color_destroy($id){
		DB::table('color')->where('color_id',$id)->delete();
		Session::flash('alert-delete','delete');
		return redirect('color');
	}
}
